<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/trips', fn () => view('pages.trips.index'))->name('trips.index');
Route::get('/trips/{trip:slug}', [TripController::class, 'show'])->name('trips.show');

Route::get('/blog', fn () => view('pages.blog.index'))->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/about', fn () => view('pages.about.index'))->name('about.index');
Route::get('/contact', fn () => view('pages.contact.index'))->name('contact.index');

Route::get('/design-system', function () {
    return view('design-system');
})->name('design-system');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn () => view('pages.dashboard.index'))->name('dashboard');
    Route::get('/dashboard/bookings', fn () => view('pages.dashboard.bookings'))->name('dashboard.bookings');
    Route::get('/dashboard/wishlist', fn () => view('pages.dashboard.wishlist'))->name('dashboard.wishlist');
    Route::get('/dashboard/profile', fn () => view('pages.dashboard.profile'))->name('dashboard.profile');

    Route::get('/trips/{trip:slug}/book', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/{booking:booking_code}', [BookingController::class, 'show'])->name('bookings.show');
});

