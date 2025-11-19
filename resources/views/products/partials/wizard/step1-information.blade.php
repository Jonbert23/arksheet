{{-- Step 1: Product Information --}}
<div class="wizard-step" id="step1" data-step="1">
    <!-- Step Header -->
    <div class="mb-24">
        <div class="d-flex align-items-center gap-2 mb-16">
            <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #ec3737; border-radius: 8px;">
                <i class="bi bi-box-seam text-white"></i>
            </div>
            <h6 class="mb-0 fw-bold" style="color: #4b5563; font-size: 18px !important;">Product Details</h6>
        </div>

        <div class="row">
            <!-- Product Name -->
            <div class="col-12 mb-20">
                <label for="product_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Product Name <span class="text-danger-600">*</span>
                </label>
                <input type="text" class="form-control radius-8" id="product_name" name="name" placeholder="e.g., Wireless Mouse" required>
            </div>

            <!-- SKU -->
            <div class="col-12 mb-20">
                <label for="product_sku" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    SKU (Stock Keeping Unit)
                </label>
                <input type="text" class="form-control radius-8" id="product_sku" name="sku" placeholder="Leave blank to auto-generate" value="SKU-{{ strtoupper(uniqid()) }}">
                <div class="form-check mt-8">
                    <input class="form-check-input" type="checkbox" id="auto_generate_sku" checked>
                    <label class="form-check-label text-sm text-secondary-light" for="auto_generate_sku">
                        Auto-generate SKU
                    </label>
                </div>
            </div>

            <!-- Category -->
            <div class="col-md-6 mb-20">
                <label for="product_category" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Product Category <span class="text-danger-600">*</span>
                </label>
                <select class="form-select radius-8" id="product_category" name="product_category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @if($categories->isEmpty())
                    <small class="text-warning-600 d-block mt-4">
                        <i class="bi bi-exclamation-triangle"></i>
                        No categories available. <a href="{{ route('settings.config.index') }}" target="_blank" class="text-warning-600 fw-semibold">Add categories</a>
                    </small>
                @endif
            </div>

            <!-- Product Type -->
            <div class="col-md-6 mb-20">
                <label for="product_type" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Product Type <span class="text-danger-600">*</span>
                </label>
                <select class="form-select radius-8" id="product_type" name="type" required>
                    <option value="">Select Product Type</option>
                    @forelse($productTypes as $type)
                        <option value="{{ $type->setting_value }}">{{ $type->setting_label }}</option>
                    @empty
                        <option value="product">Physical Product</option>
                        <option value="digital">Digital Product</option>
                        <option value="service">Service</option>
                    @endforelse
                </select>
                @if($productTypes->isEmpty())
                    <small class="text-warning-600 d-block mt-4">
                        <i class="bi bi-exclamation-triangle"></i>
                        No product types configured. <a href="{{ route('settings.config.index') }}" target="_blank" class="text-warning-600 fw-semibold">Add types</a>
                    </small>
                @endif
            </div>

            <!-- Description -->
            <div class="col-12 mb-20">
                <label for="product_description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                    Description
                </label>
                <textarea class="form-control radius-8" id="product_description" name="description" rows="3" placeholder="Describe your product features, specifications, etc."></textarea>
            </div>
        </div>
    </div>

    <!-- Step Navigation -->
    <div class="d-flex justify-content-end gap-3 pt-24" style="border-top: 1px solid #e5e7eb;">
        <button type="button" class="btn btn-outline-secondary radius-8 d-flex align-items-center gap-2" style="padding: 11px 24px; font-size: 14px; font-weight: 500;" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i>
            <span>Cancel</span>
        </button>
        <button type="button" class="btn text-white radius-8 d-flex align-items-center gap-2 btn-next-step" style="background-color: #ec3737; padding: 11px 24px; font-size: 14px; font-weight: 500;" data-next-step="2">
            <span>Next: Pricing</span>
            <i class="bi bi-arrow-right"></i>
        </button>
    </div>
</div>

