<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('dashboard') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/craphify-logo-1 copy (1).png') }}" alt="Craphify Logo" class="light-logo" style="width: 168px; height: 40px; object-fit: contain;">
            <img src="{{ asset('assets/images/craphify-logo-1 copy (1).png') }}" alt="Craphify Logo" class="dark-logo" style="width: 168px; height: 40px; object-fit: contain;">
            <img src="{{ asset('assets/images/craphify-logo-1 copy (1).png') }}" alt="Craphify Logo" class="logo-icon" style="width: 168px; height: 40px; object-fit: contain;">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            
            <!-- Dashboard -->
            @if(auth()->user()->hasModuleAccess('dashboard'))
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active-page' : '' }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            @endif

            <!-- Products Section -->
            @if(auth()->user()->hasAnyModuleAccess(['products', 'stock']))
            <li class="sidebar-menu-group-title">Inventory</li>
            @endif
            
            @if(auth()->user()->hasModuleAccess('products'))
            <li class="dropdown {{ request()->routeIs('products.*') ? 'open' : '' }}" id="products-dropdown">
                <a href="#" onclick="toggleDropdown(event, 'products-dropdown')" class="{{ request()->routeIs('products.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:package-variant" class="menu-icon"></iconify-icon>
                    <span>Products</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('products.*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            All Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Add Product
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if(auth()->user()->hasModuleAccess('stock'))
            <li class="dropdown {{ request()->routeIs('stock.*') ? 'open' : '' }}" id="stock-dropdown">
                <a href="#" onclick="toggleDropdown(event, 'stock-dropdown')" class="{{ request()->routeIs('stock.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:truck-delivery" class="menu-icon"></iconify-icon>
                    <span>Stock Management</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('stock.*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('stock.index') }}" class="{{ request()->routeIs('stock.index') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            All Stock Entries
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('stock.create') }}" class="{{ request()->routeIs('stock.create') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                            Add Stock
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Sales Section -->
            @if(auth()->user()->hasAnyModuleAccess(['sales', 'invoices', 'customers']))
            <li class="sidebar-menu-group-title">Sales</li>
            @endif

            @if(auth()->user()->hasModuleAccess('sales'))
            <li>
                <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:cart-outline" class="menu-icon"></iconify-icon>
                    <span>Sales</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasModuleAccess('invoices'))
            <li>
                <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:receipt-text" class="menu-icon"></iconify-icon>
                    <span>Invoices</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasModuleAccess('customers'))
            <li>
                <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:account-group" class="menu-icon"></iconify-icon>
                    <span>Customers</span>
                </a>
            </li>
            @endif

            <!-- Financial Section -->
            @if(auth()->user()->hasAnyModuleAccess(['expenses', 'reports']))
            <li class="sidebar-menu-group-title">Financial</li>
            @endif

            @if(auth()->user()->hasModuleAccess('expenses'))
            <li>
                <a href="{{ route('expenses.index') }}" class="{{ request()->routeIs('expenses.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:cash-remove" class="menu-icon"></iconify-icon>
                    <span>Expenses</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasModuleAccess('reports'))
            <li class="dropdown {{ request()->routeIs('reports.*') ? 'open' : '' }}" id="reports-dropdown">
                <a href="#" onclick="toggleDropdown(event, 'reports-dropdown')" class="{{ request()->routeIs('reports.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:chart-line" class="menu-icon"></iconify-icon>
                    <span>Reports</span>
                </a>
                <ul class="sidebar-submenu" style="{{ request()->routeIs('reports.*') ? 'display: block;' : 'display: none;' }}">
                    <li>
                        <a href="{{ route('reports.sales') }}" class="{{ request()->routeIs('reports.sales') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Sales Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.expenses') }}" class="{{ request()->routeIs('reports.expenses') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-danger-main w-auto"></i>
                            Expense Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.financial') }}" class="{{ request()->routeIs('reports.financial') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-success-main w-auto"></i>
                            Financial Statement
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.products') }}" class="{{ request()->routeIs('reports.products') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-info-main w-auto"></i>
                            Product Performance
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.customers') }}" class="{{ request()->routeIs('reports.customers') ? 'active-page' : '' }}">
                            <i class="ri-circle-fill circle-icon text-warning-main w-auto"></i>
                            Customer Report
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Management Section -->
            @if(auth()->user()->hasAnyModuleAccess(['goals', 'users']))
            <li class="sidebar-menu-group-title">Management</li>
            @endif

            @if(auth()->user()->hasModuleAccess('goals'))
            <li>
                <a href="{{ route('goals.index') }}" class="{{ request()->routeIs('goals.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:target" class="menu-icon"></iconify-icon>
                    <span>Target Goals</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasModuleAccess('users') && (auth()->user()->isAdmin() || auth()->user()->isManager()))
            <li>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active-page' : '' }}">
                    <iconify-icon icon="mdi:account-cog" class="menu-icon"></iconify-icon>
                    <span>User Management</span>
                </a>
            </li>
            @endif

            <!-- Settings Section -->
            <li class="sidebar-menu-group-title">Settings</li>

            @if(auth()->user()->isAdmin())
            <li>
                <a href="javascript:void(0)">
                    <iconify-icon icon="tabler:settings" class="menu-icon"></iconify-icon>
                    <span>Business Settings</span>
                    <span class="badge text-sm fw-semibold bg-warning-100 text-warning-600 px-12 py-4 radius-4 ms-auto">Soon</span>
                </a>
            </li>
            @endif

            <!-- Help & Support -->
            <li class="sidebar-menu-group-title">Support</li>

            <li>
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:help-circle-outline" class="menu-icon"></iconify-icon>
                    <span>Help & Support</span>
                </a>
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

