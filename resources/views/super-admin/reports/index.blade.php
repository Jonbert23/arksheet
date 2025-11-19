@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Reports Overview</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <i class="bi bi-house" class="icon text-lg"></i>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Reports</li>
    </ul>
</div>

<div class="row gy-4">
    <!-- Revenue Report Card -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="w-64-px h-64-px bg-success-100 text-success-600 rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Revenue Report</h5>
                        <p class="text-sm text-secondary-light mb-0">Track revenue across all businesses</p>
                    </div>
                </div>
                <p class="text-secondary-light mb-3">
                    View detailed revenue analytics, payment methods, and business performance metrics.
                </p>
                <a href="{{ route('super-admin.reports.revenue') }}" class="btn btn-success-600 w-100">
                    <i class="bi bi-circle-fill"></i>
                    View Revenue Report
                </a>
            </div>
        </div>
    </div>

    <!-- Usage Report Card -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="w-64-px h-64-px bg-info-100 text-info-600 rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Usage Report</h5>
                        <p class="text-sm text-secondary-light mb-0">Monitor business activity</p>
                    </div>
                </div>
                <p class="text-secondary-light mb-3">
                    Analyze business activity, identify most and least active businesses, and track engagement.
                </p>
                <a href="{{ route('super-admin.reports.usage') }}" class="btn btn-info-600 w-100">
                    <i class="bi bi-circle-fill"></i>
                    View Usage Report
                </a>
            </div>
        </div>
    </div>

    <!-- Growth Report Card -->
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="w-64-px h-64-px bg-warning-100 text-warning-600 rounded d-flex align-items-center justify-content-center">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">Growth Report</h5>
                        <p class="text-sm text-secondary-light mb-0">Track platform growth</p>
                    </div>
                </div>
                <p class="text-secondary-light mb-3">
                    Monitor business, user, product, and revenue growth trends over time.
                </p>
                <a href="{{ route('super-admin.reports.growth') }}" class="btn btn-warning-600 w-100">
                    <i class="bi bi-circle-fill"></i>
                    View Growth Report
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h6 class="mb-0">Report Features</h6>
    </div>
    <div class="card-body">
        <div class="row gy-3">
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="text-primary-600">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Real-time Data</h6>
                        <p class="text-sm text-secondary-light mb-0">
                            All reports display real-time data from your database
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="text-primary-600">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Date Range Filtering</h6>
                        <p class="text-sm text-secondary-light mb-0">
                            Filter reports by custom date ranges
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="text-primary-600">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Visual Charts</h6>
                        <p class="text-sm text-secondary-light mb-0">
                            Interactive charts and graphs for better insights
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex gap-3">
                    <div class="text-primary-600">
                        <i class="bi bi-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="mb-1">Export Options</h6>
                        <p class="text-sm text-secondary-light mb-0">
                            Export reports to CSV or Excel (coming soon)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

