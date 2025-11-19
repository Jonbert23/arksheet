<x-layout.master>

    <div class="dashboard-main-body">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <style>
        .pos-container {
            min-height: calc(100vh - 180px);
        }
        .products-panel {
            max-height: calc(100vh - 220px);
            overflow-y: auto;
            padding-right: 8px;
        }
        .cart-panel {
            position: sticky;
            top: 100px;
            min-height: calc(100vh - 120px);
            max-height: calc(100vh - 120px);
            display: flex;
            flex-direction: column;
            border-left: 2px solid #f0f0f0;
            padding-left: 24px;
        }
        .cart-items-container {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 16px;
            min-height: 200px;
        }
        .order-summary-wrapper {
            margin-top: auto;
        }
        .product-card {
            cursor: pointer;
            transition: all 0.2s;
            border: 2px solid #e5e7eb;
        }
        .product-card:hover {
            border-color: #ec3737;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(236, 55, 55, 0.15);
        }
        .product-card.out-of-stock {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .product-card.out-of-stock:hover {
            border-color: #e5e7eb;
            transform: none;
            box-shadow: none;
        }
        .cart-item {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
        }
        .quantity-controls button {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
        }
        .order-summary-box {
            background: linear-gradient(135deg, #ec3737 0%, #c91c1c 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
        }
        .btn-clear-cart {
            background: rgba(255, 255, 255, 0.15) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }
        .btn-clear-cart:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.5) !important;
            transform: translateY(-1px);
        }
        .btn-proceed-sale {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%) !important;
            color: white !important;
            border: none !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4) !important;
            transition: all 0.3s ease !important;
        }
        .btn-proceed-sale:hover:not(:disabled) {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(251, 191, 36, 0.5) !important;
        }
        #discountInput:focus {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: rgba(255, 255, 255, 0.6) !important;
            outline: none;
        }
        #discountInput::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-proceed-sale:disabled {
            background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%) !important;
            color: rgba(255, 255, 255, 0.6) !important;
            box-shadow: none !important;
            cursor: not-allowed;
            opacity: 0.6;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .search-box {
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            padding-bottom: 16px;
        }
    </style>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Record New Sale</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <i class="bi bi-house" class="icon text-lg"></i>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('sales.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Sales
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">POS</li>
        </ul>
    </div>

    <div class="row pos-container">
        <!-- Left Panel - Products -->
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="products-panel">
                        <!-- Search Box -->
                        <div class="search-box">
                            <div class="input-group">
                                <span class="input-group-text bg-neutral-50">
                                    <i class="bi bi-circle-fill"></i>
                                </span>
                                <input type="text" id="productSearch" class="form-control" placeholder="Search products by name, SKU, or category..." style="height: 44px;">
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="row g-3" id="productsGrid">
                            @forelse($products as $product)
                            <div class="col-md-6 col-xl-4 product-item" 
                                 data-name="{{ strtolower($product->name) }}"
                                 data-sku="{{ strtolower($product->sku ?? '') }}"
                                 data-category="{{ strtolower($product->category ?? '') }}">
                                <div class="product-card p-12 radius-8 {{ $product->stock_quantity <= 0 ? 'out-of-stock' : '' }}"
                                     data-product-id="{{ $product->id }}"
                                     data-product-name="{{ $product->name }}"
                                     data-product-price="{{ $product->price }}"
                                     data-product-cost="{{ $product->cost }}"
                                     data-product-tax="{{ $product->tax_amount ?? 0 }}"
                                     data-product-stock="{{ $product->stock_quantity }}"
                                     data-product-sku="{{ $product->sku ?? 'N/A' }}"
                                     onclick="addToCart({{ $product->id }})">
                                    
                                    <div class="d-flex align-items-start justify-content-between mb-8">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold mb-4" style="font-size: 18px !important;">{{ $product->name }}</h6>
                                            <p class="text-secondary-light mb-0" style="font-size: 11px;">SKU: {{ $product->sku ?? 'N/A' }}</p>
                                        </div>
                                        @if($product->stock_quantity <= 0)
                                        <span class="badge bg-danger-100 text-danger-600 px-8 py-4 radius-4" style="font-size: 10px;">Out of Stock</span>
                                        @else
                                        <span class="badge bg-success-100 text-success-600 px-8 py-4 radius-4" style="font-size: 10px;">In Stock</span>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-end">
                                        <div>
                                            <p class="text-primary-600 fw-bold mb-0" style="font-size: 16px;">{{ auth()->user()->business->currency }} {{ number_format($product->price, 2) }}</p>
                                            <p class="text-secondary-light mb-0" style="font-size: 10px;">Stock: {{ $product->stock_quantity }}</p>
                                        </div>
                                        @if($product->stock_quantity > 0)
                                        <button type="button" class="btn btn-sm btn-primary-600 px-8 py-4" onclick="event.stopPropagation(); addToCart({{ $product->id }})">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="text-center py-48">
                                    <i class="bi bi-circle-fill"></i>
                                    <p class="text-secondary-light fw-semibold mb-8">No Products Available</p>
                                    <p class="text-secondary-light text-sm mb-16">Please add products to your inventory first</p>
                                    <a href="{{ route('products.create') }}" class="btn btn-primary-600 px-20 py-11 radius-8">
                                        <i class="bi bi-circle-fill"></i>
                                        Add Product
                                    </a>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel - Cart & Summary -->
        <div class="col-lg-4">
            <div class="cart-panel">
                <div class="mb-16">
                    <h6 class="fw-bold mb-0" style="font-size: 18px !important;">Current Sale</h6>
                    <p class="text-secondary-light mb-0" style="font-size: 13px;">Add products to create a sale</p>
                </div>

                <!-- Cart Items -->
                <div class="cart-items-container" id="cartItemsContainer">
                    <!-- Empty State -->
                    <div id="cartEmptyState" class="text-center py-48">
                        <p class="text-secondary-light fw-semibold mb-8">Cart is Empty</p>
                        <p class="text-secondary-light text-sm mb-0">Select products from the left to start a sale</p>
                    </div>

                    <!-- Cart Items will be added here -->
                    <div id="cartItems" style="display: none;"></div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary-wrapper">
                    <div class="order-summary-box">
                        <div class="summary-row mb-12">
                            <span style="font-size: 15px; font-weight: 500;">Subtotal:</span>
                            <span class="fw-bold" style="font-size: 16px;" id="summarySubtotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="summary-row mb-12" id="summaryItemDiscountRow" style="display: none;">
                            <span style="font-size: 15px; font-weight: 500;">Item Discounts:</span>
                            <span class="fw-bold text-warning" style="font-size: 16px;" id="summaryItemDiscount">-{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="summary-row mb-16">
                            <span style="font-size: 15px; font-weight: 500;">Tax:</span>
                            <span class="fw-bold" style="font-size: 16px;" id="summaryTax">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <hr style="border-color: rgba(255,255,255,0.25); margin: 16px 0; border-width: 1.5px;">
                        <div class="summary-row mb-0">
                            <span class="fw-bold" style="font-size: 18px;">Total:</span>
                            <span class="fw-bold" style="font-size: 32px; letter-spacing: -0.5px;" id="summaryTotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        
                        <div class="d-flex gap-3 mt-20">
                            <button type="button" class="btn btn-clear-cart px-20 py-12 radius-8 d-flex align-items-center justify-content-center gap-2" onclick="clearCart()" style="min-width: 100px;">
                                <i class="bi bi-circle-fill"></i>
                                <span>Clear</span>
                            </button>
                            <button type="button" class="btn btn-proceed-sale flex-grow-1 px-20 py-12 radius-8 d-flex align-items-center justify-content-center gap-2" id="proceedToSaleBtn" onclick="openSaleInfoModal()" disabled style="min-width: 150px;">
                                <span style="font-size: 15px;">Proceed</span>
                                <i class="bi bi-circle-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sale Information Modal -->
    <div class="modal fade" id="saleInfoModal" tabindex="-1" aria-labelledby="saleInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="saleInfoModalLabel">Sale Information</h5>
                        <p class="text-secondary-light mb-0" style="font-size: 13px;">Enter sale details</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form id="saleInfoForm">
                        <div class="row g-3">
                            <!-- Date -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Sale Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" id="saleDate" class="form-control" style="height: 44px;" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <!-- Customer -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Customer
                                </label>
                                <select id="customerId" class="form-select" style="height: 44px;">
                                    <option value="">Walk-in Customer</option>
                                    @foreach($customers ?? [] as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sales Channel -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Sales Channel <span class="text-danger">*</span>
                                </label>
                                <select id="salesChannelId" class="form-select" style="height: 44px;" required>
                                    <option value="">Select Channel</option>
                                    @foreach($salesChannels ?? [] as $channel)
                                        <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Payment Method <span class="text-danger">*</span>
                                </label>
                                <select id="paymentMethod" class="form-select" style="height: 44px;" required>
                                    <option value="">Select Method</option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="gcash">GCash</option>
                                    <option value="paymaya">PayMaya</option>
                                </select>
                            </div>

                            <!-- Payment Status -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Payment Status <span class="text-danger">*</span>
                                </label>
                                <select id="paymentStatus" class="form-select" style="height: 44px;" required>
                                    <option value="paid">Paid</option>
                                    <option value="pending">Pending</option>
                                    <option value="partial">Partial</option>
                                </select>
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                    Notes
                                </label>
                                <textarea id="saleNotes" rows="3" class="form-control" style="resize: vertical;" placeholder="Additional information..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top py-16 px-24 bg-white">
                    <button type="button" class="btn text-secondary-light border border-neutral-200 hover-bg-neutral-100 radius-8 px-20 py-11" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-primary-600 radius-8 px-20 py-11" onclick="proceedToConfirmation()">
                        Continue to Review
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="confirmationModalLabel">
                           
                            Confirm Sale
                        </h5>
                        <p class="text-secondary-light mb-0" style="font-size: 13px;">Review sale details before completing</p>
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
                                    <p class="fw-semibold mb-0" id="confirmDate">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Customer</p>
                                    <p class="fw-semibold mb-0" id="confirmCustomer">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Sales Channel</p>
                                    <p class="fw-semibold mb-0" id="confirmChannel">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Method</p>
                                    <p class="fw-semibold mb-0" id="confirmPaymentMethod">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Status</p>
                                    <p class="fw-semibold mb-0" id="confirmPaymentStatus">-</p>
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
                                <tbody id="confirmItems">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="p-20 radius-8" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border: 2px solid #ec3737;">
                        <div class="d-flex justify-content-between mb-8">
                            <span class="text-secondary-light">Subtotal:</span>
                            <span class="fw-semibold" id="confirmSubtotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8" id="confirmItemDiscountRow" style="display: none;">
                            <span class="text-secondary-light">Item Discounts:</span>
                            <span class="fw-semibold" style="color: #ec3737;" id="confirmItemDiscount">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-8">
                            <span class="text-secondary-light">Tax:</span>
                            <span class="fw-semibold" id="confirmTax">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                        <hr class="my-12" style="border-color: #ec3737; opacity: 0.3;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="font-size: 18px;">Grand Total:</span>
                            <span class="fw-bold" style="font-size: 28px; color: #ec3737; letter-spacing: -0.5px;" id="confirmTotal">{{ auth()->user()->business->currency }} 0.00</span>
                        </div>
                    </div>

                    <div id="confirmNotes" class="mt-16" style="display: none;">
                        <p class="text-secondary-light mb-4" style="font-size: 12px;">Notes:</p>
                        <p class="mb-0" id="confirmNotesText"></p>
                    </div>
                </div>
                <div class="modal-footer border-top py-20 px-24 bg-white d-flex gap-3">
                    <button type="button" class="btn flex-grow-1 d-flex align-items-center justify-content-center gap-2 radius-8 py-12" 
                            style="background: #f8f9fa; color: #495057; border: 1px solid #dee2e6; font-weight: 600; transition: all 0.3s ease;"
                            onmouseover="this.style.background='#e9ecef'; this.style.borderColor='#adb5bd';"
                            onmouseout="this.style.background='#f8f9fa'; this.style.borderColor='#dee2e6';"
                            onclick="backToSaleInfo()">
                        <i class="bi bi-circle-fill"></i>
                        <span>Back</span>
                    </button>
                    <button type="button" class="btn flex-grow-1 d-flex align-items-center justify-content-center gap-2 radius-8 py-12" 
                            style="background: linear-gradient(135deg, #ec3737 0%, #c91c1c 100%); color: white; border: none; font-weight: 700; box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4); transition: all 0.3s ease;"
                            onmouseover="this.style.background='linear-gradient(135deg, #d12929 0%, #b01515 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(236, 55, 55, 0.5)';"
                            onmouseout="this.style.background='linear-gradient(135deg, #ec3737 0%, #c91c1c 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(236, 55, 55, 0.4)';"
                            onclick="completeSale()">
                        <i class="bi bi-circle-fill"></i>
                        <span>Complete Sale</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    </div> <!-- End dashboard-main-body -->

    <x-script/>

    <script>
        const currency = '{{ auth()->user()->business->currency }}';
        let cart = [];

        // Product Search (initialized in document.ready below)

        // Add to Cart
        function addToCart(productId) {
            const productCard = $(`.product-card[data-product-id="${productId}"]`);
            
            // Check if out of stock
            if (productCard.hasClass('out-of-stock')) {
                return;
            }

            const product = {
                id: productId,
                name: productCard.data('product-name'),
                price: parseFloat(productCard.data('product-price')),
                cost: parseFloat(productCard.data('product-cost')),
                tax: parseFloat(productCard.data('product-tax')),
                stock: parseInt(productCard.data('product-stock')),
                sku: productCard.data('product-sku')
            };

            // Check if already in cart
            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                if (existingItem.quantity < product.stock) {
                    existingItem.quantity++;
                } else {
                    alert('Cannot add more. Stock limit reached.');
                    return;
                }
            } else {
                cart.push({
                    ...product, 
                    quantity: 1,
                    discountType: 'percent',
                    discountValue: 0
                });
            }

            updateCart();
        }

        // Update Cart Display
        function updateCart() {
            const cartItemsDiv = $('#cartItems');
            const emptyState = $('#cartEmptyState');
            const proceedBtn = $('#proceedToSaleBtn');

            if (cart.length === 0) {
                emptyState.show();
                cartItemsDiv.hide();
                proceedBtn.prop('disabled', true);
                updateSummary();
                return;
            }

            emptyState.hide();
            cartItemsDiv.show();
            proceedBtn.prop('disabled', false);

            let html = '';
            cart.forEach(item => {
                const itemSubtotal = item.quantity * item.price;
                
                // Calculate discount
                let discountAmount = 0;
                if (item.discountValue > 0) {
                    if (item.discountType === 'percent') {
                        discountAmount = itemSubtotal * (item.discountValue / 100);
                    } else {
                        discountAmount = item.discountValue;
                    }
                }
                
                const itemSubtotalAfterDiscount = itemSubtotal - discountAmount;
                const itemTax = itemSubtotalAfterDiscount * (item.tax / 100);
                const itemTotal = itemSubtotalAfterDiscount + itemTax;

                html += `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-start mb-8">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-4" style="font-size: 18px !important;">${item.name}</h6>
                                <p class="text-secondary-light mb-0" style="font-size: 11px;">SKU: ${item.sku}</p>
                                <p class="text-primary-600 mb-0" style="font-size: 12px;">${currency} ${item.price.toFixed(2)} each</p>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger-600 p-0" style="width: 24px; height: 24px;" onclick="removeFromCart(${item.id})">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                        </div>
                        
                        <!-- Quantity and Price -->
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="quantity-controls d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-neutral-200" onclick="decreaseQuantity(${item.id})">
                                    <i class="bi bi-circle-fill"></i>
                                </button>
                                <input type="number" class="form-control text-center" style="width: 80px; height: 32px; color: #000; font-weight: 600;" value="${item.quantity}" min="1" max="${item.stock}" onchange="updateQuantity(${item.id}, this.value)">
                                <button type="button" class="btn btn-sm btn-primary-600" onclick="increaseQuantity(${item.id})" ${item.quantity >= item.stock ? 'disabled' : ''}>
                                    <i class="bi bi-circle-fill"></i>
                                </button>
                            </div>
                            <div class="text-end">
                                ${discountAmount > 0 ? `<p class="text-danger-600 mb-0" style="font-size: 11px; text-decoration: line-through;">${currency} ${(itemSubtotal + (itemSubtotal * (item.tax / 100))).toFixed(2)}</p>` : ''}
                                <p class="fw-bold mb-0" style="font-size: 14px;">${currency} ${itemTotal.toFixed(2)}</p>
                                <p class="text-secondary-light mb-0" style="font-size: 10px;">Tax: ${currency} ${itemTax.toFixed(2)}</p>
                            </div>
                        </div>
                        
                        <!-- Discount Toggle/Display -->
                        <div class="mt-8">
                            ${discountAmount > 0 ? `
                                <div class="d-flex align-items-center justify-content-between p-8 bg-danger-50 radius-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-circle-fill"></i>
                                        <span class="text-danger-600" style="font-size: 12px; font-weight: 600;">
                                            ${item.discountType === 'percent' ? item.discountValue + '% Off' : currency + ' ' + item.discountValue.toFixed(2) + ' Off'}
                                        </span>
                                        <span class="text-danger-600" style="font-size: 11px;">(-${currency} ${discountAmount.toFixed(2)})</span>
                                    </div>
                                    <button type="button" class="btn btn-sm p-0" style="width: 20px; height: 20px;" onclick="toggleItemDiscount(${item.id})">
                                        <i class="bi bi-circle-fill"></i>
                                    </button>
                                </div>
                                <div id="discount-form-${item.id}" class="discount-form mt-8" style="display: none;">
                                    <div class="d-flex gap-2 align-items-center">
                                        <select class="form-select form-select-sm" style="width: 100px; height: 38px; font-size: 13px; color: #000; font-weight: 600;" onchange="updateItemDiscountType(${item.id}, this.value)">
                                            <option value="percent" ${item.discountType === 'percent' ? 'selected' : ''}>% Percent</option>
                                            <option value="fixed" ${item.discountType === 'fixed' ? 'selected' : ''}>Fixed</option>
                                        </select>
                                        <input type="number" class="form-control form-control-sm text-center" 
                                               style="flex: 1; height: 38px; font-size: 13px; color: #000; font-weight: 600;" 
                                               value="${item.discountValue || 0}" 
                                               min="0" 
                                               step="0.01"
                                               onchange="updateItemDiscount(${item.id}, this.value)"
                                               placeholder="0.00">
                                        <button type="button" class="btn btn-sm btn-danger-600" style="height: 38px; padding: 0 12px;" onclick="removeItemDiscount(${item.id})">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            ` : `
                                <button type="button" class="btn btn-sm btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-1" style="height: 32px; font-size: 11px; padding: 4px 8px;" onclick="toggleItemDiscount(${item.id})">
                                    <i class="bi bi-circle-fill"></i>
                                    <span>Add Discount</span>
                                </button>
                                <div id="discount-form-${item.id}" class="discount-form mt-8" style="display: none;">
                                    <div class="d-flex gap-2 align-items-center">
                                        <select class="form-select form-select-sm" style="width: 100px; height: 38px; font-size: 13px; color: #000; font-weight: 600;" onchange="updateItemDiscountType(${item.id}, this.value)">
                                            <option value="percent" ${item.discountType === 'percent' ? 'selected' : ''}>% Percent</option>
                                            <option value="fixed" ${item.discountType === 'fixed' ? 'selected' : ''}>Fixed</option>
                                        </select>
                                        <input type="number" class="form-control form-control-sm text-center" 
                                               style="flex: 1; height: 38px; font-size: 13px; color: #000; font-weight: 600;" 
                                               value="${item.discountValue || 0}" 
                                               min="0" 
                                               step="0.01"
                                               onchange="updateItemDiscount(${item.id}, this.value)"
                                               placeholder="0.00">
                                        <button type="button" class="btn btn-sm btn-primary-600" style="height: 38px; padding: 0 16px;" onclick="applyItemDiscount(${item.id})">
                                            Apply
                                        </button>
                                    </div>
                                </div>
                            `}
                        </div>
                    </div>
                `;
            });

            cartItemsDiv.html(html);
            updateSummary();
        }

        function increaseQuantity(productId) {
            const item = cart.find(i => i.id === productId);
            if (item && item.quantity < item.stock) {
                item.quantity++;
                updateCart();
            }
        }

        function decreaseQuantity(productId) {
            const item = cart.find(i => i.id === productId);
            if (item && item.quantity > 1) {
                item.quantity--;
                updateCart();
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            updateCart();
        }

        function clearCart() {
            if (cart.length === 0) return;
            
            if (confirm('Are you sure you want to clear the cart?')) {
                cart = [];
                updateCart();
            }
        }

        function updateSummary() {
            let subtotal = 0;
            let totalTax = 0;
            let totalItemDiscounts = 0;

            cart.forEach(item => {
                const itemSubtotal = item.quantity * item.price;
                
                // Calculate item-level discount
                let itemDiscountAmount = 0;
                if (item.discountValue > 0) {
                    if (item.discountType === 'percent') {
                        itemDiscountAmount = itemSubtotal * (item.discountValue / 100);
                    } else {
                        itemDiscountAmount = item.discountValue;
                    }
                }
                
                const itemSubtotalAfterDiscount = itemSubtotal - itemDiscountAmount;
                const itemTax = itemSubtotalAfterDiscount * (item.tax / 100);
                
                subtotal += itemSubtotal;
                totalItemDiscounts += itemDiscountAmount;
                totalTax += itemTax;
            });

            const total = subtotal - totalItemDiscounts + totalTax;

            $('#summarySubtotal').text(`${currency} ${subtotal.toFixed(2)}`);
            
            // Show/hide and update item discounts row
            if (totalItemDiscounts > 0) {
                $('#summaryItemDiscountRow').show();
                $('#summaryItemDiscount').text(`-${currency} ${totalItemDiscounts.toFixed(2)}`);
            } else {
                $('#summaryItemDiscountRow').hide();
            }
            
            $('#summaryTax').text(`${currency} ${totalTax.toFixed(2)}`);
            $('#summaryTotal').text(`${currency} ${total.toFixed(2)}`);
        }

        function updateQuantity(productId, newQuantity) {
            const quantity = parseInt(newQuantity);
            const item = cart.find(i => i.id === productId);
            
            if (!item) return;
            
            if (quantity < 1) {
                alert('Quantity must be at least 1');
                updateCart();
                return;
            }
            
            if (quantity > item.stock) {
                alert(`Only ${item.stock} units available in stock`);
                updateCart();
                return;
            }
            
            item.quantity = quantity;
            updateCart();
        }

        function updateDiscount(value) {
            const discount = parseFloat(value) || 0;
            
            if (discount < 0) {
                $('#discountInput').val(0);
                updateSummary();
                return;
            }
            
            updateSummary();
        }

        function toggleItemDiscount(productId) {
            const form = document.getElementById(`discount-form-${productId}`);
            if (form) {
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
        }

        function applyItemDiscount(productId) {
            // Just close the form - discount is already applied via updateItemDiscount
            const form = document.getElementById(`discount-form-${productId}`);
            if (form) {
                form.style.display = 'none';
            }
            updateCart();
        }

        function removeItemDiscount(productId) {
            const item = cart.find(i => i.id === productId);
            if (!item) return;
            
            item.discountType = 'percent';
            item.discountValue = 0;
            updateCart();
        }

        function updateItemDiscountType(productId, type) {
            const item = cart.find(i => i.id === productId);
            if (!item) return;
            
            item.discountType = type;
            // Don't update cart immediately, wait for user to change value or click apply
        }

        function updateItemDiscount(productId, value) {
            const item = cart.find(i => i.id === productId);
            if (!item) return;
            
            const discountValue = parseFloat(value) || 0;
            
            if (discountValue < 0) {
                item.discountValue = 0;
                return;
            }
            
            // Validate percent discount
            if (item.discountType === 'percent' && discountValue > 100) {
                alert('Percentage discount cannot exceed 100%');
                item.discountValue = 100;
                updateCart();
                return;
            }
            
            // Validate fixed discount
            if (item.discountType === 'fixed') {
                const itemSubtotal = item.quantity * item.price;
                if (discountValue > itemSubtotal) {
                    alert('Fixed discount cannot exceed item subtotal');
                    item.discountValue = itemSubtotal;
                    updateCart();
                    return;
                }
            }
            
            item.discountValue = discountValue;
            updateCart();
        }

        // Open Sale Info Modal
        function openSaleInfoModal() {
            if (cart.length === 0) return;
            
            $('#saleInfoModal').modal('show');
        }

        // Proceed to Confirmation
        function proceedToConfirmation() {
            // Validate form
            const salesChannelId = $('#salesChannelId').val();
            const paymentMethod = $('#paymentMethod').val();
            const paymentStatus = $('#paymentStatus').val();

            if (!salesChannelId || !paymentMethod || !paymentStatus) {
                alert('Please fill in all required fields');
                return;
            }

            // Populate confirmation modal
            const saleDate = $('#saleDate').val();
            const customerId = $('#customerId').val();
            const customerText = customerId ? $('#customerId option:selected').text() : 'Walk-in Customer';
            const channelText = $('#salesChannelId option:selected').text();
            const paymentMethodText = $('#paymentMethod option:selected').text();
            const paymentStatusText = $('#paymentStatus option:selected').text();
            const notes = $('#saleNotes').val();

            $('#confirmDate').text(saleDate);
            $('#confirmCustomer').text(customerText);
            $('#confirmChannel').text(channelText);
            $('#confirmPaymentMethod').text(paymentMethodText);
            $('#confirmPaymentStatus').text(paymentStatusText);

            if (notes) {
                $('#confirmNotes').show();
                $('#confirmNotesText').text(notes);
            } else {
                $('#confirmNotes').hide();
            }

            // Populate items
            let itemsHtml = '';
            let subtotal = 0;
            let totalTax = 0;
            let totalItemDiscounts = 0;

            cart.forEach(item => {
                const itemSubtotal = item.quantity * item.price;
                
                // Calculate item-level discount
                let itemDiscountAmount = 0;
                if (item.discountValue > 0) {
                    if (item.discountType === 'percent') {
                        itemDiscountAmount = itemSubtotal * (item.discountValue / 100);
                    } else {
                        itemDiscountAmount = item.discountValue;
                    }
                }
                
                const itemSubtotalAfterDiscount = itemSubtotal - itemDiscountAmount;
                const itemTax = itemSubtotalAfterDiscount * (item.tax / 100);
                const itemTotal = itemSubtotalAfterDiscount + itemTax;
                
                subtotal += itemSubtotal;
                totalItemDiscounts += itemDiscountAmount;
                totalTax += itemTax;

                // Show discount info if applicable
                const discountInfo = itemDiscountAmount > 0 
                    ? `<br><small class="text-danger-600">-${currency} ${itemDiscountAmount.toFixed(2)} (${item.discountType === 'percent' ? item.discountValue + '%' : 'Fixed'})</small>` 
                    : '';

                itemsHtml += `
                    <tr>
                        <td style="font-size: 13px;">${item.name}${discountInfo}</td>
                        <td style="font-size: 13px;" class="text-center">${item.quantity}</td>
                        <td style="font-size: 13px;" class="text-end">${currency} ${item.price.toFixed(2)}</td>
                        <td style="font-size: 13px;" class="text-end">${currency} ${itemTax.toFixed(2)}</td>
                        <td style="font-size: 13px;" class="text-end">${currency} ${itemTotal.toFixed(2)}</td>
                    </tr>
                `;
            });

            const grandTotal = subtotal - totalItemDiscounts + totalTax;

            $('#confirmItems').html(itemsHtml);
            $('#confirmSubtotal').text(`${currency} ${subtotal.toFixed(2)}`);
            
            // Show/hide item discounts
            if (totalItemDiscounts > 0) {
                $('#confirmItemDiscountRow').show();
                $('#confirmItemDiscount').text(`-${currency} ${totalItemDiscounts.toFixed(2)}`);
            } else {
                $('#confirmItemDiscountRow').hide();
            }
            
            $('#confirmTax').text(`${currency} ${totalTax.toFixed(2)}`);
            $('#confirmTotal').text(`${currency} ${grandTotal.toFixed(2)}`);

            // Close sale info modal and open confirmation
            $('#saleInfoModal').modal('hide');
            setTimeout(() => {
                $('#confirmationModal').modal('show');
            }, 300);
        }

        function backToSaleInfo() {
            $('#confirmationModal').modal('hide');
            setTimeout(() => {
                $('#saleInfoModal').modal('show');
            }, 300);
        }

        // Complete Sale
        function completeSale() {
            const saleData = {
                date: $('#saleDate').val(),
                customer_id: $('#customerId').val() || null,
                sales_channel_id: $('#salesChannelId').val(),
                payment_method: $('#paymentMethod').val(),
                payment_status: $('#paymentStatus').val(),
                notes: $('#saleNotes').val(),
                items: cart.map(item => {
                    // Calculate item discount amount
                    let itemDiscountAmount = 0;
                    if (item.discountValue > 0) {
                        const itemSubtotal = item.quantity * item.price;
                        if (item.discountType === 'percent') {
                            itemDiscountAmount = itemSubtotal * (item.discountValue / 100);
                        } else {
                            itemDiscountAmount = item.discountValue;
                        }
                    }
                    
                    return {
                        product_id: item.id,
                        quantity: item.quantity,
                        unit_price: item.price,
                        discount_type: item.discountType || 'percent',
                        discount_value: item.discountValue || 0,
                        discount_amount: itemDiscountAmount
                    };
                })
            };

            // Send to server
            $.ajax({
                url: '{{ route("sales.store") }}',
                method: 'POST',
                data: saleData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#confirmationModal').modal('hide');
                    
                    // Show success message
                    alert('Sale completed successfully!');
                    
                    // Clear cart and reset
                    cart = [];
                    updateCart();
                    
                    // Redirect to sales index
                    window.location.href = '{{ route("sales.index") }}';
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to complete sale'));
                }
            });
        }

        // Product Search Function
        function initProductSearch() {
            const searchInput = document.getElementById('productSearch');
            if (!searchInput) {
                console.error('Search input not found');
                return;
            }

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const productItems = document.querySelectorAll('.product-item');
                
                productItems.forEach(function(item) {
                    const name = (item.getAttribute('data-name') || '').toLowerCase();
                    const sku = (item.getAttribute('data-sku') || '').toLowerCase();
                    const category = (item.getAttribute('data-category') || '').toLowerCase();
                    
                    if (name.includes(searchTerm) || sku.includes(searchTerm) || category.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

        // Initialize
        $(document).ready(function() {
            // Initialize cart
            updateCart();

            // Initialize product search
            initProductSearch();
        });
    </script>
</x-layout.master>

