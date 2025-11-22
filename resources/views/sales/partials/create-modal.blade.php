<!-- Record Sale Modal -->
<div class="modal fade" id="recordSaleModal" tabindex="-1" aria-labelledby="recordSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content radius-12">
            <div class="modal-header border-bottom py-16 px-24">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="recordSaleModalLabel">Record New Sale</h5>
                        <p class="text-secondary-light mb-0" style="font-size: 13px;">Fill in the details to record a new sale</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-24 py-24" style="max-height: 70vh; overflow-y: auto;">
                <form action="{{ route('sales.store') }}" method="POST" id="modalSaleForm">
                    @csrf
                    
                    <!-- Sale Information -->
                    <div class="mb-24">
                        <h6 class="fw-bold mb-16" style="font-size: 18px !important;">Sale Information</h6>
                            <div class="row g-4">
                                <!-- Date -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Sale Date <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" name="date" id="modal_sale_date" class="form-control" style="height: 44px;" value="{{ date('Y-m-d') }}" required>
                                </div>

                                <!-- Invoice Number -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Invoice Number
                                    </label>
                                    <input type="text" name="invoice_number" id="modal_invoice_number" class="form-control" style="height: 44px;" placeholder="Auto-generated">
                                    <small class="text-secondary-light" style="font-size: 12px;">Leave blank for auto-generation</small>
                                </div>

                                <!-- Customer -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Customer
                                    </label>
                                    <select name="customer_id" id="modal_customer_id" class="form-select" style="height: 44px;">
                                        <option value="">Walk-in Customer</option>
                                        @foreach($customers ?? [] as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sales Channel -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Sales Channel <span class="text-danger">*</span>
                                    </label>
                                    <select name="sales_channel_id" id="modal_sales_channel_id" class="form-select" style="height: 44px;" required>
                                        <option value="">Select Channel</option>
                                        @foreach($salesChannels ?? [] as $channel)
                                            <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Payment Method -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Payment Method
                                    </label>
                                    <select name="payment_method" id="modal_payment_method" class="form-select" style="height: 44px;">
                                        <option value="">Select Method</option>
                                        <option value="cash">Cash</option>
                                        <option value="card">Card</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="gcash">GCash</option>
                                        <option value="paymaya">PayMaya</option>
                                    </select>
                                </div>

                                <!-- Payment Status -->
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">
                                        Payment Status <span class="text-danger">*</span>
                                    </label>
                                    <select name="payment_status" id="modal_payment_status" class="form-select" style="height: 44px;" required>
                                        <option value="paid">Paid</option>
                                        <option value="pending">Pending</option>
                                        <option value="partial">Partial</option>
                                    </select>
                                </div>
                            </div>
                    </div>

                    <!-- Sale Items -->
                    <div class="mb-24">
                        <div class="d-flex justify-content-between align-items-center mb-16">
                            <h6 class="fw-bold mb-0" style="font-size: 18px !important;">Sale Items</h6>
                            <button type="button" class="btn btn-sm btn-primary-600 px-16 py-8" id="modalAddItemBtn">
                                <i class="bi bi-plus-circle"></i>
                                Add Item
                            </button>
                        </div>
                        
                        <!-- Empty State -->
                        <div id="modalEmptyState" class="text-center py-48 border radius-8 bg-neutral-50">
                            <i class="bi bi-inbox text-secondary-light mb-3" style="font-size: 48px;"></i>
                            <p class="text-secondary-light fw-semibold mb-8">No items added yet</p>
                            <p class="text-secondary-light text-sm mb-16">Click "Add Item" button to start adding products to this sale</p>
                            <button type="button" class="btn btn-primary-600 px-20 py-11 radius-8" onclick="document.getElementById('modalAddItemBtn').click()">
                                <i class="bi bi-plus-circle"></i>
                                Add First Item
                            </button>
                        </div>
                        
                        <div id="modalSaleItemsContainer" style="display: none;">
                            <!-- Items will be added dynamically -->
                        </div>
                    </div>

                    <!-- Totals Summary -->
                    <div class="mb-0">
                        <h6 class="fw-bold mb-16" style="font-size: 18px !important;">Order Summary</h6>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold text-dark mb-8" style="font-size: 14px;">Notes</label>
                                    <textarea name="notes" id="modal_notes" rows="4" class="form-control" style="resize: vertical;" placeholder="Additional information..."></textarea>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-16 bg-neutral-50 radius-8 h-100">
                                        <div class="d-flex flex-column gap-2 h-100 justify-content-center">
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary-light" style="font-size: 13px;">Subtotal:</span>
                                                <span class="fw-semibold" id="modal_subtotal_display">PHP 0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary-light" style="font-size: 13px;">Discount:</span>
                                                <span class="fw-semibold" id="modal_discount_display">PHP 0.00</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span class="text-secondary-light" style="font-size: 13px;">Tax:</span>
                                                <span class="fw-semibold" id="modal_tax_display">PHP 0.00</span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-bold">Grand Total:</span>
                                                <span class="fw-bold text-primary-600" style="font-size: 18px;" id="modal_grand_total_display">PHP 0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top py-16 px-24 bg-white">
                <div class="d-flex align-items-center justify-content-end gap-3 w-100">
                    <button type="button" class="btn text-secondary-light border border-neutral-200 hover-bg-neutral-100 radius-8 px-20 py-11" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" form="modalSaleForm" class="btn btn-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle"></i>
                        Record Sale
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

