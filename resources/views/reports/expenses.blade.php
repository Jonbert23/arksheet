<x-layout.master>

    @push('styles')
    <style>
        /* Custom Select Dropdown - Match Customer Module */
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

        <!-- Filters Section -->
        <form method="GET" action="{{ route('reports.expenses') }}" id="expenseReportFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    formId="expenseReportFilterForm"
                    :dateFrom="request('date_from', now()->startOfMonth()->format('Y-m-d'))"
                    :dateTo="request('date_to', now()->format('Y-m-d'))"
                    :autoSubmit="false"
                />

                <!-- Category Filter -->
                <select name="category_id" class="form-select-custom">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>

        <!-- Summary Cards -->
        <div class="row gy-4 mb-24">
            <!-- Total Expenses -->
            <div class="col-lg-4 col-sm-6">
                <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-wallet2"></i>
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
                                    <i class="bi bi-list-ul"></i>
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
                                    <i class="bi bi-calculator"></i>
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
                        <i class="bi bi-download"></i>
                        <span>Export</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end radius-8 shadow border-0 mt-2" aria-labelledby="exportDropdown" style="min-width: 180px;">
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToExcel(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-file-earmark-excel"></i>
                                <span>Export to Excel</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToPDF(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-file-earmark-pdf"></i>
                                <span>Export to PDF</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="exportToCSV(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                <span>Export to CSV</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" onclick="printTable(); return false;" style="transition: all 0.2s;">
                                <i class="bi bi-printer"></i>
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

    @push('scripts')
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
