<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of all invoices (sales)
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'salesChannel', 'saleItems.product']);

        // Filter by customer (exclude 'all')
        if ($request->filled('customer_id') && $request->customer_id !== 'all') {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Get all invoices
        $invoices = $query->latest('date')->get();
        
        // Get all customers for filter dropdown
        $customers = Customer::active()->orderBy('name')->get();
            
        return view('invoices.index', compact('invoices', 'customers'));
    }
    
    /**
     * Display the specified invoice for viewing/printing
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'salesChannel', 'saleItems.product']);
        
        return view('invoices.show', [
            'invoice' => $sale
        ]);
    }
    
    /**
     * Download invoice as PDF (future implementation)
     */
    public function download(Sale $sale)
    {
        // TODO: Implement PDF generation
        return redirect()->route('invoices.show', $sale->id);
    }
}
