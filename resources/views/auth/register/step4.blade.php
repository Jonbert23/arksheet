<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Business Account - Step 4 | ArkSheets</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -15%;
            right: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            z-index: 0;
        }
        .page-container {
            width: 90%;
            max-width: 1200px;
            background: #ffffff;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            height: 85vh;
            max-height: 700px;
            position: relative;
            z-index: 1;
            margin: 40px 0;
        }
        .auth-container {
            display: flex;
            height: 100%;
        }
        .auth-form-section {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            background: #ffffff;
            overflow-y: auto;
            overflow-x: hidden;
        }
        .auth-form-section::-webkit-scrollbar {
            width: 6px;
        }
        .auth-form-section::-webkit-scrollbar-thumb {
            background: #e0e0e0;
            border-radius: 3px;
        }
        .auth-form-section::-webkit-scrollbar-track {
            background: #f9fafb;
        }
        .form-card {
            width: 100%;
            max-width: 420px;
            padding: 20px 0;
        }
        .auth-announcements-section {
            flex: 1;
            padding: 40px 50px;
            background: linear-gradient(135deg, #ec3737 0%, #d42f2f 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .auth-announcements-section::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -15%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        .announcements-container {
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 1;
        }
        .auth-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .auth-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 18px;
            width: 100%;
        }
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            padding: 13px 16px;
            font-size: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .form-input:focus {
            outline: none;
            border-color: #ec3737;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1);
        }
        .btn-primary {
            width: 100%;
            padding: 14px;
            background: #ec3737;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: #d42f2f;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4);
        }
        .logo-upload {
            width: 100px;
            height: 100px;
            border: 2px dashed #e5e7eb;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #f9fafb;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .logo-upload:hover {
            border-color: #ec3737;
            background: #fef2f2;
        }
        .logo-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .payment-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .payment-checkbox:hover {
            border-color: #ec3737;
            background: #fef2f2;
        }
        .payment-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #ec3737;
        }
        @media (max-width: 768px) {
            .auth-announcements-section {
                display: none;
            }
            .page-container {
                max-height: none;
            }
        }
    </style>
