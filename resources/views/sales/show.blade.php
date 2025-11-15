<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Sale Details</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
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
                <li class="fw-medium">{{ $sale->invoice_number }}</li>
            </ul>
        </div>

        <div class="row gy-4">
            <!-- Sale Information Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0" style="font-size: 18px !important; color: #4b5563;">Invoice: {{ $sale->invoice_number }}</h6>
                        <div class="d-flex gap-2">
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-success-600">
                                <iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon>
                                Edit
                            </a>
                            <button onclick="window.print()" class="btn btn-sm btn-primary-600">
                                <iconify-icon icon="mdi:printer" class="text-lg"></iconify-icon>
                                Print
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-24">
                        <!-- Sale Items Table -->
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered">
                                <thead class="bg-neutral-50">
                                    <tr>
                                        <th style="width: 40%;">Product</th>
                                        <th class="text-center" style="width: 15%;">Quantity</th>
                                        <th class="text-end" style="width: 15%;">Unit Price</th>
                                        <th class="text-end" style="width: 15%;">Tax</th>
                                        <th class="text-end" style="width: 15%;">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale->saleItems as $item)
                                    <tr>
                                        <td>
                                            <div>
                                                <span class="fw-semibold text-dark d-block">{{ $item->product->name }}</span>
                                                <small class="text-secondary-light">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-medium">{{ $item->quantity }} {{ $item->product->unit ?? 'pcs' }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span>{{ auth()->user()->business->currency }} {{ number_format($item->unit_price, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span>{{ auth()->user()->business->currency }} {{ number_format($item->tax_amount, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <span class="fw-semibold text-primary-600">{{ auth()->user()->business->currency }} {{ number_format($item->total, 2) }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-neutral-50">
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                                        <td class="text-end fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($sale->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">Total Tax:</td>
                                        <td class="text-end fw-semibold">{{ auth()->user()->business->currency }} {{ number_format($sale->tax, 2) }}</td>
                                    </tr>
                                    @if($sale->discount > 0)
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold text-danger-600">Discount:</td>
                                        <td class="text-end fw-semibold text-danger-600">- {{ auth()->user()->business->currency }} {{ number_format($sale->discount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr class="text-primary-600">
                                        <td colspan="4" class="text-end fw-bold" style="font-size: 18px;">Grand Total:</td>
                                        <td class="text-end fw-bold" style="font-size: 18px;">{{ auth()->user()->business->currency }} {{ number_format($sale->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if($sale->notes)
                        <div class="alert alert-info">
                            <strong>Notes:</strong>
                            <p class="mb-0 mt-2">{{ $sale->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sale Summary Card -->
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header border-bottom">
                        <h6 class="card-title mb-0" style="font-size: 18px !important; color: #4b5563;">Sale Information</h6>
                    </div>
                    <div class="card-body p-24">
                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Sale Date</span>
                            <span class="fw-semibold text-dark">{{ $sale->date->format('F d, Y') }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Customer</span>
                            @if($sale->customer)
                                <a href="{{ route('customers.show', $sale->customer->id) }}" class="fw-semibold text-primary-600">
                                    {{ $sale->customer->name }}
                                </a>
                            @else
                                <span class="fw-semibold text-dark">Walk-in Customer</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Sales Channel</span>
                            <span class="fw-semibold text-dark">{{ $sale->salesChannel->name ?? 'N/A' }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Payment Status</span>
                            @if($sale->payment_status === 'paid')
                                <span class="badge bg-success-100 text-success-600 px-12 py-6">Paid</span>
                            @elseif($sale->payment_status === 'partial')
                                <span class="badge bg-warning-100 text-warning-600 px-12 py-6">Partial</span>
                            @else
                                <span class="badge bg-danger-100 text-danger-600 px-12 py-6">Pending</span>
                            @endif
                        </div>

                        @if($sale->payment_method)
                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Payment Method</span>
                            <span class="badge bg-neutral-100 text-neutral-600 px-12 py-6">{{ ucfirst(str_replace('_', ' ', $sale->payment_method)) }}</span>
                        </div>
                        @endif

                        <div class="mb-3">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Total Items</span>
                            <span class="fw-semibold text-dark">{{ $sale->saleItems->sum('quantity') }}</span>
                        </div>

                        <div class="mb-0">
                            <span class="text-secondary-light d-block mb-1" style="font-size: 13px;">Created At</span>
                            <span class="fw-semibold text-dark">{{ $sale->created_at->format('M d, Y H:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card">
                    <div class="card-header border-bottom">
                        <h6 class="card-title mb-0" style="font-size: 18px !important; color: #4b5563;">Quick Actions</h6>
                    </div>
                    <div class="card-body p-24">
                        <div class="d-grid gap-2">
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-success-600 w-100">
                                <iconify-icon icon="lucide:edit" class="text-lg me-1"></iconify-icon>
                                Edit Sale
                            </a>
                            <button onclick="window.print()" class="btn btn-primary-600 w-100">
                                <iconify-icon icon="mdi:printer" class="text-lg me-1"></iconify-icon>
                                Print Invoice
                            </button>
                            <a href="{{ route('sales.index') }}" class="btn btn-neutral-600 w-100">
                                <iconify-icon icon="mdi:arrow-left" class="text-lg me-1"></iconify-icon>
                                Back to Sales
                            </a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sale? Stock will be restored.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-600 w-100">
                                    <iconify-icon icon="mingcute:delete-2-line" class="text-lg me-1"></iconify-icon>
                                    Delete Sale
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-script/>

    <style>
        @media print {
            .sidebar, .navbar, .card-header button, .breadcrumb, .quick-actions {
                display: none !important;
            }
            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>

</x-layout.master>

