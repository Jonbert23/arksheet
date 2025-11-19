{{-- Step 3: Initial Stock Entry (Optional) --}}
<div class="wizard-step" id="step3" data-step="3" style="display: none;">
    <!-- Step Header & Options -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-box text-white"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Initial Stock Entry (Optional)</h6>
        </div>

        <div class="card border-0 shadow-sm mb-20" style="border: 2px solid #ec3737 !important;">
            <div class="card-body p-20" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">
                <div class="d-flex gap-3">
                    <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px; background-color: #ec3737; border-radius: 50%;">
                        <i class="bi bi-question-circle text-white" style="font-size: 20px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="fw-bold mb-12" style="color: #4b5563; font-size: 15px;">Would you like to add initial stock now?</p>
                        <div class="form-check mb-10">
                            <input class="form-check-input" type="radio" name="add_stock_option" id="add_stock_yes" value="yes" style="width: 18px; height: 18px; border-color: #ec3737;" onclick="this.style.accentColor='#ec3737'">
                            <label class="form-check-label fw-medium ms-2 text-sm" for="add_stock_yes" style="color: #4b5563;">
                                Yes, add initial stock entry
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="add_stock_option" id="add_stock_no" value="no" checked style="width: 18px; height: 18px; border-color: #ec3737; accent-color: #ec3737;">
                            <label class="form-check-label fw-medium ms-2 text-sm" for="add_stock_no" style="color: #4b5563;">
                                Skip for now (I'll add stock later)
                            </label>
                        </div>
                        <small class="d-block mt-12 text-sm" style="color: #6b7280;">
                            <i class="bi bi-info-circle" style="color: #ec3737;"></i>
                            Note: You can always add stock later in Stock Management module with full tracking
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Entry Form (Hidden by default) -->
    <div id="stock_entry_form" style="display: none;">
        <!-- Stock Details -->
        <div class="mb-24">
            <div class="d-flex align-items-center gap-2 mb-16">
                <div class="d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #ec3737; border-radius: 6px;">
                    <i class="bi bi-calendar-check text-white" style="font-size: 14px;"></i>
                </div>
                <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 16px !important;">Stock Details</h6>
            </div>
            <div class="row">
                <!-- Date Received -->
                <div class="col-md-6 mb-20">
                    <label for="date_received" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Date Received <span class="text-danger-600">*</span>
                    </label>
                    <input type="date" class="form-control radius-8" id="date_received" name="stock_date" value="{{ date('Y-m-d') }}">
                </div>

                <!-- Quantity -->
                <div class="col-md-6 mb-20">
                    <label for="quantity_received" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Quantity Received <span class="text-danger-600">*</span>
                    </label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="quantity_received" name="stock_quantity" min="1" placeholder="0">
                        <span class="input-group-text" id="quantity_unit">pcs</span>
                    </div>
                    <small class="text-secondary-light d-block mt-4">
                        <i class="bi bi-info-circle"></i>
                        How many units did you receive?
                    </small>
                </div>
            </div>
        </div>

        <!-- Cost Information -->
        <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
            <div class="d-flex align-items-center gap-2 mb-16">
                <div class="d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #ec3737; border-radius: 6px;">
                    <i class="bi bi-currency-dollar text-white" style="font-size: 14px;"></i>
                </div>
                <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 16px !important;">Cost Information</h6>
            </div>
            <div class="row">
                <!-- Cost Per Unit -->
                <div class="col-12 mb-20">
                    <label for="cost_per_unit" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Cost Per Unit <span class="text-danger-600">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                        <input type="number" class="form-control" id="cost_per_unit" name="cost_per_unit" step="0.01" min="0" placeholder="0.00">
                    </div>
                    <small class="text-secondary-light d-block mt-4">
                        <i class="bi bi-info-circle"></i>
                        Your purchase cost per unit
                    </small>
                </div>

                <!-- Additional Costs (Collapsible) -->
                <div class="col-12 mb-20">
                    <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold d-flex align-items-center gap-2 text-sm" style="color: #ec3737;" data-bs-toggle="collapse" data-bs-target="#additional_costs_section">
                        <i class="bi bi-chevron-down" id="collapse_icon"></i>
                        Additional Costs (Optional)
                    </button>
                    
                    <div class="collapse mt-12" id="additional_costs_section">
                        <div class="border radius-8 p-16" style="background-color: #f9fafb;">
                            <div class="row">
                                <!-- Shipping Cost -->
                                <div class="col-md-4 mb-16">
                                    <label for="shipping_cost" class="form-label text-sm fw-semibold mb-8">Shipping/Freight Cost</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" step="0.01" min="0" placeholder="0.00" value="0">
                                    </div>
                                </div>

                                <!-- Import Duties -->
                                <div class="col-md-4 mb-16">
                                    <label for="import_duties" class="form-label text-sm fw-semibold mb-8">Import Duties/Taxes</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" class="form-control" id="import_duties" name="import_duties" step="0.01" min="0" placeholder="0.00" value="0">
                                    </div>
                                </div>

                                <!-- Other Costs -->
                                <div class="col-md-4 mb-16">
                                    <label for="other_costs" class="form-label text-sm fw-semibold mb-8">Other Costs</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" class="form-control" id="other_costs" name="other_costs" step="0.01" min="0" placeholder="0.00" value="0">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-8">
                                <small class="fw-semibold">Total Additional Costs: <span id="total_additional_costs">{{ auth()->user()->business->currency }} 0.00</span></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cost Breakdown -->
                <div class="col-12 mb-20">
                    <div class="border radius-8 p-16" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-color: #ec3737 !important; border-width: 2px !important;">
                        <div class="d-flex align-items-center gap-2 mb-12">
                            <div class="d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; background-color: #ec3737; border-radius: 4px;">
                                <i class="bi bi-calculator text-white" style="font-size: 12px;"></i>
                            </div>
                            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 14px !important;">Cost Breakdown</h6>
                        </div>
                        <div class="row text-sm">
                            <div class="col-6 mb-8">Quantity: <strong><span id="breakdown_quantity">0</span> <span id="breakdown_unit">pcs</span></strong></div>
                            <div class="col-6 mb-8">Cost/Unit: <strong>{{ auth()->user()->business->currency }} <span id="breakdown_cost_per_unit">0.00</span></strong></div>
                            <div class="col-6 mb-8">Subtotal: <strong>{{ auth()->user()->business->currency }} <span id="breakdown_subtotal">0.00</span></strong></div>
                            <div class="col-6 mb-8"></div>
                            <div class="col-6 mb-8">Shipping: <strong>{{ auth()->user()->business->currency }} <span id="breakdown_shipping">0.00</span></strong></div>
                            <div class="col-6 mb-8">Duties: <strong>{{ auth()->user()->business->currency }} <span id="breakdown_duties">0.00</span></strong></div>
                            <div class="col-12 mb-8">Other: <strong>{{ auth()->user()->business->currency }} <span id="breakdown_other">0.00</span></strong></div>
                            <div class="col-12"><hr class="my-8"></div>
                            <div class="col-6 fw-bold">Total Cost:</div>
                            <div class="col-6 fw-bold text-end text-primary" style="font-size: 16px;">{{ auth()->user()->business->currency }} <span id="breakdown_total_cost">0.00</span></div>
                            <div class="col-6 fw-bold">Actual Cost/Unit:</div>
                            <div class="col-6 fw-bold text-end text-success" style="font-size: 16px;">{{ auth()->user()->business->currency }} <span id="breakdown_actual_cost">0.00</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Reference -->
        <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
            <div class="d-flex align-items-center gap-2 mb-16">
                <div class="d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #ec3737; border-radius: 6px;">
                    <i class="bi bi-file-earmark-text text-white" style="font-size: 14px;"></i>
                </div>
                <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 16px !important;">Purchase Reference (Optional)</h6>
            </div>
            <div class="row">
                <!-- Supplier -->
                <div class="col-md-6 mb-20">
                    <label for="supplier" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Supplier
                    </label>
                    <input type="text" class="form-control radius-8" id="supplier" name="supplier" placeholder="Select or type supplier name">
                    <small class="text-secondary-light d-block mt-4">
                        <a href="#" class="text-primary">+ Add new supplier</a>
                    </small>
                </div>

                <!-- Reference Number -->
                <div class="col-md-6 mb-20">
                    <label for="reference_number" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Reference/PO Number
                    </label>
                    <input type="text" class="form-control radius-8" id="reference_number" name="reference_number" placeholder="e.g., PO-2025-001, INV-123456">
                    <small class="text-secondary-light d-block mt-4">
                        <i class="bi bi-info-circle"></i>
                        Invoice, PO, or reference number
                    </small>
                </div>

                <!-- Notes -->
                <div class="col-12 mb-20">
                    <label for="stock_notes" class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Notes
                    </label>
                    <textarea class="form-control radius-8" id="stock_notes" name="stock_notes" rows="2" placeholder="Any additional notes about this stock entry..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Skip Message (shown by default) -->
    <div id="skip_message" class="card shadow-sm" style="display: block; border: 2px solid #10b981 !important;">
        <div class="card-body p-20" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
            <div class="d-flex gap-3 align-items-start">
                <div class="d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px; background-color: #10b981; border-radius: 50%;">
                    <i class="bi bi-check-circle-fill text-white" style="font-size: 20px;"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-8" style="color: #065f46; font-size: 15px !important; font-weight: 700;">Stock entry will be skipped</h6>
                    <p class="mb-0" style="color: #047857; font-size: 14px;">
                        You can add stock later in the Stock Management module with complete cost tracking and supplier info.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Step Navigation -->
    <div class="d-flex justify-content-between gap-3 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2 btn-prev-step" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-prev-step="2">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </button>
        <button type="button" class="btn text-white radius-8 d-flex align-items-center gap-2 btn-next-step" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500;" data-next-step="4">
            <span>Next: Review</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</div>


