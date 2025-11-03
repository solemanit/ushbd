<?php

use App\Http\Controllers\Auth\{
    AuthenticatedSessionController,
    ConfirmablePasswordController,
    EmailVerificationNotificationController,
    EmailVerificationPromptController,
    NewPasswordController,
    PasswordController,
    PasswordResetLinkController,
    RegisteredUserController,
    VerifyEmailController
};
use App\Http\Controllers\Frontend\UserDashboardController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest:web')->group(function () {
    // Redirect all GET requests to 404
    collect(['register', 'login', 'forgot-password'])->each(function ($route) {
        Route::get($route, fn() => abort(404));
    });

    // Auth Routes
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Password Reset Routes
    Route::controller(NewPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password', 'store')->name('password.store');
    });
});

// Authenticated Routes
Route::middleware('auth:web')->group(function () {
    // Email Verification Routes
    Route::controller(EmailVerificationPromptController::class)
        ->prefix('verify-email')
        ->group(function () {
            Route::get('/', '__invoke')->name('verification.notice');
            Route::get('{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');
            Route::post('/notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');
        });

    // Password Management Routes
    Route::controller(ConfirmablePasswordController::class)
        ->prefix('confirm-password')
        ->group(function () {
            Route::get('/', 'show')->name('password.confirm');
            Route::post('/', 'store');
        });

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Student Routes
Route::group([
    'middleware' => ['auth:web', 'verified', 'check_role:user'],
    'prefix' => 'user',
    'as' => 'user.',
], function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});
