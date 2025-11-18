@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Business</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('super-admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('super-admin.businesses.index') }}" class="hover-text-primary">Businesses</a>
        </li>
        <li>-</li>
        <li class="fw-medium">Edit</li>
    </ul>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Business Information</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('super-admin.businesses.update', $business) }}">
                    @csrf
                    @method('PUT')

                    <div class="row gy-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Business Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $business->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Business Email <span class="text-danger-600">*</span>
                            </label>
                            <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $business->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Phone Number
                            </label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $business->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="currency" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Currency <span class="text-danger-600">*</span>
                            </label>
                            <select class="form-select radius-8 @error('currency') is-invalid @enderror" 
                                    id="currency" name="currency" required>
                                <option value="USD" {{ old('currency', $business->currency) === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency', $business->currency) === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency', $business->currency) === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="INR" {{ old('currency', $business->currency) === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                            </select>
                            @error('currency')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="timezone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Timezone <span class="text-danger-600">*</span>
                            </label>
                            <select class="form-select radius-8 @error('timezone') is-invalid @enderror" 
                                    id="timezone" name="timezone" required>
                                <option value="UTC" {{ old('timezone', $business->timezone) === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone', $business->timezone) === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                <option value="Europe/London" {{ old('timezone', $business->timezone) === 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="Asia/Kolkata" {{ old('timezone', $business->timezone) === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
                            </select>
                            @error('timezone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Address
                            </label>
                            <textarea class="form-control radius-8 @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3">{{ old('address', $business->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $business->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Business
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 mt-4">
                        <a href="{{ route('super-admin.businesses.show', $business) }}" class="btn btn-outline-danger-600">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-600">
                            <i class="ri-save-line"></i> Update Business
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Business Details</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <span class="text-secondary-light">Created:</span>
                        <strong>{{ $business->created_at->format('M d, Y') }}</strong>
                    </li>
                    <li class="mb-3">
                        <span class="text-secondary-light">Last Updated:</span>
                        <strong>{{ $business->updated_at->format('M d, Y') }}</strong>
                    </li>
                    <li class="mb-3">
                        <span class="text-secondary-light">Status:</span>
                        @if($business->is_active)
                            <span class="badge bg-success-100 text-success-600">Active</span>
                        @else
                            <span class="badge bg-danger-100 text-danger-600">Inactive</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-danger-100">
                <h6 class="mb-0 text-danger-600">Danger Zone</h6>
            </div>
            <div class="card-body">
                <p class="text-sm mb-3">Deleting a business is permanent and cannot be undone.</p>
                <form method="POST" action="{{ route('super-admin.businesses.destroy', $business) }}" 
                      onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger-600 w-100">
                        <i class="ri-delete-bin-line"></i> Delete Business
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

