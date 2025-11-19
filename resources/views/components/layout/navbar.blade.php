<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <i class="bi bi-list icon text-2xl non-active"></i>
                    <i class="bi bi-arrow-right icon text-2xl active"></i>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <i class="bi bi-list icon"></i>
                </button>
                <form class="navbar-search">
                    <input type="text" name="search" placeholder="Search">
                    <i class="bi bi-search icon"></i>
                </form>
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <!-- Theme Toggle -->
                <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                <!-- Business Info -->
                @if(auth()->check() && auth()->user()->business)
                <div class="d-flex align-items-center gap-2 bg-neutral-50 px-3 py-2 rounded-pill d-none d-md-flex">
                    <i class="bi bi-building text-primary-600 text-xl"></i>
                    <span class="text-sm fw-semibold">{{ auth()->user()->business->name }}</span>
                </div>
                @endif

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell text-primary-light text-xl"></i>
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                        <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                            </div>
                            <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">0</span>
                        </div>

                        <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                            <div class="text-center py-5">
                                <i class="bi bi-bell-slash text-xxl text-secondary-light"></i>
                                <p class="text-secondary-light mt-2">No notifications yet</p>
                            </div>
                        </div>
                    </div>
                </div><!-- Notification dropdown end -->

                <!-- User Profile -->
                <div class="dropdown" id="user-dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle border-2 border-primary-600 p-2 hover-shadow-lg transition" type="button" onclick="toggleUserDropdown(event)" id="user-dropdown-btn" aria-expanded="false">
                        <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/user.png') }}" alt="{{ auth()->user()->name }}" class="w-40-px h-40-px object-fit-cover rounded-circle" id="navbarAvatar">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end to-top dropdown-menu-sm" id="user-dropdown-menu" style="display: none;">
                        <!-- User Info Header -->
                        <div class="px-20 py-16 border-bottom">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="position-relative">
                                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('assets/images/user.png') }}" 
                                         alt="{{ auth()->user()->name }}" 
                                         class="w-48-px h-48-px object-fit-cover rounded-circle border border-2 border-primary-100">
                                    <span class="position-absolute bottom-0 end-0 w-12-px h-12-px bg-success-600 rounded-circle border border-2 border-white status-indicator"></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="text-md fw-bold mb-1 text-dark">{{ auth()->user()->name }}</h6>
                                    <span class="badge bg-primary-50 text-primary-600 px-8 py-4 radius-4 text-xs fw-medium d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-shield-check text-sm"></i>
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </div>
                            </div>
                            @if(auth()->user()->email)
                            <div class="d-flex align-items-center gap-2 px-2">
                                <i class="bi bi-envelope text-secondary-light text-lg"></i>
                                <span class="text-secondary-light text-xs">{{ auth()->user()->email }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Menu Items -->
                        <ul class="to-top-list px-12 py-12">
                            <li class="mb-4">
                                <a class="dropdown-item text-dark px-12 py-10 hover-bg-primary-50 hover-text-primary d-flex align-items-center gap-3 radius-8 transition fw-medium" href="{{ route('profile.index') }}">
                                    <div class="w-32-px h-32-px bg-primary-50 text-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person text-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-sm d-block">My Profile</span>
                                    </div>
                                    <i class="bi bi-arrow-right text-lg text-secondary-light"></i>
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                            <li class="mb-4">
                                <a class="dropdown-item text-dark px-12 py-10 hover-bg-primary-50 hover-text-primary d-flex align-items-center gap-3 radius-8 transition fw-medium" href="{{ route('settings.config.index') }}">
                                    <div class="w-32-px h-32-px bg-primary-50 text-primary-600 rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-gear text-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="text-sm d-block">Settings</span>
                                    </div>
                                    <i class="bi bi-arrow-right text-lg text-secondary-light"></i>
                                </a>
                            </li>
                            @endif
                        </ul>

                        <!-- Logout Section -->
                        <div class="border-top px-12 py-12">
                            <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="dropdown-item text-danger-600 px-12 py-10 hover-bg-danger-50 d-flex align-items-center gap-3 radius-8 transition w-100 border-0 bg-transparent fw-semibold">
                                    <div class="w-32-px h-32-px bg-danger-50 text-danger-600 rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-box-arrow-right text-lg"></i>
                                    </div>
                                    <span class="text-sm">Log Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div><!-- Profile dropdown end -->
            </div>
        </div>
    </div>
</div>

<style>
    /* User Profile Dropdown Enhancements */
    #user-dropdown {
        position: relative;
    }
    
    #user-dropdown-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        z-index: 9999;
        min-width: 300px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 0;
        border: 1px solid #e5e7eb;
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.2s ease-out, transform 0.2s ease-out;
        pointer-events: none;
    }
    
    #user-dropdown-menu[style*="display: block"] {
        display: block !important;
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
    
    #user-dropdown-menu[style*="display: none"] {
        display: none !important;
    }
    
    .dropdown-menu-end {
        right: 0 !important;
        left: auto !important;
    }
    
    .hover-shadow-lg:hover {
        box-shadow: 0 6px 16px rgba(72, 127, 255, 0.35);
        transform: scale(1.08);
        cursor: pointer;
    }
    
    #user-dropdown-btn {
        position: relative;
        transition: all 0.3s ease;
    }
    
    #user-dropdown-btn::after {
        content: '';
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 12px;
        height: 12px;
        background: #10b981;
        border: 2px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    .dropdown-item.hover-bg-danger-50:hover {
        background-color: #fef2f2;
        color: #dc3545;
    }
    
    .dropdown-item {
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.2s ease-in-out;
    }
    
    .dropdown-item:hover {
        transform: translateX(2px);
    }
    
    .w-48-px {
        width: 48px !important;
    }
    
    .h-48-px {
        height: 48px !important;
    }
    
    .w-32-px {
        width: 32px !important;
    }
    
    .h-32-px {
        height: 32px !important;
    }
    
    .w-12-px {
        width: 12px !important;
    }
    
    .h-12-px {
        height: 12px !important;
    }
    
    /* Pulsing animation for online status */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
            transform: scale(1.1);
        }
    }
    
    .status-indicator {
        animation: pulse 2s ease-in-out infinite;
    }
    
    /* Staggered fade-in animation for menu items */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    #user-dropdown-menu[style*="display: block"] .to-top-list li {
        animation: fadeInUp 0.3s ease-out backwards;
    }
    
    #user-dropdown-menu[style*="display: block"] .to-top-list li:nth-child(1) {
        animation-delay: 0.05s;
    }
    
    #user-dropdown-menu[style*="display: block"] .to-top-list li:nth-child(2) {
        animation-delay: 0.1s;
    }
    
    #user-dropdown-menu[style*="display: block"] .to-top-list li:nth-child(3) {
        animation-delay: 0.15s;
    }
    
    /* Arrow icon animation on hover */
    .dropdown-item:hover i[class*='arrow'] {
        transform: translateX(4px);
        transition: transform 0.2s ease;
    }
    
    /* Improve avatar button active state */
    #user-dropdown-btn:active {
        transform: scale(0.95);
    }
    
    #user-dropdown-btn:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(72, 127, 255, 0.2);
    }
    
    /* Mobile responsiveness */
    @media (max-width: 576px) {
        #user-dropdown-menu {
            min-width: 280px;
            right: -10px;
        }
    }
