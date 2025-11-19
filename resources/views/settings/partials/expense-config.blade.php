<div class="row">
    <!-- Expense Categories -->
    <div class="col-md-6 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-20">
            <h6 class="text-lg mb-0">Expense Categories</h6>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExpenseCategoryModal">
                <i class="bi bi-circle-fill"></i> Add Category
            </button>
        </div>
        <div id="expenseCategoriesList">
            @forelse($expenseCategories as $category)
            <div class="config-item {{$category->is_active?'':'inactive'}}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-md mb-1">{{$category->name}}</h6>
                        @if($category->description)<p class="text-sm text-secondary-light mb-0">{{$category->description}}</p>@endif
                    </div>
                    <div class="d-flex gap-2">
                        <span class="badge {{$category->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$category->is_active?'Active':'Inactive'}}</span>
                        <button class="btn btn-sm btn-outline-primary btn-icon edit-expense-category" data-id="{{$category->id}}" data-name="{{$category->name}}" data-description="{{$category->description}}" data-active="{{$category->is_active}}"><i class="bi bi-circle-fill"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-icon delete-expense-category" data-id="{{$category->id}}"><i class="bi bi-circle-fill"></i></button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5"><i class="bi bi-circle-fill"></i><p class="text-secondary-light mt-2">No expense categories configured</p></div>
            @endforelse
        </div>
    </div>

    <!-- Expense Status -->
    <div class="col-md-6">
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-20">
                <h6 class="text-lg mb-0">Expense Status</h6>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addExpenseStatusModal">
                    <i class="bi bi-circle-fill"></i> Add Status
                </button>
            </div>
            @forelse($expenseStatuses as $status)
            <div class="config-item {{$status->is_active?'':'inactive'}}">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1"><h6 class="text-md mb-0">{{$status->setting_label}}</h6></div>
                    <div class="d-flex gap-2">
                        <span class="badge {{$status->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$status->is_active?'Active':'Inactive'}}</span>
                        @if(!$status->is_system)
                        <button class="btn btn-sm btn-outline-primary btn-icon edit-expense-status" data-id="{{$status->id}}" data-label="{{$status->setting_label}}" data-value="{{$status->setting_value}}" data-active="{{$status->is_active}}"><i class="bi bi-circle-fill"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-icon delete-expense-status" data-id="{{$status->id}}"><i class="bi bi-circle-fill"></i></button>
                        @else
                        <span class="badge bg-info-100 text-info-600 badge-status">System</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-5"><i class="bi bi-circle-fill"></i><p class="text-secondary-light mt-2">No expense statuses configured</p></div>
            @endforelse
        </div>

        <div class="alert alert-info">
            <h6 class="alert-heading">Expense Management</h6>
            <p class="text-sm mb-0">Configure categories and statuses to organize your expense tracking effectively.</p>
        </div>
    </div>
</div>

<!-- Modals would be included here -->
@push('scripts')
<script>
$(document).ready(function() {
    // Similar AJAX handlers as product-config
    // Copy pattern from product-config.blade.php for all CRUD operations
});
</script>
@endpush

