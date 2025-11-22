<x-layout.master>

    @push('styles')
    <style>
        /* Custom Select Dropdown - Match Sales Module */
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
            <h6 class="fw-semibold mb-0">Customers Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Customers</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters Section -->
        <form method="GET" action="{{ route('customers.index') }}" id="customerFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    formId="customerFilterForm"
                    :dateFrom="$dateFrom ?? ''"
                    :dateTo="$dateTo ?? ''"
                    :autoSubmit="false"
                />

                <!-- Status Filter -->
                <select name="is_active" class="form-select-custom">
                    <option value="">All Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                </select>

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>

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
                                <i class="bi bi-people-fill text-white"></i>
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
                                <i class="bi bi-check-circle-fill text-white"></i>
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
                                <i class="bi bi-cart-fill text-white"></i>
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
                                <i class="bi bi-envelope-fill text-white"></i>
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
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <button type="button" id="addCustomerBtn" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-person-plus-fill"></i>
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
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <button type="button" class="edit-customer-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-customer-id="{{ $customer->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>
                                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-48">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-inbox text-secondary-light mb-16" style="font-size: 48px;"></i>
                                        <p class="text-secondary-light mb-16">No customers found</p>
                                        <button type="button" id="addFirstCustomerBtn" class="btn text-white px-20 py-11 radius-8" style="background-color: #ec3737;">
                                            <i class="bi bi-person-plus-fill me-2"></i>
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
                        <i class="bi bi-person-plus-fill me-2"></i>
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
                        <i class="bi bi-pencil-square me-2"></i>
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
                            <i class="bi bi-person-circle me-2"></i>
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable only if there are customers
            var hasCustomers = $("#customers-table tbody tr").length > 0 && !$("#customers-table tbody tr td[colspan]").length;
            
            if (hasCustomers) {
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
                    "columns": [
                        { "orderable": false, "searchable": false },  // 0 - No.
                        { "orderable": true, "searchable": true },    // 1 - Customer Name
                        { "orderable": true, "searchable": true },    // 2 - Email
                        { "orderable": true, "searchable": true },    // 3 - Phone
                        { "orderable": true, "searchable": true },    // 4 - Company
                        { "orderable": true, "searchable": true },    // 5 - City
                        { "orderable": true, "searchable": false },   // 6 - Sales Count
                        { "orderable": true, "searchable": false },   // 7 - Status
                        { "orderable": false, "searchable": false }   // 8 - Actions
                    ],
                    "columnDefs": [
                        {
                            "targets": [6, 7, 8], // Center-aligned columns
                            "className": "text-center"
                        }
                    ],
                    "language": {
                        "emptyTable": "No customers available",
                        "zeroRecords": "No matching customers found",
                        "paginate": {
                            "first": "First",
                            "last": "Last",
                            "next": '<i class="bi bi-chevron-right"></i>',
                            "previous": '<i class="bi bi-chevron-left"></i>'
                        }
                    },
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
            }

            // ========== MODAL HANDLERS (Always Available) ==========
            
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
                            '<i class="bi bi-cart-x text-secondary-light mb-16" style="font-size: 48px;"></i>' +
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