</style>

<script>
function toggleUserDropdown(event) {
    event.stopPropagation();
    const menu = document.getElementById('user-dropdown-menu');
    const btn = document.getElementById('user-dropdown-btn');
    const isVisible = menu.style.display === 'block';
    
    console.log('🔧 User dropdown clicked, current state:', isVisible ? 'VISIBLE' : 'HIDDEN');
    
    if (isVisible) {
        menu.style.display = 'none';
        btn.setAttribute('aria-expanded', 'false');
        console.log('❌ Hiding dropdown');
    } else {
        menu.style.display = 'block';
        btn.setAttribute('aria-expanded', 'true');
        console.log('✅ Showing dropdown');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('user-dropdown');
    const menu = document.getElementById('user-dropdown-menu');
    const btn = document.getElementById('user-dropdown-btn');
    
    if (dropdown && !dropdown.contains(event.target)) {
        if (menu && menu.style.display === 'block') {
            menu.style.display = 'none';
            btn.setAttribute('aria-expanded', 'false');
            console.log('🔒 Closed dropdown (clicked outside)');
        }
    }
});

// Close dropdown on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const menu = document.getElementById('user-dropdown-menu');
        const btn = document.getElementById('user-dropdown-btn');
        if (menu && menu.style.display === 'block') {
            menu.style.display = 'none';
            btn.setAttribute('aria-expanded', 'false');
            btn.focus();
            console.log('⌨️ Closed dropdown (Escape key)');
        }
    }
});

function confirmLogout() {
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>

