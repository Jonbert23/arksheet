<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Products Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Products</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
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
                                <p class="fw-medium text-secondary-light mb-1">Total Products</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ $products->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                <i class="bi bi-box-seam text-white"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Avg. Item Price</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($products->avg('price'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-currency-dollar text-white"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Avg. Cost</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($products->avg('cost'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-cash-stack text-white"></i>
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
                                <p class="fw-medium text-primary-light mb-1">Avg. Profit Margin</p>
                                <h6 class="mb-0">{{ number_format($products->avg(function($product) { return $product->getProfitMargin(); }), 0) }}%</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-percent text-white"></i>
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
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search products..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <button type="button" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    <i class="bi bi-plus-circle"></i>
                    Add New Product
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table bordered-table mb-0" id="products-table" style="min-width: 1350px;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 180px;">Product / Service Name</th>
                                <th scope="col" style="min-width: 120px;">Item Code (SKU)</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Item Cost</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Tax Amount</th>
                                <th scope="col" class="text-end" style="min-width: 100px;">Total Costs</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Item Selling Price</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Estimated Profit</th>
                                <th scope="col" class="text-center" style="min-width: 100px;">Profit Margin</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                            <tr>
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="text-sm fw-semibold">{{ $product->name }}</span>
                                        @if($product->type === 'service')
                                            <span class="badge bg-info-100 text-info-600 text-xs">Service</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="text-sm text-secondary-light">{{ $product->sku ?? '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ number_format($product->cost, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ number_format($product->tax_amount, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-primary-600">{{ number_format($product->getTotalCosts(), 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold">{{ number_format($product->price, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-success-600">{{ number_format($product->getEstimatedProfit(), 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $product->getProfitMargin() >= 50 ? 'success' : ($product->getProfitMargin() >= 30 ? 'warning' : 'danger') }}-100 text-{{ $product->getProfitMargin() >= 50 ? 'success' : ($product->getProfitMargin() >= 30 ? 'warning' : 'danger') }}-600 px-16 py-6">
                                        {{ $product->getProfitMargin() }}%
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="view-product-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-sku="{{ $product->sku ?? 'N/A' }}"
                                            data-product-category="{{ $product->category ? $product->category->name : 'No Category' }}"
                                            data-product-type="{{ $product->type ?? 'product' }}"
                                            data-product-description="{{ $product->description ?? 'No description provided' }}"
                                            data-product-price="{{ number_format($product->price, 2) }}"
                                            data-product-cost="{{ number_format($product->cost, 2) }}"
                                            data-product-tax="{{ number_format($product->tax_amount, 2) }}"
                                            data-product-total-cost="{{ number_format($product->cost + $product->tax_amount, 2) }}"
                                            data-product-margin="{{ $product->getProfitMargin() }}"
                                            data-product-stock="{{ $product->stock_quantity }}"
                                            data-product-unit="{{ $product->unit ?? 'N/A' }}"
                                            data-product-min-stock="{{ $product->min_stock_alert }}"
                                            data-product-status="{{ $product->is_active ? 'Active' : 'Inactive' }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button type="button" class="edit-product-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-product-id="{{ $product->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle delete-btn border-0" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-48">
                                    <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background-color: #fff5f5; border-radius: 50%; margin: 0 auto 16px;">
                                        <i class="bi bi-inbox" style="font-size: 2.5rem; color: #ec3737;"></i>
                                    </div>
                                    <p class="text-secondary-light fw-semibold mb-16">No products found</p>
                                    <a href="{{ route('products.create') }}" class="btn text-white radius-8 px-24 py-11 fw-bold" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                        <i class="bi bi-plus-circle"></i>
                                        Add Your First Product
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

    @php
        $hasProducts = $products->count() > 0;
        $script = '<script>
            $(document).ready(function() {';
        
        if ($hasProducts) {
            $script .= '
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
                        { "orderable": true, "searchable": false },  // 0 - No.
                        { "orderable": true, "searchable": true },   // 1 - Product Name
                        { "orderable": true, "searchable": true },   // 2 - SKU
                        { "orderable": true, "searchable": false },  // 3 - Item Cost
                        { "orderable": true, "searchable": false },  // 4 - Tax Amount
                        { "orderable": true, "searchable": false },  // 5 - Total Costs
                        { "orderable": true, "searchable": false },  // 6 - Selling Price
                        { "orderable": true, "searchable": false },  // 7 - Estimated Profit
                        { "orderable": true, "searchable": false },  // 8 - Profit Margin
                        { "orderable": false, "searchable": false }  // 9 - Actions
                    ],
                    "columnDefs": [
                        {
                            "targets": [3, 4, 5, 6, 7], // Numeric columns
                            "className": "text-end"
                        },
                        {
                            "targets": [8], // Profit Margin
                            "className": "text-center"
                        },
                        {
                            "targets": [9], // Actions column
                            "className": "text-center"
                        }
                    ],
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "searchPlaceholder": "Search products...",
                        "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries",
                        "infoEmpty": "Showing 0 to 0 of 0 entries",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
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
                        // Re-bind delete confirmation after redraw
                        bindDeleteConfirmation();
                        
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
                });';
        }
        
        // Common functions that run regardless of whether there are products
        $script .= '

                // Delete confirmation function
                function bindDeleteConfirmation() {
                    $(".delete-btn").off("click").on("click", function(e) {
                        e.preventDefault();
                        const form = $(this).closest("form");
                        const productName = $(this).closest("tr").find("td:eq(1)").text().trim();
                        
                        if (confirm("Are you sure you want to delete \"" + productName + "\"?\\n\\nThis action cannot be undone.")) {
                            form.submit();
                        }
                    });
                }

                // Initial bind
                bindDeleteConfirmation();

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
            
            .dataTables_paginate .paginate_button.previous,
            .dataTables_paginate .paginate_button.next,
            .dataTables_paginate .paginate_button.first,
            .dataTables_paginate .paginate_button.last {
                font-weight: 600;
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
            color: #ec3737!important;
        }
        
        /* Hover effects for table rows */
        #products-table tbody tr:hover {
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
        
        /* DataTable length select and search input */
        .dataTables_length select:focus,
        .dataTables_filter input:focus {
            border-color: #ec3737 !important;
            outline: none !important;
            box-shadow: 0 0 0 0.2rem rgba(236, 55, 55, 0.15) !important;
        }
        
        /* Smooth transitions */
        .btn {
            transition: all 0.3s ease;
        }
        
        /* View Product Modal Styles */
        #viewProductModal .modal-body {
            max-height: 70vh;
            overflow-y: auto !important;
        }
        
        #viewProductModal .modal-body h6 {
            font-size: 18px !important;
        }
        
        #viewProductModal .modal-body label {
            font-size: 14px !important;
        }
        
        #viewProductModal .modal-body p {
            font-size: 15px !important;
        }
        
        /* Key Metrics Cards */
        #viewProductModal .card-body p {
            font-size: 12px !important;
        }
        
        #viewProductModal .card-body h6 {
            font-size: 18px !important;
        }
        
        /* Pricing Breakdown */
        #viewProductModal .border-bottom {
            border-color: #e5e7eb !important;
        }
    </style>

    <!-- View Product Modal -->
    <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-1" id="viewProductModalLabel" style="font-size: 18px !important;">
                            Product Details
                        </h5>
                        <p class="text-white mb-0" style="font-size: 13px; opacity: 0.9;" id="view_product_subtitle">-</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body px-24 py-24">
                    <!-- Key Metrics Cards -->
                    <div class="row g-3 mb-24">
                        <div class="col-md-3 col-6">
                            <div class="card border-0 radius-8 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 3px solid #10b981 !important;">
                                <div class="card-body p-12">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-tag-fill text-success-600" style="font-size: 16px;"></i>
                                        <p class="text-secondary-light mb-0" style="font-size: 12px;">Selling Price</p>
                                    </div>
                                    <h6 class="mb-0 text-success-600 fw-bold" style="font-size: 18px;" id="view-metric-price">-</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6">
                            <div class="card border-0 radius-8 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 3px solid #ec3737 !important;">
                                <div class="card-body p-12">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-graph-up text-danger" style="font-size: 16px;"></i>
                                        <p class="text-secondary-light mb-0" style="font-size: 12px;">Profit Margin</p>
                                    </div>
                                    <h6 class="mb-0 fw-bold" style="font-size: 18px; color: #ec3737;" id="view-metric-margin">-</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6">
                            <div class="card border-0 radius-8 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 3px solid #3b82f6 !important;">
                                <div class="card-body p-12">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-boxes text-primary-600" style="font-size: 16px;"></i>
                                        <p class="text-secondary-light mb-0" style="font-size: 12px;">In Stock</p>
                                    </div>
                                    <h6 class="mb-0 text-primary-600 fw-bold" style="font-size: 18px;" id="view-metric-stock">-</h6>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 col-6">
                            <div class="card border-0 radius-8 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 3px solid #f59e0b !important;">
                                <div class="card-body p-12">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="bi bi-info-circle text-warning-600" style="font-size: 16px;"></i>
                                        <p class="text-secondary-light mb-0" style="font-size: 12px;">Status</p>
                                    </div>
                                    <div id="view-metric-status">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="mb-24">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-box-seam text-white"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Product Details</h6>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="p-16 radius-8" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Product Name</label>
                                    <p class="text-dark fw-bold mb-0" style="font-size: 16px;" id="view-product-name">-</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-16 radius-8" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">SKU</label>
                                    <p class="text-dark mb-0" style="font-size: 14px;" id="view-product-sku">-</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-16 radius-8" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Category</label>
                                    <p class="text-dark mb-0" id="view-product-category">-</p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-16 radius-8" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Type</label>
                                    <p class="text-dark text-capitalize mb-0" id="view-product-type">-</p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="p-16 radius-8" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                                    <p class="text-dark mb-0" id="view-product-description" style="white-space: pre-wrap; line-height: 1.6;">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Breakdown Section -->
                    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-currency-dollar text-white"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Pricing Breakdown</h6>
                        </div>
                        
                        <div class="p-20 radius-8" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border: 1px solid #fecaca;">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <span class="text-secondary-light" style="font-size: 14px;">Cost Price</span>
                                        <span class="text-dark fw-semibold" id="view-product-cost">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                        <span class="text-secondary-light" style="font-size: 14px;">Tax Amount</span>
                                        <span class="text-dark fw-semibold" id="view-product-tax">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center py-2">
                                        <span class="text-secondary-light fw-bold" style="font-size: 14px;">Total Cost</span>
                                        <span class="text-dark fw-bold" style="font-size: 16px;" id="view-product-total-cost">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between align-items-center py-2">
                                        <span class="text-success-600 fw-bold" style="font-size: 14px;">Selling Price</span>
                                        <span class="text-success-600 fw-bold" style="font-size: 16px;" id="view-product-price">-</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2 p-12 radius-8 text-center" style="background-color: #ec3737;">
                                        <span class="text-white" style="font-size: 13px;">Estimated Profit per Unit: </span>
                                        <span class="text-white fw-bold" style="font-size: 16px;" id="view-product-profit">-</span>
                                        <span class="text-white mx-2">|</span>
                                        <span class="text-white" style="font-size: 13px;">Margin: </span>
                                        <span class="text-white fw-bold" style="font-size: 16px;" id="view-product-margin">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stock Management Section -->
                    <div class="pt-24" style="border-top: 1px solid #e5e7eb;">
                        <div class="d-flex align-items-center gap-2 mb-16">
                            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                                <i class="bi bi-boxes text-white"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Stock Management</h6>
                        </div>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-16 radius-8 text-center" style="background-color: #f0f9ff; border: 1px solid #bfdbfe;">
                                    <i class="bi bi-boxes text-primary-600 mb-2" style="font-size: 24px;"></i>
                                    <p class="text-secondary-light mb-1" style="font-size: 13px;">Current Stock</p>
                                    <p class="text-primary-600 fw-bold mb-0" style="font-size: 18px;" id="view-product-stock">-</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-16 radius-8 text-center" style="background-color: #fef3c7; border: 1px solid #fde68a;">
                                    <i class="bi bi-exclamation-triangle text-warning-600 mb-2" style="font-size: 24px;"></i>
                                    <p class="text-secondary-light mb-1" style="font-size: 13px;">Min. Stock Alert</p>
                                    <p class="text-warning-600 fw-bold mb-0" style="font-size: 18px;" id="view-product-min-stock">-</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="p-16 radius-8 text-center" style="background-color: #f3f4f6; border: 1px solid #d1d5db;">
                                    <i class="bi bi-rulers text-secondary-light mb-2" style="font-size: 24px;"></i>
                                    <p class="text-secondary-light mb-1" style="font-size: 13px;">Unit</p>
                                    <p class="text-dark fw-bold mb-0" style="font-size: 16px;" id="view-product-unit">-</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top py-16 px-24 bg-white">
                    <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i>
                            Close
                        </button>
                        <a href="#" id="view-product-edit-link" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <i class="bi bi-pencil-square"></i>
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Product Modal -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="createProductModalLabel" style="font-size: 18px !important;">
                        Add New Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="createProductModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" id="editProductModalLabel" style="font-size: 18px !important;">
                        Edit Product
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editProductModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load create product form via AJAX when modal is shown
        $(document).ready(function() {
            // View Product Modal Handler
            $(document).on('click', '.view-product-btn', function(e) {
                e.preventDefault();
                
                var $btn = $(this);
                var productId = $btn.data('product-id');
                var productName = $btn.data('product-name');
                var productSku = $btn.data('product-sku');
                var productCategory = $btn.data('product-category');
                var productType = $btn.data('product-type');
                var productDescription = $btn.data('product-description');
                var productPrice = $btn.data('product-price');
                var productCost = $btn.data('product-cost');
                var productTax = $btn.data('product-tax');
                var productTotalCost = $btn.data('product-total-cost');
                var productMargin = $btn.data('product-margin');
                var productStock = $btn.data('product-stock');
                var productUnit = $btn.data('product-unit');
                var productMinStock = $btn.data('product-min-stock');
                var productStatus = $btn.data('product-status');
                
                var currency = "{{ auth()->user()->business->currency }}";
                
                // Parse numeric values for calculations
                var priceNum = parseFloat(productPrice.replace(/,/g, ''));
                var costNum = parseFloat(productCost.replace(/,/g, ''));
                var taxNum = parseFloat(productTax.replace(/,/g, ''));
                var totalCostNum = parseFloat(productTotalCost.replace(/,/g, ''));
                var profit = priceNum - totalCostNum;
                
                // Populate modal header
                $("#view_product_subtitle").text(productName + " - " + productSku);
                
                // Populate key metrics cards at the top
                $("#view-metric-price").text(currency + " " + productPrice);
                $("#view-metric-margin").text(productMargin + "%");
                $("#view-metric-stock").text(productStock + " " + productUnit);
                
                // Status badge for metrics
                var statusBadgeHtml = '';
                if (productStatus === 'Active') {
                    statusBadgeHtml = '<span class="badge bg-success-100 text-success-600 px-12 py-4" style="font-size: 11px;">Active</span>';
                } else {
                    statusBadgeHtml = '<span class="badge bg-danger-100 text-danger-600 px-12 py-4" style="font-size: 11px;">Inactive</span>';
                }
                $("#view-metric-status").html(statusBadgeHtml);
                
                // Populate product details
                $("#view-product-name").text(productName);
                $("#view-product-sku").text(productSku);
                $("#view-product-category").text(productCategory);
                $("#view-product-type").text(productType);
                $("#view-product-description").text(productDescription);
                
                // Populate pricing breakdown
                $("#view-product-cost").text(currency + " " + productCost);
                $("#view-product-tax").text(currency + " " + productTax);
                $("#view-product-total-cost").text(currency + " " + productTotalCost);
                $("#view-product-price").text(currency + " " + productPrice);
                $("#view-product-profit").text(currency + " " + profit.toFixed(2));
                $("#view-product-margin").text(productMargin + "%");
                
                // Populate stock management
                $("#view-product-stock").text(productStock + " " + productUnit);
                $("#view-product-min-stock").text(productMinStock + " " + productUnit);
                $("#view-product-unit").text(productUnit);
                
                // Set edit link
                $("#view-product-edit-link").attr("href", "/products/" + productId + "/edit");
                
                // Show modal
                $("#viewProductModal").modal("show");
            });
            
            $('#createProductModal').on('show.bs.modal', function() {
                // Reset wizard initialization flag
                window.productWizardInit = false;
                
                $('#createProductModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                
                $.ajax({
                    url: '{{ route("products.create.form") }}',
                    method: 'GET',
                    success: function(response) {
                        $('#createProductModalBody').html(response);
                    },
                    error: function() {
                        $('#createProductModalBody').html('<div class="alert alert-danger">Failed to load form. Please try again.</div>');
                    }
                });
            });

            // Handle form submission via AJAX
            $(document).on('submit', '#createProductForm', function(e) {
                e.preventDefault();
                
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
                
                $.ajax({
                    url: '{{ route("products.store") }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#createProductModal').modal('hide');
                        location.reload(); // Reload page to show new product
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);
                        
                        console.error('Error response:', xhr);
                        
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0">';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            
                            // Insert errors at the top of modal body
                            $('#createProductModalBody').prepend(errorHtml);
                            
                            // Auto dismiss after 5 seconds
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 5000);
                        } else {
                            // Display more detailed error if available
                            let errorMessage = 'An error occurred. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    errorMessage = response.message || errorMessage;
                                } catch (e) {
                                    // Keep default message if parsing fails
                                }
                            }
                            
                            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show">' + 
                                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                '<strong>Error!</strong> ' + errorMessage +
                                '</div>';
                            
                            // Insert error at the top of modal body
                            $('#createProductModalBody').prepend(errorHtml);
                            
                            // Auto dismiss after 8 seconds
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 8000);
                        }
                    }
                });
            });

            // Edit Product Modal Handler
            $(document).on('click', '.edit-product-btn', function(e) {
                e.preventDefault();
                
                const productId = $(this).data('product-id');
                
                // Reset wizard initialization flag
                window.editProductWizardInit = false;
                
                // Show modal and load form
                $('#editProductModal').modal('show');
                $('#editProductModalBody').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
                
                $.ajax({
                    url: '/products/' + productId + '/edit-form',
                    method: 'GET',
                    success: function(response) {
                        $('#editProductModalBody').html(response);
                    },
                    error: function() {
                        $('#editProductModalBody').html('<div class="alert alert-danger">Failed to load product data. Please try again.</div>');
                    }
                });
            });

            // Handle edit form submission via AJAX
            $(document).on('submit', '#editProductForm', function(e) {
                e.preventDefault();
                
                const submitBtn = $(this).find('button[type="submit"]');
                const originalText = submitBtn.html();
                const formAction = $(this).attr('action');
                
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating...');
                
                $.ajax({
                    url: formAction,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#editProductModal').modal('hide');
                        location.reload(); // Reload page to show updated product
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html(originalText);
                        
                        console.error('Error response:', xhr);
                        
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show"><ul class="mb-0">';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            
                            // Insert errors at the top of modal body
                            $('#editProductModalBody').prepend(errorHtml);
                            
                            // Auto dismiss after 5 seconds
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 5000);
                        } else {
                            // Display more detailed error if available
                            let errorMessage = 'An error occurred. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.responseText) {
                                try {
                                    const response = JSON.parse(xhr.responseText);
                                    errorMessage = response.message || errorMessage;
                                } catch (e) {
                                    // Keep default message if parsing fails
                                }
                            }
                            
                            let errorHtml = '<div class="alert alert-danger alert-dismissible fade show">' + 
                                            '<i class="bi bi-exclamation-circle-fill me-2"></i>' + 
                                            errorMessage + 
                                            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' + 
                                            '</div>';
                            
                            $('#editProductModalBody').prepend(errorHtml);
                            
                            // Auto dismiss after 8 seconds
                            setTimeout(function() {
                                $('.alert').fadeOut();
                            }, 8000);
                        }
                    }
                });
            });
        });
    </script>

</x-layout.master>

