# Module Permissions System

This document explains how to use the module permissions system in the application.

## Overview

The system allows administrators to control which modules each user can access. Admins have access to all modules by default, while other users (Manager, Accountant, Staff) only have access to modules explicitly assigned to them.

## Available Modules

The following modules are available for permission assignment:

- `dashboard` - Dashboard
- `products` - Products
- `stock` - Stock Management
- `sales` - Sales
- `invoices` - Invoices
- `customers` - Customers
- `expenses` - Expenses
- `reports` - Reports
- `goals` - Target Goals
- `users` - User Management

## User Model Methods

### `hasModuleAccess($module)`

Check if a user has access to a specific module.

```php
if (auth()->user()->hasModuleAccess('products')) {
    // User has access to products module
}
```

### `hasAnyModuleAccess($modules)`

Check if a user has access to any of the specified modules.

```php
if (auth()->user()->hasAnyModuleAccess(['sales', 'invoices'])) {
    // User has access to at least one of these modules
}
```

### `getAllowedModules()`

Get all modules the user has access to.

```php
$allowedModules = auth()->user()->getAllowedModules();
// Returns: ['dashboard', 'sales', 'customers', ...]
```

## Protecting Routes with Middleware

Use the `module.permission` middleware to protect routes:

```php
// Single route
Route::get('/products', [ProductController::class, 'index'])
    ->middleware('module.permission:products');

// Route group
Route::middleware(['auth', 'module.permission:products'])->group(function () {
    Route::resource('products', ProductController::class);
});

// Multiple modules (user needs access to at least one)
Route::get('/sales', [SalesController::class, 'index'])
    ->middleware('module.permission:sales');
```

## Checking Permissions in Views

Use the permission methods in Blade templates:

```blade
@if(auth()->user()->hasModuleAccess('products'))
    <a href="{{ route('products.index') }}">Products</a>
@endif

@if(auth()->user()->hasAnyModuleAccess(['sales', 'invoices']))
    <div class="sales-section">
        <!-- Content -->
    </div>
@endif
```

## Assigning Permissions

### Via User Management Module

1. Navigate to User Management
2. Click "Add User" or edit an existing user
3. Select the user's role
4. For non-admin roles, check the modules the user should have access to
5. Click "Create User" or "Update User"

### Programmatically

```php
$user = User::find($id);
$user->permissions = ['dashboard', 'sales', 'customers'];
$user->save();
```

## Role-Based Default Behavior

- **Admin**: Automatically has access to all modules
- **Manager**: Can access User Management (if granted permission)
- **Accountant**: Custom permissions only
- **Staff**: Custom permissions only

## Important Notes

1. Admins always have full access regardless of permission settings
2. Permissions are stored as a JSON array in the `permissions` column
3. When a user's role is changed to Admin, all permissions are automatically granted
4. The sidebar automatically shows/hides menu items based on user permissions
5. Routes should be protected with middleware to prevent unauthorized access
6. The User Management module requires both permission and role check (Admin or Manager only)

## Example: Full Protection Setup

```php
// routes/web.php

// Products Module
Route::middleware(['auth', 'module.permission:products'])->group(function () {
    Route::resource('products', ProductController::class);
});

// Sales Module
Route::middleware(['auth', 'module.permission:sales'])->group(function () {
    Route::resource('sales', SalesController::class);
});

// Customers Module
Route::middleware(['auth', 'module.permission:customers'])->group(function () {
    Route::resource('customers', CustomerController::class);
});

// Goals Module
Route::middleware(['auth', 'module.permission:goals'])->group(function () {
    Route::resource('goals', GoalController::class);
});
```

## Testing Permissions

1. Create a test user with limited permissions
2. Log in as that user
3. Verify the sidebar only shows permitted modules
4. Try accessing a restricted module directly via URL
5. You should see a 403 error: "You do not have permission to access this module."

