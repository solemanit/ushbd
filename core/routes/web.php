<?php

use App\Http\Controllers\Frontend\CardViewController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\PageShowController;
use App\Mail\ContactFormMail;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Group routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'user'
            ? redirect()->route('user.dashboard')
            : abort(403, 'Unauthorized.');
    })->name('dashboard');
});

// Email verification route
Route::get('/email/verification-notification', function () {
    return auth()->check()
        ? redirect()->route('verification.notice')
        : redirect()->route('login');
});

// Debug route - should be disabled in production
if (config('app.debug')) {
    Route::get('/session-dump', fn() => response()->json(session()->all()));
}

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return "All cache cleared successfully!";
});

// Frontend route
Route::get('/', [FrontendController::class, 'index'])->name('home');

Route::get('/page/{slug}', [PageShowController::class, 'show'])->name('page.show');

// ✅ Gift Card Page & Filtering Routes

// Cards Page & Filter
Route::get('/cards', [FrontendController::class, 'cards'])->name('cards.index');
Route::get('/cards/filter', [FrontendController::class, 'filterCards'])->name('cards.filter');

Route::get('/card/{slug}', [CardViewController::class, 'show'])->name('card.view');

Route::get('/checkout/{product}', [OrderController::class, 'checkout'])->name('checkout.page');
Route::post('/checkout/store', [OrderController::class, 'store'])->name('checkout.store');

Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/about', function () {
   return view('frontend.pages.about.index');
})->name('about');


Route::get('/services', [FrontendController::class, 'services'])->name('services.index');
Route::get('/service/{slug}', [FrontendController::class, 'show'])->name('service.show');

// Include other route files
require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';
