<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('auth.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('auth.reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::delete('/bookings/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('movies', AdminMovieController::class);
});
