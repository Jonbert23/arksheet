<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <i class="bi bi-x-lg"></i>
    </button>
    <div>
        <!-- Logo -->
        <a href="{{ route('super-admin.dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            
            <!-- Dashboard -->
            <li>
                <a href="{{ route('super-admin.dashboard') }}" class="{{ request()->routeIs('super-admin.dashboard') ? 'active-page' : '' }}">
                    <i class="bi bi-house menu-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Business Management -->
            <li>
                <a href="{{ route('super-admin.businesses.index') }}" class="{{ request()->routeIs('super-admin.businesses.*') ? 'active-page' : '' }}">
                    <i class="bi bi-building menu-icon"></i>
                    <span>Businesses</span>
                </a>
            </li>

            <!-- User Management -->
            <li>
                <a href="{{ route('super-admin.users.index') }}" class="{{ request()->routeIs('super-admin.users.*') ? 'active-page' : '' }}">
                    <i class="bi bi-people menu-icon"></i>
                    <span>Users</span>
                </a>
            </li>

            <!-- Reports -->
            <li class="dropdown {{ request()->routeIs('super-admin.reports.*') ? 'open' : '' }}" id="reports-dropdown">
                <a href="#" onclick="toggleDropdown(event, 'reports-dropdown')" class="{{ request()->routeIs('super-admin.reports.*') ? 'active-page' : '' }}">
                    <i class="bi bi-graph-up menu-icon"></i>
                    <span>Reports</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('super-admin.reports.*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('super-admin.reports.index') }}" class="{{ request()->routeIs('super-admin.reports.index') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Overview
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('super-admin.reports.revenue') }}" class="{{ request()->routeIs('super-admin.reports.revenue') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Revenue Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('super-admin.reports.usage') }}" class="{{ request()->routeIs('super-admin.reports.usage') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Usage Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('super-admin.reports.growth') }}" class="{{ request()->routeIs('super-admin.reports.growth') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Growth Report
                        </a>
                    </li>
                </ul>
            </li>

            <!-- System Settings -->
            <li class="dropdown {{ request()->routeIs('super-admin.system.*') ? 'open' : '' }}" id="system-dropdown">
                <a href="#" onclick="toggleDropdown(event, 'system-dropdown')" class="{{ request()->routeIs('super-admin.system.*') ? 'active-page' : '' }}">
                    <i class="bi bi-gear menu-icon"></i>
                    <span>System</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('super-admin.system.*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('super-admin.system.settings') }}" class="{{ request()->routeIs('super-admin.system.settings') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('super-admin.system.logs') }}" class="{{ request()->routeIs('super-admin.system.logs') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> System Logs
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Divider -->
            <li class="sidebar-menu-group-title">Quick Actions</li>

            <!-- Cache Management -->
            <li>
                <form method="POST" action="{{ route('super-admin.system.clear-cache') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="sidebar-link-btn">
                        <i class="bi bi-arrow-clockwise menu-icon"></i>
                        <span>Clear Cache</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>

<script>
function toggleDropdown(event, dropdownId) {
    event.preventDefault();
    console.log('🎯 Dropdown clicked:', dropdownId);
    
    const dropdown = document.getElementById(dropdownId);
    const submenu = dropdown.querySelector('.sidebar-submenu');
    
    // Close all other dropdowns
    document.querySelectorAll('.sidebar-menu .dropdown').forEach(function(item) {
        if (item.id !== dropdownId) {
            const otherSubmenu = item.querySelector('.sidebar-submenu');
            if (otherSubmenu) {
                otherSubmenu.style.display = 'none';
            }
            item.classList.remove('open', 'dropdown-open');
        }
    });
    
    // Toggle current dropdown
    if (submenu.style.display === 'none' || submenu.style.display === '') {
        submenu.style.display = 'block';
        dropdown.classList.add('open', 'dropdown-open');
        console.log('✅ Opened:', dropdownId);
    } else {
        submenu.style.display = 'none';
        dropdown.classList.remove('open', 'dropdown-open');
        console.log('❌ Closed:', dropdownId);
    }
}
</script>

<style>
.sidebar-link-btn {
    width: 100%;
    background: none;
    border: none;
    padding: 12px 20px;
    text-align: left;
    display: flex;
    align-items: center;
    gap: 12px;
    color: inherit;
    cursor: pointer;
    transition: all 0.3s;
}

.sidebar-link-btn:hover {
    background-color: rgba(99, 102, 241, 0.1);
    color: #6366f1;
}

.avatar-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}
</style>

