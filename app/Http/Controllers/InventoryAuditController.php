<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\InventoryAudit;
use App\Models\InventoryAuditItem;
use App\Models\Product;
use App\Models\BranchComponent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;

class InventoryAuditController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', null);
        $month = $request->input('month', 'All Months');
        $type = $request->input('type', 'Products');

        $query = InventoryAudit::query();

        // Filter by year
        if ($year && $year !== 'All Years') {
            $query->whereYear('entry_datetime', $year);
        }

        // Filter by month (convert to number)
        if ($month && $month !== 'All Months') {
            $monthNum = date('m', strtotime($month));
            $query->whereMonth('entry_datetime', $monthNum);
        }

        // Filter by type
        if ($type && $type !== 'All') {
            $query->where('type', strtolower($type));
        }

        $audits = $query->with('auditor')
            ->orderBy('entry_datetime', 'desc')
            ->get();



        // Get all years in table (distinct) for dropdown
        $yearOptions = InventoryAudit::selectRaw('DISTINCT YEAR(entry_datetime) as year')
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->map(fn($y) => ['label' => $y, 'value' => $y])
            ->toArray();

        return view('inventory_audit.index', compact('audits', 'year', 'month', 'type', 'yearOptions'));
    }

    public function fetchAudits(Request $request)
    {
        $year = $request->input('year', null);
        $month = $request->input('month', 'All Months');
        $type = $request->input('type', 'Products');

        $query = InventoryAudit::query();

        // Filter by year
        if ($year && $year !== 'All Years') {
            $query->whereYear('entry_datetime', $year);
        }

        // Filter by month
        if ($month && $month !== 'All Months') {
            $monthNum = date('m', strtotime($month));
            $query->whereMonth('entry_datetime', $monthNum);
        }

        // Filter by type
        if ($type && $type !== 'All') {
            $query->where('type', strtolower($type));
        }

        // Filter by status (active/completed/archived)
        $status = $request->input('status', null);
        if ($status && in_array($status, ['active', 'completed', 'archived'])) {
            $query->where('status', $status);
        }

        $audits = $query->with('auditor')
            ->orderBy('entry_datetime', 'desc')
            ->get();

        return response()->json([
            'audits' => $audits
        ]);
    }

    public function fetchItems(Request $request)
    {
        $type = strtolower($request->input('type', 'products'));

        switch ($type) {
            case 'components':
                $items = Component::with(['category:id,name', 'subcategory:id,name'])
                    ->select('id', 'code', 'name', 'status', 'category_id', 'subcategory_id', 'onhand', 'unit_id')
                    ->get();
                break;

            case 'products':
                $items = Product::with(['category:id,name', 'subcategory:id,name'])
                    ->select('id', 'code', 'name', 'status', 'category_id', 'subcategory_id', 'unit_id')
                    ->get();
                break;

            case 'consumables':
            case 'assets':
            default:
                // Just return an empty result for now
                $items = collect();
                break;
        }

        return response()->json(['items' => $items]);
    }




    public function create()
    {
        $users = User::all(['id', 'name']);

        $products = Product::with([
            'category:id,name',
            'subcategory:id,name'
        ])
            ->select('id', 'code', 'name', 'status', 'category_id', 'subcategory_id')
            ->get();



        $mode = 'create';
        $audit = null; // <-- add this

        return view('inventory_audit.form', compact('users', 'products', 'mode', 'audit'));
    }


    public function store(Request $request)
    {
        $type = strtolower($request->input('type'));

        // Validation rules
        $rules = [
            'reference_no' => 'required|string|max:255|unique:inventory_audits,reference_no',
            'audited_by' => 'required|exists:users,id',
            'type' => 'required|in:products,components,consumables,assets',
            'entry_datetime' => 'nullable|date',
            'audit_datetime' => 'nullable|date',
            'remarks' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0',
        ];

        if ($type === 'products') {
            $rules['items.*.product_id'] = 'required|exists:products,id';
        } elseif ($type === 'components') {
            $rules['items.*.component_id'] = 'required|exists:components,id';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($validated, $type) {

            // Create main audit record
            $audit = InventoryAudit::create([
                'reference_no' => $validated['reference_no'],
                'audited_by' => $validated['audited_by'],
                'type' => $validated['type'],
                'entry_datetime' => $validated['entry_datetime'],
                'audit_datetime' => $validated['audit_datetime'],
                'remarks' => $validated['remarks'] ?? null,
            ]);

            // Save items
            foreach ($validated['items'] as $item) {
                // Prefer component onhand when available. Leave null otherwise.
                $prevQuantity = null;
                if (!empty($item['component_id'])) {
                    $comp = Component::find($item['component_id']);
                    $prevQuantity = $comp ? (float) $comp->onhand : null;
                }

                InventoryAuditItem::create([
                    'inventory_audit_id' => $audit->id,
                    'product_id' => $type === 'products' ? $item['product_id'] : null,
                    'component_id' => $type === 'components' ? $item['component_id'] : null,
                    'quantity' => $item['quantity'],
                    'prev_quantity' => $prevQuantity,
                ]);
            }
        });

        return response()->json(['message' => 'Inventory audit successfully recorded.']);
    }


    public function edit($id)
    {
        $audit = InventoryAudit::with('items')->findOrFail($id);
        $users = User::all(['id', 'name']);
        $products = Product::with(['category:id,name', 'subcategory:id,name'])
            ->select('id', 'code', 'name', 'status', 'category_id', 'subcategory_id')
            ->get();
        $mode = 'edit';
        return view('inventory_audit.form', compact('users', 'products', 'audit', 'mode'));
    }

    // Handle update
    public function update(Request $request, $id)
    {
        $audit = InventoryAudit::findOrFail($id);

        // Validate request
        $type = strtolower($request->type);
        $rules = [
            'reference_no' => 'required|string|max:255|unique:inventory_audits,reference_no,' . $audit->id,
            'audited_by' => 'required|exists:users,id',
            'type' => 'required|in:products,components,consumables,assets',
            'entry_datetime' => 'nullable|date',
            'audit_datetime' => 'nullable|date',
            'items' => 'required|array|min:1',
            'items.*.quantity' => 'required|numeric|min:0',
        ];

        if ($type === 'products') {
            $rules['items.*.product_id'] = 'required|exists:products,id';
        } elseif ($type === 'components') {
            $rules['items.*.component_id'] = 'required|exists:components,id';
        }

        $validated = $request->validate($rules);

        DB::transaction(function () use ($audit, $validated, $type) {
            // Update main audit
            $audit->update([
                'reference_no' => $validated['reference_no'],
                'audited_by' => $validated['audited_by'],
                'type' => $validated['type'],
                'entry_datetime' => $validated['entry_datetime'] ?? null,
                'audit_datetime' => $validated['audit_datetime'] ?? null,
            ]);

            // Replace items
            $audit->items()->delete();

            foreach ($validated['items'] as $item) {
                // Prefer component onhand when available. Leave null otherwise.
                $prevQuantity = null;
                if (!empty($item['component_id'])) {
                    $comp = Component::find($item['component_id']);
                    $prevQuantity = $comp ? (float) $comp->onhand : null;
                }

                $audit->items()->create([
                    'product_id' => $type === 'products' ? $item['product_id'] : null,
                    'component_id' => $type === 'components' ? $item['component_id'] : null,
                    'quantity' => $item['quantity'],
                    'prev_quantity' => $prevQuantity,
                ]);
            }
        });

        return response()->json(['message' => 'Audit updated successfully']);
    }

    public function show($id)
    {
        $products = Product::with(['category', 'subcategory'])->get();
        $components = Component::with(['category', 'subcategory'])->get();
        $audit = InventoryAudit::with([
            'items.product.category',
            'items.product.subcategory',
            'items.component.category',
            'items.component.subcategory',
            'auditor',
        ])->findOrFail($id);

        return view('inventory_audit.report', [
            'audit' => $audit,
            'auditId' => $id,
            'products' => $products,
            'components' => $components,
        ]);
    }

    public function destroy($id)
    {
        $audit = InventoryAudit::findOrFail($id);
        $audit->items()->delete();
        $audit->delete();

        return response()->json(['message' => 'Inventory audit deleted successfully.']);
    }
    public function downloadPdf($id)
    {
        $audit = InventoryAudit::with([
            'items.product.category',
            'items.product.subcategory',
            'items.component.category',
            'items.component.subcategory',
            'auditor'
        ])->findOrFail($id);

        // Use a server-rendered Blade view tailored for PDFs
        $pdf = PDF::loadView('inventory_audit.report_pdf', compact('audit'));

        return $pdf->download('audit-report-' . $audit->id . '.pdf');
    }

    /**
     * Apply the audit adjustments to stock cards (components only).
     * Requires username and password to be provided and validated.
     */
    public function apply(Request $request, $id)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 422);
        }

        /*
    |--------------------------------------------------------------------------
    | Load Audit
    |--------------------------------------------------------------------------
    */

        $audit = InventoryAudit::with('items.component')->findOrFail($id);

        DB::transaction(function () use ($audit, $user) {

            foreach ($audit->items as $item) {

                /*
            |--------------------------------------------------------------------------
            | Components only
            |--------------------------------------------------------------------------
            */

                if (!$item->component) {
                    continue;
                }

                /*
            |--------------------------------------------------------------------------
            | Get branch component
            |--------------------------------------------------------------------------
            */

                $branchComponent = BranchComponent::where('component_id', $item->component_id)
                    ->first();

                if (!$branchComponent) {
                    continue;
                }

                /*
            |--------------------------------------------------------------------------
            | Previous stock from branch_components
            |--------------------------------------------------------------------------
            */

                $prev = (float) $branchComponent->onhand;

                /*
            |--------------------------------------------------------------------------
            | Save previous quantity
            |--------------------------------------------------------------------------
            */

                $item->prev_quantity = $prev;

                $item->save();

                /*
            |--------------------------------------------------------------------------
            | Audit quantity
            |--------------------------------------------------------------------------
            */

                $auditQty = (float) $item->quantity;

                /*
            |--------------------------------------------------------------------------
            | Update branch_components onhand
            |--------------------------------------------------------------------------
            */

                $branchComponent->onhand = $auditQty;

                $branchComponent->save();
            }

            /*
        |--------------------------------------------------------------------------
        | Mark audit completed
        |--------------------------------------------------------------------------
        */

            $audit->status = 'completed';

            $audit->save();
        });

        return response()->json([
            'message' => 'Adjustments applied successfully'
        ]);
    }

    /**
     * Move an audit to archived status.
     */
    public function archive(Request $request, $id)
    {
        $audit = InventoryAudit::findOrFail($id);

        if ($audit->status === 'archived') {
            return response()->json(['message' => 'Audit is already archived.'], 422);
        }

        $audit->status = 'archived';
        $audit->save();

        return response()->json(['message' => 'Audit moved to archive.']);
    }

    /**
     * Restore an archived audit back to active (Audit Logs).
     */
    public function restore(Request $request, $id)
    {
        $audit = InventoryAudit::findOrFail($id);

        if ($audit->status !== 'archived') {
            return response()->json(['message' => 'Only archived audits can be restored.'], 422);
        }

        $audit->status = 'active';
        $audit->save();

        return response()->json(['message' => 'Audit restored to active.']);
    }
}
