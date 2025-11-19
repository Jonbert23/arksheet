<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Expense Report</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('reports.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Reports
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Expense Report</li>
            </ul>
        </div>

        <!-- Filters Card -->
        <div class="card mb-24 border-0 shadow-sm">
            <div class="card-body p-20">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Add Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn text-white d-flex align-items-center gap-2 fw-semibold radius-8 px-20 py-11 dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #ec3737; border: none; box-shadow: 0 2px 4px rgba(236, 55, 55, 0.2);" onmouseover="this.style.backgroundColor='#d42f2f'; this.style.boxShadow='0 4px 8px rgba(236, 55, 55, 0.3)'" onmouseout="this.style.backgroundColor='#ec3737'; this.style.boxShadow='0 2px 4px rgba(236, 55, 55, 0.2)'">
                                <i class="bi bi-circle-fill"></i>
                                <span>Add Filter</span>
                            </button>
                            <ul class="dropdown-menu radius-8 shadow border-0 mt-2" aria-labelledby="filterDropdown" style="min-width: 220px;">
                                <li>
                                    <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#dateRangeModal" style="transition: all 0.2s;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>Date Range</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#categoryFilterModal" style="transition: all 0.2s;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>Category</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Clear All Filters Button -->
                        @if(request()->has('date_from') || request()->has('category_id'))
                        <a href="{{ route('reports.expenses') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 radius-8 px-20 py-11">
                            <i class="bi bi-circle-fill"></i>
                            <span>Clear All Filters</span>
                        </a>
                        @endif
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->has('date_from') || request()->has('category_id'))
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-sm text-secondary-light fw-medium">Active Filters:</span>
                        @if(request('date_from'))
                            <span class="badge bg-primary-100 text-primary-600 px-12 py-6 d-inline-flex align-items-center gap-2" style="padding-right: 8px !important;">
                                <i class="bi bi-circle-fill"></i>
                                <span>{{ \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') }} - {{ \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') }}</span>
                                <a href="{{ route('reports.expenses', request()->except(['date_from', 'date_to'])) }}" class="text-primary-600 d-inline-flex align-items-center" style="text-decoration: none; margin-left: 4px;" title="Remove date filter">
                                    <i class="bi bi-circle-fill"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('category_id'))
                            <span class="badge bg-success-100 text-success-600 px-12 py-6 d-inline-flex align-items-center gap-2" style="padding-right: 8px !important;">
                                <i class="bi bi-circle-fill"></i>
                                <span>{{ $categories->firstWhere('id', request('category_id'))?->name }}</span>
                                <a href="{{ route('reports.expenses', request()->except('category_id')) }}" class="text-success-600 d-inline-flex align-items-center" style="text-decoration: none; margin-left: 4px;" title="Remove category filter">
                                    <i class="bi bi-circle-fill"></i>
                                </a>
                            </span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row gy-4 mb-24">
            <!-- Total Expenses -->
            <div class="col-lg-4 col-sm-6">
                <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Expenses</span>
                                    <h6 class="fw-bold" style="color: #ec3737;">{{ auth()->user()->business->currency }} {{ number_format($summary['total_expenses'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Transactions <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #ec3737;">{{ number_format($summary['total_transactions']) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-lg-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Transactions</span>
                                    <h6 class="fw-semibold">{{ number_format($summary['total_transactions']) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Average <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">{{ auth()->user()->business->currency }} {{ number_format($summary['average_expense'], 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Average Expense -->
            <div class="col-lg-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Average Expense</span>
                                    <h6 class="fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($summary['average_expense'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Per Transaction <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ $summary['total_transactions'] > 0 ? number_format(($summary['total_expenses'] / $summary['total_transactions']), 2) : '0.00' }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Expenses Trend -->
        <div class="card border-0 shadow-sm mb-24">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-2">
                    <div>
                        <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Daily Expenses Trend</h6>
                        <span class="text-sm fw-medium text-secondary-light">Expense performance overview</span>
                    </div>
                </div>
                <div id="dailyExpensesTrendChart" class="mt-20" style="min-height: 350px;"></div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="row gy-4 mb-24">
            <!-- Expenses by Category -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Expenses by Category</h6>
                        </div>
                        @if($expensesByCategory->isNotEmpty())
                        <div id="expensesByCategoryChart" class="mt-20" style="min-height: 280px;"></div>
                        <div class="mt-24">
                            @foreach($expensesByCategory->take(6) as $index => $expense)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#EA5455', '#FF9F43', '#28C76F', '#00CFE8', '#7367F0', '#FF6384'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $expense->name }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($expense->total_amount, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No category data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Expenses by Payment Method -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Expenses by Payment Method</h6>
                        </div>
                        @if($expensesByPayment->isNotEmpty())
                        <div id="expensesByPaymentChart" class="mt-20" style="min-height: 280px;"></div>
                        <div class="mt-24">
                            @foreach($expensesByPayment as $index => $payment)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#487FFF', '#45B369', '#FF9F43', '#EA5455', '#00CFE8', '#7367F0'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $payment->payment_method }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($payment->total_amount, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No payment data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Expenses Transactions Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-20">
                <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Expense Transactions</h6>
                <div class="dropdown">
                    <button class="btn text-white d-flex align-items-center gap-2 fw-semibold radius-8 px-20 py-11 dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #ec3737; border: none; box-shadow: 0 2px 4px rgba(236, 55, 55, 0.2);" onmouseover="this.style.backgroundColor='#d42f2f'; this.style.boxShadow='0 4px 8px rgba(236, 55, 55, 0.3)'" onmouseout="this.style.backgroundColor='#ec3737'; this.style.boxShadow='0 2px 4px rgba(236, 55, 55, 0.2)'">
                        <i class="bi bi-circle-fill"></i>
                        <span>Export</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end radius-8 shadow border-0 mt-2" aria-labelledby="exportDropdown" style="min-width: 180px;">
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToExcel(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-circle-fill"></i>
                                <span>Export to Excel</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToPDF(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-circle-fill"></i>
                                <span>Export to PDF</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToCSV(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-circle-fill"></i>
                                <span>Export to CSV</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="printTable(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-circle-fill"></i>
                                <span>Print</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="expenses-report-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Expense</th>
                                <th>Category</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->date->format('M d, Y') }}</td>
                                <td>{{ $expense->title }}</td>
                                <td>
                                    <span class="badge bg-success-100 text-success-600 px-12 py-4">
                                        {{ $expense->category ? $expense->category->name : 'N/A' }}
                                    </span>
                                </td>
                                <td>{{ $expense->payment_method ?? 'N/A' }}</td>
                                <td>
                                    @if($expense->status === 'fulfilled')
                                        <span class="badge bg-success-100 text-success-600 px-12 py-4">Fulfilled</span>
                                    @else
                                        <span class="badge bg-warning-100 text-warning-600 px-12 py-4">Unfulfilled</span>
                                    @endif
                                </td>
                                <td class="text-end fw-semibold" style="color: #ec3737;">{{ number_format($expense->amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-24">No expenses found for the selected period</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Filter Modal -->
    <div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="dateRangeModalLabel">
                        Filter by Date Range
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('reports.expenses') }}">
                    <div class="modal-body px-24 py-20">
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date From</label>
                                <input type="date" name="date_from" class="form-control radius-8" value="{{ request('date_from', $dateFrom) }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date To</label>
                                <input type="date" name="date_to" class="form-control radius-8" value="{{ request('date_to', $dateTo) }}" required>
                            </div>
                        </div>
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    </div>
                    <div class="modal-footer border-top px-24 py-16">
                        <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Category Filter Modal -->
    <div class="modal fade" id="categoryFilterModal" tabindex="-1" aria-labelledby="categoryFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="categoryFilterModalLabel">
                        Filter by Category
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('reports.expenses') }}">
                    <div class="modal-body px-24 py-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Select Category</label>
                        <select name="category_id" class="form-select radius-8" required>
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                        <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="modal-footer border-top px-24 py-16">
                        <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <style>
        /* Custom dropdown styling */
        #filterDropdown::after {
            margin-left: 8px;
        }
        
        .dropdown-menu .dropdown-item {
            border-radius: 6px;
            margin: 2px 8px;
            padding: 10px 16px;
        }
        
        .dropdown-menu .dropdown-item:hover {
            background-color: #fff5f5;
            color: #ec3737;
            transform: translateX(4px);
        }
        
        .dropdown-menu .dropdown-item:hover i {
            transform: scale(1.1);
        }
        
        .dropdown-menu {
            padding: 8px 0;
        }
        
        /* Active filter badges animation */
        .badge {
            animation: fadeInUp 0.3s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Filter badge close button hover effects */
        .badge a {
            transition: all 0.2s ease;
            opacity: 0.7;
        }
        
        .badge a:hover {
            opacity: 1;
            transform: scale(1.15);
        }
        
        .badge:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#expenses-report-table').DataTable({
                "pageLength": 25,
                "ordering": true,
                "searching": true,
                "info": true,
                "order": [[0, "desc"]],
                "language": {
                    "emptyTable": "No expenses found for the selected period"
                }
            });

            // Initialize Charts
            console.log('Charts initialization started');
            
            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded!');
                return;
            }

            // Daily Expenses Trend Chart
            @if(isset($dailyTrend) && count($dailyTrend) > 0)
            var dailyTrendOptions = {
                series: [{
                    name: "Expenses",
                    data: @json(array_column($dailyTrend, 'expenses'))
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
                        columnWidth: "40%",
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json(array_column($dailyTrend, 'date')),
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
                        },
                        formatter: function(val) {
                            return '{{ auth()->user()->business->currency }} ' + Math.round(val).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        }
                    }
                },
                colors: ["#ec3737"],
                grid: {
                    borderColor: "#E2E8F0",
                    strokeDashArray: 3,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return '{{ auth()->user()->business->currency }} ' + val.toFixed(2);
                        }
                    }
                }
            };
            var dailyTrendChart = new ApexCharts(document.querySelector("#dailyExpensesTrendChart"), dailyTrendOptions);
            dailyTrendChart.render();
            @endif

            // Expenses by Category Pie Chart
            @if($expensesByCategory->isNotEmpty())
            var categoryData = @json($expensesByCategory->take(6)->pluck('total_amount')->values()->toArray());
            var categoryLabels = @json($expensesByCategory->take(6)->pluck('name')->values()->toArray());
            
            var validCategoryData = [];
            var validCategoryLabels = [];
            
            for(var i = 0; i < categoryData.length; i++) {
                var value = parseFloat(categoryData[i]);
                if(!isNaN(value) && value > 0) {
                    validCategoryData.push(value);
                    validCategoryLabels.push(categoryLabels[i]);
                }
            }
            
            if(document.querySelector("#expensesByCategoryChart") && validCategoryData.length > 0) {
                var categoryOptions = {
                    series: validCategoryData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: validCategoryLabels,
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
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return '{{ auth()->user()->business->currency }} ' + val.toFixed(2);
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
                var categoryChart = new ApexCharts(document.querySelector("#expensesByCategoryChart"), categoryOptions);
                categoryChart.render();
            }
            @endif

            // Expenses by Payment Method Pie Chart
            @if($expensesByPayment->isNotEmpty())
            var paymentData = @json($expensesByPayment->pluck('total_amount')->values()->toArray());
            var paymentLabels = @json($expensesByPayment->pluck('payment_method')->values()->toArray());
            
            var validPaymentData = [];
            var validPaymentLabels = [];
            
            for(var i = 0; i < paymentData.length; i++) {
                var value = parseFloat(paymentData[i]);
                if(!isNaN(value) && value > 0) {
                    validPaymentData.push(value);
                    validPaymentLabels.push(paymentLabels[i]);
                }
            }
            
            if(document.querySelector("#expensesByPaymentChart") && validPaymentData.length > 0) {
                var paymentOptions = {
                    series: validPaymentData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: validPaymentLabels,
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
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return '{{ auth()->user()->business->currency }} ' + val.toFixed(2);
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
                var paymentChart = new ApexCharts(document.querySelector("#expensesByPaymentChart"), paymentOptions);
                paymentChart.render();
            }
            @endif
        });

        // Export Functions
        function exportToExcel() {
            var csv = tableToCSV($('#expenses-report-table'));
            downloadFile(csv, 'expenses-report.csv', 'text/csv');
        }

        function exportToPDF() {
            window.print();
        }

        function exportToCSV() {
            var csv = tableToCSV($('#expenses-report-table'));
            downloadFile(csv, 'expenses-report.csv', 'text/csv');
        }

        function printTable() {
            window.print();
        }

        function tableToCSV(table) {
            var csv = [];
            var rows = table.find('tr:visible');
            
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = $(rows[i]).find('td, th');
                
                for (var j = 0; j < cols.length; j++) {
                    var text = $(cols[j]).text().trim().replace(/"/g, '""');
                    row.push('"' + text + '"');
                }
                
                csv.push(row.join(','));
            }
            
            return csv.join('\n');
        }

        function downloadFile(content, fileName, mimeType) {
            var blob = new Blob([content], { type: mimeType });
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = fileName;
            link.click();
        }
    </script>
    @endpush

</x-layout.master>
