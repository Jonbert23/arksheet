<x-layout.master>

    @push('styles')
    <style>
        @media print {
            /* Hide everything except the table */
            .sidebar,
            .navbar,
            .footer,
            .d-flex.flex-wrap.align-items-center.justify-content-between.gap-3.mb-24,
            .alert,
            .row.gy-4.mb-24,
            .card-header,
            .dataTables_filter,
            .dataTables_length,
            .dataTables_info,
            .dataTables_paginate {
                display: none !important;
            }

            /* Ensure table is visible */
            .card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }

            .card-body {
                padding: 0 !important;
            }

            /* Print title */
            body::before {
                content: "Invoice List - {{ auth()->user()->business->name }}";
                display: block;
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 20px;
                padding-bottom: 10px;
            }

            /* Optimize table for print */
            table {
                font-size: 12px !important;
            }

            table th,
            table td {
                padding: 8px 4px !important;
            }

            /* Hide action buttons in print */
            table td:last-child {
                display: none !important;
            }

            table th:last-child {
                display: none !important;
            }

            /* Print footer with date/time */
            body::after {
                content: "Printed on: " attr(data-print-date) " | Page " counter(page);
                display: block;
                position: fixed;
                bottom: 10px;
                right: 10px;
                font-size: 10px;
                color: #666;
            }

            /* Page break control */
            .card {
                page-break-inside: avoid;
            }

            tbody tr {
                page-break-inside: avoid;
            }
        }
    </style>
    @endpush

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Invoices</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Invoices</li>
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
            <!-- Total Invoices -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Total Invoices</span>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1" style="color: #ec3737; font-size: 1.5rem;">{{ $invoices->count() }}</h6>
                        <p class="text-sm mb-0">All time invoices</p>
                    </div>
                </div>
            </div>

            <!-- Total Amount -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Total Amount</span>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ auth()->user()->business->currency }} {{ number_format($invoices->sum('total'), 2) }}</h6>
                        <p class="text-sm mb-0">All time invoice amount</p>
                    </div>
                </div>
            </div>

            <!-- Paid Invoices -->
            <div class="col-xxl-3 col-sm-6">
                <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-info-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <span class="text-secondary-light text-lg fw-medium">Paid</span>
                            </div>
                        </div>
                        <h6 class="fw-semibold mb-1">{{ $invoices->filter(function($inv) { return strtolower($inv->payment_status) === 'paid'; })->count() }}</h6>
                        <p class="text-sm mb-0">Paid invoices</p>
                    </div>
                </div>
            </div>

            <!-- Pending Invoices -->
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
                        <h6 class="fw-semibold mb-1">{{ $invoices->filter(function($inv) { return strtolower($inv->payment_status) === 'pending'; })->count() }}</h6>
                        <p class="text-sm mb-0">Pending payment</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Table -->
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-sm text-secondary-light fw-medium">Show</span>
                        <select class="form-select form-select-sm w-auto" id="entries-select" style="min-width: 70px;">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="icon-field">
                        <input type="text" class="form-control form-control-sm w-auto" placeholder="Search invoices..." id="invoice-search-input" style="min-width: 250px;">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button type="button" id="printBtn" class="btn text-white text-sm btn-sm px-20 py-11 radius-8 d-flex align-items-center gap-2 fw-semibold shadow-sm" style="background-color: #ec3737; border: none; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(236, 55, 55, 0.35)'" onmouseout="this.style.backgroundColor='#ec3737'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(236, 55, 55, 0.25)'">
                        <i class="bi bi-circle-fill"></i>
                        Print List
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table class="table bordered-table mb-0" id="invoicesTable">
                    <thead>
                        <tr>
                            <th scope="col" style="min-width: 120px;">Invoice #</th>
                            <th scope="col" style="min-width: 100px;">Date</th>
                            <th scope="col" style="min-width: 150px;">Customer</th>
                            <th scope="col" style="min-width: 120px;">Channel</th>
                            <th scope="col" class="text-end" style="min-width: 100px;">Subtotal</th>
                            <th scope="col" class="text-end" style="min-width: 100px;">Tax</th>
                            <th scope="col" class="text-end" style="min-width: 100px;">Discount</th>
                            <th scope="col" class="text-end" style="min-width: 120px;">Total</th>
                            <th scope="col" class="text-center" style="min-width: 120px;">Payment</th>
                            <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="text-primary-600 fw-semibold">
                                        {{ $invoice->invoice_number }}
                                    </a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-circle-fill"></i>
                                        <span class="fw-medium">{{ $invoice->customer->name ?? 'Walk-in Customer' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-sm fw-semibold text-secondary-light border">
                                        {{ $invoice->salesChannel->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-end">{{ auth()->user()->business->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                                <td class="text-end">{{ auth()->user()->business->currency }} {{ number_format($invoice->tax, 2) }}</td>
                                <td class="text-end">
                                    @if($invoice->discount > 0)
                                        <span class="fw-semibold" style="color: #ec3737;">
                                            -{{ auth()->user()->business->currency }} {{ number_format($invoice->discount, 2) }}
                                        </span>
                                    @else
                                        <span class="text-secondary-light">{{ auth()->user()->business->currency }} 0.00</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-primary-600">
                                        {{ auth()->user()->business->currency }} {{ number_format($invoice->total, 2) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if(strtolower($invoice->payment_status) === 'paid')
                                        <span class="badge bg-success-100 text-success-600 px-16 py-6 fw-semibold">Paid</span>
                                    @elseif(strtolower($invoice->payment_status) === 'partial')
                                        <span class="badge bg-warning-100 text-warning-600 px-16 py-6 fw-semibold">Partial</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-16 py-6 fw-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('invoices.show', $invoice->id) }}" 
                                           class="btn btn-sm px-12 py-8 text-white radius-4" 
                                           style="background-color: #ec3737;"
                                           title="View Invoice">
                                            <i class="bi bi-circle-fill"></i>
                                        </a>
                                        <a href="{{ route('invoices.show', $invoice->id) }}" 
                                           target="_blank"
                                           class="btn btn-sm px-12 py-8 bg-info-600 text-white radius-4"
                                           title="Print Invoice">
                                            <i class="bi bi-circle-fill"></i>
                                        </a>
                                        <a href="{{ route('invoices.download', $invoice->id) }}" 
                                           class="btn btn-sm px-12 py-8 bg-success-600 text-white radius-4"
                                           title="Download PDF">
                                            <i class="bi bi-circle-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px;">
                                        <i class="bi bi-circle-fill"></i>
                                        <p class="text-secondary-light mb-0">No invoices found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Only initialize DataTable if there are invoices
            var hasInvoices = $("#invoicesTable tbody tr").length > 0 && !$("#invoicesTable tbody tr td[colspan]").length;
            
            if (!hasInvoices) {
                console.log("No invoices to display, skipping DataTable initialization");
                return;
            }

            // Check if DataTable is already initialized
            if ($.fn.DataTable.isDataTable("#invoicesTable")) {
                $("#invoicesTable").DataTable().destroy();
            }

            // Initialize DataTable
            var table = $("#invoicesTable").DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "ordering": true,
                "searching": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "order": [[1, "desc"]], // Sort by date descending
                "pagingType": "full_numbers",
                "dom": 'rtip', // Hide default length menu and search box, show only table, info, and pagination
                "columns": [
                    { "orderable": true, "searchable": true },   // 0 - Invoice #
                    { "orderable": true, "searchable": false },  // 1 - Date
                    { "orderable": true, "searchable": true },   // 2 - Customer
                    { "orderable": true, "searchable": true },   // 3 - Channel
                    { "orderable": true, "searchable": false },  // 4 - Subtotal
                    { "orderable": true, "searchable": false },  // 5 - Tax
                    { "orderable": true, "searchable": false },  // 6 - Discount
                    { "orderable": true, "searchable": false },  // 7 - Total
                    { "orderable": true, "searchable": false },  // 8 - Payment
                    { "orderable": false, "searchable": false }  // 9 - Actions
                ],
                "columnDefs": [
                    {
                        "targets": [4, 5, 6, 7], // Numeric columns (Subtotal, Tax, Discount, Total)
                        "className": "text-end"
                    },
                    {
                        "targets": [8, 9], // Center-aligned columns (Payment, Actions)
                        "className": "text-center"
                    }
                ],
                "language": {
                    "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "paginate": {
                        "first": "<i class=\"ph ph-caret-double-left\"></i>",
                        "last": "<i class=\"ph ph-caret-double-right\"></i>",
                        "next": "<i class=\"ph ph-caret-right\"></i>",
                        "previous": "<i class=\"ph ph-caret-left\"></i>"
                    },
                    "emptyTable": "No invoices available",
                    "zeroRecords": "No matching invoices found"
                }
            });

            // Custom length control
            $('#entries-select').on('change', function() {
                var length = $(this).val();
                table.page.len(parseInt(length)).draw();
            });

            // Custom search control
            $('#invoice-search-input').on('keyup', function() {
                table.search($(this).val()).draw();
            });

            // Print functionality - show all entries
            $('#printBtn').on('click', function() {
                // Store current page length
                var currentLength = table.page.len();
                
                // Add print date to body
                var now = new Date();
                var printDate = now.toLocaleString('en-US', { 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                $('body').attr('data-print-date', printDate);
                
                // Set to show all entries
                table.page.len(-1).draw();
                
                // Small delay to ensure rendering, then print
                setTimeout(function() {
                    window.print();
                    
                    // Restore original page length after print dialog closes
                    setTimeout(function() {
                        table.page.len(currentLength).draw();
                        $('body').removeAttr('data-print-date');
                    }, 100);
                }, 100);
            });
        });
    </script>
    @endpush

</x-layout.master>

