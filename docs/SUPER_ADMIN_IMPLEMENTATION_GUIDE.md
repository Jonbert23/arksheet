# Super Admin Implementation Guide

## Overview
This comprehensive guide combines detailed tasks with ready-to-use AI prompts for implementing the Super Admin role. Each task includes acceptance criteria, time estimates, and corresponding AI prompts for code generation.

---

## How to Use This Guide

1. **Read the Task**: Understand requirements and acceptance criteria
2. **Use the AI Prompt**: Copy the prompt to your AI assistant (Cursor, ChatGPT, etc.)
3. **Review Generated Code**: Always review and test generated code
4. **Check Off Task**: Mark task as complete when done
5. **Move to Next Task**: Proceed sequentially through phases

---

## Phase 1: Database & Model Updates (4-6 hours)

### Task 1.1: Create Role Update Migration ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 30 minutes

#### Requirements
- [x] Create migration file: `database/migrations/YYYY_MM_DD_update_user_roles_add_super_admin.php`
- [x] Add code to update existing `admin` role to `business_owner`
- [x] Add rollback functionality
- [x] Test migration up and down

#### Acceptance Criteria
- ✅ Migration runs without errors
- ✅ All existing admin users become business_owner
- ✅ Rollback works correctly

#### AI Prompt
```
Create a Laravel migration file to update user roles for the Super Admin implementation:

Requirements:
1. File name: YYYY_MM_DD_update_user_roles_add_super_admin.php
2. Update all existing users with role 'admin' to 'business_owner'
3. Add proper rollback functionality
4. Use DB::table() for data updates
5. Include comments explaining each step

The migration should:
- Change 'admin' role to 'business_owner' in the up() method
- Revert 'business_owner' back to 'admin' in the down() method
- Delete any super_admin users in the down() method

Follow Laravel best practices and include proper error handling.
```

---

### Task 1.2: Create Super Admin Seeder ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 30 minutes

#### Requirements
- [x] Create `database/seeders/SuperAdminSeeder.php`
- [x] Add default Super Admin account creation
- [x] Set secure default password
- [x] Add to DatabaseSeeder
- [x] Test seeder execution

#### Acceptance Criteria
- ✅ Seeder creates Super Admin account
- ✅ Super Admin has null business_id
- ✅ Super Admin can log in
- ✅ Console displays credentials after seeding

#### Default Credentials
```
Email: superadmin@arksheet.com
Password: SuperAdmin@123
```

#### AI Prompt
```
Create a Laravel seeder to create the default Super Admin account:

Requirements:
1. File name: database/seeders/SuperAdminSeeder.php
2. Create a Super Admin user with:
   - Name: "Super Administrator"
   - Email: superadmin@arksheet.com
   - Password: SuperAdmin@123 (hashed)
   - Role: super_admin
   - business_id: null
   - is_active: true
3. Display credentials in console after seeding
4. Add warning to change password after first login
5. Handle duplicate email gracefully

Include proper error handling and informative console output.
```

---

### Task 1.3: Update User Model - Role Methods ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [x] Add `isSuperAdmin()` method
- [x] Add `isBusinessOwner()` method (rename from isAdmin)
- [x] Keep `isAdmin()` for backward compatibility
- [x] Add `canAccessBusiness($businessId)` method
- [x] Update PHPDoc comments
- [x] Test all role methods

#### Acceptance Criteria
- ✅ `isSuperAdmin()` returns true only for super_admin role
- ✅ `isBusinessOwner()` returns true only for business_owner role
- ✅ `canAccessBusiness()` works for all roles
- ✅ Backward compatibility maintained

#### AI Prompt
```
Update the User model (app/Models/User.php) to support the Super Admin role:

Add these methods:
1. isSuperAdmin() - Check if user is super_admin
2. isBusinessOwner() - Check if user is business_owner (replaces isAdmin)
3. Keep isAdmin() for backward compatibility (should call isBusinessOwner)
4. canAccessBusiness($businessId) - Check if user can access a specific business
   - Super Admin can access all businesses
   - Business Owner/Staff can only access their own business

Update existing role helper methods:
- isManager()
- isAccountant()
- isStaff()

Ensure all methods have proper PHPDoc comments and return type hints.

Current User model has these existing methods:
- isAdmin()
- isManager()
- isAccountant()
- isStaff()
- hasRole($role)
- hasPermission($permission)
```

---

### Task 1.4: Update User Model - Permission Methods ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [x] Update `hasModuleAccess($module)` for Super Admin
- [x] Update `getAllowedModules()` for Super Admin
- [x] Add Super Admin specific modules list
- [x] Update `hasPermission($permission)` if needed
- [x] Test permission checks for all roles

#### Acceptance Criteria
- ✅ Super Admin has access to super-admin modules
- ✅ Business Owner has access to all business modules
- ✅ Staff has access to granted modules only
- ✅ Permission checks work correctly for all scenarios

#### AI Prompt
```
Update the permission methods in the User model (app/Models/User.php) to support Super Admin:

Update these methods:
1. hasModuleAccess($module)
   - Super Admin should have access to super-admin specific modules:
     * super-admin-dashboard
     * businesses
     * system-users
     * system-settings
     * system-reports
   - Business Owner should have access to all business modules
   - Staff should check their permissions array

2. getAllowedModules()
   - Return super-admin modules for Super Admin
   - Return all business modules for Business Owner
   - Return granted modules for Staff

3. getAvailableModules() (static method)
   - Keep existing business modules list

Current business modules:
- dashboard
- products
- stock
- sales
- invoices
- customers
- expenses
- reports
- goals
- users

Ensure proper type hints and PHPDoc comments.
```

---

### Task 1.5: Update TenantScope Trait ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [x] Skip tenant scoping for Super Admin in global scope
- [x] Skip auto-assignment of business_id for Super Admin
- [x] Test with Super Admin queries
- [x] Test with Business Owner queries
- [x] Test with Staff queries
- [x] Ensure no breaking changes

