<?php

use App\Http\Controllers\Api\AdController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SearchConroller;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



//Social Login
Route::post('/social-login', [SocialAuthController::class, 'socialLogin']);

//Register API
Route::controller(RegisterController::class)->prefix('users/register')->group(function () {
    // User Register
    Route::post('/', 'userRegister');

    // Verify OTP
    Route::post('/otp-verify', 'otpVarify');

    // Resend OTP
    Route::post('/otp-resend', 'otpResend');
});

//Login API
Route::controller(LoginController::class)->prefix('users/login')->group(function () {

    // User Login
    Route::post('/', 'userLogin');

    // Verify Email
    Route::post('/email-verify', 'emailVarify');

    // Resend OTP
    Route::post('/otp-resend', 'otpResend');

    // Verify OTP
    Route::post('/otp-verify', 'otpVarify');

    //Reset Password
    Route::post('/reset-password', 'resetPassword');
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('/users/data', [UserController::class, 'userData']);
    Route::post('/users/update/{id}', [UserController::class, 'userUpdate']);
    Route::post('/users/logout', [UserController::class, 'logoutUser']);
    Route::delete('/users/delete', [UserController::class, 'deleteUser']);

    //Category API
    Route::get('/categorys', [CategoryController::class, 'category']);
    Route::get('/categorys/all', [CategoryController::class, 'categoryAll']);

    //Search Ad
    Route::post('/search/ad', [SearchConroller::class, 'searchAd']);

    //Create Ad
    Route::post('/ad/create', [AdController::class, 'store']);

    //Edit Ad
    Route::post('/ad/edit/{id}', [AdController::class, 'edit']);

    //My Ad
    Route::get('/my/ads', [AdController::class, 'myAd']);

    //Ad API
    Route::get('/ads', [AdController::class, 'ad']);
    Route::get('/category/{id}/ads', [AdController::class, 'adsUnderCategory']);
    Route::get('/single/{id}/ad', [AdController::class, 'singleAd']);

    // Route to add/remove a product from favorites
    Route::post('/bookmark/toggle', [BookmarkController::class, 'toggleBookmark']);
    Route::get('/bookmarks', [BookmarkController::class, 'getBookmarks']);


    //Notification API
    Route::get('/notifications', [NotificationController::class, 'index']);
});
