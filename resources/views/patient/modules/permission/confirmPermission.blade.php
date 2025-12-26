<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Confirm Permission</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-5">
            <a href="{{ route('patient.permission.requests') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Requests
            </a>
        </div>

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Review Access Request</h1>
            <p class="text-sm text-gray-500">Review the doctor's information and decide which records they can access.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

            <!-- Left Column: Profile Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-user text-gray-400"></i> DOCTOR PROFILE
                        </h3>
                    </div>
                    <div class="p-6 sm:p-8 flex flex-col items-center text-center flex-1 justify-center">
                        <div class="relative w-24 h-24 sm:w-32 sm:h-32 mb-4 sm:mb-5 mx-auto shrink-0">
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl sm:text-4xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                @if($permission->doctor->profile_image_url)
                                    <img src="{{ asset($permission->doctor->profile_image_url) }}" alt="{{ $permission->doctor->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fas fa-user-md"></i>
                                @endif
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900">{{ $permission->doctor->full_name }}</h2>
                        <p class="text-sm text-gray-500 mb-3">{{ $permission->doctor->specialisation ?? 'General Practitioner' }}</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Doctor Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-user-md text-gray-400"></i> DOCTOR INFORMATION
                        </h3>
                    </div>
                    
                    <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-8">
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->doctor->full_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Specialisation</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->doctor->specialisation ?? 'General Practitioner' }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Medical License Number</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->doctor->medical_license_number }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Doctor Email</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->doctor->email }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Facility Name</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->provider->organisation_name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Facility Email</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->provider->email }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Facility Contact</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->provider->phone_number }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Requested On</label>
                            <p class="text-sm text-gray-900 font-medium">{{ $permission->requested_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Permission Scope Selection -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-shield-halved text-gray-400"></i> PERMISSION SCOPE
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-6">Select the medical records you want to share with this doctor. You can change these permissions at any time.</p>
                        
                        @php
                            $scopes = [
                                'medical_conditions' => ['label' => 'Medical Conditions', 'icon' => 'fas fa-heartbeat'],
                                'medications' => ['label' => 'Medications', 'icon' => 'fas fa-pills'],
                                'allergies' => ['label' => 'Allergies', 'icon' => 'fas fa-allergies'],
                                'immunisations' => ['label' => 'Immunisations', 'icon' => 'fas fa-syringe'],
                                'lab_tests' => ['label' => 'Lab Tests', 'icon' => 'fas fa-flask'],
                            ];
                        @endphp

                        <!-- Requested Scope -->
                        <div class="mb-8">
                            <h4 class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">Requested by Doctor</h4>
                            <div class="flex flex-wrap gap-2">
                                @if(in_array('all', $permission->permission_scope ?? []))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                        <i class="fas fa-file-medical mr-1.5 text-[10px]"></i>
                                        All Medical Records
                                    </span>
                                @else
                                    @foreach($permission->permission_scope ?? [] as $scope)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            <i class="fas {{ $scopes[$scope]['icon'] ?? 'fa-file-medical' }} mr-1.5 text-[10px]"></i>
                                            {{ $scopes[$scope]['label'] ?? ucwords(str_replace('_', ' ', $scope)) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        @if($permission->notes)
                        <div class="mb-8 p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-comment-medical text-blue-500"></i>
                                <p class="text-sm text-gray-700 italic">"{{ $permission->notes }}"</p>
                            </div>
                        </div>
                        @endif

                        <form id="approvePermissionForm" data-permission-id="{{ $permission->id }}">
                            <div class="mb-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase mb-3 tracking-wider">Grant Access To</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                                @foreach($scopes as $key => $data)
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" name="permission_scope[]" value="{{ $key }}" 
                                            {{ in_array($key, $permission->permission_scope ?? []) || in_array('all', $permission->permission_scope ?? []) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </div>
                                    <div class="ml-4 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                            <i class="fas {{ $data['icon'] }} text-sm"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $data['label'] }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>

                            <div class="mb-8 max-w-md">
                                <label for="expiry_date" class="block text-sm font-semibold text-gray-900 mb-2">Access Expiry Date</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                    </div>
                                    <input type="date" id="expiry_date" name="expiry_date" required
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        value="{{ date('Y-m-d', strtotime('+1 month')) }}"
                                        class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                                </div>
                                <p class="mt-2 text-xs text-gray-500">The doctor's access will automatically expire after this date.</p>
                            </div>

                            <div class="flex flex-col text-sm sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                                <button type="button" id="declineRequestBtn" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-500/5 backdrop-blur-md text-red-700 rounded-xl border border-red-400/20 shadow-sm text-sm font-medium hover:bg-red-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                                    Decline Request
                                </button>
                                <button type="submit" id="grantAccessBtn" class="inline-flex items-center cursor-pointer px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    Grant Access
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('patient.components.footer')

    @vite(['resources/js/main/patient/header.js', 'resources/js/main/permission/confirmPermission.js'])

</body>

</html>