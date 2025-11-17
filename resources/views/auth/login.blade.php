<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ArkSheets</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        /* Custom Red Branding */
        .auth-left {
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
        }
        .brand-title {
            color: #ec3737;
            font-weight: 700;
        }
        .btn-brand {
            background-color: #ec3737;
            border-color: #ec3737;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-brand:hover {
            background-color: #d42f2f;
            border-color: #d42f2f;
            color: #fff;
        }
        .btn-outline-brand {
            background-color: transparent;
            border: 1.5px solid #ec3737;
            color: #ec3737;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-outline-brand:hover {
            background-color: #fff5f5;
            border-color: #ec3737;
            color: #ec3737;
        }
        .form-control:focus {
            border-color: #ec3737;
            box-shadow: 0 0 0 0.2rem rgba(236, 55, 55, 0.15);
        }
        .text-brand {
            color: #ec3737;
        }
        .auth-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body style="background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);">
    <section class="auth d-flex flex-wrap min-vh-100">
        <div class="auth-left d-lg-flex d-none flex-column align-items-center justify-content-center p-5" style="flex: 0 0 40%; max-width: 40%;">
            <div class="text-center text-white">
                <div class="mb-5">
                    <iconify-icon icon="mdi:office-building" style="font-size: 120px; opacity: 0.9;"></iconify-icon>
                </div>
                <h2 class="fw-bold mb-3">Welcome to ArkSheets</h2>
                <p class="fs-5 opacity-90">Your Complete Business Management Solution</p>
                <div class="mt-5 d-flex flex-column gap-3 text-start" style="max-width: 400px;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2" style="width: 48px; height: 48px;">
                            <iconify-icon icon="mdi:chart-line" style="font-size: 32px;"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Track Sales & Revenue</h6>
                            <small class="opacity-75">Monitor your business performance</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2" style="width: 48px; height: 48px;">
                            <iconify-icon icon="mdi:package-variant" style="font-size: 32px;"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Manage Inventory</h6>
                            <small class="opacity-75">Keep track of stock levels</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white bg-opacity-25 rounded-circle p-2" style="width: 48px; height: 48px;">
                            <iconify-icon icon="mdi:account-group" style="font-size: 32px;"></iconify-icon>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Customer Management</h6>
                            <small class="opacity-75">Build strong relationships</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="auth-right d-flex flex-column justify-content-center align-items-center p-4" style="flex: 1; min-height: 100vh;">
            <div class="max-w-464-px mx-auto w-100">
                <div class="mb-4">
                    <a href="{{ url('/') }}" class="d-inline-block mb-4">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="ArkSheets Logo" style="max-width: 180px;">
                    </a>
                    <h3 class="mb-2 brand-title">Sign In</h3>
                    <p class="mb-4 text-secondary-light">Welcome back! Please enter your credentials</p>
                </div>

                @if(session('success'))
                <div class="alert alert-success border-0 radius-8 mb-3" style="background-color: #f0fdf4; border-left: 4px solid #22c55e !important;">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:check-circle" style="font-size: 24px; color: #22c55e;"></iconify-icon>
                        <span style="color: #166534;">{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger border-0 radius-8 mb-3" style="background-color: #fef2f2; border-left: 4px solid #ec3737 !important;">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:alert-circle" style="font-size: 24px; color: #ec3737;"></iconify-icon>
                        <span style="color: #dc2626;">{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger border-0 radius-8 mb-3" style="background-color: #fef2f2; border-left: 4px solid #ec3737 !important;">
                    <div class="d-flex align-items-start gap-2">
                        <iconify-icon icon="mdi:alert-circle" style="font-size: 24px; color: #ec3737;"></iconify-icon>
                        <div style="color: #dc2626;">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="auth-card p-4">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-primary-light">Email Address</label>
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y" style="color: #ec3737;">
                                <iconify-icon icon="mdi:email-outline" style="font-size: 20px;"></iconify-icon>
                            </span>
                            <input type="email" class="form-control h-56-px radius-8 @error('email') is-invalid @enderror" 
                                   id="email"
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Enter your email" 
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="your-password" class="form-label fw-semibold text-primary-light">Password</label>
                        <div class="position-relative">
                            <div class="icon-field">
                                <span class="icon top-50 translate-middle-y" style="color: #ec3737;">
                                    <iconify-icon icon="mdi:lock-outline" style="font-size: 20px;"></iconify-icon>
                                </span>
                                <input type="password" class="form-control h-56-px radius-8 @error('password') is-invalid @enderror" 
                                       id="your-password" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required>
                            </div>
                            <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        <a href="javascript:void(0)" class="text-brand fw-medium text-decoration-none">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn btn-brand text-sm px-12 py-12 w-100 radius-8 shadow-sm">
                        <iconify-icon icon="mdi:login" class="me-2" style="font-size: 20px;"></iconify-icon>
                        Sign In
                    </button>

                    <div class="mt-4 text-center">
                        <span class="text-secondary-light">Don't have an account?</span>
                        <a href="{{ route('register') }}" class="text-brand fw-semibold text-decoration-none ms-1">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        // Password Show Hide Js
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
        initializePasswordToggle(".toggle-password");
    </script>
</body>
</html>