#### Acceptance Criteria
- ✅ Super Admin can query across all businesses
- ✅ Business Owner queries still scoped to their business
- ✅ Staff queries still scoped to their business
- ✅ Existing functionality not broken

#### AI Prompt
```
Update the TenantScope trait (app/Traits/TenantScope.php) to skip tenant scoping for Super Admin:

Requirements:
1. In the bootTenantScope() method:
   - Skip auto-assignment of business_id when creating records if user is Super Admin
   - Skip global scope filtering if user is Super Admin
   - Keep existing behavior for Business Owner and Staff

2. Maintain existing methods:
   - scopeWithoutTenant()
   - scopeForBusiness()

Current TenantScope implementation:
- Automatically adds business_id when creating records
- Automatically scopes all queries to current user's business_id
- Provides methods to query without tenant scope

The updated trait should allow Super Admin to:
- Query across all businesses
- Not have business_id auto-assigned
- Still allow explicit business_id assignment if needed

Ensure no breaking changes for existing Business Owner and Staff functionality.
```

---

### Task 1.6: Run and Test Migrations ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 30 minutes

#### Requirements
- [x] Run `php artisan migrate`
- [x] Run `php artisan db:seed --class=SuperAdminSeeder`
- [x] Verify database changes
- [ ] Test rollback
- [ ] Re-run migrations

#### Acceptance Criteria
- ✅ Migrations run successfully
- ✅ Super Admin account created
- ✅ No data loss
- ✅ Rollback works

#### Commands
```bash
# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed --class=SuperAdminSeeder

# Test rollback
php artisan migrate:rollback

# Re-run migrations
php artisan migrate

# Verify Super Admin created
php artisan tinker
>>> User::where('role', 'super_admin')->first()
```

---

## Phase 2: Authentication & Authorization (3-4 hours)

### Task 2.1: Create SuperAdminMiddleware ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 45 minutes

#### Requirements
- [x] Create `app/Http/Middleware/SuperAdminMiddleware.php`
- [x] Add authentication check
- [x] Add Super Admin role check
- [x] Add proper error responses
- [x] Register middleware in `bootstrap/app.php` or `Kernel.php`
- [x] Test middleware

#### Acceptance Criteria
- ✅ Middleware blocks non-authenticated users
- ✅ Middleware blocks non-Super Admin users
- ✅ Middleware allows Super Admin users
- ✅ Returns 403 for unauthorized access

#### AI Prompt
```
Create a Laravel middleware to protect Super Admin routes:

Requirements:
1. File: app/Http/Middleware/SuperAdminMiddleware.php
2. Check if user is authenticated
3. Check if user has super_admin role using isSuperAdmin() method
4. Redirect to login if not authenticated
5. Return 403 error if not Super Admin
6. Include proper error messages

The middleware should:
- Use auth()->check() to verify authentication
- Use auth()->user()->isSuperAdmin() to verify role
- Return appropriate responses for each scenario
- Include proper type hints and PHPDoc comments

After creating the middleware, provide instructions on how to register it in:
- Laravel 11: bootstrap/app.php
- Laravel 10: app/Http/Kernel.php
```

---

### Task 2.2: Create BusinessAccessMiddleware ✅ COMPLETED
**Priority:** MEDIUM | **Estimated Time:** 45 minutes

#### Requirements
- [x] Create `app/Http/Middleware/BusinessAccessMiddleware.php`
- [x] Check if user can access specific business
- [x] Allow Super Admin to access any business
- [x] Block Business Owner from other businesses
- [x] Register middleware
- [x] Test middleware

#### Acceptance Criteria
- ✅ Super Admin can access any business
- ✅ Business Owner can only access their business
- ✅ Staff can only access their business
- ✅ Returns 403 for unauthorized access

#### AI Prompt
```
Create a Laravel middleware to verify business access permissions:

Requirements:
1. File: app/Http/Middleware/BusinessAccessMiddleware.php
2. Accept a business_id parameter
3. Check if user can access the specified business
4. Allow Super Admin to access any business
5. Allow Business Owner/Staff to access only their business
6. Return 403 if access denied

The middleware should:
- Extract business_id from route parameters
- Use auth()->user()->canAccessBusiness($businessId) method
- Return appropriate error messages
- Include proper type hints and PHPDoc comments

Usage example:
Route::get('/businesses/{business}', [Controller::class, 'show'])
    ->middleware('business.access');
```

---

### Task 2.3: Update LoginController ✅ COMPLETED
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [x] Update `login()` method
- [x] Add Super Admin check
- [x] Redirect Super Admin to super-admin dashboard
- [x] Keep existing business owner/staff logic
- [x] Update welcome messages
- [ ] Test login for all roles

#### Acceptance Criteria
- ✅ Super Admin redirected to `/super-admin`
- ✅ Business Owner redirected to `/dashboard`
- ✅ Staff redirected to `/dashboard`
- ✅ Login still requires business_id for non-Super Admin
- ✅ Error messages appropriate for each role

#### AI Prompt
```
Update the LoginController (app/Http/Controllers/Auth/LoginController.php) to handle Super Admin login:

Requirements:
1. In the login() method, after successful authentication:
   - Check if user is Super Admin using isSuperAdmin()
   - If Super Admin, redirect to route('super-admin.dashboard')
   - If not Super Admin, keep existing business_id check
   - Update welcome messages for each role

Current login flow:
1. Validate credentials
2. Attempt authentication
3. Regenerate session
4. Check if user has business_id (required for non-Super Admin)
5. Check if user is active
6. Redirect to dashboard

New flow should:
1. Validate credentials
2. Attempt authentication
3. Regenerate session
4. Check if user is Super Admin
   - If yes, redirect to super-admin dashboard
   - If no, continue with existing checks (business_id, is_active)
5. Redirect to appropriate dashboard

Maintain all existing validation and error handling.
```