</head>
<body>

    <div class="page-container">
        <div class="auth-container">
            {{-- Announcements Section --}}
            <div class="auth-announcements-section">
                <div class="announcements-container">
                    <div class="announcement-badge">
                        <i class="bi bi-circle-fill"></i>
                        Final Step!
                    </div>
                    
                    <h2 class="announcement-title">You're Almost Done!</h2>
                    <p class="announcement-subtitle">Add your business logo and customize your operating hours to complete your registration and get started.</p>

                    <div style="margin-top: 32px;">
                        <div class="progress-step-item" style="opacity: 0.6;">
                            <div class="step-number">✓</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Business Information</div>
                                <div style="font-size: 13px; opacity: 0.85;">Completed</div>
                            </div>
                        </div>

                        <div class="progress-step-item" style="opacity: 0.6;">
                            <div class="step-number">✓</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Owner Account</div>
                                <div style="font-size: 13px; opacity: 0.85;">Completed</div>
                            </div>
                        </div>

                        <div class="progress-step-item" style="opacity: 0.6;">
                            <div class="step-number">✓</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Business Location</div>
                                <div style="font-size: 13px; opacity: 0.85;">Completed</div>
                            </div>
                        </div>

                        <div class="progress-step-item active">
                            <div class="step-number">4</div>
                            <div>
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 2px;">Finalize Setup</div>
                                <div style="font-size: 13px; opacity: 0.85;">Customize your preferences</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Section --}}
            <div class="auth-form-section">
                <div class="form-card">
                    {{-- Header --}}
                    <div style="text-align: center; margin-bottom: 32px;">
                        <h1 class="auth-title">Finalize Your Setup</h1>
                        <p class="auth-subtitle">Customize your business (optional - you can skip this)</p>
                    </div>

                    {{-- Progress --}}
                    @include('auth.register.progress', ['currentStep' => 4])

                    {{-- Alerts --}}
                    @if ($errors->any() || session('error'))
                        <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 16px; margin-bottom: 20px;">
                            <div style="display: flex; align-items-start; gap: 10px;">
                                <i class="bi bi-circle-fill"></i>
                                <div style="flex: 1;">
                                    @if($errors->any())
                                        <strong style="color: #991b1b; font-size: 14px;">Please fix the following errors:</strong>
                                        <ul style="margin: 8px 0 0 0; padding-left: 20px; color: #991b1b; font-size: 13px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                    @if(session('error'))
                                        <div style="color: #991b1b; font-size: 13px;">{{ session('error') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('register.complete') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Logo Upload --}}
                        <div class="form-group">
                            <label class="form-label">Business Logo</label>
                            <div style="display: flex; align-items: center; gap: 16px;">
                                <div class="logo-upload">
                                    <img id="logo-preview" alt="Logo Preview">
                                    <label for="logo" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%; height: 100%; cursor: pointer; padding: 10px;">
                                        <i class="bi bi-circle-fill"></i>
                                        <span style="font-size: 11px; color: #9ca3af; margin-top: 6px;">Upload</span>
                                    </label>
                                    <input type="file" id="logo" name="logo" accept="image/*" hidden onchange="previewLogo(this)">
                                </div>
                                <div>
                                    <p style="margin: 0 0 4px 0; font-size: 14px; font-weight: 500; color: #374151;">Upload Your Logo</p>
                                    <p style="margin: 0; font-size: 13px; color: #6b7280;">Max: 2MB (JPG, PNG)</p>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            {{-- Business Hours --}}
                            <div class="form-group">
                                <label for="business_hours" class="form-label">Business Hours</label>
                                <input type="text" class="form-input" id="business_hours" name="business_hours" value="{{ old('business_hours') }}" placeholder="e.g., Mon-Fri: 9AM-6PM">
                                <small style="color: #6b7280; font-size: 13px; display: block; margin-top: 6px;">Shown on invoices</small>
                            </div>

                            {{-- Product Categories --}}
                            <div class="form-group">
                                <label for="product_categories" class="form-label">Product Categories</label>
                                <input type="text" class="form-input" id="product_categories" name="product_categories" value="{{ old('product_categories') }}" placeholder="e.g., Electronics, Clothing">
                                <small style="color: #6b7280; font-size: 13px; display: block; margin-top: 6px;">Separate with commas</small>
                            </div>
                        </div>

                        {{-- Payment Methods --}}
                        <div class="form-group">
                            <label class="form-label">Payment Methods</label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 10px;">
                                <label class="payment-checkbox">
                                    <input type="checkbox" name="payment_methods[]" value="Cash" checked>
                                    <i class="bi bi-circle-fill"></i>
                                    <span style="font-size: 14px; color: #374151;">Cash</span>
                                </label>
                                <label class="payment-checkbox">
                                    <input type="checkbox" name="payment_methods[]" value="Credit/Debit Card">
                                    <i class="bi bi-circle-fill"></i>
                                    <span style="font-size: 14px; color: #374151;">Card</span>
                                </label>
                                <label class="payment-checkbox">
                                    <input type="checkbox" name="payment_methods[]" value="Bank Transfer">
                                    <i class="bi bi-circle-fill"></i>
                                    <span style="font-size: 14px; color: #374151;">Bank</span>
                                </label>
                                <label class="payment-checkbox">
                                    <input type="checkbox" name="payment_methods[]" value="Mobile Money">
                                    <i class="bi bi-circle-fill"></i>
                                    <span style="font-size: 14px; color: #374151;">Mobile</span>
                                </label>
                            </div>
                        </div>

                        {{-- Info Box --}}
                        <div style="background: #e8f4fd; border: 1px solid #b8dff5; border-radius: 8px; padding: 12px 14px; margin: 20px 0; display: flex; align-items-start; gap: 10px;">
                            <i class="bi bi-circle-fill"></i>
                            <small style="color: #0c5ba0; font-size: 13px;"><strong>Note:</strong> All these settings can be changed later from your dashboard.</small>
                        </div>

                        <button type="submit" class="btn-primary" style="margin-top: 24px;">
                            <i class="bi bi-circle-fill"></i>
                            Complete Setup & Start
                        </button>

                        <div style="text-align: center; margin-top: 20px; font-size: 14px; color: #6c757d;">
                            Already have an account? <a href="{{ route('login') }}" style="color: #ec3737; text-decoration: none; font-weight: 600;">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('logo-preview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    input.parentElement.querySelector('label').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
