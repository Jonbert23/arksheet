<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\BusinessController as SuperAdminBusinessController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\SystemController as SuperAdminSystemController;
use App\Http\Controllers\SuperAdmin\ReportController as SuperAdminReportController;

// ============================================
// ARKSHEETS APPLICATION ROUTES
// ============================================

// Guest Routes (Not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Multi-step Registration
    Route::get('/register', [RegisterController::class, 'showStep1'])->name('register');
    Route::prefix('register')->name('register.')->group(function () {
        Route::post('/step1', [RegisterController::class, 'postStep1'])->name('step1.post');
        Route::get('/step2', [RegisterController::class, 'showStep2'])->name('step2');
        Route::post('/step2', [RegisterController::class, 'postStep2'])->name('step2.post');
        Route::get('/step3', [RegisterController::class, 'showStep3'])->name('step3');
        Route::post('/step3', [RegisterController::class, 'postStep3'])->name('step3.post');
        Route::get('/step4', [RegisterController::class, 'showStep4'])->name('step4');
        Route::post('/complete', [RegisterController::class, 'complete'])->name('complete');
    });
});

// Authenticated Routes (Logged in users only)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // User Profile (Available to all authenticated users)
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar', [ProfileController::class, 'deleteAvatar'])->name('avatar.delete');
    });
    
    // Dashboard
    Route::middleware('module.permission:dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
    
    // Products Module
    Route::middleware('module.permission:products')->group(function () {
        Route::get('products/create-form', [ProductController::class, 'createForm'])->name('products.create.form');
        Route::get('products/{product}/edit-form', [ProductController::class, 'editForm'])->name('products.edit.form');
        Route::resource('products', ProductController::class);
    });
    
    // Stock Management Module
    Route::middleware('module.permission:stock')->group(function () {
        Route::resource('stock', StockInController::class);
    });
    
    // Sales Module
    Route::middleware('module.permission:sales')->group(function () {
        Route::get('sales/pos', [SaleController::class, 'pos'])->name('sales.pos');
        Route::resource('sales', SaleController::class);
    });
    
    // Invoices Module
    Route::middleware('module.permission:invoices')->group(function () {
        Route::prefix('invoices')->name('invoices.')->group(function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');
            Route::get('/{sale}', [InvoiceController::class, 'show'])->name('show');
            Route::get('/{sale}/download', [InvoiceController::class, 'download'])->name('download');
        });
    });
    
    // Expenses Module
    Route::middleware('module.permission:expenses')->group(function () {
        Route::resource('expenses', ExpenseController::class);
    });
    
    // Customers Module
    Route::middleware('module.permission:customers')->group(function () {
        Route::resource('customers', CustomerController::class);
    });
    
    // Users Module (Admin and Manager only + permission check)
    Route::middleware('module.permission:users')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('users/partials/edit-form', function() {
            return view('users.partials.edit-form');
        })->name('users.partials.edit-form');
    });
    
    // Goals Module
    Route::middleware('module.permission:goals')->group(function () {
        Route::prefix('goals')->name('goals.')->group(function () {
            Route::get('/', [GoalController::class, 'index'])->name('index');
            Route::get('/create', [GoalController::class, 'create'])->name('create');
            Route::post('/', [GoalController::class, 'store'])->name('store');
            Route::get('/{goal}', [GoalController::class, 'show'])->name('show');
            Route::get('/{goal}/edit', [GoalController::class, 'edit'])->name('edit');
            Route::put('/{goal}', [GoalController::class, 'update'])->name('update');
            Route::delete('/{goal}', [GoalController::class, 'destroy'])->name('destroy');
            Route::post('/{goal}/update-progress', [GoalController::class, 'updateProgress'])->name('update-progress');
            Route::post('/refresh-all', [GoalController::class, 'refreshAll'])->name('refresh-all');
        });
    });
    
    // Reports Module
    Route::middleware('module.permission:reports')->group(function () {
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
            Route::get('/expenses', [ReportController::class, 'expenses'])->name('expenses');
            Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
            Route::get('/products', [ReportController::class, 'products'])->name('products');
            Route::get('/customers', [ReportController::class, 'customers'])->name('customers');
        });
    });
});

// ============================================
// SUPER ADMIN ROUTES
// ============================================

