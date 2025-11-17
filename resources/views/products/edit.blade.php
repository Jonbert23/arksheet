<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Product: {{ $product->name }}</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('products.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Products
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Product</li>
            </ul>
        </div>

        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Hidden Fields -->
            <input type="hidden" name="is_active" value="{{ old('is_active', $product->is_active) }}">
            <input type="hidden" name="additional_info" value="{{ old('additional_info', $product->additional_info) }}">
            
            <div class="row gy-4">
                <!-- Configuration Alerts -->
                @if($categories->isEmpty() || $productTypes->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning-100 border-start border-warning-600 border-3 radius-8 px-24 py-20" role="alert">
                        <div class="d-flex align-items-start gap-3">
                            <div class="d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f59e0b; border-radius: 12px;">
                                <iconify-icon icon="mdi:alert-circle-outline" class="text-white" style="font-size: 28px;"></iconify-icon>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-12 fw-bold text-warning-600" style="font-size: 16px;">
                                    <iconify-icon icon="mdi:cog-outline" class="me-1"></iconify-icon>
                                    Configuration Required
                                </h6>
                                <div class="text-sm text-secondary-light mb-12">
                                    @if($categories->isEmpty() && $productTypes->isEmpty())
                                        <p class="mb-8">⚠️ <strong>No Product Categories or Product Types configured.</strong></p>
                                        <p class="mb-0">Please set up your product categories and types in Business Settings for better product organization.</p>
                                    @elseif($categories->isEmpty())
                                        <p class="mb-8">⚠️ <strong>No Product Categories configured.</strong></p>
                                        <p class="mb-0">Please add product categories in Business Settings to better organize your products.</p>
                                    @elseif($productTypes->isEmpty())
                                        <p class="mb-8">⚠️ <strong>No Product Types configured.</strong></p>
                                        <p class="mb-0">Please add product types in Business Settings to specify whether products are physical, digital, or services.</p>
                                    @endif
                                </div>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('settings.config.index') }}" class="btn btn-warning-600 text-white radius-8 px-20 py-10 d-inline-flex align-items-center gap-2 hover-bg-warning-700 fw-semibold">
                                    <iconify-icon icon="mdi:cog" class="text-lg"></iconify-icon>
                                    Go to Business Settings
                                    <iconify-icon icon="mdi:arrow-right" class="text-lg"></iconify-icon>
                                </a>
                                @else
                                <div class="alert alert-info-100 border-info-600 px-16 py-12 radius-8 mt-12">
                                    <iconify-icon icon="mdi:information-outline" class="me-2"></iconify-icon>
                                    <small>Please contact your administrator to configure product settings.</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($units->isEmpty())
                <div class="col-12">
                    <div class="alert alert-info-100 border-start border-info-600 border-3 radius-8 px-24 py-16" role="alert">
                        <div class="d-flex align-items-center gap-3">
                            <iconify-icon icon="mdi:information-outline" class="text-info-600" style="font-size: 24px;"></iconify-icon>
                            <div class="flex-grow-1">
                                <p class="mb-0 text-sm text-secondary-light">
                                    <strong class="text-info-600">Info:</strong> No units of measurement configured. Default units will be available, or 
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('settings.config.index') }}" class="text-info-600 fw-semibold text-decoration-underline">add custom units</a>.
                                    @else
                                        contact your administrator to add custom units.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Quick Tips Card (Full Width) -->
                <div class="col-12">
                    <div class="card bg-primary-50 border border-primary-600">
                        <div class="card-body">
                            <div class="d-flex align-items-start gap-2">
                                <iconify-icon icon="mdi:lightbulb-on-outline" class="text-primary-600 text-xl"></iconify-icon>
                                <div>
                                    <h6 class="text-primary-600 mb-8">Quick Tips</h6>
                                    <ul class="text-sm text-secondary-light mb-0 ps-16">
                                        <li class="mb-8">Fill in accurate cost prices for profit tracking</li>
                                        <li class="mb-8">Set min stock alerts to prevent stockouts</li>
                                        <li class="mb-8">Use descriptive SKUs for easy identification</li>
                                        <li>Keep descriptions clear and detailed</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Left Column -->
                <div class="col-lg-12">
                    <!-- Basic Information Card -->
                    <div class="card mb-24">
                        <div class="card-header bg-neutral-50">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:information-outline" class="text-primary-600 text-xl"></iconify-icon>
                                <h6 class="card-title mb-0">Basic Information</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <!-- Product Name -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- SKU -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror" placeholder="Auto-generated if left empty" value="{{ old('sku', $product->sku) }}">
                                    @error('sku')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="product_category_id" class="form-select @error('product_category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Product Type <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select Product Type</option>
                                        @forelse($productTypes as $type)
                                            <option value="{{ $type->setting_value }}" {{ old('type', $product->type) == $type->setting_value ? 'selected' : '' }}>
                                                {{ $type->setting_label }}
                                            </option>
                                        @empty
                                            <option value="physical" {{ old('type', $product->type) == 'physical' ? 'selected' : '' }}>Physical Product</option>
                                            <option value="digital" {{ old('type', $product->type) == 'digital' ? 'selected' : '' }}>Digital Product</option>
                                            <option value="service" {{ old('type', $product->type) == 'service' ? 'selected' : '' }}>Service</option>
                                        @endforelse
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description</label>
                                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Describe your product or service">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Costs Card -->
                    <div class="card mb-24">
                        <div class="card-header bg-neutral-50">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:currency-usd" class="text-success-600 text-xl"></iconify-icon>
                                <h6 class="card-title mb-0">Pricing & Costs</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <!-- Selling Price -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Selling Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary-50 text-primary-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" placeholder="0.00" value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Cost Price -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Cost Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-warning-50 text-warning-600 fw-semibold">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" name="cost" step="0.01" class="form-control @error('cost') is-invalid @enderror" placeholder="0.00" value="{{ old('cost', $product->cost) }}">
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tax Amount -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tax Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" name="tax_amount" step="0.01" class="form-control @error('tax_amount') is-invalid @enderror" placeholder="0.00" value="{{ old('tax_amount', $product->tax_amount) }}">
                                        @error('tax_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Other Costs -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Other Costs</label>
                                    <div class="input-group">
                                        <span class="input-group-text">{{ auth()->user()->business->currency }}</span>
                                        <input type="number" name="other_costs" step="0.01" class="form-control @error('other_costs') is-invalid @enderror" placeholder="0.00" value="{{ old('other_costs', $product->other_costs) }}">
                                        @error('other_costs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <small class="text-secondary-light">
                                        <iconify-icon icon="mdi:information-outline" class="text-xs"></iconify-icon>
                                        Packaging, shipping, handling, etc.
                                    </small>
                                </div>

                                <!-- Profit Preview -->
                                <div class="col-12">
                                    <div class="alert alert-info-100 border border-info-600 text-info-600 radius-8 px-20 py-12">
                                        <div class="d-flex align-items-center gap-2">
                                            <iconify-icon icon="mdi:calculator" class="text-xl"></iconify-icon>
                                            <div>
                                                <strong>Profit Calculation:</strong>
                                                <span class="ms-2">Estimated Profit = Selling Price - (Cost + Tax + Other Costs)</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Management Card -->
                    <div class="card">
                        <div class="card-header bg-neutral-50">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:warehouse" class="text-warning-600 text-xl"></iconify-icon>
                                <h6 class="card-title mb-0">Inventory Management</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row gy-3">
                                <!-- Stock Quantity -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" class="form-control @error('stock_quantity') is-invalid @enderror" placeholder="0" value="{{ old('stock_quantity', $product->stock_quantity) }}">
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Min Stock Alert -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Min. Stock Alert Level</label>
                                    <input type="number" name="min_stock_alert" class="form-control @error('min_stock_alert') is-invalid @enderror" placeholder="10" value="{{ old('min_stock_alert', $product->min_stock_alert) }}">
                                    @error('min_stock_alert')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-secondary-light">
                                        <iconify-icon icon="mdi:alert-circle-outline" class="text-xs"></iconify-icon>
                                        Alert when stock falls below this level
                                    </small>
                                </div>

                                <!-- Unit -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Unit of Measurement</label>
                                    <select name="unit" class="form-select @error('unit') is-invalid @enderror">
                                        <option value="">Select Unit</option>
                                        @forelse($units as $unit)
                                            <option value="{{ $unit->setting_value }}" {{ old('unit', $product->unit) == $unit->setting_value ? 'selected' : '' }}>
                                                {{ $unit->setting_label }} ({{ $unit->setting_value }})
                                            </option>
                                        @empty
                                            <option value="pcs" {{ old('unit', $product->unit) == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                            <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                            <option value="ltr" {{ old('unit', $product->unit) == 'ltr' ? 'selected' : '' }}>Liter (ltr)</option>
                                        @endforelse
                                    </select>
                                    @error('unit')
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
                                    <a href="{{ route('products.index') }}" class="btn bg-neutral-200 text-neutral-900 hover-bg-neutral-300 radius-8 px-32 py-14 d-flex align-items-center gap-2 fw-semibold">
                                        <iconify-icon icon="mdi:arrow-left" class="text-xl"></iconify-icon>
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary-600 hover-bg-primary-700 radius-8 px-32 py-14 d-flex align-items-center gap-2 fw-semibold shadow-sm">
                                        <iconify-icon icon="mdi:check-circle" class="text-xl"></iconify-icon>
                                        Update Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* Alert styling enhancements */
        .alert-warning-100 {
            background-color: #fffbeb;
        }
        
        .alert-info-100 {
            background-color: #eff6ff;
        }

        .hover-bg-warning-700:hover {
            background-color: #d97706 !important;
        }

        .btn-warning-600 {
            background-color: #f59e0b;
            transition: all 0.3s ease;
        }

        .border-warning-600 {
            border-color: #f59e0b !important;
        }

        .text-warning-600 {
            color: #f59e0b !important;
        }

        .border-info-600 {
            border-color: #3b82f6 !important;
        }

        .text-info-600 {
            color: #3b82f6 !important;
        }
    </style>

</x-layout.master>
