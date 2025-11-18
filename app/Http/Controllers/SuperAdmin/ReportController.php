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
 * Super Admin Report Controller
 * 
 * Generates system-wide reports and analytics across all businesses
 */
class ReportController extends Controller
{
    /**
     * Display reports overview
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('super-admin.reports.index');
    }

    /**
     * Generate revenue report
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function revenue(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Total revenue across all businesses
        $totalRevenue = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');

        // Revenue by business
        $revenueByBusiness = Business::withoutGlobalScope('business')
            ->select('businesses.id', 'businesses.name')
            ->selectRaw('COALESCE(SUM(sales.total), 0) as total_revenue')
            ->selectRaw('COUNT(sales.id) as total_sales')
            ->leftJoin('sales', function ($join) use ($startDate, $endDate) {
                $join->on('businesses.id', '=', 'sales.business_id')
                     ->whereBetween('sales.created_at', [$startDate, $endDate]);
            })
            ->groupBy('businesses.id', 'businesses.name')
            ->orderByDesc('total_revenue')
            ->get();

        // Daily revenue trend
        $dailyRevenue = Sale::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as sales_count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Revenue by payment method (if applicable)
        $revenueByPaymentMethod = Sale::select('payment_method')
            ->selectRaw('SUM(total) as total_revenue')
            ->selectRaw('COUNT(*) as total_sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('payment_method')
            ->get();

        return view('super-admin.reports.revenue', compact(
            'totalRevenue',
            'revenueByBusiness',
            'dailyRevenue',
            'revenueByPaymentMethod',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate business usage report
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function usage(Request $request)
    {
        $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Business activity metrics
        $businessMetrics = Business::withoutGlobalScope('business')
            ->select('businesses.id', 'businesses.name', 'businesses.created_at')
            ->selectRaw('(SELECT COUNT(*) FROM users WHERE users.business_id = businesses.id) as user_count')
            ->selectRaw('(SELECT COUNT(*) FROM products WHERE products.business_id = businesses.id) as product_count')
            ->selectRaw('(SELECT COUNT(*) FROM sales WHERE sales.business_id = businesses.id AND sales.created_at BETWEEN ? AND ?) as sales_count', [$startDate, $endDate])
            ->selectRaw('(SELECT COALESCE(SUM(total), 0) FROM sales WHERE sales.business_id = businesses.id AND sales.created_at BETWEEN ? AND ?) as total_revenue', [$startDate, $endDate])
            ->get();

        // Most active businesses
        $mostActiveBusinesses = $businessMetrics->sortByDesc('sales_count')->take(10);

        // Least active businesses
        $leastActiveBusinesses = $businessMetrics->sortBy('sales_count')->take(10);

        // Inactive businesses (no sales in period)
        $inactiveBusinesses = $businessMetrics->where('sales_count', 0);

        return view('super-admin.reports.usage', compact(
            'businessMetrics',
            'mostActiveBusinesses',
            'leastActiveBusinesses',
            'inactiveBusinesses',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Generate growth report
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function growth(Request $request)
    {
        $months = $request->get('months', 12);

        // Business growth over time
        $businessGrowth = Business::withoutGlobalScope('business')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // User growth over time
        $userGrowth = User::where('role', '!=', 'super_admin')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Revenue growth over time
        $revenueGrowth = Sale::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total) as revenue'),
                DB::raw('COUNT(*) as sales_count')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Product growth over time
        $productGrowth = Product::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate growth rates
        $currentMonthBusinesses = Business::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $lastMonthBusinesses = Business::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $businessGrowthRate = $lastMonthBusinesses > 0 
            ? (($currentMonthBusinesses - $lastMonthBusinesses) / $lastMonthBusinesses) * 100 
            : 0;

        return view('super-admin.reports.growth', compact(
            'businessGrowth',
            'userGrowth',
            'revenueGrowth',
            'productGrowth',
            'businessGrowthRate',
            'months'
        ));
    }

    /**
     * Export report data
     *
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request, string $type)
    {
        // This would implement CSV/Excel export functionality
        // For now, return a simple response
        return response()->json([
            'message' => 'Export functionality coming soon',
            'type' => $type
        ]);
    }
}