---

### Task 2.4: Update CheckModulePermission Middleware ✅ COMPLETED
**Priority:** MEDIUM | **Estimated Time:** 45 minutes

#### Requirements
- [x] Update to handle Super Admin
- [x] Allow Super Admin view access to business modules (future)
- [ ] Keep existing Business Owner logic
- [ ] Keep existing Staff logic
- [ ] Test with all roles

#### Acceptance Criteria
- ✅ Super Admin permission checks work
- ✅ Business Owner permission checks still work
- ✅ Staff permission checks still work
- ✅ No breaking changes

#### AI Prompt
```
Update the CheckModulePermission middleware (app/Http/Middleware/CheckModulePermission.php) to handle Super Admin:

Requirements:
1. Keep existing authentication check
2. Add Super Admin check before module permission check
3. Super Admin should have access to super-admin modules
4. Business Owner should have access to all business modules (existing)
5. Staff should check their permissions array (existing)

Current middleware:
- Checks if user is authenticated
- Checks if user has module access using hasModuleAccess($module)
- Returns 403 if no access

Update to:
- Add special handling for Super Admin if needed
- Ensure Super Admin can access super-admin modules
- Keep existing Business Owner and Staff logic
- Maintain backward compatibility

The hasModuleAccess() method in User model will handle the logic, so the middleware might not need changes, but verify and update if necessary.
```

---

## Phase 3: Super Admin Controllers (8-10 hours)

### Task 3.1: Create SuperAdmin\DashboardController
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `app/Http/Controllers/SuperAdmin/DashboardController.php`
- [ ] Create `index()` method
- [ ] Calculate system-wide statistics
- [ ] Prepare data for charts
- [ ] Return view with data

#### Statistics to Include
- Total Businesses (Active/Inactive)
- Total Users (by role)
- Total Revenue (all businesses)
- Monthly Revenue Trend
- Business Growth Chart
- Recent Activities
- Top Performing Businesses

#### Acceptance Criteria
- ✅ Dashboard displays system-wide metrics
- ✅ Statistics are accurate
- ✅ Charts display correctly
- ✅ Performance is acceptable

#### AI Prompt
```
Create a Super Admin Dashboard Controller:

Requirements:
1. File: app/Http/Controllers/SuperAdmin/DashboardController.php
2. Namespace: App\Http\Controllers\SuperAdmin
3. Method: index()

The dashboard should display:
1. System-wide statistics:
   - Total businesses (active/inactive counts)
   - Total users (by role: business_owner, staff)
   - Total revenue (sum of all sales across all businesses)
   - Monthly revenue (current month, all businesses)

2. Charts data:
   - Monthly revenue trend (last 12 months)
   - Business growth (new businesses per month)
   - User growth (new users per month)

3. Recent activities:
   - Recently created businesses (last 10)
   - Recently registered users (last 10)

4. Top performing businesses:
   - Top 5 businesses by revenue
   - Top 5 businesses by sales count

Use these models:
- Business
- User
- Sale
- Expense

Return view: 'super-admin.dashboard'

Include proper query optimization and eager loading where needed.
```

---

### Task 3.2: Create SuperAdmin\BusinessController
**Priority:** HIGH | **Estimated Time:** 3 hours

#### Requirements
- [ ] Create `app/Http/Controllers/SuperAdmin/BusinessController.php`
- [ ] Implement `index()` - List all businesses
- [ ] Implement `create()` - Show create form
- [ ] Implement `store()` - Create business
- [ ] Implement `show($id)` - View business details
- [ ] Implement `edit($id)` - Show edit form
- [ ] Implement `update($id)` - Update business
- [ ] Implement `destroy($id)` - Delete business (soft delete)
- [ ] Implement `toggleStatus($id)` - Suspend/Activate
- [ ] Implement `stats($id)` - Business statistics
- [ ] Add validation for all methods
- [ ] Add error handling

#### Business Statistics to Show
- Total Sales
- Total Expenses
- Total Products
- Total Customers
- Total Users
- Recent Activity
- Growth Metrics

#### Acceptance Criteria
- ✅ All CRUD operations work
- ✅ Validation prevents invalid data
- ✅ Soft delete works correctly
- ✅ Toggle status works
- ✅ Business stats display correctly
- ✅ Error handling works

#### AI Prompt
```
Create a Super Admin Business Management Controller:

Requirements:
1. File: app/Http/Controllers/SuperAdmin/BusinessController.php
2. Namespace: App\Http\Controllers\SuperAdmin
3. Implement full CRUD operations

Methods to implement:
1. index() - List all businesses with pagination and search
2. create() - Show create business form
3. store() - Create new business with validation
4. show($id) - Display business details and statistics
5. edit($id) - Show edit business form
6. update($id) - Update business with validation
7. destroy($id) - Soft delete business
8. toggleStatus($id) - Toggle business active/inactive status
9. stats($id) - Get business statistics (AJAX)

Validation rules for store/update:
- name: required, string, max:255
- email: nullable, email
- phone: nullable, string
- address: nullable, string
- currency: required, string
- timezone: required, string
- founder: nullable, string
- category: nullable, string

Business statistics should include:
- Total sales
- Total expenses
- Total products
- Total customers
- Total users
- Active users count
- Recent sales (last 10)

Use soft deletes and include proper error handling.
Views to return:
- index: 'super-admin.businesses.index'
- create: 'super-admin.businesses.create'
- show: 'super-admin.businesses.show'
- edit: 'super-admin.businesses.edit'
```

---

### Task 3.3: Create SuperAdmin\UserController
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `app/Http/Controllers/SuperAdmin/UserController.php`
- [ ] Implement `index()` - List all users with filters
- [ ] Implement `show($id)` - View user details
- [ ] Implement `toggleStatus($id)` - Suspend/Activate user
- [ ] Implement `resetPassword($id)` - Reset user password
- [ ] Add validation
- [ ] Add error handling

