<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

@php
    $patient = Auth::guard('patient')->user();
    $hour = now()->hour;
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
    
    // Get patient data counts (replace with actual queries in controller)
    $activeMedications = $patient->medications()->where('status', 'active')->count();
    $activeConditions = $patient->conditions()->where('status', 'active')->count();
    // Labs are stored results, so count total lab records
    $labRecordsCount = $patient->labs()->count();
    $allergiesCount = $patient->allergies()->count();
    $severeAllergies = $patient->allergies()->where('severity', 'severe')->get();
    $pendingPermissions = \App\Models\Permission::where('patient_id', $patient->id)->where('status', 'pending')->count();
    
    // Recent medications for today's schedule
    $todayMedications = $patient->medications()->where('status', 'active')->latest()->take(4)->get();
    
    // Recent medical history (conditions, surgeries, hospitalisations)
    $recentConditions = $patient->conditions()->latest()->take(3)->get();
    
    // Recent labs
    $recentLabs = $patient->labs()->latest()->take(3)->get();
    
    // Upcoming immunisations (if any are overdue or due soon)
    $immunisations = $patient->immunisations()->latest()->take(2)->get();
@endphp

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
                alt="" 
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

        {{-- ============================================= --}}
        {{-- ZONE: WELCOME HEADER --}}
        {{-- ============================================= --}}
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
                        {{ $greeting }}!
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ now()->format('l, F j, Y') }}
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

        {{-- ============================================= --}}
        {{-- ZONE A: CRITICAL ALERTS BANNER --}}
        {{-- ============================================= --}}
        @if($pendingPermissions > 0)
        <div class="mb-6">
            {{-- Pending Permission Requests --}}
            <div class="flex items-center p-4 bg-amber-50 border border-amber-200 rounded-xl" role="alert">
                <div class="flex-shrink-0">
                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-amber-100">
                        <i class="fas fa-user-shield text-amber-600" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-sm font-semibold text-amber-800">{{ $pendingPermissions }} Pending Access Request{{ $pendingPermissions > 1 ? 's' : '' }}</h3>
                    <p class="text-sm text-amber-700">Healthcare providers are requesting access to your records</p>
                </div>
                <a href="{{ route('patient.permission') }}" class="ml-4 inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                    Review
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        @endif

        {{-- ============================================= --}}
        {{-- ZONE B: KEY METRICS - HERO STATS (Bento Grid) --}}
        {{-- ============================================= --}}
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

            {{-- Known Allergies --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-allergies text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $allergiesCount }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Known Allergies</p>
                    <p class="text-xs text-gray-500">On record</p>
                </div>
            </div>
        </div>

        {{-- ============================================= --}}
        {{-- ZONE C: MAIN CONTENT GRID --}}
        {{-- ============================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT COLUMN (2/3 width) --}}
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
                            <a href="{{ route('patient.myrecords') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
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
                            <a href="{{ route('patient.myrecords') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
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
                        @php
                            $recentPermissions = \App\Models\Permission::where('patient_id', $patient->id)
                                ->latest()
                                ->take(3)
                                ->get();
                            $activeProviders = \App\Models\Permission::where('patient_id', $patient->id)
                                ->where('status', 'granted')
                                ->count();
                        @endphp
                        
                        @if($recentPermissions->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentPermissions as $permission)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    @php
                                        $status = $permission->status ?? 'pending';
                                        $statusBg = [
                                            'granted' => 'bg-green-100',
                                            'pending' => 'bg-yellow-100',
                                            'denied' => 'bg-red-100',
                                        ][$status] ?? 'bg-gray-100';
                                        $statusIcon = [
                                            'granted' => 'fa-check text-green-600',
                                            'pending' => 'fa-clock text-yellow-600',
                                            'denied' => 'fa-times text-red-600',
                                        ][$status] ?? 'fa-question text-gray-500';
                                    @endphp
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full {{ $statusBg }}">
                                        <i class="fas {{ $statusIcon }}" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">
                                        Healthcare Provider #{{ $permission->provider_id ?? 'Unknown' }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Requested: {{ $permission->requested_at?->format('M d, Y') ?? 'N/A' }}
                                        @if($permission->expiry_date)
                                        • Expires: {{ $permission->expiry_date->format('M d, Y') }}
                                        @endif
                                    </p>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    @if($permission->status === 'granted')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        Granted
                                    </span>
                                    @elseif($permission->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @elseif($permission->status === 'denied')
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

            {{-- RIGHT COLUMN (1/3 width) --}}
            <div class="space-y-6">

                {{-- Health Tips Card --}}
                <section class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl shadow-sm text-white overflow-hidden" aria-labelledby="tips-heading">
                    <div class="p-5">
                        <div class="flex items-center space-x-2 mb-4">
                            <i class="fas fa-heart-circle-check text-blue-200"></i>
                            <h2 id="tips-heading" class="text-sm font-semibold text-blue-100">Health Tip of the Day</h2>
                        </div>
                        
                        @php
                            $tips = [
                                ['icon' => 'fa-pills', 'text' => 'Take your medications at the same time each day to help build a routine and improve adherence.'],
                                ['icon' => 'fa-glass-water', 'text' => 'Stay hydrated! Aim for 8 glasses of water daily to support your overall health and medication effectiveness.'],
                                ['icon' => 'fa-heart-pulse', 'text' => 'Regular check-ups are essential. Schedule your next appointment to keep your health conditions monitored.'],
                                ['icon' => 'fa-utensils', 'text' => 'A balanced diet rich in fruits, vegetables, and whole grains can help manage chronic conditions effectively.'],
                                ['icon' => 'fa-person-walking', 'text' => 'Even 30 minutes of light exercise daily can significantly improve your health outcomes and energy levels.'],
                                ['icon' => 'fa-bed', 'text' => 'Quality sleep is crucial for healing. Aim for 7-9 hours of consistent sleep each night.'],
                                ['icon' => 'fa-shield-virus', 'text' => 'Keep your immunizations up to date to protect yourself from preventable diseases.'],
                                ['icon' => 'fa-notes-medical', 'text' => 'Keep track of any new symptoms and discuss them with your healthcare provider during your next visit.'],
                            ];
                            
                            $todayTip = $tips[now()->dayOfYear % count($tips)];
                        @endphp
                        
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
                                    <a href="{{ route('patient.auth.profile') }}" class="group flex items-center p-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                                        <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-gray-100 group-hover:bg-gray-200 transition-colors">
                                            <i class="fas fa-user-edit text-gray-600" aria-hidden="true"></i>
                                        </div>
                                        <span class="ml-3">Edit Profile</span>
                                        <i class="fas fa-chevron-right ml-auto text-gray-400 text-xs group-hover:text-gray-600"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </section>

                {{-- Security & Privacy Card --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="security-heading">
                    <div class="p-5 border-b border-gray-100">
                        <h2 id="security-heading" class="text-lg font-semibold text-gray-900">Security & Privacy</h2>
                    </div>
                    
                    <div class="p-5 space-y-4">
                        {{-- Last Login --}}
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100">
                                <i class="fas fa-clock text-blue-600 text-sm" aria-hidden="true"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Last Login</p>
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $patient->last_login ? $patient->last_login->format('M d, Y \a\t h:i A') : 'First login' }}
                                </p>
                            </div>
                        </div>

                        {{-- Account Status --}}
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100">
                                <i class="fas fa-user-check text-blue-600 text-sm" aria-hidden="true"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Email Verification</p>
                                <p class="text-sm font-medium text-gray-900">
                                    @if($patient->email_verified_at)
                                    <span class="text-green-600">Verified</span>
                                    @else
                                    <span class="text-amber-600">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Active Doctors --}}
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center justify-center h-9 w-9 rounded-lg bg-blue-100">
                                <i class="fas fa-user-doctor text-blue-600 text-sm" aria-hidden="true"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Active Doctors</p>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ \App\Models\Permission::where('patient_id', $patient->id)->where('status', 'granted')->count() }} with access
                                </p>
                            </div>
                        </div>
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