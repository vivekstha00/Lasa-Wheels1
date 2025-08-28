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
use App\Http\Controllers\User\AuthController;


// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'registerStore'])->name('user.register.store');
Route::get('/login', [LoginController::class, 'index'])->name('user.login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot password routes
Route::get('/forgot-password', function () {
    return view('user.pages.forgot-password');
})->name('forgot-password');

Route::post('/api/forgot-password', [AuthController::class, 'forgetPassword']);
Route::post('/api/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/api/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth'])->group(function () {
    Route::get('/vehicle', [VehicleController::class, 'index'])->name('vehicle');
    Route::get('/vehicle/{vehicle}', [VehicleController::class, 'show'])->name('vehicle.show');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/about', [AboutController::class, 'index'])->name('about');
    Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    Route::middleware([AdminMiddleware::class])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('vehicles', AdminVehicleController::class, ['as' => 'admin']);
        Route::resource('users', AdminUserController::class, ['as' => 'admin']);
    });
});
