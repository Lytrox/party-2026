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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('registration', 'pages::rsvp')->name('registration');
    Route::livewire('faq', 'pages::faq')->name('faq');
});

require __DIR__.'/settings.php';
