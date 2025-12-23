<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Doctor Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    <!-- Header -->
    @include('organisation.components.header')

    <!-- Sidebar -->
    @include('organisation.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-4">
                    <a href="{{ route('organisation.doctors') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Doctors List
                    </a>
                </div>

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Doctor Profile</h1>
                    <p class="text-sm text-gray-500">View and manage healthcare professional details.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Left Column: Profile Summary -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i> PROFILE
                                </h3>
                            </div>
                            <div class="p-8 flex flex-col items-center text-center">
                                <div class="relative w-32 h-32 mb-5 mx-auto shrink-0">
                                    <div class="w-32 h-32 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-4xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                        @if($doctor->profile_image_url)
                                            <img src="{{ asset($doctor->profile_image_url) }}" alt="{{ $doctor->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user-md"></i>
                                        @endif
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900">{{ $doctor->full_name }}</h2>
                                <p class="text-sm text-gray-500 mb-3">{{ $doctor->specialisation ?? 'General Practitioner' }}</p>

                                <div class="mb-2">
                                    @if($doctor->active_status)
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 flex items-center gap-2 mx-auto w-fit">
                                            <i class="fa-solid fa-check-circle"></i> Active
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold border border-red-200 flex items-center gap-2 mx-auto w-fit">
                                            <i class="fa-solid fa-circle-xmark"></i> Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Doctor Information -->
                    <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-user-md text-gray-400"></i> DOCTOR INFORMATION
                            </h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / ID Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->ic_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->phone_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Specialisation</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->specialisation ?? 'General Practitioner' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Medical License Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->medical_license_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Joined Date</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $doctor->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Account Status</label>
                                <div>
                                    @if($doctor->active_status)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                            ACTIVE
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-100 text-red-700 border border-red-200">
                                            INACTIVE
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Sections -->
                    <div class="lg:col-span-3 space-y-6">
                        <!-- Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-gear text-gray-400"></i> ACTIONS
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-2">
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Last Login</p>
                                        <p class="text-xs text-gray-500">Last login: {{ $doctor->last_login ? $doctor->last_login->diffForHumans() : 'Never' }}</p>
                                    </div>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $doctor->last_login ? $doctor->last_login->format('d M Y, h:i A') : 'Never' }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between py-4 border-b border-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Edit Doctor Profile</p>
                                        <p class="text-xs text-gray-500">Update professional and personal details</p>
                                    </div>
                                    <button class="px-4 py-2 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-100">
                                        Edit Profile
                                    </button>
                                </div>

                                <div class="flex items-center justify-between py-4">
                                    <div>
                                        <p class="text-sm font-medium text-red-600">Remove Doctor</p>
                                        <p class="text-xs text-red-400">Permanently remove this doctor from the organisation</p>
                                    </div>
                                    <button class="px-4 py-2 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                                        Remove Doctor
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/header.js'])

</body>

</html>
