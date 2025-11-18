<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - ArkSheets</title>
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
            height: 100vh;
            overflow: hidden;
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
        }
        .auth-container {
            display: flex;
            height: 100%;
        }
        .auth-form-section {
            flex: 1;
            padding: 40px 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            overflow: hidden;
        }
        .auth-form-section::-webkit-scrollbar {
            display: none;
        }
        .auth-form-section {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .form-card {
            width: 100%;
            max-width: 420px;
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
        .auth-announcements-section::-webkit-scrollbar {
            display: none;
        }
        .auth-announcements-section {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
        .brand-icon {
            width: 50px;
            height: 50px;
            background: #ec3737;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
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
        }
        .form-input:focus {
            outline: none;
            border-color: #ec3737;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(236, 55, 55, 0.1);
        }
        .forgot-password {
            color: #ec3737;
            font-size: 14px;
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #374151;
            margin: 20px 0 24px 0;
        }
        .btn-signin {
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
        .btn-signin:hover {
            background: #d42f2f;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(236, 55, 55, 0.4);
        }
        .signup-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #6c757d;
        }
        .signup-link a {
            color: #ec3737;
            text-decoration: none;
            font-weight: 600;
        }
        .footer-links {
            text-align: center;
            margin-top: 28px;
            font-size: 13px;
        }
        .footer-links a {
            color: #9ca3af;
            text-decoration: none;
            margin: 0 12px;
        }
        .footer-links a:hover {
            color: #ec3737;
        }
        .announcement-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .announcement-title {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 14px;
            line-height: 1.3;
        }
        .announcement-subtitle {
            font-size: 14px;
            opacity: 0.92;
            margin-bottom: 30px;
            line-height: 1.5;
        }
        .announcement-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 14px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        .announcement-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .announcement-card-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .announcement-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .announcement-card-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .announcement-card-text {
            font-size: 13px;
            opacity: 0.95;
            line-height: 1.5;
            margin-bottom: 8px;
        }
        .announcement-time {
            font-size: 12px;
            opacity: 0.75;
        }
        @media (max-width: 992px) {
            body {
                padding: 20px;
            }
            .auth-container {
                flex-direction: column;
            }
            .auth-form-section,
            .auth-announcements-section {
                padding: 40px 32px;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <div class="auth-container">
            <!-- Left Side - Form -->
            <div class="auth-form-section">
                <div class="form-card">
                <div class="brand-icon">
                    <iconify-icon icon="mdi:shield-check" style="font-size: 28px; color: white;"></iconify-icon>
                </div>
                    
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Sign in to continue to your account</p>

                @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    {{ session('error') }}
                </div>
                @endif

                @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" 
                               class="form-input" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="Enter your email" 
                               required>
                    </div>

                    <div class="form-group" style="margin-bottom: 12px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label class="form-label" style="margin-bottom: 0;">Password</label>
                            <a href="javascript:void(0)" class="forgot-password">Forgot Password?</a>
                        </div>
                        <input type="password" 
                               class="form-input" 
                               name="password" 
                               id="password"
                               placeholder="Enter your password" 
                               required>
                    </div>

                    <label class="remember-me">
                        <input type="checkbox" name="remember" style="width: 16px; height: 16px;">
                        <span>Keep me signed in</span>
                    </label>

                    <button type="submit" class="btn-signin">Sign In</button>

                    <div class="signup-link">
                        Don't have an account? <a href="{{ route('register') }}">Create Account</a>
                    </div>

                    <div class="footer-links">
                        <a href="javascript:void(0)">Privacy</a>
                        <a href="javascript:void(0)">Terms</a>
                        <a href="javascript:void(0)">Help</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side - Announcements -->
        <div class="auth-announcements-section">
            <div class="announcements-container">
                <div class="announcement-badge">
                    <iconify-icon icon="mdi:bell" style="font-size: 16px;"></iconify-icon>
                    Announcements
                </div>

                <h2 class="announcement-title">Stay Updated with Latest News</h2>
                <p class="announcement-subtitle">Get real-time updates, important announcements, and system notifications right here.</p>

                <div class="announcement-card">
                    <div class="announcement-card-header">
                        <div class="announcement-icon">
                            <iconify-icon icon="mdi:information-outline" style="font-size: 24px; color: white;"></iconify-icon>
                        </div>
                        <div style="flex: 1;">
                            <div class="announcement-card-title">System Update</div>
                            <div class="announcement-card-text">New features and improvements are now available. Check out what's new!</div>
                            <div class="announcement-time">2 hours ago</div>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-card-header">
                        <div class="announcement-icon">
                            <iconify-icon icon="mdi:shield-lock" style="font-size: 24px; color: white;"></iconify-icon>
                        </div>
                        <div style="flex: 1;">
                            <div class="announcement-card-title">Security Enhancement</div>
                            <div class="announcement-card-text">Two-factor authentication is now available for enhanced security.</div>
                            <div class="announcement-time">1 day ago</div>
                        </div>
                    </div>
                </div>

                <div class="announcement-card">
                    <div class="announcement-card-header">
                        <div class="announcement-icon">
                            <iconify-icon icon="mdi:star-circle" style="font-size: 24px; color: white;"></iconify-icon>
                        </div>
                        <div style="flex: 1;">
                            <div class="announcement-card-title">New Features</div>
                            <div class="announcement-card-text">Explore our new dashboard with improved analytics and reporting tools.</div>
                            <div class="announcement-time">3 days ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
</body>
</html>
