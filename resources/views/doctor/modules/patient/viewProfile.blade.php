<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Search</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-50">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <a href="{{ route('doctor.patient.search') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mb-4 inline-block">&larr; Back to Search</a>

                <!-- Dashboard Content -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Patient Profile</h1>
                    <p class="mt-1 text-sm text-gray-600">View detailed information about the patient.</p>
                </div>

                <!-- Profile Header -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="flex items-start gap-6">
                        <!-- Profile Picture -->
                        <div class="flex-shrink-0">
                            @if($patient->profile_image_url)
                                <img src="{{ asset($patient->profile_image_url) }}" 
                                     alt="{{ $patient->full_name }}"
                                     class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-2 border-blue-300">
                                    <i class="fas fa-user text-blue-600 text-3xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Basic Info -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $patient->full_name }}</h2>
                                    <div class="flex items-center gap-3 mb-3 flex-wrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <i class="fas fa-calendar mr-1.5 text-xs"></i>
                                            {{ $patient->age }} years old
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-100 text-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-800">
                                            <i class="fas fa-{{ $patient->gender === 'Male' ? 'mars' : 'venus' }} mr-1.5 text-xs"></i>
                                            {{ $patient->gender }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-id-card w-5 text-gray-400 mr-2"></i>
                                            <span class="font-medium text-gray-700 mr-1">IC:</span>
                                            {{ $patient->ic_number }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-envelope w-5 text-gray-400 mr-2"></i>
                                            <span class="font-medium text-gray-700 mr-1">Email:</span>
                                            {{ $patient->email }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-phone w-5 text-gray-400 mr-2"></i>
                                            <span class="font-medium text-gray-700 mr-1">Phone:</span>
                                            {{ $patient->phone_number }}
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-birthday-cake w-5 text-gray-400 mr-2"></i>
                                            <span class="font-medium text-gray-700 mr-1">DOB:</span>
                                            {{ $patient->date_of_birth->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 pt-6 border-t border-gray-200 flex gap-3 flex-wrap">
                        <button 
                            id="openRequestAccessModal"
                            data-patient-id="{{ $patient->id }}"
                            data-patient-name="{{ $patient->full_name }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            Request Access
                        </button>
                        <!--
                        <button class="inline-flex items-center px-4 py-2 border border-blue-300 shadow-sm text-blue-600 hover:text-blue-800 hover:bg-blue-200 text-sm font-medium rounded-lg transition-colors duration-200">
                            View Medical Records
                        </button>
                        -->
                    </div>
                </div>

                <!-- Information Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Medical Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            Medical Information
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Blood Type</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-600">
                                    <i class="fas fa-tint mr-1.5 text-xs"></i>
                                    {{ $patient->blood_type ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Height</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $patient->height ? $patient->height . ' cm' : 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">Weight</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $patient->weight ? $patient->weight . ' kg' : 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-sm font-medium text-gray-600">BMI</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $patient->bmi ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-600">Race</span>
                                <span class="text-sm text-gray-900 font-medium">{{ $patient->race ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact & Address -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            Address Information
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Address</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $patient->address ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Postal Code</label>
                                    <p class="text-sm text-gray-900 mt-1">{{ $patient->postal_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">State</label>
                                    <p class="text-sm text-gray-900 mt-1">{{ $patient->state ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-white rounded-lg shadow-sm p-6 lg:col-span-2">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-phone-alt text-red-500 mr-2"></i>
                            Emergency Contact
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Name</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $patient->emergency_contact_name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">IC Number</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $patient->emergency_contact_ic_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Phone Number</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $patient->emergency_contact_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Relationship</label>
                                <p class="text-sm text-gray-900 mt-1">{{ $patient->emergency_contact_relationship ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Access Modal -->
    @include('doctor.modules.permission.requestAccessModal')

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

    <!-- requestAccess JS -->
    @vite(['resources/js/main/doctor/requestAccess.js'])

</body>

</html>