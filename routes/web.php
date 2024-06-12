<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('mainpage');
});

Route::get('/reflection', function () {
    return view('reflection');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
