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
    public function index()
    {
        $business = auth()->user()->business;
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $today = now()->toDateString();

        // ==================== ALL-TIME METRICS ====================
        $allTimeSales = Sale::sum('total');
        $allTimeExpenses = Expense::sum('amount');
        $allTimeGrossProfit = $allTimeSales - $allTimeExpenses;
        $grossProfitMargin = $allTimeSales > 0 ? round(($allTimeGrossProfit / $allTimeSales) * 100) : 0;

        // ==================== TODAY'S METRICS ====================
        $salesToday = Sale::whereDate('date', $today)->sum('total');
        $expensesToday = Expense::whereDate('date', $today)->sum('amount');
        $itemsSoldToday = SaleItem::whereHas('sale', function($q) use ($today) {
            $q->whereDate('date', $today);
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

        // ==================== TARGETS ====================
        $itemsSoldTarget = 500;
        $salesTarget = 500000;
        $annualSalesTarget = 6000000;
        
        $itemsSoldPercentage = $itemsSoldTarget > 0 ? round(($monthlyItemsSold / $itemsSoldTarget) * 100) : 0;
        $salesPercentage = $salesTarget > 0 ? round(($monthlySales / $salesTarget) * 100) : 0;
        $annualSalesPercentage = $annualSalesTarget > 0 ? round(($allTimeSales / $annualSalesTarget) * 100) : 0;

        // ==================== INVENTORY STATUS ====================
        $inStockProducts = Product::where('stock_quantity', '>', DB::raw('min_stock_alert'))->count();
        $lowStockProducts = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', DB::raw('min_stock_alert'))
            ->count();
        $outOfStockProducts = Product::where('stock_quantity', 0)->count();

        // ==================== DAILY SALES TREND (Last 31 days) ====================
        $dailySalesTrend = [];
        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dailySales = Sale::whereDate('date', $date)->sum('total');
            $dailySalesTrend[] = [
                'date' => $date,
                'day' => now()->subDays($i)->format('d'),
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

        // ==================== BESTSELLING PRODUCTS ====================
        $bestsellingProducts = SaleItem::select('product_id', DB::raw('SUM(quantity * unit_price) as revenue'))
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();

        // ==================== TOP SALES CHANNELS ====================
        $topSalesChannels = Sale::select('sales_channel_id', DB::raw('SUM(total) as total_amount'))
            ->with('salesChannel')
            ->whereNotNull('sales_channel_id')
            ->groupBy('sales_channel_id')
            ->orderBy('total_amount', 'desc')
            ->get();

        // ==================== EXPENSE DISTRIBUTION ====================
        $expenseDistribution = Expense::select('category_id', DB::raw('SUM(amount) as total'))
            ->with('expenseCategory')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->get();

        // ==================== RECENT SALES ====================
        $recentSales = Sale::with('customer', 'salesChannel')
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
