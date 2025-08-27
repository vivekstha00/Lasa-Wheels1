<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;


// Change these to match your JavaScript calls
Route::post('/forgot-password', [AuthController::class, 'forgetPassword']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
