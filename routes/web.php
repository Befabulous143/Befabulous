<?php

use App\MicroSite\Auth\Controllers\AuthController;
use App\MicroSite\DashBoard\Controllers\DashboardController;
use App\MicroSite\DashBoard\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/**
 * auth routes
 */
Route::get('/', [AuthController::class, 'index'])->name('login_page');
/** Register routes */
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/create', [AuthController::class, 'create'])->name('create');
Route::get('/verify-mobile', [AuthController::class, 'mobileVerification'])->name('mobile_verification');
Route::post('/send-otp', [AuthController::class, 'sendOtpToMobile'])->name('send-otp');
Route::get('/otp', [AuthController::class, 'otpIndex'])->name('otp-index');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify-otp');

/** Login route */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/** Forget Password */
Route::get('/forget-password', [AuthController::class, 'forgetPassword'])->name('forget_password');
Route::post('/update-forget-password', [AuthController::class, 'updateForgetPassword'])->name('update_forget_password');
Route::get('/forget-password-otp-page', [AuthController::class, 'forgetPasswordOtpPage'])->name('forget_password_otp_page');
Route::post('/forget_password_verify_otp', [AuthController::class, 'validateOtpForForgetPassword'])->name('forget_password_verify_otp');

//email check 
Route::post('/email-check',[AuthController::class, 'emailVerify'])->name('email-verify');
Route::post('/mobile-check',[AuthController::class, 'mobileVerify'])->name('mobile-verify');

Route::group(['middleware' => 'auth_login'], function () {
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboardView'])->name('dashboard');
    //coupens
    Route::get('/terms&conditions', [ProfileController::class, 'termsConditions'])->name('terms');
    //profile
    Route::get('/user', [ProfileController::class, 'index'])->name('profile');
    Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
    Route::post('/update', [ProfileController::class, 'update'])->name('update');
    Route::post('/delete', [ProfileController::class, 'delete'])->name('delete');
    Route::get('/change_password', [ProfileController::class, 'changePassword'])->name('change_password');
    Route::post('/update_password', [ProfileController::class, 'updatePassword'])->name('update_password');
    //point history
    Route::any('/point_history', [DashboardController::class, 'pointHistory'])->name('point_history');
});
