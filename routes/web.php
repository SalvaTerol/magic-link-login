<?php

use Illuminate\Support\Facades\Route;
use SalvaTerol\MagicLinkLogin\Controllers\AuthController;

Route::middleware(['web', 'guest'])->group(callback: function () {
    Route::view('/login', 'magic-link-login::pages.login')->name('login');
    Route::get('/auth/callback/{service}', [AuthController::class, 'handleProviderCallback'])->name('login.callback');
    Route::get('/auth/{service}', [AuthController::class, 'redirectToProvider'])->name('login.redirect');
    Route::get('/login/{token}', [AuthController::class, 'loginWithToken'])->name('login.token')->middleware('signed');
});
