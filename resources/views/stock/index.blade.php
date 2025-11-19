<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Stock Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Stock</li>
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

        <!-- Summary Stats (Dashboard Style) -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-secondary-light mb-1">Total Stock Entries</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ $stockIns->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                <i class="bi bi-circle-fill"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Total Units Received</p>
                                <h6 class="mb-0">{{ number_format($stockIns->sum('quantity')) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Total Stock Value</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($stockIns->sum('total_cost'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Avg. Cost Per Unit</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ $stockIns->count() > 0 ? number_format($stockIns->avg('cost_per_unit'), 2) : '0.00' }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
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
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search stock entries..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                    </div>
                </div>
                <a href="{{ route('stock.create') }}" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-circle-fill"></i>
                    Add Stock
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="stock-table" style="min-width: 1400px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 120px;">Date</th>
                                <th scope="col" style="min-width: 200px;">Product</th>
                                <th scope="col" style="min-width: 120px;">Reference No.</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Quantity</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Cost Per Unit</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Total Cost</th>
                                <th scope="col" style="min-width: 150px;">Supplier</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stockIns as $index => $stockIn)
                            <tr data-stock-id="{{ $stockIn->id }}"
                                data-stock-product-id="{{ $stockIn->product_id }}"
                                data-stock-product-name="{{ $stockIn->product->name }}"
                                data-stock-product-sku="{{ $stockIn->product->sku ?? 'N/A' }}"
                                data-stock-product-unit="{{ $stockIn->product->unit ?? 'pcs' }}"
                                data-stock-quantity="{{ $stockIn->quantity }}"
                                data-stock-cost="{{ $stockIn->cost_per_unit }}"
                                data-stock-total="{{ $stockIn->total_cost }}"
                                data-stock-shipping="{{ $stockIn->shipping_cost ?? 0 }}"
                                data-stock-duties="{{ $stockIn->import_duties ?? 0 }}"
                                data-stock-other="{{ $stockIn->other_transaction_costs ?? 0 }}"
                                data-stock-supplier="{{ $stockIn->supplier ?? '' }}"
                                data-stock-reference="{{ $stockIn->reference_number ?? '' }}"
                                data-stock-date="{{ $stockIn->date->format('Y-m-d') }}"
                                data-stock-notes="{{ $stockIn->notes ?? '' }}">
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $stockIn->date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm fw-semibold">{{ $stockIn->product->name }}</span>
                                        <span class="text-xs text-secondary-light">SKU: {{ $stockIn->product->sku ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $stockIn->reference_number ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-primary-100 text-primary-600 px-16 py-6">
                                        +{{ number_format($stockIn->quantity) }} {{ $stockIn->product->unit ?? 'pcs' }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ number_format($stockIn->cost_per_unit, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-success-600">{{ number_format($stockIn->total_cost, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $stockIn->supplier ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <a href="{{ route('stock.show', $stockIn->id) }}" class="bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle" title="View">
                                            <i class="bi bi-circle-fill"></i>
                                        </a>
                                        <button type="button" class="edit-stock-btn bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Edit">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                        <form action="{{ route('stock.destroy', $stockIn->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <i class="bi bi-circle-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-48">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #fff5f5; border-radius: 50%; margin: 0 auto 16px;">
                                        <i class="bi bi-inbox" style="font-size: 2.5rem; color: #ec3737;"></i>
                                    </div>
                                    <p class="text-secondary-light fw-semibold mb-16">No stock entries found</p>
                                    <a href="{{ route('stock.create') }}" class="btn text-white radius-8 px-24 py-11 fw-bold" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                        <i class="bi bi-plus-circle"></i>
                                        Add Your First Stock Entry
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

    <!-- Edit Stock Modal -->
    <div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content radius-12">
                <form action="" method="POST" id="editStockForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="product_id" id="edit_product_id">
                    
                    <div class="modal-header border-bottom py-16 px-24">
                        <div class="d-flex align-items-center gap-3">
                            <div class="w-40-px h-40-px bg-success-100 text-success-600 rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-0" id="editStockModalLabel">Edit Stock Entry</h5>
                                <p class="text-secondary-light mb-0" style="font-size: 13px;" id="edit_product_name_display">-</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body px-24 py-24">
                        <!-- Product Info Display -->
                        <div class="mb-24">
                            <div class="row g-3">
                                <div class="col-md-4 col-6">
                                    <div class="p-16 bg-neutral-50 radius-8 h-100">
                                        <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">Product</span>
                                        <p class="text-dark fw-bold mb-0" style="font-size: 18px !important;" id="edit-product-name">-</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="p-16 bg-neutral-50 radius-8 h-100">
                                        <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">SKU</span>
                                        <p class="text-dark fw-bold mb-0" style="font-size: 16px !important;" id="edit-product-sku">-</p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div class="p-16 bg-neutral-50 radius-8 h-100">
                                        <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">Unit</span>
                                        <p class="text-dark fw-bold mb-0" style="font-size: 18px !important;" id="edit-product-unit">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Entry Form -->
                        <div class="row g-4">
                            <!-- Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Date Received <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="date" id="edit_date" class="form-control" style="height: 44px;" required>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Quantity <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="quantity" id="edit_quantity" class="form-control" style="height: 44px;" placeholder="0" min="1" required>
                                <small class="text-secondary-light d-block mt-4" style="font-size: 12px;" id="edit_unit_label">Units</small>
                            </div>

                            <!-- Reference Number -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Reference / PO Number
                                </label>
                                <input type="text" name="reference_number" id="edit_reference" class="form-control" style="height: 44px;" placeholder="PO-12345, INV-67890...">
                            </div>

                            <!-- Supplier -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Supplier
                                </label>
                                <input type="text" name="supplier" id="edit_supplier" class="form-control" style="height: 44px;" placeholder="Supplier name or company">
                            </div>

                            <!-- Cost Per Unit -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Cost Per Unit <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-warning-50 text-warning-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                    <input type="number" name="cost_per_unit" id="edit_cost_per_unit" step="0.01" class="form-control" style="height: 44px;" placeholder="0.00" min="0" required>
                                </div>
                            </div>

                            <!-- Additional Costs Section -->
                            <div class="col-12">
                                <div class="p-16 bg-white border radius-8">
                                    <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #212529;">Additional Costs (Optional)</h6>
                                    <div class="row g-3">
                                        <!-- Shipping/Freight Cost -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                                Shipping/Freight
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                <input type="number" name="shipping_cost" id="edit_shipping_cost" step="0.01" class="form-control" style="height: 44px;" placeholder="0.00" value="0" min="0">
                                            </div>
                                        </div>

                                        <!-- Import Duties/Taxes -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                                Import Duties/Taxes
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                <input type="number" name="import_duties" id="edit_import_duties" step="0.01" class="form-control" style="height: 44px;" placeholder="0.00" value="0" min="0">
                                            </div>
                                        </div>

                                        <!-- Other Transaction Costs -->
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                                Other Costs
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                <input type="number" name="other_transaction_costs" id="edit_other_costs" step="0.01" class="form-control" style="height: 44px;" placeholder="0.00" value="0" min="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Cost -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Total Cost
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success-50 text-success-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                    <input type="text" id="edit_total_cost" class="form-control fw-semibold text-success-600" style="height: 44px;" placeholder="0.00" readonly>
                                </div>
                                <small class="text-secondary-light d-block mt-4" style="font-size: 12px;">Auto-calculated (Base Cost + Additional Costs)</small>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Notes
                                </label>
                                <textarea name="notes" id="edit_notes" rows="3" class="form-control" style="resize: vertical;" placeholder="Additional information..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top py-16 px-24 bg-white">
                        <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                            <button type="button" class="btn text-secondary-light border border-neutral-200 hover-bg-neutral-100 radius-8 px-20 py-11" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                                <i class="bi bi-circle-fill"></i>
                                Update Stock Entry
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $hasStockEntries = $stockIns->count() > 0;
        $script = '<script>
            $(document).ready(function() {';
        
        if ($hasStockEntries) {
            $script .= '
                // Check if DataTable is already initialized
                if ($.fn.DataTable.isDataTable("#stock-table")) {
                    $("#stock-table").DataTable().destroy();
                }

                // Initialize DataTable
                var table = $("#stock-table").DataTable({
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                    "ordering": true,
                    "searching": true,
                    "info": true,
                    "responsive": true,
                    "autoWidth": false,
                    "order": [[1, "desc"]],
                    "pagingType": "full_numbers",
                    "columns": [
                        { "orderable": false, "searchable": false },  // 0 - No.
                        { "orderable": true, "searchable": false },   // 1 - Date
                        { "orderable": true, "searchable": true },    // 2 - Product
                        { "orderable": true, "searchable": true },    // 3 - Reference No.
                        { "orderable": true, "searchable": false },   // 4 - Quantity
                        { "orderable": true, "searchable": false },   // 5 - Cost Per Unit
                        { "orderable": true, "searchable": false },   // 6 - Total Cost
                        { "orderable": true, "searchable": true },    // 7 - Supplier
                        { "orderable": false, "searchable": false }   // 8 - Actions
                    ],
                    "columnDefs": [
                        {
                            "targets": [4, 5, 6], // Numeric columns
                            "className": "text-end"
                        },
                        {
                            "targets": [8], // Actions column
                            "className": "text-center"
                        }
                    ],
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "searchPlaceholder": "Search stock entries...",
                        "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "paginate": {
                            "first": "<i class=\"ph ph-caret-double-left\"></i>",
                            "last": "<i class=\"ph ph-caret-double-right\"></i>",
                            "next": "<i class=\"ph ph-caret-right\"></i>",
                            "previous": "<i class=\"ph ph-caret-left\"></i>"
                        },
                        "emptyTable": "No stock entries found",
                        "zeroRecords": "No matching stock entries found"
                    },
                    "dom": "<\"row\"<\"col-sm-12\"tr>>" +
                           "<\"row mt-24\"<\"col-sm-12 col-md-5\"<\"dataTables_info_wrapper\"i>><\"col-sm-12 col-md-7\"<\"dataTables_paginate_wrapper\"p>>>",
                    "drawCallback": function(settings) {
                        // Re-bind handlers after redraw
                        bindDeleteConfirmation();
                        bindEditHandlers();
                    }
                });

                // Connect custom search input to DataTable
                $("#search-input").on("keyup", function() {
                    table.search(this.value).draw();
                });

                // Connect custom length selector to DataTable
                $("#entries-per-page").on("change", function() {
                    table.page.len($(this).val()).draw();
                });';
        }
        
        // Common functions that run regardless of whether there are stock entries
        $script .= '

                // Delete confirmation function
                function bindDeleteConfirmation() {
                    $(".delete-btn").off("click").on("click", function(e) {
                        e.preventDefault();
                        const form = $(this).closest("form");
                        const productName = $(this).closest("tr").find("td:eq(2)").text().trim();
                        
                        if (confirm("Are you sure you want to delete this stock entry for \"" + productName + "\"?\\n\\nThis will also reduce the product stock quantity.")) {
                            form.submit();
                        }
                    });
                }

                // Initial bind
                bindDeleteConfirmation();

                // Edit Stock Modal Handler
                function bindEditHandlers() {
                    $(".edit-stock-btn").off("click").on("click", function(e) {
                        e.preventDefault();
                        
                        var $row = $(this).closest("tr");
                        var stockId = $row.data("stock-id");
                        var productId = $row.data("stock-product-id");
                        var productName = $row.data("stock-product-name");
                        var productSku = $row.data("stock-product-sku");
                        var productUnit = $row.data("stock-product-unit");
                        var quantity = $row.data("stock-quantity");
                        var cost = $row.data("stock-cost");
                        var shippingCost = $row.data("stock-shipping");
                        var importDuties = $row.data("stock-duties");
                        var otherCosts = $row.data("stock-other");
                        var supplier = $row.data("stock-supplier");
                        var reference = $row.data("stock-reference");
                        var date = $row.data("stock-date");
                        var notes = $row.data("stock-notes");
                        
                        // Update form action
                        $("#editStockForm").attr("action", "/stock/" + stockId);
                        
                        // Populate modal fields
                        $("#edit_product_id").val(productId);
                        $("#edit_product_name_display").text(productName + " - " + productSku);
                        $("#edit-product-name").text(productName);
                        $("#edit-product-sku").text(productSku);
                        $("#edit-product-unit").text(productUnit);
                        $("#edit_date").val(date);
                        $("#edit_quantity").val(quantity);
                        $("#edit_cost_per_unit").val(cost);
                        $("#edit_shipping_cost").val(shippingCost);
                        $("#edit_import_duties").val(importDuties);
                        $("#edit_other_costs").val(otherCosts);
                        $("#edit_supplier").val(supplier);
                        $("#edit_reference").val(reference);
                        $("#edit_notes").val(notes);
                        $("#edit_unit_label").text(productUnit + " to add");
                        
                        // Calculate total cost
                        calculateEditTotal();
                        
                        // Show modal
                        $("#editStockModal").modal("show");
                    });
                }

                // Calculate total cost for edit modal
                function calculateEditTotal() {
                    var quantity = parseFloat($("#edit_quantity").val()) || 0;
                    var costPerUnit = parseFloat($("#edit_cost_per_unit").val()) || 0;
                    var shippingCost = parseFloat($("#edit_shipping_cost").val()) || 0;
                    var importDuties = parseFloat($("#edit_import_duties").val()) || 0;
                    var otherCosts = parseFloat($("#edit_other_costs").val()) || 0;
                    
                    var baseCost = quantity * costPerUnit;
                    var totalAdditionalCosts = shippingCost + importDuties + otherCosts;
                    var totalCost = baseCost + totalAdditionalCosts;
                    
                    $("#edit_total_cost").val(totalCost.toFixed(2));
                }

                // Recalculate on input change
                $("#edit_quantity, #edit_cost_per_unit, #edit_shipping_cost, #edit_import_duties, #edit_other_costs").on("input", calculateEditTotal);

                // Bind edit handlers initially and after DataTable redraws
                bindEditHandlers();

                // Auto-dismiss alerts after 5 seconds
                setTimeout(function() {
                    $(".alert").fadeOut("slow", function() {
                        $(this).remove();
                    });
                }, 5000);
            });
        </script>';
        
        echo $script;
    @endphp
        
        <style>
            /* Edit Modal Product Info Styling */
            #edit-product-name,
            #edit-product-sku,
            #edit-product-unit {
                font-size: 18px !important;
            }
            
            /* DataTables Pagination Styling */
            .dataTables_info_wrapper {
                display: flex;
                align-items: center;
            }
            
            .dataTables_info {
                color: #6c757d;
                font-size: 14px;
                font-weight: 500;
                margin: 0;
            }
            
            .dataTables_info strong {
                color: #2d3748;
                font-weight: 600;
            }
            
            .dataTables_paginate_wrapper {
                display: flex;
                justify-content: flex-end;
            }
            
            .dataTables_paginate {
                display: flex;
                align-items: center;
                gap: 4px;
            }
            
            .dataTables_paginate .paginate_button {
                min-width: 36px;
                height: 36px;
                padding: 0 12px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid #e2e8f0;
                background: #ffffff;
                color: #64748b;
                font-size: 14px;
                font-weight: 500;
                border-radius: 6px;
                cursor: pointer;
                transition: all 0.2s ease;
                text-decoration: none;
            }
            
            .dataTables_paginate .paginate_button:hover:not(.disabled) {
                background: #f8fafc;
                border-color: #cbd5e1;
                color: #475569;
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }
            
            .dataTables_paginate .paginate_button.current {
                background: linear-gradient(135deg, #487FFF 0%, #3b6fd9 100%);
                border-color: #487FFF;
                color: #ffffff;
                font-weight: 600;
                box-shadow: 0 2px 8px rgba(72, 127, 255, 0.3);
            }
            
            .dataTables_paginate .paginate_button.current:hover {
                background: linear-gradient(135deg, #3b6fd9 0%, #2d5bb7 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(72, 127, 255, 0.4);
            }
            
            .dataTables_paginate .paginate_button.disabled {
                opacity: 0.4;
                cursor: not-allowed;
                pointer-events: none;
            }
            
            .dataTables_paginate .paginate_button i {
                font-size: 16px;
                line-height: 1;
            }
            
            /* Responsive adjustments */
            @media (max-width: 768px) {
                .dataTables_info_wrapper,
                .dataTables_paginate_wrapper {
                    justify-content: center;
                    margin-top: 12px;
                }
                
                .dataTables_paginate .paginate_button {
                    min-width: 32px;
                    height: 32px;
                    padding: 0 8px;
                    font-size: 13px;
                }
            }
        </style>

    <x-script/>
    {!! $script !!}

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
        #stock-table tbody tr:hover {
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

</x-layout.master>

