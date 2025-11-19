<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Expenses Management</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Expenses</li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Summary Stats -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-sm radius-8 border-0 h-100" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%); border-left: 4px solid #ec3737 !important;">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-secondary-light mb-1">Total Expenses</p>
                                <h6 class="mb-0 fw-bold" style="color: #ec3737; font-size: 1.5rem;">{{ auth()->user()->business->currency }} {{ number_format($expenses->sum('amount'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px rounded-circle d-flex justify-content-center align-items-center" style="background-color: #ec3737;">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Transactions</p>
                                <h6 class="mb-0">{{ number_format($expenses->count()) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-3">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Average Expense</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($expenses->avg('amount'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">This Month</p>
                                <h6 class="mb-0">{{ auth()->user()->business->currency }} {{ number_format($expenses->filter(function($expense) { return $expense->date->isCurrentMonth(); })->sum('amount'), 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-info-main rounded-circle d-flex justify-content-center align-items-center">
                                <i class="bi bi-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-md mb-0 fw-semibold text-secondary-light">Show</span>
                        <select class="form-select form-select-sm w-auto" id="entries-per-page">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="icon-field">
                        <input type="text" name="search" class="form-control form-control-sm w-auto" placeholder="Search expenses..." id="search-input">
                        <span class="icon" style="color: #ec3737;">
                            <i class="bi bi-circle-fill"></i>
                        </span>
                    </div>
                </div>
                <button type="button" id="addExpenseBtn" class="btn text-white text-sm btn-sm px-20 py-12 radius-8 d-flex align-items-center gap-2 fw-bold shadow-sm" style="background-color: #ec3737; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                    <i class="bi bi-circle-fill"></i>
                    Record Expense
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table bordered-table mb-0" id="expenses-table">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center" style="width: 50px;">No.</th>
                                <th scope="col" style="min-width: 200px;">Expense</th>
                                <th scope="col" style="min-width: 100px;">Date</th>
                                <th scope="col" style="min-width: 150px;">Category</th>
                                <th scope="col" style="min-width: 120px;">Payment Method</th>
                                <th scope="col" style="min-width: 120px;">Receipt Number</th>
                                <th scope="col" class="text-center" style="min-width: 100px;">Status</th>
                                <th scope="col" class="text-end" style="min-width: 120px;">Amount</th>
                                <th scope="col" class="text-center" style="min-width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $index => $expense)
                            <tr>
                                <td class="text-center">
                                    <span class="text-sm fw-medium">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <span class="text-sm fw-semibold">{{ $expense->title }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $expense->date->format('M d, Y') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary-100 text-primary-600 px-16 py-6">
                                        {{ $expense->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $expense->payment_method ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ $expense->receipt ?? '-' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($expense->status === 'fulfilled')
                                        <span class="badge bg-success-100 text-success-600 px-16 py-6 text-xs">Fulfilled</span>
                                    @else
                                        <span class="badge bg-danger-100 text-danger-600 px-16 py-6 text-xs">Unfulfilled</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="text-sm fw-semibold text-danger-600">{{ number_format($expense->amount, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-6 justify-content-center">
                                        <button type="button" class="view-expense-btn bg-info-focus bg-hover-info-200 text-info-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="View" data-expense-id="{{ $expense->id }}">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                        <button type="button" class="edit-expense-btn fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle text-white border-0" style="background-color: #ec3737;" title="Edit" data-expense-id="{{ $expense->id }}" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                                            <i class="bi bi-circle-fill"></i>
                                        </button>
                                        <button type="button" class="delete-expense-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-32-px h-32-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete" data-expense-id="{{ $expense->id }}">
                                                <i class="bi bi-circle-fill"></i>
                                            </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-48">
                                    <i class="bi bi-circle-fill"></i>
                                    <p class="text-secondary-light fw-semibold mb-16">No expenses found</p>
                                    <a href="{{ route('expenses.create') }}" class="btn btn-primary-600 radius-8 px-20 py-11">
                                        Record Your First Expense
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="addExpenseModalLabel">Record New Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form id="addExpenseForm">
                        @csrf
                        <div class="row gy-3">
                            <!-- Title -->
                            <div class="col-12">
                                <label for="add_title" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Title <span class="text-danger-600">*</span>
                                </label>
                                <input type="text" class="form-control radius-8" id="add_title" name="title" placeholder="Enter expense title" required>
                            </div>

                            <!-- Expense Date -->
                            <div class="col-md-6">
                                <label for="add_date" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Expense Date <span class="text-danger-600">*</span>
                                </label>
                                <input type="date" class="form-control radius-8" id="add_date" name="date" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label for="add_category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Category <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-select radius-8" id="add_category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6">
                                <label for="add_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Amount <span class="text-danger-600">*</span>
                                </label>
                                <input type="number" class="form-control radius-8" id="add_amount" name="amount" step="0.01" min="0" placeholder="0.00" required>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-6">
                                <label for="add_payment_method" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Payment Method
                                </label>
                                <select class="form-select radius-8" id="add_payment_method" name="payment_method">
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="GCash">GCash</option>
                                    <option value="PayMaya">PayMaya</option>
                                </select>
                            </div>

                            <!-- Vendor -->
                            <div class="col-md-6">
                                <label for="add_vendor" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Vendor/Supplier
                                </label>
                                <input type="text" class="form-control radius-8" id="add_vendor" name="vendor" placeholder="Enter vendor name">
                            </div>

                            <!-- Receipt Number -->
                            <div class="col-md-6">
                                <label for="add_receipt" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Receipt Number
                                </label>
                                <input type="text" class="form-control radius-8" id="add_receipt" name="receipt" placeholder="Enter receipt number">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="add_status" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Status <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-select radius-8" id="add_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="fulfilled">Fulfilled</option>
                                    <option value="unfulfilled">Unfulfilled</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="add_description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Description
                                </label>
                                <textarea class="form-control radius-8" id="add_description" name="description" rows="3" placeholder="Enter additional details..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" form="addExpenseForm" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Record Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Expense Modal -->
    <div class="modal fade" id="editExpenseModal" tabindex="-1" aria-labelledby="editExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <h5 class="modal-title fw-bold" style="color: #ec3737;" id="editExpenseModalLabel">Edit Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <form id="editExpenseForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_expense_id" name="expense_id">
                        <div class="row gy-3">
                            <!-- Title -->
                            <div class="col-12">
                                <label for="edit_title" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Title <span class="text-danger-600">*</span>
                                </label>
                                <input type="text" class="form-control radius-8" id="edit_title" name="title" required>
                            </div>

                            <!-- Expense Date -->
                            <div class="col-md-6">
                                <label for="edit_date" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Expense Date <span class="text-danger-600">*</span>
                                </label>
                                <input type="date" class="form-control radius-8" id="edit_date" name="date" required>
                            </div>

                            <!-- Category -->
                            <div class="col-md-6">
                                <label for="edit_category_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Category <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-select radius-8" id="edit_category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6">
                                <label for="edit_amount" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Amount <span class="text-danger-600">*</span>
                                </label>
                                <input type="number" class="form-control radius-8" id="edit_amount" name="amount" step="0.01" min="0" required>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-6">
                                <label for="edit_payment_method" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Payment Method
                                </label>
                                <select class="form-select radius-8" id="edit_payment_method" name="payment_method">
                                    <option value="">Select Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="GCash">GCash</option>
                                    <option value="PayMaya">PayMaya</option>
                                </select>
                            </div>

                            <!-- Vendor -->
                            <div class="col-md-6">
                                <label for="edit_vendor" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Vendor/Supplier
                                </label>
                                <input type="text" class="form-control radius-8" id="edit_vendor" name="vendor">
                            </div>

                            <!-- Receipt Number -->
                            <div class="col-md-6">
                                <label for="edit_receipt" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Receipt Number
                                </label>
                                <input type="text" class="form-control radius-8" id="edit_receipt" name="receipt" placeholder="Enter receipt number">
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <label for="edit_status" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Status <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-select radius-8" id="edit_status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="fulfilled">Fulfilled</option>
                                    <option value="unfulfilled">Unfulfilled</option>
                                </select>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label for="edit_description" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Description
                                </label>
                                <textarea class="form-control radius-8" id="edit_description" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white radius-8 px-20 py-11" style="background-color: #ec3737;" form="editExpenseForm" onmouseover="this.style.backgroundColor='#d42f2f'" onmouseout="this.style.backgroundColor='#ec3737'">
                        Update Expense
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Expense Modal -->
    <div class="modal fade" id="viewExpenseModal" tabindex="-1" aria-labelledby="viewExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content radius-12">
                <div class="modal-header border-bottom py-16 px-24" style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0" style="color: #ec3737;" id="viewExpenseModalLabel">
                            Expense Details
                        </h5>
                        <p class="text-secondary-light mb-0 mt-1" style="font-size: 13px;" id="view_expense_description_subtitle"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-24 py-24">
                    <!-- Expense Information -->
                    <div class="mb-20">
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Expense Information</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Expense Date</p>
                                    <p class="fw-semibold mb-0" id="view_date">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Category</p>
                                    <span id="view_category">-</span>
                                </div>
                                <div class="col-12">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Title</p>
                                    <p class="fw-semibold mb-0" id="view_title">-</p>
                                </div>
                                <div class="col-12" id="view_description_container" style="display: none;">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Description</p>
                                    <p class="mb-0" id="view_description">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Amount</p>
                                    <p class="fw-bold mb-0 text-danger-600" style="font-size: 20px;" id="view_amount">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Payment Method</p>
                                    <p class="fw-semibold mb-0" id="view_payment_method">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="mb-20">
                        <h6 class="fw-bold mb-12" style="font-size: 18px !important; color: #4b5563;">Additional Details</h6>
                        <div class="p-16 bg-neutral-50 radius-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Vendor/Supplier</p>
                                    <p class="fw-semibold mb-0" id="view_vendor">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Receipt Number</p>
                                    <p class="fw-semibold mb-0" id="view_receipt">-</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="text-secondary-light mb-4" style="font-size: 12px;">Status</p>
                                    <span id="view_status">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top px-24 py-16">
                    <button type="button" class="btn btn-secondary-600 radius-8 px-20 py-11" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                var expensesTable;

                // Delete confirmation binding
                function bindDeleteConfirmation() {
                    $(document).off("click", ".delete-expense-btn").on("click", ".delete-expense-btn", function() {
                        var expenseId = $(this).data("expense-id");
                        
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#ec3737",
                            cancelButtonColor: "#6c757d",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "/expenses/" + expenseId,
                                    type: "DELETE",
                                    data: {
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Deleted!",
                                            text: "Expense has been deleted.",
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(function() {
                                            location.reload();
                                        });
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Error",
                                            text: "Failed to delete expense."
                                        });
                                    }
                                });
                            }
                        });
                    });
                }

                // Initialize DataTable
                function initDataTable() {
                    console.log("Initializing expense DataTable...");
                    
                    // Check if table exists
                    if ($("#expenses-table").length === 0) {
                        console.error("Expense table not found!");
                        return null;
                    }
                    
                    // Only initialize DataTable if there are expenses
                    var hasExpenses = $("#expenses-table tbody tr").length > 0 && !$("#expenses-table tbody tr td[colspan]").length;
                    
                    if (!hasExpenses) {
                        console.log("No expenses to display, skipping DataTable initialization");
                        return null;
                    }
                    
                    // Destroy existing instance if present
                if ($.fn.DataTable.isDataTable("#expenses-table")) {
                        console.log("Destroying existing DataTable instance...");
                    $("#expenses-table").DataTable().destroy();
                }

                    try {
                        expensesTable = $("#expenses-table").DataTable({
                        "pageLength": 10,
                        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
                        "ordering": true,
                    "searching": true,
                    "paging": true,
                    "info": true,
                    "responsive": true,
                    "autoWidth": false,
                    "order": [[2, "desc"]],
                    "pagingType": "simple_numbers",
                    "columns": [
                        { "orderable": true, "searchable": false },   // 0 - No.
                        { "orderable": true, "searchable": true },    // 1 - Expense
                        { "orderable": true, "searchable": false },   // 2 - Date
                        { "orderable": true, "searchable": true },    // 3 - Category
                        { "orderable": true, "searchable": true },    // 4 - Payment Method
                        { "orderable": true, "searchable": true },    // 5 - Receipt Number
                        { "orderable": true, "searchable": true },    // 6 - Status
                        { "orderable": true, "searchable": false },   // 7 - Amount
                        { "orderable": false, "searchable": false }   // 8 - Actions
                    ],
                    "columnDefs": [
                        {
                                "targets": [6], // Status column
                                "className": "text-center"
                            },
                            {
                                "targets": [7], // Amount column
                            "className": "text-end"
                        },
                        {
                                "targets": [8], // Actions column
                                "className": "text-center"
                        }
                    ],
                    "language": {
                        "lengthMenu": "Show _MENU_ entries",
                        "search": "Search:",
                        "searchPlaceholder": "Search expenses...",
                            "info": "Showing <strong>_START_</strong> to <strong>_END_</strong> of <strong>_TOTAL_</strong> entries",
                            "infoEmpty": "Showing 0 to 0 of 0 entries",
                            "infoFiltered": "(filtered from _MAX_ total entries)",
                        "paginate": {
                            "next": "Next",
                            "previous": "Previous"
                            },
                            "emptyTable": "No expenses found",
                            "zeroRecords": "No matching expenses found"
                        },
                        "dom": "<\"row\"<\"col-sm-12\"tr>>" +
                               "<\"row mt-24\"<\"col-sm-12 col-md-5\"<\"dataTables_info_wrapper\"i>><\"col-sm-12 col-md-7\"<\"dataTables_paginate_wrapper\"p>>>",
                        "drawCallback": function(settings) {
                            // Re-bind delete confirmation after redraw
                            bindDeleteConfirmation();
                            console.log("DataTable redrawn - Total records:", settings.fnRecordsTotal());
                        }
                    });

                    console.log("DataTable initialized successfully!");
                    return expensesTable;
                    
                    } catch (error) {
                        console.error("Error initializing DataTable:", error);
                        return null;
                    }
                }

                // Check if DataTables library is loaded
                if (typeof $.fn.DataTable === "undefined") {
                    console.error("DataTables library not loaded!");
                    return;
                }

                // Initialize the table
                expensesTable = initDataTable();
                console.log("Expense DataTable initialized:", expensesTable);

                // Only bind event handlers if table was initialized successfully
                if (expensesTable) {
                    // Unbind previous handlers to avoid duplicates
                    $("#search-input").off("keyup");
                    $("#entries-per-page").off("change");

                    // Custom search functionality
                    $("#search-input").on("keyup", function() {
                        console.log("Search triggered:", this.value);
                        expensesTable.search(this.value).draw();
                    });

                    // Custom entries per page functionality
                    $("#entries-per-page").on("change", function() {
                        console.log("Entries per page changed:", this.value);
                        expensesTable.page.len(parseInt(this.value)).draw();
                    });
                } else {
                    console.error("DataTable initialization failed - event handlers not bound");
                }

                // Add Expense Modal
                $("#addExpenseBtn").on("click", function() {
                    $("#addExpenseForm")[0].reset();
                    $("#add_date").val("{{ date('Y-m-d') }}");
                    $("#addExpenseModal").modal("show");
                });

                // Add Expense Form Submit
                $("#addExpenseForm").on("submit", function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "{{ route('expenses.store') }}",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            $("#addExpenseModal").modal("hide");
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "Expense recorded successfully!",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = "Please check the form for errors.";
                            
                            if (errors) {
                                errorMessage = Object.values(errors).flat().join("\\n");
                            }
                            
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: errorMessage
                            });
                        }
                    });
                });

                // View Expense Modal
                $(document).on("click", ".view-expense-btn", function() {
                    var expenseId = $(this).data("expense-id");
                    
                    $.ajax({
                        url: "/expenses/" + expenseId,
                        type: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        },
                        success: function(response) {
                            var expense = response.expense;
                            var currency = response.currency;
                            
                            $("#view_expense_description_subtitle").text(expense.title);
                            $("#view_date").text(expense.date_formatted);
                            $("#view_category").html('<span class="badge bg-primary-100 text-primary-600 px-16 py-6">' + expense.category.name + '</span>');
                            $("#view_title").text(expense.title);
                            
                            if (expense.description) {
                                $("#view_description").text(expense.description);
                                $("#view_description_container").show();
                            } else {
                                $("#view_description_container").hide();
                            }
                            
                            $("#view_amount").text(currency + " " + parseFloat(expense.amount).toFixed(2));
                            $("#view_payment_method").text(expense.payment_method || "Not Specified");
                            $("#view_vendor").text(expense.vendor || "Not Specified");
                            $("#view_receipt").text(expense.receipt || "Not Specified");
                            
                            // Display status with badge
                            if (expense.status === "fulfilled") {
                                $("#view_status").html('<span class="badge bg-success-100 text-success-600 px-16 py-6 text-xs">Fulfilled</span>');
                            } else {
                                $("#view_status").html('<span class="badge bg-danger-100 text-danger-600 px-16 py-6 text-xs">Unfulfilled</span>');
                            }
                            
                            $("#viewExpenseModal").modal("show");
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Failed to load expense details."
                            });
                        }
                    });
                });

                // Edit Expense Modal
                $(document).on("click", ".edit-expense-btn", function() {
                    var expenseId = $(this).data("expense-id");
                    
                    $.ajax({
                        url: "/expenses/" + expenseId,
                        type: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                            "Accept": "application/json"
                        },
                        success: function(response) {
                            var expense = response.expense;
                            
                            $("#edit_expense_id").val(expense.id);
                            $("#edit_date").val(expense.date);
                            $("#edit_category_id").val(expense.category_id);
                            $("#edit_title").val(expense.title);
                            $("#edit_description").val(expense.description || "");
                            $("#edit_amount").val(expense.amount);
                            $("#edit_payment_method").val(expense.payment_method || "");
                            $("#edit_vendor").val(expense.vendor || "");
                            $("#edit_receipt").val(expense.receipt || "");
                            $("#edit_status").val(expense.status || "unfulfilled");
                            
                            $("#editExpenseModal").modal("show");
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Failed to load expense details."
                            });
                        }
                    });
                });

                // Edit Expense Form Submit
                $("#editExpenseForm").on("submit", function(e) {
                    e.preventDefault();
                    var expenseId = $("#edit_expense_id").val();
                    var formData = $(this).serialize();

                    $.ajax({
                        url: "/expenses/" + expenseId,
                        type: "PUT",
                        data: formData,
                        success: function(response) {
                            $("#editExpenseModal").modal("hide");
                            Swal.fire({
                                icon: "success",
                                title: "Success!",
                                text: "Expense updated successfully!",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = "Please check the form for errors.";
                            
                            if (errors) {
                                errorMessage = Object.values(errors).flat().join("\\n");
                            }

                    Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: errorMessage
                            });
                        }
                    });
                });

            });
        </script>
    @endpush

</x-layout.master>

