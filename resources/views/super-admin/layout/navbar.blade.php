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
            </div>
        </div>
        <div class="col-auto">
            <div class="d-flex flex-wrap align-items-center gap-3">
                
                <!-- Super Admin Badge -->
                <span class="badge bg-danger-600 text-white px-3 py-2">
                    <i class="fas fa-shield-alt me-1"></i> SUPER ADMIN
                </span>

                <!-- Theme Toggle -->
                <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                        <iconify-icon icon="mage:email" class="text-primary-light text-xl"></iconify-icon>
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-end">
                        <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                            <div class="text-center py-4">
                                <p class="text-secondary-light mb-0">No new notifications</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
                        <div class="avatar-circle bg-primary-600 text-white">
                            <span>{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                        </div>
                    </button>
                    <div class="dropdown-menu to-top dropdown-menu-end">
                        <div class="dropdown-menu-header">
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary-600 text-white me-3">
                                    <span>{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                                </div>
                                <div>
                                    <h6 class="text-md text-neutral-900 fw-semibold mb-0">{{ auth()->user()->name }}</h6>
                                    <span class="text-sm text-secondary-light fw-medium">Super Administrator</span>
                                </div>
                            </div>
                        </div>
                        <ul class="to-top-list">
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="{{ route('super-admin.dashboard') }}">
                                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-xl"></iconify-icon> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="{{ route('super-admin.system.settings') }}">
                                    <iconify-icon icon="solar:settings-outline" class="icon text-xl"></iconify-icon> System Settings
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3">
                                        <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

