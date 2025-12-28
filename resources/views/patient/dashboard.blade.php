<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Banner -->
    <section class="relative h-80 bg-gray-900 overflow-hidden">

        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/dashboard_patient.png') }}" 
                alt="Patient Dashboard Background"
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gray-900/40"></div>
        </div>
        
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
                    Dashboard
                </h1>
                <p class="text-lg md:text-xl text-gray-200">
                    Welcome back to your health portal
                </p>
            </div>
        </div>
    </section>

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Background Image Banner -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ $greeting }}!
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        Last Login: {{ $patient->last_login ? $patient->last_login->format('M d, Y \a\t h:i A') : 'First login' }}
                    </p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                        Health Profile Active
                    </span>
                </div>
            </div>
        </div>

        <!-- Pending Permission Alert -->
        @if($pendingPermissions > 0)
        <div class="mb-6">
            {{-- Pending Permission Requests --}}
            <div class="flex items-center p-4 bg-amber-50 border border-amber-200 rounded-xl" role="alert">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                        <i class="fas fa-user-doctor text-amber-600" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-semibold text-amber-800">{{ $pendingPermissions }} Pending Access Request{{ $pendingPermissions > 1 ? 's' : '' }}</h3>
                    <p class="text-sm text-amber-700">Doctors are requesting access to your records</p>
                </div>
                <a href="{{ route('patient.permission') }}" class="ml-4 inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                    Review
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @endif

        <!-- Profile Incomplete Alert -->
        @if($needsProfileCompletion)
        <div class="mb-6">
            <div class="flex items-start p-4 bg-amber-50 border border-amber-100 rounded-xl" role="alert">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                        <i class="fas fa-user text-amber-600" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-semibold text-amber-800">Complete your profile for a richer experience</h3>
                    <p class="text-sm text-amber-700 mt-1">
                        Fill them in so doctors, medications, and notifications stay tailored to you.
                    </p>
                </div>
                <a href="{{ route('patient.profile') }}" class="ml-4 inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-600 bg-white border border-amber-200 rounded-lg hover:bg-amber-100 transition-colors">
                    Update profile
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @endif

        <!-- Summary Card -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            {{-- Active Medications --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-pills text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $activeMedications }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Active Medications</p>
                    <p class="text-xs text-gray-500">Currently prescribed</p>
                </div>
            </div>

            {{-- Active Conditions --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-heart-pulse text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $activeConditions }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Health Conditions</p>
                    <p class="text-xs text-gray-500">Patient's current conditions</p>
                </div>
            </div>

            {{-- Lab Records --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-flask text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $labRecordsCount }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Lab Records</p>
                    <p class="text-xs text-gray-500">Stored lab results</p>
                </div>
            </div>

            {{-- Active Access --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-user-doctor text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $activeProviders }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Active Access</p>
                    <p class="text-xs text-gray-500">Doctors with access</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Today's Medication Schedule --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="medications-heading">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100">
                                    <i class="fas fa-clock text-blue-600" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h2 id="medications-heading" class="text-lg font-semibold text-gray-900">Today's Medications</h2>
                                    <p class="text-xs text-gray-500">Your daily medication schedule</p>
                                </div>
                            </div>
                            <a href="{{ route('patient.medication') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                View all
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        @if($todayMedications->count() > 0)
                        <div class="space-y-3">
                            @foreach($todayMedications as $medication)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                        <i class="fas fa-pills text-blue-600" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $medication->medication_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $medication->formatted_dosage }} • {{ $medication->frequency }}</p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    @if($medication->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($medication->status) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="flex items-center justify-center h-16 w-16 mx-auto rounded-full bg-gray-100">
                                <i class="fas fa-pills text-gray-400 text-2xl"></i>
                            </div>
                            <p class="mt-4 text-sm font-medium text-gray-900">No active medications</p>
                            <p class="mt-1 text-xs text-gray-500">Your medication schedule will appear here</p>
                        </div>
                        @endif
                    </div>
                </section>

                {{-- Recent Lab Results --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="labs-heading">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100">
                                    <i class="fas fa-flask text-blue-600" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h2 id="labs-heading" class="text-lg font-semibold text-gray-900">Recent Lab Results</h2>
                                    <p class="text-xs text-gray-500">Your latest test results</p>
                                </div>
                            </div>
                            <a href="{{ route('patient.lab') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                View all
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @forelse($recentLabs as $lab)
                        <div class="p-5 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gray-100">
                                        <i class="fas fa-file-medical text-gray-600" aria-hidden="true"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $lab->test_name }}</p>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <span class="text-xs text-gray-500">{{ $lab->facility_name ?? 'Unknown Facility' }}</span>
                                            <span class="text-gray-300">•</span>
                                            <span class="text-xs text-gray-500">{{ $lab->test_date?->format('M d, Y') ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($lab->verification_status === 'verified')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                    @elseif($lab->verification_status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @endif
                                    <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <div class="flex items-center justify-center h-16 w-16 mx-auto rounded-full bg-gray-100">
                                <i class="fas fa-flask text-gray-400 text-2xl"></i>
                            </div>
                            <p class="mt-4 text-sm font-medium text-gray-900">No lab results yet</p>
                            <p class="mt-1 text-xs text-gray-500">Your lab results will appear here</p>
                        </div>
                        @endforelse
                    </div>
                </section>

                {{-- Data Access & Permissions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="permissions-heading">
                    <div class="p-5 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-blue-100">
                                    <i class="fas fa-shield-halved text-blue-600" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h2 id="permissions-heading" class="text-lg font-semibold text-gray-900">Data Access & Permissions</h2>
                                    <p class="text-xs text-gray-500">Manage who can view your records</p>
                                </div>
                            </div>
                            <a href="{{ route('patient.permission') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                                View all
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        @if($recentPermissions->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentPermissions as $permission)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0 relative">
                                    <div class="h-10 w-10 rounded-full bg-blue-50 border-2 border-white shadow-sm overflow-hidden flex items-center justify-center">
                                        @if($permission->doctor && $permission->doctor->profile_image_url)
                                            <img src="{{ asset($permission->doctor->profile_image_url) }}" alt="Doctor" class="h-full w-full object-cover">
                                        @else
                                            <i class="fas fa-user-doctor text-blue-600"></i>
                                        @endif
                                    </div>
                                    @php
                                        $status = ucfirst(strtolower($permission->status ?? 'Pending'));
                                        $statusColor = [
                                            'Active' => 'bg-green-500',
                                            'Pending' => 'bg-yellow-500',
                                            'Denied' => 'bg-red-500',
                                        ][$status] ?? 'bg-yellow-500';
                                    @endphp
                                    <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full {{ $statusColor }} ring-2 ring-white"></span>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        Dr. {{ $permission->doctor->full_name ?? 'Unknown Doctor' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Requested: {{ $permission->requested_at?->format('M d, Y') ?? 'N/A' }}
                                        @if($permission->expiry_date)
                                        • Expires: {{ $permission->expiry_date->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    @if(strtolower($permission->status) === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        Active
                                    </span>
                                    @elseif(strtolower($permission->status) === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @elseif(strtolower($permission->status) === 'denied')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Denied
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ ucfirst($permission->status) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        {{-- Summary Stats --}}
                        <div class="mt-5 pt-5 border-t border-gray-200">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-green-50 rounded-lg">
                                    <p class="text-2xl font-bold text-green-600">{{ $activeProviders }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Active Access</p>
                                </div>
                                <div class="text-center p-3 bg-yellow-50 rounded-lg">
                                    <p class="text-2xl font-bold text-yellow-600">{{ $pendingPermissions }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Pending Review</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-8">
                            <div class="flex items-center justify-center h-16 w-16 mx-auto rounded-full bg-gray-100">
                                <i class="fas fa-shield-halved text-gray-400 text-2xl"></i>
                            </div>
                            <p class="mt-4 text-sm font-medium text-gray-900">No access requests yet</p>
                            <p class="mt-1 text-xs text-gray-500">Doctor's requests will appear here</p>
                        </div>
                        @endif
                    </div>
                </section>

            </div>

            {{-- Right Column --}}
            <div class="space-y-6">

                {{-- Health Tips Card --}}
                <section class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-sm text-white overflow-hidden" aria-labelledby="tips-heading">
                    <div class="p-5">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-heart-circle-check text-blue-200"></i>
                            <h2 id="tips-heading" class="text-sm font-semibold text-blue-100">Health Tip of the Day</h2>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-white/20">
                                    <i class="fas {{ $todayTip['icon'] }} text-white"></i>
                                </div>
                            </div>
                            <p class="text-base leading-relaxed">
                                {{ $todayTip['text'] }}
                            </p>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-blue-500/30">
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-blue-100">
                                    <i class="fas fa-calendar-day mr-2"></i>
                                    <span>{{ now()->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center text-blue-100">
                                    <i class="fas fa-rotate mr-2"></i>
                                    <span>Updates daily</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Quick Actions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="actions-heading">
                    <div class="p-5 border-b border-gray-100">
                        <h2 id="actions-heading" class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    
                    <div class="p-3">
                        <nav>
                            <ul role="list" class="space-y-1">
                                <li>
                                    <a href="{{ route('patient.myrecords') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-file-medical-alt text-blue-600" aria-hidden="true"></i>
                                        </div>
                                        <span class="ml-3">All Medical Records</span>
                                        <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs group-hover:text-blue-500"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('patient.medicalHistory') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-book-medical text-blue-600" aria-hidden="true"></i>
                                        </div>
                                        <span class="ml-3">Medical History</span>
                                        <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs group-hover:text-blue-500"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('patient.permission') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100 group-hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-shield-halved text-blue-600" aria-hidden="true"></i>
                                        </div>
                                        <span class="ml-3">Access Permissions</span>
                                        @if($pendingPermissions > 0)
                                        <span class="ml-auto inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-500 text-white text-xs font-bold">{{ $pendingPermissions }}</span>
                                        @else
                                        <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs group-hover:text-blue-500"></i>
                                        @endif
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('patient.profile') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 transition-colors">
                                            <i class="fas fa-user text-gray-600" aria-hidden="true"></i>
                                        </div>
                                        <span class="ml-3">My Profile</span>
                                        <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs group-hover:text-gray-600"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

    <!-- Javascript -->
    @vite(['resources/js/main/main.js'])
    @vite(['resources/js/main/patient/header.js'])
</body>

</html>