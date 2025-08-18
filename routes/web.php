<?php

use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

// MyCareX Home Page
Route::get('/', [HomePageController::class, 'index'])->name('index');

// Registration Page
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