#### Acceptance Criteria
- ✅ Lists all users across all businesses
- ✅ Filters work correctly
- ✅ Search works
- ✅ Pagination works
- ✅ Toggle status works
- ✅ Password reset works

#### AI Prompt
```
Create a Super Admin User Management Controller:

Requirements:
1. File: app/Http/Controllers/SuperAdmin/UserController.php
2. Namespace: App\Http\Controllers\SuperAdmin
3. Methods for viewing and managing users

Methods to implement:
1. index() - List all users across all businesses
   - Include filters: business_id, role, is_active
   - Include search: name, email
   - Include pagination
   - Eager load business relationship

2. show($id) - Display user details
   - Show user information
   - Show business information
   - Show user's recent activities (future)
   - Show user statistics

3. toggleStatus($id) - Toggle user active/inactive
   - Update is_active field
   - Return JSON response for AJAX

4. resetPassword($id) - Reset user password
   - Generate random password
   - Update user password
   - Send email notification (future)
   - Return success message

Use these models:
- User
- Business

Views to return:
- index: 'super-admin.users.index'
- show: 'super-admin.users.show'

Include proper authorization checks (only Super Admin can access).
```

---

### Task 3.4: Create SuperAdmin\SystemController
**Priority:** MEDIUM | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `app/Http/Controllers/SuperAdmin/SystemController.php`
- [ ] Implement `settings()` - Show system settings
- [ ] Implement `updateSettings()` - Update system settings
- [ ] Implement `logs()` - View system logs
- [ ] Add validation
- [ ] Add error handling

#### System Settings to Include
- Application Name
- Application URL
- Default Currency
- Default Timezone
- Email Settings (future)
- Maintenance Mode (future)

#### Acceptance Criteria
- ✅ System settings page displays
- ✅ Settings can be updated
- ✅ System logs display correctly
- ✅ Only Super Admin can access

#### AI Prompt
```
Create a Super Admin System Controller for system settings and logs:

Requirements:
1. File: app/Http/Controllers/SuperAdmin/SystemController.php
2. Namespace: App\Http\Controllers\SuperAdmin
3. Methods for system management

Methods to implement:
1. settings() - Display system settings page
   - Load current settings from config or database
   - Show form to update settings

2. updateSettings() - Update system settings
   - Validate input
   - Update settings in config or database
   - Clear cache after update
   - Return success message

3. logs() - Display system logs
   - Read Laravel log file
   - Parse log entries
   - Filter by date, level (error, warning, info)
   - Paginate results

System settings to manage:
- app_name
- app_url
- default_currency
- default_timezone
- maintenance_mode (future)
- email_settings (future)

Views to return:
- settings: 'super-admin.system.settings'
- logs: 'super-admin.system.logs'

Include proper error handling and validation.
```

---

### Task 3.5: Create SuperAdmin\ReportController
**Priority:** MEDIUM | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `app/Http/Controllers/SuperAdmin/ReportController.php`
- [ ] Implement `index()` - Reports dashboard
- [ ] Implement `revenue()` - Revenue reports
- [ ] Implement `usage()` - Usage analytics
- [ ] Implement `growth()` - Growth metrics
- [ ] Add date range filters

#### Reports to Include
- Revenue by Business
- Revenue Trends
- User Growth
- Business Growth
- Top Performing Businesses
- Usage Statistics

#### Acceptance Criteria
- ✅ Reports display correctly
- ✅ Data is accurate
- ✅ Filters work
- ✅ Charts display correctly
- ✅ Performance is acceptable

#### AI Prompt
```
Create a Super Admin Reports Controller for system-wide reports:

Requirements:
1. File: app/Http/Controllers/SuperAdmin/ReportController.php
2. Namespace: App\Http\Controllers\SuperAdmin
3. Methods for various reports

Methods to implement:
1. index() - Reports dashboard
   - Show available reports
   - Show quick statistics

2. revenue() - Revenue reports across all businesses
   - Total revenue
   - Revenue by business
   - Revenue trends (monthly, yearly)
   - Top performing businesses
   - Include date range filter

3. usage() - Usage analytics
   - Active users count
   - Login frequency
   - Most used features
   - Business activity levels

4. growth() - Growth metrics
   - New businesses per month
   - New users per month
   - Revenue growth rate
   - User growth rate

Use these models:
- Business
- User
- Sale
- Expense

All methods should:
- Accept date range parameters (date_from, date_to)
- Return data for charts (JSON for AJAX or view data)
- Include proper query optimization

Views to return:
- index: 'super-admin.reports.index'
- revenue: 'super-admin.reports.revenue'
- usage: 'super-admin.reports.usage'
- growth: 'super-admin.reports.growth'
```

---

## Phase 4: Super Admin Views (12-16 hours)

### Task 4.1: Create Super Admin Layout
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `resources/views/super-admin/layouts/app.blade.php`
- [ ] Create `resources/views/super-admin/layouts/navbar.blade.php`
- [ ] Create `resources/views/super-admin/layouts/sidebar.blade.php`
- [ ] Add Super Admin branding
- [ ] Add navigation menu
- [ ] Add user dropdown
- [ ] Style consistently with existing theme

#### Navigation Items
- Dashboard
- Business Management
- User Management
- System Settings
- Reports
- Profile
- Logout

#### Acceptance Criteria
- ✅ Layout displays correctly
- ✅ Navigation works
- ✅ Responsive design
- ✅ Matches existing theme style
- ✅ User dropdown works

