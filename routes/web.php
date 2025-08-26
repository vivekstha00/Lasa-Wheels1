<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminVehicleController;  
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\AboutController;
use App\Http\Controllers\User\BlogController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerStore'])->name('user.register.store');
Route::get('/login', [LoginController::class, 'index'])->name('user.login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle');
    Route::get('/vehicle/{vehicle}', [VehicleController::class, 'show'])->name('vehicle.show');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
});

// Admin login routes (without middleware)
Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'check'])->name('login.check');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});


// Admin protected routes (with middleware)
Route::prefix('admin')->middleware(AdminMiddleware::class)->as('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Vehicle management routes
    Route::controller(AdminVehicleController::class)->group(function () {
        Route::get('/manage', 'index')->name('manage');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{vehicle}', 'edit')->name('edit');
        Route::put('/update/{vehicle}', 'update')->name('update');
        Route::delete('/delete/{vehicle}', 'destroy')->name('delete');
    });

    // User management routes
    Route::prefix('users')->as('users.')->controller(AdminUserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'edit')->name('edit');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'delete')->name('delete');
    });
});
