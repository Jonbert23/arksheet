<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Expense Status</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addExpenseStatusModal">
        <iconify-icon icon="ic:round-plus" class="icon text-xl"></iconify-icon>
        Add Status
    </button>
</div>

@forelse($expenseStatuses as $status)
<div class="config-item {{$status->is_active?'':'inactive'}}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1"><h6 class="text-md mb-0">{{$status->setting_label}}</h6></div>
        <div class="d-flex gap-2">
            <span class="badge {{$status->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$status->is_active?'Active':'Inactive'}}</span>
            @if(!$status->is_system)
            <button class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 edit-expense-status" data-id="{{$status->id}}" data-label="{{$status->setting_label}}" data-value="{{$status->setting_value}}" data-active="{{$status->is_active}}" title="Edit"><iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon></button>
            <button class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1 delete-expense-status" data-id="{{$status->id}}" title="Delete"><iconify-icon icon="mingcute:delete-2-line" class="text-lg"></iconify-icon></button>
            @else
            <span class="badge bg-info-100 text-info-600 badge-status fw-medium">System</span>
            @endif
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="d-flex justify-content-center mb-3">
        <iconify-icon icon="mdi:check-all" class="text-secondary-light" style="font-size: 48px;"></iconify-icon>
    </div>
    <p class="text-secondary-light mb-0">No expense statuses configured</p>
</div>
@endforelse

