<!-- Summary Metrics -->
<div class="row gy-4 mb-24">
    <!-- Total Sales -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0" style="background-color: #ec3737;">
                            <i class="bi bi-receipt"></i>
                        </span>
                        <span class="text-secondary-light text-lg fw-medium">Total Sales</span>
                    </div>
                </div>
                <h6 class="fw-bold mb-1" style="color: #ec3737; font-size: 1.5rem;">{{ $sales->count() }}</h6>
                <p class="text-sm mb-0">All time sales count</p>
            </div>
        </div>
    </div>

    <!-- Total Revenue -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-2">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-success-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                            <i class="bi bi-cash-stack"></i>
                        </span>
                        <span class="text-secondary-light text-lg fw-medium">Total Revenue</span>
                    </div>
                </div>
                <h6 class="fw-semibold mb-1">{{ auth()->user()->business->currency }} {{ number_format($sales->sum('total'), 2) }}</h6>
                <p class="text-sm mb-0">All time revenue</p>
            </div>
        </div>
    </div>

    <!-- Avg. Sale Value -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-3">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-info-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                            <i class="bi bi-graph-up-arrow"></i>
                        </span>
                        <span class="text-secondary-light text-lg fw-medium">Avg. Sale Value</span>
                    </div>
                </div>
                <h6 class="fw-semibold mb-1">{{ auth()->user()->business->currency }} {{ $sales->count() > 0 ? number_format($sales->avg('total'), 2) : '0.00' }}</h6>
                <p class="text-sm mb-0">Average per sale</p>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="col-xxl-3 col-sm-6">
        <div class="card px-24 py-16 shadow-none radius-8 border h-100 bg-gradient-start-4">
            <div class="card-body p-0">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                    <div class="d-flex align-items-center gap-2">
                        <span class="mb-0 w-48-px h-48-px bg-warning-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                            <i class="bi bi-hourglass-split"></i>
                        </span>
                        <span class="text-secondary-light text-lg fw-medium">Pending</span>
                    </div>
                </div>
                <h6 class="fw-semibold mb-1">{{ $sales->where('payment_status', 'pending')->count() }}</h6>
                <p class="text-sm mb-0">Pending payments</p>
            </div>
        </div>
    </div>
</div>

