<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Sales Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Sales</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Summary Metrics -->
        <div class="row gy-4 mb-24">
            <!-- Total Sales -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Total Sales</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #ec3737; font-size: 1.5rem;">{{ $sales->count() }}</h6>
                        <p class="text-sm mb-0">All time sales count</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Total Revenue</span>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ auth()->user()->business->currency }} {{ number_format($sales->sum('total'), 2) }}</h6>
                        <p class="text-sm mb-0">All time revenue</p>
                    </div>
                </div>
            </div>

            <!-- Avg. Sale Value -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-info-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Avg. Sale Value</span>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ auth()->user()->business->currency }} {{ $sales->count() > 0 ? number_format($sales->avg('total'), 2) : '0.00' }}</h6>
                        <p class="text-sm mb-0">Average per sale</p>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-warning-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Pending</span>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ $sales->where('payment_status', 'pending')->count() }}</h6>
                        <p class="text-sm mb-0">Pending payments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Table -->
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
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search sales..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                    </div>
                </div>
                <a href="{{ route('sales.pos') }}" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-circle-fill"></i>
                    Record New Sale
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="sales-table" style="min-width: 1600px;">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 150px;">Invoice #</th>
                                <th scope="col" style="min-width: 120px;">Date</th>
                                <th scope="col" style="min-width: 180px;">Customer</th>
                                <th scope="col" style="min-width: 150px;">Sales Channel</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Subtotal</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Tax</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Discount</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Total</th>
                                <th scope="col" class="text-center" style="min-width: 130px;">Payment Status</th>
                                <th scope="col" class="text-center" style="min-width: 130px;">Payment Method</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $sale)
                            <tr>
                                <td>
                                    <a href="{{ route('sales.show', $sale->id) }}" class="text-primary-600 fw-semibold hover-text-primary-800">
                                        {{ $sale->invoice_number }}
                                    </a>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $sale->date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $sale->customer->name ?? 'Walk-in Customer' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $sale->salesChannel->name ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ auth()->user()->business->currency }} {{ number_format($sale->subtotal, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ auth()->user()->business->currency }} {{ number_format($sale->tax, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    @if($sale->discount > 0)
                                        <span class="text-sm fw-semibold" style="color: #ec3737;">-{{ auth()->user()->business->currency }} {{ number_format($sale->discount, 2) }}</span>
                                    @else
                                        <span class="text-sm text-secondary-light">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-primary-600">{{ auth()->user()->business->currency }} {{ number_format($sale->total, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($sale->payment_status === 'paid')
                                        <span class="badge bg-success-100 text-success-600 px-16 py-6">Paid</span>
                                    @elseif($sale->payment_status === 'partial')
                                        <span class="badge bg-warning-100 text-warning-600 px-16 py-6">Partial</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-16 py-6">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($sale->payment_method)
                                        <span class="badge bg-neutral-100 text-neutral-600 px-16 py-6">{{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</span>
                                    @else
                                        <span class="text-secondary-light">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" onclick="viewSale({{ $sale->id }})">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle" title="Edit">
                                            <i class="bi bi-circle-fill"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this sale? Stock will be restored.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete">
                                                <i class="bi bi-circle-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="bi bi-circle-fill"></i>
                                    <p class="text-secondary-light mb-0">No sales recorded yet</p>
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary-600 mt-3">
                                        <i class="bi bi-circle-fill"></i>
                                        Record First Sale
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- View Sale Modal -->
    <div class="modal fade" id="viewSaleModal" tabindex="-1" aria-labelledby="viewSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="viewSaleModalLabel">
                            Sale Details
                        </h5>
                        <p class="text-secondary-light mb-0" style="font-size: 13px;">Invoice: <span id="modalInvoiceNumber"></span></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24" style="max-height: 70vh; overflow-y: auto;">
                    <!-- Sale Details -->
                    <div class="mb-20">
                        <h6 class="fw-bold mb-12" style="font-size: 16px; color: #ec3737;">Sale Information</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Date</p>
                                    <p class="fw-semibold mb-0" id="modalSaleDate">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Customer</p>
                                    <p class="fw-semibold mb-0" id="modalCustomer">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Sales Channel</p>
                                    <p class="fw-semibold mb-0" id="modalChannel">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Method</p>
                                    <p class="fw-semibold mb-0" id="modalPaymentMethod">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Status</p>
                                    <p class="fw-semibold mb-0" id="modalPaymentStatus">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Total Items</p>
                                    <p class="fw-semibold mb-0" id="modalTotalItems">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="mb-20">
                        <h6 class="fw-bold mb-12" style="font-size: 16px; color: #ec3737;">Items</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-neutral-50">
                                    <tr>
                                        <th style="font-size: 13px;">Product</th>
                                        <th style="font-size: 13px;" class="text-center">Qty</th>
                                        <th style="font-size: 13px;" class="text-end">Price</th>
                                        <th style="font-size: 13px;" class="text-end">Tax</th>
                                        <th style="font-size: 13px;" class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="modalSaleItems">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="p-20 radius-8" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border: 2px solid #ec3737;">
                        <div class="d-flex justify-content-between mb-8">
                            <span class="text-secondary-light">Subtotal:</span>
                            <span class="fw-semibold" id="modalSubtotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8" id="modalDiscountRow" style="display: none;">
                            <span class="text-secondary-light">Item Discounts:</span>
                            <span class="fw-semibold" style="color: #ec3737;" id="modalDiscount">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8">
                            <span class="text-secondary-light">Tax:</span>
                            <span class="fw-semibold" id="modalTax">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <hr class="my-12" style="border-color: #ec3737; opacity: 0.3;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size: 18px;">Grand Total:</span>
                            <span class="fw-bold" style="font-size: 28px; color: #ec3737; letter-spacing: -0.5px;" id="modalTotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                    </div>

                    <div id="modalNotes" class="mt-16" style="display: none;">
                        <p class="text-secondary-light mb-4" style="font-size: 12px;">Notes:</p>
                        <p class="mb-0" id="modalNotesText"></p>
                    </div>
                </div>
                <div class="modal-footer border-top py-20 px-24 bg-white d-flex justify-content-end gap-3">
                    <button type="button" class="btn d-flex align-items-center justify-content-center gap-2 radius-8 py-12 px-20" 
                            style="background: #f8f9fa; color: #495057; border: 1px solid #dee2e6; font-weight: 600;"
                            data-bs-dismiss="modal">
                        <i class="bi bi-circle-fill"></i>
                        <span>Close</span>
                    </button>
                    <a href="#" id="modalEditButton" class="btn d-flex align-items-center justify-content-center gap-2 radius-8 py-12 px-20" 
                       style="background: linear-gradient(135deg, #ec3737 0%, #c91c1c 100%); color: white; border: none; font-weight: 700; box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4); text-decoration: none;">
                        <i class="bi bi-circle-fill"></i>
                        <span>Edit Sale</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <x-script/>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <style>
        /* DataTables Custom Styling */
        .dataTables_info {
            padding-top: 0.85rem;
            font-size: 14px;
            font-weight: 500;
        }
        .dataTables_paginate {
            padding-top: 0.75rem;
        }
        .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem;
            margin-left: 2px;
            border-radius: 6px;
            border: 1px solid #E0E0E0;
            background: white;
            color: #637381;
            font-weight: 500;
            cursor: pointer;
        }
        .dataTables_paginate .paginate_button:hover {
            background: #f8f9fa;
            border-color: #d0d0d0;
            color: #212529;
        }
        .dataTables_paginate .paginate_button.current {
            background: #487fff !important;
            color: white !important;
            border-color: #487fff !important;
        }
        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>

    <script>
        $(document).ready(function() {
            // Only initialize DataTable if there are sales
            var hasSales = $("#sales-table tbody tr").length > 0 && !$("#sales-table tbody tr td[colspan]").length;
            
            if (!hasSales) {
                console.log("No sales to display, skipping DataTable initialization");
                return;
            }

            // Check if DataTable is already initialized
            if ($.fn.DataTable.isDataTable("#sales-table")) {
                $("#sales-table").DataTable().destroy();
            }

            // Initialize DataTable
            var table = $("#sales-table").DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "ordering": true,
                "searching": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "order": [[1, "desc"]], // Sort by date descending
                "pagingType": "full_numbers",
                "columns": [
                    { "orderable": true, "searchable": true },   // 0 - Invoice #
                    { "orderable": true, "searchable": false },  // 1 - Date
                    { "orderable": true, "searchable": true },   // 2 - Customer
                    { "orderable": true, "searchable": true },   // 3 - Sales Channel
                    { "orderable": true, "searchable": false },  // 4 - Subtotal
                    { "orderable": true, "searchable": false },  // 5 - Tax
                    { "orderable": true, "searchable": false },  // 6 - Discount
                    { "orderable": true, "searchable": false },  // 7 - Total
                    { "orderable": true, "searchable": false },  // 8 - Payment Status
                    { "orderable": true, "searchable": false },  // 9 - Payment Method
                    { "orderable": false, "searchable": false }  // 10 - Action
                ],
                "columnDefs": [
                    {
                        "targets": [4, 5, 6, 7], // Numeric columns (Subtotal, Tax, Discount, Total)
                        "className": "text-end"
                    },
                    {
                        "targets": [8, 9, 10], // Center aligned (Payment Status, Payment Method, Actions)
                        "className": "text-center"
                    }
                ],
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Search:",
                    "searchPlaceholder": "Search sales...",
                    "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> sales",
                    "infoEmpty": "Showing 0 to 0 of 0 sales",
                    "infoFiltered": "(filtered from _MAX_ total sales)",
                    "paginate": {
                        "first": "<i class=\"ph ph-caret-double-left\"></i>",
                        "last": "<i class=\"ph ph-caret-double-right\"></i>",
                        "next": "<i class=\"ph ph-caret-right\"></i>",
                        "previous": "<i class=\"ph ph-caret-left\"></i>"
                    },
                    "emptyTable": "No sales recorded yet",
                    "zeroRecords": "No matching sales found"
                },
                "dom": "<\"row\"<\"col-sm-12\"tr>>" +
                       "<\"row mt-24\"<\"col-sm-12 col-md-5\"<\"dataTables_info_wrapper\"i>><\"col-sm-12 col-md-7\"<\"dataTables_paginate_wrapper\"p>>>",
                "drawCallback": function(settings) {
                    // Enhanced pagination styling
                    $(".dataTables_paginate .paginate_button").each(function() {
                        if (!$(this).hasClass("previous") && !$(this).hasClass("next") && 
                            !$(this).hasClass("first") && !$(this).hasClass("last")) {
                            $(this).addClass("page-number");
                        }
                    });
                }
            });

            // Connect custom search input to DataTable
            $("#search-input").on("keyup", function() {
                table.search(this.value).draw();
            });

            // Connect custom length selector to DataTable
            $("#entries-per-page").on("change", function() {
                table.page.len($(this).val()).draw();
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 5000);
        });

        // View Sale in Modal
        function viewSale(saleId) {
            // Show loading state
            $('#viewSaleModal').modal('show');
            
            // Fetch sale data
            $.ajax({
                url: `/sales/${saleId}`,
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    const sale = response.sale;
                    const currency = '{{ auth()->user()->business->currency }}';
                    
                    // Populate modal fields
                    $('#modalInvoiceNumber').text(sale.invoice_number);
                    $('#modalSaleDate').text(new Date(sale.date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }));
                    $('#modalCustomer').text(sale.customer ? sale.customer.name : 'Walk-in Customer');
                    $('#modalChannel').text(sale.sales_channel ? sale.sales_channel.name : 'N/A');
                    $('#modalPaymentMethod').text(sale.payment_method ? sale.payment_method.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : '-');
                    
                    // Payment status with badge
                    let statusBadge = '';
                    if (sale.payment_status === 'paid') {
                        statusBadge = '<span class="badge bg-success-100 text-success-600 px-12 py-6">Paid</span>';
                    } else if (sale.payment_status === 'partial') {
                        statusBadge = '<span class="badge bg-warning-100 text-warning-600 px-12 py-6">Partial</span>';
                    } else {
                        statusBadge = '<span class="badge bg-danger-100 text-danger-600 px-12 py-6">Pending</span>';
                    }
                    $('#modalPaymentStatus').html(statusBadge);
                    
                    // Total items
                    let totalItems = 0;
                    sale.sale_items.forEach(item => {
                        totalItems += parseInt(item.quantity);
                    });
                    $('#modalTotalItems').text(totalItems);
                    
                    // Populate items table and calculate total item discounts
                    let itemsHtml = '';
                    let totalItemDiscounts = 0;
                    
                    sale.sale_items.forEach(item => {
                        // Check for item-level discount
                        let discountInfo = '';
                        if (item.discount_amount && parseFloat(item.discount_amount) > 0) {
                            totalItemDiscounts += parseFloat(item.discount_amount);
                            const discountType = item.discount_type === 'percent' ? `${item.discount_value}%` : 'Fixed';
                            discountInfo = `<br><small class="text-danger-600">-${currency} ${parseFloat(item.discount_amount).toFixed(2)} (${discountType})</small>`;
                        }
                        
                        itemsHtml += `
                            <tr>
                                <td style="font-size: 13px;">
                                    <span class="fw-semibold d-block">${item.product.name}</span>
                                    <small class="text-secondary-light">SKU: ${item.product.sku || 'N/A'}</small>
                                    ${discountInfo}
                                </td>
                                <td style="font-size: 13px;" class="text-center">${item.quantity}</td>
                                <td style="font-size: 13px;" class="text-end">${currency} ${parseFloat(item.unit_price).toFixed(2)}</td>
                                <td style="font-size: 13px;" class="text-end">${currency} ${parseFloat(item.tax_amount).toFixed(2)}</td>
                                <td style="font-size: 13px;" class="text-end">${currency} ${parseFloat(item.total).toFixed(2)}</td>
                            </tr>
                        `;
                    });
                    $('#modalSaleItems').html(itemsHtml);
                    
                    // Populate summary
                    $('#modalSubtotal').text(`${currency} ${parseFloat(sale.subtotal).toFixed(2)}`);
                    $('#modalTax').text(`${currency} ${parseFloat(sale.tax).toFixed(2)}`);
                    $('#modalTotal').text(`${currency} ${parseFloat(sale.total).toFixed(2)}`);
                    
                    // Show/hide item discounts
                    if (totalItemDiscounts > 0) {
                        $('#modalDiscountRow').show();
                        $('#modalDiscount').text(`-${currency} ${totalItemDiscounts.toFixed(2)}`);
                    } else if (sale.discount && parseFloat(sale.discount) > 0) {
                        $('#modalDiscountRow').show();
                        $('#modalDiscount').text(`-${currency} ${parseFloat(sale.discount).toFixed(2)}`);
                    } else {
                        $('#modalDiscountRow').hide();
                    }
                    
                    // Show/hide notes
                    if (sale.notes) {
                        $('#modalNotes').show();
                        $('#modalNotesText').text(sale.notes);
                    } else {
                        $('#modalNotes').hide();
                    }
                    
                    // Set edit button link
                    $('#modalEditButton').attr('href', `/sales/${saleId}/edit`);
                },
                error: function(xhr) {
                    alert('Error loading sale details');
                    $('#viewSaleModal').modal('hide');
                }
            });
        }
    </script>

    <style>
        /* Brand Color Focus States */
        .form-control:focus,
        .form-select:focus {
            border-color: #ec3737 !important;
            box-shadow: 0 0 0 0.2rem rgba(236, 55, 55, 0.15) !important;
        }
        
        /* Search input icon */
        .icon-field:focus-within .icon {
            color: #ec3737 !important;
        }
        
        /* Hover effects for table rows */
        #sales-table tbody tr:hover {
            background-color: #fff5f5 !important;
            transition: background-color 0.2s ease;
        }
        
        /* DataTable pagination active state */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #ec3737 !important;
            border-color: #ec3737 !important;
            color: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #d42f2f !important;
            border-color: #d42f2f !important;
            color: white !important;
        }
        
        /* Smooth transitions */
        .btn {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        // Modal Sale Form JavaScript
        let modalItemIndex = 0;
        const modalProducts = @json($products ?? []);

        // Add Item to Modal Sale
        $(document).on('click', '#modalAddItemBtn', function(e) {
            e.preventDefault();
            addModalSaleItem();
        });

        function addModalSaleItem() {
            modalItemIndex++;
            
            const productOptions = modalProducts.map(product => 
                `<option value="${product.id}" 
                    data-price="${product.price}" 
                    data-stock="${product.stock_quantity}" 
                    data-tax="${product.tax_amount || 0}">
                    ${product.name} - Stock: ${product.stock_quantity} ${product.unit || 'pcs'}
                </option>`
            ).join('');

            const itemHtml = `
                <div class="sale-item-row mb-12 p-12 bg-neutral-50 radius-8" data-item-index="${modalItemIndex}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Product <span class="text-danger">*</span></label>
                            <select name="items[${modalItemIndex}][product_id]" class="form-select modal-product-select" style="height: 44px;" required>
                                <option value="">Select Product</option>
                                ${productOptions}
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="items[${modalItemIndex}][quantity]" class="form-control modal-item-quantity" style="height: 44px;" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Price</label>
                            <input type="number" name="items[${modalItemIndex}][unit_price]" class="form-control modal-item-price" style="height: 44px;" step="0.01" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Discount %</label>
                            <input type="number" name="items[${modalItemIndex}][discount_percent]" class="form-control modal-item-discount" style="height: 44px;" step="0.01" value="0" min="0" max="100">
                        </div>
                        <div class="col-md-1">
                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Total</label>
                            <input type="text" class="form-control modal-item-total fw-semibold" style="height: 44px;" readonly>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger-600 w-100 remove-modal-item" style="height: 44px;">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $('#modalSaleItemsContainer').append(itemHtml);
            updateModalEmptyState();
            calculateModalTotals();
        }

        // Remove Item
        $(document).on('click', '.remove-modal-item', function() {
            $(this).closest('.sale-item-row').remove();
            updateModalEmptyState();
            calculateModalTotals();
        });

        // Update empty state visibility
        function updateModalEmptyState() {
            const itemCount = $('.sale-item-row').length;
            if (itemCount === 0) {
                $('#modalEmptyState').show();
                $('#modalSaleItemsContainer').hide();
            } else {
                $('#modalEmptyState').hide();
                $('#modalSaleItemsContainer').show();
            }
        }

        // When product is selected, update price
        $(document).on('change', '.modal-product-select', function() {
            const $row = $(this).closest('.sale-item-row');
            const $option = $(this).find('option:selected');
            const price = parseFloat($option.data('price')) || 0;
            const stock = parseFloat($option.data('stock')) || 0;
            const quantity = parseFloat($row.find('.modal-item-quantity').val()) || 0;

            if (quantity > stock) {
                alert(`Only ${stock} units available in stock!`);
                $row.find('.modal-item-quantity').val(stock);
            }

            $row.find('.modal-item-price').val(price.toFixed(2));
            calculateModalItemTotal($row);
        });

        // When quantity or discount changes, recalculate
        $(document).on('input', '.modal-item-quantity, .modal-item-discount', function() {
            const $row = $(this).closest('.sale-item-row');
            const $option = $row.find('.modal-product-select option:selected');
            const stock = parseFloat($option.data('stock')) || 0;
            const quantity = parseFloat($row.find('.modal-item-quantity').val()) || 0;

            if (quantity > stock) {
                alert(`Only ${stock} units available in stock!`);
                $row.find('.modal-item-quantity').val(stock);
                return;
            }

            calculateModalItemTotal($row);
        });

        function calculateModalItemTotal($row) {
            const quantity = parseFloat($row.find('.modal-item-quantity').val()) || 0;
            const price = parseFloat($row.find('.modal-item-price').val()) || 0;
            const discountPercent = parseFloat($row.find('.modal-item-discount').val()) || 0;

            const subtotal = quantity * price;
            const discountAmount = subtotal * (discountPercent / 100);
            const total = subtotal - discountAmount;

            $row.find('.modal-item-total').val(total.toFixed(2));
            calculateModalTotals();
        }

        function calculateModalTotals() {
            let subtotal = 0;
            let totalDiscount = 0;
            let totalTax = 0;

            $('.sale-item-row').each(function() {
                const quantity = parseFloat($(this).find('.modal-item-quantity').val()) || 0;
                const price = parseFloat($(this).find('.modal-item-price').val()) || 0;
                const discountPercent = parseFloat($(this).find('.modal-item-discount').val()) || 0;
                const $option = $(this).find('.modal-product-select option:selected');
                const taxRate = parseFloat($option.data('tax')) || 0;

                const itemSubtotal = quantity * price;
                const discountAmount = itemSubtotal * (discountPercent / 100);
                const afterDiscount = itemSubtotal - discountAmount;
                const taxAmount = afterDiscount * (taxRate / 100);

                subtotal += itemSubtotal;
                totalDiscount += discountAmount;
                totalTax += taxAmount;
            });

            const grandTotal = subtotal - totalDiscount + totalTax;

            $('#modal_subtotal_display').text('PHP ' + subtotal.toFixed(2));
            $('#modal_discount_display').text('PHP ' + totalDiscount.toFixed(2));
            $('#modal_tax_display').text('PHP ' + totalTax.toFixed(2));
            $('#modal_grand_total_display').text('PHP ' + grandTotal.toFixed(2));
        }

        // Reset modal when closed
        $('#recordSaleModal').on('hidden.bs.modal', function() {
            $('#modalSaleForm')[0].reset();
            $('#modalSaleItemsContainer').empty();
            modalItemIndex = 0;
            updateModalEmptyState();
            calculateModalTotals();
        });

        // Show empty state when modal opens
        $('#recordSaleModal').on('shown.bs.modal', function() {
            updateModalEmptyState();
        });

        // Form submission validation
        $('#modalSaleForm').on('submit', function(e) {
            const itemCount = $('.sale-item-row').length;
            if (itemCount === 0) {
                e.preventDefault();
                alert('Please add at least one item to the sale!');
                return false;
            }
            return true;
        });
    </script>

    <!-- Record Sale Modal -->
    <div class="modal fade" id="recordSaleModal" tabindex="-1" aria-labelledby="recordSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24">
                    <div class="d-flex align-items-center gap-3">
                        
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="recordSaleModalLabel">Record New Sale</h5>
                            <p class="text-secondary-light mb-0" style="font-size: 13px;">Fill in the details to record a new sale</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24" style="max-height: 70vh; overflow-y: auto;">
                    <form action="{{ route('sales.store') }}" method="POST" id="modalSaleForm">
                        @csrf
                        
                        <!-- Sale Information -->
                        <div class="mb-24">
                            <h6 class="fw-bold mb-16" style="font-size: 18px !important;">Sale Information</h6>
                                <div class="row g-4">
                                    <!-- Date -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Sale Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="date" id="modal_sale_date" class="form-control" style="height: 44px;" value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <!-- Invoice Number -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Invoice Number
                                        </label>
                                        <input type="text" name="invoice_number" id="modal_invoice_number" class="form-control" style="height: 44px;" placeholder="Auto-generated">
                                        <small class="text-secondary-light" style="font-size: 12px;">Leave blank for auto-generation</small>
                                    </div>

                                    <!-- Customer -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Customer
                                        </label>
                                        <select name="customer_id" id="modal_customer_id" class="form-select" style="height: 44px;">
                                            <option value="">Walk-in Customer</option>
                                            @foreach($customers ?? [] as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sales Channel -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Sales Channel <span class="text-danger">*</span>
                                        </label>
                                        <select name="sales_channel_id" id="modal_sales_channel_id" class="form-select" style="height: 44px;" required>
                                            <option value="">Select Channel</option>
                                            @foreach($salesChannels ?? [] as $channel)
                                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Payment Method -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Payment Method
                                        </label>
                                        <select name="payment_method" id="modal_payment_method" class="form-select" style="height: 44px;">
                                            <option value="">Select Method</option>
                                            <option value="cash">Cash</option>
                                            <option value="card">Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="gcash">GCash</option>
                                            <option value="paymaya">PayMaya</option>
                                        </select>
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="col-md-3">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                            Payment Status <span class="text-danger">*</span>
                                        </label>
                                        <select name="payment_status" id="modal_payment_status" class="form-select" style="height: 44px;" required>
                                            <option value="paid">Paid</option>
                                            <option value="pending">Pending</option>
                                            <option value="partial">Partial</option>
                                        </select>
                                    </div>
                                </div>
                        </div>

                        <!-- Sale Items -->
                        <div class="mb-24">
                            <div class="d-flex justify-content-between align-items-center mb-16">
                                <h6 class="fw-bold mb-0" style="font-size: 18px !important;">Sale Items</h6>
                                <button type="button" class="btn btn-sm btn-primary-600 px-16 py-8" id="modalAddItemBtn">
                                    <i class="bi bi-circle-fill"></i>
                                    Add Item
                                </button>
                            </div>
                            
                            <!-- Empty State -->
                            <div id="modalEmptyState" class="text-center py-48 border radius-8 bg-neutral-50">
                                <i class="bi bi-circle-fill"></i>
                                <p class="text-secondary-light fw-semibold mb-8">No items added yet</p>
                                <p class="text-secondary-light text-sm mb-16">Click "Add Item" button to start adding products to this sale</p>
                                <button type="button" class="btn btn-primary-600 px-20 py-11 radius-8" onclick="document.getElementById('modalAddItemBtn').click()">
                                    <i class="bi bi-circle-fill"></i>
                                    Add First Item
                                </button>
                            </div>
                            
                            <div id="modalSaleItemsContainer" style="display: none;">
                                <!-- Items will be added dynamically -->
                            </div>
                        </div>

                        <!-- Totals Summary -->
                        <div class="mb-0">
                            <h6 class="fw-bold mb-16" style="font-size: 18px !important;">Order Summary</h6>
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Notes</label>
                                        <textarea name="notes" id="modal_notes" rows="4" class="form-control" style="resize: vertical;" placeholder="Additional information..."></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-16 bg-neutral-50 radius-8 h-100">
                                            <div class="d-flex flex-column gap-2 h-100 justify-content-center">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-secondary-light" style="font-size: 13px;">Subtotal:</span>
                                                    <span class="fw-semibold" id="modal_subtotal_display">PHP 0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-secondary-light" style="font-size: 13px;">Discount:</span>
                                                    <span class="fw-semibold" id="modal_discount_display">PHP 0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-secondary-light" style="font-size: 13px;">Tax:</span>
                                                    <span class="fw-semibold" id="modal_tax_display">PHP 0.00</span>
                                                </div>
                                                <hr class="my-2">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-bold">Grand Total:</span>
                                                    <span class="fw-bold text-primary-600" style="font-size: 18px;" id="modal_grand_total_display">PHP 0.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top py-16 px-24 bg-white">
                    <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                        <button type="button" class="btn text-secondary-light border border-neutral-200 hover-bg-neutral-100 radius-8 px-20 py-11" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" form="modalSaleForm" class="btn btn-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                            <i class="bi bi-circle-fill"></i>
                            Record Sale
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.master>

