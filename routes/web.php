<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('/register-secret', function () {
    session(['can_register' => true]);

    return redirect()->route('register');
})->middleware('guest')->name('register.secret');

Route::livewire('privacy-policy', 'pages::privacy-policy')->name('privacy-policy');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('registration', 'pages::rsvp')->name('registration');
    Route::livewire('faq', 'pages::faq')->name('faq');
    Route::livewire('house-rules', 'pages::house-rules')->name('house-rules');
});

require __DIR__.'/settings.php';
