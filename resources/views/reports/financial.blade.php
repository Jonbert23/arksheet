<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Financial Statement (Profit & Loss)</h6>
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
                <li class="fw-medium">Financial Statement</li>
            </ul>
        </div>

        <!-- Filters Section -->
        <form method="GET" action="{{ route('reports.financial') }}" id="financialReportFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    formId="financialReportFilterForm"
                    :dateFrom="request('date_from', now()->startOfMonth()->format('Y-m-d'))"
                    :dateTo="request('date_to', now()->format('Y-m-d'))"
                    :autoSubmit="false"
                />

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>

        <!-- Summary Cards -->
        <div class="row gy-4 mb-24">
            <!-- Gross Revenue -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-graph-up"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Gross Revenue</span>
                                    <h6 class="fw-bold" style="color: #ec3737;">{{ auth()->user()->business->currency }} {{ number_format($grossRevenue, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Net <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #ec3737;">{{ auth()->user()->business->currency }} {{ number_format($totalRevenue, 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Gross Profit -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-trophy"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Gross Profit</span>
                                    <h6 class="fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($grossProfit, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Margin <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ number_format($grossProfitMargin, 1) }}%</span></p>
                    </div>
                </div>
            </div>

            <!-- Total Expenses -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-5">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-pink text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-wallet2"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Expenses</span>
                                    <h6 class="fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($totalExpenses, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">COGS <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">{{ auth()->user()->business->currency }} {{ number_format($cogs, 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 {{ $netProfit >= 0 ? 'bg-gradient-end-2' : 'bg-gradient-end-5' }}">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px {{ $netProfit >= 0 ? 'bg-success-main' : 'bg-danger-main' }} flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-cash-stack"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Net Profit</span>
                                    <h6 class="fw-semibold {{ $netProfit >= 0 ? 'text-success-main' : 'text-danger-main' }}">{{ auth()->user()->business->currency }} {{ number_format($netProfit, 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Margin <span class="{{ $netProfit >= 0 ? 'bg-success-focus text-success-main' : 'bg-danger-focus text-danger-main' }} px-1 rounded-2 fw-medium text-sm">{{ number_format($netProfitMargin, 1) }}%</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Financial Trend -->
        <div class="card border-0 shadow-sm mb-24">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-2">
                    <div>
                        <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Daily Financial Performance</h6>
                        <span class="text-sm fw-medium text-secondary-light">Revenue, Expenses & Profit overview</span>
                    </div>
                </div>
                <div id="dailyFinancialTrendChart" class="mt-20" style="min-height: 350px;"></div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="row gy-4 mb-24">
            <!-- Monthly Trend -->
            <div class="col-lg-12">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">6-Month Financial Trend</h6>
                        </div>
                        <div id="monthlyTrendChart" class="mt-20" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Expense Breakdown by Category</h6>
                        </div>
                        @if($expensesByCategory->isNotEmpty())
                        <div id="expenseBreakdownChart" class="mt-20" style="min-height: 280px;"></div>
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
                        <p class="text-center text-secondary-light mt-5">No expense data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Profit Analysis -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Profit Analysis</h6>
                        </div>
                        <div id="profitAnalysisChart" class="mt-20" style="min-height: 280px;"></div>
                        <div class="mt-24">
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: #45B369"></span>
                                    <span class="text-sm">Gross Profit</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($grossProfit, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: #EA5455"></span>
                                    <span class="text-sm">Total Expenses</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($totalExpenses, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: #487FFF"></span>
                                    <span class="text-sm">Net Profit</span>
                                </div>
                                <span class="text-sm fw-bold {{ $netProfit >= 0 ? 'text-success-main' : 'text-danger-main' }}">{{ number_format($netProfit, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Details Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-20">
                <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Financial Summary Details</h6>
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
            <div class="card-body p-24">
                <table class="table table-borderless" id="financial-summary-table">
                    <tbody>
                        <tr class="border-bottom">
                            <td class="py-16"><strong>Revenue</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="ps-24 py-12">Gross Sales</td>
                            <td class="text-end py-12">{{ auth()->user()->business->currency }} {{ number_format($grossRevenue, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="ps-24 py-12">Less: Discounts</td>
                            <td class="text-end py-12 text-danger-main">-{{ auth()->user()->business->currency }} {{ number_format($totalDiscount, 2) }}</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="ps-24 py-12">Tax Collected</td>
                            <td class="text-end py-12">{{ auth()->user()->business->currency }} {{ number_format($totalTax, 2) }}</td>
                        </tr>
                        <tr class="bg-light-subtle">
                            <td class="fw-bold py-16">Net Revenue</td>
                            <td class="text-end fw-bold py-16" style="color: #ec3737;">{{ auth()->user()->business->currency }} {{ number_format($totalRevenue, 2) }}</td>
                        </tr>
                        
                        <tr class="border-bottom">
                            <td class="py-16 pt-24"><strong>Cost of Goods Sold</strong></td>
                            <td class="text-end py-16 pt-24 text-danger-main">{{ auth()->user()->business->currency }} {{ number_format($cogs, 2) }}</td>
                        </tr>
                        
                        <tr class="bg-success-subtle">
                            <td class="fw-bold py-16"><strong>Gross Profit</strong></td>
                            <td class="text-end fw-bold py-16 text-success-main">{{ auth()->user()->business->currency }} {{ number_format($grossProfit, 2) }}</td>
                        </tr>
                        
                        <tr class="border-bottom">
                            <td class="py-16 pt-24"><strong>Operating Expenses</strong></td>
                            <td class="text-end py-16 pt-24 text-danger-main">{{ auth()->user()->business->currency }} {{ number_format($totalExpenses, 2) }}</td>
                        </tr>
                        
                        <tr class="bg-{{ $netProfit >= 0 ? 'success' : 'danger' }}-subtle">
                            <td class="fw-bold py-16"><strong>Net Profit</strong></td>
                            <td class="text-end fw-bold py-16 {{ $netProfit >= 0 ? 'text-success-main' : 'text-danger-main' }}">{{ auth()->user()->business->currency }} {{ number_format($netProfit, 2) }}</td>
                        </tr>
                        
                        <tr class="border-top border-2">
                            <td class="py-16 pt-20"><strong>Profit Margins</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="ps-24 py-12">Gross Profit Margin</td>
                            <td class="text-end py-12"><span class="badge bg-success-100 text-success-600 px-12 py-6">{{ number_format($grossProfitMargin, 2) }}%</span></td>
                        </tr>
                        <tr>
                            <td class="ps-24 py-12">Net Profit Margin</td>
                            <td class="text-end py-12"><span class="badge bg-{{ $netProfit >= 0 ? 'success' : 'danger' }}-100 text-{{ $netProfit >= 0 ? 'success' : 'danger' }}-600 px-12 py-6">{{ number_format($netProfitMargin, 2) }}%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            console.log('Financial charts initialization started');
            
            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded!');
                return;
            }

            // Daily Financial Trend Chart
            @if(isset($dailyTrend) && count($dailyTrend) > 0)
            var dailyFinancialOptions = {
                series: [
                    {
                        name: "Revenue",
                        data: @json(array_column($dailyTrend, 'revenue'))
                    },
                    {
                        name: "Expenses",
                        data: @json(array_column($dailyTrend, 'expenses'))
                    },
                    {
                        name: "Profit",
                        data: @json(array_column($dailyTrend, 'profit'))
                    }
                ],
                chart: {
                    type: "line",
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: "smooth",
                    width: 3,
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
                colors: ["#45B369", "#EA5455", "#487FFF"],
                legend: {
                    position: "top",
                    horizontalAlign: "right"
                },
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
            var dailyFinancialChart = new ApexCharts(document.querySelector("#dailyFinancialTrendChart"), dailyFinancialOptions);
            dailyFinancialChart.render();
            @endif

            // Monthly Trend Chart
            @if(isset($monthlyData) && count($monthlyData) > 0)
            var monthlyTrendOptions = {
                series: [
                    {
                        name: "Revenue",
                        data: @json(array_column($monthlyData, 'revenue'))
                    },
                    {
                        name: "Gross Profit",
                        data: @json(array_column($monthlyData, 'gross_profit'))
                    },
                    {
                        name: "Net Profit",
                        data: @json(array_column($monthlyData, 'net_profit'))
                    }
                ],
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
                        columnWidth: "60%",
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: @json(array_column($monthlyData, 'month')),
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
                colors: ["#487FFF", "#45B369", "#ec3737"],
                legend: {
                    position: "top",
                    horizontalAlign: "right"
                },
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
            var monthlyTrendChart = new ApexCharts(document.querySelector("#monthlyTrendChart"), monthlyTrendOptions);
            monthlyTrendChart.render();
            @endif

            // Expense Breakdown Pie Chart
            @if($expensesByCategory->isNotEmpty())
            var expenseData = @json($expensesByCategory->take(6)->pluck('total_amount')->values()->toArray());
            var expenseLabels = @json($expensesByCategory->take(6)->pluck('name')->values()->toArray());
            
            var validExpenseData = [];
            var validExpenseLabels = [];
            
            for(var i = 0; i < expenseData.length; i++) {
                var value = parseFloat(expenseData[i]);
                if(!isNaN(value) && value > 0) {
                    validExpenseData.push(value);
                    validExpenseLabels.push(expenseLabels[i]);
                }
            }
            
            if(document.querySelector("#expenseBreakdownChart") && validExpenseData.length > 0) {
                var expenseOptions = {
                    series: validExpenseData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: validExpenseLabels,
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
                var expenseChart = new ApexCharts(document.querySelector("#expenseBreakdownChart"), expenseOptions);
                expenseChart.render();
            }
            @endif

            // Profit Analysis Pie Chart
            if(document.querySelector("#profitAnalysisChart")) {
                var profitData = [
                    {{ $grossProfit }},
                    {{ $totalExpenses }},
                    {{ abs($netProfit) }}
                ];
                
                var profitOptions = {
                    series: profitData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: ["Gross Profit", "Total Expenses", "Net Profit"],
                    colors: ["#45B369", "#EA5455", "#487FFF"],
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
                var profitChart = new ApexCharts(document.querySelector("#profitAnalysisChart"), profitOptions);
                profitChart.render();
            }
        });

        // Export Functions
        function exportToExcel() {
            var csv = tableToCSV($('#financial-summary-table'));
            downloadFile(csv, 'financial-statement.csv', 'text/csv');
        }

        function exportToPDF() {
            window.print();
        }

        function exportToCSV() {
            var csv = tableToCSV($('#financial-summary-table'));
            downloadFile(csv, 'financial-statement.csv', 'text/csv');
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
