<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<x-head/>

<body>

    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="{{ asset('assets/images/auth/auth-img.png') }}" alt="">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <a href="{{ route('login') }}" class="mb-40 max-w-290-px">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="">
                    </a>
                    <h4 class="mb-12">Create Your Business Account</h4>
                    <p class="mb-32 text-secondary-light text-lg">Start managing your business with ArkSheets</p>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <!-- Business Information -->
                    <div class="mb-20">
                        <h6 class="text-md mb-16">Business Information</h6>
                        
                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mdi:office-building"></iconify-icon>
                            </span>
                            <input type="text" name="business_name" class="form-control h-56-px bg-neutral-50 radius-12 @error('business_name') is-invalid @enderror" placeholder="Business Name *" value="{{ old('business_name') }}" required>
                        </div>
                        @error('business_name')
                            <span class="text-danger text-sm mb-8 d-block">{{ $message }}</span>
                        @enderror

                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mdi:tag"></iconify-icon>
                            </span>
                            <input type="text" name="business_category" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Business Category (e.g. Software, Retail)" value="{{ old('business_category') }}">
                        </div>

                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mdi:account-tie"></iconify-icon>
                            </span>
                            <input type="text" name="founder" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Founder Name" value="{{ old('founder') }}">
                        </div>

                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mdi:calendar"></iconify-icon>
                            </span>
                            <input type="date" name="date_founded" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Date Founded" value="{{ old('date_founded', date('Y-m-d')) }}">
                        </div>
                    </div>

                    <!-- User Information -->
                    <div class="mb-20">
                        <h6 class="text-md mb-16">Admin User Information</h6>
                        
                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="f7:person"></iconify-icon>
                            </span>
                            <input type="text" name="name" class="form-control h-56-px bg-neutral-50 radius-12 @error('name') is-invalid @enderror" placeholder="Your Name *" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <span class="text-danger text-sm mb-8 d-block">{{ $message }}</span>
                        @enderror

                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="email" name="email" class="form-control h-56-px bg-neutral-50 radius-12 @error('email') is-invalid @enderror" placeholder="Email Address *" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <span class="text-danger text-sm mb-8 d-block">{{ $message }}</span>
                        @enderror

                        <div class="icon-field mb-16">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="mdi:phone"></iconify-icon>
                            </span>
                            <input type="text" name="phone" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Phone Number" value="{{ old('phone') }}">
                        </div>

                        <div class="mb-16">
                            <div class="position-relative">
                                <div class="icon-field">
                                    <span class="icon top-50 translate-middle-y">
                                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                    </span>
                                    <input type="password" name="password" class="form-control h-56-px bg-neutral-50 radius-12 @error('password') is-invalid @enderror" id="your-password" placeholder="Password *" required>
                                </div>
                                <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                            </div>
                            @error('password')
                                <span class="text-danger text-sm mt-8 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-20">
                            <div class="position-relative">
                                <div class="icon-field">
                                    <span class="icon top-50 translate-middle-y">
                                        <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                                    </span>
                                    <input type="password" name="password_confirmation" class="form-control h-56-px bg-neutral-50 radius-12" id="confirm-password" placeholder="Confirm Password *" required>
                                </div>
                                <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#confirm-password"></span>
                            </div>
                            <span class="mt-12 text-sm text-secondary-light d-block">Your password must have at least 8 characters</span>
                        </div>
                    </div>

                    <div class="mb-20">
                        <div class="form-check style-check d-flex align-items-start">
                            <input class="form-check-input border border-neutral-300 mt-4" type="checkbox" value="" id="condition" required>
                            <label class="form-check-label text-sm" for="condition">
                                By creating an account you agree to the
                                <a href="javascript:void(0)" class="text-primary-600 fw-semibold">Terms & Conditions</a> and 
                                <a href="javascript:void(0)" class="text-primary-600 fw-semibold">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Create Business Account</button>

                    <div class="mt-32 text-center text-sm">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary-600 fw-semibold">Sign In</a></p>
                    </div>

                </form>
            </div>
        </div>
    </section>

@php
    $script = '<script>
        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on("click", function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle(".toggle-password");
        // ========================= Password Show Hide Js End ===========================
    </script>';
@endphp

<x-script/>
{!! $script !!}

</body>

</html>
