<x-layout.master>

    @push('styles')
    <!-- Sales Module CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/modules/sales.css') }}">
    <style>
        /* Custom Select Dropdown */
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
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filters Section -->
        <form method="GET" action="{{ route('sales.index') }}" id="salesFilterForm" class="mb-24 pb-24" style="border-bottom: 2px solid #e5e7eb;">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Date Range Filter -->
                <x-filters.date-range 
                    form-id="salesFilterForm"
                    :date-from="$dateFrom"
                    :date-to="$dateTo"
                    :auto-submit="false"
                />

                <!-- Sales Channel Filter -->
                <select name="sales_channel_id" class="form-select-custom">
                    <option value="all">All Channels</option>
                    @foreach($salesChannels as $channel)
                    <option value="{{ $channel->id }}" {{ request('sales_channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                    @endforeach
                </select>

                <!-- Payment Status Filter -->
                <select name="payment_status" class="form-select-custom">
                    <option value="all">All Statuses</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="partial" {{ request('payment_status') === 'partial' ? 'selected' : '' }}>Partial</option>
                </select>

                <!-- Apply Filter Button -->
                <button type="submit" class="btn text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #ec3737; height: 42px; padding: 0 24px; border-radius: 8px; font-size: 16px; font-weight: 600; transition: all 0.2s ease; white-space: nowrap; flex-shrink: 0;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    Apply Filter
                </button>
            </div>
        </form>

        <!-- Summary Metrics -->
        @include('sales.partials.summary-cards')

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
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
                <a href="{{ route('sales.pos') }}" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-plus-circle"></i>
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
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <a href="{{ route('sales.edit', $sale->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this sale? Stock will be restored.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-5">
                                    <i class="bi bi-inbox text-secondary-light mb-3" style="font-size: 48px;"></i>
                                    <p class="text-secondary-light mb-0">No sales recorded yet</p>
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary-600 mt-3">
                                        <i class="bi bi-plus-circle"></i>
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
    @include('sales.partials.view-modal')

    @push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
                                <i class="bi bi-trash-fill"></i>
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
    @endpush

    <!-- Record Sale Modal -->
    @include('sales.partials.create-modal')

    <x-script/>

</x-layout.master>

