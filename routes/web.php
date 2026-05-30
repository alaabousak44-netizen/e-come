<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TravelController;
use App\Http\Controllers\TravelRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TravelController::class, 'home'])->name('home');
Route::get('/search-results', [TravelController::class, 'search'])->name('search');
Route::post('/travel-requests', [TravelRequestController::class, 'store'])->name('travel-requests.store');
Route::get('/travel-requests/sent', [TravelRequestController::class, 'sent'])->name('travel-requests.sent');

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

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/packages', [AdminController::class, 'packages'])->name('packages.index');
        Route::get('/packages/create', [AdminController::class, 'createPackage'])->name('packages.create');
        Route::post('/packages', [AdminController::class, 'storePackage'])->name('packages.store');
        Route::get('/packages/{package}/edit', [AdminController::class, 'editPackage'])->name('packages.edit');
        Route::put('/packages/{package}', [AdminController::class, 'updatePackage'])->name('packages.update');
        Route::delete('/packages/{package}', [AdminController::class, 'destroyPackage'])->name('packages.destroy');
        Route::delete('/packages/{package}/images/{image}', [AdminController::class, 'destroyPackageImage'])->name('packages.images.destroy');
        Route::get('/requests', [AdminController::class, 'requests'])->name('requests.index');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    });
});
