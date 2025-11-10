<?php

use App\Http\Controllers\Admin\{
    AdminController,
    AdminOrderController,
    BannerController,
    BrandController,
    CardVariantController,
    ContactUsController,
    DashboardController,
    PageController,
    ProductController,
    ServiceController
};
use App\Http\Controllers\Admin\Auth\{
    AuthenticatedSessionController,
    ConfirmablePasswordController,
    EmailVerificationNotificationController,
    EmailVerificationPromptController,
    NewPasswordController,
    PasswordController,
    PasswordResetLinkController,
    VerifyEmailController
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Guest Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'guest:admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // Authentication
    Route::controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('login');
        Route::post('login', 'store')->name('login.store');
    });

    // Password Reset
    Route::controller(PasswordResetLinkController::class)->group(function () {
        Route::get('forgot-password', 'create')->name('password.request');
        Route::post('forgot-password', 'store')->name('password.email');
    });

    Route::controller(NewPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'create')->name('password.reset');
        Route::post('reset-password', 'store')->name('password.store');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'auth:admin',
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // Email Verification
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Password Management
    Route::controller(ConfirmablePasswordController::class)->group(function () {
        Route::get('confirm-password', 'show')->name('password.confirm');
        Route::post('confirm-password', 'store');
    });

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // Authentication
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Admin Profile
    Route::resource('profile', AdminController::class)
        ->parameters(['profile' => 'admin']);

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('banners', BannerController::class);
    Route::resource('brands', BrandController::class);
    // Products
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');

    Route::resource('pages', PageController::class)->except(['show']);
    Route::resource('contact', ContactUsController::class);
    Route::resource('card-variants', CardVariantController::class);

});
