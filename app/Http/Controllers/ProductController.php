<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'saleItems');

        // Filter by category
        if ($request->filled('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by stock status
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'low') {
                $query->lowStock();
            } elseif ($request->stock_status === 'out') {
                $query->outOfStock();
            }
        }

        // Get all products (DataTables handles pagination client-side)
        $products = $query->latest()->get();
        $categories = ProductCategory::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $businessId = auth()->user()->business_id;
        
        $categories = ProductCategory::where('business_id', $businessId)->active()->get();
        $productTypes = BusinessSetting::where('business_id', $businessId)
            ->where('setting_key', 'product_type')
            ->active()
            ->ordered()
            ->get();
        $units = BusinessSetting::where('business_id', $businessId)
            ->where('setting_key', 'unit_of_measurement')
            ->active()
            ->ordered()
            ->get();
        
        return view('products.create', compact('categories', 'productTypes', 'units'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'description' => 'nullable|string',
            'additional_info' => 'nullable|string|max:255',
            'type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'other_costs' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load('category', 'stockIns', 'saleItems');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $businessId = auth()->user()->business_id;
        
        $categories = ProductCategory::where('business_id', $businessId)->active()->get();
        $productTypes = BusinessSetting::where('business_id', $businessId)
            ->where('setting_key', 'product_type')
            ->active()
            ->ordered()
            ->get();
        $units = BusinessSetting::where('business_id', $businessId)
            ->where('setting_key', 'unit_of_measurement')
            ->active()
            ->ordered()
            ->get();
        
        return view('products.edit', compact('product', 'categories', 'productTypes', 'units'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_category_id' => 'nullable|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'additional_info' => 'nullable|string|max:255',
            'type' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'other_costs' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
