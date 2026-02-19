<?php

namespace App\Http\Controllers;

use App\Models\BranchProduct;
use App\Models\Category;
use App\Models\Component;
use App\Models\Product;
use App\Models\Station;
use App\Models\Subcategory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
{
    return view('products.index');
}

/**
 * Fetch products based on status, search, pagination, and branch
 */
public function fetchProducts(Request $request)
{
    // 🔥 DEFAULT STATUS HANDLED HERE
   $status = $request->get('status', 'active');

    $perPage     = $request->get('perPage', 10);
    $search      = $request->get('search');
    $category    = $request->get('category');
    $subcategory = $request->get('subcategory');
    $type       = $request->get('type');

    $branchId = current_branch_id();

    if ($branchId == 1) {

        $products = Product::with(['category', 'subcategory', 'unit', 'station'])
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
                'bc.status as status'
            ])
            ->join('branch_products as bc', 'bc.product_id', '=', 'products.id')
            ->where('bc.branch_id', $branchId)
            ->where('products.status', $status)
            ->with(['category', 'subcategory', 'unit', 'station'])
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
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::all();
        $units = Unit::all();
        $stations = Station::all();

        return view('products.create', compact('categories', 'subcategories', 'units', 'stations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:products,code',
            'name' => 'required|string',
            'price' => 'required|numeric',

            'quantity'   => 'required|numeric|min:0',
            'station_id' => 'required|exists:stations,id',
            'unit_id'    => 'required|exists:units,id',

            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

            // Recipe validation
            'recipes.component_id.*' => 'required|exists:components,id',
            'recipes.quantity.*' => 'required|numeric',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        // Create product
        $product = Product::create($validated);

         BranchProduct::create([
            'branch_id'  => current_branch_id(),
            'product_id' => $product->id,
            'station_id' => $product->station_id,
            'unit_id'    => $product->unit_id,
            'quantity'   => $product->quantity,
            'price'      => $product->price,
            'status'     => 'active', // or whatever default you use
        ]);

        // Save recipes
        if ($request->has('recipes')) {
            foreach ($request->recipes['component_id'] as $index => $component_id) {
                $quantity = $request->recipes['quantity'][$index];
                $unit = $request->recipes['unit'][$index];
                $product->recipes()->create([
                    'component_id' => $component_id,
                    'quantity' => $quantity,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created with recipes.');
    }

    public function edit($id)
    {
        $product = Product::with('recipes')->findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        $subcategories = Subcategory::all();
        $components = Component::all();
        $units = Unit::all();
        $stations = Station::all();

        return view('products.edit', compact('product', 'categories', 'subcategories', 'components', 'units', 'stations'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'code' => 'required|string|unique:products,code,' . $product->id,
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',

            'station_id' => 'required|exists:stations,id',
            'quantity' => 'required|numeric|min:0',
            'unit_id' => 'required|exists:units,id',

            'recipes' => 'nullable|array',
            'recipes.*.component_id' => 'required|exists:components,id',
            'recipes.*.quantity' => 'required|numeric',
            'recipes.*.unit' => 'required|string',
            'recipes.*.cost' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
                $productData = Arr::only($validated, [
                'code',
                'name',
                'price',
                'category_id',
                'subcategory_id',
                'station_id',
                'unit_id',
                'quantity',
            ]);

            // Handle new image upload
            if ($request->hasFile('image')) {
                // delete old image if exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                $productData['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($productData);

            if ($request->has('recipes')) {
                $existingIds = $product->recipes()->pluck('id')->toArray();
                $submittedIds = [];

                foreach ($validated['recipes'] as $recipeData) {
                    if (!empty($recipeData['id'])) {
                        $recipe = $product->recipes()->find($recipeData['id']);
                        if ($recipe) {
                            $recipe->update($recipeData);
                            $submittedIds[] = $recipe->id;
                        }
                    } else {
                        $newRecipe = $product->recipes()->create($recipeData);
                        $submittedIds[] = $newRecipe->id;
                    }
                }

                $toDelete = array_diff($existingIds, $submittedIds);
                if (!empty($toDelete)) {
                    $product->recipes()->whereIn('id', $toDelete)->delete();
                }
            }

            DB::commit();
            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Move the specified Product to archive (status change).
     */
    public function archive(Product $product)
{
    $product->update(['status' => 'archived']);

    return response()->json([
        'message' => 'Product moved to archive successfully.',
        'status' => 'success',
        'product_id' => $product->id
    ]);
}


    /**
     * Restore a product from archive.
     */
    public function restore(Product $product)
{
    $product->update([
        'status' => 'active'
    ]);

    return response()->json([
        'message' => 'Product restored to active successfully.',
        'status' => 'success',
        'product_id' => $product->id
    ]);
}

    public function verify(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $rows = array_map('str_getcsv', file($request->file));
        $header = array_map('trim', array_shift($rows));

        $preview = [];
        $errors  = [];

        foreach ($rows as $index => $row) {
            $data = array_combine($header, $row);

            $category = Category::where('name', $data['Category'])->first();
            $subcategory = Subcategory::where('name', $data['Subcategory'])->first();

            $rowErrors = [];

            if (!$category) $rowErrors[] = 'Category not found';
            if (!$subcategory) $rowErrors[] = 'Subcategory not found';

            $preview[] = [
                'row' => $index + 2,
                'sku' => $data['SKU'],
                'name' => $data['Name'],
                'category' => $data['Category'],
                'subcategory' => $data['Subcategory'],
                'quantity' => (float) $data['Quantity'],
                'unit' => $data['Unit'],
                'price' => (float) $data['Price'],
                'errors' => $rowErrors,
                'valid' => empty($rowErrors),
            ];
        }

        return response()->json([
            'preview' => $preview,
            'can_submit' => collect($preview)->every(fn ($r) => $r['valid'])
        ]);
    }

    public function checkImportDuplicates(Request $request)
{
    $rows = $request->rows;

    $skus  = collect($rows)->pluck('code')->filter();
    $names = collect($rows)->pluck('name')->filter();

    $existingSkus = Product::whereIn('code', $skus)->pluck('code')->toArray();
    $existingNames = Product::whereIn('name', $names)->pluck('name')->toArray();

    return response()->json([
        'existingSkus'  => $existingSkus,
        'existingNames' => $existingNames,
    ]);
}


    public function import(Request $request)
    {
        $file = $request->file('file');
        $rows = array_map('str_getcsv', file($file));

        foreach ($rows as $i => $row) {
            if ($i === 0) continue; // skip header

            Product::updateOrCreate(
                ['code' => $row[0]],
                [
                    'name' => $row[1],
                    'category_id' => $row[2],
                    'subcategory_id' => $row[3],
                    'status' => 'active'
                ]
            );
        }

        return response()->json(['success' => true]);
    }
}
