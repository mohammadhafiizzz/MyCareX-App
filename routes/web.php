<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Patient\Auth\RegistrationController as PatientRegistrationController;
use App\Http\Controllers\Patient as Patient;

// MyCareX Home Page
Route::get('/', [HomePageController::class, 'index'])->name('index');

// Patient Routes
Route::prefix('patient')->group(function () {
    // Patient Registration
    Route::get('/register', [PatientRegistrationController::class, 'showRegistrationForm'])->name('patient.register.form');
    Route::post('/register', [PatientRegistrationController::class, 'register'])->name('patient.register');

    // Patient Login
    Route::get('/login', [Patient\Auth\LoginController::class, 'showLoginForm'])->name('patient.login.form');
    Route::post('/login', [Patient\Auth\LoginController::class, 'login'])->name('patient.login');

    // Patient Dashboard (should be protected)
    Route::get('/dashboard', [Patient\DashboardController::class, 'index'])
        ->name('patient.dashboard')
        ->middleware('auth:patient');
});

