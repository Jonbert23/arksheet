<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of all invoices (sales)
     */
    public function index()
    {
        $invoices = Sale::with(['customer', 'salesChannel', 'saleItems.product'])
            ->latest('date')
            ->get();
            
        return view('invoices.index', compact('invoices'));
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
