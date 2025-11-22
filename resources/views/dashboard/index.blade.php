<x-layout.master>

    @push('styles')
    <style>
        /* Custom Select Dropdown Styling */
        .form-select-custom {
            width: 220px;
            height: 42px;
            padding: 12px 36px 12px 16px;
            border: none;
            background-color: #ffffff;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #1f2937;
            cursor: pointer;
            outline: none;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%231f2937' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }
        
        .form-select-custom:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .form-select-custom:focus {
            box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1);
        }
    </style>
    @endpush

    <div class="dashboard-main-body">
        
        <!-- Date Range Filter -->
        <form method="GET" action="{{ route('dashboard') }}" id="dashboardFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    form-id="dashboardFilterForm"
                    :date-from="$dateFrom"
                    :date-to="$dateTo"
                    :auto-submit="false"
                />

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>
        
        <!-- Goal Notifications -->
        @if(!empty($goalNotifications))
        <div class="mb-24">
            @foreach($goalNotifications as $notification)
            <div class="alert alert-{{ $notification['type'] }} alert-dismissible fade show d-flex align-items-center gap-3 border-0 shadow-sm radius-8 mb-16" role="alert" style="border-left: 4px solid {{ $notification['type'] === 'success' ? '#10b981' : ($notification['type'] === 'warning' ? '#f59e0b' : '#ef4444') }} !important;">
                <i class="bi bi-circle-fill"></i>
                <div class="flex-grow-1">
                    <h6 class="fw-bold mb-4">{{ $notification['title'] }}</h6>
                    <p class="mb-0 text-sm">{{ $notification['message'] }}</p>
                </div>
                <a href="{{ route('goals.index') }}" class="btn btn-sm text-white radius-8 px-16 py-8" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    View Goals
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="row gy-4">
            <!-- Stats Cards Row -->
            <div class="col-xxl-8">
                <div class="row gy-4">
                    
                    <!-- Gross Profit (Filtered) -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                            <i class="bi bi-cash-stack"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Gross Profit</span>
                                            <h6 class="fw-bold" style="color: #ec3737;">{{ $business->currency }} {{ number_format($filteredGrossProfit, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Margin <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #ec3737;">{{ $grossProfitMargin }}%</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Sales (Filtered) -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Total Sales</span>
                                            <h6 class="fw-semibold">{{ $business->currency }} {{ number_format($filteredSales, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Selected Period</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Sold (Filtered) -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="bi bi-tag-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Items Sold</span>
                                            <h6 class="fw-semibold">{{ number_format($filteredItemsSold) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Selected Period</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Products -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="bi bi-box-seam-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Products</span>
                                            <h6 class="fw-semibold">{{ number_format($totalProducts) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Low Stock <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">{{ $lowStockProducts }}</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Expenses (Filtered) -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="bi bi-wallet2"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Expenses</span>
                                            <h6 class="fw-semibold">{{ $business->currency }} {{ number_format($filteredExpenses, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Selected Period</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Customers -->
                    <div class="col-xxl-4 col-sm-6">
                        <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="bi bi-people-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-2 fw-medium text-secondary-light text-sm">Customers</span>
                                            <h6 class="fw-semibold">{{ number_format($totalCustomers) }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm mb-0">Profit <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ $business->currency }} {{ number_format($monthlyProfit, 2) }}</span></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Monthly Sales Target -->
            <div class="col-xxl-4">
                <div class="card h-100 radius-8 border-0 shadow-sm" style="border-top: 3px solid #ec3737 !important;">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <div>
                                <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Sales Target</h6>
                                <span class="text-sm fw-medium text-secondary-light">{{ $business->name }}</span>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-2 fw-bold text-lg">{{ $business->currency }} {{ number_format($filteredSales, 2) }}</h6>
                                <span class="ps-12 pe-12 pt-2 pb-2 rounded-2 fw-bold text-white text-sm" style="background-color: #ec3737;">{{ $salesPercentage }}%</span>
                            </div>
                        </div>
                        <div id="revenueChart" class="mt-28"></div>
                        
                        <div class="mt-20">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                <div class="d-flex align-items-center">
                                    <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0" style="color: #ec3737;">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                    <span class="text-primary-light fw-medium text-sm ps-12">Sales Target</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 w-100">
                                    <div class="w-100 max-w-66 ms-auto">
                                        <div class="progress progress-sm rounded-pill" role="progressbar" style="background-color: #fff5f5;">
                                            <div class="progress-bar rounded-pill" style="width: {{ min($salesPercentage, 100) }}%; background-color: #ec3737;"></div>
                                        </div>
                                    </div>
                                    <span class="text-secondary-light font-xs fw-bold">{{ $salesPercentage }}%</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between gap-3">
                                <div class="d-flex align-items-center">
                                    <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                        <i class="bi bi-circle-fill"></i>
                                    </span>
                                    <span class="text-primary-light fw-medium text-sm ps-12">Items Target</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 w-100">
                                    <div class="w-100 max-w-66 ms-auto">
                                        <div class="progress progress-sm rounded-pill" role="progressbar">
                                            <div class="progress-bar bg-success-main rounded-pill" style="width: {{ min($itemsSoldPercentage, 100) }}%;"></div>
                                        </div>
                                    </div>
                                    <span class="text-secondary-light font-xs fw-semibold">{{ $itemsSoldPercentage }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Sales Trend -->
            <div class="col-xxl-8">
                <div class="card h-100 radius-8 border-0 shadow-sm" style="border-top: 3px solid #ec3737 !important;">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-2">
                            <div>
                                <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Daily Sales Trend</h6>
                                <span class="text-sm fw-medium text-secondary-light">Last 30 days overview</span>
                            </div>
                            <div class="">
                                <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                    <option>Last 30 Days</option>
                                    <option>Last 7 Days</option>
                                    <option>This Month</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-20 d-flex justify-content-center flex-wrap gap-3">
                            <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Peak Day</span>
                                    <h6 class="text-md fw-semibold mb-0">{{ $business->currency }} {{ number_format(collect($dailySalesTrend)->max('sales'), 2) }}</h6>
                                </div>
                            </div>

                            <div class="d-inline-flex align-items-center gap-2 p-2 radius-8 border pe-36 br-hover-primary group-item">
                                <span class="bg-neutral-100 w-44-px h-44-px text-xxl radius-8 d-flex justify-content-center align-items-center text-secondary-light group-hover:bg-primary-600 group-hover:text-white">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="text-secondary-light text-sm fw-medium">Average</span>
                                    <h6 class="text-md fw-semibold mb-0">{{ $business->currency }} {{ number_format(collect($dailySalesTrend)->avg('sales'), 2) }}</h6>
                                </div>
                            </div>
                        </div>

                        <div id="dailySalesChart" class="mt-20"></div>
                    </div>
                </div>
            </div>

            <!-- Inventory & Targets -->
            <div class="col-xxl-4">
                <div class="row gy-4">
                    <!-- Inventory Status -->
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Inventory</h6>
                                    <a href="{{ route('products.index') }}" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                                        View All
                                        <i class="bi bi-arrow-right class="icon""></i>
                                    </a>
                                </div>

                                <div class="mt-3">
                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-success-main">
                                                <i class="bi bi-circle-fill"></i>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">In Stock</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar">
                                                    <div class="progress-bar bg-success-main rounded-pill" style="width: {{ $totalProducts > 0 ? ($inStockProducts / $totalProducts) * 100 : 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">{{ $inStockProducts }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-warning-main">
                                                <i class="bi bi-circle-fill"></i>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Low Stock</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar">
                                                    <div class="progress-bar bg-warning-main rounded-pill" style="width: {{ $totalProducts > 0 ? ($lowStockProducts / $totalProducts) * 100 : 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">{{ $lowStockProducts }}</span>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between gap-3">
                                        <div class="d-flex align-items-center">
                                            <span class="text-xxl line-height-1 d-flex align-content-center flex-shrink-0 text-danger-main">
                                                <i class="bi bi-circle-fill"></i>
                                            </span>
                                            <span class="text-primary-light fw-medium text-sm ps-12">Out of Stock</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 w-100">
                                            <div class="w-100 max-w-66 ms-auto">
                                                <div class="progress progress-sm rounded-pill" role="progressbar">
                                                    <div class="progress-bar bg-danger-main rounded-pill" style="width: {{ $totalProducts > 0 ? ($outOfStockProducts / $totalProducts) * 100 : 0 }}%;"></div>
                                                </div>
                                            </div>
                                            <span class="text-secondary-light font-xs fw-semibold">{{ $outOfStockProducts }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Annual Target -->
                    <div class="col-xxl-12 col-sm-6">
                        <div class="card h-100 radius-8 border-0 overflow-hidden">
                            <div class="card-body p-24">
                                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                    <h6 class="mb-2 fw-bold text-lg">Annual Target</h6>
                                </div>

                                <div class="d-flex flex-wrap align-items-center mt-3">
                                    <ul class="flex-shrink-0">
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Current: {{ $business->currency }} {{ number_format($allTimeSales, 0) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2 mb-28">
                                            <span class="w-12-px h-12-px rounded-circle bg-warning-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Goal: {{ $business->currency }} {{ number_format($annualSalesTarget, 0) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center gap-2">
                                            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                                            <span class="text-secondary-light text-sm fw-medium">Progress: {{ $annualSalesPercentage }}%</span>
                                        </li>
                                    </ul>
                                    <div id="annualTargetChart" class="flex-grow-1 apexcharts-tooltip-z-none title-style circle-none"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Sales Channels (Pie Chart) -->
            <div class="col-xxl-6">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg">Top Sales Channels</h6>
                        </div>
                        @if($topSalesChannels->isNotEmpty())
                        <div id="salesChannelChart" class="mt-20"></div>
                        <div class="mt-24">
                            @foreach($topSalesChannels as $index => $channel)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#487FFF', '#45B369', '#FF9F43', '#EA5455', '#00CFE8', '#7367F0'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $channel->salesChannel ? $channel->salesChannel->name : 'N/A' }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ $business->currency }} {{ number_format($channel->total_amount, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No sales channels data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Expense Distribution (Pie Chart) -->
            <div class="col-xxl-6">
                <div class="card h-100 radius-8 border-0">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg">Expense Distribution</h6>
                        </div>
                        @if($expenseDistribution->isNotEmpty())
                        <div id="expenseChart" class="mt-20"></div>
                        <div class="mt-24">
                            @foreach($expenseDistribution as $index => $expense)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#EA5455', '#FF9F43', '#28C76F', '#00CFE8', '#7367F0', '#FF6384'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $expense->expenseCategory ? $expense->expenseCategory->name : 'Uncategorized' }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ $business->currency }} {{ number_format($expense->total, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No expense data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bestselling Products -->
            <div class="col-xxl-12">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white py-16 px-24 d-flex align-items-center justify-content-between">
                        <h6 class="text-lg fw-bold mb-0" style="color: #ec3737;">Bestselling Products</h6>
                        <a href="{{ route('products.index') }}" class="fw-bold d-flex align-items-center gap-1" style="color: #ec3737; text-decoration: none;" onmouseover="this.style.color='#d42f2f'" onmouseout="this.style.color='#ec3737'">
                            View All
                            <i class="bi bi-arrow-right class="icon""></i>
                        </a>
                    </div>
                    <div class="card-body p-24">
                        <div class="table-responsive scroll-sm">
                            <table class="table bordered-table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Product Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Revenue</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bestsellingProducts as $item)
                                    <tr>
                                        <td>
                                            <div>
                                                <span class="text-md d-block line-height-1 fw-medium text-primary-light text-w-200-px">{{ $item->product ? $item->product->name : 'N/A' }}</span>
                                                <span class="text-sm d-block fw-normal text-secondary-light">{{ $item->product ? $item->product->sku : '' }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $item->product && $item->product->category ? $item->product->category->name : 'N/A' }}</td>
                                        <td>{{ $business->currency }} {{ $item->product ? number_format($item->product->price, 2) : '0.00' }}</td>
                                        <td><span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">{{ $business->currency }} {{ number_format($item->revenue, 2) }}</span></td>
                                        <td>{{ $item->product ? $item->product->stock_quantity : 0 }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No sales data available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <x-script/>
    
    <script>
        window.addEventListener('load', function() {
        // Check if ApexCharts is loaded
        if (typeof ApexCharts === 'undefined') {
            console.error('ApexCharts is not loaded!');
            return;
        }
        
        // Revenue Chart (Monthly Target)
        var revenueOptions = {
            series: [{
                name: "Sales",
                data: [{{ implode(',', array_column($dailySalesTrend, 'sales')) }}]
            }],
            chart: {
                type: "area",
                height: 100,
                sparkline: {
                    enabled: true
                }
            },
            stroke: {
                curve: "smooth",
                width: 2,
                colors: ["#487FFF"]
            },
            fill: {
                type: "gradient",
                gradient: {
                    shade: "light",
                    type: "vertical",
                    shadeIntensity: 0.5,
                    gradientToColors: ["#487FFF"],
                    inverseColors: false,
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                }
            },
            tooltip: {
                enabled: true
            }
        };
        var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
        revenueChart.render();

        // Daily Sales Chart
        var dailySalesOptions = {
            series: [{
                name: "Sales",
                data: @json(array_column($dailySalesTrend, 'sales'))
            }],
            chart: {
                type: "bar",
                height: 350,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: "20%",
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: @json(array_column($dailySalesTrend, 'day')),
                labels: {
                    style: {
                        colors: "#A0AEC0",
                        fontSize: "12px"
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: "#A0AEC0",
                        fontSize: "12px"
                    }
                }
            },
            colors: ["#487FFF"],
            grid: {
                borderColor: "#E2E8F0",
                strokeDashArray: 3,
            }
        };
        var dailySalesChart = new ApexCharts(document.querySelector("#dailySalesChart"), dailySalesOptions);
        dailySalesChart.render();

        // Annual Target Donut Chart
        var annualTargetOptions = {
            series: [{{ $annualSalesPercentage }}, {{ 100 - $annualSalesPercentage }}],
            chart: {
                height: 200,
                type: "donut",
            },
            labels: ["Achieved", "Remaining"],
            colors: ["#45B369", "#F4F7FE"],
            legend: {
                show: false
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "70%",
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: "Progress",
                                fontSize: "14px",
                                color: "#A0AEC0",
                                formatter: function (w) {
                                    return "{{ $annualSalesPercentage }}%"
                                }
                            }
                        }
                    }
                }
            }
        };
        var annualTargetChart = new ApexCharts(document.querySelector("#annualTargetChart"), annualTargetOptions);
        annualTargetChart.render();

        // Sales Channels Pie Chart
        @if($topSalesChannels->isNotEmpty())
        if(document.querySelector("#salesChannelChart")) {
            var salesChannelOptions = {
                series: @json($topSalesChannels->pluck('total_amount')->values()->toArray()),
                chart: {
                    height: 280,
                    type: "pie",
                },
                labels: @json($topSalesChannels->map(function($channel) {
                    return $channel->salesChannel ? $channel->salesChannel->name : 'N/A';
                })->values()->toArray()),
                colors: ["#487FFF", "#45B369", "#FF9F43", "#EA5455", "#00CFE8", "#7367F0"],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return Math.round(val) + "%"
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "0%"
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        }
                    }
                }]
            };
            var salesChannelChart = new ApexCharts(document.querySelector("#salesChannelChart"), salesChannelOptions);
            salesChannelChart.render();
        }
        @endif

        // Expense Distribution Pie Chart
        @if($expenseDistribution->isNotEmpty())
        if(document.querySelector("#expenseChart")) {
            var expenseOptions = {
                series: @json($expenseDistribution->pluck('total')->values()->toArray()),
                chart: {
                    height: 280,
                    type: "pie",
                },
                labels: @json($expenseDistribution->map(function($expense) {
                    return $expense->expenseCategory ? $expense->expenseCategory->name : 'Uncategorized';
                })->values()->toArray()),
                colors: ["#EA5455", "#FF9F43", "#28C76F", "#00CFE8", "#7367F0", "#FF6384"],
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return Math.round(val) + "%"
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "0%"
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        }
                    }
                }]
            };
            var expenseChart = new ApexCharts(document.querySelector("#expenseChart"), expenseOptions);
            expenseChart.render();
        }
        @endif
        }); // End window.load
    </script>

    <style>
        /* Brand Color Focus States */
        .form-control:focus,
        .form-select:focus {
            border-color: #ec3737 !important;
            box-shadow: 0 0 0 0.2rem rgba(236, 55, 55, 0.15) !important;
        }
        
        /* Chart primary colors */
        .apexcharts-tooltip-series-group .apexcharts-tooltip-marker {
            background-color: #ec3737 !important;
        }
        
        /* Hover effects for stat cards */
        .card:hover {
            transform: translateY(-2px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        /* Link hover effects */
        a:hover {
            transition: color 0.2s ease;
        }
        
        /* Table row hover */
        .table tbody tr:hover {
            background-color: #fff5f5 !important;
            transition: background-color 0.2s ease;
        }
        
        /* Progress bars smooth animation */
        .progress-bar {
            transition: width 0.6s ease;
        }
        
        /* Smooth transitions for cards */
        .card {
            transition: all 0.3s ease;
        }
        
        /* Brand colored elements */
        .text-primary-600 {
            color: #ec3737 !important;
        }
        
        .bg-primary-600 {
            background-color: #ec3737 !important;
        }
        
        .border-primary {
            border-color: #ec3737 !important;
        }
    </style>

</x-layout.master>
