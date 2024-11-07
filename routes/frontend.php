<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ResetController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

//! Route for Reset Database and Optimize Clear
Route::get('/reset', [ResetController::class, 'RunMigrations'])->name('reset');

//! Route for Landing Page
Route::get('/', [HomeController::class, 'index'])->name('welcome');

//Dynamic Page
Route::get('/page/privacy-and-policy', [PageController::class, 'privacyAndPolicy'])->name('dynamicPage.privacyAndPolicy');