#### AI Prompt
```
Create a Super Admin layout using the existing theme:

Requirements:
1. File: resources/views/super-admin/layouts/app.blade.php
2. Use the existing application theme and styles
3. Create separate navbar and sidebar components

The layout should include:
1. HTML structure with existing CSS/JS assets
2. Super Admin navbar (include component)
3. Super Admin sidebar (include component)
4. Main content area with @yield('content')
5. Footer
6. Scripts section

Create these additional files:
1. resources/views/super-admin/layouts/navbar.blade.php
   - User dropdown with profile and logout
   - Application name/logo
   - Notifications icon (future)

2. resources/views/super-admin/layouts/sidebar.blade.php
   - Navigation menu with these items:
     * Dashboard (super-admin.dashboard)
     * Business Management (super-admin.businesses.index)
     * User Management (super-admin.users.index)
     * System Settings (super-admin.system.settings)
     * Reports (super-admin.reports.index)
   - Active state highlighting
   - Icons for each menu item

Use the existing theme's CSS classes and structure. The current business owner layout is in:
- resources/views/components/layout/app.blade.php
- resources/views/components/layout/navbar.blade.php
- resources/views/components/layout/sidebar.blade.php

Match the styling but customize for Super Admin context (different color scheme or branding if desired).
```

---

### Task 4.2: Create Super Admin Dashboard View
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `resources/views/super-admin/dashboard.blade.php`
- [ ] Add metrics cards
- [ ] Add charts (Chart.js or similar)
- [ ] Add recent activities table
- [ ] Add quick actions
- [ ] Make responsive

#### Metrics Cards
- Total Businesses
- Total Users
- Total Revenue
- Active Businesses
- Monthly Revenue
- Growth Rate

#### Acceptance Criteria
- ✅ Dashboard displays all metrics
- ✅ Charts render correctly
- ✅ Responsive on all devices
- ✅ Quick actions work
- ✅ Recent activities display

#### AI Prompt
```
Create the Super Admin Dashboard view:

Requirements:
1. File: resources/views/super-admin/dashboard.blade.php
2. Extend: super-admin.layouts.app
3. Use existing theme components and styles

The dashboard should display:

1. Metrics Cards (top row):
   - Total Businesses (with active/inactive count)
   - Total Users (with role breakdown)
   - Total Revenue (all businesses)
   - Monthly Revenue (current month)

2. Charts (middle section):
   - Monthly Revenue Trend (line chart, last 12 months)
   - Business Growth Chart (bar chart, new businesses per month)
   - Revenue by Business (pie chart, top 5 businesses)

3. Tables (bottom section):
   - Recent Businesses (last 10, with status and created date)
   - Recent Users (last 10, with business and role)

4. Quick Actions (sidebar or cards):
   - Create New Business
   - View All Businesses
   - View All Users
   - System Settings

Use these technologies:
- Chart.js for charts (already included in theme)
- DataTables for tables (already included in theme)
- Bootstrap cards for metrics
- Responsive grid layout

Data passed from controller:
- $totalBusinesses, $activeBusinesses, $inactiveBusinesses
- $totalUsers, $businessOwners, $staff
- $totalRevenue, $monthlyRevenue
- $monthlyRevenueTrend (array)
- $businessGrowth (array)
- $revenueByBusiness (array)
- $recentBusinesses (collection)
- $recentUsers (collection)

Make it visually appealing and responsive.
```

---

### Task 4.3: Create Business Management Views
**Priority:** HIGH | **Estimated Time:** 4 hours

#### Requirements
- [ ] Create `resources/views/super-admin/businesses/index.blade.php`
- [ ] Create `resources/views/super-admin/businesses/create.blade.php`
- [ ] Create `resources/views/super-admin/businesses/edit.blade.php`
- [ ] Create `resources/views/super-admin/businesses/show.blade.php`

#### Acceptance Criteria
- ✅ All views display correctly
- ✅ Forms work correctly
- ✅ Validation works
- ✅ DataTables works
- ✅ Actions work (edit, delete, toggle)

#### AI Prompt
```
Create the Business Management views for Super Admin:

Requirements:
Create these 4 files:

1. resources/views/super-admin/businesses/index.blade.php
   - List all businesses in a DataTable
   - Columns: ID, Name, Email, Phone, Status, Users Count, Created Date, Actions
   - Actions: View, Edit, Delete, Toggle Status
   - Add "Create Business" button
   - Add search and filters
   - Show active/inactive badges

2. resources/views/super-admin/businesses/create.blade.php
   - Form to create new business
   - Fields:
     * Name (required)
     * Email
     * Phone
     * Address
     * City, State, Postal Code, Country
     * Currency (dropdown)
     * Timezone (dropdown)
     * Founder
     * Category
     * Date Founded
   - Validation messages
   - Submit button

3. resources/views/super-admin/businesses/edit.blade.php
   - Similar to create form but with current values
   - Same fields as create
   - Update button
   - Delete button (with confirmation)

4. resources/views/super-admin/businesses/show.blade.php
   - Display business information (all fields)
   - Display business statistics:
     * Total Sales
     * Total Expenses
     * Total Products
     * Total Customers
     * Total Users
   - Display business users table
   - Display recent sales table
   - Action buttons: Edit, Delete, Toggle Status

Use existing theme components:
- Cards for sections
- DataTables for lists
- Bootstrap forms
- Modal for confirmations

All views should extend: super-admin.layouts.app
```

---

### Task 4.4: Create User Management Views
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `resources/views/super-admin/users/index.blade.php`
- [ ] Create `resources/views/super-admin/users/show.blade.php`

#### Acceptance Criteria
- ✅ User list displays correctly
- ✅ Filters work
- ✅ Search works
- ✅ User details display correctly
- ✅ Actions work

