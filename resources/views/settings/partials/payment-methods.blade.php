<div class="d-flex justify-content-between align-items-center mb-20">
    <h6 class="text-lg mb-0 fw-semibold">Payment Methods</h6>
    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-6 radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
        <iconify-icon icon="ic:round-plus" class="icon text-xl"></iconify-icon>
        Add Method
    </button>
</div>

@forelse($paymentMethods as $method)
<div class="config-item {{$method->is_active?'':'inactive'}}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1"><h6 class="text-md mb-0">{{$method->setting_label}}</h6></div>
        <div class="d-flex gap-2">
            <span class="badge {{$method->is_active?'bg-success-100 text-success-600':'bg-secondary-100 text-secondary-600'}} badge-status">{{$method->is_active?'Active':'Inactive'}}</span>
            @if(!$method->is_system)
            <button class="btn btn-sm btn-outline-primary-600 radius-8 px-12 py-4 d-flex align-items-center gap-1" title="Edit"><iconify-icon icon="lucide:edit" class="text-lg"></iconify-icon></button>
            <button class="btn btn-sm btn-outline-danger-600 radius-8 px-12 py-4 d-flex align-items-center gap-1" title="Delete"><iconify-icon icon="mingcute:delete-2-line" class="text-lg"></iconify-icon></button>
            @else
            <span class="badge bg-info-100 text-info-600 badge-status fw-medium">System</span>
            @endif
        </div>
    </div>
</div>
@empty
<div class="text-center py-5">
    <div class="d-flex justify-content-center mb-3">
        <iconify-icon icon="mdi:credit-card" class="text-secondary-light" style="font-size: 48px;"></iconify-icon>
    </div>
    <p class="text-secondary-light mb-0">No payment methods configured</p>
</div>
@endforelse

