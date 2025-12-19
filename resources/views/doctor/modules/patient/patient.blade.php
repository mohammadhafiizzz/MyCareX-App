<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - My Patients</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">My Patients</h1>
                    <p class="mt-2 text-sm text-gray-600">Patients who have granted you access to their medical records</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Patient Count -->
                <div class="mb-6">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold text-gray-900">{{ $patients->count() }}</span> 
                        {{ $patients->count() === 1 ? 'patient' : 'patients' }} found
                    </p>
                </div>

                <!-- Patients Grid -->
                @if($patients->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($patients as $patient)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100">
                                <!-- Patient Card -->
                                <div class="p-6">
                                    <!-- Profile Image -->
                                    <div class="flex justify-center mb-4">
                                        @if($patient->profile_image_url)
                                            <img src="{{ asset($patient->profile_image_url) }}" 
                                                 alt="{{ $patient->full_name }}"
                                                 class="w-24 h-24 rounded-full object-cover border-4 border-gray-100">
                                        @else
                                            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-4 border-blue-100">
                                                <i class="fas fa-user text-blue-600 text-3xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Patient Info -->
                                    <div class="text-center mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $patient->full_name }}</h3>
                                        <p class="text-sm text-gray-500 mb-3">{{ $patient->ic_number }}</p>
                                        
                                        <!-- Quick Info Badges -->
                                        <div class="flex flex-wrap justify-center gap-2 mb-3">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-calendar mr-1 text-xs"></i>
                                                {{ $patient->age }} yrs
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-100 text-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-800">
                                                <i class="fas fa-{{ $patient->gender === 'Male' ? 'mars' : 'venus' }} mr-1 text-xs"></i>
                                                {{ $patient->gender }}
                                            </span>
                                            @if($patient->blood_type)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-tint mr-1 text-xs"></i>
                                                {{ $patient->blood_type }}
                                            </span>
                                            @endif
                                        </div>

                                        <!-- Contact Info -->
                                        <div class="space-y-1.5 mb-4">
                                            <div class="flex items-center justify-center text-xs text-gray-600">
                                                <i class="fas fa-envelope w-4 text-gray-400 mr-2"></i>
                                                <span class="truncate">{{ $patient->email }}</span>
                                            </div>
                                            <div class="flex items-center justify-center text-xs text-gray-600">
                                                <i class="fas fa-phone w-4 text-gray-400 mr-2"></i>
                                                <span>{{ $patient->phone_number }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Profile Button -->
                                    <a href="{{ route('doctor.patient.details', $patient->id) }}" 
                                       class="block w-full text-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                        View Profile
                                    </a>
                                </div>

                                <!-- Card Footer - Access Info -->
                                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                                    <div class="flex items-center justify-between text-xs text-gray-600">
                                        <span class="flex items-center">
                                            <i class="fas fa-check-circle text-green-500 mr-1.5"></i>
                                            Access Granted
                                        </span>
                                        @if($patient->permissions->first() && $patient->permissions->first()->granted_at)
                                            <span>{{ $patient->permissions->first()->granted_at->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <i class="fas fa-users text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Patients Yet</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            You don't have any patients who have granted you access to their medical records yet.
                        </p>
                        <a href="{{ route('doctor.patient.search') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search for Patients
                        </a>
                    </div>
                @endif
                
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

</body>

</html>