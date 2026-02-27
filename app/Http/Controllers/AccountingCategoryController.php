<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use App\Models\AccountingSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountingCategoryController extends Controller
{
    public function index()
    {
        $categoryOptions = AccountingCategory::with('activeSubCategories')
            ->where('status', 'active')
            ->get();

        return view('accounting-categories.index', compact('categoryOptions'));
    }

    // -------------------------------------------------------------------------
    // ADD CATEGORY
    // -------------------------------------------------------------------------

    public function addCategory(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'account_code' => 'required|string|max:50|unique:accounting_categories,account_code',
        ]);

        $exists = AccountingCategory::whereRaw('LOWER(category) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Category name already exists.'
            ], 422);
        }

        $category = AccountingCategory::create([
            'category'     => $request->name,
            'account_code' => $request->account_code,
            'status'       => 'active',
            'created_by'   => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $category->id,
                'name'         => $category->category,
                'account_code' => $category->account_code,
                'label'        => $category->category_label,
            ]
        ]);
    }

    // -------------------------------------------------------------------------
    // ADD SUB CATEGORY
    // -------------------------------------------------------------------------

    public function addSubCategory(Request $request)
    {
        $request->validate([
            'accounting_category_id' => 'required|exists:accounting_categories,id',
            'name'                   => 'required|string|max:255',
            'account_code'           => 'required|string|max:50', // ← removed unique rule
        ]);

        // Duplicate check: same name AND same account_code within same parent category only
        $exists = AccountingSubCategory::where('accounting_category_id', $request->accounting_category_id)
            ->whereRaw('LOWER(sub_category) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sub category already exists under this category.'
            ], 422);
        }

        $sub = AccountingSubCategory::create([
            'accounting_category_id' => $request->accounting_category_id,
            'sub_category'           => $request->name,
            'account_code'           => $request->account_code,
            'status'                 => 'active',
            'created_by'             => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $sub->id,
                'name'         => $sub->sub_category,
                'account_code' => $sub->account_code,
                'label'        => $sub->type_label,
            ]
        ]);
    }
    // -------------------------------------------------------------------------
    // DELETE CATEGORY
    // -------------------------------------------------------------------------

    public function destroy($id)
    {
        $category = AccountingCategory::find($id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
        }

        $inUse = DB::table('account_payable_details')
            ->where('accounting_category_id', $id)
            ->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete. This category is already in use by existing records.'
            ], 422);
        }

        // cascadeOnDelete handles sub categories automatically
        $category->delete();

        return response()->json(['success' => true]);
    }

    // -------------------------------------------------------------------------
    // DELETE SUB CATEGORY
    // -------------------------------------------------------------------------

    public function destroySubCategory($id)
    {
        $sub = AccountingSubCategory::findOrFail($id);

        $inUse = DB::table('account_payable_details')
            ->where('accounting_category_id', $sub->accounting_category_id)
            ->where('type', $sub->sub_category) // adjust column name if different
            ->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete. This sub category is already in use by existing records.'
            ], 422);
        }

        $sub->delete();

        return response()->json(['success' => true]);
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
};