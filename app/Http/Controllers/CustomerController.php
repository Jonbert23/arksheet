<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers
     */
    public function index(Request $request)
    {
        $query = Customer::withCount('sales');

        // Date range filter
        $dateFrom = $request->input('date_from', now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        
        $query->whereBetween('created_at', [
            $dateFrom . ' 00:00:00',
            $dateTo . ' 23:59:59'
        ]);

        // Status filter
        if ($request->filled('is_active')) {
            if ($request->is_active === '1') {
                $query->where('is_active', true);
            } elseif ($request->is_active === '0') {
                $query->where('is_active', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->get();

        return view('customers.index', compact('customers', 'dateFrom', 'dateTo'));
    }

    /**
     * Show the form for creating a new customer
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Default is_active to true if not provided
        if (!isset($validated['is_active'])) {
            $validated['is_active'] = true;
        }

        DB::beginTransaction();
        try {
            Customer::create(array_merge($validated, [
                'business_id' => auth()->user()->business_id,
            ]));

            DB::commit();

            return redirect()->route('customers.index')
                ->with('success', 'Customer created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified customer
     */
    public function show(Request $request, Customer $customer)
    {
        $customer->load(['sales' => function($query) {
            $query->latest('date')->with('salesChannel')->take(10);
        }]);
        
        // Return JSON for AJAX requests (modal)
        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            // Calculate total sales
            $totalSales = $customer->sales()->sum('total');
            
            return response()->json([
                'customer' => array_merge($customer->toArray(), [
                    'total_sales' => $totalSales,
                    'sales_count' => $customer->sales()->count()
                ])
            ]);
        }
        
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit(Request $request, Customer $customer)
    {
        // Return JSON for AJAX requests (modal)
        if ($request->wantsJson() || $request->expectsJson() || $request->ajax()) {
            return response()->json(['customer' => $customer]);
        }
        
        // Return view for regular requests
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $customer->update($validated);

            DB::commit();

            return redirect()->route('customers.index')
                ->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update customer: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified customer
     */
    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            // Check if customer has sales
            if ($customer->sales()->count() > 0) {
                return back()->with('error', 'Cannot delete customer with existing sales. Please deactivate instead.');
            }

            $customer->delete();

            DB::commit();

            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete customer: ' . $e->getMessage());
        }
    }
}

