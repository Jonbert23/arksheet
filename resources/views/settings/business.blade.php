<x-layout.master>

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Business Settings</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Settings</li>
                <li>-</li>
                <li class="fw-medium">Business Settings</li>
            </ul>
        </div>

        <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-40">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <iconify-icon icon="mdi:check-circle" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <iconify-icon icon="mdi:alert-circle" class="icon text-xl"></iconify-icon>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('settings.business.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Business Identity Section -->
                <div class="mb-40">
                    <h6 class="text-xl mb-24">Business Identity</h6>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Business Name <span class="text-danger-600">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $business->name ?? '') }}" 
                                       placeholder="Enter business name" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="founder" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Founder Name
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('founder') is-invalid @enderror" 
                                       id="founder" 
                                       name="founder" 
                                       value="{{ old('founder', $business->founder ?? '') }}" 
                                       placeholder="Enter founder name">
                                @error('founder')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="category" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Industry Category
                                </label>
                                <select class="form-control radius-8 form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category">
                                    <option value="">Select Industry</option>
                                    <option value="electronics" {{ old('category', $business->category ?? '') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                                    <option value="fashion_apparel" {{ old('category', $business->category ?? '') == 'fashion_apparel' ? 'selected' : '' }}>Fashion & Apparel</option>
                                    <option value="food_beverage" {{ old('category', $business->category ?? '') == 'food_beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                    <option value="health_beauty" {{ old('category', $business->category ?? '') == 'health_beauty' ? 'selected' : '' }}>Health & Beauty</option>
                                    <option value="home_garden" {{ old('category', $business->category ?? '') == 'home_garden' ? 'selected' : '' }}>Home & Garden</option>
                                    <option value="automotive" {{ old('category', $business->category ?? '') == 'automotive' ? 'selected' : '' }}>Automotive</option>
                                    <option value="construction" {{ old('category', $business->category ?? '') == 'construction' ? 'selected' : '' }}>Construction</option>
                                    <option value="technology" {{ old('category', $business->category ?? '') == 'technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="education" {{ old('category', $business->category ?? '') == 'education' ? 'selected' : '' }}>Education</option>
                                    <option value="healthcare" {{ old('category', $business->category ?? '') == 'healthcare' ? 'selected' : '' }}>Healthcare</option>
                                    <option value="professional_services" {{ old('category', $business->category ?? '') == 'professional_services' ? 'selected' : '' }}>Professional Services</option>
                                    <option value="other" {{ old('category', $business->category ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="business_type" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Business Type
                                </label>
                                <select class="form-control radius-8 form-select @error('business_type') is-invalid @enderror" 
                                        id="business_type" 
                                        name="business_type">
                                    <option value="">Select Business Type</option>
                                    <option value="retail_store" {{ old('business_type', $business->business_type ?? '') == 'retail_store' ? 'selected' : '' }}>Retail Store</option>
                                    <option value="wholesale" {{ old('business_type', $business->business_type ?? '') == 'wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="restaurant" {{ old('business_type', $business->business_type ?? '') == 'restaurant' ? 'selected' : '' }}>Restaurant / Food Service</option>
                                    <option value="service" {{ old('business_type', $business->business_type ?? '') == 'service' ? 'selected' : '' }}>Service Business</option>
                                    <option value="manufacturing" {{ old('business_type', $business->business_type ?? '') == 'manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="ecommerce" {{ old('business_type', $business->business_type ?? '') == 'ecommerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="other" {{ old('business_type', $business->business_type ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('business_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="employees" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Number of Employees
                                </label>
                                <select class="form-control radius-8 form-select @error('employees') is-invalid @enderror" 
                                        id="employees" 
                                        name="employees">
                                    <option value="">Select Range</option>
                                    <option value="1-5" {{ old('employees', $business->employees ?? '') == '1-5' ? 'selected' : '' }}>1-5 employees</option>
                                    <option value="6-10" {{ old('employees', $business->employees ?? '') == '6-10' ? 'selected' : '' }}>6-10 employees</option>
                                    <option value="11-20" {{ old('employees', $business->employees ?? '') == '11-20' ? 'selected' : '' }}>11-20 employees</option>
                                    <option value="21-50" {{ old('employees', $business->employees ?? '') == '21-50' ? 'selected' : '' }}>21-50 employees</option>
                                    <option value="51-100" {{ old('employees', $business->employees ?? '') == '51-100' ? 'selected' : '' }}>51-100 employees</option>
                                    <option value="100+" {{ old('employees', $business->employees ?? '') == '100+' ? 'selected' : '' }}>100+ employees</option>
                                </select>
                                @error('employees')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="years_in_business" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Years in Business
                                </label>
                                <select class="form-control radius-8 form-select @error('years_in_business') is-invalid @enderror" 
                                        id="years_in_business" 
                                        name="years_in_business">
                                    <option value="">Select Range</option>
                                    <option value="new" {{ old('years_in_business', $business->years_in_business ?? '') == 'new' ? 'selected' : '' }}>Just Starting</option>
                                    <option value="0-1" {{ old('years_in_business', $business->years_in_business ?? '') == '0-1' ? 'selected' : '' }}>Less than 1 year</option>
                                    <option value="1-3" {{ old('years_in_business', $business->years_in_business ?? '') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                                    <option value="3-5" {{ old('years_in_business', $business->years_in_business ?? '') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                                    <option value="5-10" {{ old('years_in_business', $business->years_in_business ?? '') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                    <option value="10+" {{ old('years_in_business', $business->years_in_business ?? '') == '10+' ? 'selected' : '' }}>10+ years</option>
                                </select>
                                @error('years_in_business')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="date_founded" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Date Founded
                                </label>
                                <input type="date" 
                                       class="form-control radius-8 @error('date_founded') is-invalid @enderror" 
                                       id="date_founded" 
                                       name="date_founded" 
                                       value="{{ old('date_founded', $business->date_founded ? $business->date_founded->format('Y-m-d') : '') }}">
                                @error('date_founded')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-20">
                                <label for="logoUpload" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Business Logo <span class="text-secondary-light fw-normal">(Recommended: 200px X 200px)</span>
                                </label>
                                <input type="file" 
                                       class="form-control radius-8 @error('logo') is-invalid @enderror" 
                                       id="logoUpload" 
                                       name="logo" 
                                       accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
                                @if(isset($business) && $business->logo)
                                    <div class="mt-16">
                                        <p class="text-sm mb-8">Current Logo:</p>
                                        <img src="{{ asset('storage/' . $business->logo) }}" 
                                             alt="Business Logo" 
                                             class="border radius-8" 
                                             style="max-width: 200px; max-height: 200px;">
                                    </div>
                                @endif
                                
                                <div class="avatar-upload mt-16">
                                    <div class="avatar-preview style-two">
                                        <div id="logoPreview"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="mb-40">
                    <h6 class="text-xl mb-24">Contact Information</h6>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control radius-8 @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', $business->phone ?? '') }}" 
                                       placeholder="+1 (234) 567-8900">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Business Email <span class="text-danger-600">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control radius-8 @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $business->email ?? '') }}" 
                                       placeholder="business@example.com" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-20">
                                <label for="website" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Website URL
                                </label>
                                <input type="url" 
                                       class="form-control radius-8 @error('website') is-invalid @enderror" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $business->website ?? '') }}" 
                                       placeholder="https://www.example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-20">
                                <label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Street Address
                                </label>
                                <textarea class="form-control radius-8 @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="2" 
                                          placeholder="Enter street address">{{ old('address', $business->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="city" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    City
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city', $business->city ?? '') }}" 
                                       placeholder="Enter city">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="state" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    State/Province
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('state') is-invalid @enderror" 
                                       id="state" 
                                       name="state" 
                                       value="{{ old('state', $business->state ?? '') }}" 
                                       placeholder="Enter state/province">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="postal_code" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Postal Code
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('postal_code') is-invalid @enderror" 
                                       id="postal_code" 
                                       name="postal_code" 
                                       value="{{ old('postal_code', $business->postal_code ?? '') }}" 
                                       placeholder="Enter postal code">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="country" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Country
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('country') is-invalid @enderror" 
                                       id="country" 
                                       name="country" 
                                       value="{{ old('country', $business->country ?? 'Philippines') }}" 
                                       placeholder="Enter country">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="business_hours" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Business Hours
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('business_hours') is-invalid @enderror" 
                                       id="business_hours" 
                                       name="business_hours" 
                                       value="{{ old('business_hours', $business->business_hours ?? '') }}" 
                                       placeholder="e.g., Mon-Fri: 9AM-6PM">
                                @error('business_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="tax_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Tax ID / Business Registration
                                </label>
                                <input type="text" 
                                       class="form-control radius-8 @error('tax_id') is-invalid @enderror" 
                                       id="tax_id" 
                                       name="tax_id" 
                                       value="{{ old('tax_id', $business->tax_id ?? '') }}" 
                                       placeholder="Enter tax ID or business registration number">
                                @error('tax_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Regional Settings Section -->
                <div class="mb-40">
                    <h6 class="text-xl mb-24">Regional Settings</h6>
                    <div class="row gy-3">
                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="currency" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Currency <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-control radius-8 form-select @error('currency') is-invalid @enderror" 
                                        id="currency" 
                                        name="currency" 
                                        required>
                                    <option value="">Select Currency</option>
                                    <option value="USD" {{ old('currency', $business->currency ?? 'USD') == 'USD' ? 'selected' : '' }}>USD - US Dollar ($)</option>
                                    <option value="EUR" {{ old('currency', $business->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro (€)</option>
                                    <option value="GBP" {{ old('currency', $business->currency ?? '') == 'GBP' ? 'selected' : '' }}>GBP - British Pound (£)</option>
                                    <option value="JPY" {{ old('currency', $business->currency ?? '') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen (¥)</option>
                                    <option value="CAD" {{ old('currency', $business->currency ?? '') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar (C$)</option>
                                    <option value="AUD" {{ old('currency', $business->currency ?? '') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar (A$)</option>
                                    <option value="CHF" {{ old('currency', $business->currency ?? '') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc (CHF)</option>
                                    <option value="CNY" {{ old('currency', $business->currency ?? '') == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan (¥)</option>
                                    <option value="INR" {{ old('currency', $business->currency ?? '') == 'INR' ? 'selected' : '' }}>INR - Indian Rupee (₹)</option>
                                    <option value="PHP" {{ old('currency', $business->currency ?? '') == 'PHP' ? 'selected' : '' }}>PHP - Philippine Peso (₱)</option>
                                </select>
                                @error('currency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-20">
                                <label for="timezone" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Timezone <span class="text-danger-600">*</span>
                                </label>
                                <select class="form-control radius-8 form-select @error('timezone') is-invalid @enderror" 
                                        id="timezone" 
                                        name="timezone" 
                                        required>
                                    <option value="">Select Timezone</option>
                                    <option value="America/New_York" {{ old('timezone', $business->timezone ?? '') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (ET)</option>
                                    <option value="America/Chicago" {{ old('timezone', $business->timezone ?? '') == 'America/Chicago' ? 'selected' : '' }}>Central Time (CT)</option>
                                    <option value="America/Denver" {{ old('timezone', $business->timezone ?? '') == 'America/Denver' ? 'selected' : '' }}>Mountain Time (MT)</option>
                                    <option value="America/Los_Angeles" {{ old('timezone', $business->timezone ?? '') == 'America/Los_Angeles' ? 'selected' : '' }}>Pacific Time (PT)</option>
                                    <option value="Europe/London" {{ old('timezone', $business->timezone ?? '') == 'Europe/London' ? 'selected' : '' }}>London (GMT)</option>
                                    <option value="Europe/Paris" {{ old('timezone', $business->timezone ?? '') == 'Europe/Paris' ? 'selected' : '' }}>Paris (CET)</option>
                                    <option value="Asia/Tokyo" {{ old('timezone', $business->timezone ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo (JST)</option>
                                    <option value="Asia/Shanghai" {{ old('timezone', $business->timezone ?? '') == 'Asia/Shanghai' ? 'selected' : '' }}>Shanghai (CST)</option>
                                    <option value="Asia/Dubai" {{ old('timezone', $business->timezone ?? '') == 'Asia/Dubai' ? 'selected' : '' }}>Dubai (GST)</option>
                                    <option value="Asia/Manila" {{ old('timezone', $business->timezone ?? '') == 'Asia/Manila' ? 'selected' : '' }}>Manila (PHT)</option>
                                    <option value="Australia/Sydney" {{ old('timezone', $business->timezone ?? '') == 'Australia/Sydney' ? 'selected' : '' }}>Sydney (AEDT)</option>
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="mb-40">
                    <h6 class="text-xl mb-24">Business Status</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check form-switch mb-20">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       role="switch" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', $business->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold text-primary-light text-sm" for="is_active">
                                    Business is Active
                                </label>
                                <p class="text-secondary-light text-sm mb-0 mt-2">
                                    When disabled, no transactions can be processed for this business.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                    <button type="reset" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 py-11 radius-8">
                        <iconify-icon icon="mdi:refresh" class="icon text-xl"></iconify-icon>
                        Reset
                    </button>
                    <button type="submit" class="btn btn-primary-600 radius-8 px-24 py-12 d-flex align-items-center gap-2">
                        <iconify-icon icon="ic:round-check" class="text-xl"></iconify-icon>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

    @push('scripts')
    <script>
        // ================== Image Upload Js Start ===========================
        function readURL(input, previewElementId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $("#" + previewElementId).css("background-image", "url(" + e.target.result + ")");
                    $("#" + previewElementId).hide();
                    $("#" + previewElementId).fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#logoUpload").change(function() {
            readURL(this, "logoPreview");
        });
        // ================== Image Upload Js End ===========================
    </script>
    @endpush

</x-layout.master>

