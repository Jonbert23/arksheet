<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Stock Entry</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
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
                <li class="fw-medium">Edit Stock</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:alert-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('stock.update', $stock->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row gy-4">
                <!-- Warning Card (Full Width) -->
                <div class="col-12">
                    <div class="card bg-warning-50 border border-warning-600">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:alert" class="text-warning-600 text-xl"></iconify-icon>
                                <div>
                                    <h6 class="text-warning-600 mb-8">Important Notice</h6>
                                    <ul class="text-sm text-secondary-light mb-0 ps-16">
                                        <li class="mb-8">Editing this stock entry will adjust the product's current stock quantity</li>
                                        <li class="mb-8">If you change the product, stock will be removed from the old product and added to the new one</li>
                                        <li class="mb-8">Changing quantity will increase/decrease the product's stock accordingly</li>
                                        <li>All changes are tracked with timestamps for audit purposes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Entry Information -->
                <div class="col-lg-12">
                    <div class="card mb-24">
                        <div class="card-header bg-neutral-50">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:pencil" class="text-primary-600 text-xl"></iconify-icon>
                                <h6 class="card-title mb-0">Stock Entry Information</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <!-- Product -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Select Product <span class="text-danger">*</span></label>
                                    <select name="product_id" id="product_id" class="form-select select2-product @error('product_id') is-invalid @enderror" required>
                                        <option value="">Search and select a product...</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}" 
                                                    data-unit="{{ $product->unit ?? 'pcs' }}"
                                                    data-current-stock="{{ $product->stock_quantity }}"
                                                    data-current-cost="{{ $product->cost }}"
                                                    data-sku="{{ $product->sku ?? 'N/A' }}"
                                                    data-name="{{ $product->name }}"
                                                    {{ old('product_id', $stock->product_id) == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }} - {{ $product->sku ?? 'No SKU' }} (Current: {{ $product->stock_quantity }} {{ $product->unit ?? 'pcs' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-secondary-light" id="product-info"></small>
                                </div>

                                <!-- Date -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Date Received <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $stock->date->format('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="0" value="{{ old('quantity', $stock->quantity) }}" min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-secondary-light">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs"></iconify-icon>
                                        <span id="unit-label">Units received</span>
                                    </small>
                                </div>

                                <!-- Cost Per Unit -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Cost Per Unit <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-warning-50 text-warning-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" name="cost_per_unit" id="cost_per_unit" step="0.01" class="form-control @error('cost_per_unit') is-invalid @enderror" placeholder="0.00" value="{{ old('cost_per_unit', $stock->cost_per_unit) }}" min="0" required>
                                        @error('cost_per_unit')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Total Cost (Auto-calculated) -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Total Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success-50 text-success-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                        <input type="text" id="total_cost_display" class="form-control fw-semibold text-success-600" placeholder="0.00" readonly>
                                    </div>
                                    <small class="text-secondary-light">
                                        <iconify-icon icon="mdi:calculator" class="text-xs"></iconify-icon>
                                        Automatically calculated
                                    </small>
                                </div>

                                <!-- Reference Number -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Reference / PO Number</label>
                                    <input type="text" name="reference_number" class="form-control @error('reference_number') is-invalid @enderror" placeholder="PO-12345, INV-67890, etc." value="{{ old('reference_number', $stock->reference_number) }}">
                                    @error('reference_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Supplier -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Supplier</label>
                                    <input type="text" name="supplier" class="form-control @error('supplier') is-invalid @enderror" placeholder="Supplier name or company" value="{{ old('supplier', $stock->supplier) }}">
                                    @error('supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Notes</label>
                                    <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional information about this stock entry...">{{ old('notes', $stock->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions (Full Width) -->
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-24">
                            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                                <div class="text-secondary-light">
                                    <iconify-icon icon="mdi:information-outline" class="text-lg"></iconify-icon>
                                    <span class="ms-2">Fields marked with <span class="text-danger fw-semibold">*</span> are required</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="{{ route('stock.show', $stock->id) }}" class="btn bg-neutral-200 text-neutral-900 hover-bg-neutral-300 radius-8 px-32 py-14 d-flex align-items-center gap-2 fw-semibold">
                                        <iconify-icon icon="mdi:arrow-left" class="text-xl"></iconify-icon>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary-600 hover-bg-primary-700 radius-8 px-32 py-14 d-flex align-items-center gap-2 fw-semibold shadow-sm">
                                        <iconify-icon icon="mdi:content-save" class="text-xl"></iconify-icon>
                                        Update Stock Entry
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <style>
        /* Custom Select2 Styling */
        .select2-container--default .select2-selection--single {
            height: 42px;
            padding: 0.375rem 0.75rem;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
            padding-left: 0;
            color: #495057;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px;
        }
        
        .select2-dropdown {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
        }
        
        /* Search Box - Force Display */
        .select2-search--dropdown {
            display: block !important;
            padding: 10px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        
        .select2-search--dropdown .select2-search__field {
            display: block !important;
            width: 100% !important;
            height: 38px !important;
            padding: 8px 12px !important;
            font-size: 14px !important;
            line-height: 1.5 !important;
            color: #495057 !important;
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            outline: none !important;
        }
        
        .select2-search--dropdown .select2-search__field:focus {
            border-color: #487FFF !important;
            box-shadow: 0 0 0 0.2rem rgba(72, 127, 255, 0.25) !important;
        }
        
        .select2-results {
            max-height: 350px;
            overflow-y: auto;
        }
        
        .select2-results__option {
            padding: 10px 12px;
        }
        
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #487FFF !important;
            color: white !important;
        }
        
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e9ecef;
        }
    </style>
    
    <script>
        $(document).ready(function() {
            console.log('🔍 Initializing Select2 for product search...');
            
            // Initialize Select2 for product selection with search enabled
            $("#product_id").select2({
                placeholder: "Search and select a product...",
                allowClear: true,
                width: "100%",
                minimumResultsForSearch: 0, // Force search bar to always show
                templateResult: formatProduct,
                templateSelection: formatProductSelection
            });
            
            console.log('✅ Select2 initialized');
            
            // Debug: Check if search box exists when dropdown opens
            $('#product_id').on('select2:open', function() {
                console.log('🔓 Dropdown opened');
                setTimeout(function() {
                    var searchField = $('.select2-search--dropdown .select2-search__field');
                    console.log('🔍 Search field found:', searchField.length > 0);
                    console.log('📊 Search field visible:', searchField.is(':visible'));
                    if (searchField.length > 0) {
                        console.log('✅ Search box exists in DOM');
                        searchField.focus(); // Auto-focus the search box
                    } else {
                        console.error('❌ Search box NOT found in DOM!');
                    }
                }, 100);
            });
            
            // Custom format for dropdown results
            function formatProduct(product) {
                if (!product.id) {
                    return product.text;
                }
                
                var $product = $(product.element);
                var productName = $product.data("name");
                var sku = $product.data("sku");
                var stock = $product.data("current-stock");
                var unit = $product.data("unit");
                
                var $result = $(
                    '<div class="d-flex flex-column">' +
                        '<span class="fw-semibold">' + productName + '</span>' +
                        '<small class="text-muted">SKU: ' + sku + ' | Stock: ' + stock + ' ' + unit + '</small>' +
                    '</div>'
                );
                
                return $result;
            }
            
            // Custom format for selected product
            function formatProductSelection(product) {
                if (!product.id) {
                    return product.text;
                }
                
                var $product = $(product.element);
                var productName = $product.data("name");
                
                return productName || product.text;
            }
            
            // Calculate total cost on quantity or cost change
            function calculateTotalCost() {
                const quantity = parseFloat($("#quantity").val()) || 0;
                const costPerUnit = parseFloat($("#cost_per_unit").val()) || 0;
                const totalCost = quantity * costPerUnit;
                
                $("#total_cost_display").val(totalCost.toFixed(2));
            }

            $("#quantity, #cost_per_unit").on("input", calculateTotalCost);

            // Update product info on selection
            $("#product_id").on("change", function() {
                const selectedOption = $(this).find("option:selected");
                const unit = selectedOption.data("unit") || "pcs";
                const currentStock = selectedOption.data("current-stock") || 0;
                const currentCost = selectedOption.data("current-cost") || 0;

                // Update unit label
                $("#unit-label").text(unit + " received");

                // Show product info
                if (selectedOption.val()) {
                    $("#product-info").html(
                        '<iconify-icon icon="mdi:information" class="text-xs"></iconify-icon>' +
                        'Current stock: <strong>' + currentStock + ' ' + unit + '</strong> | Current cost: <strong>₱ ' + currentCost.toFixed(2) + '</strong>'
                    );
                } else {
                    $("#product-info").html("");
                }
            });

            // Trigger on page load if product is selected
            if ($("#product_id").val()) {
                $("#product_id").trigger("change");
            }

            // Initial calculation
            calculateTotalCost();
        });
    </script>

    <x-script/>

</x-layout.master>

