<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Expense Categories</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addExpenseCategoryModal">
        <i class="bi bi-plus-circle"></i>
        Add Category
    </button>
</div>

@forelse($expenseCategories as $category)
<div class="config-item {{$category->is_active?'':'inactive'}}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1">
            <h6 class="text-md mb-1">{{$category->name}}</h6>
            @if($category->description)<p class="text-sm text-secondary-light mb-0">{{$category->description}}</p>@endif
        </div>
        <div class="d-flex gap-2">
            <span class="badge {{$category->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$category->is_active?'Active':'Inactive'}}</span>
            <button class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-expense-category" data-id="{{$category->id}}" data-name="{{$category->name}}" data-description="{{$category->description}}" data-active="{{$category->is_active}}" title="Edit"><i class="bi bi-pencil-square"></i></button>
            <button class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-expense-category" data-id="{{$category->id}}" title="Delete"><i class="bi bi-trash3"></i></button>
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="d-flex justify-content-center mb-3">
        <i class="bi bi-inbox" style="font-size: 48px; color: #9ca3af;"></i>
    </div>
    <p class="text-secondary-light mb-0">No expense categories configured</p>
</div>
@endforelse

