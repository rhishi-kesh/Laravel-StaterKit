<?php

use App\Http\Controllers\Backend\FaQController;
use App\Http\Controllers\Backend\Settings\DynamicPageController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;


Route::get('/page/privacy-and-policy', [PageController::class, 'privacyAndPolicy'])->name('dynamicPage.privacyAndPolicy');
