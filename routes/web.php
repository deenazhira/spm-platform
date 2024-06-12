<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReflectionController;


Route::get('/', function () {
    return view('mainpage');
});

Route::get('/reflection', function () {
    return view('reflection');
});

Route::get('/index', function () {
    return view('subjects.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('reflections', ReflectionController::class);
    Route::get('/reflection', [ReflectionController::class, 'index'])->name('reflection.index');

    Route::delete('/reflection/{reflection}', [ReflectionController::class, 'destroy'])
     ->name('reflection.destroy');

});

use App\Http\Controllers\RegisterController;

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login Routes
Route::get('/login', [RegisterController::class, 'showLoginForm'])->name('login');
Route::post('/login', [RegisterController::class, 'login']);

// Logout Route
Route::post('/logout', [RegisterController::class, 'logout'])->name('logout');


