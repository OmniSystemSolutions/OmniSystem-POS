<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use Illuminate\Http\Request;

class AccountingCategoryController extends Controller
{
    public function index()
    {
        // Category rows only (type is null) — both modes
        $categoryPayableOptions = AccountingCategory::where('mode', 'payable')
            ->whereNull('type_payable')
            ->where('status', 'active')
            ->get();

        $categoryReceivableOptions = AccountingCategory::where('mode', 'receivable')
            ->whereNull('type_receivable')
            ->where('status', 'active')
            ->get();

        // Type rows grouped by category name — both modes
        $typesByCategoryPayable = AccountingCategory::where('mode', 'payable')
            ->whereNotNull('type_payable')
            ->where('status', 'active')
            ->select('id', 'category_payable', 'type_payable', 'account_code_payable')
            ->get()
            ->groupBy('category_payable');

        $typesByCategoryReceivable = AccountingCategory::where('mode', 'receivable')
            ->whereNotNull('type_receivable')
            ->where('status', 'active')
            ->select('id', 'category_receivable', 'type_receivable', 'account_code_receivable')
            ->get()
            ->groupBy('category_receivable');

        return view('accounting-categories.index', compact(
            'categoryPayableOptions',
            'categoryReceivableOptions',
            'typesByCategoryPayable',
            'typesByCategoryReceivable'
        ));
    }

    // -------------------------------------------------------------------------
    // ADD CATEGORY
    // -------------------------------------------------------------------------

    public function addPayable(Request $request)
    {
        $request->validate([
            'category_payable' => 'required|string|max:255',
            'account_code'     => 'required|string|max:50|unique:accounting_categories,account_code_payable',
        ]);

        // Duplicate category name check
        $exists = AccountingCategory::where('mode', 'payable')
            ->whereNull('type_payable')
            ->whereRaw('LOWER(category_payable) = ?', [strtolower($request->category_payable)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Category name already exists.'
            ], 422);
        }

        $category = AccountingCategory::create([
            'mode'                 => 'payable',
            'category_payable'     => $request->category_payable,
            'account_code_payable' => $request->account_code,
            'type_payable'         => null,
            'status'               => 'active',
            'created_by'           => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $category->id,
                'name'         => $category->category_payable,
                'account_code' => $category->account_code_payable,
                'label'        => $category->category_label,
            ]
        ]);
    }

    public function addReceivable(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'account_code' => 'required|string|max:50|unique:accounting_categories,account_code_receivable',
        ]);

        $exists = AccountingCategory::where('mode', 'receivable')
            ->whereNull('type_receivable')
            ->whereRaw('LOWER(category_receivable) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Category name already exists.'
            ], 422);
        }

        $category = AccountingCategory::create([
            'mode'                    => 'receivable',
            'category_receivable'     => $request->name,
            'account_code_receivable' => $request->account_code,
            'type_receivable'         => null,
            'status'                  => 'active',
            'created_by'              => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $category->id,
                'name'         => $category->category_receivable,
                'account_code' => $category->account_code_receivable,
                'label'        => $category->category_label,
            ]
        ]);
    }

    // -------------------------------------------------------------------------
    // ADD TYPE (SUB CATEGORY)
    // -------------------------------------------------------------------------

    public function addTypePayable(Request $request)
    {
        $request->validate([
            'category'     => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'account_code' => 'required|string|max:50|unique:accounting_categories,account_code_payable',
        ]);

        // Duplicate type name within same category
        $exists = AccountingCategory::where('mode', 'payable')
            ->where('category_payable', $request->category)
            ->whereNotNull('type_payable')
            ->whereRaw('LOWER(type_payable) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sub category already exists under this category.'
            ], 422);
        }

        $type = AccountingCategory::create([
            'mode'                 => 'payable',
            'category_payable'     => $request->category,
            'account_code_payable' => $request->account_code,
            'type_payable'         => $request->name,
            'category_receivable'  => null,
            'type_receivable'      => null,
            'status'               => 'active',
            'created_by'           => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $type->id,
                'name'         => $type->type_payable,
                'account_code' => $type->account_code_payable,
                'label'        => $type->type_label,
            ]
        ]);
    }

    public function addTypeReceivable(Request $request)
    {
        $request->validate([
            'category'     => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'account_code' => 'required|string|max:50|unique:accounting_categories,account_code_receivable',
        ]);

        $exists = AccountingCategory::where('mode', 'receivable')
            ->where('category_receivable', $request->category)
            ->whereNotNull('type_receivable')
            ->whereRaw('LOWER(type_receivable) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sub category already exists under this category.'
            ], 422);
        }

        $type = AccountingCategory::create([
            'mode'                    => 'receivable',
            'category_receivable'     => $request->category,
            'account_code_receivable' => $request->account_code,
            'type_receivable'         => $request->name,
            'category_payable'        => null,
            'type_payable'            => null,
            'status'                  => 'active',
            'created_by'              => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $type->id,
                'name'         => $type->type_receivable,
                'account_code' => $type->account_code_receivable,
                'label'        => $type->type_label,
            ]
        ]);
    }

    // -------------------------------------------------------------------------
    // DELETE
    // -------------------------------------------------------------------------

    public function destroy($id)
    {
        $category = AccountingCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        if ($category->mode === 'receivable') {
            AccountingCategory::where('category_receivable', $category->category_receivable)->delete();
        } else {
            AccountingCategory::where('category_payable', $category->category_payable)->delete();
        }

        return response()->json(['success' => true]);
    }

    public function destroyType($id)
    {
        $type = AccountingCategory::findOrFail($id);

        if ($type->type_payable || $type->type_receivable) {
            $type->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Not a sub category record'], 400);
    }

    // -------------------------------------------------------------------------
    // ARCHIVE / RESTORE
    // -------------------------------------------------------------------------

    public function archive(AccountingCategory $accountingCategory)
    {
        $accountingCategory->update(['status' => 'archived']);
        return redirect()->route('accounting-categories.index');
    }

    public function restore(AccountingCategory $accountingCategory)
    {
        $accountingCategory->update(['status' => 'active']);
        return redirect()->route('accounting-categories.index');
    }
}