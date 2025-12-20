<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Header with Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center text-sm text-gray-500 mb-3">
                <a href="{{ route('patient.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-gray-900 font-medium">My Profile</span>
            </nav>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                    <p class="text-gray-600 mt-1">Manage your personal information and account settings</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i class="fas fa-clock"></i>
                    <span>Last login: {{ $lastLogin }}</span>
                </div>
            </div>
        </div>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        @if (session('info'))
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-blue-800">{{ session('info') }}</p>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-red-600 mt-0.5" aria-hidden="true"></i>
                    <div>
                        <p class="text-sm font-medium text-red-900 mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1 text-sm text-red-800">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Need for completion -->
        @if($needsProfileCompletion)
            <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5" aria-hidden="true"></i>
                <div class="text-sm text-amber-800">
                    <p class="font-medium">Your profile is incomplete.</p>
                    <p>Please complete your information to ensure healthcare providers have your complete medical information.</p>
                </div>
            </div>
        @endif

        <!-- Profile Overview Hero Card -->
        <div class="bg-white rounded-2xl shadow-sm mb-8 overflow-hidden transition-all duration-200 ease-in-out hover:shadow-xl">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-8 sm:px-8">
                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <!-- Profile Image -->
                    <div class="relative group">
                        @if(Auth::guard('patient')->user()->profile_image_url)
                            <img src="{{ Auth::guard('patient')->user()->profile_image_url }}" alt="Profile Picture"
                                class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl object-cover border-4 border-white/30 shadow-xl">
                        @else
                            <div class="w-28 h-28 sm:w-32 sm:h-32 bg-white/20 backdrop-blur rounded-2xl flex items-center justify-center border-4 border-white/30 shadow-xl">
                                <i class="fas fa-user text-4xl text-white/80"></i>
                            </div>
                        @endif
                        <button
                            class="absolute -bottom-2 -right-2 bg-white text-blue-600 p-2.5 rounded-xl hover:bg-gray-50 transition-all cursor-pointer shadow-lg group-hover:scale-105"
                            onclick="openProfilePictureModal()">
                            <i class="fas fa-camera text-sm"></i>
                        </button>
                    </div>
                    <!-- User Info -->
                    <div class="text-center sm:text-left">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white">
                            {{ $patient->full_name }}
                        </h2>
                        <p class="text-blue-100 mt-1 flex items-center justify-center sm:justify-start gap-2">
                            <i class="fas fa-id-card text-sm"></i>
                            {{ $patient->ic_number }}
                        </p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 mt-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur rounded-lg text-sm text-white">
                                <i class="fas fa-birthday-cake text-xs"></i>
                                {{ $age }} years old
                            </span>
                            @if($patient->gender)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur rounded-lg text-sm text-white capitalize">
                                <i class="fas fa-venus-mars text-xs"></i>
                                {{ $patient->gender }}
                            </span>
                            @endif
                            @if($bloodType)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500/80 backdrop-blur rounded-lg text-sm text-white font-semibold">
                                <i class="fas fa-tint text-xs"></i>
                                {{ $bloodType }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Physical Stats -->
            <div class="border-t border-gray-200 bg-white">
                <div class="grid grid-cols-2 sm:grid-cols-4">
                    <!-- Height -->
                    <div class="px-4 py-5 text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $height }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Height (cm)</p>
                    </div>
                    
                    <!-- Weight -->
                    <div class="px-4 py-5 text-center">
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $weight }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Weight (kg)</p>
                    </div>
                    
                    <!-- BMI -->
                    <div class="px-4 py-5 text-center">
                        <p class="text-2xl font-bold {{ $bmiColor }}">
                            {{ $bmi ?? '--' }}
                        </p>
                        <p class="text-xs mt-1 {{ $bmi ? $bmiColor : 'text-gray-500' }}">
                            {{ $bmiLabel }}
                        </p>
                    </div>
                    
                    <!-- Edit Button -->
                    <div class="px-4 py-5 flex items-center justify-center">
                        <button
                                class="inline-flex cursor-pointer items-center gap-2 px-4 py-2 text-blue-600 hover:text-blue-800 text-sm font-medium rounded-lg transition-all duration-150 ease-in-out"
                                onclick="editPhysicalInfo()">
                                <i class="fas fa-pen text-xs"></i>
                                <span>Edit</span>
                            </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid Layout -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            <!-- Left Column - Primary Information -->
            <div class="xl:col-span-7 space-y-6">

                <!-- Personal Information Card -->
                <div class="bg-white rounded-2xl shadow-sm transition-all duration-200 ease-in-out hover:shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Personal Information</h2>
                                    <p class="text-xs text-gray-500">Your identity details</p>
                                </div>
                            </div>
                            <button
                                class="inline-flex cursor-pointer items-center gap-2 px-4 py-2 text-blue-600 hover:text-blue-800 text-sm font-medium rounded-lg transition-all duration-150 ease-in-out"
                                onclick="editPersonalInfo()">
                                <i class="fas fa-pen text-xs"></i>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Full Name</label>
                                <p class="text-gray-900 font-medium">{{ $patient->full_name }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">IC Number</label>
                                <p class="text-gray-900 font-medium">{{ $patient->ic_number }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Email Address</label>
                                <p class="text-gray-900 font-medium">{{ $patient->email }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Phone Number</label>
                                <p class="text-gray-900 font-medium">{{ $phoneNumber }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Date of Birth</label>
                                <p class="text-gray-900 font-medium">{{ $dateOfBirth }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Gender</label>
                                <p class="text-gray-900 font-medium capitalize">{{ $patient->gender ?? 'Not specified' }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Blood Type</label>
                                <p class="text-gray-900 font-medium">
                                    @if($bloodType)
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                            {{ $bloodType }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Not specified</span>
                                    @endif
                                </p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Race</label>
                                <p class="text-gray-900 font-medium">{{ $race }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Card -->
                <div class="bg-white rounded-2xl shadow-sm transition-all duration-200 ease-in-out hover:shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-map-marker-alt text-blue-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Address Information</h2>
                                    <p class="text-xs text-gray-500">Your residential address</p>
                                </div>
                            </div>
                            <button
                                class="inline-flex cursor-pointer items-center gap-2 px-4 py-2 text-blue-600 hover:text-blue-800 text-sm font-medium rounded-lg transition-all duration-150 ease-in-out"
                                onclick="editAddressInfo()">
                                <i class="fas fa-pen text-xs"></i>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50 mb-2">
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Street Address</label>
                            <p class="text-gray-900 font-medium">{{ $address }}</p>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Postal Code</label>
                                <p class="text-gray-900 font-medium">{{ $postalCode }}</p>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50">
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">State</label>
                                <p class="text-gray-900 font-medium">{{ $state }}</p>
                            </div>
                        </div>
                        <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                                <i class="fas fa-location-dot mr-1"></i> Full Address
                            </label>
                            <p class="text-gray-700">{{ $fullAddress }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Secondary Information -->
            <div class="xl:col-span-5 space-y-6">

                <!-- Emergency Contact Card -->
                <div class="bg-white rounded-2xl shadow-sm transition-all duration-200 ease-in-out hover:shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-phone-alt text-red-600"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Emergency Contact</h2>
                                    <p class="text-xs text-gray-500">Who to contact in emergencies</p>
                                </div>
                            </div>
                            <button
                                class="inline-flex cursor-pointer items-center gap-2 px-4 py-2 text-blue-600 hover:text-blue-800 text-sm font-medium rounded-lg transition-all duration-150 ease-in-out"
                                onclick="editEmergencyInfo()">
                                <i class="fas fa-pen text-xs"></i>
                                <span>Edit</span>
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-start gap-4 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-shield text-blue-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-lg font-semibold text-gray-900 truncate">
                                    {{ $emergencyName }}
                                </p>
                                <p class="text-sm text-blue-600 font-medium">
                                    {{ $emergencyRelationship }}
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mt-4">
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50 flex items-center gap-3">
                                <i class="fas fa-phone text-gray-400 w-4"></i>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">Phone</label>
                                    <p class="text-gray-900 font-medium">{{ $emergencyPhone }}</p>
                                </div>
                            </div>
                            <div class="relative p-3 rounded-lg transition-colors duration-150 hover:bg-gray-50 flex items-center gap-3">
                                <i class="fas fa-id-card text-gray-400 w-4"></i>
                                <div>
                                    <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider">IC Number</label>
                                    <p class="text-gray-900 font-medium">{{ $emergencyIc }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security & Privacy Card -->
                <div class="bg-white rounded-2xl shadow-sm transition-all duration-200 ease-in-out hover:shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shield-alt text-gray-600"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Security & Privacy</h2>
                                <p class="text-xs text-gray-500">Account security settings</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Password -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-key text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-gray-900 font-medium">Password</p>
                                    <p class="text-xs text-gray-500">Last updated: Never</p>
                                </div>
                            </div>
                            <button
                                class="text-blue-600 cursor-pointer hover:text-blue-800 px-4 py-2 rounded-lg font-medium text-sm transition-colors"
                                onclick="changePassword()">
                                Change
                            </button>
                        </div>

                        <!-- Account Info -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                                    <i class="fas fa-calendar-alt text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-gray-900 font-medium">Account Created</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $accountCreated }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-xs font-medium text-gray-400 uppercase tracking-wider mb-3">Danger Zone</p>
                            <div class="flex items-center justify-between p-4 bg-red-50 rounded-xl border border-red-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-trash-alt text-red-500"></i>
                                    </div>
                                    <div>
                                        <p class="text-red-700 font-medium">Delete Account</p>
                                        <p class="text-xs text-red-500">This action is irreversible</p>
                                    </div>
                                </div>
                                <button
                                    class="text-white cursor-pointer bg-red-600 hover:bg-red-800 px-4 py-2 rounded-lg font-medium text-sm transition-colors"
                                    onclick="deleteAccount()">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form Sections -->
    @include('patient.auth.profileForm.personalInfo')
    @include('patient.auth.profileForm.physicalInfo')
    @include('patient.auth.profileForm.addressInfo')
    @include('patient.auth.profileForm.emergencyContact')
    @include('patient.auth.profileForm.changePassword')
    @include('patient.auth.profileForm.deleteAccount')
    @include('patient.auth.profileForm.profilePicture')

    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/patient/patientProfile.js'])
    @vite(['resources/js/main/patient/header.js'])

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')
</body>

</html>