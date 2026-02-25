<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use Illuminate\Http\Request;

class AccountingCategoryController extends Controller
{
    public function index()
    {
        // Category rows only (type is null)
        $categoryOptions = AccountingCategory::whereNull('type')
            ->where('status', 'active')
            ->get();

        // Type rows grouped by category
        $typesByCategory = AccountingCategory::whereNotNull('type')
            ->where('status', 'active')
            ->select('id', 'category', 'account_code', 'type')
            ->get()
            ->groupBy('category');

        return view('accounting-categories.index', compact(
            'categoryOptions',
            'typesByCategory'
        ));
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

        $exists = AccountingCategory::whereNull('type')
            ->whereRaw('LOWER(category) = ?', [strtolower($request->name)])
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
            'type'         => null,
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
    // ADD TYPE (SUB CATEGORY)
    // -------------------------------------------------------------------------

    public function addType(Request $request)
    {
        $request->validate([
            'category'     => 'required|string|max:255',
            'name'         => 'required|string|max:255',
            'account_code' => 'required|string|max:50|unique:accounting_categories,account_code',
        ]);

        $exists = AccountingCategory::where('category', $request->category)
            ->whereNotNull('type')
            ->whereRaw('LOWER(type) = ?', [strtolower($request->name)])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Sub category already exists under this category.'
            ], 422);
        }

        $type = AccountingCategory::create([
            'category'     => $request->category,
            'account_code' => $request->account_code,
            'type'         => $request->name,
            'status'       => 'active',
            'created_by'   => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'           => $type->id,
                'name'         => $type->type,
                'account_code' => $type->account_code,
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
        return response()->json(['success' => false, 'message' => 'Category not found.'], 404);
    }

    // Get all IDs under this category (the parent row + all its type rows)
    $ids = AccountingCategory::where('category', $category->category)
        ->pluck('id');

    // Check if any are referenced in account_payable_details
    $inUse = \DB::table('account_payable_details')
        ->whereIn('accounting_category_id', $ids)
        ->exists();

    if ($inUse) {
        return response()->json([
            'success' => false,
            'message' => 'Cannot delete. This category is already in use by existing records.'
        ], 422);
    }

    AccountingCategory::where('category', $category->category)->delete();

    return response()->json(['success' => true]);
}

    public function destroyType($id)
    {
        $type = AccountingCategory::findOrFail($id);

        if (!$type->type) {
            return response()->json(['success' => false, 'message' => 'Not a sub category record'], 400);
        }

        $type->delete();

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
}