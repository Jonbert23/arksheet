<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Customer Report</h6>
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
                <li class="fw-medium">Customer Report</li>
            </ul>
        </div>

        <!-- Filters -->
        <div class="card mb-24 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Add Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" 
                                    style="background-color: #ec3737;" 
                                    onmouseover="this.style.backgroundColor='#d42f2f'" 
                                    onmouseout="this.style.backgroundColor='#ec3737'"
                                    type="button" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                <i class="bi bi-circle-fill"></i>
                                Add Filter
                            </button>
                            <ul class="dropdown-menu" style="min-width: 200px;">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#dateRangeModal">
                                        <i class="bi bi-circle-fill"></i>
                                        Date Range
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Clear All Filters -->
                        <a href="{{ route('reports.customers') }}" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2">
                            <i class="bi bi-circle-fill"></i>
                            Clear All Filters
                        </a>
                    </div>

                    <!-- Active Filters Display -->
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        @if($dateFrom != \Carbon\Carbon::now()->startOfYear()->format('Y-m-d') || $dateTo != \Carbon\Carbon::now()->format('Y-m-d'))
                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded" style="background-color: #fef2f2; border: 1px solid #fecaca;">
                                <i class="bi bi-circle-fill"></i>
                                <span class="text-sm" style="color: #991b1b;">{{ $dateFrom }} to {{ $dateTo }}</span>
                                <a href="{{ route('reports.customers') }}" class="text-decoration-none" style="color: #991b1b;">
                                    <i class="bi bi-circle-fill"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard-style Metrics -->
        <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4 mb-24">
            <div class="col">
                <div class="card shadow-none border bg-gradient-start-1 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Customers</p>
                                <h6 class="mb-0">{{ number_format($summary['total_customers']) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-2 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Active Customers</p>
                                <h6 class="mb-0">{{ number_format($summary['active_customers']) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-3 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Revenue</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($summary['total_revenue'], 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-4 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Transactions</p>
                                <h6 class="mb-0">{{ number_format($summary['total_transactions']) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-none border bg-gradient-start-5 h-100">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Avg. Transaction</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($summary['avg_transaction_value'], 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Customer Activity Trend -->
        <div class="card border-0 shadow-sm mb-24">
            <div class="card-header bg-white">
                <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Daily Customer Activity</h6>
            </div>
            <div class="card-body">
                <div id="dailyCustomerTrendChart" style="min-height: 350px;"></div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row gy-4 mb-24">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Top 10 Customers by Revenue</h6>
                    </div>
                    <div class="card-body">
                        <div id="topCustomersChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Customer Segments</h6>
                    </div>
                    <div class="card-body">
                        <div id="customerSegmentsChart" style="min-height: 350px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Purchase Analysis Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Customer Purchase Analysis</h6>
                
                <!-- Export Dropdown -->
                <div class="dropdown">
                    <button class="btn text-white radius-8 px-16 py-8 d-flex align-items-center gap-2" 
                            style="background-color: #ec3737;" 
                            onmouseover="this.style.backgroundColor='#d42f2f'" 
                            onmouseout="this.style.backgroundColor='#ec3737'"
                            type="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                        <i class="bi bi-circle-fill"></i>
                        Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" onclick="exportTableToExcel('customers-report-table', 'Customer_Report'); return false;">
                                <i class="bi bi-circle-fill"></i>
                                Export to Excel
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" onclick="exportTableToPDF('Customer Report', 'customers-report-table'); return false;">
                                <i class="bi bi-circle-fill"></i>
                                Export to PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" onclick="exportTableToCSV('customers-report-table', 'Customer_Report.csv'); return false;">
                                <i class="bi bi-circle-fill"></i>
                                Export to CSV
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#" onclick="window.print(); return false;">
                                <i class="bi bi-circle-fill"></i>
                                Print
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="customers-report-table">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th class="text-center">Transactions</th>
                                <th class="text-end">Total Sales</th>
                                <th class="text-end">Avg. Sale</th>
                                <th>Last Purchase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customersData as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="w-40-px h-40-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                            <span class="text-white fw-semibold">{{ strtoupper(substr($customer['name'], 0, 1)) }}</span>
                                        </div>
                                        <span class="fw-semibold">{{ $customer['name'] }}</span>
                                    </div>
                                </td>
                                <td>{{ $customer['email'] ?? '-' }}</td>
                                <td>{{ $customer['phone'] ?? '-' }}</td>
                                <td>{{ $customer['company'] ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary-100 text-primary-600 px-12 py-6">
                                        {{ number_format($customer['transaction_count']) }}
                                    </span>
                                </td>
                                <td class="text-end fw-semibold" style="color: #ec3737;">
                                    {{ number_format($customer['total_sales'], 2) }}
                                </td>
                                <td class="text-end">{{ number_format($customer['average_sale'], 2) }}</td>
                                <td>
                                    <span class="badge bg-neutral-200 text-neutral-600 px-12 py-6">
                                        {{ $customer['last_purchase'] }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-24">
                                    <i class="bi bi-circle-fill"></i>
                                    <p class="text-secondary-light mb-0">No customer data available for the selected period</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Filter Modal -->
    <div class="modal fade" id="dateRangeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-circle-fill"></i>
                        Filter by Date Range
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="GET" action="{{ route('reports.customers') }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $dateFrom }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $dateTo }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn text-white" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            Apply Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Export Functions
        function exportTableToExcel(tableId, filename = 'export') {
            const table = document.getElementById(tableId);
            const workbook = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
            XLSX.writeFile(workbook, filename + '.xlsx');
        }

        function exportTableToCSV(tableId, filename) {
            const table = document.getElementById(tableId);
            const rows = table.querySelectorAll('tr');
            let csv = [];
            
            for (let row of rows) {
                let cols = row.querySelectorAll('td, th');
                let csvRow = [];
                for (let col of cols) {
                    csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
                }
                csv.push(csvRow.join(','));
            }
            
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.click();
            window.URL.revokeObjectURL(url);
        }

        function exportTableToPDF(title, tableId) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            
            doc.setFontSize(18);
            doc.text(title, 14, 15);
            
            doc.autoTable({
                html: '#' + tableId,
                startY: 25,
                theme: 'grid',
                styles: { fontSize: 8 },
                headStyles: { fillColor: [236, 55, 55] }
            });
            
            doc.save(title + '.pdf');
        }

        $(document).ready(function() {
            console.log('Initializing Customer Report...');

            // Initialize DataTable
            $('#customers-report-table').DataTable({
                "pageLength": 25,
                "ordering": true,
                "searching": true,
                "info": true,
                "order": [[5, "desc"]], // Sort by total sales descending
                "columnDefs": [
                    {
                        "targets": [4], // Transactions column
                        "className": "text-center"
                    },
                    {
                        "targets": [5, 6], // Total Sales, Avg Sale columns
                        "className": "text-end"
                    }
                ],
                "language": {
                    "emptyTable": "No customer data available for the selected period"
                }
            });

            // Daily Customer Activity Trend Chart
            const dailyTrendData = @json($dailyTrend);
            console.log('Daily Trend Data:', dailyTrendData);

            const dailyTrendDates = dailyTrendData.map(item => item.date);
            const dailyTrendCustomers = dailyTrendData.map(item => parseInt(item.customer_count) || 0);
            const dailyTrendTransactions = dailyTrendData.map(item => parseInt(item.transaction_count) || 0);

            const dailyTrendOptions = {
                series: [
                    {
                        name: 'Active Customers',
                        data: dailyTrendCustomers
                    },
                    {
                        name: 'Transactions',
                        data: dailyTrendTransactions
                    }
                ],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: false,
                            reset: true
                        }
                    }
                },
                colors: ['#ec3737', '#f59e0b'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.6,
                        opacityTo: 0.1
                    }
                },
                xaxis: {
                    categories: dailyTrendDates,
                    title: {
                        text: 'Date'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Count'
                    },
                    min: 0,
                    forceNiceScale: true,
                    labels: {
                        formatter: function(val) {
                            return Number(val).toLocaleString('en-US', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        }
                    }
                },
                grid: {
                    borderColor: '#f1f1f1'
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function(val) {
                            return Number(val).toLocaleString('en-US');
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                }
            };

            const dailyTrendChart = new ApexCharts(document.querySelector("#dailyCustomerTrendChart"), dailyTrendOptions);
            dailyTrendChart.render();

            // Top Customers Pie Chart
            const topCustomersData = @json($topCustomers);
            console.log('Top Customers Data:', topCustomersData);

            const topCustomersLabels = topCustomersData.map(item => item.name);
            const topCustomersSeries = topCustomersData.map(item => parseFloat(item.revenue) || 0);

            // Filter out NaN, zero, and negative values
            const validTopCustomersData = topCustomersLabels.reduce((acc, label, index) => {
                const value = topCustomersSeries[index];
                if (!isNaN(value) && value > 0) {
                    acc.labels.push(label);
                    acc.series.push(value);
                }
                return acc;
            }, { labels: [], series: [] });

            console.log('Valid Top Customers Data:', validTopCustomersData);

            if (validTopCustomersData.series.length > 0) {
                const topCustomersOptions = {
                    series: validTopCustomersData.series,
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    labels: validTopCustomersData.labels,
                    colors: ['#ec3737', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#f97316', '#14b8a6', '#a855f7', '#06b6d4'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return val.toFixed(1) + '%';
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return '{{ auth()->user()->business->currency }} ' + Number(val).toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                };

                const topCustomersChart = new ApexCharts(document.querySelector("#topCustomersChart"), topCustomersOptions);
                topCustomersChart.render();
            } else {
                document.querySelector("#topCustomersChart").innerHTML = '<div class="text-center py-5"><p class="text-muted">No data available</p></div>';
            }

            // Customer Segments Pie Chart
            const customerSegmentsData = @json($customerSegments);
            console.log('Customer Segments Data:', customerSegmentsData);

            const segmentLabels = customerSegmentsData.map(item => item.segment);
            const segmentSeries = customerSegmentsData.map(item => parseInt(item.count) || 0);

            // Filter out zero values
            const validSegmentsData = segmentLabels.reduce((acc, label, index) => {
                const value = segmentSeries[index];
                if (!isNaN(value) && value > 0) {
                    acc.labels.push(label);
                    acc.series.push(value);
                }
                return acc;
            }, { labels: [], series: [] });

            console.log('Valid Segments Data:', validSegmentsData);

            if (validSegmentsData.series.length > 0) {
                const customerSegmentsOptions = {
                    series: validSegmentsData.series,
                    chart: {
                        type: 'pie',
                        height: 350
                    },
                    labels: validSegmentsData.labels,
                    colors: ['#ec3737', '#f59e0b', '#10b981', '#94a3b8'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return val.toFixed(1) + '%';
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return Number(val).toLocaleString('en-US') + ' customers';
                            }
                        }
                    }
                };

                const customerSegmentsChart = new ApexCharts(document.querySelector("#customerSegmentsChart"), customerSegmentsOptions);
                customerSegmentsChart.render();
            } else {
                document.querySelector("#customerSegmentsChart").innerHTML = '<div class="text-center py-5"><p class="text-muted">No data available</p></div>';
            }
        });
    </script>
    @endpush

</x-layout.master>
