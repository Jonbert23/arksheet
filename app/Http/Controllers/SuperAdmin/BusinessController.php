<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Super Admin Business Management Controller
 * 
 * Handles CRUD operations for businesses across the entire system
 */
class BusinessController extends Controller
{
    /**
     * Display a listing of all businesses
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Business::withoutGlobalScope('business')
            ->withCount(['users', 'products', 'sales']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $businesses = $query->paginate(20);

        return view('super-admin.businesses.index', compact('businesses'));
    }

    /**
     * Show the form for creating a new business
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('super-admin.businesses.create');
    }

    /**
     * Store a newly created business in storage
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'currency' => ['required', 'string', 'max:3'],
            'timezone' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
            
            // Owner details
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'owner_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            // Create business
            $business = Business::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'currency' => $validated['currency'],
                'timezone' => $validated['timezone'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            // Create business owner
            $owner = User::create([
                'business_id' => $business->id,
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make($validated['owner_password']),
                'role' => 'business_owner',
                'is_active' => true,
            ]);

            DB::commit();

            return redirect()
                ->route('super-admin.businesses.show', $business)
                ->with('success', 'Business created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create business: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified business
     *
     * @param Business $business
     * @return \Illuminate\View\View
     */
    public function show(Business $business)
    {
        // Load business without tenant scope
        $business = Business::withoutGlobalScope('business')
            ->with(['users' => function ($query) {
                $query->withoutGlobalScope('business');
            }])
            ->findOrFail($business->id);

        // Get business statistics
        $stats = [
            'total_users' => User::where('business_id', $business->id)->count(),
            'active_users' => User::where('business_id', $business->id)
                ->where('is_active', true)
                ->count(),
            'total_products' => Product::where('business_id', $business->id)->count(),
            'total_sales' => Sale::where('business_id', $business->id)->count(),
            'total_revenue' => Sale::where('business_id', $business->id)
                ->sum('total'),
            'revenue_this_month' => Sale::where('business_id', $business->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('total'),
        ];

        // Get recent activity
        $recentSales = Sale::where('business_id', $business->id)
            ->with('customer')
            ->latest()
            ->take(10)
            ->get();

        return view('super-admin.businesses.show', compact('business', 'stats', 'recentSales'));
    }

    /**
     * Show the form for editing the specified business
     *
     * @param Business $business
     * @return \Illuminate\View\View
     */
    public function edit(Business $business)
    {
        // Load business without tenant scope
        $business = Business::withoutGlobalScope('business')
            ->findOrFail($business->id);

        return view('super-admin.businesses.edit', compact('business'));
    }

    /**
     * Update the specified business in storage
     *
     * @param Request $request
     * @param Business $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Business $business)
    {
        // Load business without tenant scope
        $business = Business::withoutGlobalScope('business')
            ->findOrFail($business->id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'currency' => ['required', 'string', 'max:3'],
            'timezone' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);

        try {
            $business->update($validated);

            return redirect()
                ->route('super-admin.businesses.show', $business)
                ->with('success', 'Business updated successfully!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update business: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified business from storage
     *
     * @param Business $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Business $business)
    {
        // Load business without tenant scope
        $business = Business::withoutGlobalScope('business')
            ->findOrFail($business->id);

        try {
            // Check if business has any data
            $hasUsers = User::where('business_id', $business->id)->exists();
            $hasSales = Sale::where('business_id', $business->id)->exists();

            if ($hasUsers || $hasSales) {
                return back()->with('error', 'Cannot delete business with existing users or sales. Please deactivate instead.');
            }

            $business->delete();

            return redirect()
                ->route('super-admin.businesses.index')
                ->with('success', 'Business deleted successfully!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to delete business: ' . $e->getMessage());
        }
    }

    /**
     * Toggle business active status
     *
     * @param Business $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(Business $business)
    {
        // Load business without tenant scope
        $business = Business::withoutGlobalScope('business')
            ->findOrFail($business->id);

        try {
            $business->update([
                'is_active' => !$business->is_active
            ]);

            $status = $business->is_active ? 'activated' : 'deactivated';

            return back()->with('success', "Business {$status} successfully!");

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update business status: ' . $e->getMessage());
        }
    }
}

