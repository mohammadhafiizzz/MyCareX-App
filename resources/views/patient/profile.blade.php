<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>My Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    @include('patient.components.header')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="min-h-screen">
            
            <!-- Page Header -->
            <div class="mb-8">
                <nav class="flex items-center text-sm text-gray-500 mb-3">
                    <a href="{{ route('patient.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
                    <i class="fas fa-chevron-right mx-2 text-xs"></i>
                    <span class="text-gray-900 font-medium">My Profile</span>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
                        <p class="text-sm text-gray-500">Manage your personal information and account settings.</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column: Profile Overview -->
                <div class="space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
                        <div class="relative w-24 h-24 mb-4 mx-auto shrink-0">
                            <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                @if($patient->profile_image_url)
                                    <img src="{{ asset($patient->profile_image_url) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <button onclick="openProfilePictureModal()" class="absolute bottom-0 right-0 bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-md border border-gray-100 text-blue-600 hover:text-blue-700 hover:bg-gray-100 cursor-pointer transition-transform hover:scale-110 z-10">
                                <i class="fas fa-camera text-xs"></i>
                            </button>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h2>
                        <p class="text-sm text-gray-500 mb-2">{{ $patient->ic_number }}</p>

                    </div>

                    <!-- Physical Stats Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-weight-scale text-gray-400"></i> PHYSICAL STATS
                            </h3>
                            <button onclick="editPhysicalInfo()" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                Edit
                            </button>
                        </div>
                        <div class="p-4 grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <p class="text-lg font-bold text-gray-900">{{ $height }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-medium">Height (cm)</p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-bold text-gray-900">{{ $weight }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-medium">Weight (kg)</p>
                            </div>
                            <div class="text-center">
                                <p class="text-lg font-bold {{ $bmiColor }}">{{ $bmi ?? '--' }}</p>
                                <p class="text-[10px] {{ $bmi ? $bmiColor : 'text-gray-500' }} uppercase font-medium">{{ $bmiLabel }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Personal Details -->
                <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user text-gray-400"></i> PERSONAL DETAILS
                        </h3>
                        <button onclick="editPersonalInfo()" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                            Edit Details
                        </button>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $patient->full_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / Passport Number</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $patient->ic_number }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Date of Birth</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $dateOfBirth }} (Age: {{ $age }})</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Gender</label>
                            <p class="text-sm text-gray-900 font-medium capitalize">{{ $patient->gender ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Race</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $race }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Blood Type</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $bloodType ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $phoneNumber }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                            <div class="flex items-center gap-2">
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->email }}</p>
                                @if($patient->email_verified_at)
                                    <i class="fas fa-check-circle text-green-500 text-xs" title="Verified"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Full Width Sections -->
                <div class="lg:col-span-3 space-y-6">

                    <!-- Contact & Location -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-gray-400"></i> CONTACT & LOCATION
                            </h3>
                            <button onclick="editAddressInfo()" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                Edit Address
                            </button>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div class="sm:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Street Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $address }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Postal Code</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $postalCode }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">State</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $state }}</p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Address</label>
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    <p class="text-sm text-gray-700">{{ $fullAddress }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-phone text-gray-400"></i> EMERGENCY CONTACT
                            </h3>
                            <button onclick="editEmergencyInfo()" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                Edit Contact
                            </button>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Contact Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $emergencyName }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Relationship</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $emergencyRelationship }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $emergencyPhone }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / ID Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $emergencyIc }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Account Settings -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-gear text-gray-400"></i> ACCOUNT SETTINGS
                            </h3>
                        </div>
                        
                        <div class="p-6 space-y-2">
                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Last Login</p>
                                    <p class="text-xs text-gray-500">Last login: {{ $patient->last_login->diffForHumans() }}</p>
                                </div>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $patient->last_login ? date('d M Y, h:i A', strtotime($patient->last_login)) : 'Never' }}
                                    </p>
                                </div>

                            <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Joined</p>
                                    <p class="text-xs text-gray-500">Joined: {{ $patient->created_at->diffForHumans() }}</p>
                                </div>
                                <p class="text-sm text-gray-900 font-medium">
                                        {{ $patient->created_at ? date('d M Y', strtotime($patient->created_at)) : 'Never' }}
                                    </p>
                            </div>

                            <div class="flex items-center justify-between py-4 border-b border-gray-50">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Password</p>
                                    <p class="text-xs text-gray-500">Last changed: {{ $patient->updated_at->diffForHumans() }}</p>
                                </div>
                                <button onclick="changePassword()" class="text-xs px-4 py-2.5 rounded-md font-medium bg-blue-50 hover:bg-blue-100 text-blue-600 hover:text-blue-800">Change Password</button>
                            </div>

                            <div class="flex items-center justify-between py-4">
                                <div>
                                    <p class="text-sm font-medium text-red-600">Delete Account</p>
                                    <p class="text-xs text-gray-500">Permanently remove your account and all data.</p>
                                </div>
                                <button onclick="deleteAccount()" class="px-4 py-2.5 rounded-md text-xs font-medium bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-800">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('patient.components.footer')

    <!-- Modals -->
    @include('patient.auth.profile.personalDetails')
    @include('patient.auth.profileForm.physicalInfo')
    @include('patient.auth.profileForm.addressInfo')
    @include('patient.auth.profileForm.emergencyContact')
    @include('patient.auth.profileForm.changePassword')
    @include('patient.auth.profileForm.deleteAccount')
    @include('patient.auth.profileForm.profilePicture')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

    @vite(['resources/js/main/patient/header.js', 'resources/js/main/patient/profile.js'])
</body>
</html>
