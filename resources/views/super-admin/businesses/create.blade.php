@extends('super-admin.layout.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Create New Business</h6>
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
        <li class="fw-medium">Create</li>
    </ul>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Business Information</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('super-admin.businesses.store') }}">
                    @csrf

                    <!-- Business Details -->
                    <div class="row gy-3 mb-4">
                        <div class="col-12">
                            <h6 class="text-md mb-3">Business Details</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Business Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Business Email <span class="text-danger-600">*</span>
                            </label>
                            <input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Phone Number
                            </label>
                            <input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
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
                                <option value="USD" {{ old('currency') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="GBP" {{ old('currency') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                                <option value="INR" {{ old('currency') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
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
                                <option value="UTC" {{ old('timezone') === 'UTC' ? 'selected' : '' }}>UTC</option>
                                <option value="America/New_York" {{ old('timezone') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                                <option value="Europe/London" {{ old('timezone') === 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="Asia/Kolkata" {{ old('timezone') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
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
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Business
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Details -->
                    <div class="row gy-3">
                        <div class="col-12">
                            <h6 class="text-md mb-3 mt-3">Business Owner Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label for="owner_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Owner Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('owner_name') is-invalid @enderror" 
                                   id="owner_name" name="owner_name" value="{{ old('owner_name') }}" required>
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="owner_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Owner Email <span class="text-danger-600">*</span>
                            </label>
                            <input type="email" class="form-control radius-8 @error('owner_email') is-invalid @enderror" 
                                   id="owner_email" name="owner_email" value="{{ old('owner_email') }}" required>
                            @error('owner_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="owner_password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Owner Password <span class="text-danger-600">*</span>
                            </label>
                            <input type="password" class="form-control radius-8 @error('owner_password') is-invalid @enderror" 
                                   id="owner_password" name="owner_password" required>
                            @error('owner_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="owner_password_confirmation" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Confirm Password <span class="text-danger-600">*</span>
                            </label>
                            <input type="password" class="form-control radius-8" 
                                   id="owner_password_confirmation" name="owner_password_confirmation" required>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end gap-3 mt-4">
                        <a href="{{ route('super-admin.businesses.index') }}" class="btn btn-outline-danger-600">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-600">
                            <i class="ri-add-line"></i> Create Business
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Information</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6 class="mb-2"><i class="fas fa-info-circle"></i> Important Notes</h6>
                    <ul class="mb-0 ps-3">
                        <li>A business owner account will be created automatically</li>
                        <li>The owner will receive login credentials via email</li>
                        <li>You can manage business settings later</li>
                        <li>Inactive businesses cannot be accessed by users</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

