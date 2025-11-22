<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Stock Entry Details</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
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
                <li class="fw-medium">View Details</li>
            </ul>
        </div>

        <div class="row gy-4">
            <!-- Stock Entry Details Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-neutral-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-box-seam text-primary"></i>
                                <h6 class="card-title mb-0">Stock Entry Information</h6>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-sm btn-primary-600 hover-bg-primary-700 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                                    <i class="bi bi-pencil-square"></i>
                                    Edit
                                </a>
                                <form action="{{ route('stock.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock entry? This will reduce the product stock quantity.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger-600 hover-bg-danger-700 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                                        <i class="bi bi-trash3"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-4">
                            <!-- Product Information -->
                            <div class="col-12">
                                <div class="p-16 bg-primary-50 radius-8">
                                    <div class="d-flex align-items-center gap-2 mb-12">
                                        <i class="bi bi-box-seam text-primary-600"></i>
                                        <h6 class="text-primary-600 mb-0">Product Information</h6>
                                    </div>
                                    <div class="row gy-2">
                                        <div class="col-md-6">
                                            <span class="text-secondary-light text-sm">Product Name:</span>
                                            <p class="text-dark fw-semibold mb-0">{{ $stock->product->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-secondary-light text-sm">SKU:</span>
                                            <p class="text-dark fw-semibold mb-0">{{ $stock->product->sku ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-secondary-light text-sm">Current Stock:</span>
                                            <p class="text-dark fw-semibold mb-0">{{ $stock->product->stock_quantity }} {{ $stock->product->unit ?? 'pcs' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="text-secondary-light text-sm">Category:</span>
                                            <p class="text-dark fw-semibold mb-0">{{ $stock->product->category->name ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Entry Details -->
                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Date Received</label>
                                <p class="text-dark fw-semibold mb-0">{{ $stock->date->format('F d, Y') }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Reference Number</label>
                                <p class="text-dark fw-semibold mb-0">{{ $stock->reference_number ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="text-secondary-light text-sm">Quantity Received</label>
                                <p class="text-dark fw-semibold mb-0 text-success-600">
                                    <i class="bi bi-arrow-down-circle"></i>
                                    {{ $stock->quantity }} {{ $stock->product->unit ?? 'pcs' }}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Supplier</label>
                                <p class="text-dark fw-semibold mb-0">{{ $stock->supplier ?? 'N/A' }}</p>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Cost Per Unit</label>
                                <p class="text-dark fw-semibold mb-0">{{ auth()->user()->business->currency }} {{ number_format($stock->cost_per_unit, 2) }}</p>
                            </div>

                            @if($stock->shipping_cost > 0 || $stock->import_duties > 0 || $stock->other_transaction_costs > 0)
                            <!-- Additional Costs Section -->
                            <div class="col-12">
                                <div class="p-16 bg-white border radius-8">
                                    <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #212529;">Additional Costs</h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="text-secondary-light text-sm">Shipping/Freight</label>
                                            <p class="text-dark fw-semibold mb-0">{{ auth()->user()->business->currency }} {{ number_format($stock->shipping_cost ?? 0, 2) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-secondary-light text-sm">Import Duties/Taxes</label>
                                            <p class="text-dark fw-semibold mb-0">{{ auth()->user()->business->currency }} {{ number_format($stock->import_duties ?? 0, 2) }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="text-secondary-light text-sm">Other Costs</label>
                                            <p class="text-dark fw-semibold mb-0">{{ auth()->user()->business->currency }} {{ number_format($stock->other_transaction_costs ?? 0, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12">
                                <label class="text-secondary-light text-sm">Total Cost</label>
                                <p class="text-dark fw-bold mb-0 text-primary-600" style="font-size: 20px;">{{ auth()->user()->business->currency }} {{ number_format($stock->total_cost, 2) }}</p>
                                @if($stock->shipping_cost > 0 || $stock->import_duties > 0 || $stock->other_transaction_costs > 0)
                                <small class="text-secondary-light">Includes {{ auth()->user()->business->currency }} {{ number_format(($stock->shipping_cost ?? 0) + ($stock->import_duties ?? 0) + ($stock->other_transaction_costs ?? 0), 2) }} in additional costs</small>
                                @endif
                            </div>

                            @if($stock->notes)
                            <div class="col-12">
                                <label class="text-secondary-light text-sm">Notes</label>
                                <div class="p-16 bg-neutral-50 radius-8">
                                    <p class="text-dark mb-0">{{ $stock->notes }}</p>
                                </div>
                            </div>
                            @endif

                            <!-- Timestamps -->
                            <div class="col-12">
                                <hr class="my-2">
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Created At</label>
                                <p class="text-dark mb-0">{{ $stock->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary-light text-sm">Last Updated</label>
                                <p class="text-dark mb-0">{{ $stock->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card mb-24">
                    <div class="card-header bg-neutral-50">
                        <h6 class="card-title mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <a href="{{ route('stock.edit', $stock->id) }}" class="btn btn-primary-600 hover-bg-primary-700 radius-8 px-20 py-11 d-flex align-items-center gap-2 w-100">
                                <i class="bi bi-pencil-square"></i>
                                Edit Stock Entry
                            </a>
                            <a href="{{ route('products.show', $stock->product->id) }}" class="btn btn-info-600 hover-bg-info-700 radius-8 px-20 py-11 d-flex align-items-center gap-2 w-100">
                                <i class="bi bi-eye"></i>
                                View Product
                            </a>
                            <a href="{{ route('stock.create') }}" class="btn btn-success-600 hover-bg-success-700 radius-8 px-20 py-11 d-flex align-items-center gap-2 w-100">
                                <i class="bi bi-plus-circle"></i>
                                Add New Stock
                            </a>
                            <a href="{{ route('stock.index') }}" class="btn btn-neutral-600 hover-bg-neutral-700 radius-8 px-20 py-11 d-flex align-items-center gap-2 w-100">
                                <i class="bi bi-arrow-left"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stock Summary -->
                <div class="card">
                    <div class="card-header bg-neutral-50">
                        <h6 class="card-title mb-0">Stock Impact</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column gap-3">
                            <div class="p-12 bg-success-50 radius-8">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-secondary-light text-sm">Quantity Added</span>
                                    <span class="text-success-600 fw-bold">+{{ $stock->quantity }}</span>
                                </div>
                            </div>
                            <div class="p-12 bg-warning-50 radius-8">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-secondary-light text-sm">Value Added</span>
                                    <span class="text-warning-600 fw-bold">{{ auth()->user()->business->currency }} {{ number_format($stock->total_cost, 2) }}</span>
                                </div>
                            </div>
                            <div class="p-12 bg-primary-50 radius-8">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-secondary-light text-sm">Current Stock</span>
                                    <span class="text-primary-600 fw-bold">{{ $stock->product->stock_quantity }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-script/>

</x-layout.master>

