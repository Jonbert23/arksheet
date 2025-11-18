<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Super Admin Dashboard Controller
 * 
 * Displays system-wide statistics and metrics across all businesses
 */
class DashboardController extends Controller
{
    /**
     * Display the Super Admin dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get system-wide statistics
        $stats = [
            'total_businesses' => Business::count(),
            'active_businesses' => Business::where('is_active', true)->count(),
            'total_users' => User::where('role', '!=', 'super_admin')->count(),
            'active_users' => User::where('role', '!=', 'super_admin')
                ->where('is_active', true)
                ->count(),
            'total_sales' => Sale::where('created_at', '>=', now()->subDays(30))->count(),
        ];

        // Calculate growth rate (month over month)
        $currentMonthBusinesses = Business::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $lastMonthBusinesses = Business::whereYear('created_at', now()->subMonth()->year)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->count();
        
        $stats['growth_rate'] = $lastMonthBusinesses > 0 
            ? round((($currentMonthBusinesses - $lastMonthBusinesses) / $lastMonthBusinesses) * 100, 1)
            : 0;

        // Get total revenue across all businesses (last 30 days)
        $totalRevenue = Sale::where('created_at', '>=', now()->subDays(30))
            ->sum('total');

        // Get total products across all businesses
        $totalProducts = Product::count();

        // Get recent businesses (last 10)
        $recentBusinesses = Business::withoutGlobalScope('business')
            ->latest()
            ->take(10)
            ->get();

        // Get business growth data (last 12 months)
        $businessGrowth = Business::withoutGlobalScope('business')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Get revenue by business (top 10)
        $revenueByBusiness = Business::withoutGlobalScope('business')
            ->select('businesses.id', 'businesses.name')
            ->selectRaw('COALESCE(SUM(sales.total), 0) as total_revenue')
            ->leftJoin('sales', 'businesses.id', '=', 'sales.business_id')
            ->where('sales.created_at', '>=', now()->subDays(30))
            ->orWhereNull('sales.created_at')
            ->groupBy('businesses.id', 'businesses.name')
            ->orderByDesc('total_revenue')
            ->take(10)
            ->get();

        // Get user distribution by role
        $usersByRole = User::where('role', '!=', 'super_admin')
            ->select('role', DB::raw('COUNT(*) as count'))
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role');

        // Revenue Trend (Last 30 days) - For Line Graph
        $revenueTrend = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as sales_count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Business Status Distribution - For Pie Chart
        $activeBusinesses = Business::where('is_active', true)
            ->where('created_at', '<', now()->subDays(30))
            ->count();
        $inactiveBusinesses = Business::where('is_active', false)->count();
        $newBusinesses = Business::where('created_at', '>=', now()->subDays(30))->count();
        $dormantBusinesses = Business::where('is_active', true)
            ->whereDoesntHave('sales', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->where('created_at', '<', now()->subDays(30))
            ->count();

        $businessStatusDistribution = [
            'active' => $activeBusinesses - $dormantBusinesses,
            'inactive' => $inactiveBusinesses,
            'new' => $newBusinesses,
            'dormant' => $dormantBusinesses
        ];

        // User Role Distribution - For Pie Chart
        $businessOwners = User::where('role', 'business_owner')->count();
        $staffMembers = User::where('role', 'staff')->count();
        $activeOwners = User::where('role', 'business_owner')->where('is_active', true)->count();
        $activeStaff = User::where('role', 'staff')->where('is_active', true)->count();

        $userRoleDistribution = [
            'business_owners' => $businessOwners,
            'staff' => $staffMembers,
            'active_owners' => $activeOwners,
            'active_staff' => $activeStaff
        ];

        return view('super-admin.dashboard', compact(
            'stats',
            'totalRevenue',
            'totalProducts',
            'recentBusinesses',
            'businessGrowth',
            'revenueByBusiness',
            'usersByRole',
            'revenueTrend',
            'businessStatusDistribution',
            'userRoleDistribution'
        ));
    }
}