#### AI Prompt
```
Create the User Management views for Super Admin:

Requirements:
Create these 2 files:

1. resources/views/super-admin/users/index.blade.php
   - List all users across all businesses in a DataTable
   - Columns: ID, Name, Email, Business, Role, Status, Created Date, Actions
   - Actions: View, Toggle Status, Reset Password
   - Add filters:
     * Business (dropdown)
     * Role (dropdown)
     * Status (active/inactive)
   - Add search (name, email)
   - Show role badges (different colors for each role)
   - Show status badges (active/inactive)

2. resources/views/super-admin/users/show.blade.php
   - Display user information:
     * Name, Email, Phone
     * Role (with badge)
     * Status (with badge)
     * Business (with link to business details)
     * Created Date
     * Last Login (future)
   - Display user statistics:
     * Total Sales (if applicable)
     * Total Activities (future)
   - Action buttons:
     * Toggle Status
     * Reset Password
     * View Business

Use existing theme components:
- Cards for sections
- DataTables for lists
- Badges for status and roles
- Buttons for actions
- Modals for confirmations

All views should extend: super-admin.layouts.app

Role badge colors:
- super_admin: red/danger
- business_owner: blue/primary
- staff: green/success
```

---

### Task 4.5: Create System Views
**Priority:** MEDIUM | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `resources/views/super-admin/system/settings.blade.php`
- [ ] Create `resources/views/super-admin/system/logs.blade.php`

#### Acceptance Criteria
- ✅ Settings form works
- ✅ Settings save correctly
- ✅ Logs display correctly
- ✅ Filters work

#### AI Prompt
```
Create the System Settings and Logs views for Super Admin:

Requirements:
Create these 2 files:

1. resources/views/super-admin/system/settings.blade.php
   - Form to update system settings
   - Settings sections:
     * Application Settings
       - Application Name
       - Application URL
       - Default Currency
       - Default Timezone
     * Email Settings (future)
       - SMTP Host
       - SMTP Port
       - SMTP Username
       - SMTP Password
     * Maintenance Mode (future)
       - Enable/Disable toggle
       - Maintenance Message
   - Save button
   - Reset to defaults button

2. resources/views/super-admin/system/logs.blade.php
   - Display system logs in a table
   - Columns: Date/Time, Level, Message, Context
   - Filters:
     * Date range
     * Log level (error, warning, info, debug)
   - Color coding by level:
     * Error: red
     * Warning: yellow
     * Info: blue
     * Debug: gray
   - Pagination
   - Refresh button
   - Clear logs button (with confirmation)

Use existing theme components:
- Cards for sections
- Bootstrap forms
- Tables for logs
- Badges for log levels
- Date range picker (if available in theme)

All views should extend: super-admin.layouts.app
```

---

### Task 4.6: Create Reports Views
**Priority:** MEDIUM | **Estimated Time:** 3 hours

#### Requirements
- [ ] Create `resources/views/super-admin/reports/index.blade.php`
- [ ] Create `resources/views/super-admin/reports/revenue.blade.php`
- [ ] Create `resources/views/super-admin/reports/usage.blade.php`
- [ ] Create `resources/views/super-admin/reports/growth.blade.php`

#### Acceptance Criteria
- ✅ All reports display correctly
- ✅ Charts render correctly
- ✅ Filters work
- ✅ Data is accurate
- ✅ Responsive design

#### AI Prompt
```
Create the Reports views for Super Admin:

Requirements:
Create these 4 files:

1. resources/views/super-admin/reports/index.blade.php
   - Reports dashboard with cards linking to each report:
     * Revenue Reports
     * Usage Analytics
     * Growth Metrics
   - Quick statistics:
     * Total Revenue (all time)
     * Total Businesses
     * Total Users
     * Growth Rate

2. resources/views/super-admin/reports/revenue.blade.php
   - Revenue reports across all businesses
   - Date range filter
   - Charts:
     * Monthly Revenue Trend (line chart)
     * Revenue by Business (bar chart)
     * Top 5 Businesses by Revenue (table)
   - Total revenue summary
   - Export button (future)

3. resources/views/super-admin/reports/usage.blade.php
   - Usage analytics
   - Metrics:
     * Active Users (today, this week, this month)
     * Most Used Features
     * Business Activity Levels
   - Charts:
     * Daily Active Users (line chart)
     * Feature Usage (pie chart)

4. resources/views/super-admin/reports/growth.blade.php
   - Growth metrics
   - Charts:
     * New Businesses per Month (bar chart)
     * New Users per Month (bar chart)
     * Revenue Growth Rate (line chart)
   - Growth statistics:
     * Month-over-month growth
     * Year-over-year growth

Use these technologies:
- Chart.js for all charts
- Date range picker for filters
- Bootstrap cards and tables
- Responsive grid layout

All views should extend: super-admin.layouts.app

Include proper data visualization and make charts interactive.
```

---

## Phase 5: Routes & Navigation (2-3 hours)

### Task 5.1: Create Super Admin Routes
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [ ] Add Super Admin route group in `routes/web.php`
- [ ] Add middleware: `auth`, `super-admin`
- [ ] Add prefix: `/super-admin`
- [ ] Add name prefix: `super-admin.`
- [ ] Add all Super Admin routes
- [ ] Test all routes

#### Acceptance Criteria
- ✅ All routes work
- ✅ Middleware protects routes
- ✅ Route names work
- ✅ URL structure is clean

#### AI Prompt
```
Add Super Admin routes to routes/web.php:

Requirements:
1. Add a new route group for Super Admin
2. Use middleware: ['auth', 'super-admin']
3. Use prefix: 'super-admin'
4. Use name prefix: 'super-admin.'

Routes to add:

1. Dashboard:
   - GET /super-admin → DashboardController@index (super-admin.dashboard)

2. Business Management:
   - Resource routes for businesses
   - POST /super-admin/businesses/{business}/toggle-status → toggleStatus
   - GET /super-admin/businesses/{business}/stats → stats

3. User Management:
   - GET /super-admin/users → UserController@index
   - GET /super-admin/users/{user} → UserController@show
   - POST /super-admin/users/{user}/toggle-status → toggleStatus
   - POST /super-admin/users/{user}/reset-password → resetPassword

4. System:
   - GET /super-admin/system/settings → SystemController@settings
   - PUT /super-admin/system/settings → SystemController@updateSettings
   - GET /super-admin/system/logs → SystemController@logs

5. Reports:
   - GET /super-admin/reports → ReportController@index
   - GET /super-admin/reports/revenue → ReportController@revenue
   - GET /super-admin/reports/usage → ReportController@usage
   - GET /super-admin/reports/growth → ReportController@growth

Add these routes after the existing authenticated routes but before the settings routes.

Use proper controller namespacing: App\Http\Controllers\SuperAdmin\
```

