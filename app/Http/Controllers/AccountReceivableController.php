<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use App\Models\AccountingSubCategory;
use App\Models\AccountsReceivableDetail;
use App\Models\ChartAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AccountsReceivables;
use App\Models\AccountsReceivablesPayment;
use App\Models\CashEquivalent;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AccountReceivableController extends Controller
{
    public function index()
    {
        $minYear = AccountsReceivables::min(DB::raw('YEAR(transaction_datetime)'));
        $maxYear = AccountsReceivables::max(DB::raw('YEAR(transaction_datetime)'));

        $receivables = AccountsReceivables::with('user')->get();

        return view('accounts-receivable.index', [
            'minYear'     => $minYear,
            'maxYear'     => $maxYear,
            'receivables' => $receivables,
        ]);
    }

    public function filter(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page    = $request->input('page', 1);

        $query = AccountsReceivables::with([
            'user',
            'branch',
            'items.chartAccount.category',
            'items.chartAccount.subcategory',
            'approvedBy',
            'completedBy',
            'disapprovedBy',
            'archivedBy',
        ])
        ->whereYear('transaction_datetime', $request->year);

        if ($request->month && $request->month !== 'all') {
            $query->whereMonth('transaction_datetime', $request->month);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $paginated = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data'         => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'from'         => $paginated->firstItem(),
            'to'           => $paginated->lastItem(),
            'per_page'     => $paginated->perPage(),
            'total'        => $paginated->total(),
            'last_page'    => $paginated->lastPage(),
        ]);
    }

    public function create()
    {
        $branch = auth()->user()->branches()->first();

        if (!$branch) {
            abort(403, 'You are not assigned to any branch.');
        }

        $prefix = "AR-{$branch->id}-";

        $lastRecord = AccountsReceivables::where('reference_no', 'LIKE', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(reference_no, ?) AS UNSIGNED) DESC', [strlen($prefix) + 1])
            ->first();

        $nextNumber = $lastRecord
            ? ((int) substr($lastRecord->reference_no, strlen($prefix)) + 1)
            : 1;

        $nextReferenceNo = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return view('accounts-receivable.form', [
            'mode'              => 'create',
            'next_reference_no' => $nextReferenceNo,
            'current_branch_id' => $branch->id,
        ]);
    }

    public function edit($id)
    {
        $receivable = AccountsReceivables::with([
            'items.chartAccount.category',
            'items.chartAccount.subcategory',
        ])->findOrFail($id);

        // Transform items for the form
        $receivable->items = $receivable->items->map(function ($item) {
            $chart = $item->chartAccount;

            return [
                'id'               => $item->id,
                'chart_account_id' => $item->chart_account_id,
                'account_name'     => $chart ? ($chart->code ? "{$chart->code} – {$chart->name}" : $chart->name) : 'Unknown',
                'category'         => $chart?->category?->category ?? 'Unknown',
                'sub_category_name'=> $chart?->subcategory?->sub_category ?? 'Unknown',
                'type_id'          => $item->type_id,
                'description'      => $item->description,
                'quantity'         => $item->qty,
                'unit_price'       => $item->unit_price,
                'tax'              => $item->tax ?? 'NON-VAT',
                'tax_amount'       => $item->tax_amount ?? 0,
                'subtotal'         => $item->sub_total ?? ($item->qty * $item->unit_price),
                'total'            => $item->total_amount ?? 0,
            ];
        });

        return view('accounts-receivable.form', [
            'mode'       => 'edit',
            'receivable' => $receivable,
        ]);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $receivable = AccountsReceivables::findOrFail($id);

            $receivable->update([
                'transaction_datetime' => $request->transaction_datetime,
                'payor_name'           => $request->payor_name,
                'company'              => $request->company ?? null,
                'address'              => $request->address ?? null,
                'mobile_no'            => $request->mobile_no ?? null,
                'email'                => $request->email ?? null,
                'tin'                  => $request->tin ?? null,
                'due_date'             => $request->due_date,
                'sub_total'            => $request->sub_total ?? 0,
                'total_tax'            => $request->total_tax ?? 0,
                'total_amount'         => $request->total_amount ?? 0,
                'status'               => $request->status ?? 'pending',
            ]);

            $receivable->items()->delete();

            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    $receivable->items()->create([
                        'chart_account_id' => $item['chart_account_id'] ?? null,
                        'type_id'          => $item['type_id'] ?? null,
                        'description'      => $item['description'],
                        'qty'              => $item['qty'],
                        'unit_price'       => $item['unit_price'],
                        'tax'              => $item['tax'] ?? 'NON-VAT',
                        'tax_amount'       => $item['tax_amount'] ?? 0,
                        'sub_total'        => $item['sub_total'],
                        'total_amount'     => $item['total_amount'],
                    ]);
                }
            }

            $amountDue = $receivable->items()->sum('total_amount');
            $balance   = $amountDue - ($receivable->total_received ?? 0);

            $receivable->update([
                'amount_due' => $amountDue,
                'balance'    => $balance,
            ]);

            DB::commit();

            return redirect('/accounts-receivable')
                ->with('success', 'Accounts Receivable updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('AR Update Failed: ' . $e->getMessage(), [
                'request' => $request->all(),
                'id'      => $id,
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update record. Please try again.');
        }
    }

    // ─────────────────────────────────────────────
    // API: Account Names from chart_accounts
    // ─────────────────────────────────────────────

    /**
     * GET /api/receivable/account-names
     * Returns all active chart accounts with their category + subcategory info.
     */
