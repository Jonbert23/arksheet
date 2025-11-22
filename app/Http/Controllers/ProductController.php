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
     * Load create product form for modal
     */
    public function createForm()
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
        
        return view('products.partials.create-form', compact('categories', 'productTypes', 'units'));
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
            'cost_per_unit' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'other_costs' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            // Stock entry fields (optional)
            'add_stock_option' => 'nullable|string|in:yes,no',
            'stock_date' => 'nullable|date',
            'shipping_cost' => 'nullable|numeric|min:0',
            'import_duties' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'stock_notes' => 'nullable|string',
        ]);

        // Set default values for nullable numeric fields to prevent null constraint violations
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['cost'] = $validated['cost'] ?? 0;
        $validated['stock_quantity'] = $validated['stock_quantity'] ?? 0;
        $validated['min_stock_alert'] = $validated['min_stock_alert'] ?? 0;

        // If cost_per_unit is provided but cost is 0, use cost_per_unit as the product cost
        if (!empty($validated['cost_per_unit']) && $validated['cost'] == 0) {
            // Calculate actual cost per unit including additional costs
            $costPerUnit = $validated['cost_per_unit'];
            $quantity = $validated['stock_quantity'] ?? 1;
            
            // Calculate total additional costs (for stock entry tracking)
            $shippingCost = $validated['shipping_cost'] ?? 0;
            $importDuties = $validated['import_duties'] ?? 0;
            $otherCostsFromStock = $validated['other_costs'] ?? 0;
            $totalAdditionalCosts = $shippingCost + $importDuties + $otherCostsFromStock;
            
            // Calculate actual cost per unit (this already includes all costs)
            if ($quantity > 0) {
                $validated['cost'] = $costPerUnit + ($totalAdditionalCosts / $quantity);
            } else {
                $validated['cost'] = $costPerUnit;
            }
            
            // Set other_costs to 0 for the product since cost already includes everything
            // The other_costs field in the product is for any ADDITIONAL per-unit costs beyond the base cost
            // But in our wizard, all costs are already factored into the 'cost' field
            $validated['other_costs'] = 0;
        } else {
            // If not using cost_per_unit, set other_costs to 0 by default
            $validated['other_costs'] = $validated['other_costs'] ?? 0;
        }

        // Set stock quantity to 0 if not adding stock
        if ($request->add_stock_option !== 'yes') {
            $validated['stock_quantity'] = 0;
        }

        $product = Product::create($validated);

        // Create initial stock entry if user chose to add stock
        if ($request->add_stock_option === 'yes' && isset($validated['stock_quantity']) && $validated['stock_quantity'] > 0) {
            $stockData = [
                'product_id' => $product->id,
                'quantity_received' => $validated['stock_quantity'],
                'cost_per_unit' => $validated['cost_per_unit'] ?? $validated['cost'] ?? 0,
                'date_received' => $validated['stock_date'] ?? now(),
                'supplier' => $validated['supplier'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'notes' => $validated['stock_notes'] ?? null,
                'shipping_cost' => $validated['shipping_cost'] ?? 0,
                'import_duties' => $validated['import_duties'] ?? 0,
                'other_costs' => $validated['other_costs'] ?? 0,
                'status' => 'received',
            ];
            
            try {
                \App\Models\StockIn::create($stockData);
            } catch (\Exception $e) {
                \Log::error('Failed to create stock entry: ' . $e->getMessage(), [
                    'stock_data' => $stockData,
                    'request_data' => $request->all()
                ]);
                // Continue without throwing error - product was created successfully
            }
        }

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product' => $product
            ]);
        }

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
     * Load edit product form for modal
     */
    public function editForm(Product $product)
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
        
        return view('products.partials.edit-form', compact('product', 'categories', 'productTypes', 'units'));
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
            'cost_per_unit' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'other_costs' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        // Set default values for nullable numeric fields
        $validated['tax_amount'] = $validated['tax_amount'] ?? 0;
        $validated['other_costs'] = $validated['other_costs'] ?? 0;
        $validated['stock_quantity'] = $validated['stock_quantity'] ?? 0;
        $validated['min_stock_alert'] = $validated['min_stock_alert'] ?? 0;
        
        // If cost is not provided, keep existing cost
        if (!isset($validated['cost'])) {
            $validated['cost'] = $product->cost;
        }

        $product->update($validated);

        // Return JSON response for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => $product
            ]);
        }

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
