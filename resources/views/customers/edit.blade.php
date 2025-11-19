<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Edit Customer</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <i class="bi bi-house" class="icon text-lg"></i>
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
                <li class="fw-medium">Edit</li>
            </ul>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-circle-fill"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Customer Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row gy-3">
                        <!-- Customer Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Customer Name <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $customer->name) }}" 
                                   placeholder="Enter customer name"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Email Address
                            </label>
                            <input type="email" 
                                   class="form-control radius-8 @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $customer->email) }}" 
                                   placeholder="customer@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Phone Number
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $customer->phone) }}" 
                                   placeholder="+1 234 567 8900">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Company -->
                        <div class="col-md-6">
                            <label for="company" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Company Name
                            </label>
                            <input type="text" 
                                   class="form-control radius-8 @error('company') is-invalid @enderror" 
                                   id="company" 
                                   name="company" 
                                   value="{{ old('company', $customer->company) }}" 
                                   placeholder="Enter company name">
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Address
                            </label>
                            <textarea class="form-control radius-8 @error('address') is-invalid @enderror" 
                                      id="address" 
                                      name="address" 
                                      rows="3" 
                                      placeholder="Enter customer address">{{ old('address', $customer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1"
                                       {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold text-primary-light text-sm" for="is_active">
                                    Active Customer
                                </label>
                            </div>
                            <small class="text-secondary-light">Inactive customers won't appear in selection lists</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="col-12">
                            <div class="d-flex align-items-center gap-3">
                                <button type="submit" class="btn btn-primary-600 radius-8 px-20 py-11">
                                    <i class="bi bi-circle-fill"></i>
                                    Update Customer
                                </button>
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary-600 radius-8 px-20 py-11">
                                    <i class="bi bi-circle-fill"></i>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layout.master>

