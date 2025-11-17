<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AiapplicationController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ComponentpageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\RoleandaccessController;
use App\Http\Controllers\CryptocurrencyController;
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

// ============================================
// ARKSHEETS APPLICATION ROUTES
// ============================================

// Guest Routes (Not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
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
// TEMPLATE DEMO ROUTES (Keep for reference)
// ============================================

Route::controller(HomeController::class)->group(function () {
    Route::get('calendar','calendar')->name('calendar');
    Route::get('chatmessage','chatMessage')->name('chatMessage');
    Route::get('chatempty','chatempty')->name('chatempty');
    Route::get('email','email')->name('email');
    Route::get('error','error1')->name('error');
    Route::get('faq','faq')->name('faq');
    Route::get('gallery','gallery')->name('gallery');
    Route::get('kanban','kanban')->name('kanban');
    Route::get('pricing','pricing')->name('pricing');
    Route::get('termscondition','termsCondition')->name('termsCondition');
    Route::get('widgets','widgets')->name('widgets');
    Route::get('chatprofile','chatProfile')->name('chatProfile');
    Route::get('veiwdetails','veiwDetails')->name('veiwDetails');
    Route::get('blankPage','blankPage')->name('blankPage');
    Route::get('comingSoon','comingSoon')->name('comingSoon');
    Route::get('maintenance','maintenance')->name('maintenance');
    Route::get('starred','starred')->name('starred');
    Route::get('testimonials','testimonials')->name('testimonials');
    });

    // aiApplication
Route::prefix('aiapplication')->group(function () {
    Route::controller(AiapplicationController::class)->group(function () {
        Route::get('/codegenerator', 'codeGenerator')->name('codeGenerator');
        Route::get('/codegeneratornew', 'codeGeneratorNew')->name('codeGeneratorNew');
        Route::get('/imagegenerator','imageGenerator')->name('imageGenerator');
        Route::get('/textgeneratornew','textGeneratorNew')->name('textGeneratorNew');
        Route::get('/textgenerator','textGenerator')->name('textGenerator');
        Route::get('/videogenerator','videoGenerator')->name('videoGenerator');
        Route::get('/voicegenerator','voiceGenerator')->name('voiceGenerator');
    });
});

// Authentication
Route::prefix('authentication')->group(function () {
    Route::controller(AuthenticationController::class)->group(function () {
        Route::get('/forgotpassword', 'forgotPassword')->name('forgotPassword');
        Route::get('/signin', 'signin')->name('signin');
        Route::get('/signup', 'signup')->name('signup');
    });
});

// chart
Route::prefix('chart')->group(function () {
    Route::controller(ChartController::class)->group(function () {
        Route::get('/columnchart', 'columnChart')->name('columnChart');
        Route::get('/linechart', 'lineChart')->name('lineChart');
        Route::get('/piechart', 'pieChart')->name('pieChart');
    });
});

// Componentpage
Route::prefix('componentspage')->group(function () {
    Route::controller(ComponentpageController::class)->group(function () {
        Route::get('/alert', 'alert')->name('alert');
        Route::get('/avatar', 'avatar')->name('avatar');
        Route::get('/badges', 'badges')->name('badges');
        Route::get('/button', 'button')->name('button');
        Route::get('/calendar', 'calendar')->name('calendar');
        Route::get('/card', 'card')->name('card');
        Route::get('/carousel', 'carousel')->name('carousel');
        Route::get('/colors', 'colors')->name('colors');
        Route::get('/dropdown', 'dropdown')->name('dropdown');
        Route::get('/imageupload', 'imageUpload')->name('imageUpload');
        Route::get('/list', 'list')->name('list');
        Route::get('/pagination', 'pagination')->name('pagination');
        Route::get('/progress', 'progress')->name('progress');
        Route::get('/radio', 'radio')->name('radio');
        Route::get('/starrating', 'starRating')->name('starRating');
        Route::get('/switch', 'switch')->name('switch');
        Route::get('/tabs', 'tabs')->name('tabs');
        Route::get('/tags', 'tags')->name('tags');
        Route::get('/tooltip', 'tooltip')->name('tooltip');
        Route::get('/typography', 'typography')->name('typography');
        Route::get('/videos', 'videos')->name('videos');
    });
});

