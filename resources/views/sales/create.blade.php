<x-layout.master>

    <div class="dashboard-main-body">
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
                <li class="fw-medium">Record Sale</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Step Progress Indicator -->
        <div class="card mb-24">
            <div class="card-body p-20">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-3" id="step1Indicator">
                            <div class="step-number active">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Step 1</h6>
                                <small class="text-secondary-light">Sale Information</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-3" id="step2Indicator">
                            <div class="step-number">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Step 2</h6>
                                <small class="text-secondary-light">Add Items</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-3" id="step3Indicator">
                            <div class="step-number">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">Step 3</h6>
                                <small class="text-secondary-light">Review & Submit</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="progress mt-3" style="height: 4px;">
                    <div class="progress-bar bg-primary-600" role="progressbar" id="progressBar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf
            
            <div class="row gy-4">
                <!-- Sale Information Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="w-32-px h-32-px bg-primary-100 text-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-circle-fill"></i>
                                </div>
                                <h6 class="card-title mb-0">Step 1: Sale Information</h6>
                            </div>
                            <span class="badge bg-primary-100 text-primary-600 px-12 py-6">Required</span>
                        </div>
                        <div class="card-body p-24">
                            <div class="row g-4">
                                <!-- Date -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Sale Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Invoice Number -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Invoice Number
                                    </label>
                                    <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" placeholder="Auto-generated" value="{{ old('invoice_number') }}">
                                    <small class="text-secondary-light">Leave blank for auto-generation</small>
                                    @error('invoice_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Customer -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Customer
                                    </label>
                                    <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror">
                                        <option value="">Walk-in Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Sales Channel -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Sales Channel <span class="text-danger">*</span>
                                    </label>
                                    <select name="sales_channel_id" class="form-select @error('sales_channel_id') is-invalid @enderror" required>
                                        <option value="">Select Channel</option>
                                        @foreach($salesChannels as $channel)
                                            <option value="{{ $channel->id }}" {{ old('sales_channel_id') == $channel->id ? 'selected' : '' }}>
                                                {{ $channel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sales_channel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Notes
                                    </label>
                                    <textarea name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional notes about this sale">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sale Items Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="w-32-px h-32-px bg-success-100 text-success-600 rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-circle-fill"></i>
                                </div>
                                <div>
                                    <h6 class="card-title mb-0">Step 2: Sale Items</h6>
                                    <small class="text-secondary-light" id="itemCount">0 items added</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success-600 btn-sm" id="addItemBtn">
                                <i class="bi bi-circle-fill"></i>
                                Add Item
                            </button>
                        </div>
                        <div class="card-body p-24">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="itemsTable">
                                    <thead class="bg-neutral-50">
                                        <tr>
                                            <th style="width: 35%;">Product</th>
                                            <th style="width: 15%;" class="text-center">Quantity</th>
                                            <th style="width: 15%;" class="text-end">Unit Price</th>
                                            <th style="width: 15%;" class="text-end">Tax</th>
                                            <th style="width: 15%;" class="text-end">Total</th>
                                            <th style="width: 5%;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemsTableBody">
                                        <!-- Items will be added here dynamically -->
                                    </tbody>
                                    <tfoot class="bg-neutral-50 fw-bold">
                                        <tr>
                                            <td colspan="3" class="text-end">Subtotal:</td>
                                            <td class="text-end" colspan="3">
                                                <span id="subtotalDisplay">{{ auth()->user()->business->currency }} 0.00</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-end">Total Tax:</td>
                                            <td class="text-end" colspan="3">
                                                <span id="totalTaxDisplay">{{ auth()->user()->business->currency }} 0.00</span>
                                            </td>
                                        </tr>
                                        <tr class="text-primary-600">
                                            <td colspan="3" class="text-end" style="font-size: 16px;">Grand Total:</td>
                                            <td class="text-end" colspan="3" style="font-size: 16px;">
                                                <span id="grandTotalDisplay">{{ auth()->user()->business->currency }} 0.00</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <div id="noItemsMessage" class="text-center py-5">
                                <div class="mb-4">
                                    <div class="w-80-px h-80-px bg-neutral-100 rounded-circle d-inline-flex align-items-center justify-content-center mb-3">
                                        <i class="bi bi-circle-fill"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-2">No Items Added Yet</h6>
                                <p class="text-secondary-light mb-4">Start by adding products to this sale</p>
                                <button type="button" class="btn btn-success-600 mt-2 px-24 py-12" id="addFirstItemBtn">
                                    <i class="bi bi-circle-fill"></i>
                                    Add First Item
                                </button>
                                <div class="mt-4">
                                    <small class="text-secondary-light">
                                        <i class="bi bi-circle-fill"></i>
                                        Tip: You can add multiple items and adjust quantities before submitting
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <div class="w-32-px h-32-px bg-warning-100 text-warning-600 rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-circle-fill"></i>
                                </div>
                                <h6 class="card-title mb-0">Step 3: Review & Submit</h6>
                            </div>
                        </div>
                        <div class="card-body p-24">
                            <div class="alert alert-info d-flex align-items-start gap-3 mb-4">
                                <i class="bi bi-circle-fill"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Ready to record this sale?</h6>
                                    <p class="mb-0 text-sm">Please review the sale details above. Once submitted, the stock quantities will be automatically updated.</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="{{ route('sales.index') }}" class="btn btn-neutral-600 hover-bg-neutral-700 radius-8 px-24 py-12">
                                    <i class="bi bi-circle-fill"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary-600 hover-bg-primary-700 radius-8 px-32 py-12 fw-bold" id="submitBtn" disabled>
                                    <i class="bi bi-circle-fill"></i>
                                    <span id="submitBtnText">Record Sale</span>
                                    <span id="submitBtnLoader" class="spinner-border spinner-border-sm ms-2" style="display: none;"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-script/>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log('====== SALES CREATE SCRIPT LOADED ======');
            console.log('jQuery version:', $.fn.jquery);
            
            // Initialize Select2
            try {
                $('#customer_id').select2({
                    placeholder: 'Select or search customer',
                    allowClear: true
                });
                console.log('Customer Select2 initialized');
            } catch (e) {
                console.error('Select2 initialization error:', e);
            }

            let itemCounter = 0;
            const products = @json($products);
            const currency = '{{ auth()->user()->business->currency }}';
            
            console.log('Products loaded:', products.length);
            console.log('Currency:', currency);
            console.log('Buttons exist:', $('#addItemBtn').length, $('#addFirstItemBtn').length);

            // Update progress indicators
            function updateProgress() {
                const itemCount = $('#itemsTableBody tr').length;
                
                // Update item count
                $('#itemCount').text(itemCount + (itemCount === 1 ? ' item added' : ' items added'));
                
                // Update progress bar and steps
                if (itemCount === 0) {
                    // Step 1: Sale Information
                    $('#progressBar').css('width', '33%').attr('aria-valuenow', 33);
                    $('#step1Indicator .step-number').addClass('active').removeClass('completed');
                    $('#step2Indicator .step-number').removeClass('active completed');
                    $('#step3Indicator .step-number').removeClass('active completed');
                    $('#submitBtn').prop('disabled', true);
                } else {
                    // Step 2: Items Added
                    $('#progressBar').css('width', '66%').attr('aria-valuenow', 66);
                    $('#step1Indicator .step-number').removeClass('active').addClass('completed');
                    $('#step2Indicator .step-number').addClass('active').removeClass('completed');
                    $('#step3Indicator .step-number').removeClass('active').removeClass('completed');
                    $('#submitBtn').prop('disabled', false);
                    
                    // Step 3 indicator (show ready state)
                    setTimeout(function() {
                        $('#progressBar').css('width', '100%').attr('aria-valuenow', 100);
                        $('#step2Indicator .step-number').removeClass('active').addClass('completed');
                        $('#step3Indicator .step-number').addClass('active');
                    }, 500);
                }
            }
            
            // Hide/show no items message
            function updateNoItemsMessage() {
                const hasItems = $('#itemsTableBody tr').length > 0;
                if (hasItems) {
                    $('#noItemsMessage').hide();
                    $('#itemsTable').show();
                } else {
                    $('#noItemsMessage').show();
                    $('#itemsTable').hide();
                }
                
                // Update progress
                updateProgress();
            }

            // Add item row
            function addItemRow() {
                console.log('addItemRow function called, itemCounter:', itemCounter);
                itemCounter++;
                
                let optionsHtml = '<option value="">Select Product</option>';
                console.log('Building options from', products.length, 'products');
                products.forEach(function(p) {
                    optionsHtml += `<option value="${p.id}" 
                        data-price="${p.price || 0}" 
                        data-cost="${p.cost || 0}"
                        data-tax="${p.tax_amount || 0}"
                        data-stock="${p.stock_quantity || 0}">
                        ${p.name} - ${p.sku || 'N/A'} (Stock: ${p.stock_quantity || 0})
                    </option>`;
                });
                
                const row = `
                    <tr data-item-id="${itemCounter}">
                        <td>
                            <select name="items[${itemCounter}][product_id]" class="form-select form-select-sm product-select" required data-item-id="${itemCounter}">
                                ${optionsHtml}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[${itemCounter}][quantity]" class="form-control form-control-sm text-center quantity-input" min="1" value="1" required data-item-id="${itemCounter}">
                        </td>
                        <td>
                            <input type="number" name="items[${itemCounter}][unit_price]" class="form-control form-control-sm text-end unit-price-input" step="0.01" min="0" value="0" required data-item-id="${itemCounter}">
                        </td>
                        <td class="text-end align-middle">
                            <span class="item-tax" data-item-id="${itemCounter}">${currency} 0.00</span>
                        </td>
                        <td class="text-end align-middle">
                            <span class="item-total fw-bold text-primary-600" data-item-id="${itemCounter}">${currency} 0.00</span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-item-id="${itemCounter}">
                                <i class="bi bi-circle-fill"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#itemsTableBody').append(row);
                updateNoItemsMessage();
                
                // Initialize Select2 for the new product select
                try {
                    $(`select[name="items[${itemCounter}][product_id]"]`).select2({
                        placeholder: 'Select product',
                        width: '100%'
                    });
                } catch (e) {
                    console.log('Select2 initialization skipped:', e);
                }
            }

            // Calculate item total
            function calculateItemTotal(itemId) {
                const quantity = parseFloat($(`input[name="items[${itemId}][quantity]"]`).val()) || 0;
                const unitPrice = parseFloat($(`input[name="items[${itemId}][unit_price]"]`).val()) || 0;
                const productSelect = $(`select[name="items[${itemId}][product_id]"]`);
                const selectedOption = productSelect.find('option:selected');
                const taxRate = parseFloat(selectedOption.data('tax')) || 0;
                
                const subtotal = quantity * unitPrice;
                // Tax rate is stored as percentage (e.g., 10 for 10%)
                const tax = subtotal * (taxRate / 100);
                const total = subtotal + tax;
                
                $(`.item-tax[data-item-id="${itemId}"]`).text(`${currency} ${tax.toFixed(2)}`);
                $(`.item-total[data-item-id="${itemId}"]`).text(`${currency} ${total.toFixed(2)}`);
                
                calculateGrandTotal();
            }

            // Calculate grand total
            function calculateGrandTotal() {
                let subtotal = 0;
                let totalTax = 0;
                
                $('#itemsTableBody tr').each(function() {
                    const itemId = $(this).data('item-id');
                    const quantity = parseFloat($(`input[name="items[${itemId}][quantity]"]`).val()) || 0;
                    const unitPrice = parseFloat($(`input[name="items[${itemId}][unit_price]"]`).val()) || 0;
                    const productSelect = $(`select[name="items[${itemId}][product_id]"]`);
                    const selectedOption = productSelect.find('option:selected');
                    const taxRate = parseFloat(selectedOption.data('tax')) || 0;
                    
                    const itemSubtotal = quantity * unitPrice;
                    // Tax rate is stored as percentage
                    const itemTax = itemSubtotal * (taxRate / 100);
                    
                    subtotal += itemSubtotal;
                    totalTax += itemTax;
                });
                
                const grandTotal = subtotal + totalTax;
                
                $('#subtotalDisplay').text(`${currency} ${subtotal.toFixed(2)}`);
                $('#totalTaxDisplay').text(`${currency} ${totalTax.toFixed(2)}`);
                $('#grandTotalDisplay').text(`${currency} ${grandTotal.toFixed(2)}`);
            }

            // Event: Add item button (using event delegation for reliability)
            $(document).on('click', '#addItemBtn, #addFirstItemBtn', function(e) {
                e.preventDefault();
                console.log('Add item button clicked');
                addItemRow();
            });

            // Event: Remove item button
            $(document).on('click', '.remove-item-btn', function() {
                const itemId = $(this).data('item-id');
                $(`tr[data-item-id="${itemId}"]`).remove();
                updateNoItemsMessage();
                calculateGrandTotal();
            });

            // Event: Product selection change
            $(document).on('change', '.product-select', function() {
                const itemId = $(this).data('item-id');
                const selectedOption = $(this).find('option:selected');
                const price = parseFloat(selectedOption.data('price')) || 0;
                const stock = parseFloat(selectedOption.data('stock')) || 0;
                
                // Update unit price
                $(`input[name="items[${itemId}][unit_price]"]`).val(price.toFixed(2));
                
                // Update quantity max to available stock
                $(`input[name="items[${itemId}][quantity]"]`).attr('max', stock);
                
                calculateItemTotal(itemId);
            });

            // Event: Quantity or price change
            $(document).on('input', '.quantity-input, .unit-price-input', function() {
                const itemId = $(this).data('item-id');
                calculateItemTotal(itemId);
            });

            // Form validation and submission
            $('#saleForm').on('submit', function(e) {
                const hasItems = $('#itemsTableBody tr').length > 0;
                if (!hasItems) {
                    e.preventDefault();
                    alert('Please add at least one item to the sale.');
                    return false;
                }
                
                // Validate stock for each item
                let stockError = false;
                $('#itemsTableBody tr').each(function() {
                    const itemId = $(this).data('item-id');
                    const quantity = parseFloat($(`input[name="items[${itemId}][quantity]"]`).val()) || 0;
                    const productSelect = $(`select[name="items[${itemId}][product_id]"]`);
                    const selectedOption = productSelect.find('option:selected');
                    const stock = parseFloat(selectedOption.data('stock')) || 0;
                    
                    if (quantity > stock) {
                        stockError = true;
                        alert(`Insufficient stock for ${selectedOption.text()}. Available: ${stock}`);
                        return false;
                    }
                });
                
                if (stockError) {
                    e.preventDefault();
                    return false;
                }
                
                // Show loading state
                $('#submitBtn').prop('disabled', true);
                $('#submitBtnText').text('Recording Sale...');
                $('#submitBtnLoader').show();
                
                // Update progress to final state
                $('#progressBar').css('width', '100%');
                $('#step3Indicator .step-number').removeClass('active').addClass('completed');
            });

            // Initialize
            updateNoItemsMessage();
        });
    </script>

    <style>
        /* Select2 Styling */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
            padding-left: 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
        
        /* Step Indicators */
        .step-number {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #f0f0f0;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.3s ease;
            border: 3px solid transparent;
        }
        
        .step-number.active {
            background: linear-gradient(135deg, #487FFF 0%, #3D6FE8 100%);
            color: white;
            border-color: #487FFF;
            box-shadow: 0 4px 12px rgba(72, 127, 255, 0.3);
            transform: scale(1.1);
        }
        
        .step-number.completed {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-color: #10b981;
        }
        
        /* Progress Bar Animation */
        .progress-bar {
            transition: width 0.5s ease;
        }
        
        /* Table Display */
        #itemsTable {
            display: none;
        }
        
        /* Empty State Animation */
        #noItemsMessage {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Stock Badge */
        .stock-badge {
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 600;
        }
        
        .stock-low {
            background: #FEF3C7;
            color: #92400E;
        }
        
        .stock-out {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        /* Submit Button Loading State */
        #submitBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        /* Alert Animation */
        .alert {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

</x-layout.master>

