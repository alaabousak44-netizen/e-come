<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TravelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TravelController::class, 'home'])->name('home');
Route::get('/search-results', [TravelController::class, 'search'])->name('search');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/welcome', [MemberController::class, 'welcome'])->name('welcome');
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/my-bookings', [MemberController::class, 'bookings'])->name('bookings');
    Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
    Route::put('/profile', [MemberController::class, 'updateProfile'])->name('profile.update');

    Route::get('/packages/{package}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/packages/{package}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}/confirmation', [BookingController::class, 'confirmation'])->name('bookings.confirmation');
});
