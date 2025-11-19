<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div>
                <h6 class="fw-semibold mb-8">Add Stock</h6>
                <p class="text-secondary-light mb-0" style="font-size: 14px;">Select a product from the table below to add stock</p>
            </div>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('stock.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Stock
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add Stock</li>
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

        <!-- Products Table -->
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
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
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search products..." id="search-input">
                        <span class="icon">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="products-table" style="min-width: 1200px;">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 250px;">Product Name</th>
                                <th scope="col" style="min-width: 120px;">SKU</th>
                                <th scope="col" style="min-width: 100px;">Category</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Current Stock</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Current Cost</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Stock Value</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr class="product-row" 
                                data-product-id="{{ $product->id }}"
                                data-product-name="{{ $product->name }}"
                                data-product-sku="{{ $product->sku ?? 'N/A' }}"
                                data-product-stock="{{ $product->stock_quantity }}"
                                data-product-unit="{{ $product->unit ?? 'pcs' }}"
                                data-product-cost="{{ $product->cost }}">
                                <td>
                                    <span class="text-sm fw-semibold">{{ $product->name }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $product->sku ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $product->category->name ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold">{{ $product->stock_quantity }} {{ $product->unit ?? 'pcs' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ auth()->user()->business->currency }} {{ number_format($product->cost, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-primary-600">{{ auth()->user()->business->currency }} {{ number_format($product->stock_quantity * $product->cost, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-8 radius-8 d-flex align-items-center gap-1 add-stock-btn" style="margin: 0 auto;">
                                        <i class="bi bi-circle-fill"></i>
                                        Add Stock
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <span class="text-secondary-light">No products found</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Stock Modal -->
        <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" style="max-height: 90vh; margin: 1.75rem auto;">
                <div class="modal-content" style="max-height: 90vh;">
                    <form action="{{ route('stock.store') }}" method="POST" id="addStockForm">
                        @csrf
                        <input type="hidden" name="product_id" id="modal_product_id">
                        
                        <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                            <div>
                                <h5 class="modal-title text-white fw-bold mb-1" id="addStockModalLabel" style="font-size: 18px !important;">
                                    Add Stock Entry
                                </h5>
                                <p class="text-white mb-0" style="font-size: 13px; opacity: 0.9;" id="modal_product_name_display">-</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body px-24 py-24" style="overflow-y: auto;">
                            <!-- Current Product Information -->
                            <div class="mb-24">
                                <div class="row g-3">
                                    <div class="col-md-3 col-6">
                                        <div class="p-16 bg-neutral-50 radius-8 h-100">
                                            <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">Current Stock</span>
                                            <p class="text-dark fw-bold mb-0" style="font-size: 18px !important;" id="modal-current-stock">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="p-16 bg-neutral-50 radius-8 h-100">
                                            <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">Current Cost</span>
                                            <p class="text-dark fw-bold mb-0" style="font-size: 18px !important;" id="modal-current-cost">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="p-16 bg-neutral-50 radius-8 h-100">
                                            <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">Stock Value</span>
                                            <p class="text-primary-600 fw-bold mb-0" style="font-size: 18px !important;" id="modal-stock-value">-</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <div class="p-16 bg-neutral-50 radius-8 h-100">
                                            <span class="d-block text-secondary-light mb-8" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 500;">SKU</span>
                                            <p class="text-dark fw-bold mb-0" style="font-size: 16px !important;" id="modal-sku">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Entry Details Section -->
                            <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                                <div class="d-flex align-items-center gap-2 mb-16">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                        <i class="bi bi-box-seam text-white"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Stock Details</h6>
                                </div>
                                
                                <div class="row g-4">
                                    <!-- Date -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Date Received <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="date" name="date" class="form-control radius-8" value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Quantity <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="number" name="quantity" id="modal_quantity" class="form-control radius-8" placeholder="0" value="1" min="1" required>
                                        <small class="text-secondary-light d-block mt-4" style="font-size: 12px;" id="modal_unit_label">Units to add</small>
                                    </div>

                                    <!-- Reference Number -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Reference / PO Number
                                        </label>
                                        <input type="text" name="reference_number" class="form-control radius-8" placeholder="PO-12345, INV-67890...">
                                    </div>

                                    <!-- Supplier -->
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Supplier
                                        </label>
                                        <input type="text" name="supplier" class="form-control radius-8" placeholder="Supplier name or company">
                                    </div>
                                </div>
                            </div>

                            <!-- Cost Information Section -->
                            <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                                <div class="d-flex align-items-center gap-2 mb-16">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                        <i class="bi bi-currency-dollar text-white"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Cost Information</h6>
                                </div>
                                
                                <div class="row g-4">
                                    <!-- Cost Per Unit -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Cost Per Unit <span class="text-danger-600">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-warning-50 text-warning-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                            <input type="number" name="cost_per_unit" id="modal_cost_per_unit" step="0.01" class="form-control radius-8" placeholder="0.00" value="0" min="0" required>
                                        </div>
                                    </div>

                                    <!-- Additional Costs Collapsible -->
                                    <div class="col-12">
                                        <button class="btn btn-outline-danger btn-sm radius-8 mb-12 d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#additionalCostsCollapse" aria-expanded="false" style="border-color: #ec3737; color: #ec3737;">
                                            <i class="bi bi-plus-circle"></i>
                                            <span>Add Additional Costs (Optional)</span>
                                        </button>
                                        
                                        <div class="collapse" id="additionalCostsCollapse">
                                            <div class="p-16 bg-neutral-50 radius-8">
                                                <div class="row g-3">
                                                    <!-- Shipping/Freight Cost -->
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                            Shipping/Freight
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                            <input type="number" name="shipping_cost" id="modal_shipping_cost" step="0.01" class="form-control radius-8" placeholder="0.00" value="0" min="0">
                                                        </div>
                                                    </div>

                                                    <!-- Import Duties/Taxes -->
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                            Import Duties/Taxes
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                            <input type="number" name="import_duties" id="modal_import_duties" step="0.01" class="form-control radius-8" placeholder="0.00" value="0" min="0">
                                                        </div>
                                                    </div>

                                                    <!-- Other Transaction Costs -->
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                                            Other Costs
                                                        </label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                                            <input type="number" name="other_transaction_costs" id="modal_other_costs" step="0.01" class="form-control radius-8" placeholder="0.00" value="0" min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Cost -->
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Total Cost
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success-50 text-success-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                            <input type="text" id="modal_total_cost" class="form-control fw-semibold text-success-600 radius-8" placeholder="0.00" readonly>
                                        </div>
                                        <small class="text-secondary-light d-block mt-4" style="font-size: 12px;">Auto-calculated (Base Cost + Additional Costs)</small>
                                    </div>

                                    <!-- Cost Breakdown Display -->
                                    <div class="col-12" id="cost-breakdown-section" style="display: none;">
                                        <div class="p-16 radius-8" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border: 1px solid #fecaca;">
                                            <div class="d-flex align-items-center gap-2 mb-12">
                                                <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background-color: #ec3737; border-radius: 6px;">
                                                    <i class="bi bi-calculator text-white" style="font-size: 12px;"></i>
                                                </div>
                                                <h6 class="fw-bold mb-0" style="font-size: 15px; color: #4b5563;">Cost Breakdown</h6>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <div class="text-center p-12 bg-white radius-6">
                                                        <p class="text-secondary-light mb-4" style="font-size: 11px;">Base Cost</p>
                                                        <p class="fw-bold mb-0" style="font-size: 14px;" id="breakdown-base-cost">{{ auth()->user()->business->currency }} 0.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-12 bg-white radius-6">
                                                        <p class="text-secondary-light mb-4" style="font-size: 11px;">Additional Costs</p>
                                                        <p class="fw-bold mb-0" style="font-size: 14px;" id="breakdown-additional-costs">{{ auth()->user()->business->currency }} 0.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-12 bg-white radius-6">
                                                        <p class="text-secondary-light mb-4" style="font-size: 11px;">Cost Per Unit</p>
                                                        <p class="fw-bold mb-0" style="font-size: 14px;" id="breakdown-per-unit">{{ auth()->user()->business->currency }} 0.00</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center p-12 radius-6" style="background-color: #fff5f5;">
                                                        <p class="text-secondary-light mb-4" style="font-size: 11px;">True Cost Per Unit</p>
                                                        <p class="fw-bold mb-0" style="font-size: 14px; color: #ec3737;" id="breakdown-true-cost">{{ auth()->user()->business->currency }} 0.00</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Projected WAC Display -->
                                    <div class="col-12" id="modal-projected-wac" style="display: none;">
                                        <div class="p-16 bg-success-50 border border-success-100 radius-8">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="text-secondary-light mb-4" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">New Weighted Average Cost</p>
                                                    <p class="text-success-600 fw-bold mb-0" style="font-size: 20px;" id="modal-new-wac">-</p>
                                                </div>
                                                <div>
                                                    <p class="text-secondary-light mb-4" style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px;">New Total Stock</p>
                                                    <p class="text-success-600 fw-bold mb-0" style="font-size: 20px;" id="modal-new-total-stock">-</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                                <div class="d-flex align-items-center gap-2 mb-16">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                        <i class="bi bi-sticky text-white"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Additional Notes</h6>
                                </div>
                                
                                <div>
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                        Notes (Optional)
                                    </label>
                                    <textarea name="notes" rows="3" class="form-control radius-8" style="resize: vertical;" placeholder="Additional information about this stock entry..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer border-top py-16 px-24 bg-white">
                            <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                                <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle"></i>
                                    Cancel
                                </button>
                                <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                    <i class="bi bi-check-circle"></i>
                                    Save Stock Entry
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Load jQuery first -->
    <x-script/>

    <style>
        /* Product row clickable styling */
        .product-row {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        
        .product-row:hover {
            background-color: rgba(72, 127, 255, 0.05);
        }
        
        /* Force 18px font size for modal product info */
        #modal-current-stock,
        #modal-current-cost,
        #modal-stock-value,
        #modal-sku,
        #modal-new-wac,
        #modal-new-total-stock {
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
            margin: 0;
        }
        
        .dataTables_paginate .paginate_button:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: #487fff;
            border-color: #487fff;
            color: #ffffff;
            font-weight: 600;
        }
        
        .dataTables_paginate .paginate_button.current:hover {
            background: #3d6fde;
            border-color: #3d6fde;
            color: #ffffff;
        }
        
        .dataTables_paginate .paginate_button.disabled {
            cursor: not-allowed;
            opacity: 0.5;
            pointer-events: none;
        }
        
        .dataTables_paginate .paginate_button.disabled:hover {
            background: #ffffff;
            border-color: #e2e8f0;
            color: #64748b;
        }
        
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next,
        .dataTables_paginate .paginate_button.first,
        .dataTables_paginate .paginate_button.last {
            font-size: 16px;
            padding: 0;
            width: 36px;
        }
        
        .dataTables_paginate .paginate_button i {
            margin: 0;
            font-size: 16px;
        }
    </style>
    
    <script>
        $(document).ready(function() {
            // Only initialize DataTable if there are products
            var hasProducts = $("#products-table tbody tr").length > 0 && !$("#products-table tbody tr td[colspan]").length;
            
            if (!hasProducts) {
                console.log("No products to display, skipping DataTable initialization");
                return;
            }

            // Check if DataTable is already initialized
            if ($.fn.DataTable.isDataTable("#products-table")) {
                $("#products-table").DataTable().destroy();
            }

            // Initialize DataTable
            var table = $("#products-table").DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                "ordering": true,
                "searching": true,
                "info": true,
                "responsive": true,
                "autoWidth": false,
                "order": [[0, "asc"]],
                "pagingType": "full_numbers",
                "columns": [
                    { "orderable": true, "searchable": true },   // 0 - Product Name
                    { "orderable": true, "searchable": true },   // 1 - SKU
                    { "orderable": true, "searchable": true },   // 2 - Category
                    { "orderable": true, "searchable": false },  // 3 - Current Stock
                    { "orderable": true, "searchable": false },  // 4 - Current Cost
                    { "orderable": true, "searchable": false },  // 5 - Stock Value
                    { "orderable": false, "searchable": false }  // 6 - Action
                ],
                "columnDefs": [
                    {
                        "targets": [3, 4, 5], // Numeric columns (Stock, Cost, Value)
                        "className": "text-end"
                    },
                    {
                        "targets": [6], // Actions column
                        "className": "text-center"
                    }
                ],
                "language": {
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Search:",
                    "searchPlaceholder": "Search products...",
                    "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> products",
                    "infoEmpty": "Showing 0 to 0 of 0 products",
                    "infoFiltered": "(filtered from _MAX_ total products)",
                    "paginate": {
                        "first": "<i class=\"ph ph-caret-double-left\"></i>",
                        "last": "<i class=\"ph ph-caret-double-right\"></i>",
                        "next": "<i class=\"ph ph-caret-right\"></i>",
                        "previous": "<i class=\"ph ph-caret-left\"></i>"
                    },
                    "emptyTable": "No products found",
                    "zeroRecords": "No matching products found"
                },
                "dom": "<\"row\"<\"col-sm-12\"tr>>" +
                       "<\"row mt-24\"<\"col-sm-12 col-md-5\"<\"dataTables_info_wrapper\"i>><\"col-sm-12 col-md-7\"<\"dataTables_paginate_wrapper\"p>>>",
                "drawCallback": function(settings) {
                    // Re-bind modal click handlers after redraw
                    bindModalHandlers();
                    
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

            // Store current product data
            var currentProductData = {
                id: 0,
                name: '',
                sku: '',
                stock: 0,
                cost: 0,
                unit: 'pcs'
            };

            // Bind modal handlers function
            function bindModalHandlers() {
                // Open modal when clicking Add Stock button or row
                $('.add-stock-btn, .product-row').off('click').on('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    var $row = $(this).closest('tr');
                    
                    // Get product data from row
                    currentProductData = {
                        id: $row.data('product-id'),
                        name: $row.data('product-name'),
                        sku: $row.data('product-sku'),
                        stock: parseFloat($row.data('product-stock')) || 0,
                        cost: parseFloat($row.data('product-cost')) || 0,
                        unit: $row.data('product-unit') || 'pcs'
                    };
                    
                    // Populate modal
                    $('#modal_product_id').val(currentProductData.id);
                    $('#modal_product_name_display').text(currentProductData.name + ' - ' + currentProductData.sku);
                    $('#modal-current-stock').text(currentProductData.stock + ' ' + currentProductData.unit);
                    $('#modal-current-cost').text('{{ auth()->user()->business->currency }} ' + currentProductData.cost.toFixed(2));
                    $('#modal-stock-value').text('{{ auth()->user()->business->currency }} ' + (currentProductData.stock * currentProductData.cost).toLocaleString('en-PH', {minimumFractionDigits: 2}));
                    $('#modal-sku').text(currentProductData.sku);
                    $('#modal_unit_label').text(currentProductData.unit + ' to add');
                    
                    // Pre-fill cost
                    $('#modal_cost_per_unit').val(currentProductData.cost);
                    
                    // Calculate initial total
                    calculateModalTotal();
                    
                    // Show modal
                    $('#addStockModal').modal('show');
                });
            }

            // Initial bind
            bindModalHandlers();

            // Calculate total cost and WAC
            function calculateModalTotal() {
                var quantity = parseFloat($('#modal_quantity').val()) || 0;
                var costPerUnit = parseFloat($('#modal_cost_per_unit').val()) || 0;
                
                // Get additional costs
                var shippingCost = parseFloat($('#modal_shipping_cost').val()) || 0;
                var importDuties = parseFloat($('#modal_import_duties').val()) || 0;
                var otherCosts = parseFloat($('#modal_other_costs').val()) || 0;
                
                // Calculate costs
                var baseCost = quantity * costPerUnit;
                var totalAdditionalCosts = shippingCost + importDuties + otherCosts;
                var totalCost = baseCost + totalAdditionalCosts;
                
                // Calculate cost per unit (with and without additional costs)
                var additionalCostPerUnit = quantity > 0 ? totalAdditionalCosts / quantity : 0;
                var trueCostPerUnit = costPerUnit + additionalCostPerUnit;
                
                // Update total cost display
                $('#modal_total_cost').val(totalCost.toFixed(2));
                
                // Show/hide cost breakdown
                if (totalAdditionalCosts > 0 && quantity > 0) {
                    $('#cost-breakdown-section').show();
                    $('#breakdown-base-cost').text('{{ auth()->user()->business->currency }} ' + baseCost.toFixed(2));
                    $('#breakdown-additional-costs').text('{{ auth()->user()->business->currency }} ' + totalAdditionalCosts.toFixed(2));
                    $('#breakdown-per-unit').text('{{ auth()->user()->business->currency }} ' + costPerUnit.toFixed(2));
                    $('#breakdown-true-cost').text('{{ auth()->user()->business->currency }} ' + trueCostPerUnit.toFixed(2));
                } else {
                    $('#cost-breakdown-section').hide();
                }
                
                // Calculate WAC with true cost per unit
                if (quantity > 0 && trueCostPerUnit > 0) {
                    var currentTotalValue = currentProductData.stock * currentProductData.cost;
                    var newTotalValue = quantity * trueCostPerUnit;
                    var totalQty = currentProductData.stock + quantity;
                    var weightedAvgCost = (currentTotalValue + newTotalValue) / totalQty;
                    
                    $('#modal-new-wac').text('{{ auth()->user()->business->currency }} ' + weightedAvgCost.toFixed(2));
                    $('#modal-new-total-stock').text(totalQty + ' ' + currentProductData.unit);
                    $('#modal-projected-wac').show();
                } else {
                    $('#modal-projected-wac').hide();
                }
            }

            // Recalculate on input
            $('#modal_quantity, #modal_cost_per_unit, #modal_shipping_cost, #modal_import_duties, #modal_other_costs').on('input', calculateModalTotal);

            // Reset form when modal closes
            $('#addStockModal').on('hidden.bs.modal', function() {
                $('#addStockForm')[0].reset();
                $('#modal-projected-wac').hide();
                $('#cost-breakdown-section').hide();
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $(".alert").fadeOut("slow", function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>

</x-layout.master>
