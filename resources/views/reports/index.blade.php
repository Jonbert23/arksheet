<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Reports & Analytics</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Reports</li>
            </ul>
        </div>

        <!-- Quick Access Cards -->
        <div class="row gy-4">
            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('reports.sales') }}" class="card shadow-none radius-8 border h-100 hover-shadow-lg text-decoration-none">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-primary-100 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Sales Report</h6>
                                <span class="text-sm text-secondary-light">Detailed sales analysis</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">View sales by customer, channel, product, and payment status. Track revenue trends and top-selling items.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('reports.expenses') }}" class="card shadow-none radius-8 border h-100 hover-shadow-lg text-decoration-none">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-danger-100 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Expense Report</h6>
                                <span class="text-sm text-secondary-light">Track business expenses</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">Analyze expenses by category, vendor, payment method. Monitor spending patterns and budget adherence.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('reports.financial') }}" class="card shadow-none radius-8 border h-100 hover-shadow-lg text-decoration-none">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-success-100 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Financial Statement</h6>
                                <span class="text-sm text-secondary-light">Profit & loss overview</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">Comprehensive profit & loss statement. View revenue, COGS, expenses, and net profit margins.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('reports.products') }}" class="card shadow-none radius-8 border h-100 hover-shadow-lg text-decoration-none">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-info-100 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Product Performance</h6>
                                <span class="text-sm text-secondary-light">Product sales analysis</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">Track product performance, revenue, profit margins, and inventory turnover rates.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6">
                <a href="{{ route('reports.customers') }}" class="card shadow-none radius-8 border h-100 hover-shadow-lg text-decoration-none">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-warning-100 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Customer Report</h6>
                                <span class="text-sm text-secondary-light">Customer insights</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">Analyze customer purchase behavior, lifetime value, and transaction history.</p>
                    </div>
                </a>
            </div>

            <div class="col-lg-4 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-neutral-50">
                    <div class="card-body p-24">
                        <div class="d-flex align-items-center gap-3 mb-16">
                            <div class="w-60-px h-60-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                            <div>
                                <h6 class="fw-semibold mb-0">Export Reports</h6>
                                <span class="text-sm text-secondary-light">Coming soon</span>
                            </div>
                        </div>
                        <p class="text-secondary-light mb-0 text-sm">Export reports to PDF, Excel, or CSV for offline analysis and record-keeping.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-layout.master>

