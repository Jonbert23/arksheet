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
                                    Business Category
                                </label>
                                <select class="form-control radius-8 form-select @error('category') is-invalid @enderror" 
                                        id="category" 
                                        name="category">
                                    <option value="">Select Category</option>
                                    <option value="Retail" {{ old('category', $business->category ?? '') == 'Retail' ? 'selected' : '' }}>Retail</option>
                                    <option value="Wholesale" {{ old('category', $business->category ?? '') == 'Wholesale' ? 'selected' : '' }}>Wholesale</option>
                                    <option value="E-commerce" {{ old('category', $business->category ?? '') == 'E-commerce' ? 'selected' : '' }}>E-commerce</option>
                                    <option value="Services" {{ old('category', $business->category ?? '') == 'Services' ? 'selected' : '' }}>Services</option>
                                    <option value="Manufacturing" {{ old('category', $business->category ?? '') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                                    <option value="Food & Beverage" {{ old('category', $business->category ?? '') == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                                    <option value="Technology" {{ old('category', $business->category ?? '') == 'Technology' ? 'selected' : '' }}>Technology</option>
                                    <option value="Consulting" {{ old('category', $business->category ?? '') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                                    <option value="Other" {{ old('category', $business->category ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
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
                                    Business Address
                                </label>
                                <textarea class="form-control radius-8 @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3" 
                                          placeholder="Enter complete business address">{{ old('address', $business->address ?? '') }}</textarea>
                                @error('address')
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