---

### Task 5.2: Update Navigation Components
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [ ] Update main layout to detect Super Admin
- [ ] Load Super Admin layout for Super Admin users
- [ ] Keep existing layout for Business Owner/Staff
- [ ] Test layout switching
- [ ] Ensure no breaking changes

#### Acceptance Criteria
- ✅ Super Admin sees Super Admin layout
- ✅ Business Owner sees business layout
- ✅ Staff sees business layout
- ✅ No layout conflicts

#### AI Prompt
```
Update the main application layout to support Super Admin:

Requirements:
1. Update the main layout file to detect user role
2. Load Super Admin layout for Super Admin users
3. Keep existing layout for Business Owner and Staff

Files to update:
1. Create a layout switcher or update existing layout detection

Approach 1: Layout Switcher in AuthServiceProvider or Middleware
- Detect user role after authentication
- Set layout variable in view composer
- Use in blade: @extends($layout)

Approach 2: Conditional in Main Layout
- Check user role in main layout
- Include appropriate navbar and sidebar

Recommended approach:
Create a view composer that sets the layout based on user role:

File: app/Providers/AppServiceProvider.php
In boot() method:
- Use View::composer() to share layout variable
- Check auth()->user()->isSuperAdmin()
- Set $layout = 'super-admin.layouts.app' or 'components.layout.app'

Then in controllers or views:
- Use @extends($layout ?? 'components.layout.app')

Ensure:
- No breaking changes to existing functionality
- Super Admin sees Super Admin layout
- Business Owner/Staff see business layout
- Proper fallback if user not authenticated
```

---

## Phase 6: Role Alignment (2-3 hours)

### Task 6.1: Update Role References in Code
**Priority:** MEDIUM | **Estimated Time:** 1 hour

#### Requirements
- [ ] Find all references to `'admin'` role
- [ ] Update to `'business_owner'` where appropriate
- [ ] Keep backward compatibility where needed
- [ ] Update comments and documentation in code
- [ ] Test all affected functionality

#### Files to Check
- Controllers
- Models
- Middleware
- Views
- Seeders
- Tests

#### Acceptance Criteria
- ✅ All role references updated
- ✅ No breaking changes
- ✅ Tests still pass
- ✅ Functionality works

#### AI Prompt
```
Find and update all references to 'admin' role to 'business_owner':

Requirements:
1. Search for all occurrences of 'admin' role in the codebase
2. Update to 'business_owner' where appropriate
3. Keep backward compatibility where needed

Files to check and update:

1. Controllers:
   - Search for: where('role', 'admin')
   - Search for: ->role === 'admin'
   - Search for: ->role == 'admin'
   - Update to: 'business_owner'

2. Views:
   - Search for: role == 'admin'
   - Search for: role === 'admin'
   - Search for: "Admin" labels
   - Update to: 'business_owner' and "Business Owner"

3. Seeders:
   - Update role in seeders
   - Update test data

4. Tests:
   - Update test assertions
   - Update test data

5. Comments and Documentation:
   - Update inline comments
   - Update PHPDoc comments

Provide a list of files changed and a summary of updates made.

Exclude:
- Don't change 'super_admin' references
- Don't change method names like isAdmin() (keep for compatibility)
- Don't change variable names unless they're confusing
```

---

### Task 6.2: Update UI Labels and Text
**Priority:** MEDIUM | **Estimated Time:** 1 hour

#### Requirements
- [ ] Update "Admin" to "Business Owner" in views
- [ ] Update role selection dropdowns
- [ ] Update permission labels
- [ ] Update help text and tooltips
- [ ] Update error messages
- [ ] Review all user-facing text

#### Acceptance Criteria
- ✅ All labels updated
- ✅ Consistent terminology
- ✅ No "admin" references for business owners
- ✅ Clear distinction between Super Admin and Business Owner

#### AI Prompt
```
Update all user-facing text to use "Business Owner" instead of "Admin":

Requirements:
1. Update all blade templates
2. Update form labels
3. Update dropdown options
4. Update help text and tooltips
5. Update error messages
6. Update success messages

Files to update:

1. User Management Views:
   - Role selection dropdowns
   - Role display labels
   - User list role column

2. Settings Views:
   - Permission labels
   - Role descriptions

3. Dashboard and other views:
   - Any reference to "Admin" role

Search patterns:
- "Admin" (in quotes)
- >Admin<
- Admin User
- Admin Role

Replace with:
- "Business Owner"
- >Business Owner<
- Business Owner User
- Business Owner Role

Exceptions (keep as is):
- "Super Admin" (new role)
- "Administrator" in context of Super Admin
- Technical terms in code comments

Provide a list of files changed and specific text replacements made.
```

---

## Phase 7: Testing & Validation (4-6 hours)

### Task 7.1: Create Feature Tests
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Requirements
- [ ] Create `tests/Feature/SuperAdminAuthTest.php`
- [ ] Create `tests/Feature/SuperAdminBusinessTest.php`
- [ ] Create `tests/Feature/SuperAdminUserTest.php`
- [ ] Run all tests

#### Acceptance Criteria
- ✅ All tests pass
- ✅ Code coverage > 80%
- ✅ Edge cases covered

