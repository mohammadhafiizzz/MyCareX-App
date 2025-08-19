<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Patient\Auth\RegistrationController as PatientRegistrationController;

// MyCareX Home Page
Route::get('/', [HomePageController::class, 'index'])->name('index');

// Patient Routes
Route::prefix('patient')->group(function () {
    Route::get('/register', [PatientRegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [PatientRegistrationController::class, 'register']);
});

