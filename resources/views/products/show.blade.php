<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Product Details</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
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
                <li class="fw-medium">{{ $product->name }}</li>
            </ul>
        </div>

        <div class="row gy-4">
            <!-- Product Information -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h6 class="card-title mb-0">Product Information</h6>
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary-600 radius-8 px-12 py-8">
                                    <i class="bi bi-pencil"></i>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Product Name</label>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">SKU</label>
                                    <h6 class="mb-0">{{ $product->sku ?? 'N/A' }}</h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Category</label>
                                    <h6 class="mb-0">
                                        @if($product->category)
                                            <span class="badge text-sm fw-semibold text-primary-600 bg-primary-100 px-20 py-9 radius-4">
                                                {{ $product->category->name }}
                                            </span>
                                        @else
                                            <span class="text-secondary-light">No Category</span>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Type</label>
                                    <h6 class="mb-0 text-capitalize">{{ $product->type ?? 'product' }}</h6>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Selling Price</label>
                                    <h6 class="mb-0 text-success-600">{{ auth()->user()->business->currency }} {{ number_format($product->price, 2) }}</h6>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Cost Price</label>
                                    <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($product->cost, 2) }}</h6>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Profit Margin</label>
                                    <h6 class="mb-0 text-primary-600">
                                        {{ $product->cost > 0 ? number_format((($product->price - $product->cost) / $product->cost) * 100, 2) : 0 }}%
                                    </h6>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Description</label>
                                    <p class="mb-0">{{ $product->description ?? 'No description provided' }}</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Status</label>
                                    <div>
                                        @if($product->is_active)
                                            <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">Active</span>
                                        @else
                                            <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Summary -->
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Inventory Summary</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-24">
                            <div class="w-80-px h-80-px bg-primary-50 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-16">
                                <i class="bi bi-box-seam text-primary-600" style="font-size: 2rem;"></i>
                            </div>
                            <h3 class="mb-0 fw-bold">{{ $product->stock_quantity }}</h3>
                            <p class="text-secondary-light mb-0">Units in Stock</p>
                        </div>
                        
                        <div class="border-top pt-20">
                            <div class="d-flex justify-content-between align-items-center mb-16">
                                <span class="text-secondary-light">Min Stock Alert</span>
                                <span class="fw-semibold">{{ $product->min_stock_alert }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-16">
                                <span class="text-secondary-light">Stock Status</span>
                                @if($product->stock_quantity <= $product->min_stock_alert)
                                    <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">
                                        Low Stock
                                    </span>
                                @elseif($product->stock_quantity == 0)
                                    <span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">
                                        Out of Stock
                                    </span>
                                @else
                                    <span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">
                                        In Stock
                                    </span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-secondary-light">Stock Value</span>
                                <span class="fw-semibold text-primary-600">
                                    {{ auth()->user()->business->currency }} {{ number_format($product->cost * $product->stock_quantity, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Record Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Created At</label>
                                    <h6 class="mb-0">{{ $product->created_at->format('M d, Y h:i A') }}</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">Last Updated</label>
                                    <h6 class="mb-0">{{ $product->updated_at->format('M d, Y h:i A') }}</h6>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-sm text-secondary-light mb-1">ID</label>
                                    <h6 class="mb-0">#{{ $product->id }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-24">
            <a href="{{ route('products.index') }}" class="btn btn-neutral-500 radius-8 px-20 py-11">
                <i class="bi bi-arrow-left"></i>
                Back to Products
            </a>
        </div>
    </div>

</x-layout.master>

