<?php

use Illuminate\Support\Facades\Route;
use SalvaTerol\MagicLinkLogin\Controllers\AuthController;

Route::middleware('guest')->group(callback: function () {
    Route::view('/login', 'magic-link-login::pages.login')->name('login');
    Route::get('/auth/{service}/callback', [AuthController::class, 'handleProviderCallback'])->name('login.callback');
    Route::get('/login/{token}', [AuthController::class, 'loginWithToken'])->name('login.token')->middleware('signed');
});
