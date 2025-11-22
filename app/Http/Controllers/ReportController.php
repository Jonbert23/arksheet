<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ExpenseCategory;
use App\Models\SalesChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display the main reports page
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Sales Report
     */
    public function sales(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));
        $customerId = $request->input('customer_id');
        $channelId = $request->input('channel_id');

        $query = Sale::with(['customer', 'salesChannel', 'saleItems.product'])
            ->whereBetween('date', [$dateFrom, $dateTo]);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        if ($channelId) {
            $query->where('sales_channel_id', $channelId);
        }

        $sales = $query->latest('date')->get();

        // Calculate summary statistics
        $summary = [
            'total_sales' => $sales->sum('total'),
            'total_transactions' => $sales->count(),
            'average_sale' => $sales->count() > 0 ? $sales->sum('total') / $sales->count() : 0,
            'total_tax' => $sales->sum('tax'),
            'total_discount' => $sales->sum('discount'),
            'gross_sales' => $sales->sum('subtotal'),
        ];

        // Sales by payment status
        $paymentStatusBreakdown = [
            'paid' => $sales->where('payment_status', 'paid')->sum('total'),
            'partial' => $sales->where('payment_status', 'partial')->sum('total'),
            'pending' => $sales->where('payment_status', 'pending')->sum('total'),
        ];

        // Top products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.date', [$dateFrom, $dateTo])
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_quantity'), DB::raw('SUM(sale_items.total) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_revenue')
            ->limit(10)
            ->get();

        // Sales by channel
        $salesByChannel = DB::table('sales')
            ->join('sales_channels', 'sales.sales_channel_id', '=', 'sales_channels.id')
            ->whereBetween('sales.date', [$dateFrom, $dateTo])
            ->select('sales_channels.name', DB::raw('SUM(sales.total) as total_sales'), DB::raw('COUNT(sales.id) as transaction_count'))
            ->groupBy('sales_channels.id', 'sales_channels.name')
            ->orderByDesc('total_sales')
            ->get();

        // Daily sales trend
        $dailyTrend = [];
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);
        
        while ($start->lte($end)) {
            $dailySales = $sales->filter(function($sale) use ($start) {
                return $sale->date->format('Y-m-d') === $start->format('Y-m-d');
            })->sum('total');
            
            $dailyTrend[] = [
                'date' => $start->format('M d'),
                'sales' => $dailySales,
            ];
            
            $start->addDay();
        }

        $customers = Customer::active()->orderBy('name')->get();
        $channels = SalesChannel::active()->orderBy('name')->get();

        return view('reports.sales', compact('sales', 'summary', 'paymentStatusBreakdown', 'topProducts', 'salesByChannel', 'dailyTrend', 'dateFrom', 'dateTo', 'customers', 'channels'));
    }

    /**
     * Expenses Report
     */
    public function expenses(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));
        $categoryId = $request->input('category_id');

        $query = Expense::with('category')
            ->whereBetween('date', [$dateFrom, $dateTo]);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $expenses = $query->latest('date')->get();

        // Calculate summary statistics
        $summary = [
            'total_expenses' => $expenses->sum('amount'),
            'total_transactions' => $expenses->count(),
            'average_expense' => $expenses->count() > 0 ? $expenses->sum('amount') / $expenses->count() : 0,
        ];

        // Expenses by category
        $expensesByCategory = DB::table('expenses')
            ->join('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
            ->whereBetween('expenses.date', [$dateFrom, $dateTo])
            ->select('expense_categories.name', DB::raw('SUM(expenses.amount) as total_amount'), DB::raw('COUNT(expenses.id) as transaction_count'))
            ->groupBy('expense_categories.id', 'expense_categories.name')
            ->orderByDesc('total_amount')
            ->get();

        // Expenses by payment method
        $expensesByPayment = DB::table('expenses')
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->whereNotNull('payment_method')
            ->select('payment_method', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(id) as transaction_count'))
            ->groupBy('payment_method')
            ->orderByDesc('total_amount')
            ->get();

        // Daily expenses trend
        $dailyTrend = [];
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);
        
        while ($start->lte($end)) {
            $dailyExpenses = $expenses->filter(function($expense) use ($start) {
                return $expense->date->format('Y-m-d') === $start->format('Y-m-d');
            })->sum('amount');
            
            $dailyTrend[] = [
                'date' => $start->format('M d'),
                'expenses' => $dailyExpenses,
            ];
            
            $start->addDay();
        }

        $categories = ExpenseCategory::active()->orderBy('name')->get();

        return view('reports.expenses', compact('expenses', 'summary', 'expensesByCategory', 'expensesByPayment', 'dailyTrend', 'dateFrom', 'dateTo', 'categories'));
    }

    /**
     * Financial Report (Profit & Loss)
     */
    public function financial(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        // Revenue
        $sales = Sale::whereBetween('date', [$dateFrom, $dateTo])->get();
        $totalRevenue = $sales->sum('total');
        $totalTax = $sales->sum('tax');
        $totalDiscount = $sales->sum('discount');
        $grossRevenue = $sales->sum('subtotal');

        // Cost of Goods Sold (COGS)
        // Note: sale_items.cost already contains total cost (quantity * unit_cost), so we don't multiply by quantity again
        $cogs = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereBetween('sales.date', [$dateFrom, $dateTo])
            ->sum('sale_items.cost');

        // Expenses
        $totalExpenses = Expense::whereBetween('date', [$dateFrom, $dateTo])->sum('amount');

        // Calculations
        $grossProfit = $grossRevenue - $cogs;
        $grossProfitMargin = $grossRevenue > 0 ? ($grossProfit / $grossRevenue) * 100 : 0;
        
        $netProfit = $grossProfit - $totalExpenses;
        $netProfitMargin = $grossRevenue > 0 ? ($netProfit / $grossRevenue) * 100 : 0;

        // Expenses by category
        $expensesByCategory = DB::table('expenses')
            ->join('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
            ->whereBetween('expenses.date', [$dateFrom, $dateTo])
            ->select('expense_categories.name', DB::raw('SUM(expenses.amount) as total_amount'))
            ->groupBy('expense_categories.id', 'expense_categories.name')
            ->orderByDesc('total_amount')
            ->get();

        // Monthly trend (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            $monthRevenue = Sale::whereBetween('date', [$monthStart, $monthEnd])->sum('subtotal');
            $monthCogs = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->whereBetween('sales.date', [$monthStart, $monthEnd])
                ->sum('sale_items.cost');
            $monthExpenses = Expense::whereBetween('date', [$monthStart, $monthEnd])->sum('amount');
            
            $monthlyData[] = [
                'month' => $monthStart->format('M Y'),
                'revenue' => $monthRevenue,
                'cogs' => $monthCogs,
                'expenses' => $monthExpenses,
                'gross_profit' => $monthRevenue - $monthCogs,
                'net_profit' => $monthRevenue - $monthCogs - $monthExpenses,
            ];
        }

        // Daily financial trend
        $dailyTrend = [];
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);
        
        while ($start->lte($end)) {
            $dailyRevenue = $sales->filter(function($sale) use ($start) {
                return $sale->date->format('Y-m-d') === $start->format('Y-m-d');
            })->sum('subtotal');
            
            $dailyExpenses = Expense::where('date', $start->format('Y-m-d'))->sum('amount');
            
            $dailyCogs = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sales.date', $start->format('Y-m-d'))
                ->sum('sale_items.cost');
            
            $dailyProfit = $dailyRevenue - $dailyCogs - $dailyExpenses;
            
            $dailyTrend[] = [
                'date' => $start->format('M d'),
                'revenue' => $dailyRevenue,
                'expenses' => $dailyExpenses,
                'profit' => $dailyProfit,
            ];
            
            $start->addDay();
        }

        return view('reports.financial', compact(
            'totalRevenue', 
            'grossRevenue', 
            'totalTax', 
            'totalDiscount', 
            'cogs', 
            'grossProfit', 
            'grossProfitMargin',
            'totalExpenses',
            'netProfit',
            'netProfitMargin',
            'expensesByCategory',
            'monthlyData',
            'dailyTrend',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Product Performance Report
     */
    public function products(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        $products = Product::with(['category', 'saleItems' => function($query) use ($dateFrom, $dateTo) {
            $query->whereHas('sale', function($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('date', [$dateFrom, $dateTo]);
            });
        }])->get();

        $productsData = $products->map(function($product) use ($dateFrom, $dateTo) {
            $saleItems = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sale_items.product_id', $product->id)
                ->whereBetween('sales.date', [$dateFrom, $dateTo])
                ->select(
                    DB::raw('SUM(sale_items.quantity) as total_quantity'),
                    DB::raw('SUM(sale_items.total) as total_revenue'),
                    DB::raw('SUM(sale_items.profit) as total_profit')
                )
                ->first();

            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'category' => $product->category->name ?? 'N/A',
                'category_id' => $product->product_category_id,
                'current_stock' => $product->stock_quantity,
                'quantity_sold' => $saleItems->total_quantity ?? 0,
                'revenue' => $saleItems->total_revenue ?? 0,
                'profit' => $saleItems->total_profit ?? 0,
                'profit_margin' => $saleItems->total_revenue > 0 ? (($saleItems->total_profit ?? 0) / ($saleItems->total_revenue ?? 1)) * 100 : 0,
            ];
        })->sortByDesc('revenue');

        // Summary statistics
        $summary = [
            'total_products' => $productsData->count(),
            'total_revenue' => $productsData->sum('revenue'),
            'total_profit' => $productsData->sum('profit'),
            'total_units_sold' => $productsData->sum('quantity_sold'),
            'average_profit_margin' => $productsData->avg('profit_margin') ?? 0,
        ];

        // Sales by category
        $salesByCategory = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->whereBetween('sales.date', [$dateFrom, $dateTo])
            ->select(
                'product_categories.name',
                DB::raw('SUM(sale_items.total) as total_revenue'),
                DB::raw('SUM(sale_items.quantity) as total_quantity')
            )
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderByDesc('total_revenue')
            ->get();

        // Daily product sales trend
        $dailyTrend = [];
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);
        
        while ($start->lte($end)) {
            $dailySales = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sales.date', $start->format('Y-m-d'))
                ->sum('sale_items.total');
            
            $dailyTrend[] = [
                'date' => $start->format('M d'),
                'sales' => $dailySales,
            ];
            
            $start->addDay();
        }

        // Top performing products
        $topProducts = $productsData->take(10);

        return view('reports.products', compact('productsData', 'summary', 'salesByCategory', 'dailyTrend', 'topProducts', 'dateFrom', 'dateTo'));
    }

    /**
     * Customer Report
     */
    public function customers(Request $request)
    {
        $dateFrom = $request->input('date_from', Carbon::now()->startOfYear()->format('Y-m-d'));
        $dateTo = $request->input('date_to', Carbon::now()->format('Y-m-d'));

        $customers = Customer::with(['sales' => function($query) use ($dateFrom, $dateTo) {
            $query->whereBetween('date', [$dateFrom, $dateTo]);
        }])->get();

        $customersData = $customers->map(function($customer) {
            $sales = $customer->sales;
            
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'company' => $customer->company,
                'total_sales' => $sales->sum('total'),
                'transaction_count' => $sales->count(),
                'average_sale' => $sales->count() > 0 ? $sales->sum('total') / $sales->count() : 0,
                'last_purchase' => $sales->sortByDesc('date')->first()?->date?->format('M d, Y') ?? 'N/A',
            ];
        })->sortByDesc('total_sales');

        // Summary metrics
        $summary = [
            'total_customers' => $customersData->count(),
            'active_customers' => $customersData->filter(fn($c) => $c['transaction_count'] > 0)->count(),
            'total_revenue' => $customersData->sum('total_sales'),
            'total_transactions' => $customersData->sum('transaction_count'),
            'avg_transaction_value' => $customersData->sum('transaction_count') > 0 ? $customersData->sum('total_sales') / $customersData->sum('transaction_count') : 0,
        ];

        // Daily trend - customer transactions per day
        $dailyTrend = DB::table('sales')
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->selectRaw('DATE(date) as date, COUNT(DISTINCT customer_id) as customer_count, COUNT(*) as transaction_count, SUM(total) as revenue')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top customers by revenue
        $topCustomers = $customersData->take(10)->map(function($customer) {
            return [
                'name' => $customer['name'],
                'revenue' => $customer['total_sales']
            ];
        });

        // Customer segments by transaction count
        $customerSegments = [
            ['segment' => 'High Value (10+ purchases)', 'count' => $customersData->filter(fn($c) => $c['transaction_count'] >= 10)->count()],
            ['segment' => 'Medium Value (5-9 purchases)', 'count' => $customersData->filter(fn($c) => $c['transaction_count'] >= 5 && $c['transaction_count'] < 10)->count()],
            ['segment' => 'Low Value (1-4 purchases)', 'count' => $customersData->filter(fn($c) => $c['transaction_count'] >= 1 && $c['transaction_count'] < 5)->count()],
            ['segment' => 'Inactive (0 purchases)', 'count' => $customersData->filter(fn($c) => $c['transaction_count'] == 0)->count()],
        ];

        return view('reports.customers', compact(
            'customersData', 
            'dateFrom', 
            'dateTo',
            'summary',
            'dailyTrend',
            'topCustomers',
            'customerSegments'
        ));
    }
}
