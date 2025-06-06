<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ShowtimeController;
use App\Http\Middleware\AdminMiddleware;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

// Setup Route (temporary, remove after use)
Route::get('/setup/create-admin', [SetupController::class, 'createAdmin']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('auth.forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('auth.reset-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Booking Routes
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/create/{showtime}', [BookingController::class, 'create'])->name('create');
        Route::post('/{showtime}', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('/{booking}/confirmation', [BookingController::class, 'showConfirmation'])->name('confirmation');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
        Route::put('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
        Route::get('/seats/{showtime}', [BookingController::class, 'showSeatSelection'])->name('seats');
        Route::post('/payment/{booking}', [BookingController::class, 'payment'])->name('payment');
        Route::get('/payment/{booking}', [BookingController::class, 'payment'])->name('payment');
    });
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    
    // Movie Routes
    Route::prefix('movies')->name('movies.')->group(function () {
        Route::get('/', [AdminMovieController::class, 'index'])->name('index');
        Route::get('/create', [AdminMovieController::class, 'create'])->name('create');
        Route::post('/', [AdminMovieController::class, 'store'])->name('store');
        Route::get('/{movie}/edit', [AdminMovieController::class, 'edit'])->name('edit');
        Route::put('/{movie}', [AdminMovieController::class, 'update'])->name('update');
        Route::delete('/{movie}', [AdminMovieController::class, 'destroy'])->name('destroy');
    });
    
    // Showtime Routes
    Route::prefix('showtimes')->name('showtimes.')->group(function () {
        Route::get('/', [ShowtimeController::class, 'index'])->name('index');
        Route::get('/create', [ShowtimeController::class, 'create'])->name('create');
        Route::post('/', [ShowtimeController::class, 'store'])->name('store');
        Route::get('/{showtime}/edit', [ShowtimeController::class, 'edit'])->name('edit');
        Route::put('/{showtime}', [ShowtimeController::class, 'update'])->name('update');
        Route::delete('/{showtime}', [ShowtimeController::class, 'destroy'])->name('destroy');
    });
    
    Route::resource('users', AdminUserController::class)->except(['show']);
    
    // Screen Routes
    Route::resource('screens', App\Http\Controllers\Admin\ScreenController::class);
});
