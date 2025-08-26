<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Patient\Auth\RegistrationController as PatientRegistrationController;
use App\Http\Controllers\Patient as Patient;

// MyCareX Home Page
Route::get('/', [HomePageController::class, 'index'])->name('index');

// Patient Routes
Route::prefix('patient')->middleware(['web'])->group(function () {
    // Patient Registration
    Route::get('/register', [PatientRegistrationController::class, 'showRegistrationForm'])->name('patient.register.form');
    Route::post('/register', [PatientRegistrationController::class, 'register'])->name('patient.register');

    // Email verification
    Route::get('/email/verify', [PatientRegistrationController::class, 'showEmailVerificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [PatientRegistrationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/verification-notification', [PatientRegistrationController::class, 'resend'])->name('verification.resend');
    Route::get('/email/verified', [PatientRegistrationController::class, 'showEmailVerified'])->name('verification.success');

    // Patient Login
    Route::post('/login', [Patient\Auth\LoginController::class, 'login'])->name('patient.login');

    // Patient Logout
    Route::post('/logout', [Patient\Auth\LoginController::class, 'logout'])->name('patient.logout');

    // Patient Dashboard (should be protected)
    Route::get('/dashboard', [Patient\DashboardController::class, 'index'])
        ->name('patient.dashboard')
        ->middleware('auth:patient');

    // Patient Profile
    Route::get('/profile', [Patient\ProfileController::class, 'showProfilePage'])
        ->name('patient.profile')
        ->middleware('auth:patient');

    // Profile Update Routes (Protected)
    Route::middleware('auth:patient')->group(function () {
        Route::put('/profile/personal-info', [Patient\UpdateProfileController::class, 'updatePersonalInfo'])
            ->name('patient.profile.update.personal');

        Route::put('/profile/physical-info', [Patient\UpdateProfileController::class, 'updatePhysicalInfo'])
            ->name('patient.profile.update.physical');

        Route::put('/profile/address-info', [Patient\UpdateProfileController::class, 'updateAddressInfo'])
            ->name('patient.profile.update.address');

        Route::put('/profile/emergency-contact', [Patient\UpdateProfileController::class, 'updateEmergencyInfo'])
            ->name('patient.profile.update.emergency');

        Route::put('/profile/password', [Patient\UpdateProfileController::class, 'updatePassword'])
            ->name('patient.profile.update.password');

        Route::put('/profile/picture', [Patient\UpdateProfileController::class, 'updateProfilePicture'])
            ->name('patient.profile.update.picture');

        Route::delete('/profile/account', [Patient\DeleteProfileController::class, 'deleteAccount'])
            ->name('patient.profile.delete.account');

        Route::delete('/profile/picture', [Patient\DeleteProfileController::class, 'deleteProfilePicture'])
            ->name('patient.profile.delete.picture');
    });
});

