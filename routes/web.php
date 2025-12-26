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

        // forgot password form
        Route::get('/forgot-password', [Patient\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])
            ->name('patient.forgot.form');

        // forgot password sent page
        Route::get('/forgot-password/sent', [Patient\Auth\ForgotPasswordController::class, 'showForgotPasswordSent'])
            ->name('patient.forgot.sent');
        
        Route::post('/forgot-password', [Patient\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('patient.password.email');
        Route::get('/reset-password/success', [Patient\Auth\ForgotPasswordController::class, 'showSuccess'])
            ->name('password.reset.success');
        Route::get('/reset-password/{token}', [Patient\Auth\ForgotPasswordController::class, 'showResetForm'])
            ->name('patient.password.reset');
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
            ->name('patient.profile');

        // Update and Delete Profile
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
                Route::get('/', [Modules\Allergy\ReadController::class, 'index'])
                    ->name('patient.allergy');

                // Add Allergy
                Route::post('/add', [Modules\Allergy\CreateController::class, 'store'])
                    ->name('patient.allergy.add');

                // Export Allergies as PDF
                Route::get('/export-pdf', [Modules\Allergy\ReadController::class, 'exportPdf'])
                    ->name('patient.allergy.export.pdf');

                // Get Allergy JSON (for edit form)
                Route::get('/allergy/{allergy}/json', [Modules\Allergy\ReadController::class, 'getAllergyJson'])
                    ->name('patient.allergy.json');

                // Update Allergy
                Route::put('/{allergy}', [Modules\Allergy\UpdateController::class, 'update'])
                    ->name('patient.allergy.update');

                // Delete Allergy
                Route::delete('/{allergy}', [Modules\Allergy\DeleteController::class, 'destroy'])
                    ->name('patient.allergy.delete');

                // Allergy More Info
                Route::get('/{allergy}', [Modules\Allergy\ReadController::class, 'show'])
                    ->name('patient.allergy.info');

            });

            // Immunisation (CRUD)
            Route::prefix('/immunisation')->group(function () {

                // Immunisation Page
                Route::get('/', [Modules\Immunisation\ReadController::class, 'index'])
                    ->name('patient.immunisation');

                // Add Vaccination
                Route::post('/add', [Modules\Immunisation\CreateController::class, 'store'])
                    ->name('patient.immunisation.add');

                // Export Immunisations as PDF
                Route::get('/export', [Modules\Immunisation\ReadController::class, 'exportPdf'])
                    ->name('patient.immunisation.export');

                // Get Immunisation JSON (for edit form)
                Route::get('/immunisation/{immunisation}/json', [Modules\Immunisation\ReadController::class, 'getImmunisationJson'])
                    ->name('patient.immunisation.json');

                // Upload Certificate for Immunisation
                Route::post('/{immunisation}/upload-certificate', [Modules\Immunisation\UpdateController::class, 'uploadCertificate'])
                    ->name('patient.immunisation.upload.certificate');

                // Delete Certificate for Immunisation
                Route::delete('/{immunisation}/delete-certificate', [Modules\Immunisation\DeleteController::class, 'deleteCertificate'])
                    ->name('patient.immunisation.delete.certificate');

                // Update Immunisation
                Route::put('/{immunisation}', [Modules\Immunisation\UpdateController::class, 'update'])
                    ->name('patient.immunisation.update');

                // Delete Immunisation
                Route::delete('/{immunisation}', [Modules\Immunisation\DeleteController::class, 'destroy'])
                    ->name('patient.immunisation.delete');

                // Immunisation More Info
                Route::get('/{immunisation}', [Modules\Immunisation\ReadController::class, 'show'])
                    ->name('patient.immunisation.info');

            });

            // Lab Tests (CRUD)
            Route::prefix('/lab-tests')->group(function () {

                // Lab Tests Page
                Route::get('/', [Modules\Lab\ReadController::class, 'index'])
                    ->name('patient.lab');

                // Add Lab Test
                Route::post('/add', [Modules\Lab\CreateController::class, 'store'])
                    ->name('patient.lab.add');

                // Export Lab Tests as PDF
                Route::get('/export', [Modules\Lab\ReadController::class, 'exportPdf'])
                    ->name('patient.lab.export');

                // Get Lab Test JSON (for edit form)
                Route::get('/test/{labTest}/json', [Modules\Lab\ReadController::class, 'getLabTestJson'])
                    ->name('patient.lab.json');

                // Upload Attachment for Lab Test
                Route::post('/{labTest}/upload-attachment', [Modules\Lab\UpdateController::class, 'uploadAttachment'])
                    ->name('patient.lab.upload.attachment');

                // Update Lab Test
                Route::put('/{labTest}', [Modules\Lab\UpdateController::class, 'update'])
                    ->name('patient.lab.update');

                // Delete Lab Test
                Route::delete('/{labTest}', [Modules\Lab\DeleteController::class, 'destroy'])
                    ->name('patient.lab.delete');

                // Lab Test More Info
                Route::get('/{labTest}', [Modules\Lab\ReadController::class, 'show'])
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
            Route::get('/', [Modules\Permission\ReadController::class, 'patientIndex'])
                ->name('patient.permission');

            // View Authorised Doctors Permission Details
            Route::get('doctors/view/{id}', [Modules\Permission\ReadController::class,'viewPermission'])
                ->name('patient.permission.view');

            // Update Permission Scope
            Route::put('doctors/update/{id}', [Modules\Permission\UpdateController::class, 'updatePermission'])
                ->name('patient.permission.update');

            // Pending Requests List
            Route::get('/requests', [Modules\Permission\ReadController::class, 'patientRequests'])
                ->name('patient.permission.requests');

            // View and Confirm Permission Request
            Route::get('/requests/{id}', [Modules\Permission\ReadController::class, 'showConfirmPermission'])
                ->name('patient.permission.confirm');

            // Activity History
            Route::get('/activity', [Modules\Permission\ReadController::class, 'patientActivity'])
                ->name('patient.permission.activity');

            // Approve Permission Request
            Route::post('/approve/{id}', [Modules\Permission\UpdateController::class, 'approveRequest'])
                ->name('patient.permission.approve');

            // Decline Permission Request
            Route::delete('/decline/{id}', [Modules\Permission\DeleteController::class, 'declineRequest'])
                ->name('patient.permission.decline');

            // Revoke Permission
            Route::delete('/revoke', [Modules\Permission\DeleteController::class, 'revokePermission'])
                ->name('patient.permission.revoke');
        });

        // Emergency Kit
        Route::prefix('/emergency-kit')->group(function () {

            // Emergency Kit Main Page
            Route::get('/', [Modules\EmergencyKit\ReadController::class, 'index'])
            ->name('patient.emergency-kit.index');

            // Create Emergency Kit Item Page
            Route::get('/create', [Modules\EmergencyKit\ReadController::class, 'create'])
            ->name('patient.emergency-kit.create');

            // Store Emergency Kit Item
            Route::post('/', [Modules\EmergencyKit\CreateController::class, 'store'])
            ->name('patient.emergency-kit.store');

            // Delete Emergency Kit Item
            Route::delete('/{id}', [Modules\EmergencyKit\DeleteController::class, 'destroy'])
            ->name('patient.emergency-kit.destroy');

            // Fetch Records for Emergency Kit
            Route::get('/fetch-records', [Modules\EmergencyKit\ReadController::class, 'fetchRecords'])
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

    // Password Reset
    Route::middleware('guest:organisation')->group(function () {

        // forgot password form
        Route::get('/forgot-password', [Organisation\Auth\AuthController::class, 'showForgotPasswordForm'])
            ->name('organisation.forgot.form');

        // forgot password sent page
        Route::get('/forgot-password/sent', [Organisation\Auth\AuthController::class, 'showForgotPasswordSent'])
            ->name('organisation.forgot.sent');
        
        Route::post('/forgot-password', [Organisation\Auth\AuthController::class, 'sendResetLinkEmail'])
            ->name('organisation.password.email');

        Route::get('/reset-password/success', [Organisation\Auth\AuthController::class, 'showSuccess'])
            ->name('organisation.password.reset.success');

        Route::get('/reset-password/{token}', [Organisation\Auth\AuthController::class, 'showResetForm'])
            ->name('organisation.password.reset');

        Route::post('/reset-password', [Organisation\Auth\AuthController::class, 'reset'])
            ->name('organisation.password.update');
    });
    
    // Authenticated Organisation Routes (Protected)
    Route::middleware(['auth:organisation', 'verified'])->group(function () {

        // Organisation Dashboard
        Route::get('/dashboard', [Organisation\MainController::class, 'index'])
            ->name('organisation.dashboard');

        // Doctor Management Routes
        Route::prefix('/doctors')->group(function () {

            // Doctors List Page
            Route::get('/', [Modules\Doctor\ReadController::class, 'doctor'])
                ->name('organisation.doctors');

            // View Doctor Profile
            Route::get('/profile/{id}', [Modules\Doctor\ReadController::class, 'doctorProfile'])
                ->name('organisation.doctor.profile');

            // Add New Doctor Form
            Route::get('/add', [Modules\Doctor\ReadController::class, 'addDoctor'])
                ->name('organisation.addDoctor');

            // Store New Doctor
            Route::post('/store', [Modules\Doctor\CreateController::class, 'store'])
                ->name('organisation.doctor.store');

            // Edit Doctor Form
            Route::get('/edit/{id}', [Modules\Doctor\ReadController::class, 'edit'])
                ->name('organisation.doctor.edit');

            // Update Doctor
            Route::put('/update/{id}', [Modules\Doctor\UpdateController::class, 'update'])
                ->name('organisation.doctor.update');

            // Delete Doctor
            Route::delete('/delete/{id}', [Modules\Doctor\DeleteController::class, 'destroy'])
                ->name('organisation.doctor.delete');
        });

        // Organisation Profile Page
        Route::prefix('/profile')->group(function () {

            // View Profile Page
            Route::get('/', [Organisation\MainController::class, 'profile'])
                ->name('organisation.profile');

            // Update Profile Sections
            Route::put('/update-details', [Organisation\MainController::class, 'updateDetails'])->name('organisation.profile.update.details');
            Route::put('/update-contact', [Organisation\MainController::class, 'updateContact'])->name('organisation.profile.update.contact');
            Route::put('/update-pic', [Organisation\MainController::class, 'updatePic'])->name('organisation.profile.update.pic');
            Route::put('/update-legal', [Organisation\MainController::class, 'updateLegal'])->name('organisation.profile.update.legal');
            Route::put('/update-picture', [Organisation\MainController::class, 'updatePicture'])->name('organisation.profile.update.picture');
            Route::put('/update-password', [Organisation\MainController::class, 'updatePassword'])->name('organisation.profile.update.password');
        });
    });
});

