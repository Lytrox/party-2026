<?php

use Illuminate\Support\Facades\Route;

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');
