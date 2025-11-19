<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Sale</h6>
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
                <li class="fw-medium">Edit Sale</li>
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

        <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="saleForm">
            @csrf
            @method('PUT')
            
            <div class="row gy-4">
                <!-- Sale Information Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h6 class="card-title mb-0">Sale Information</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="row g-4">
                                <!-- Date -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Sale Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $sale->date->format('Y-m-d')) }}" required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Invoice Number -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8">
                                        Invoice Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $sale->invoice_number) }}" required>
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
                                            <option value="{{ $customer->id }}" {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
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
                                            <option value="{{ $channel->id }}" {{ old('sales_channel_id', $sale->sales_channel_id) == $channel->id ? 'selected' : '' }}>
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
                                    <textarea name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional notes about this sale">{{ old('notes', $sale->notes) }}</textarea>
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
                            <h6 class="card-title mb-0">Sale Items</h6>
                            <button type="button" class="btn btn-primary-600 btn-sm" id="addItemBtn">
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
                                        <!-- Items will be loaded here -->
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
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-neutral-600 hover-bg-neutral-700 radius-8 px-24 py-11">
                            <i class="bi bi-circle-fill"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-success-600 hover-bg-success-700 radius-8 px-24 py-11" id="submitBtn">
                            <i class="bi bi-circle-fill"></i>
                            Update Sale
                        </button>
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
            // Initialize Select2
            $('#customer_id').select2({
                placeholder: 'Select or search customer',
                allowClear: true
            });

            let itemCounter = 0;
            const products = @json($products);
            const existingItems = @json($sale->saleItems);
            const currency = '{{ auth()->user()->business->currency }}';

            // Add item row
            function addItemRow(itemData = null) {
                itemCounter++;
                const productId = itemData ? itemData.product_id : '';
                const quantity = itemData ? itemData.quantity : 1;
                const unitPrice = itemData ? itemData.unit_price : 0;
                
                const row = `
                    <tr data-item-id="${itemCounter}">
                        <td>
                            <select name="items[${itemCounter}][product_id]" class="form-select form-select-sm product-select" required data-item-id="${itemCounter}">
                                <option value="">Select Product</option>
                                ${products.map(p => `
                                    <option value="${p.id}" 
                                        data-price="${p.price}" 
                                        data-cost="${p.cost}"
                                        data-tax="${p.tax_amount || 0}"
                                        data-stock="${p.stock_quantity}"
                                        ${productId == p.id ? 'selected' : ''}>
                                        ${p.name} - ${p.sku || 'N/A'} (Stock: ${p.stock_quantity})
                                    </option>
                                `).join('')}
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[${itemCounter}][quantity]" class="form-control form-control-sm text-center quantity-input" min="1" value="${quantity}" required data-item-id="${itemCounter}">
                        </td>
                        <td>
                            <input type="number" name="items[${itemCounter}][unit_price]" class="form-control form-control-sm text-end unit-price-input" step="0.01" min="0" value="${unitPrice}" required data-item-id="${itemCounter}">
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
                
                // Initialize Select2 for the new product select
                $(`select[name="items[${itemCounter}][product_id]"]`).select2({
                    placeholder: 'Select product',
                    width: '100%'
                });
                
                // Calculate initial totals
                if (itemData) {
                    calculateItemTotal(itemCounter);
                }
            }

            // Calculate item total
            function calculateItemTotal(itemId) {
                const quantity = parseFloat($(`input[name="items[${itemId}][quantity]"]`).val()) || 0;
                const unitPrice = parseFloat($(`input[name="items[${itemId}][unit_price]"]`).val()) || 0;
                const productSelect = $(`select[name="items[${itemId}][product_id]"]`);
                const selectedOption = productSelect.find('option:selected');
                const taxAmount = parseFloat(selectedOption.data('tax')) || 0;
                
                const subtotal = quantity * unitPrice;
                const tax = subtotal * (taxAmount / 100);
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
                    const taxAmount = parseFloat(selectedOption.data('tax')) || 0;
                    
                    const itemSubtotal = quantity * unitPrice;
                    const itemTax = itemSubtotal * (taxAmount / 100);
                    
                    subtotal += itemSubtotal;
                    totalTax += itemTax;
                });
                
                const grandTotal = subtotal + totalTax;
                
                $('#subtotalDisplay').text(`${currency} ${subtotal.toFixed(2)}`);
                $('#totalTaxDisplay').text(`${currency} ${totalTax.toFixed(2)}`);
                $('#grandTotalDisplay').text(`${currency} ${grandTotal.toFixed(2)}`);
            }

            // Event: Add item button
            $('#addItemBtn').on('click', function() {
                addItemRow();
            });

            // Event: Remove item button
            $(document).on('click', '.remove-item-btn', function() {
                const itemId = $(this).data('item-id');
                $(`tr[data-item-id="${itemId}"]`).remove();
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

            // Form validation
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
            });

            // Load existing items
            existingItems.forEach(item => {
                addItemRow({
                    product_id: item.product_id,
                    quantity: item.quantity,
                    unit_price: item.unit_price
                });
            });

            // Initial calculation
            calculateGrandTotal();
        });
    </script>

    <style>
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
    </style>

</x-layout.master>

