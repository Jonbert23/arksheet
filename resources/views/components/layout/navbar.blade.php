<div class="navbar-header">
    <div class="row align-items-center justify-content-between">
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-4">
                <button type="button" class="sidebar-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                    <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                </button>
                <button type="button" class="sidebar-mobile-toggle">
                    <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                </button>
                <form class="navbar-search">
                    <input type="text" name="search" placeholder="Search">
                    <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
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
                    <iconify-icon icon="mdi:office-building" class="text-primary-600 text-xl"></iconify-icon>
                    <span class="text-sm fw-semibold">{{ auth()->user()->business->name }}</span>
                </div>
                @endif

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                        <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
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
                                <iconify-icon icon="mdi:bell-off-outline" class="text-xxl text-secondary-light"></iconify-icon>
                                <p class="text-secondary-light mt-2">No notifications yet</p>
                            </div>
                        </div>
                    </div>
                </div><!-- Notification dropdown end -->

                <!-- User Profile -->
                <div class="dropdown" id="user-dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle border-2 border-primary-600 p-2 hover-shadow-lg transition" type="button" onclick="toggleUserDropdown(event)" id="user-dropdown-btn" aria-expanded="false">
                        <img src="{{ auth()->user()->avatar ?? asset('assets/images/user.png') }}" alt="{{ auth()->user()->name }}" class="w-40-px h-40-px object-fit-cover rounded-circle">
                    </button>
                    <div class="dropdown-menu dropdown-menu-end to-top dropdown-menu-sm" id="user-dropdown-menu" style="display: none;">
                        <div class="py-12 px-16 radius-8 bg-gradient-start-1 mb-16 d-flex align-items-center justify-content-between gap-2">
                            <div>
                                <h6 class="text-lg fw-semibold mb-1">{{ auth()->user()->name }}</h6>
                                <span class="text-secondary-light fw-medium text-sm d-flex align-items-center gap-1">
                                    <iconify-icon icon="mdi:shield-account" class="text-xs"></iconify-icon>
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                                @if(auth()->user()->email)
                                <span class="text-secondary-light text-xs d-block mt-1">{{ auth()->user()->email }}</span>
                                @endif
                            </div>
                        </div>
                        <ul class="to-top-list">
                            <li>
                                <a class="dropdown-item text-black px-16 py-10 hover-bg-primary-50 hover-text-primary d-flex align-items-center gap-3 radius-8 transition" href="javascript:void(0)">
                                    <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> 
                                    <span>My Profile</span>
                                    <span class="badge bg-info-100 text-info-600 text-xs ms-auto">Soon</span>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-16 py-10 hover-bg-primary-50 hover-text-primary d-flex align-items-center gap-3 radius-8 transition" href="javascript:void(0)">
                                    <iconify-icon icon="tabler:settings" class="icon text-xl"></iconify-icon> 
                                    <span>Settings</span>
                                    <span class="badge bg-info-100 text-info-600 text-xs ms-auto">Soon</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-8"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()" class="dropdown-item text-danger-600 px-16 py-10 hover-bg-danger-50 d-flex align-items-center gap-3 radius-8 transition w-100 border-0 bg-transparent">
                                        <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> 
                                        <span class="fw-semibold">Log Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
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
        min-width: 280px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        padding: 16px;
    }
    
    #user-dropdown-menu[style*="display: block"] {
        display: block !important;
    }
    
    #user-dropdown-menu[style*="display: none"] {
        display: none !important;
    }
    
    .dropdown-menu-end {
        right: 0 !important;
        left: auto !important;
    }
    
    .hover-shadow-lg:hover {
        box-shadow: 0 4px 12px rgba(72, 127, 255, 0.3);
        transform: scale(1.05);
        cursor: pointer;
    }
    
    .transition {
        transition: all 0.2s ease-in-out;
    }
    
    .dropdown-item.hover-bg-danger-50:hover {
        background-color: #fee;
        color: #dc3545;
    }
    
    .dropdown-item {
        cursor: pointer;
        text-decoration: none;
    }
</style>

<script>
function toggleUserDropdown(event) {
    event.stopPropagation();
    const menu = document.getElementById('user-dropdown-menu');
    const isVisible = menu.style.display === 'block';
    
    console.log('🔧 User dropdown clicked, current state:', isVisible ? 'VISIBLE' : 'HIDDEN');
    
    if (isVisible) {
        menu.style.display = 'none';
        console.log('❌ Hiding dropdown');
    } else {
        menu.style.display = 'block';
        console.log('✅ Showing dropdown');
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('user-dropdown');
    const menu = document.getElementById('user-dropdown-menu');
    
    if (dropdown && !dropdown.contains(event.target)) {
        if (menu && menu.style.display === 'block') {
            menu.style.display = 'none';
            console.log('🔒 Closed dropdown (clicked outside)');
        }
    }
});

function confirmLogout() {
    if (confirm('Are you sure you want to log out?')) {
        document.getElementById('logout-form').submit();
    }
}
</script>

