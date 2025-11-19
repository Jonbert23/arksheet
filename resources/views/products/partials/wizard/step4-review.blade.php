{{-- Step 4: Review & Confirmation --}}
<div class="wizard-step" id="step4" data-step="4" style="display: none;">
    <!-- Step Header -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-check-circle text-white"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Review & Confirmation</h6>
        </div>
        <p class="text-secondary-light text-sm mb-0">Please review your product details before saving</p>
    </div>

    <!-- Product Information Summary -->
    <div class="mb-20">
        <div class="border radius-8 overflow-hidden">
            <div class="d-flex justify-content-between align-items-center p-16 border-bottom" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2" style="color: #4b5563; font-size: 15px !important;">
                    <i class="bi bi-box-seam" style="color: #ec3737;"></i>
                    Product Information
                </h6>
                <button type="button" class="btn btn-sm radius-8 btn-edit-step" data-edit-step="1" style="border: 1px solid #ec3737; color: #ec3737; padding: 6px 12px; font-size: 13px;" onmouseover="this.style.backgroundColor='#ec3737'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ec3737'">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="p-16">
                <div class="row text-sm">
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Name:</span>
                        <strong class="d-block" id="review_name">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">SKU:</span>
                        <strong class="d-block" id="review_sku">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Category:</span>
                        <strong class="d-block" id="review_category">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Type:</span>
                        <strong class="d-block" id="review_type">-</strong>
                    </div>
                    <div class="col-12">
                        <span class="text-secondary-light">Description:</span>
                        <p class="mb-0 mt-4" id="review_description">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pricing & Settings Summary -->
    <div class="mb-20">
        <div class="border radius-8 overflow-hidden">
            <div class="d-flex justify-content-between align-items-center p-16 border-bottom" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2" style="color: #4b5563; font-size: 15px !important;">
                    <i class="bi bi-currency-dollar" style="color: #ec3737;"></i>
                    Pricing & Settings
                </h6>
                <button type="button" class="btn btn-sm radius-8 btn-edit-step" data-edit-step="2" style="border: 1px solid #ec3737; color: #ec3737; padding: 6px 12px; font-size: 13px;" onmouseover="this.style.backgroundColor='#ec3737'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ec3737'">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="p-16">
                <div class="row text-sm">
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Selling Price:</span>
                        <strong class="d-block" style="color: #ec3737;" id="review_price">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Tax Amount:</span>
                        <strong class="d-block" id="review_tax">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Unit:</span>
                        <strong class="d-block" id="review_unit">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Min Stock Alert:</span>
                        <strong class="d-block" id="review_min_stock">-</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary-light">Status:</span>
                        <strong class="d-block" id="review_status">-</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Entry Summary -->
    <div class="mb-20">
        <div class="border radius-8 overflow-hidden">
            <div class="d-flex justify-content-between align-items-center p-16 border-bottom" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                <h6 class="mb-0 fw-semibold d-flex align-items-center gap-2" style="color: #4b5563; font-size: 15px !important;">
                    <i class="bi bi-box" style="color: #ec3737;"></i>
                    Initial Stock Entry
                </h6>
                <button type="button" class="btn btn-sm radius-8 btn-edit-step" data-edit-step="3" style="border: 1px solid #ec3737; color: #ec3737; padding: 6px 12px; font-size: 13px;" onmouseover="this.style.backgroundColor='#ec3737'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ec3737'">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="p-16">
                <!-- Show if stock added -->
                <div id="review_stock_added" style="display: none;">
                    <div class="row text-sm">
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Date Received:</span>
                            <strong class="d-block" id="review_stock_date">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Quantity:</span>
                            <strong class="d-block" id="review_stock_quantity">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Cost Per Unit:</span>
                            <strong class="d-block" id="review_stock_cost">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Additional Costs:</span>
                            <strong class="d-block" id="review_stock_additional">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Total Cost:</span>
                            <strong class="d-block" style="color: #ec3737;" id="review_stock_total">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Actual Cost/Unit:</span>
                            <strong class="d-block" style="color: #ec3737;" id="review_stock_actual_cost">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Supplier:</span>
                            <strong class="d-block" id="review_stock_supplier">-</strong>
                        </div>
                        <div class="col-6 mb-12">
                            <span class="text-secondary-light">Reference:</span>
                            <strong class="d-block" id="review_stock_reference">-</strong>
                        </div>
                    </div>
                </div>

                <!-- Show if stock skipped -->
                <div id="review_stock_skipped">
                    <div class="d-flex gap-3 align-items-center text-secondary-light">
                        <i class="bi bi-x-circle" style="font-size: 24px;"></i>
                        <div>
                            <p class="fw-semibold mb-4">Stock entry was skipped</p>
                            <small>You can add stock later in Stock Management module</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profit Analysis (if stock added) -->
    <div class="mb-20" id="profit_analysis" style="display: none;">
        <div class="border radius-8 overflow-hidden" style="border-color: #ec3737 !important; border-width: 2px !important;">
            <div class="p-16" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; background-color: #ec3737; border-radius: 6px;">
                        <i class="bi bi-graph-up text-white" style="font-size: 14px;"></i>
                    </div>
                    <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 16px !important;">Profit Analysis</h6>
                </div>
            </div>
            <div class="p-16 bg-white">
                <div class="row text-sm">
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Selling Price:</span>
                        <strong class="d-block" style="color: #10b981;" id="profit_selling_price">-</strong>
                    </div>
                    <div class="col-6 mb-12">
                        <span class="text-secondary-light">Unit Cost:</span>
                        <strong class="d-block" style="color: #ec3737;" id="profit_unit_cost">-</strong>
                    </div>
                    <div class="col-12"><hr class="my-12"></div>
                    <div class="col-6">
                        <span class="text-secondary-light">Profit/Unit:</span>
                        <strong class="d-block" style="font-size: 18px; color: #10b981;" id="profit_per_unit">-</strong>
                    </div>
                    <div class="col-6">
                        <span class="text-secondary-light">Profit Margin:</span>
                        <strong class="d-block" style="font-size: 18px; color: #4b5563;" id="profit_margin">
                            <span id="profit_margin_value">0</span>%
                            <i class="bi bi-check-circle" style="color: #10b981; display: none;" id="profit_icon"></i>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step Navigation -->
    <div class="d-flex justify-content-between gap-3 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2 btn-prev-step" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-prev-step="3">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </button>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" id="btn_save_draft">
                <i class="bi bi-bookmark"></i>
                <span>Save as Draft</span>
            </button>
            <button type="submit" class="btn text-white radius-8 d-flex align-items-center gap-2" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500;" id="btn_create_product">
                <i class="bi bi-check-circle"></i>
                <span>Create Product</span>
            </button>
        </div>
    </div>
</div>


