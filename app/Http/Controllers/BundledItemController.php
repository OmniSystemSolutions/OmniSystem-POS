<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Component;
use App\Models\Subcategory;
use App\Models\Unit;
use App\Models\Station;
use App\Models\BranchProduct;
use Illuminate\Support\Facades\DB;

class BundledItemController extends Controller
{
    public function index()
    {
        return view('bundled-items.index');
    }

    public function fetchItems(Request $request)
    {
        $status     = $request->get('status', 'active');
        $perPage    = $request->get('perPage', 10);
        $search     = $request->get('search');
        $category   = $request->get('category');
        $subcategory= $request->get('subcategory');
        $type       = $request->get('type'); // simple | bundle

        $branchId = current_branch_id();

        if ($branchId == 1) {

            $products = Product::with([
                    'category',
                    'subcategory',
                    'unit',
                    'station',
                    'bundledProducts' // 🔥 load bundle children
                ])
                ->where('status', $status)
                ->when($type, fn ($q) =>
                    $q->where('type', $type)
                )
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('products.name', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        )
                        ->orWhereHas('subcategory', fn ($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        );
                    });
                })
                ->when($category, fn ($q) =>
                    $q->where('category_id', $category)
                )
                ->when($subcategory, fn ($q) =>
                    $q->where('subcategory_id', $subcategory)
                )
                ->orderBy('products.created_at', 'desc')
                ->paginate($perPage);

        } else {

            $products = Product::query()
                ->select([
                    'products.*',
                    'bc.quantity',
                    'bc.price',
                    'bc.status as branch_status'
                ])
                ->join('branch_products as bc', 'bc.product_id', '=', 'products.id')
                ->where('bc.branch_id', $branchId)
                ->where('products.status', $status)
                ->with([
                    'category',
                    'subcategory',
                    'unit',
                    'station',
                    'bundledProducts' // 🔥 load bundle children
                ])
                ->when($type, fn ($q) =>
                    $q->where('products.type', $type)
                )
                ->when($search, function ($query, $search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('products.name', 'like', "%{$search}%")
                        ->orWhereHas('category', fn ($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        )
                        ->orWhereHas('subcategory', fn ($q) =>
                            $q->where('name', 'like', "%{$search}%")
                        );
                    });
                })
                ->when($category, fn ($q) =>
                    $q->where('products.category_id', $category)
                )
                ->when($subcategory, fn ($q) =>
                    $q->where('products.subcategory_id', $subcategory)
                )
                ->orderBy('products.created_at', 'desc')
                ->paginate($perPage);
        }

        return response()->json($products);
    }

    public function create()
{
    
    return view('bundled-items.form', [
        'bundle' => null,
        'categories' => Category::all(),
        'subcategories' => Subcategory::all(),
        'stations' => Station::all(),
        'units' => Unit::all(),
        'components' => Component::where('for_sale', true)->get(),
        'products' => Product::where('type', 'simple')->get()
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'code' => 'required|string|unique:products,code',
        'name' => 'required|string',
        'price' => 'required|numeric',
        'quantity'   => 'required|numeric|min:0',
        'unit_id'    => 'required|exists:units,id',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

        // Recipe validation
        'recipes.component_id.*' => 'required|exists:components,id',
        'recipes.quantity.*' => 'required|numeric|min:0.01',

        // Bundle items
        'items' => 'nullable|array',
        'items.*.type' => 'required|in:product,component',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|numeric|min:0.01',
    ]);

    $validated['station_id'] = null;
    $validated['type'] = 'bundle';

    // Handle image upload
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('products', 'public');
    }

    // Create product
    $product = Product::create($validated);

    // Create branch product record
    BranchProduct::create([
        'branch_id'  => current_branch_id(),
        'product_id' => $product->id,
        'type'       => 'bundle',
        'station_id' => null,
        'unit_id'    => $product->unit_id,
        'quantity'   => $product->quantity,
        'price'      => $product->price,
        'status'     => 'active',
    ]);

    // Save recipes
    if ($request->has('recipes')) {
        foreach ($request->recipes['component_id'] as $index => $component_id) {
            $product->recipes()->create([
                'component_id' => $component_id,
                'quantity'     => $request->recipes['quantity'][$index],
            ]);
        }
    }

    // ✅ Save bundle items
    if (!empty($request->items)) {
        foreach ($request->items as $item) {
            // Check if item exists based on type
            $exists = $item['type'] === 'product'
                ? \App\Models\Product::where('id', $item['product_id'])->exists()
                : \App\Models\Component::where('id', $item['product_id'])->exists();

            if (!$exists) {
                return back()->withInput()->with('error', "Invalid item selected.");
            }

            $product->bundleItems()->create([
                'item_id'   => $item['product_id'],
                'item_type' => $item['type'],
                'quantity'  => $item['quantity'],
            ]);
        }
    }

    return redirect()
        ->route('bundled-items.index')
        ->with('success', 'Product created successfully.');
}

public function edit($id)
{
    $bundle = Product::with('bundleItems')->findOrFail($id);

    // Ensure this is really a bundle
    BranchProduct::where('product_id', $id)
        ->where('type', 'bundle')
        ->firstOrFail();

    return view('bundled-items.form', [
        'bundle' => $bundle,
        'categories' => Category::all(),
        'subcategories' => Subcategory::all(),
        'stations' => Station::all(),
        'units' => Unit::all(),
        'products' => Product::where('type', 'simple')->get()
    ]);
}

public function update(Request $request, $id)
{
    $bundle = Product::findOrFail($id);

    $validated = $request->validate([
        'code' => 'required|string|unique:products,code,' . $bundle->id,
        'name' => 'required|string',
        'price' => 'required|numeric',
        'quantity' => 'required|numeric|min:0',
        'unit_id' => 'required|exists:units,id',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'nullable|exists:subcategories,id',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

        // Bundle items required
        'items' => 'required|array|min:1',
        'items.*.type' => 'required|in:product,component',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|numeric|min:0.01',
    ]);

    DB::transaction(function () use ($request, $bundle, $validated) {

        // Handle image update
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['station_id'] = null;
        $validated['type'] = 'bundle';

        // Update product
        $bundle->update($validated);

        // Update branch product record
        BranchProduct::where('product_id', $bundle->id)
            ->update([
                'type'     => 'bundle',
                'unit_id'  => $bundle->unit_id,
                'quantity' => $bundle->quantity,
                'price'    => $bundle->price,
            ]);

        // Remove old bundle items
        $bundle->bundleItems()->delete();

        // Insert updated bundle items
        foreach ($request->items as $item) {

            $exists = $item['type'] === 'product'
                ? \App\Models\Product::where('id', $item['product_id'])->exists()
                : \App\Models\Component::where('id', $item['product_id'])->exists();

            if (!$exists) {
                throw new \Exception("Invalid bundle item selected.");
            }

            $bundle->bundleItems()->create([
                'bundle_id' => $bundle->id,
                'item_id'   => $item['product_id'],
                'item_type' => $item['type'],
                'quantity'  => $item['quantity'],
            ]);
        }
    });

    return redirect()
        ->route('bundled-items.index')
        ->with('success', 'Bundle updated successfully.');
}

    public function archive(Product $product)
{
    $product->update(['status' => 'archived']);

    return response()->json([
        'message' => 'Product moved to archive successfully.',
        'status' => 'success',
        'product_id' => $product->id
    ]);
}

    public function restore($id)
    {
        $product = Product::findOrFail($id);
        $product->update(['status' => 'active']);

        return response()->json(['message' => 'Product restored successfully']);
    }

}