// Dashboard
Route::prefix('dashboard')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/index2', 'index2')->name('index2');
        Route::get('/index3', 'index3')->name('index3');
        Route::get('/index4', 'index4')->name('index4');
        Route::get('/index5','index5')->name('index5');
        Route::get('/index6','index6')->name('index6');
        Route::get('/index7','index7')->name('index7');
        Route::get('/index8','index8')->name('index8');
        Route::get('/index9','index9')->name('index9');
        Route::get('/index10','index10')->name('index10');
        Route::get('/wallet','wallet')->name('wallet');
    });
});

// Forms
Route::prefix('forms')->group(function () {
    Route::controller(FormsController::class)->group(function () {
        Route::get('/form-layout', 'formLayout')->name('formLayout');
        Route::get('/form-validation', 'formValidation')->name('formValidation');
        Route::get('/form', 'form')->name('form');
        Route::get('/wizard', 'wizard')->name('wizard');
    });
});

// invoice/invoiceList
Route::prefix('invoice')->group(function () {
    Route::controller(InvoiceController::class)->group(function () {
        Route::get('/invoice-add', 'invoiceAdd')->name('invoiceAdd');
        Route::get('/invoice-edit', 'invoiceEdit')->name('invoiceEdit');
        Route::get('/invoice-list', 'invoiceList')->name('invoiceList');
        Route::get('/invoice-preview', 'invoicePreview')->name('invoicePreview');
    });
});

// Settings
Route::prefix('settings')->group(function () {
    Route::controller(SettingsController::class)->group(function () {
        Route::get('/company', 'company')->name('company');
        Route::get('/currencies', 'currencies')->name('currencies');
        Route::get('/language', 'language')->name('language');
        Route::get('/notification', 'notification')->name('notification');
        Route::get('/notification-alert', 'notificationAlert')->name('notificationAlert');
        Route::get('/payment-gateway', 'paymentGateway')->name('paymentGateway');
        Route::get('/theme', 'theme')->name('theme');
        
        // Business Settings (Admin only)
        Route::middleware('auth')->group(function () {
            Route::get('/business', 'business')->name('settings.business');
            Route::put('/business', 'updateBusiness')->name('settings.business.update');
        });
    });
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

// Table
Route::prefix('table')->group(function () {
    Route::controller(TableController::class)->group(function () {
        Route::get('/tablebasic', 'tableBasic')->name('tableBasic');
        Route::get('/tabledata', 'tableData')->name('tableData');
    });
});

// Users
Route::prefix('users')->group(function () {
    Route::controller(UsersController::class)->group(function () {
        Route::get('/add-user', 'addUser')->name('addUser');
        Route::get('/users-grid', 'usersGrid')->name('usersGrid');
        Route::get('/users-list', 'usersList')->name('usersList');
        Route::get('/view-profile', 'viewProfile')->name('viewProfile');
    });
});

// Users
Route::prefix('blog')->group(function () {
    Route::controller(BlogController::class)->group(function () {
        Route::get('/addBlog', 'addBlog')->name('addBlog');
        Route::get('/blog', 'blog')->name('blog');
        Route::get('/blogDetails', 'blogDetails')->name('blogDetails');
    });
});

// Users
Route::prefix('roleandaccess')->group(function () {
    Route::controller(RoleandaccessController::class)->group(function () {
        Route::get('/assignRole', 'assignRole')->name('assignRole');
        Route::get('/roleAaccess', 'roleAaccess')->name('roleAaccess');
    });
});

// Users
Route::prefix('cryptocurrency')->group(function () {
    Route::controller(CryptocurrencyController::class)->group(function () {
        Route::get('/marketplace', 'marketplace')->name('marketplace');
        Route::get('/marketplacedetails', 'marketplaceDetails')->name('marketplaceDetails');
        Route::get('/portfolio', 'portfolio')->name('portfolio');
        Route::get('/wallet', 'wallet')->name('wallet');
    });
});
