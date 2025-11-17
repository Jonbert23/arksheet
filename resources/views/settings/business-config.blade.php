<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Business Configuration</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Settings</li>
                <li>-</li>
                <li class="fw-medium">Configuration</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:check-circle" class="icon text-xl"></iconify-icon>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:alert-circle" class="icon text-xl"></iconify-icon>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Nav tabs (Outside Card) -->
        <ul class="nav bordered-tab nav-primary mb-0" id="mainTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active d-flex align-items-center gap-2 px-24 py-12" id="main-business-tab" data-bs-toggle="tab" data-bs-target="#main-business" type="button" role="tab" aria-selected="true">
                    <iconify-icon icon="mdi:office-building" class="text-xl"></iconify-icon>
                    <span>Business</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2 px-24 py-12" id="main-products-tab" data-bs-toggle="tab" data-bs-target="#main-products" type="button" role="tab" aria-selected="false">
                    <iconify-icon icon="mdi:package-variant" class="text-xl"></iconify-icon>
                    <span>Products</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2 px-24 py-12" id="main-stock-tab" data-bs-toggle="tab" data-bs-target="#main-stock" type="button" role="tab" aria-selected="false">
                    <iconify-icon icon="mdi:truck-delivery" class="text-xl"></iconify-icon>
                    <span>Stock</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2 px-24 py-12" id="main-sales-tab" data-bs-toggle="tab" data-bs-target="#main-sales" type="button" role="tab" aria-selected="false">
                    <iconify-icon icon="mdi:cart-outline" class="text-xl"></iconify-icon>
                    <span>Sales</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link d-flex align-items-center gap-2 px-24 py-12" id="main-expenses-tab" data-bs-toggle="tab" data-bs-target="#main-expenses" type="button" role="tab" aria-selected="false">
                    <iconify-icon icon="mdi:cash-remove" class="text-xl"></iconify-icon>
                    <span>Expenses</span>
                </button>
            </li>
        </ul>

        <div class="card h-100 p-0 radius-12" id="config-card">
            <div class="card-body p-24">
                <!-- Main Tab Content -->
                <div class="tab-content" id="mainTabContent">
                    
                    <!-- Business Tab -->
                    <div class="tab-pane fade show active" id="main-business" role="tabpanel" aria-labelledby="main-business-tab">
                        @include('settings.partials.business-settings')
                    </div>

                    <!-- Products Tab -->
                    <div class="tab-pane fade" id="main-products" role="tabpanel" aria-labelledby="main-products-tab">
                        <!-- Sub-tabs for Products -->
                        <ul class="nav bordered-tab d-inline-flex nav-primary mb-24" id="productsSubTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-20 py-9" id="product-categories-tab" data-bs-toggle="pill" data-bs-target="#product-categories" type="button" role="tab" aria-selected="true">
                                    Product Categories
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-20 py-9" id="product-types-tab" data-bs-toggle="pill" data-bs-target="#product-types" type="button" role="tab" aria-selected="false">
                                    Product Types
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="productsSubTabContent">
                            <div class="tab-pane fade show active" id="product-categories" role="tabpanel">
                                @include('settings.partials.product-categories')
                            </div>
                            <div class="tab-pane fade" id="product-types" role="tabpanel">
                                @include('settings.partials.product-types')
                            </div>
                        </div>
                    </div>

                    <!-- Stock Tab -->
                    <div class="tab-pane fade" id="main-stock" role="tabpanel" aria-labelledby="main-stock-tab">
                        @include('settings.partials.stock-config')
                    </div>

                    <!-- Sales Tab -->
                    <div class="tab-pane fade" id="main-sales" role="tabpanel" aria-labelledby="main-sales-tab">
                        <!-- Sub-tabs for Sales -->
                        <ul class="nav bordered-tab d-inline-flex nav-primary mb-24" id="salesSubTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-20 py-9" id="sales-channels-tab" data-bs-toggle="pill" data-bs-target="#sales-channels" type="button" role="tab" aria-selected="true">
                                    Sales Channels
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-20 py-9" id="payment-methods-tab" data-bs-toggle="pill" data-bs-target="#payment-methods" type="button" role="tab" aria-selected="false">
                                    Payment Methods
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-20 py-9" id="payment-status-tab" data-bs-toggle="pill" data-bs-target="#payment-status" type="button" role="tab" aria-selected="false">
                                    Payment Status
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="salesSubTabContent">
                            <div class="tab-pane fade show active" id="sales-channels" role="tabpanel">
                                @include('settings.partials.sales-channels')
                            </div>
                            <div class="tab-pane fade" id="payment-methods" role="tabpanel">
                                @include('settings.partials.payment-methods')
                            </div>
                            <div class="tab-pane fade" id="payment-status" role="tabpanel">
                                @include('settings.partials.payment-status')
                            </div>
                        </div>
                    </div>

                    <!-- Expenses Tab -->
                    <div class="tab-pane fade" id="main-expenses" role="tabpanel" aria-labelledby="main-expenses-tab">
                        <!-- Sub-tabs for Expenses -->
                        <ul class="nav bordered-tab d-inline-flex nav-primary mb-24" id="expensesSubTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active px-20 py-9" id="expense-categories-tab" data-bs-toggle="pill" data-bs-target="#expense-categories" type="button" role="tab" aria-selected="true">
                                    Expense Categories
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link px-20 py-9" id="expense-status-tab" data-bs-toggle="pill" data-bs-target="#expense-status" type="button" role="tab" aria-selected="false">
                                    Expense Status
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="expensesSubTabContent">
                            <div class="tab-pane fade show active" id="expense-categories" role="tabpanel">
                                @include('settings.partials.expense-categories')
                            </div>
                            <div class="tab-pane fade" id="expense-status" role="tabpanel">
                                @include('settings.partials.expense-statuses')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Sales Channels Modals -->
    <div class="modal fade" id="addChannelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Add Sales Channel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addChannelForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Channel Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="name" required placeholder="e.g., Online Store">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                            <textarea class="form-control radius-8" name="description" rows="3" placeholder="Brief description..."></textarea>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Add Channel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editChannelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Edit Sales Channel
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editChannelForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="channel_id" id="edit_channel_id">
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Channel Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="name" id="edit_channel_name" required>
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                            <textarea class="form-control radius-8" name="description" id="edit_channel_description" rows="3"></textarea>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_channel_active">
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Update Channel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Methods Modals -->
    <div class="modal fade" id="addPaymentMethodModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Add Payment Method
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPaymentMethodForm">
                    @csrf
                    <input type="hidden" name="setting_key" value="payment_method">
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Method Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="label" required placeholder="e.g., Cash">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Method Value <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="value" required placeholder="e.g., cash">
                            <small class="text-secondary-light d-block mt-1"><iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon> Lowercase, no spaces (use underscores)</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Add Method
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Status Modals -->
    <div class="modal fade" id="addPaymentStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Add Payment Status
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPaymentStatusForm">
                    @csrf
                    <input type="hidden" name="setting_key" value="payment_status">
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status Label <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="label" required placeholder="e.g., Paid">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status Value <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="value" required placeholder="e.g., paid">
                            <small class="text-secondary-light d-block mt-1"><iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon> Lowercase, no spaces (use underscores)</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Add Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Expense Categories Modals -->
    <div class="modal fade" id="addExpenseCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Add Expense Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addExpenseCategoryForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Category Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="name" required placeholder="e.g., Office Supplies">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                            <textarea class="form-control radius-8" name="description" rows="3" placeholder="Brief description..."></textarea>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editExpenseCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Edit Expense Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editExpenseCategoryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" id="edit_expense_category_id">
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Category Name <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="name" id="edit_expense_category_name" required>
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                            <textarea class="form-control radius-8" name="description" id="edit_expense_category_description" rows="3"></textarea>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_expense_category_active">
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Expense Status Modals -->
    <div class="modal fade" id="addExpenseStatusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);">
                    <h5 class="modal-title text-white fw-bold" style="font-size: 18px !important;">
                        Add Expense Status
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addExpenseStatusForm">
                    @csrf
                    <input type="hidden" name="setting_key" value="expense_status">
                    <div class="modal-body">
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status Label <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="label" required placeholder="e.g., Approved">
                        </div>
                        <div class="mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status Value <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8" name="value" required placeholder="e.g., approved">
                            <small class="text-secondary-light d-block mt-1"><iconify-icon icon="mdi:information" class="icon-sm"></iconify-icon> Lowercase, no spaces (use underscores)</small>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" checked>
                            <label class="form-check-label fw-medium">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary radius-8 px-20 py-11 d-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <iconify-icon icon="ic:round-close" class="text-xl"></iconify-icon>
                            Cancel
                        </button>
                        <button type="submit" class="btn text-white radius-8 px-20 py-11 d-flex align-items-center gap-2" style="background-color: #ec3737;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                            <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                            Add Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Config items styling */
        .config-item {
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin-bottom: 12px;
            background: #fff;
            transition: all 0.2s;
        }
        .config-item:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-color: #ddd;
        }
        .config-item.inactive {
            opacity: 0.65;
            background: #f9fafb;
        }
        .badge-status {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 4px;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items-center;
            justify-content: center;
            border-radius: 6px;
        }
        
        /* Remove top border radius from card when tabs are above */
        #config-card {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            margin-top: -1px;
        }
    </style>
    @endpush

</x-layout.master>

