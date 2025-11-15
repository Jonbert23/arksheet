<x-layout.master>

    @push('styles')
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    
    <style>
        /* Quick select buttons styling */
        .quick-date-btn {
            transition: all 0.2s ease;
            font-size: 16px;
            padding: 8px 0 !important;
            border-radius: 0 !important;
            background-color: transparent !important;
            border: none !important;
            color: #1f2937 !important;
            font-weight: 600 !important;
        }
        
        .quick-date-btn:hover {
            background-color: transparent !important;
            color: #ec3737 !important;
            border: none !important;
        }
        
        .quick-date-btn:active,
        .quick-date-btn.active {
            background-color: transparent !important;
            color: #ec3737 !important;
            border: none !important;
        }
        
        /* Customer filter hover styling */
        #customerFilterForm .btn-outline-secondary:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #customerFilterForm .btn-outline-secondary:hover .text-secondary-light {
            color: #ffffff !important;
        }
        
        #customerFilterForm select.form-select:hover {
            background-color: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Select dropdown options styling */
        #customerFilterForm select.form-select option {
            background-color: #ffffff !important;
            color: #1f2937 !important;
            padding: 8px 12px;
        }
        
        #customerFilterForm select.form-select option:hover {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        #customerFilterForm select.form-select option:checked,
        #customerFilterForm select.form-select option:focus {
            background-color: #ec3737 !important;
            color: #ffffff !important;
        }
        
        /* Ensure Flatpickr calendar is visible - Match Goals Module */
        #dateRangePicker .flatpickr-calendar {
            display: block !important;
            position: relative !important;
            box-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: auto !important;
            border: none !important;
            background: transparent !important;
        }
        
        .flatpickr-calendar.inline {
            display: block !important;
            position: relative !important;
            box-shadow: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            border: none !important;
        }
        
        /* Style for two-month display */
        .flatpickr-months {
            display: flex !important;
            gap: 20px;
        }
        
        /* Month navigation */
        .flatpickr-month {
            background: transparent !important;
            color: #1f2937 !important;
            height: auto !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        .flatpickr-current-month {
            padding: 10px 0 !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: static !important;
            width: auto !important;
            transform: none !important;
            height: auto !important;
        }
        
        .flatpickr-monthDropdown-months {
            font-weight: 600 !important;
            color: #1f2937 !important;
            background: transparent !important;
            border: none !important;
        }
        
        .numInputWrapper {
            display: inline-block !important;
        }
        
        .cur-year {
            display: inline-block !important;
            font-weight: 600 !important;
            color: #1f2937 !important;
        }
        
        .cur-year .numInput {
            display: inline-block !important;
            color: #1f2937 !important;
            font-weight: 600 !important;
        }
        
        /* Weekday headers */
        .flatpickr-weekdays {
            background: transparent !important;
            height: 40px !important;
            align-items: center !important;
        }
        
        .flatpickr-weekday {
            color: #6b7280 !important;
            font-weight: 600 !important;
            font-size: 13px !important;
        }
        
        /* Day cells */
        .flatpickr-days {
            width: auto !important;
        }
        
        .flatpickr-day {
            color: #1f2937 !important;
            border: none !important;
            border-radius: 6px !important;
            height: 36px !important;
            line-height: 36px !important;
            max-width: 36px !important;
            font-weight: 500 !important;
            margin: 2px !important;
        }
        
        .flatpickr-day:hover {
            background: #f3f4f6 !important;
            border-color: transparent !important;
        }
        
        /* Today - RED BRANDING */
        .flatpickr-day.today {
            border: 2px solid #ec3737 !important;
            color: #ec3737 !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day.today:hover {
            background: #fef2f2 !important;
            border-color: #ec3737 !important;
        }
        
        /* Selected and range - RED BRANDING */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #ec3737 !important;
            border-color: #ec3737 !important;
            color: #ffffff !important;
            font-weight: 600 !important;
        }
        
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #d42f2f !important;
            border-color: #d42f2f !important;
        }
        
        .flatpickr-day.inRange {
            background: #fee2e2 !important;
            border-color: transparent !important;
            color: #991b1b !important;
            box-shadow: none !important;
        }
        
        /* Disabled days */
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #d1d5db !important;
        }
        
        .flatpickr-day.flatpickr-disabled:hover {
            background: transparent !important;
            cursor: not-allowed !important;
        }
        
        /* Ensure two months display side by side */
        #dateRangePicker .flatpickr-months {
            display: flex !important;
            flex-wrap: nowrap !important;
        }
        
        /* Ensure calendar doesn't overflow */
        #dateRangePicker {
            width: 100%;
            max-width: 100%;
        }
        
        #dateRangePicker .flatpickr-calendar.inline {
            display: block !important;
            position: static !important;
            box-shadow: none !important;
            width: auto !important;
            max-width: none !important;
        }
    </style>
    @endpush

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Customers Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Customers</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:check-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:alert-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Date Range and Status Filter -->
        <div class="card mb-24 border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('customers.index') }}" id="customerFilterForm">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <!-- Date Range Picker with Dropdown -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-2 radius-8 px-16 py-11 dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" style="min-width: 280px;">
                                <iconify-icon icon="mdi:calendar" class="text-secondary-light"></iconify-icon>
                                <span id="dateRangeDisplay">
                                    {{ $dateFrom && $dateTo ? \Carbon\Carbon::parse($dateFrom)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($dateTo)->format('M d, Y') : \Carbon\Carbon::now()->startOfMonth()->format('M d, Y') . ' - ' . \Carbon\Carbon::now()->format('M d, Y') }}
                                </span>
                            </button>
                            <div class="dropdown-menu p-0" style="width: 800px; max-width: 95vw;" onclick="event.stopPropagation();">
                                <div class="d-flex">
                                    <!-- Quick Select Options -->
                                    <div style="width: 160px; border-right: 1px solid #e5e7eb; padding: 16px 12px; flex-shrink: 0;">
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="today">Today</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="yesterday">Yesterday</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_week">This week</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="month_to_date">Month to date</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_month">This month</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="last_month">Last month</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_quarter">This quarter</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="this_year">This year</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="year_to_date">Year to date</button>
                                        <button type="button" class="btn btn-sm btn-light w-100 text-start mb-2 quick-date-btn" data-range="last_year">Last year</button>
                                    </div>
                                    <!-- Calendar -->
                                    <div style="flex: 1; padding: 16px; min-width: 0; overflow-x: auto;">
                                        <div id="dateRangePicker"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div style="min-width: 200px;">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:filter" style="font-size: 20px; color: #ec3737;"></iconify-icon>
                                <select name="is_active" class="form-select radius-8 px-16 py-11" style="border: 1px solid #e5e7eb; min-width: 180px;">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="date_from" id="filter_date_from" value="{{ $dateFrom }}">
                        <input type="hidden" name="date_to" id="filter_date_to" value="{{ $dateTo }}">

                        <!-- Apply Filter Button -->
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2 ms-auto" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="mdi:filter-check" style="font-size: 18px;"></iconify-icon>
                            <span>Apply Filter</span>
                        </button>

                        <!-- Reset Filter Button -->
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:refresh" style="font-size: 18px;"></iconify-icon>
                            <span>Reset</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-secondary-light mb-1">Total Customers</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ $customers->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                <iconify-icon icon="mdi:account-multiple" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Active Customers</p>
                                <h6 class="mb-0">{{ $customers->where('is_active', true)->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:account-check" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Sales</p>
                                <h6 class="mb-0">{{ $customers->sum('sales_count') }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:cart" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Customers w/ Email</p>
                                <h6 class="mb-0">{{ $customers->whereNotNull('email')->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:email" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-md mb-0 fw-semibold text-secondary-light">Show</span>
                        <select class="form-select form-select-sm w-auto" id="entries-per-page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="icon-field">
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search customers..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <iconify-icon icon="ion:search-outline"></iconify-icon>
                        </span>
                    </div>
                </div>
                <button type="button" id="addCustomerBtn" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Add New Customer
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="customers-table" style="min-width: 900px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 150px;">Customer Name</th>
                                <th scope="col" style="min-width: 150px;">Email</th>
                                <th scope="col" style="min-width: 120px;">Phone</th>
                                <th scope="col" style="min-width: 120px;">Company</th>
                                <th scope="col" style="min-width: 100px;">City</th>
                                <th scope="col" class="text-center" style="min-width: 80px;">Sales Count</th>
                                <th scope="col" class="text-center" style="min-width: 80px;">Status</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $customer)
                            <tr>
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="w-32-px h-32-px rounded-circle d-flex justify-content-center align-items-center text-white fw-bold" style="background-color: #ec3737; font-size: 12px;">
                                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                                        </div>
                                        <span class="text-sm fw-semibold">{{ $customer->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $customer->email ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $customer->phone ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $customer->company ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $customer->city ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-100 text-info-600 px-12 py-6">{{ $customer->sales_count }}</span>
                                </td>
                                <td class="text-center">
                                    @if($customer->is_active)
                                        <span class="badge bg-success-100 text-success-600 px-12 py-6">Active</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-12 py-6">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="view-customer-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" data-customer-id="{{ $customer->id }}">
                                            <iconify-icon icon="solar:eye-linear" class="icon text-lg"></iconify-icon>
                                        </button>
                                        <button type="button" class="edit-customer-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-customer-id="{{ $customer->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <iconify-icon icon="lucide:edit" class="icon text-lg"></iconify-icon>
                                        </button>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <iconify-icon icon="fluent:delete-24-regular" class="icon text-lg"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-48">
                                    <div class="d-flex flex-column align-items-center">
                                        <iconify-icon icon="mdi:account-off" class="text-secondary-light mb-8" style="font-size: 48px;"></iconify-icon>
                                        <p class="text-secondary-light mb-16">No customers found</p>
                                        <button type="button" id="addFirstCustomerBtn" class="btn text-white px-20 py-11 radius-8" style="background-color: #ec3737;">
                                            <iconify-icon icon="ic:baseline-plus" class="icon text-xl me-1"></iconify-icon>
                                            Add Your First Customer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="addCustomerModalLabel">
                       
                        Add New Customer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form id="addCustomerForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter customer name" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="customer@example.com">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="+1 234 567 8900">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Company</label>
                                <input type="text" name="company" class="form-control" placeholder="Company name">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" name="city" class="form-control" placeholder="City">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="add_is_active" checked>
                                    <label class="form-check-label" for="add_is_active">Active Customer</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" rows="2" class="form-control" placeholder="Complete address"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes" rows="2" class="form-control" placeholder="Additional notes"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="saveCustomerBtn" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;">
                        Save Customer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="editCustomerModalLabel">
                        
                        Edit Customer
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form id="editCustomerForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="customer_id" id="edit_customer_id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="edit_name" class="form-control" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" id="edit_phone" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Company</label>
                                <input type="text" name="company" id="edit_company" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">City</label>
                                <input type="text" name="city" id="edit_city" class="form-control">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_is_active">
                                    <label class="form-check-label" for="edit_is_active">Active Customer</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Address</label>
                                <textarea name="address" id="edit_address" rows="2" class="form-control"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Notes</label>
                                <textarea name="notes" id="edit_notes" rows="2" class="form-control"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" id="updateCustomerBtn" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;">
                        Update Customer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Customer Modal -->
    <div class="modal fade" id="viewCustomerModal" tabindex="-1" aria-labelledby="viewCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="viewCustomerModalLabel">
                            Customer Details
                        </h5>
                        <p class="text-secondary-light mb-0 mt-1" style="font-size: 13px;" id="view_customer_name_subtitle"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <!-- Customer Information -->
                    <div class="mb-20">
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Customer Information</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Name</p>
                                    <p class="fw-semibold mb-0" id="view_name">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Status</p>
                                    <span id="view_status">-</span>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Email</p>
                                    <p class="fw-semibold mb-0" id="view_email">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Phone</p>
                                    <p class="fw-semibold mb-0" id="view_phone">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Company</p>
                                    <p class="fw-semibold mb-0" id="view_company">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">City</p>
                                    <p class="fw-semibold mb-0" id="view_city">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-20" id="view_address_container" style="display: none;">
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Address</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <p class="mb-0" id="view_address">-</p>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-20" id="view_notes_container" style="display: none;">
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Notes</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <p class="mb-0" id="view_notes">-</p>
                        </div>
                    </div>

                    <!-- Sales History Section -->
                    <div>
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Sales History</h6>
                        <div id="view_sales_history_container">
                            <div class="text-center py-20">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="text-secondary-light mt-2 mb-0">Loading sales history...</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Flatpickr JS -->
    <script src="{{ asset('assets/js/flatpickr.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Flatpickr for inline calendar
            let customerDateRangePicker = null;
            const dropdownButton = $('#customerFilterForm .dropdown-toggle[data-bs-toggle="dropdown"]').first();
            
            // Initialize Flatpickr when dropdown is opened
            dropdownButton.on('click', function() {
                setTimeout(function() {
                    if (!customerDateRangePicker) {
                        console.log('Initializing Customer Date Range Picker...');
                        
                        const calendarElement = document.getElementById('dateRangePicker');
                        if (calendarElement && typeof flatpickr !== 'undefined') {
                            customerDateRangePicker = flatpickr(calendarElement, {
                                mode: "range",
                                inline: true,
                                showMonths: 2,
                                dateFormat: "Y-m-d",
                                defaultDate: ['{{ $dateFrom }}', '{{ $dateTo }}'],
                                onChange: function(selectedDates, dateStr, instance) {
                                    console.log('Customer dates selected:', selectedDates);
                                    if (selectedDates.length === 2) {
                                        updateCustomerDateRange(selectedDates[0], selectedDates[1]);
                                    }
                                },
                                onReady: function() {
                                    console.log('Customer Flatpickr ready with', this.config.showMonths, 'months!');
                                }
                            });
                            
                            console.log('Customer Flatpickr instance created:', customerDateRangePicker);
                        } else {
                            console.error('Cannot initialize Customer Flatpickr:', {
                                element: calendarElement,
                                flatpickrAvailable: typeof flatpickr !== 'undefined'
                            });
                        }
                    }
                }, 100);
            });

            // Quick date range selection
            $('.quick-date-btn').on('click', function() {
                const range = $(this).data('range');
                const dates = getCustomerDateRange(range);
                
                $('.quick-date-btn').removeClass('active');
                $(this).addClass('active');
                
                if (customerDateRangePicker) {
                    customerDateRangePicker.setDate([dates.from, dates.to]);
                }
                updateCustomerDateRange(dates.from, dates.to);
            });

            function getCustomerDateRange(range) {
                const today = new Date();
                let from, to;

                switch(range) {
                    case 'today':
                        from = to = new Date();
                        break;
                    case 'yesterday':
                        from = to = new Date(today.setDate(today.getDate() - 1));
                        break;
                    case 'this_week':
                        from = new Date(today.setDate(today.getDate() - today.getDay()));
                        to = new Date();
                        break;
                    case 'month_to_date':
                    case 'this_month':
                        from = new Date(today.getFullYear(), today.getMonth(), 1);
                        to = new Date();
                        break;
                    case 'last_month':
                        from = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        to = new Date(today.getFullYear(), today.getMonth(), 0);
                        break;
                    case 'this_quarter':
                        const quarter = Math.floor(today.getMonth() / 3);
                        from = new Date(today.getFullYear(), quarter * 3, 1);
                        to = new Date(today.getFullYear(), (quarter + 1) * 3, 0);
                        break;
                    case 'this_year':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = new Date(today.getFullYear(), 11, 31);
                        break;
                    case 'year_to_date':
                        from = new Date(today.getFullYear(), 0, 1);
                        to = new Date();
                        break;
                    case 'last_year':
                        from = new Date(today.getFullYear() - 1, 0, 1);
                        to = new Date(today.getFullYear() - 1, 11, 31);
                        break;
                }

                return { from, to };
            }

            function updateCustomerDateRange(from, to) {
                const fromDate = from instanceof Date ? from : new Date(from);
                const toDate = to instanceof Date ? to : new Date(to);
                
                // Format dates for display
                const options = { year: 'numeric', month: 'short', day: 'numeric' };
                const fromStr = fromDate.toLocaleDateString('en-US', options);
                const toStr = toDate.toLocaleDateString('en-US', options);
                
                // Update display
                $('#dateRangeDisplay').text(fromStr + ' - ' + toStr);
                
                // Update hidden inputs
                $('#filter_date_from').val(formatCustomerDate(fromDate));
                $('#filter_date_to').val(formatCustomerDate(toDate));
            }

            function formatCustomerDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            // Initialize DataTable
            if ($.fn.DataTable.isDataTable("#customers-table")) {
                $("#customers-table").DataTable().destroy();
            }

            var table = $("#customers-table").DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "lengthChange": false,
                "dom": '<"top">rt<"bottom"p><"clear">',
                "language": {
                    "emptyTable": "No customers available",
                    "zeroRecords": "No matching customers found",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": '<iconify-icon icon="ic:baseline-chevron-right"></iconify-icon>',
                        "previous": '<iconify-icon icon="ic:baseline-chevron-left"></iconify-icon>'
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, -1] }
                ],
                "order": [[1, "asc"]]
            });

            // Custom search
            $("#search-input").on("keyup", function() {
                table.search(this.value).draw();
            });

            // Custom page length
            $("#entries-per-page").on("change", function() {
                table.page.len(parseInt(this.value)).draw();
            });

            // Open Add Customer Modal
            $("#addCustomerBtn, #addFirstCustomerBtn").on("click", function() {
                $("#addCustomerForm")[0].reset();
                $("#addCustomerForm .is-invalid").removeClass("is-invalid");
                $("#addCustomerModal").modal("show");
            });

            // Save Customer
            $("#saveCustomerBtn").on("click", function() {
                var btn = $(this);
                var form = $("#addCustomerForm");
                var formData = form.serialize();

                // Clear previous errors
                form.find(".is-invalid").removeClass("is-invalid");
                form.find(".invalid-feedback").text("");

                btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');

                $.ajax({
                    url: "{{ route('customers.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {
                        $("#addCustomerModal").modal("hide");
                        
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Customer created successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        btn.prop("disabled", false).html('Save Customer');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass("is-invalid");
                                input.siblings(".invalid-feedback").text(value[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Failed to create customer. Please try again."
                            });
                        }
                    }
                });
            });

            // Open Edit Customer Modal
            $(document).on("click", ".edit-customer-btn", function() {
                var customerId = $(this).data("customer-id");
                
                // Clear form
                $("#editCustomerForm")[0].reset();
                $("#editCustomerForm .is-invalid").removeClass("is-invalid");
                
                // Show modal with loading
                $("#editCustomerModal").modal("show");

                // Fetch customer data
                $.ajax({
                    url: "/customers/" + customerId + "/edit",
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    },
                    success: function(response) {
                        var customer = response.customer;
                        
                        $("#edit_customer_id").val(customer.id);
                        $("#edit_name").val(customer.name);
                        $("#edit_email").val(customer.email || "");
                        $("#edit_phone").val(customer.phone || "");
                        $("#edit_company").val(customer.company || "");
                        $("#edit_city").val(customer.city || "");
                        $("#edit_address").val(customer.address || "");
                        $("#edit_notes").val(customer.notes || "");
                        $("#edit_is_active").prop("checked", customer.is_active);
                    },
                    error: function(xhr) {
                        $("#editCustomerModal").modal("hide");
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Failed to load customer data."
                        });
                    }
                });
            });

            // Update Customer
            $("#updateCustomerBtn").on("click", function() {
                var btn = $(this);
                var form = $("#editCustomerForm");
                var customerId = $("#edit_customer_id").val();
                var formData = form.serialize();

                // Clear previous errors
                form.find(".is-invalid").removeClass("is-invalid");
                form.find(".invalid-feedback").text("");

                btn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');

                $.ajax({
                    url: "/customers/" + customerId,
                    method: "PUT",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $("#editCustomerModal").modal("hide");
                        
                        Swal.fire({
                            icon: "success",
                            title: "Success!",
                            text: "Customer updated successfully!",
                            timer: 2000,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(xhr) {
                        btn.prop("disabled", false).html('Update Customer');

                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                var input = form.find('[name="' + key + '"]');
                                input.addClass("is-invalid");
                                input.siblings(".invalid-feedback").text(value[0]);
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Error!",
                                text: "Failed to update customer. Please try again."
                            });
                        }
                    }
                });
            });

            // Open View Customer Modal
            $(document).on("click", ".view-customer-btn", function() {
                var customerId = $(this).data("customer-id");
                
                // Reset sales history container
                $("#view_sales_history_container").html('<div class="text-center py-20"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="text-secondary-light mt-2 mb-0">Loading sales history...</p></div>');
                
                $("#viewCustomerModal").modal("show");

                $.ajax({
                    url: "/customers/" + customerId,
                    method: "GET",
                    headers: {
                        "Accept": "application/json"
                    },
                    success: function(response) {
                        var customer = response.customer;
                        var currency = "{{ auth()->user()->business->currency }}";
                        
                        $("#view_customer_name_subtitle").text(customer.name);
                        $("#view_name").text(customer.name);
                        $("#view_email").text(customer.email || "Not Provided");
                        $("#view_phone").text(customer.phone || "Not Provided");
                        $("#view_company").text(customer.company || "Not Provided");
                        $("#view_city").text(customer.city || "Not Provided");
                        $("#view_sales_count").text(customer.sales_count || 0);
                        $("#view_total_sales").text(currency + " " + parseFloat(customer.total_sales || 0).toFixed(2));
                        
                        if (customer.is_active) {
                            $("#view_status").html('<span class="badge bg-success-100 text-success-600 px-12 py-6">Active</span>');
                        } else {
                            $("#view_status").html('<span class="badge bg-danger-100 text-danger-600 px-12 py-6">Inactive</span>');
                        }
                        
                        if (customer.address) {
                            $("#view_address").text(customer.address);
                            $("#view_address_container").show();
                        } else {
                            $("#view_address_container").hide();
                        }
                        
                        if (customer.notes) {
                            $("#view_notes").text(customer.notes);
                            $("#view_notes_container").show();
                        } else {
                            $("#view_notes_container").hide();
                        }

                        // Load and display sales history
                        displaySalesHistory(customer.sales, currency);
                    },
                    error: function(xhr) {
                        $("#viewCustomerModal").modal("hide");
                        Swal.fire({
                            icon: "error",
                            title: "Error!",
                            text: "Failed to load customer details."
                        });
                    }
                });
            });

            // Function to display sales history
            function displaySalesHistory(sales, currency) {
                var container = $("#view_sales_history_container");
                
                if (!sales || sales.length === 0) {
                    container.html(
                        '<div class="text-center py-32">' +
                            '<iconify-icon icon="mdi:receipt-text-remove" class="text-secondary-light mb-8" style="font-size: 48px;"></iconify-icon>' +
                            '<p class="text-secondary-light mb-0">No sales found for this customer</p>' +
                        '</div>'
                    );
                    return;
                }

                var tableHtml = '<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">' +
                    '<table class="table table-bordered table-hover mb-0">' +
                        '<thead class="bg-neutral-50" style="position: sticky; top: 0; z-index: 10;">' +
                            '<tr>' +
                                '<th style="font-size: 13px; width: 100px;">Invoice #</th>' +
                                '<th style="font-size: 13px; width: 120px;">Date</th>' +
                                '<th style="font-size: 13px;">Channel</th>' +
                                '<th style="font-size: 13px; text-align: right; width: 100px;">Discount</th>' +
                                '<th style="font-size: 13px; text-align: right; width: 100px;">Total</th>' +
                                '<th style="font-size: 13px; text-align: center; width: 100px;">Status</th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>';

                sales.forEach(function(sale) {
                    var saleDate = new Date(sale.date);
                    var formattedDate = saleDate.toLocaleDateString("en-US", { 
                        year: "numeric", 
                        month: "short", 
                        day: "numeric" 
                    });

                    var statusBadge = '';
                    if (sale.payment_status === 'paid') {
                        statusBadge = '<span class="badge bg-success-100 text-success-600 px-12 py-4" style="font-size: 11px;">Paid</span>';
                    } else if (sale.payment_status === 'partial') {
                        statusBadge = '<span class="badge bg-warning-100 text-warning-600 px-12 py-4" style="font-size: 11px;">Partial</span>';
                    } else {
                        statusBadge = '<span class="badge bg-danger-100 text-danger-600 px-12 py-4" style="font-size: 11px;">Pending</span>';
                    }

                    var channelName = sale.sales_channel ? sale.sales_channel.name : 'N/A';
                    var discount = sale.discount ? parseFloat(sale.discount).toFixed(2) : '0.00';

                    tableHtml += '<tr>' +
                        '<td style="font-size: 13px;"><span class="fw-semibold">' + sale.invoice_number + '</span></td>' +
                        '<td style="font-size: 13px;">' + formattedDate + '</td>' +
                        '<td style="font-size: 13px;">' + channelName + '</td>' +
                        '<td style="font-size: 13px; text-align: right;">' + currency + ' ' + discount + '</td>' +
                        '<td style="font-size: 13px; text-align: right;"><span class="fw-semibold">' + currency + ' ' + parseFloat(sale.total).toFixed(2) + '</span></td>' +
                        '<td style="text-align: center;">' + statusBadge + '</td>' +
                    '</tr>';
                });

                tableHtml += '</tbody></table></div>';

                // Add summary at the bottom
                var totalSales = 0;
                sales.forEach(function(sale) {
                    totalSales += parseFloat(sale.total);
                });

                tableHtml += '<div class="mt-12 p-12 border-top">' +
                    '<div class="row">' +
                        '<div class="col-6">' +
                            '<p class="mb-0 text-secondary-light" style="font-size: 13px;">Total Transactions: <strong>' + sales.length + '</strong></p>' +
                        '</div>' +
                        '<div class="col-6 text-end">' +
                            '<p class="mb-0 text-secondary-light" style="font-size: 13px;">Total Amount: <strong style="color: #ec3737;">' + currency + ' ' + totalSales.toFixed(2) + '</strong></p>' +
                        '</div>' +
                    '</div>' +
                '</div>';

                container.html(tableHtml);
            }

            // Delete confirmation
            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This customer will be permanently deleted!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#ec3737",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut("slow");
            }, 5000);
        });
    </script>
    @endpush

</x-layout.master>