// Doctor Routes
Route::prefix('doctor')->group(function () {
    // Doctor Login Page
    Route::get('/login', [Doctor\Auth\AuthController::class, 'index'])
        ->name('doctor.login');

    // Doctor Login Process
    Route::post('/login', [Doctor\Auth\AuthController::class, 'login'])
        ->name('doctor.login.submit');

    // Doctor Logout
    Route::post('/logout', [Doctor\Auth\AuthController::class, 'logout'])
        ->name('doctor.logout');

    // Password Reset
    Route::middleware('guest:doctor')->group(function () {
        // forgot password form
        Route::get('/forgot-password', [Doctor\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])
            ->name('doctor.forgot.form');

        // forgot password sent page
        Route::get('/forgot-password/sent', [Doctor\Auth\ForgotPasswordController::class, 'showForgotPasswordSent'])
            ->name('doctor.forgot.sent');
        
        Route::post('/forgot-password', [Doctor\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('doctor.password.email');

        Route::get('/reset-password/success', [Doctor\Auth\ForgotPasswordController::class, 'showSuccess'])
            ->name('doctor.password.reset.success');

        Route::get('/reset-password/{token}', [Doctor\Auth\ForgotPasswordController::class, 'showResetForm'])
            ->name('doctor.password.reset');

        Route::post('/reset-password', [Doctor\Auth\ForgotPasswordController::class, 'reset'])
            ->name('doctor.password.update');
    });

    // Authenticated Doctor Routes (Protected)
    Route::middleware('auth:doctor')->group(function () {
        // Doctor Dashboard
        Route::get('/dashboard', [Doctor\DoctorController::class, 'index'])
            ->name('doctor.dashboard');

        // Doctor Profile Page
        Route::prefix('/profile')->group(function () {
            // View Profile Page
            Route::get('/', [Doctor\MainController::class, 'profile'])
                ->name('doctor.profile');

            // Update Profile Sections
            Route::put('/update-personal', [Doctor\MainController::class, 'updatePersonal'])->name('doctor.profile.update.personal');
            Route::post('/update-picture', [Doctor\MainController::class, 'updatePicture'])->name('doctor.profile.update.picture');
            Route::put('/update-password', [Doctor\MainController::class, 'updatePassword'])->name('doctor.profile.update.password');
        });

        // My Patients - List all patients with granted access
        Route::get('/patients', [Doctor\DoctorController::class, 'patients'])
            ->name('doctor.patients');

        // Patient Details - View detailed patient information
        Route::get('/patients/{patientId}', [Doctor\DoctorController::class, 'viewPatient'])
            ->name('doctor.patient.details');

        // Patient
        Route::prefix('/patient')->group(function () {

            // Search
            Route::prefix('/search')->group(function () {
                // Search Patient Page
                Route::get('/', [Doctor\DoctorController::class, 'searchPatient'])
                    ->name('doctor.patient.search');

                // Search Patient Result Page
                Route::get('/results', [Doctor\DoctorController::class, 'searchPatientResult'])
                    ->name('doctor.patient.search.results');

                // View Patient Profile Page
                Route::get('/view/{patientId}', [Doctor\DoctorController::class, 'viewPatientProfile'])
                    ->name('doctor.patient.view.profile');

            });
        });

        // Permission Routes
        Route::prefix('/permission')->group(function () {
            // View All Permission Requests
            Route::get('/requests', [Modules\Permission\ReadController::class, 'doctorIndex'])
                ->name('doctor.permission.requests');

            // Request Access to Patient Records
            Route::post('/request', [Modules\Permission\CreateController::class, 'requestAccess'])
                ->name('doctor.permission.request');

            // Terminate Access to Patient Records
            Route::delete('/terminate/{id}', [Modules\Permission\DeleteController::class, 'terminateAccess'])
                ->name('doctor.permission.terminate');
        });

        // Medical Records Routes
        Route::prefix('/medical-records')->group(function () {
            // View All Medical Records (with permissions)
            Route::get('/', [Modules\Permission\ReadController::class, 'medicalRecordIndex'])
                ->name('doctor.medical.records');

            // View Specific Record Details
            Route::get('/condition/{id}', [Modules\Permission\ReadController::class, 'showCondition'])
                ->name('doctor.medical.records.condition');

            Route::get('/medication/{id}', [Modules\Permission\ReadController::class, 'showMedication'])
                ->name('doctor.medical.records.medication');

            Route::get('/allergy/{id}', [Modules\Permission\ReadController::class, 'showAllergy'])
                ->name('doctor.medical.records.allergy');

            Route::get('/immunisation/{id}', [Modules\Permission\ReadController::class, 'showImmunisation'])
                ->name('doctor.medical.records.immunisation');

            Route::get('/lab/{id}', [Modules\Permission\ReadController::class, 'showLab'])
                ->name('doctor.medical.records.lab');
        });
    });
});

// Admin Routes
Route::prefix('admin')->group(function () {

    // Admin Login
    Route::get('/', [Admin\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [Admin\Auth\LoginController::class, 'login'])->name('admin.login.action');

    // Admin Logout
    Route::post('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');

    // Password Reset
    Route::middleware('guest:admin')->group(function () {
        // forgot password form
        Route::get('/forgot-password', [Admin\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])
            ->name('admin.forgot.form');

        // forgot password sent page
        Route::get('/forgot-password/sent', [Admin\Auth\ForgotPasswordController::class, 'showForgotPasswordSent'])
            ->name('admin.forgot.sent');
        
        Route::post('/forgot-password', [Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])
            ->name('admin.password.email');

        Route::get('/reset-password/success', [Admin\Auth\ForgotPasswordController::class, 'showSuccess'])
            ->name('admin.password.reset.success');

        Route::get('/reset-password/{token}', [Admin\Auth\ForgotPasswordController::class, 'showResetForm'])
            ->name('admin.password.reset');

        Route::post('/reset-password', [Admin\Auth\ForgotPasswordController::class, 'reset'])
            ->name('admin.password.update');
    });

    // Admin Registration
    Route::get('/register', [Admin\Auth\RegistrationController::class, 'showRegistrationForm'])->name('admin.register.form');
    Route::post('/register', [Admin\Auth\RegistrationController::class, 'register'])->name('admin.register');

    // Authenticated Admin Routes (Protected)
    Route::middleware('auth:admin')->group(function () {
        // Admin Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('admin.dashboard');

        // Admin Profile Page
        Route::prefix('/profile')->group(function () {
            // View Profile Page
            Route::get('/', [Admin\MainController::class, 'profile'])
                ->name('admin.profile');

            // Update Profile Sections
            Route::put('/update-personal', [Admin\MainController::class, 'updatePersonal'])->name('admin.profile.update.personal');
            Route::put('/update-picture', [Admin\MainController::class, 'updatePicture'])->name('admin.profile.update.picture');
            Route::put('/update-password', [Admin\MainController::class, 'updatePassword'])->name('admin.profile.update.password');
        });

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

