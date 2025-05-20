<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        
        Route::resource('staff', \App\Http\Controllers\Admin\StaffController::class);
    });

    // Staff routes
    Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', function () {
            return view('staff.dashboard');
        })->name('dashboard');
        Route::get('/purchase-orders', function () {
            return view('staff.purchase_orders');
        })->name('purchase_orders');
        // Add more staff routes here if needed
        Route::resource('products', App\Http\Controllers\Staff\ProductController::class);
        Route::resource('categories', App\Http\Controllers\Staff\CategoryController::class);
        Route::resource('purchase-orders', App\Http\Controllers\Staff\PurchaseOrderController::class);
    });
});