Route::middleware(['auth', 'super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    // Dashboard
    Route::get('/', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    
    // Business Management
    Route::resource('businesses', SuperAdminBusinessController::class)->except(['create', 'store']);
    Route::patch('businesses/{business}/toggle-status', [SuperAdminBusinessController::class, 'toggleStatus'])->name('businesses.toggle-status');
    
    // User Management
    Route::get('users', [SuperAdminUserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [SuperAdminUserController::class, 'show'])->name('users.show');
    Route::patch('users/{user}/toggle-status', [SuperAdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('users/{user}', [SuperAdminUserController::class, 'destroy'])->name('users.destroy');
    
    // System Management
    Route::prefix('system')->name('system.')->group(function () {
        Route::get('settings', [SuperAdminSystemController::class, 'settings'])->name('settings');
        Route::get('logs', [SuperAdminSystemController::class, 'logs'])->name('logs');
        Route::post('clear-cache', [SuperAdminSystemController::class, 'clearCache'])->name('clear-cache');
        Route::post('optimize', [SuperAdminSystemController::class, 'optimize'])->name('optimize');
        Route::post('migrate', [SuperAdminSystemController::class, 'migrate'])->name('migrate');
        Route::post('clear-logs', [SuperAdminSystemController::class, 'clearLogs'])->name('clear-logs');
    });
    
    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [SuperAdminReportController::class, 'index'])->name('index');
        Route::get('revenue', [SuperAdminReportController::class, 'revenue'])->name('revenue');
        Route::get('usage', [SuperAdminReportController::class, 'usage'])->name('usage');
        Route::get('growth', [SuperAdminReportController::class, 'growth'])->name('growth');
        Route::get('export/{type}', [SuperAdminReportController::class, 'export'])->name('export');
    });
});

// ============================================
// SETTINGS (Admin Only)
// ============================================

// Business Settings (Admin only)
Route::middleware('auth')->prefix('settings')->name('settings.')->controller(SettingsController::class)->group(function () {
    Route::get('/business', 'business')->name('business');
    Route::put('/business', 'updateBusiness')->name('business.update');
});

// Business Configuration (Admin only)
Route::middleware('auth')->prefix('settings/config')->name('settings.config.')->controller(App\Http\Controllers\BusinessConfigController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    
    // Product Categories
    Route::post('/product-categories', 'storeProductCategory')->name('product-categories.store');
    Route::put('/product-categories/{id}', 'updateProductCategory')->name('product-categories.update');
    Route::delete('/product-categories/{id}', 'destroyProductCategory')->name('product-categories.destroy');
    
    // Sales Channels
    Route::post('/sales-channels', 'storeSalesChannel')->name('sales-channels.store');
    Route::put('/sales-channels/{id}', 'updateSalesChannel')->name('sales-channels.update');
    Route::delete('/sales-channels/{id}', 'destroySalesChannel')->name('sales-channels.destroy');
    
    // Expense Categories
    Route::post('/expense-categories', 'storeExpenseCategory')->name('expense-categories.store');
    Route::put('/expense-categories/{id}', 'updateExpenseCategory')->name('expense-categories.update');
    Route::delete('/expense-categories/{id}', 'destroyExpenseCategory')->name('expense-categories.destroy');
    
    // Generic Settings
    Route::post('/settings', 'storeSetting')->name('settings.store');
    Route::put('/settings/{id}', 'updateSetting')->name('settings.update');
    Route::delete('/settings/{id}', 'destroySetting')->name('settings.destroy');
    
    // Convenience routes for specific settings
    Route::post('/product-types', 'storeSetting')->name('product-types.store');
    Route::put('/product-types/{id}', 'updateSetting')->name('product-types.update');
    Route::delete('/product-types/{id}', 'destroySetting')->name('product-types.destroy');
    
    Route::post('/units', 'storeSetting')->name('units.store');
    Route::put('/units/{id}', 'updateSetting')->name('units.update');
    Route::delete('/units/{id}', 'destroySetting')->name('units.destroy');
    
    Route::post('/payment-methods', 'storeSetting')->name('payment-methods.store');
    Route::put('/payment-methods/{id}', 'updateSetting')->name('payment-methods.update');
    Route::delete('/payment-methods/{id}', 'destroySetting')->name('payment-methods.destroy');
    
    Route::post('/payment-statuses', 'storeSetting')->name('payment-statuses.store');
    Route::put('/payment-statuses/{id}', 'updateSetting')->name('payment-statuses.update');
    Route::delete('/payment-statuses/{id}', 'destroySetting')->name('payment-statuses.destroy');
    
    Route::post('/expense-statuses', 'storeSetting')->name('expense-statuses.store');
    Route::put('/expense-statuses/{id}', 'updateSetting')->name('expense-statuses.update');
    Route::delete('/expense-statuses/{id}', 'destroySetting')->name('expense-statuses.destroy');
});