#### AI Prompt
```
Create comprehensive feature tests for Super Admin functionality:

Requirements:
Create these test files:

1. tests/Feature/SuperAdminAuthTest.php
   - Test Super Admin can log in
   - Test Super Admin redirected to super-admin dashboard
   - Test Business Owner cannot access super-admin routes
   - Test unauthenticated user cannot access super-admin routes
   - Test Super Admin can log out

2. tests/Feature/SuperAdminBusinessTest.php
   - Test Super Admin can view all businesses
   - Test Super Admin can create business
   - Test Super Admin can update business
   - Test Super Admin can delete business
   - Test Super Admin can toggle business status
   - Test Super Admin can view business statistics
   - Test Business Owner cannot access business management

3. tests/Feature/SuperAdminUserTest.php
   - Test Super Admin can view all users
   - Test Super Admin can view user details
   - Test Super Admin can toggle user status
   - Test Super Admin can reset user password
   - Test Business Owner cannot access user management

Use Laravel's testing features:
- $this->actingAs($user) for authentication
- $this->get(), $this->post(), etc. for requests
- $this->assertStatus(), $this->assertRedirect(), etc. for assertions
- Database factories for test data

Include setup and teardown methods to create test data.
```

---

### Task 7.2: Test Multi-tenancy Isolation
**Priority:** HIGH | **Estimated Time:** 1 hour

#### Requirements
- [ ] Test Business Owner can only see their business
- [ ] Test Staff can only see their business
- [ ] Test Super Admin can see all businesses
- [ ] Test TenantScope with Super Admin
- [ ] Test queries don't leak data
- [ ] Test business_id assignment

#### Acceptance Criteria
- ✅ Multi-tenancy works correctly
- ✅ No data leakage
- ✅ Super Admin can access all data
- ✅ Business Owner/Staff isolated

#### AI Prompt
```
Create tests to verify multi-tenancy isolation:

Requirements:
Create test file: tests/Feature/MultiTenancyTest.php

Tests to include:
1. Test Business Owner can only see their business data
   - Create two businesses with data
   - Log in as business owner of business 1
   - Verify can only see business 1 data
   - Verify cannot see business 2 data

2. Test Staff can only see their business data
   - Similar to above but with staff user

3. Test Super Admin can see all business data
   - Create multiple businesses with data
   - Log in as Super Admin
   - Verify can see all businesses' data

4. Test TenantScope works correctly
   - Test Product queries
   - Test Sale queries
   - Test Customer queries
   - Test Expense queries

5. Test business_id auto-assignment
   - Create records as Business Owner
   - Verify business_id assigned automatically
   - Create records as Super Admin
   - Verify business_id not assigned automatically

Use these models in tests:
- Business
- User
- Product
- Sale
- Customer
- Expense

Include proper test data setup and cleanup.
```

---

### Task 7.3: Manual Testing
**Priority:** HIGH | **Estimated Time:** 2 hours

#### Manual Testing Checklist
- [ ] Test Super Admin login
- [ ] Test Super Admin dashboard
- [ ] Test business management (create, edit, delete, toggle, stats)
- [ ] Test user management (view, filter, toggle, reset password)
- [ ] Test system settings
- [ ] Test reports
- [ ] Test Business Owner login (ensure not broken)
- [ ] Test Staff login (ensure not broken)
- [ ] Test all existing features still work

#### Acceptance Criteria
- ✅ All features work as expected
- ✅ No bugs found
- ✅ UI is intuitive
- ✅ Performance is acceptable
- ✅ Existing features not broken

---

## Deployment Checklist

### Pre-Deployment
- [ ] All tests pass
- [ ] Code reviewed
- [ ] Documentation updated
- [ ] Database backup created
- [ ] Migration tested on staging

### Deployment Commands
```bash
# Run migrations
php artisan migrate

# Run seeder
php artisan db:seed --class=SuperAdminSeeder

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Restart queue workers (if applicable)
php artisan queue:restart
```

### Post-Deployment
- [ ] Test Super Admin login
- [ ] Test business management
- [ ] Test user management
- [ ] Verify existing functionality works
- [ ] Monitor logs for errors
- [ ] Change default Super Admin password

---

## Progress Tracking

### Overall Progress

**Phase 1:** Database & Model Updates - 6/6 tasks ✅✅✅✅✅✅ **COMPLETE!**  
**Phase 2:** Authentication & Authorization - 4/4 tasks ✅✅✅✅ **COMPLETE!**  
**Phase 3:** Super Admin Controllers - 5/5 tasks ✅✅✅✅✅ **COMPLETE!**  
**Phase 4:** Super Admin Views - 6/6 tasks ✅✅✅✅✅✅ **COMPLETE!**  
**Phase 5:** Routes & Navigation - 2/2 tasks ✅✅ **COMPLETE!**  
**Phase 6:** Role Alignment - 0/2 tasks ⬜⬜  
**Phase 7:** Testing & Validation - 0/3 tasks ⬜⬜⬜  

**Total Progress: 23/28 tasks completed (82%)**

---

## Tips for Success

1. **Follow the Order**: Complete tasks sequentially within each phase
2. **Test After Each Task**: Don't wait until the end to test
3. **Use AI Prompts**: Copy prompts directly into your AI assistant
4. **Review Generated Code**: Always review before implementing
5. **Commit Frequently**: Commit after each completed task
6. **Take Breaks**: This is 35-48 hours of work - pace yourself
7. **Ask Questions**: Refer back to documentation when unclear
8. **Track Progress**: Check off tasks as you complete them

---

## Support Resources

- **Full Plan**: SUPER_ADMIN_IMPLEMENTATION_PLAN.md
- **Quick Reference**: SUPER_ADMIN_QUICK_REFERENCE.md
- **Checklist**: SUPER_ADMIN_IMPLEMENTATION_CHECKLIST.md
- **Requirements**: USER_ROLES_AND_PERMISSIONS.md

---

**Document Version:** 1.0  
**Created:** November 18, 2025  
**Last Updated:** November 18, 2025  
**Estimated Total Time:** 35-48 hours

---

**Ready to start? Begin with Phase 1, Task 1.1!** 🚀

