<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Customer Details</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('customers.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Customers
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Details</li>
            </ul>
        </div>

        <!-- Customer Info Card -->
        <div class="card mb-24">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Customer Information</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-success-600 radius-8 px-20 py-11">
                        <iconify-icon icon="lucide:edit" class="icon text-xl me-1"></iconify-icon>
                        Edit
                    </a>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger-600 radius-8 px-20 py-11 delete-btn">
                            <iconify-icon icon="fluent:delete-24-regular" class="icon text-xl me-1"></iconify-icon>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="row gy-4">
                    <!-- Customer Name -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:account" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Customer Name</span>
                            </div>
                            <h6 class="mb-0">{{ $customer->name }}</h6>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:check-circle" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Status</span>
                            </div>
                            @if($customer->is_active)
                                <span class="badge bg-success-100 text-success-600 px-16 py-6 text-md">Active</span>
                            @else
                                <span class="badge bg-danger-100 text-danger-600 px-16 py-6 text-md">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:email" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Email</span>
                            </div>
                            <h6 class="mb-0">{{ $customer->email ?? 'Not Provided' }}</h6>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:phone" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Phone</span>
                            </div>
                            <h6 class="mb-0">{{ $customer->phone ?? 'Not Provided' }}</h6>
                        </div>
                    </div>

                    <!-- Company -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:office-building" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Company</span>
                            </div>
                            <h6 class="mb-0">{{ $customer->company ?? 'Not Provided' }}</h6>
                        </div>
                    </div>

                    <!-- Total Sales -->
                    <div class="col-md-6">
                        <div class="p-16 border radius-8 h-100 bg-success-50">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:cash-multiple" class="text-success-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Total Sales</span>
                            </div>
                            <h5 class="mb-0 text-success-600">{{ auth()->user()->business->currency }} {{ number_format($customer->sales->sum('total'), 2) }}</h5>
                        </div>
                    </div>

                    <!-- Address -->
                    @if($customer->address)
                    <div class="col-12">
                        <div class="p-16 border radius-8">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <iconify-icon icon="mdi:map-marker" class="text-primary-600 text-xl"></iconify-icon>
                                <span class="text-sm text-secondary-light">Address</span>
                            </div>
                            <p class="mb-0">{{ $customer->address }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Metadata -->
                    <div class="col-12">
                        <div class="p-16 border radius-8 bg-neutral-50">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <iconify-icon icon="mdi:clock-outline" class="text-secondary-light"></iconify-icon>
                                        <span class="text-sm text-secondary-light">Created: {{ $customer->created_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <iconify-icon icon="mdi:clock-check-outline" class="text-secondary-light"></iconify-icon>
                                        <span class="text-sm text-secondary-light">Updated: {{ $customer->updated_at->format('M d, Y h:i A') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales History -->
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Sales History</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="sales-table">
                        <thead>
                            <tr>
                                <th scope="col">Invoice #</th>
                                <th scope="col">Date</th>
                                <th scope="col">Channel</th>
                                <th scope="col" class="text-end">Subtotal</th>
                                <th scope="col" class="text-end">Tax</th>
                                <th scope="col" class="text-end">Total</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->sales->sortByDesc('date') as $sale)
                            <tr>
                                <td>
                                    <span class="text-sm fw-semibold">{{ $sale->invoice_number }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $sale->date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $sale->salesChannel->name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ number_format($sale->subtotal, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm">{{ number_format($sale->tax, 2) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold">{{ number_format($sale->total, 2) }}</span>
                                </td>
                                <td>
                                    @if($sale->payment_status === 'paid')
                                        <span class="badge bg-success-100 text-success-600 px-16 py-6">Paid</span>
                                    @elseif($sale->payment_status === 'partial')
                                        <span class="badge bg-warning-100 text-warning-600 px-16 py-6">Partial</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-16 py-6">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="view-sale-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" data-sale-id="{{ $sale->id }}">
                                        <iconify-icon icon="solar:eye-linear" class="icon text-lg"></iconify-icon>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-32">
                                    <iconify-icon icon="mdi:receipt-text-remove" class="text-xxl text-secondary-light mb-8" style="font-size: 48px;"></iconify-icon>
                                    <p class="text-secondary-light mb-0">No sales found for this customer</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-24">
            <a href="{{ route('customers.index') }}" class="btn btn-secondary-600 radius-8 px-20 py-11">
                <iconify-icon icon="mdi:arrow-left" class="icon text-xl me-1"></iconify-icon>
                Back to List
            </a>
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
                            <span class="fw-semibold" id="modalSubtotal">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8" id="modalDiscountRow" style="display: none;">
                            <span class="text-secondary-light">Item Discounts:</span>
                            <span class="fw-semibold" style="color: #ec3737;" id="modalDiscount">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8">
                            <span class="text-secondary-light">Tax:</span>
                            <span class="fw-semibold" id="modalTax">-</span>
                        </div>
                        <hr class="my-12" style="border-color: #ec3737; opacity: 0.3;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size: 18px;">Grand Total:</span>
                            <span class="fw-bold" style="font-size: 28px; color: #ec3737; letter-spacing: -0.5px;" id="modalTotal">-</span>
                        </div>
                    </div>

                    <div id="modalNotes" class="mt-16" style="display: none;">
                        <p class="text-secondary-light mb-4" style="font-size: 12px;">Notes:</p>
                        <p class="mb-0" id="modalNotesText"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            if ($.fn.DataTable.isDataTable("#sales-table")) {
                $("#sales-table").DataTable().destroy();
            }

            $("#sales-table").DataTable({
                "paging": true,
                "searching": false,
                "ordering": true,
                "info": false,
                "responsive": true,
                "autoWidth": false,
                "order": [[1, "desc"]],
                "pagingType": "simple",
                "pageLength": 10
            });

            // Delete confirmation
            $(".delete-btn").on("click", function(e) {
                e.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // View Sale button click handler
            $(document).on("click", ".view-sale-btn", function() {
                var saleId = $(this).data("sale-id");
                viewSale(saleId);
            });
        });

        // View Sale in Modal
        function viewSale(saleId) {
            // Show loading state
            $("#viewSaleModal").modal("show");
            
            // Fetch sale data
            $.ajax({
                url: "/sales/" + saleId,
                method: "GET",
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(response) {
                    var sale = response.sale;
                    var currency = "{{ auth()->user()->business->currency }}";
                    
                    // Populate modal fields
                    $("#modalInvoiceNumber").text(sale.invoice_number || "N/A");
                    
                    var saleDate = new Date(sale.date);
                    var formattedDate = saleDate.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
                    $("#modalSaleDate").text(formattedDate);
                    
                    var customerName = sale.customer ? sale.customer.name : "Walk-in Customer";
                    $("#modalCustomer").text(customerName);
                    
                    var channelName = sale.sales_channel ? sale.sales_channel.name : "N/A";
                    $("#modalChannel").text(channelName);
                    
                    var paymentMethod = sale.payment_method || "-";
                    if (paymentMethod !== "-") {
                        paymentMethod = paymentMethod.replace(/_/g, " ");
                        paymentMethod = paymentMethod.charAt(0).toUpperCase() + paymentMethod.slice(1);
                    }
                    $("#modalPaymentMethod").text(paymentMethod);
                    
                    // Payment status with badge
                    var statusBadge = "";
                    if (sale.payment_status === "paid") {
                        statusBadge = '<span class="badge bg-success-100 text-success-600 px-12 py-6">Paid</span>';
                    } else if (sale.payment_status === "partial") {
                        statusBadge = '<span class="badge bg-warning-100 text-warning-600 px-12 py-6">Partial</span>';
                    } else {
                        statusBadge = '<span class="badge bg-danger-100 text-danger-600 px-12 py-6">Pending</span>';
                    }
                    $("#modalPaymentStatus").html(statusBadge);
                    
                    // Total items
                    var totalItems = 0;
                    sale.sale_items.forEach(function(item) {
                        totalItems += parseInt(item.quantity);
                    });
                    $("#modalTotalItems").text(totalItems);
                    
                    // Populate items table and calculate total item discounts
                    var itemsHtml = "";
                    var totalItemDiscounts = 0;
                    
                    sale.sale_items.forEach(function(item) {
                        // Check for item-level discount
                        var discountInfo = "";
                        if (item.discount_amount && parseFloat(item.discount_amount) > 0) {
                            totalItemDiscounts += parseFloat(item.discount_amount);
                            var discountType = item.discount_type === "percent" ? item.discount_value + "%" : "Fixed";
                            var discountAmt = parseFloat(item.discount_amount || 0).toFixed(2);
                            discountInfo = '<br><small class="text-danger-600">-' + currency + ' ' + discountAmt + ' (' + discountType + ')</small>';
                        }
                        
                        var productName = item.product ? item.product.name : "Unknown Product";
                        var productSku = item.product && item.product.sku ? item.product.sku : "N/A";
                        var unitPrice = parseFloat(item.unit_price || 0).toFixed(2);
                        var taxAmount = parseFloat(item.tax_amount || 0).toFixed(2);
                        var itemTotal = parseFloat(item.total || 0).toFixed(2);
                        
                        itemsHtml += '<tr>' +
                            '<td style="font-size: 13px;">' +
                                '<span class="fw-semibold d-block">' + productName + '</span>' +
                                '<small class="text-secondary-light">SKU: ' + productSku + '</small>' +
                                discountInfo +
                            '</td>' +
                            '<td style="font-size: 13px;" class="text-center">' + item.quantity + '</td>' +
                            '<td style="font-size: 13px;" class="text-end">' + currency + ' ' + unitPrice + '</td>' +
                            '<td style="font-size: 13px;" class="text-end">' + currency + ' ' + taxAmount + '</td>' +
                            '<td style="font-size: 13px;" class="text-end">' + currency + ' ' + itemTotal + '</td>' +
                        '</tr>';
                    });
                    $("#modalSaleItems").html(itemsHtml);
                    
                    // Populate summary
                    var subtotal = parseFloat(sale.subtotal || 0).toFixed(2);
                    var tax = parseFloat(sale.tax || 0).toFixed(2);
                    var total = parseFloat(sale.total || 0).toFixed(2);
                    
                    $("#modalSubtotal").text(currency + " " + subtotal);
                    $("#modalTax").text(currency + " " + tax);
                    $("#modalTotal").text(currency + " " + total);
                    
                    // Show/hide item discounts
                    if (totalItemDiscounts > 0) {
                        $("#modalDiscountRow").show();
                        $("#modalDiscount").text("-" + currency + " " + totalItemDiscounts.toFixed(2));
                    } else if (sale.discount && parseFloat(sale.discount) > 0) {
                        $("#modalDiscountRow").show();
                        var discount = parseFloat(sale.discount).toFixed(2);
                        $("#modalDiscount").text("-" + currency + " " + discount);
                    } else {
                        $("#modalDiscountRow").hide();
                    }
                    
                    // Show/hide notes
                    if (sale.notes) {
                        $("#modalNotes").show();
                        $("#modalNotesText").text(sale.notes);
                    } else {
                        $("#modalNotes").hide();
                    }
                },
                error: function(xhr) {
                    alert("Error loading sale details");
                    $("#viewSaleModal").modal("hide");
                }
            });
        }
    </script>
    @endpush

</x-layout.master>

