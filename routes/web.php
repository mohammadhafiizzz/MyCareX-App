<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Patient\Auth\RegistrationController as PatientRegistrationController;
use App\Http\Controllers\Patient as Patient;
use App\Http\Controllers\Organisation as Organisation;
use App\Http\Controllers\Admin as Admin;

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

    // Password Reset
    Route::middleware('guest:patient')->group(function () {
        Route::get('/forgot-password', [Patient\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])
            ->name('patient.password.request');
        Route::post('/forgot-password', [Patient\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('patient.password.email');
        Route::get('/reset-password/success', [Patient\Auth\ForgotPasswordController::class, 'showSuccess'])
            ->name('password.reset.success');
        Route::get('/reset-password/{token}', [Patient\Auth\ForgotPasswordController::class, 'showResetForm'])
            ->name('password.reset');
        Route::post('/reset-password', [Patient\Auth\ForgotPasswordController::class, 'reset'])
            ->name('patient.password.update');
    });

    // Patient Dashboard (Protected)
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

// Organisation Routes
Route::prefix('organisation')->middleware(['web'])->group(function () {
    // Organisation Login Page
    Route::get('/', [Organisation\Auth\LoginController::class, 'showLoginPage'])->name('organisation.login');
});

// Admin Routes
Route::prefix('admin')->middleware(['web'])->group(function () {
    // Admin Login
    Route::get('/', [Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [Admin\Auth\LoginController::class, 'login'])->name('admin.login.submit');

    // Admin Logout
    Route::post('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');

    // Admin Registration
    Route::get('/register', [Admin\Auth\RegistrationController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/register', [Admin\Auth\RegistrationController::class, 'register'])->name('admin.register');

    // Admin Dashboard
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('auth:admin');

    // Admin Management Page
    Route::get('/management', [Admin\AdminManagementController::class, 'index'])
        ->name('admin.management')
        ->middleware('auth:admin');

    // Get lists of admins
    Route::get('management/list/{status}', [Admin\AdminManagementController::class, 'listAdmins'])
        ->name('admin.management.list')
        ->middleware('auth:admin');
});

