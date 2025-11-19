{{-- Step 2: Pricing & Settings --}}
<div class="wizard-step" id="step2" data-step="2" style="display: none;">
    <!-- Step Header -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-currency-dollar text-white"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Selling Information</h6>
        </div>

        <div class="row">
            <!-- Selling Price -->
            <div class="col-md-6 mb-20">
                <label for="selling_price" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Selling Price <span class="text-danger-600">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text fw-bold text-white" style="background-color: #ec3737;">{{ auth()->user()->business->currency }}</span>
                    <input type="number" class="form-control" id="selling_price" name="price" step="0.01" min="0" placeholder="0.00" required style="border-color: #ec3737;">
                </div>
                <small class="text-secondary-light d-block mt-4">
                    <i class="bi bi-info-circle"></i>
                    The price customers will pay
                </small>
            </div>

            <!-- Tax Amount -->
            <div class="col-md-6 mb-20">
                <label for="tax_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Tax Amount
                </label>
                <div class="input-group">
                    <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                    <input type="number" class="form-control" id="tax_amount" name="tax_amount" step="0.01" min="0" placeholder="0.00">
                </div>
                <small class="text-secondary-light d-block mt-4">
                    <i class="bi bi-info-circle"></i>
                    Tax per unit (if applicable)
                </small>
            </div>
        </div>
    </div>

    <!-- Product Settings -->
    <div class="mb-24 pt-24" style="border-top: 1px solid #e5e7eb;">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-gear text-white"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Product Settings</h6>
        </div>

        <div class="row">
            <!-- Unit of Measurement -->
            <div class="col-md-6 mb-20">
                <label for="unit_of_measurement" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Unit of Measurement <span class="text-danger-600">*</span>
                </label>
                <select class="form-select radius-8" id="unit_of_measurement" name="unit" required>
                    <option value="">Select Unit</option>
                    @forelse($units as $unit)
                        <option value="{{ $unit->setting_value }}" {{ $unit->setting_value == 'pcs' ? 'selected' : '' }}>
                            {{ $unit->setting_label }} ({{ $unit->setting_value }})
                        </option>
                    @empty
                        <option value="pcs" selected>Pieces (pcs)</option>
                        <option value="kg">Kilogram (kg)</option>
                        <option value="ltr">Liter (ltr)</option>
                    @endforelse
                </select>
                <small class="text-secondary-light d-block mt-4">
                    Options: pcs, kg, lbs, ltr, gal, m, box, pack
                </small>
            </div>

            <!-- Minimum Stock Alert -->
            <div class="col-md-6 mb-20">
                <label for="min_stock_alert" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Minimum Stock Alert Level
                </label>
                <input type="number" class="form-control radius-8" id="min_stock_alert" name="min_stock_alert" min="0" placeholder="10" value="10">
                <small class="text-secondary-light d-block mt-4">
                    <i class="bi bi-bell"></i>
                    Get notified when stock falls below this level
                </small>
            </div>

            <!-- Product Status -->
            <div class="col-12 mb-20">
                <label class="form-label fw-semibold text-primary-light text-sm mb-12">
                    Product Status
                </label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="product_status" checked style="width: 48px; height: 24px;">
                    <label class="form-check-label fw-medium ms-2" for="product_status">
                        <span id="status_label">Active</span>
                    </label>
                </div>
                <small class="text-secondary-light d-block mt-4">
                    <i class="bi bi-info-circle"></i>
                    Inactive products won't appear in POS/Sales
                </small>
            </div>
        </div>
    </div>

    <!-- Step Navigation -->
    <div class="d-flex justify-content-between gap-3 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2 btn-prev-step" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-prev-step="1">
            <i class="bi bi-arrow-left"></i>
            <span>Back</span>
        </button>
        <button type="button" class="btn text-white radius-8 d-flex align-items-center gap-2 btn-next-step" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500;" data-next-step="3">
            <span>Next: Stock</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</div>


