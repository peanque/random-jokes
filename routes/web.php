<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\JokesController;
use App\Http\Middleware\EnsureWebUserIsAuthenticated;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.show');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.show');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/jokes', [JokesController::class, 'showJokes'])->name('jokes');
});
