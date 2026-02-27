<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use App\Models\AccountingSubCategory;
use App\Models\ChartAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class ChartofAccountController extends Controller
{
    public function index()
    {
        $categories = AccountingCategory::all();
        $subcategories = AccountingSubCategory::all();
        $sample = 'samp';
        return view(
        'general-settings.accounting.chart-of-accounts.index',
        compact('categories', 'subcategories', 'sample')
    );
    }

    public function fetchItems(Request $request)
    {
        $charts = ChartAccount::with(['category', 'subcategory'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
            ->orderByDesc('created_at')
            ->paginate($request->per_page ?? 10);

        // Load active categories with their subcategories
        $categories = AccountingCategory::all();

        // Flatten subcategories just in case you need a global list
        $subcategories = AccountingSubCategory::all();

        return response()->json([
            'charts' => $charts,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

public function create()
    {
        return response()->json([
            'categories' => \App\Models\AccountingCategory::with('subCategories')->active()->get(),
            'classifications' => [
                ['id' => 'credit', 'name' => 'Credit'],
                ['id' => 'debit', 'name' => 'Debit']
            ],
        ]);
    }

    /**
     * Store a new chart account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'accounting_category_id'    => 'required|exists:accounting_categories,id',
            'accounting_subcategory_id' => 'nullable|exists:accounting_sub_categories,id',
            'code'                      => 'required|string|max:20|unique:chart_accounts,code',
            'name'                      => 'required|string|max:255',
            // Ensure your Vue 'selectedClassification' sends 'credit' or 'debit'
            'classification'            => ['required', \Illuminate\Validation\Rule::in(['credit', 'debit'])],
            'tax_mapping'               => 'nullable|string|max:255',
        ]);

        // Manually merge the extra fields
        $chart = ChartAccount::create(array_merge($validated, [
            'created_by' => Auth::id(),
            'status'     => 'active',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Chart account created successfully.',
            'data'    => $chart,
        ]);
    }

    /**
     * Show chart account for edit
     */
    public function edit($id)
    {
        $chart = ChartAccount::findOrFail($id);

        return response()->json([
            'chart' => $chart,
            'categories' => \App\Models\AccountingCategory::with('subCategories')->active()->get(),
            'classifications' => [
                ['id' => 'credit', 'name' => 'Credit'],
                ['id' => 'debit', 'name' => 'Debit']
            ],
        ]);
    }

    /**
     * Update an existing chart account
     */
    public function update(Request $request, $id)
    {
        $chart = ChartAccount::findOrFail($id);

        $validated = $request->validate([
            'accounting_category_id' => 'required|exists:accounting_categories,id',
            'accounting_subcategory_id' => 'nullable|exists:accounting_sub_categories,id',
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('chart_accounts', 'code')->ignore($chart->id),
            ],
            'name' => 'required|string|max:255',
            'classification' => ['required', Rule::in(['credit','debit'])],
            'tax_mapping' => 'nullable|string|max:255',
        ]);

        $chart->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Chart account updated successfully.',
            'data' => $chart,
        ]);
    }

    public function archive($id)
    {
        $chart = ChartAccount::findOrFail($id);

        $chart->status = 'inactive';
        $chart->save();

        return response()->json([
            'success' => true,
            'message' => 'Chart account archived successfully.'
        ]);
    }

    public function restore($id)
    {
        $chart = ChartAccount::findOrFail($id);

        $chart->status = 'active';
        $chart->save();

        return response()->json([
            'success' => true,
            'message' => 'Chart account restored successfully.'
        ]);
    }

    public function destroy($id)
    {
        $chart = ChartAccount::findOrFail($id);

        $chart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Chart account deleted permanently.'
        ]);
    }

}
