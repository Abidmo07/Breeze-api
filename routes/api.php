<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class,'getUser'])->name('user');
    //events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
      Route::get('/events/search', [EventController::class, 'search'])->name('events.search');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    // bookings
    Route::post('/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get("/bookings",[BookingController::class,"index"])->name("bookings.index");
    Route::get("/bookings/{booking}",[BookingController::class,"show"])->name("bookings.show");
    Route::delete("/cancel/{booking}",[BookingController::class,"cancel"])->name("bookings.destroy");    
    Route::put("/bookings/{booking}",[BookingController::class,"update"])->name("bookings.update");

  
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/event', [EventController::class, 'store'])->name('events.store');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

});
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
  

Route::post('/logini', [AuthController::class,'logini'])->name('logini');
Route::middleware('auth:sanctum')->post('/logouti', [AuthController::class,"logouti"])->name('logouti');
