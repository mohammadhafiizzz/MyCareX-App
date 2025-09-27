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
    // Organisation Home Page
    Route::get('/', [Organisation\HomePageController::class, 'index'])->name('organisation.home');

    // Organisation Registration
    Route::get('/register', [Organisation\Auth\RegistrationController::class, 'showRegistrationForm'])->name('organisation.register.form');
    Route::post('/register', [Organisation\Auth\RegistrationController::class, 'register'])->name('organisation.register');

    // Email verification
    Route::get('/email/verify', [Organisation\Auth\RegistrationController::class, 'showEmailVerificationNotice'])->name('organisation.verification.notice');
    Route::get('/email/verify/{id}/{hash}', [Organisation\Auth\RegistrationController::class, 'verify'])->name('organisation.verification.verify');
    Route::post('/email/verification-notification', [Organisation\Auth\RegistrationController::class, 'resend'])->name('organisation.verification.resend');
    Route::get('/email/verified', [Organisation\Auth\RegistrationController::class, 'showEmailVerified'])->name('organisation.verification.success');
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
    Route::prefix('/management')->group(function () {

        // Admin Management Page
        Route::get('/', [Admin\AdminManagementController::class, 'index'])
            ->name('admin.management');

        // Get lists of admins
        Route::get('/list/{status}', [Admin\AdminManagementController::class, 'listAdmins'])
            ->name('admin.management.list');

        // POST routes for approving/rejecting admin accounts
        // Approve
        Route::post('/approve/{admin:admin_id}', [Admin\AdminManagementController::class, 'approveAdmin'])
            ->name('admin.management.approve');

        // Reject
        Route::post('/reject/{admin:admin_id}', [Admin\AdminManagementController::class, 'rejectAdmin'])
            ->name('admin.management.reject');

        // Delete
        Route::post('/delete/{admin:admin_id}', [Admin\AdminManagementController::class, 'deleteAdmin'])
            ->name('admin.management.delete');
    });

    // Healthcare Provider Management Page
    Route::prefix('/providers')->group(function () {
        // Provider Management Dashboard
        Route::get('/', [Organisation\ProviderManagementController::class, 'index'])
            ->name('organisation.providerManagement');

        // Provider Verification Dashboard
        Route::get('/verification', [Organisation\ProviderManagementController::class, 'providerVerification'])
            ->name('organisation.providerVerification');

        // Provider Verification Requests
        Route::get('/verification-requests', [Organisation\ProviderManagementController::class, 'verificationRequests'])
            ->name('organisation.providers.verification.requests');

        // Approve Provider
        Route::post('/approve/{provider:id}', [Organisation\ProviderManagementController::class, 'approveProvider'])
            ->name('organisation.providers.approve');

        // Reject Provider
        Route::post('/reject/{provider:id}', [Organisation\ProviderManagementController::class, 'rejectProvider'])
            ->name('organisation.providers.reject');

        // Delete Provider
        Route::post('/delete/{provider:id}', [Organisation\ProviderManagementController::class, 'deleteProvider'])
            ->name('organisation.providers.delete');
    });
});

