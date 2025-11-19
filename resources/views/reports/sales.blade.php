<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Sales Report</h6>
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
                <li class="fw-medium">Sales Report</li>
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
                                    <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#customerFilterModal" style="transition: all 0.2s;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>Customer</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#channelFilterModal" style="transition: all 0.2s;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>Sales Channel</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <a class="dropdown-item py-10 px-16 d-flex align-items-center gap-2" href="#" data-bs-toggle="modal" data-bs-target="#advancedFilterModal" style="transition: all 0.2s;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span>Advanced Filter</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Clear All Filters Button -->
                        @if(request()->has('date_from') || request()->has('customer_id') || request()->has('channel_id'))
                        <a href="{{ route('reports.sales') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2 radius-8 px-20 py-11">
                            <i class="bi bi-circle-fill"></i>
                            <span>Clear All Filters</span>
                        </a>
                        @endif
                    </div>

                    <!-- Active Filters Display -->
                    @if(request()->has('date_from') || request()->has('customer_id') || request()->has('channel_id'))
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <span class="text-sm text-secondary-light fw-medium">Active Filters:</span>
                        @if(request('date_from'))
                            <span class="badge bg-primary-100 text-primary-600 px-12 py-6 d-inline-flex align-items-center gap-2" style="padding-right: 8px !important;">
                                <i class="bi bi-circle-fill"></i>
                                <span>{{ \Carbon\Carbon::parse(request('date_from'))->format('M d, Y') }} - {{ \Carbon\Carbon::parse(request('date_to'))->format('M d, Y') }}</span>
                                <a href="{{ route('reports.sales', array_merge(request()->except(['date_from', 'date_to']), [])) }}" class="text-primary-600 d-inline-flex align-items-center" style="text-decoration: none; margin-left: 4px;" title="Remove date filter">
                                    <i class="bi bi-circle-fill"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('customer_id'))
                            <span class="badge bg-success-100 text-success-600 px-12 py-6 d-inline-flex align-items-center gap-2" style="padding-right: 8px !important;">
                                <i class="bi bi-circle-fill"></i>
                                <span>{{ $customers->firstWhere('id', request('customer_id'))?->name }}</span>
                                <a href="{{ route('reports.sales', request()->except('customer_id')) }}" class="text-success-600 d-inline-flex align-items-center" style="text-decoration: none; margin-left: 4px;" title="Remove customer filter">
                                    <i class="bi bi-circle-fill"></i>
                                </a>
                            </span>
                        @endif
                        @if(request('channel_id'))
                            <span class="badge bg-info-100 text-info-600 px-12 py-6 d-inline-flex align-items-center gap-2" style="padding-right: 8px !important;">
                                <i class="bi bi-circle-fill"></i>
                                <span>{{ $channels->firstWhere('id', request('channel_id'))?->name }}</span>
                                <a href="{{ route('reports.sales', request()->except('channel_id')) }}" class="text-info-600 d-inline-flex align-items-center" style="text-decoration: none; margin-left: 4px;" title="Remove channel filter">
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
            <!-- Total Sales -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Sales</span>
                                    <h6 class="fw-bold" style="color: #ec3737;">{{ auth()->user()->business->currency }} {{ number_format($summary['total_sales'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Transactions <span class="px-1 rounded-2 fw-bold text-white text-sm" style="background-color: #ec3737;">{{ number_format($summary['total_transactions']) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Total Transactions -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Transactions</span>
                                    <h6 class="fw-semibold">{{ number_format($summary['total_transactions']) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Average <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ auth()->user()->business->currency }} {{ number_format($summary['average_sale'], 2) }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Average Sale -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-3">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-yellow text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Average Sale</span>
                                    <h6 class="fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($summary['average_sale'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Per Transaction <span class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">{{ $summary['total_transactions'] > 0 ? number_format(($summary['total_sales'] / $summary['total_transactions']), 2) : '0.00' }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Total Discount -->
            <div class="col-lg-3 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-4">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-purple text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Total Discount</span>
                                    <h6 class="fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($summary['total_discount'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Impact <span class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">{{ $summary['total_sales'] > 0 ? number_format(($summary['total_discount'] / ($summary['total_sales'] + $summary['total_discount'])) * 100, 1) : '0' }}%</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daily Sales Trend -->
        <div class="card border-0 shadow-sm mb-24">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-2">
                    <div>
                        <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Daily Sales Trend</h6>
                        <span class="text-sm fw-medium text-secondary-light">Sales performance overview</span>
                    </div>
                </div>
                <div id="dailySalesTrendChart" class="mt-20" style="min-height: 350px;"></div>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="row gy-4 mb-24">
            <!-- Top Products -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Top Selling Products</h6>
                        </div>
                        @if($topProducts->isNotEmpty())
                        <div id="topProductsChart" class="mt-20" style="min-height: 280px;"></div>
                        <div class="mt-24">
                            @foreach($topProducts->take(6) as $index => $product)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#487FFF', '#45B369', '#FF9F43', '#EA5455', '#00CFE8', '#7367F0'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $product->name }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($product->total_revenue, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No products data</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sales by Channel -->
            <div class="col-lg-6">
                <div class="card h-100 radius-8 border-0 shadow-sm">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                            <h6 class="mb-2 fw-bold text-lg" style="color: #ec3737;">Sales by Channel</h6>
                        </div>
                        @if($salesByChannel->isNotEmpty())
                        <div id="salesByChannelChart" class="mt-20" style="min-height: 280px;"></div>
                        <div class="mt-24">
                            @foreach($salesByChannel as $index => $channel)
                            <div class="d-flex align-items-center justify-content-between mb-12">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px radius-2" style="background-color: {{ ['#EA5455', '#FF9F43', '#28C76F', '#00CFE8', '#7367F0', '#FF6384'][$index % 6] }}"></span>
                                    <span class="text-sm">{{ $channel->name }}</span>
                                </div>
                                <span class="text-sm fw-bold">{{ number_format($channel->total_sales, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-center text-secondary-light mt-5">No channel data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Transactions Table -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-20">
                <h6 class="fw-bold mb-0" style="font-size: 18px !important; color: #4b5563;">Sales Transactions</h6>
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
                    <table class="table bordered-table mb-0" id="sales-report-table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Channel</th>
                                <th>Status</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-end">Discount</th>
                                <th class="text-end">Tax</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-primary-600 fw-semibold">
                                        {{ $sale->invoice_number }}
                                    </a>
                                </td>
                                <td>{{ $sale->date->format('M d, Y') }}</td>
                                <td>{{ $sale->customer ? $sale->customer->name : 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-primary-100 text-primary-600 px-12 py-4">
                                        {{ $sale->salesChannel ? $sale->salesChannel->name : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if($sale->payment_status === 'paid')
                                        <span class="badge bg-success-100 text-success-600 px-12 py-4">Paid</span>
                                    @elseif($sale->payment_status === 'partial')
                                        <span class="badge bg-warning-100 text-warning-600 px-12 py-4">Partial</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-12 py-4">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ number_format($sale->subtotal, 2) }}</td>
                                <td class="text-end">{{ number_format($sale->discount, 2) }}</td>
                                <td class="text-end">{{ number_format($sale->tax, 2) }}</td>
                                <td class="text-end fw-semibold" style="color: #ec3737;">{{ number_format($sale->total, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-24">No sales found for the selected period</td>
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
                <div class="modal-body px-24 py-24">
                    <form method="GET" action="{{ route('reports.sales') }}" id="dateRangeForm">
                        @if(request('customer_id'))
                            <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                        @endif
                        @if(request('channel_id'))
                            <input type="hidden" name="channel_id" value="{{ request('channel_id') }}">
                        @endif
                        <div class="mb-16">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date From</label>
                            <input type="date" name="date_from" class="form-control radius-8" value="{{ $dateFrom }}" required>
                        </div>
                        <div class="mb-16">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date To</label>
                            <input type="date" name="date_to" class="form-control radius-8" value="{{ $dateTo }}" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="dateRangeForm" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Filter Modal -->
    <div class="modal fade" id="customerFilterModal" tabindex="-1" aria-labelledby="customerFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="customerFilterModalLabel">
                        
                        Filter by Customer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form method="GET" action="{{ route('reports.sales') }}" id="customerFilterForm">
                        <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" value="{{ $dateTo }}">
                        @if(request('channel_id'))
                            <input type="hidden" name="channel_id" value="{{ request('channel_id') }}">
                        @endif
                        <div class="mb-16">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Select Customer</label>
                            <select name="customer_id" class="form-select radius-8" required>
                                <option value="">Choose a customer...</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="customerFilterForm" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Channel Filter Modal -->
    <div class="modal fade" id="channelFilterModal" tabindex="-1" aria-labelledby="channelFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="channelFilterModalLabel">
                        Filter by Sales Channel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form method="GET" action="{{ route('reports.sales') }}" id="channelFilterForm">
                        <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" value="{{ $dateTo }}">
                        @if(request('customer_id'))
                            <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                        @endif
                        <div class="mb-16">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Select Channel</label>
                            <select name="channel_id" class="form-select radius-8" required>
                                <option value="">Choose a channel...</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ request('channel_id') == $channel->id ? 'selected' : '' }}>
                                        {{ $channel->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="channelFilterForm" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Apply Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filter Modal -->
    <div class="modal fade" id="advancedFilterModal" tabindex="-1" aria-labelledby="advancedFilterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="advancedFilterModalLabel">
                        Advanced Filter
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form method="GET" action="{{ route('reports.sales') }}" id="advancedFilterForm">
                        <div class="row gy-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date From</label>
                                <input type="date" name="date_from" class="form-control radius-8" value="{{ $dateFrom }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date To</label>
                                <input type="date" name="date_to" class="form-control radius-8" value="{{ $dateTo }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Customer</label>
                                <select name="customer_id" class="form-select radius-8">
                                    <option value="">All Customers</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Sales Channel</label>
                                <select name="channel_id" class="form-select radius-8">
                                    <option value="">All Channels</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ request('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="advancedFilterForm" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Apply Filters
                    </button>
                </div>
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
            $('#sales-report-table').DataTable({
                "pageLength": 25,
                "ordering": true,
                "searching": true,
                "info": true,
                "order": [[1, "desc"]],
                "language": {
                    "emptyTable": "No sales found for the selected period"
                }
            });

            // Initialize Charts
            console.log('Charts initialization started');
            
            // Check if ApexCharts is loaded
            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded!');
                return;
            }
            console.log('ApexCharts loaded successfully');

            // Daily Sales Trend Chart
            @if(isset($dailyTrend) && count($dailyTrend) > 0)
            console.log('Initializing daily trend chart');
            console.log('Daily trend data:', @json($dailyTrend));
            var salesData = @json(array_column($dailyTrend, 'sales'));
            console.log('Sales values:', salesData);
            console.log('Date labels:', @json(array_column($dailyTrend, 'date')));
            console.log('Sales data type check:', salesData.map(function(v) { return typeof v + ': ' + v; }));
            
            var dailyTrendOptions = {
                series: [{
                    name: "Sales",
                    data: salesData
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
                            if (typeof val !== 'number') val = parseFloat(val);
                            if (isNaN(val)) return '0';
                            return '{{ auth()->user()->business->currency }} ' + val.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
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
            var dailyTrendChart = new ApexCharts(document.querySelector("#dailySalesTrendChart"), dailyTrendOptions);
            dailyTrendChart.render();
            @endif

            // Top Products Pie Chart
            @if($topProducts->isNotEmpty())
            console.log('Top products data available');
            
            // Filter and validate data
            var topProductsData = @json($topProducts->take(6)->pluck('total_revenue')->values()->toArray());
            var topProductsLabels = @json($topProducts->take(6)->pluck('name')->values()->toArray());
            
            // Convert to numbers and filter out invalid values
            var validProductData = [];
            var validProductLabels = [];
            
            for(var i = 0; i < topProductsData.length; i++) {
                var value = parseFloat(topProductsData[i]);
                if(!isNaN(value) && value > 0) {
                    validProductData.push(value);
                    validProductLabels.push(topProductsLabels[i]);
                }
            }
            
            console.log('Valid series data:', validProductData);
            console.log('Valid labels:', validProductLabels);
            
            if(document.querySelector("#topProductsChart") && validProductData.length > 0) {
                console.log('Top products chart container found');
                var topProductsOptions = {
                    series: validProductData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: validProductLabels,
                    colors: ["#487FFF", "#45B369", "#FF9F43", "#EA5455", "#00CFE8", "#7367F0"],
                    legend: {
                        show: false
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            var value = opts.w.config.series[opts.seriesIndex];
                            return '{{ auth()->user()->business->currency }} ' + value.toFixed(2);
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold'
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
                var topProductsChart = new ApexCharts(document.querySelector("#topProductsChart"), topProductsOptions);
                topProductsChart.render();
                console.log('Top products chart rendered');
            } else {
                if(validProductData.length === 0) {
                    console.warn('No valid product data found after filtering');
                    document.querySelector("#topProductsChart").innerHTML = '<p class="text-center text-secondary-light">No valid sales data available</p>';
                } else {
                    console.error('Top products chart container not found');
                }
            }
            @else
            console.log('No top products data available');
            @endif

            // Sales by Channel Pie Chart
            @if($salesByChannel->isNotEmpty())
            console.log('Sales by channel data available');
            
            // Filter and validate data
            var salesChannelData = @json($salesByChannel->pluck('total_sales')->values()->toArray());
            var salesChannelLabels = @json($salesByChannel->pluck('name')->values()->toArray());
            
            // Convert to numbers and filter out invalid values
            var validChannelData = [];
            var validChannelLabels = [];
            
            for(var i = 0; i < salesChannelData.length; i++) {
                var value = parseFloat(salesChannelData[i]);
                if(!isNaN(value) && value > 0) {
                    validChannelData.push(value);
                    validChannelLabels.push(salesChannelLabels[i]);
                }
            }
            
            console.log('Valid channel series:', validChannelData);
            console.log('Valid channel labels:', validChannelLabels);
            
            if(document.querySelector("#salesByChannelChart") && validChannelData.length > 0) {
                console.log('Sales by channel chart container found');
                var salesByChannelOptions = {
                    series: validChannelData,
                    chart: {
                        height: 280,
                        type: "pie",
                    },
                    labels: validChannelLabels,
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
                var salesByChannelChart = new ApexCharts(document.querySelector("#salesByChannelChart"), salesByChannelOptions);
                salesByChannelChart.render();
                console.log('Sales by channel chart rendered');
            } else {
                if(validChannelData.length === 0) {
                    console.warn('No valid channel data found after filtering');
                    document.querySelector("#salesByChannelChart").innerHTML = '<p class="text-center text-secondary-light">No valid sales data available</p>';
                } else {
                    console.error('Sales by channel chart container not found');
                }
            }
            @else
            console.log('No sales by channel data available');
            @endif
            
            console.log('Charts initialization completed');
        });

        // Export Functions
        function exportToExcel() {
            var table = $('#sales-report-table').DataTable();
            var data = table.buttons.exportData();
            
            // Using DataTables built-in Excel export
            table.button('.buttons-excel').trigger();
            
            // Fallback: Simple download
            var csv = tableToCSV($('#sales-report-table'));
            downloadFile(csv, 'sales-report.csv', 'text/csv');
        }

        function exportToPDF() {
            window.print();
        }

        function exportToCSV() {
            var csv = tableToCSV($('#sales-report-table'));
            downloadFile(csv, 'sales-report.csv', 'text/csv');
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

