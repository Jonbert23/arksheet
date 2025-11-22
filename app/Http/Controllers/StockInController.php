<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * Display a listing of stock entries
     */
    public function index(Request $request)
    {
        $query = StockIn::with('product', 'product.category');

        // Filter by product (exclude 'all')
        if ($request->filled('product_id') && $request->product_id !== 'all') {
            $query->where('product_id', $request->product_id);
        }

        // Filter by date range (default to current month if not provided)
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->format('Y-m-d');
        
        $query->whereDate('date', '>=', $dateFrom);
        $query->whereDate('date', '<=', $dateTo);

        // Get all stock entries (DataTables handles pagination)
        $stockIns = $query->recent()->get();
        $products = Product::active()->orderBy('name')->get();

        return view('stock.index', compact('stockIns', 'products'));
    }

    /**
     * Show the form for creating a new stock entry
     */
    public function create()
    {
        $products = Product::with('category')->active()->orderBy('name')->get();
        return view('stock.create', compact('products'));
    }

    /**
     * Store a newly created stock entry
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_per_unit' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'import_duties' => 'nullable|numeric|min:0',
            'other_transaction_costs' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Set default values for additional costs
            $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
            $validated['import_duties'] = $validated['import_duties'] ?? 0;
            $validated['other_transaction_costs'] = $validated['other_transaction_costs'] ?? 0;
            
            // Calculate total additional costs
            $totalAdditionalCosts = $validated['shipping_cost'] + $validated['import_duties'] + $validated['other_transaction_costs'];
            
            // Calculate base cost and total cost
            $baseCost = $validated['quantity'] * $validated['cost_per_unit'];
            $validated['total_cost'] = $baseCost + $totalAdditionalCosts;
            
            // Calculate true cost per unit (including additional costs distributed across all units)
            $additionalCostPerUnit = $validated['quantity'] > 0 ? $totalAdditionalCosts / $validated['quantity'] : 0;
            $trueCostPerUnit = $validated['cost_per_unit'] + $additionalCostPerUnit;

            // Get product before updating
            $product = Product::findOrFail($validated['product_id']);
            
            // Calculate Weighted Average Cost (WAC) using true cost per unit
            if ($trueCostPerUnit > 0) {
                $currentStockQty = $product->stock_quantity;
                $currentCost = $product->cost;
                $newQty = $validated['quantity'];
                
                // Formula: (Current Qty × Current Cost + New Qty × True Cost Per Unit) / (Current Qty + New Qty)
                $currentTotalValue = $currentStockQty * $currentCost;
                $newTotalValue = $newQty * $trueCostPerUnit;
                $totalQty = $currentStockQty + $newQty;
                
                $weightedAverageCost = ($currentTotalValue + $newTotalValue) / $totalQty;
                
                // Update product with WAC
                $product->update(['cost' => $weightedAverageCost]);
            }

            // Create stock entry
            $stockIn = StockIn::create($validated);

            // Update product stock quantity
            $product->increment('stock_quantity', $validated['quantity']);

            DB::commit();

            return redirect()->route('stock.index')
                ->with('success', 'Stock added successfully! ' . $validated['quantity'] . ' units added to ' . $product->name . '. New average cost: ' . auth()->user()->business->currency . ' ' . number_format($weightedAverageCost ?? $product->cost, 2));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add stock: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified stock entry
     */
    public function show(StockIn $stock)
    {
        $stock->load('product', 'product.category');
        return view('stock.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified stock entry
     */
    public function edit(StockIn $stock)
    {
        $products = Product::active()->orderBy('name')->get();
        return view('stock.edit', compact('stock', 'products'));
    }

    /**
     * Update the specified stock entry
     */
    public function update(Request $request, StockIn $stock)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_per_unit' => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'import_duties' => 'nullable|numeric|min:0',
            'other_transaction_costs' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'date' => 'required|date',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Set default values for additional costs
            $validated['shipping_cost'] = $validated['shipping_cost'] ?? 0;
            $validated['import_duties'] = $validated['import_duties'] ?? 0;
            $validated['other_transaction_costs'] = $validated['other_transaction_costs'] ?? 0;
            
            // Calculate total additional costs
            $totalAdditionalCosts = $validated['shipping_cost'] + $validated['import_duties'] + $validated['other_transaction_costs'];
            
            // Calculate base cost and total cost
            $baseCost = $validated['quantity'] * $validated['cost_per_unit'];
            $validated['total_cost'] = $baseCost + $totalAdditionalCosts;
            
            // Calculate true cost per unit (including additional costs)
            $additionalCostPerUnit = $validated['quantity'] > 0 ? $totalAdditionalCosts / $validated['quantity'] : 0;
            $newTrueCostPerUnit = $validated['cost_per_unit'] + $additionalCostPerUnit;

            // Get old values
            $oldQuantity = $stock->quantity;
            $oldCostPerUnit = $stock->cost_per_unit;
            $oldAdditionalCosts = ($stock->shipping_cost ?? 0) + ($stock->import_duties ?? 0) + ($stock->other_transaction_costs ?? 0);
            $oldAdditionalCostPerUnit = $oldQuantity > 0 ? $oldAdditionalCosts / $oldQuantity : 0;
            $oldTrueCostPerUnit = $oldCostPerUnit + $oldAdditionalCostPerUnit;
            $oldProductId = $stock->product_id;
            
            $newQuantity = $validated['quantity'];
            $newProductId = $validated['product_id'];

            // If product changed, reverse old stock and add to new
            if ($oldProductId != $newProductId) {
                // Reverse from old product and recalculate WAC
                $oldProduct = Product::findOrFail($oldProductId);
                $this->recalculateWACAfterRemoval($oldProduct, $oldQuantity, $oldTrueCostPerUnit);
                $oldProduct->decrement('stock_quantity', $oldQuantity);

                // Add to new product and recalculate WAC
                $newProduct = Product::findOrFail($newProductId);
                $this->applyWAC($newProduct, $newQuantity, $newTrueCostPerUnit);
                $newProduct->increment('stock_quantity', $newQuantity);
            } else {
                // Same product, need to recalculate WAC considering the change
                $product = Product::findOrFail($newProductId);
                
                // Remove old entry's effect from WAC
                $this->recalculateWACAfterRemoval($product, $oldQuantity, $oldTrueCostPerUnit);
                
                // Apply new entry's effect to WAC
                $this->applyWAC($product, $newQuantity, $newTrueCostPerUnit);
                
                // Adjust quantity
                $quantityDiff = $newQuantity - $oldQuantity;
                if ($quantityDiff > 0) {
                    $product->increment('stock_quantity', $quantityDiff);
                } elseif ($quantityDiff < 0) {
                    $product->decrement('stock_quantity', abs($quantityDiff));
                }
            }

            // Update stock entry
            $stock->update($validated);

            DB::commit();

            return redirect()->route('stock.index')
                ->with('success', 'Stock entry updated successfully with recalculated average cost!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update stock: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified stock entry
     */
    public function destroy(StockIn $stock)
    {
        DB::beginTransaction();
        try {
            // Calculate true cost per unit including additional costs
            $additionalCosts = ($stock->shipping_cost ?? 0) + ($stock->import_duties ?? 0) + ($stock->other_transaction_costs ?? 0);
            $additionalCostPerUnit = $stock->quantity > 0 ? $additionalCosts / $stock->quantity : 0;
            $trueCostPerUnit = $stock->cost_per_unit + $additionalCostPerUnit;
            
            // Get product and recalculate WAC after removing this entry
            $product = Product::findOrFail($stock->product_id);
            $this->recalculateWACAfterRemoval($product, $stock->quantity, $trueCostPerUnit);
            
            // Reverse stock quantity from product
            $product->decrement('stock_quantity', $stock->quantity);

            $stock->delete();

            DB::commit();

            return redirect()->route('stock.index')
                ->with('success', 'Stock entry deleted successfully and average cost recalculated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete stock: ' . $e->getMessage());
        }
    }

    /**
     * Apply Weighted Average Cost when adding stock
     */
    private function applyWAC($product, $newQty, $newCost)
    {
        if ($newCost <= 0) {
            return;
        }

        $currentStockQty = $product->stock_quantity;
        $currentCost = $product->cost;
        
        // Formula: (Current Qty × Current Cost + New Qty × New Cost) / (Current Qty + New Qty)
        $currentTotalValue = $currentStockQty * $currentCost;
        $newTotalValue = $newQty * $newCost;
        $totalQty = $currentStockQty + $newQty;
        
        if ($totalQty > 0) {
            $weightedAverageCost = ($currentTotalValue + $newTotalValue) / $totalQty;
            $product->update(['cost' => $weightedAverageCost]);
        }
    }

    /**
     * Recalculate Weighted Average Cost after removing stock entry
     */
    private function recalculateWACAfterRemoval($product, $removedQty, $removedCost)
    {
        $currentStockQty = $product->stock_quantity;
        $currentCost = $product->cost;
        
        // If removing all stock, keep the current cost
        if ($currentStockQty <= $removedQty) {
            return;
        }
        
        // Formula: (Current Total Value - Removed Value) / (Current Qty - Removed Qty)
        $currentTotalValue = $currentStockQty * $currentCost;
        $removedTotalValue = $removedQty * $removedCost;
        $remainingQty = $currentStockQty - $removedQty;
        
        if ($remainingQty > 0) {
            $newAverageCost = ($currentTotalValue - $removedTotalValue) / $remainingQty;
            
            // Prevent negative costs
            if ($newAverageCost > 0) {
                $product->update(['cost' => $newAverageCost]);
            }
        }
    }
}