public function getAccountNames()
{
    $accounts = ChartAccount::with([
            'category',    // → AccountingCategory  (accounting_category_id)
            'subcategory', // → AccountingSubCategory (accounting_subcategory_id)
        ])
        ->where('status', 'active')
        ->orderBy('code')
        ->get()
        ->map(function ($a) {

            // Build category label: "5000 – COGS" or just "COGS"
            $categoryLabel = '';
            if ($a->category) {
                $categoryLabel = $a->category->account_code
                    ? "{$a->category->account_code} – {$a->category->category}"
                    : $a->category->category;
            }

            // Build sub category label: "88 – Expenses" or just "Expenses"
            $subCategoryLabel = '';
            if ($a->subcategory) {
                $subCategoryLabel = $a->subcategory->account_code
                    ? "{$a->subcategory->account_code} – {$a->subcategory->sub_category}"
                    : $a->subcategory->sub_category;
            }

            return [
                'id'               => $a->id,
                'display_name'     => $a->code ? "{$a->code} – {$a->name}" : $a->name,
                'code'             => $a->code,
                'plain_name'       => $a->name,

                // Category
                'category_id'      => $a->accounting_category_id,
                'category_name'    => $categoryLabel,

                // Sub Category
                'subcategory_id'   => $a->accounting_subcategory_id,
                'subcategory_name' => $subCategoryLabel,
            ];
        });

    return response()->json($accounts);
}

    // ─────────────────────────────────────────────
    // Legacy API (kept for backward compat)
    // ─────────────────────────────────────────────

    public function getCategories()
    {
        $categories = AccountingCategory::where('status', 'active')
            ->orderBy('category')
            ->get()
            ->map(function ($c, $index) {
                return [
                    'id'   => $c->id,
                    'name' => $c->category_label,
                ];
            });

        return response()->json($categories);
    }

    public function getTypes(Request $request)
    {
        $types = AccountingSubCategory::where('accounting_category_id', $request->category_id)
            ->where('status', 'active')
            ->orderBy('sub_category')
            ->get()
            ->map(function ($t) {
                return [
                    'id'   => $t->id,
                    'name' => $t->type_label,
                ];
            });

        return response()->json($types);
    }

    // ─────────────────────────────────────────────
    // STORE
    // ─────────────────────────────────────────────

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_datetime'       => 'required|date',
            'payor_name'                 => 'required|string|max:255',
            'company'                    => 'nullable|string|max:255',
            'address'                    => 'nullable|string',
            'mobile_no'                  => 'nullable|string|max:50',
            'email'                      => 'nullable|email|max:255',
            'tin'                        => 'nullable|string|max:50',
            'due_date'                   => 'required|date',

            'items'                      => 'required|array|min:1',
            'items.*.chart_account_id'   => 'required|exists:chart_accounts,id',
            'items.*.description'        => 'required|string',
            'items.*.qty'                => 'required|integer|min:1',
            'items.*.unit_price'         => 'required|numeric|min:0',
            'items.*.tax'                => 'required|in:Vat,Non-Vat,VAT,NON-VAT,ZERO-RATED',
            'items.*.tax_amount'         => 'nullable|numeric|min:0',

            'sub_total'                  => 'required|numeric|min:0',
            'total_tax'                  => 'required|numeric|min:0',
            'total_amount'               => 'required|numeric|min:0',
        ]);

        $branch = auth()->user()->branches()->first();

        if (!$branch) {
            return response()->json(['message' => 'You are not assigned to any branch.'], 403);
        }

        $prefix = "AR-{$branch->id}-";

        $lastRecord = AccountsReceivables::where('reference_no', 'LIKE', $prefix . '%')
            ->orderByRaw('CAST(SUBSTRING(reference_no, ?) AS UNSIGNED) DESC', [strlen($prefix) + 1])
            ->first();

        $nextNumber  = $lastRecord
            ? ((int) substr($lastRecord->reference_no, strlen($prefix)) + 1)
            : 1;

        $referenceNo = $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        $ar = AccountsReceivables::create([
            'reference_no'         => $referenceNo,
            'branch_id'            => $branch->id,
            'transaction_datetime' => $validated['transaction_datetime'],
            'payor_name'           => $validated['payor_name'],
            'company'              => $validated['company'],
            'address'              => $validated['address'],
            'mobile_no'            => $validated['mobile_no'],
            'email'                => $validated['email'],
            'tin'                  => $validated['tin'],
            'due_date'             => $validated['due_date'],
            'user_id'              => auth()->id(),
            'transaction_type'     => 'Account Receivables',
            'status'               => 'pending',
            'sub_total'            => $validated['sub_total'],
            'total_tax'            => $validated['total_tax'],
            'total_amount'         => $validated['total_amount'],
            'total_received'       => 0,
            'amount_due'           => $validated['total_amount'],
            'balance'              => $validated['total_amount'],
        ]);

        foreach ($validated['items'] as $item) {
            $chartAccount = ChartAccount::find($item['chart_account_id']);

            $ar->items()->create([
                'chart_account_id' => $item['chart_account_id'],
                'type_id'          => $chartAccount?->accounting_subcategory_id ?? null,
                'description'      => $item['description'],
                'qty'              => $item['qty'],
                'unit_price'       => $item['unit_price'],
                'tax'              => strtoupper($item['tax']),        // string column
                'tax_amount'       => $item['tax_amount'] ?? 0,
                'sub_total'        => $item['qty'] * $item['unit_price'],
                'total_amount'     => ($item['qty'] * $item['unit_price']) + ($item['tax_amount'] ?? 0),
                // NOTE: tax_id is left null for new records — it's a legacy column
            ]);
        }

        return response()->json([
            'message'      => 'Accounts Receivable created successfully!',
            'reference_no' => $referenceNo,
            'id'           => $ar->id,
        ], 201);
    }

    // ─────────────────────────────────────────────
    // STATUS
    // ─────────────────────────────────────────────

    public function updateStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,completed,disapproved,archived',
        ]);

        $receivable = AccountsReceivables::findOrFail($id);
        $user       = Auth::user();
        $now        = now();
        $newStatus  = $request->status;

        $allowed = [
            'pending'     => ['approved', 'disapproved', 'completed', 'archived'],
            'approved'    => ['completed', 'disapproved', 'archived'],
            'disapproved' => ['pending', 'archived'],
            'archived'    => ['pending'],
            'completed'   => [],
        ];

        $from = $receivable->status;

        if (!in_array($newStatus, $allowed[$from] ?? [])) {
            return response()->json([
                'message' => "Cannot change status from '{$from}' to '{$newStatus}'",
            ], 400);
        }

        $updateData = ['status' => $newStatus];

        match ($newStatus) {
            'approved'    => [$updateData['approved_by']    = $user->id, $updateData['approved_at']    = $now],
            'completed'   => [$updateData['completed_by']   = $user->id, $updateData['completed_at']   = $now],
            'disapproved' => [$updateData['disapproved_by'] = $user->id, $updateData['disapproved_at'] = $now],
            'archived'    => [$updateData['archived_by']    = $user->id, $updateData['archived_at']    = $now],
            'pending'     => [
                $updateData['approved_by']    = null, $updateData['approved_at']    = null,
                $updateData['completed_by']   = null, $updateData['completed_at']   = null,
                $updateData['disapproved_by'] = null, $updateData['disapproved_at'] = null,
                $updateData['archived_by']    = null, $updateData['archived_at']    = null,
            ],
            default => null,
        };

        $receivable->update($updateData);
        $receivable->load(['approvedBy', 'completedBy', 'disapprovedBy', 'archivedBy']);

        return response()->json([
            'message'    => 'Status updated successfully',
            'receivable' => $receivable,
        ]);
    }

    // ─────────────────────────────────────────────
    // PAYMENT
    // ─────────────────────────────────────────────

    public function receivePaymentOptions(): JsonResponse
    {
        $cashEquivalents = CashEquivalent::where('status', 'active')
            ->orderBy('name')
            ->get()
            ->map(function ($item) {
                $label = $item->name;
                if ($item->account_number) {
                    $label .= ' - ' . $item->account_number;
                }

                return [
                    'id'             => $item->id,
                    'label'          => $label,
                    'name'           => $item->name,
                    'account_number' => $item->account_number,
                    'type'           => $item->type_of_account,
                ];
            });

        $paymentMethods = Payment::where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn ($item) => ['id' => $item->id, 'label' => $item->name]);

        return response()->json([
            'cash_equivalents' => $cashEquivalents,
            'payment_methods'  => $paymentMethods,
        ]);
    }

    public function updatePayment(Request $request, $arId)
    {
        $request->validate([
            'cash_equivalent_id'   => 'nullable|exists:cash_equivalents,id',
            'payment_method_id'    => 'nullable|exists:payments,id',
            'amount'               => 'required|numeric|min:0.01',
            'transaction_datetime' => 'required|date_format:Y-m-d H:i:s',
        ]);

        $ar = AccountsReceivables::findOrFail($arId);

        $payment = AccountsReceivablesPayment::create([
            'account_receivable_id' => $arId,
            'cash_equivalent_id'    => $request->cash_equivalent_id,
            'payment_method_id'     => $request->payment_method_id,
            'amount'                => $request->amount,
            'transaction_datetime'  => $request->transaction_datetime,
        ]);

        $ar->total_received += $request->amount;
        $ar->balance         = $ar->amount_due - $ar->total_received;

        if ($ar->balance <= 0) {
            $ar->status       = 'Completed';
            $ar->completed_at = now();
            $ar->completed_by = auth()->id();
        }

        $ar->save();

        return response()->json([
            'message' => 'Payment successfully recorded.',
            'payment' => $payment,
            'updated_ar' => [
                'total_received' => $ar->total_received,
                'balance'        => $ar->balance,
                'status'         => $ar->status,
            ],
        ]);
    }

    public function updateDueDate(Request $request, $id)
    {
        $request->validate(['due_date' => 'required|date']);

        $ar           = AccountsReceivables::findOrFail($id);
        $ar->due_date = $request->due_date;
        $ar->save();

        return response()->json(['message' => 'Due date updated', 'due_date' => $ar->due_date]);
    }
}