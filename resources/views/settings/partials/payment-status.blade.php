<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Payment Status</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addPaymentStatusModal">
        <i class="bi bi-circle-fill"></i>
        Add Status
    </button>
</div>

@forelse($paymentStatuses as $status)
<div class="config-item {{$status->is_active?'':'inactive'}}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1"><h6 class="text-md mb-0">{{$status->setting_label}}</h6></div>
        <div class="d-flex gap-2">
            <span class="badge {{$status->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$status->is_active?'Active':'Inactive'}}</span>
            @if(!$status->is_system)
            <button class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1" title="Edit"><i class="bi bi-circle-fill"></i></button>
            <button class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1" title="Delete"><i class="bi bi-circle-fill"></i></button>
            @else
            <span class="badge bg-info-100 text-info-600 badge-status fw-medium">System</span>
            @endif
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="d-flex justify-content-center mb-3">
        <i class="bi bi-circle-fill"></i>
    </div>
    <p class="text-secondary-light mb-0">No payment statuses configured</p>
</div>
@endforelse

