<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Staff\StaffDashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/transactions/{id}/detail', [DashboardController::class, 'getTransactionDetail'])->name('transactions.detail');
        Route::get('/report/print', [DashboardController::class, 'printReport'])->name('report.print');
        Route::get('/report/data', [DashboardController::class, 'getReportData'])->name('report.data');

        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

        Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
    });

    // Staff routes
    Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('/purchase-orders', function () {
            return view('staff.purchase_orders');
        })->name('purchase_orders');
        // Add more staff routes here if needed
        Route::resource('products', App\Http\Controllers\Staff\ProductController::class);
        Route::get('products/list', [App\Http\Controllers\Staff\ProductController::class, 'list'])->name('products.list');
        Route::resource('categories', App\Http\Controllers\Staff\CategoryController::class);
        Route::resource('purchase-orders', App\Http\Controllers\Staff\PurchaseOrderController::class);
        Route::get('/purchase-orders/{id}', [App\Http\Controllers\Staff\PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
    });
});

