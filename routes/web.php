<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Admin as Admin;
use App\Http\Controllers\Patient as Patient;
use App\Http\Controllers\Organisation as Organisation;
use App\Http\Controllers\Doctor as Doctor;
use App\Http\Controllers\Modules as Modules;

// MyCareX Home Page
Route::get('/', [HomePageController::class, 'index'])->name('index');

// Patient Routes
Route::prefix('patient')->group(function () {

    // Patient Registration
    Route::get('/register', [Patient\Auth\RegistrationController::class, 'showRegistrationForm'])->name('patient.register.form');
    Route::post('/register', [Patient\Auth\RegistrationController::class, 'register'])->name('patient.register');

    // Email verification
    Route::get('/email/verify', [Patient\Auth\RegistrationController::class, 'showEmailVerificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [Patient\Auth\RegistrationController::class, 'verify'])->name('verification.verify');
    Route::post('/email/verification-notification', [Patient\Auth\RegistrationController::class, 'resend'])->name('verification.resend');
    Route::get('/email/verified', [Patient\Auth\RegistrationController::class, 'showEmailVerified'])->name('verification.success');

    // Patient Login
    Route::get('/login', [Patient\Auth\LoginController::class, 'showLoginForm'])->name('patient.login.form');
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

    // Authenticated Patient Routes (Protected)
    Route::middleware(['auth:patient', 'verified'])->group(function () {

        // Patient Dashboard
        Route::get('/dashboard', [Patient\DashboardController::class, 'index'])
            ->name('patient.dashboard');

        // Patient Profile
        Route::get('/profile', [Patient\ProfileController::class, 'showProfilePage'])
            ->name('patient.auth.profile');

        // Update and Delete Profile
        Route::put('/profile/personal-info', [Patient\UpdateProfileController::class, 'updatePersonalInfo'])
            ->name('patient.auth.profile.update.personal');

        Route::put('/profile/physical-info', [Patient\UpdateProfileController::class, 'updatePhysicalInfo'])
            ->name('patient.auth.profile.update.physical');

        Route::put('/profile/address-info', [Patient\UpdateProfileController::class, 'updateAddressInfo'])
            ->name('patient.auth.profile.update.address');

        Route::put('/profile/emergency-contact', [Patient\UpdateProfileController::class, 'updateEmergencyInfo'])
            ->name('patient.auth.profile.update.emergency');

        Route::put('/profile/password', [Patient\UpdateProfileController::class, 'updatePassword'])
            ->name('patient.auth.profile.update.password');

        Route::put('/profile/picture', [Patient\UpdateProfileController::class, 'updateProfilePicture'])
            ->name('patient.auth.profile.update.picture');

        Route::delete('/profile/account', [Patient\DeleteProfileController::class, 'deleteAccount'])
            ->name('patient.auth.profile.delete.account');

        Route::delete('/profile/picture', [Patient\DeleteProfileController::class, 'deleteProfilePicture'])
            ->name('patient.auth.profile.delete.picture');

        // My Records
        Route::prefix('/my-records')->group(function () {
            // My Records Main Page
            Route::get('/', [Patient\MyRecordsController::class, 'index'])
                ->name('patient.myrecords');

            // Medical Conditions (CRUD)
            Route::prefix('/medical-conditions')->group(function () {

                // Medical Conditions Page
                Route::get('/', [Modules\MedicalCondition\MedicalConditionController::class, 'index'])
                    ->name('patient.medicalCondition');

                // Export Medical Conditions as PDF
                Route::get('/export-pdf', [Modules\MedicalCondition\ExportConditionsController::class, 'exportPdf'])
                    ->name('patient.condition.export.pdf');

                // Add Medical Condition
                Route::post('/add', [Modules\MedicalCondition\AddConditionController::class, 'add'])
                    ->name('patient.condition.add');

                Route::get('/condition/{condition}/json', [Modules\MedicalCondition\MedicalConditionController::class, 'getConditionJson'])
                    ->name('patient.condition.json');

                // Upload Attachment for Medical Condition
                Route::post('/{condition}/upload-attachment', [Modules\MedicalCondition\UploadAttachmentController::class, 'upload'])
                    ->name('patient.condition.upload.attachment');

                // Delete Attachment for Medical Condition
                Route::delete('/{condition}/delete-attachment', [Modules\MedicalCondition\UploadAttachmentController::class, 'deleteAttachment'])
                    ->name('patient.condition.delete.attachment');

                // Update Medical Condition
                Route::put('/{condition}', [Modules\MedicalCondition\UpdateConditionController::class, 'update'])
                    ->name('patient.condition.update');

                // Delete Medical Condition
                Route::delete('/{condition}', [Modules\MedicalCondition\DeleteConditionController::class, 'delete'])
                    ->name('patient.condition.delete');

                // More info Medical Condition
                Route::get('/{condition}', [Modules\MedicalCondition\MedicalConditionController::class, 'moreInfo'])
                    ->name('patient.condition.info');
            });

            // Medication (CRUD)
            Route::prefix('/medication')->group(function () {

                // Medication Page
                Route::get('/', [Modules\Medication\MedicationController::class, 'index'])
                    ->name('patient.medication');

                // Export Medications as PDF
                Route::get('/export-pdf', [Modules\Medication\ExportMedicationsController::class, 'exportPdf'])
                    ->name('patient.medication.export.pdf');

                // Add Medication
                Route::post('/add', [Modules\Medication\AddMedicationController::class, 'add'])
                    ->name('patient.medication.add');

                // Update Medication
                Route::put('/{medication}', [Modules\Medication\UpdateMedicationController::class, 'update'])
                    ->name('patient.medication.update');

                // Delete Medication
                Route::delete('/{medication}', [Modules\Medication\DeleteMedicationController::class, 'delete'])
                    ->name('patient.medication.delete');

                // Get Medication JSON (for edit form)
                Route::get('/{medication}/json', [Modules\Medication\MedicationController::class, 'getJson'])
                    ->name('patient.medication.json');

                // Upload Image for Medication
                Route::post('/{medication}/upload-image', [Modules\Medication\UploadMedicationImageController::class, 'upload'])
                    ->name('patient.medication.upload.image');

                // Delete Image for Medication
                Route::delete('/{medication}/delete-image', [Modules\Medication\UploadMedicationImageController::class, 'deleteImage'])
                    ->name('patient.medication.delete.image');

                // Medication More Info
                Route::get('/{medication}', [Modules\Medication\MedicationController::class, 'moreInfo'])
                    ->name('patient.medication.info');

            });

            // Allergies (CRUD)
            Route::prefix('/allergies')->group(function () {

                // Allergies Page
                Route::get('/', [Modules\Allergy\AllergyController::class, 'index'])
                    ->name('patient.allergy');

                // Add Allergy
                Route::post('/add', [Modules\Allergy\AllergyController::class, 'store'])
                    ->name('patient.allergy.add');

                // Export Allergies as PDF
                Route::get('/export-pdf', [Modules\Allergy\AllergyController::class, 'exportPdf'])
                    ->name('patient.allergy.export.pdf');

                // Get Allergy JSON (for edit form)
                Route::get('/allergy/{allergy}/json', [Modules\Allergy\AllergyController::class, 'getAllergyJson'])
                    ->name('patient.allergy.json');

                // Update Allergy
                Route::put('/{allergy}', [Modules\Allergy\AllergyController::class, 'update'])
                    ->name('patient.allergy.update');

                // Delete Allergy
                Route::delete('/{allergy}', [Modules\Allergy\AllergyController::class, 'destroy'])
                    ->name('patient.allergy.delete');

                // Allergy More Info
                Route::get('/{allergy}', [Modules\Allergy\AllergyController::class, 'show'])
                    ->name('patient.allergy.info');

            });

            // Immunisation (CRUD)
            Route::prefix('/immunisation')->group(function () {

                // Immunisation Page
                Route::get('/', [Modules\Immunisation\ImmunisationController::class, 'index'])
                    ->name('patient.immunisation');

                // Add Vaccination
                Route::post('/add', [Modules\Immunisation\ImmunisationController::class, 'store'])
                    ->name('patient.immunisation.add');

                // Export Immunisations as PDF
                Route::get('/export', [Modules\Immunisation\ImmunisationController::class, 'exportPdf'])
                    ->name('patient.immunisation.export');

                // Get Immunisation JSON (for edit form)
                Route::get('/immunisation/{immunisation}/json', [Modules\Immunisation\ImmunisationController::class, 'getImmunisationJson'])
                    ->name('patient.immunisation.json');

                // Upload Certificate for Immunisation
                Route::post('/{immunisation}/upload-certificate', [Modules\Immunisation\ImmunisationController::class, 'uploadCertificate'])
                    ->name('patient.immunisation.upload.certificate');

                // Delete Certificate for Immunisation
                Route::delete('/{immunisation}/delete-certificate', [Modules\Immunisation\ImmunisationController::class, 'deleteCertificate'])
                    ->name('patient.immunisation.delete.certificate');

                // Update Immunisation
                Route::put('/{immunisation}', [Modules\Immunisation\ImmunisationController::class, 'update'])
                    ->name('patient.immunisation.update');

                // Delete Immunisation
                Route::delete('/{immunisation}', [Modules\Immunisation\ImmunisationController::class, 'destroy'])
                    ->name('patient.immunisation.delete');

                // Immunisation More Info
                Route::get('/{immunisation}', [Modules\Immunisation\ImmunisationController::class, 'show'])
                    ->name('patient.immunisation.info');

            });

            // Lab Tests (CRUD)
            Route::prefix('/lab-tests')->group(function () {

                // Lab Tests Page
                Route::get('/', [Modules\Lab\LabTestController::class, 'index'])
                    ->name('patient.lab');

                // Add Lab Test
                Route::post('/add', [Modules\Lab\LabTestController::class, 'store'])
                    ->name('patient.lab.add');

                // Export Lab Tests as PDF
                Route::get('/export', [Modules\Lab\LabTestController::class, 'exportPdf'])
                    ->name('patient.lab.export');

                // Get Lab Test JSON (for edit form)
                Route::get('/test/{labTest}/json', [Modules\Lab\LabTestController::class, 'getLabTestJson'])
                    ->name('patient.lab.json');

                // Upload Attachment for Lab Test
                Route::post('/{labTest}/upload-attachment', [Modules\Lab\LabTestController::class, 'uploadAttachment'])
                    ->name('patient.lab.upload.attachment');

                // Update Lab Test
                Route::put('/{labTest}', [Modules\Lab\LabTestController::class, 'update'])
                    ->name('patient.lab.update');

                // Delete Lab Test
                Route::delete('/{labTest}', [Modules\Lab\LabTestController::class, 'destroy'])
                    ->name('patient.lab.delete');

                // Lab Test More Info
                Route::get('/{labTest}', [Modules\Lab\LabTestController::class, 'show'])
                    ->name('patient.lab.info');

            });
        });

        // Medical History
        Route::prefix('/medical-history')->group(function () {
            // Medical History Page
            Route::get('/', [Patient\DashboardController::class, 'medicalHistory'])
                ->name('patient.medicalHistory');

            // Surgery History Page
            Route::prefix('/surgery')->group(function () {
                // Surgery History Page
                Route::get('/', [Modules\Surgery\SurgeryController::class, 'index'])
                    ->name('patient.surgery');

                // Add Surgery
                Route::post('/add', [Modules\Surgery\AddSurgeryController::class, 'add'])
                    ->name('patient.surgery.add');

                // Get Surgery JSON (for edit form)
                Route::get('/{surgery}/json', [Modules\Surgery\SurgeryController::class, 'getSurgeryJson'])
                    ->name('patient.surgery.json');

                // Update Surgery
                Route::put('/{surgery}', [Modules\Surgery\UpdateSurgeryController::class, 'update'])
                    ->name('patient.surgery.update');

                // Delete Surgery
                Route::delete('/{surgery}', [Modules\Surgery\DeleteSurgeryController::class, 'delete'])
                    ->name('patient.surgery.delete');

                // Surgery More Info
                Route::get('/{surgery}', [Modules\Surgery\SurgeryController::class, 'moreInfo'])
                    ->name('patient.surgery.info');
            });

            // Hospitalisation History Page
            Route::prefix('/hospitalisation')->group(function () {
                // Hospitalisation History Page
                Route::get('/', [Modules\Hospitalisation\HospitalisationController::class, 'index'])
                    ->name('patient.hospitalisation');

                // Add Hospitalisation
                Route::post('/add', [Modules\Hospitalisation\AddHospitalisationController::class, 'add'])
                    ->name('patient.hospitalisation.add');

                // Get Hospitalisation JSON (for edit form)
                Route::get('/{hospitalisation}/json', [Modules\Hospitalisation\HospitalisationController::class, 'getHospitalisationJson'])
                    ->name('patient.hospitalisation.json');

                // Update Hospitalisation
                Route::put('/{hospitalisation}', [Modules\Hospitalisation\UpdateHospitalisationController::class, 'update'])
                    ->name('patient.hospitalisation.update');

                // Delete Hospitalisation
                Route::delete('/{hospitalisation}', [Modules\Hospitalisation\DeleteHospitalisationController::class, 'delete'])
                    ->name('patient.hospitalisation.delete');

                // Hospitalisation More Info
                Route::get('/{hospitalisation}', [Modules\Hospitalisation\HospitalisationController::class, 'moreInfo'])
                    ->name('patient.hospitalisation.info');
            });
        });

        // Permission Routes
        Route::prefix('/permissions')->group(function () {

            // Permission Page
            Route::get('/', [Modules\Permission\PermissionController::class, 'index'])
                ->name('patient.permission');

            // Authorized Doctors List
            Route::get('/doctors', [Modules\Permission\PermissionController::class, 'doctors'])
                ->name('patient.permission.doctors');

            // Pending Requests List
            Route::get('/requests', [Modules\Permission\PermissionController::class, 'requests'])
                ->name('patient.permission.requests');

            // Activity History
            Route::get('/activity', [Modules\Permission\PermissionController::class, 'activity'])
                ->name('patient.permission.activity');
        });

        // Emergency Kit
        Route::prefix('/emergency-kit')->group(function () {

            // Emergency Kit Main Page
            Route::get('/', [Modules\EmergencyKit\EmergencyKitController::class, 'index'])
            ->name('patient.emergency-kit.index');

            // Create Emergency Kit Item Page
            Route::get('/create', [Modules\EmergencyKit\EmergencyKitController::class, 'create'])
            ->name('patient.emergency-kit.create');

            // Store Emergency Kit Item
            Route::post('/', [Modules\EmergencyKit\EmergencyKitController::class, 'store'])
            ->name('patient.emergency-kit.store');

            // Delete Emergency Kit Item
            Route::delete('/{id}', [Modules\EmergencyKit\EmergencyKitController::class, 'destroy'])
            ->name('patient.emergency-kit.destroy');

            // Fetch Records for Emergency Kit
            Route::get('/fetch-records', [Modules\EmergencyKit\EmergencyKitController::class, 'fetchRecords'])
            ->name('patient.emergency-kit.fetch-records');
        });
    });
});

// Organisation Routes
Route::prefix('organisation')->group(function () {

    // Organisation Home Page
    Route::get('/', [Organisation\HomePageController::class, 'index'])->name('organisation.index');

    // Organisation Login
    Route::get('/login', [Organisation\Auth\LoginController::class, 'showLoginPage'])->name('organisation.login.form');
    Route::post('/login', [Organisation\Auth\LoginController::class, 'login'])->name('organisation.login');

    // Organisation Logout
    Route::post('/logout', [Organisation\Auth\LoginController::class, 'logout'])->name('organisation.logout');

    // Organisation Registration
    Route::get('/register', [Organisation\Auth\RegistrationController::class, 'showRegistrationForm'])->name('organisation.register.form');
    Route::post('/register', [Organisation\Auth\RegistrationController::class, 'register'])->name('organisation.register');

    // Email verification
    Route::prefix('/email')->group(function () {
        Route::get('/verify', [Organisation\Auth\RegistrationController::class, 'showEmailVerificationNotice'])->name('organisation.verification.notice');
        Route::get('/verify/{id}/{hash}', [Organisation\Auth\RegistrationController::class, 'verify'])->name('organisation.verification.verify');
        Route::post('/verification-notification', [Organisation\Auth\RegistrationController::class, 'resend'])->name('organisation.verification.resend');
        Route::get('/verified', [Organisation\Auth\RegistrationController::class, 'showEmailVerified'])->name('organisation.verification.success');
    });
    
    // Authenticated Organisation Routes (Protected)
    Route::middleware(['auth:organisation', 'verified'])->group(function () {
        // Organisation Dashboard
        Route::get('/dashboard', [Organisation\DashboardController::class, 'index'])
            ->name('organisation.dashboard');

        // Doctor Management Routes
        Route::prefix('/doctors')->group(function () {
            // Doctor Management Page
            Route::get('/', [Organisation\DashboardController::class, 'addDoctor'])
                ->name('organisation.addDoctor');
        });
    });
});

// Doctor Routes
Route::prefix('doctor')->group(function () {
    // Doctor Dashboard
    Route::get('/dashboard', [Doctor\DashboardController::class, 'index'])
        ->name('doctor.dashboard');
});

// Admin Routes
Route::prefix('admin')->group(function () {

    // Admin Login
    Route::get('/', [Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [Admin\Auth\LoginController::class, 'login'])->name('admin.login.submit');

    // Admin Logout
    Route::post('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');

    // Admin Registration
    Route::get('/register', [Admin\Auth\RegistrationController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/register', [Admin\Auth\RegistrationController::class, 'register'])->name('admin.register');

    // Authenticated Admin Routes (Protected)
    Route::middleware('auth:admin')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('admin.dashboard');

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

            // Get lists of providers by status
            Route::get('/list/{status}', [Organisation\ProviderManagementController::class, 'listProviders'])
                ->name('organisation.providers.list');

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
});

