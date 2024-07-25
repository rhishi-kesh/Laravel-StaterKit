<?php

use App\Http\Controllers\auth\AdminController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\SystemInformationController;
use App\Http\Controllers\ErrorRedirectController;
use App\Http\Controllers\frontend\FrontendController;
use Illuminate\Support\Facades\Route;

//Frontend
Route::get('/', [FrontendController::class, 'index'])->name('index');

//Admin Auth
Route::get('/admin', [AdminController::class, 'adminLogin'])->name('adminLogin');
Route::post('/login-post', [AdminController::class, 'loginPost'])->name('loginPost');
Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

// Error Redirect
Route::get('/404', [ErrorRedirectController::class, 'notFound'])->name('notFound');

//Dashboard
Route::group(['prefix'=>'admin', 'middleware' => 'auth'], function () {

    //Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    //Admin Register
    Route::get('/register', [AdminController::class, 'register'])->name('register');
    Route::post('/register-post', [AdminController::class, 'registerPost'])->name('registerPost');

    //Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/user-delete/{id}', [AdminController::class, 'userDelete'])->name('userDelete');
    Route::get('/user-status/{id}', [AdminController::class, 'userStatus'])->name('userStatus');

    //Admin Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/change-password/{id}', [AdminController::class, 'changePassword'])->name('changePassword');
    Route::post('/change-information/{id}', [AdminController::class, 'changeInformation'])->name('changeInformation');
    Route::post('/change-profile/{id}', [AdminController::class, 'changeProfile'])->name('changeProfile');

    //System Information
    Route::get('/system-information', [SystemInformationController::class, 'systemInformation'])->name('systemInformation');
    Route::post('/system-information-post/{id}', [SystemInformationController::class, 'systemInformationPost'])->name('systemInformationPost');
});


