<?php

namespace App\Http\Controllers;

use App\Models\AccountingCategory;
use App\Models\AccountingSubCategory;
use App\Models\ChartAccount;
use Illuminate\Http\Request;

class ChartofAccountController extends Controller
{
    public function index()
    {
       $categories = AccountingCategory::all();
       $subcategories = AccountingSubCategory::all();

        return view('general-settings.accounting.chart-of-accounts.index', compact('categories', 'subcategories'));
    }

    public function fetchItems(Request $request)
{
    $charts = ChartAccount::when($request->status, function ($q) use ($request) {
                        $q->where('status', $request->status);
                    })
                    ->when($request->search, function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orderByDesc('created_at')
                    ->paginate($request->per_page ?? 10);

    return response()->json($charts);
}

}
