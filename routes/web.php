<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;

// Public routes
Route::get('/', [VehicleController::class, 'index'])->name('home');

Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerStore'])->name('user.register.store');

Route::get('/login', [LoginController::class, 'index'])->name('user.login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin routes (temporarily without authentication)
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('dashboard');
    
    // Vehicle management routes - using simple names without vehicles prefix
    Route::get('/manage', [AdminVehicleController::class, 'index'])->name('manage');
    Route::get('/create', [AdminVehicleController::class, 'create'])->name('create');
    Route::post('/store', [AdminVehicleController::class, 'store'])->name('store');
    Route::get('/edit/{vehicle}', [AdminVehicleController::class, 'edit'])->name('edit');
    Route::put('/update/{vehicle}', [AdminVehicleController::class, 'update'])->name('update');
    Route::delete('/delete/{vehicle}', [AdminVehicleController::class, 'destroy'])->name('delete');
});
