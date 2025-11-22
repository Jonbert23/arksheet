<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Customer;
use App\Models\SalesChannel;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $business = auth()->user()->business;
        
        // Get date range from request or use defaults
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->startOfMonth()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->format('Y-m-d');
        
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $today = now()->toDateString();

        // ==================== FILTERED DATE RANGE METRICS ====================
        $filteredSales = Sale::whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->sum('total');
        $filteredExpenses = Expense::whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->sum('amount');
        $filteredGrossProfit = $filteredSales - $filteredExpenses;
        $grossProfitMargin = $filteredSales > 0 ? round(($filteredGrossProfit / $filteredSales) * 100) : 0;
        
        // ==================== ALL-TIME METRICS ====================
        $allTimeSales = Sale::sum('total');
        $allTimeExpenses = Expense::sum('amount');
        $allTimeGrossProfit = $allTimeSales - $allTimeExpenses;

        // ==================== TODAY'S METRICS ====================
        $salesToday = Sale::whereDate('date', $today)->sum('total');
        $expensesToday = Expense::whereDate('date', $today)->sum('amount');
        $itemsSoldToday = SaleItem::whereHas('sale', function($q) use ($today) {
            $q->whereDate('date', $today);
        })->sum('quantity');
        
        // ==================== FILTERED ITEMS SOLD ====================
        $filteredItemsSold = SaleItem::whereHas('sale', function($q) use ($dateFrom, $dateTo) {
            $q->whereDate('date', '>=', $dateFrom)->whereDate('date', '<=', $dateTo);
        })->sum('quantity');

        // ==================== MONTHLY METRICS ====================
        $monthlySales = Sale::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('total');
        
        $monthlyExpenses = Expense::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');
        
        $monthlyProfit = $monthlySales - $monthlyExpenses;
        
        $monthlyItemsSold = SaleItem::whereHas('sale', function($q) use ($currentMonth, $currentYear) {
            $q->whereMonth('date', $currentMonth)->whereYear('date', $currentYear);
        })->sum('quantity');

        // ==================== TARGETS (Based on Filtered Date) ====================
        $itemsSoldTarget = 500;
        $salesTarget = 500000;
        $annualSalesTarget = 6000000;
        
        // Calculate percentages based on filtered data
        $itemsSoldPercentage = $itemsSoldTarget > 0 ? round(($filteredItemsSold / $itemsSoldTarget) * 100) : 0;
        $salesPercentage = $salesTarget > 0 ? round(($filteredSales / $salesTarget) * 100) : 0;
        $annualSalesPercentage = $annualSalesTarget > 0 ? round(($filteredSales / $annualSalesTarget) * 100) : 0;

        // ==================== INVENTORY STATUS ====================
        $inStockProducts = Product::where('stock_quantity', '>', DB::raw('min_stock_alert'))->count();
        $lowStockProducts = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', DB::raw('min_stock_alert'))
            ->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();

        // ==================== DAILY SALES TREND (Filtered Date Range) ====================
        $dailySalesTrend = [];
        $startDate = \Carbon\Carbon::parse($dateFrom);
        $endDate = \Carbon\Carbon::parse($dateTo);
        $daysDiff = $startDate->diffInDays($endDate);
        
        // Limit to maximum 31 days for chart readability
        if ($daysDiff > 31) {
            $startDate = $endDate->copy()->subDays(30);
        }
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dailySales = Sale::whereDate('date', $date->toDateString())->sum('total');
            $dailySalesTrend[] = [
                'date' => $date->toDateString(),
                'day' => $date->format('d'),
                'sales' => $dailySales
            ];
        }

        // ==================== MONTHLY SALES & EXPENSES TREND (Last 12 months) ====================
        $monthlyTrend = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $sales = Sale::whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('total');
            $expenses = Expense::whereMonth('date', $date->month)
                ->whereYear('date', $date->year)
                ->sum('amount');
            
            $monthlyTrend[] = [
                'month' => $date->format('M'),
                'sales' => $sales,
                'expenses' => $expenses
            ];
        }

        // ==================== BESTSELLING PRODUCTS (Filtered) ====================
        $bestsellingProducts = SaleItem::select('product_id', DB::raw('SUM(quantity * unit_price) as revenue'))
            ->with('product')
            ->whereHas('sale', function($q) use ($dateFrom, $dateTo) {
                $q->whereDate('date', '>=', $dateFrom)->whereDate('date', '<=', $dateTo);
            })
            ->groupBy('product_id')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        // ==================== TOP SALES CHANNELS (Filtered) ====================
        $topSalesChannels = Sale::select('sales_channel_id', DB::raw('SUM(total) as total_amount'))
            ->with('salesChannel')
            ->whereNotNull('sales_channel_id')
            ->whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->groupBy('sales_channel_id')
            ->orderBy('total_amount', 'desc')
            ->get();

        // ==================== EXPENSE DISTRIBUTION (Filtered) ====================
        $expenseDistribution = Expense::select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->whereNotNull('category_id')
            ->whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->groupBy('category_id')
            ->get();

        // ==================== RECENT SALES (Filtered) ====================
        $recentSales = Sale::with('customer', 'salesChannel')
            ->whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo)
            ->latest('date')
            ->take(10)
            ->get();

        // ==================== GENERAL STATS ====================
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();

        // ==================== GOAL NOTIFICATIONS ====================
        $goalNotifications = [];
        
        // Get active goals
        $activeGoals = Goal::where('business_id', $business->id)->active()->current()->get();
        
        foreach ($activeGoals as $goal) {
            $goal->updateProgress();
            
            // Check if goal just achieved (100% progress)
            if ($goal->progress_percentage >= 100 && $goal->status === 'completed') {
                $goalNotifications[] = [
                    'type' => 'success',
                    'icon' => 'mdi:trophy',
                    'title' => 'Goal Achieved!',
                    'message' => "Congratulations! You've completed: {$goal->name}",
                    'goal_id' => $goal->id
                ];
            }
            // Check if deadline approaching (within 3 days)
            elseif ($goal->getDaysRemaining() <= 3 && $goal->getDaysRemaining() > 0) {
                $goalNotifications[] = [
                    'type' => 'warning',
                    'icon' => 'mdi:clock-alert',
                    'title' => 'Deadline Approaching',
                    'message' => "{$goal->name} ends in {$goal->getDaysRemaining()} day(s). Current progress: " . number_format($goal->progress_percentage, 0) . "%",
                    'goal_id' => $goal->id
                ];
            }
            // Check if behind pace
            elseif (!$goal->isOnTrack() && $goal->progress_percentage < 100) {
                $goalNotifications[] = [
                    'type' => 'danger',
                    'icon' => 'mdi:alert-circle',
                    'title' => 'Goal Behind Pace',
                    'message' => "{$goal->name} is behind schedule. Current progress: " . number_format($goal->progress_percentage, 0) . "%",
                    'goal_id' => $goal->id
                ];
            }
        }

        return view('dashboard.index', compact(
            'business',
            // Date range
            'dateFrom',
            'dateTo',
            // Filtered metrics (based on date range)
            'filteredSales',
            'filteredExpenses',
            'filteredGrossProfit',
            'filteredItemsSold',
            // All-time
            'allTimeSales',
            'allTimeExpenses',
            'allTimeGrossProfit',
            'grossProfitMargin',
            // Today
            'salesToday',
            'expensesToday',
            'itemsSoldToday',
            // Monthly
            'monthlySales',
            'monthlyExpenses',
            'monthlyProfit',
            'monthlyItemsSold',
            // Targets
            'itemsSoldTarget',
            'salesTarget',
            'annualSalesTarget',
            'itemsSoldPercentage',
            'salesPercentage',
            'annualSalesPercentage',
            // Inventory
            'inStockProducts',
            'lowStockProducts',
            'outOfStockProducts',
            // Charts data
            'dailySalesTrend',
            'monthlyTrend',
            'bestsellingProducts',
            'topSalesChannels',
            'expenseDistribution',
            // Other
            'recentSales',
            'totalProducts',
            'totalCustomers',
            // Goal Notifications
            'goalNotifications'
        ));
    }
    
    public function index2()
    {
        return view('dashboard/index2');
    }
    
    public function index3()
    {
        return view('dashboard/index3');
    }
    
    public function index4()
    {
        return view('dashboard/index4');
    }
    
    public function index5()
    {
        return view('dashboard/index5');
    }
    
    public function index6()
    {
        return view('dashboard/index6');
    }
    
    public function index7()
    {
        return view('dashboard/index7');
    }
    
    public function index8()
    {
        return view('dashboard/index8');
    }
    
    public function index9()
    {
        return view('dashboard/index9');
    }
    
    public function index10()
    {
        return view('dashboard/index10');
    }

    
}
