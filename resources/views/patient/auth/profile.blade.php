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

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="text-center mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
            <div class="flex items-start">
                <i class="fas fa-check-circle mt-0.5 mr-3 text-green-600"></i>
                <div>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle mt-0.5 mr-3 text-red-600"></i>
                <div>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Info Box -->
    @if (session('info'))
        <div class="mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-blue-800">
            <div class="flex items-start">
                <i class="fas fa-info-circle mt-0.5 mr-3 text-blue-600"></i>
                <div>
                    <p class="font-medium">{{ session('info') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
            <div class="flex items-start">
                <i class="fas fa-times-circle mt-0.5 mr-3 text-red-600"></i>
                <div>
                    <p class="font-medium mb-2">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
            <p class="text-gray-600 mt-2">Manage your personal information and settings</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left Column - Profile Picture -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            @if(Auth::guard('patient')->user()->profile_image_url)
                                <img src="{{ Auth::guard('patient')->user()->profile_image_url }}" alt="Profile Picture"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                            @else
                                <div
                                    class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center border-4 border-gray-300">
                                    <i class="fas fa-user text-4xl text-gray-400"></i>
                                </div>
                            @endif
                            <button
                                class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 transition-colors cursor-pointer"
                                onclick="openProfilePictureModal()">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mt-4">
                            {{ Auth::guard('patient')->user()->full_name }}
                        </h3>
                        <p class="text-gray-600">Age: {{ Auth::guard('patient')->user()->age }} years old</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Information Sections -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Personal Information Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Personal Information</h2>
                            <button
                                class="inline-flex cursor-pointer items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                onclick="editPersonalInfo()">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->full_name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">IC Number</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->ic_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->phone_number }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                                <p class="text-gray-900 font-medium">
                                    {{ Auth::guard('patient')->user()->date_of_birth->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                                <p class="text-gray-900 font-medium capitalize">
                                    {{ Auth::guard('patient')->user()->gender }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Blood Type</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->blood_type }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Race</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->race }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Information Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Physical Information</h2>
                            <button
                                class="inline-flex items-center cursor-pointer px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                onclick="editPhysicalInfo()">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Height</label>
                                <p class="text-gray-900 font-medium">
                                    @if(Auth::guard('patient')->user()->height)
                                        {{ Auth::guard('patient')->user()->height }} cm
                                    @else
                                        <span class="text-gray-400">Not specified</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Weight</label>
                                <p class="text-gray-900 font-medium">
                                    @if(Auth::guard('patient')->user()->weight)
                                        {{ Auth::guard('patient')->user()->weight }} kg
                                    @else
                                        <span class="text-gray-400">Not specified</span>
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">BMI</label>
                                <p class="text-gray-900 font-medium">
                                    @if(Auth::guard('patient')->user()->bmi)
                                        {{ Auth::guard('patient')->user()->bmi }}
                                        @if(Auth::guard('patient')->user()->bmi < 18.5)
                                            <span class="text-blue-600 text-sm">(Underweight)</span>
                                        @elseif(Auth::guard('patient')->user()->bmi >= 18.5 && Auth::guard('patient')->user()->bmi < 25)
                                            <span class="text-green-600 text-sm">(Normal)</span>
                                        @elseif(Auth::guard('patient')->user()->bmi >= 25 && Auth::guard('patient')->user()->bmi < 30)
                                            <span class="text-yellow-600 text-sm">(Overweight)</span>
                                        @else
                                            <span class="text-red-600 text-sm">(Obese)</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Not calculated</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Address Information</h2>
                            <button
                                class="inline-flex items-center px-4 py-2 cursor-pointer bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                onclick="editAddressInfo()">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Address</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->address }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Postal Code</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->postal_code }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">State</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->state }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Full Address</label>
                                <p class="text-gray-900 font-medium">{{ Auth::guard('patient')->user()->full_address }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Emergency Contact</h2>
                            <button
                                class="inline-flex cursor-pointer items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
                                onclick="editEmergencyInfo()">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Contact Name</label>
                                <p class="text-gray-900 font-medium">
                                    {{ Auth::guard('patient')->user()->emergency_contact_name }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">IC Number</label>
                                <p class="text-gray-900 font-medium">
                                    {{ Auth::guard('patient')->user()->emergency_contact_ic_number }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                                <p class="text-gray-900 font-medium">
                                    {{ Auth::guard('patient')->user()->emergency_contact_number }}
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Relationship</label>
                                <p class="text-gray-900 font-medium">
                                    {{ Auth::guard('patient')->user()->emergency_contact_relationship }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900">Security & Privacy</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium">Password</p>
                                    <p class="text-gray-500 text-sm">Last updated: Never</p>
                                </div>
                                <button
                                    class="text-blue-600 cursor-pointer hover:text-blue-700 hover:bg-blue-100 p-3 rounded-md font-medium text-sm"
                                    onclick="changePassword()">
                                    Change Password
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-red-600 font-medium">Delete Account</p>
                                    <p class="text-gray-500 text-sm">This action is irreversible.</p>
                                </div>
                                <button
                                    class="text-red-600 cursor-pointer hover:text-red-700 hover:bg-red-100 p-3 rounded-md font-medium text-sm"
                                    onclick="deleteAccount()">
                                    Delete Account
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-900 font-medium">Account Created</p>
                                    <p class="text-gray-500 text-sm">
                                        {{ Auth::guard('patient')->user()->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
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
</body>

</html>