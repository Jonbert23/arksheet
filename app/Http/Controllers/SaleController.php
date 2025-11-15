<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of sales
     */
    public function index(Request $request)
    {
        $query = Sale::with('customer', 'salesChannel', 'saleItems.product');

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by sales channel
        if ($request->filled('sales_channel_id')) {
            $query->where('sales_channel_id', $request->sales_channel_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Get all sales (DataTables handles pagination)
        $sales = $query->latest('date')->get();
        $customers = Customer::active()->orderBy('name')->get();
        $salesChannels = SalesChannel::active()->orderBy('name')->get();
        $products = Product::active()->orderBy('name')->get();

        return view('sales.index', compact('sales', 'customers', 'salesChannels', 'products'));
    }

    /**
     * Display POS interface
     */
    public function pos()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->active()
            ->orderBy('name')
            ->get();
        $customers = Customer::active()->orderBy('name')->get();
        $salesChannels = SalesChannel::active()->orderBy('name')->get();

        return view('sales.pos', compact('products', 'customers', 'salesChannels'));
    }

    /**
     * Show the form for creating a new sale
     */
    public function create()
    {
        $products = Product::active()->with('category')->orderBy('name')->get();
        $customers = Customer::active()->orderBy('name')->get();
        $salesChannels = SalesChannel::active()->orderBy('name')->get();
        
        return view('sales.create', compact('products', 'customers', 'salesChannels'));
    }

    /**
     * Store a newly created sale
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sales_channel_id' => 'required|exists:sales_channels,id',
            'date' => 'required|date',
            'invoice_number' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string',
            'payment_status' => 'required|in:paid,pending,partial',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_type' => 'nullable|string|in:percent,fixed',
            'items.*.discount_value' => 'nullable|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            $totalTax = 0;
            $totalDiscount = 0;
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                
                // Apply item-level discount
                $itemDiscountAmount = $item['discount_amount'] ?? 0;
                $itemSubtotalAfterDiscount = $itemSubtotal - $itemDiscountAmount;
                
                // Calculate tax on discounted amount
                $itemTax = $itemSubtotalAfterDiscount * (($product->tax_amount ?? 0) / 100);
                
                $subtotal += $itemSubtotal;
                $totalDiscount += $itemDiscountAmount;
                $totalTax += $itemTax;
            }
            
            $total = $subtotal - $totalDiscount + $totalTax;

            // Create sale
            $sale = Sale::create([
                'business_id' => auth()->user()->business_id,
                'customer_id' => $validated['customer_id'],
                'sales_channel_id' => $validated['sales_channel_id'],
                'date' => $validated['date'],
                'invoice_number' => $validated['invoice_number'] ?? 'INV-' . time(),
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_status'],
                'subtotal' => $subtotal,
                'discount' => $totalDiscount,
                'tax' => $totalTax,
                'total' => $total,
                'notes' => $validated['notes'],
            ]);

            // Create sale items and update product stock
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                
                // Calculate item values
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                
                // Apply item-level discount
                $itemDiscountAmount = $item['discount_amount'] ?? 0;
                $itemSubtotalAfterDiscount = $itemSubtotal - $itemDiscountAmount;
                
                // Calculate tax on discounted amount
                $itemTax = $itemSubtotalAfterDiscount * (($product->tax_amount ?? 0) / 100);
                $itemTotal = $itemSubtotalAfterDiscount + $itemTax;
                $itemCost = $item['quantity'] * $product->cost;
                $itemProfit = $itemTotal - $itemCost;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_type' => $item['discount_type'] ?? null,
                    'discount_value' => $item['discount_value'] ?? 0,
                    'discount_amount' => $itemDiscountAmount,
                    'tax_rate' => ($product->tax_amount ?? 0),
                    'tax_amount' => $itemTax,
                    'subtotal' => $itemSubtotal,
                    'total' => $itemTotal,
                    'cost' => $itemCost,
                    'profit' => $itemProfit,
                ]);

                // Decrease product stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Sale recorded successfully! Invoice: ' . $sale->invoice_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record sale: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified sale
     */
    public function show(Sale $sale, Request $request)
    {
        $sale->load('customer', 'salesChannel', 'saleItems.product');
        
        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'sale' => $sale
            ]);
        }
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale
     */
    public function edit(Sale $sale)
    {
        $sale->load('saleItems.product');
        $products = Product::active()->with('category')->orderBy('name')->get();
        $customers = Customer::active()->orderBy('name')->get();
        $salesChannels = SalesChannel::active()->orderBy('name')->get();
        
        return view('sales.edit', compact('sale', 'products', 'customers', 'salesChannels'));
    }

    /**
     * Update the specified sale
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'sales_channel_id' => 'required|exists:sales_channels,id',
            'date' => 'required|date',
            'invoice_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Restore stock from old sale items
            foreach ($sale->saleItems as $oldItem) {
                $oldItem->product->increment('stock_quantity', $oldItem->quantity);
            }

            // Delete old sale items
            $sale->saleItems()->delete();

            // Calculate new totals
            $subtotal = 0;
            $totalTax = 0;
            
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemTax = $itemSubtotal * (($product->tax_amount ?? 0) / 100);
                
                $subtotal += $itemSubtotal;
                $totalTax += $itemTax;
            }
            
            $total = $subtotal + $totalTax;

            // Update sale
            $sale->update([
                'customer_id' => $validated['customer_id'],
                'sales_channel_id' => $validated['sales_channel_id'],
                'date' => $validated['date'],
                'invoice_number' => $validated['invoice_number'] ?? $sale->invoice_number,
                'subtotal' => $subtotal,
                'tax' => $totalTax,
                'total' => $total,
                'notes' => $validated['notes'],
            ]);

            // Create new sale items and update stock
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                
                $itemSubtotal = $item['quantity'] * $item['unit_price'];
                $itemTax = $itemSubtotal * (($product->tax_amount ?? 0) / 100);
                $itemTotal = $itemSubtotal + $itemTax;
                $itemCost = $item['quantity'] * $product->cost;
                $itemProfit = $itemTotal - $itemCost;

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'tax_rate' => ($product->tax_amount ?? 0),
                    'tax_amount' => $itemTax,
                    'subtotal' => $itemSubtotal,
                    'total' => $itemTotal,
                    'cost' => $itemCost,
                    'profit' => $itemProfit,
                ]);

                // Decrease product stock
                $product->decrement('stock_quantity', $item['quantity']);
            }

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Sale updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update sale: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified sale
     */
    public function destroy(Sale $sale)
    {
        DB::beginTransaction();
        try {
            // Restore stock from sale items
            foreach ($sale->saleItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Sale deleted successfully and stock restored!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }
}

