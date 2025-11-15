<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Add New Customer</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('customers.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        Customers
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Add Customer</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <iconify-icon icon="mdi:alert-circle" class="icon text-xl me-2"></iconify-icon>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            
            <div class="row gy-4">
                <!-- Customer Information Card -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h6 class="card-title mb-0">Customer Information</h6>
                        </div>
                        <div class="card-body p-24">
                            <div class="row g-4">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        Customer Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter customer name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="customer@example.com" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="+1 234 567 8900" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Company -->
                                <div class="col-md-6">
                                    <label class="form-label">Company</label>
                                    <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" placeholder="Company name" value="{{ old('company') }}">
                                    @error('company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" placeholder="Complete address">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-12">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" value="1" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Active Customer
                                            </label>
                                        </div>
                                        <small class="text-secondary-light">Uncheck to mark customer as inactive</small>
                                    </div>
                                    @error('is_active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Notes -->
                                <div class="col-12">
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional notes about the customer">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="col-12">
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <a href="{{ route('customers.index') }}" class="btn btn-neutral-600 hover-bg-neutral-700 radius-8 px-24 py-11">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary-600 hover-bg-primary-700 radius-8 px-24 py-11">
                            <iconify-icon icon="mdi:check-circle" class="text-lg me-1"></iconify-icon>
                            Save Customer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-layout.master>

