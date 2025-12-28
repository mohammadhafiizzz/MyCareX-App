<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - {{ $patient->full_name }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('doctor.patients') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to My Patients
                    </a>
                </div>

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Patient Profile</h1>
                    <p class="text-sm text-gray-500">Detailed medical records and personal information.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Profile Card -->
                    <div class="space-y-6 flex flex-col">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-1">
                            <div class="p-6 sm:p-8 flex flex-col items-center text-center h-full justify-center">
                                <div class="relative w-24 h-24 sm:w-32 sm:h-32 mb-4 sm:mb-5 mx-auto shrink-0">
                                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl sm:text-4xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                        @if($patient->profile_image_url)
                                            <img src="{{ asset($patient->profile_image_url) }}" alt="{{ $patient->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user"></i>
                                        @endif
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h2>
                                <p class="text-sm text-gray-500 mb-4">{{ $patient->age }} years old • {{ $patient->gender }}</p>

                                <div class="w-full border-t border-gray-100 pt-6">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="text-center">
                                            <span class="block text-[10px] text-gray-400 uppercase font-bold">Height</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $patient->height ? $patient->height . ' cm' : 'N/A' }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="block text-[10px] text-gray-400 uppercase font-bold">Weight</span>
                                            <span class="text-sm font-semibold text-gray-900">{{ $patient->weight ? $patient->weight . ' kg' : 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Personal Details Card -->
                    <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-address-card text-gray-400"></i> PERSONAL DETAILS
                            </h3>
                        </div>
                        
                        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->ic_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->phone_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Date of Birth</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->date_of_birth->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Gender</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->gender }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Race</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->race ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Blood Type</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->blood_type ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Location and Emergency Contact -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Contact & Location -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-location-dot text-gray-400"></i> CONTACT & LOCATION
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Home Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->address ?? 'N/A' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Postal Code</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->postal_code ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">State</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->state ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-phone-flip text-gray-400"></i> EMERGENCY CONTACT
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Contact Name</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->emergency_contact_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Relationship</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->emergency_contact_relationship ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC Number</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->emergency_contact_ic_number ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                    <p class="text-sm text-gray-900 font-medium text-blue-600">{{ $patient->emergency_contact_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-file-medical text-gray-400"></i> MEDICAL RECORDS
                        </h3>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-100">
                        <nav class="flex overflow-x-auto no-scrollbar" aria-label="Tabs">
                            @if($isAll || in_array('medical_conditions', $scope))
                            <button onclick="showTab('conditions')" 
                                    id="tab-conditions"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-bold transition-all border-blue-600 text-blue-600">
                                <i class="fas fa-heartbeat mr-2"></i>
                                Conditions
                                <span class="ml-2 bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full text-[10px] border border-blue-100">{{ $patient->conditions->count() }}</span>
                            </button>
                            @endif

                            @if($isAll || in_array('medications', $scope))
                            <button onclick="showTab('medications')" 
                                    id="tab-medications"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-bold transition-all border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200">
                                <i class="fas fa-pills mr-2"></i>
                                Medications
                                <span class="ml-2 bg-gray-50 text-gray-400 px-2 py-0.5 rounded-full text-[10px] border border-gray-100">{{ $patient->medications->count() }}</span>
                            </button>
                            @endif

                            @if($isAll || in_array('allergies', $scope))
                            <button onclick="showTab('allergies')" 
                                    id="tab-allergies"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-bold transition-all border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200">
                                <i class="fas fa-allergies mr-2"></i>
                                Allergies
                                <span class="ml-2 bg-gray-50 text-gray-400 px-2 py-0.5 rounded-full text-[10px] border border-gray-100">{{ $patient->allergies->count() }}</span>
                            </button>
                            @endif

                            @if($isAll || in_array('immunisations', $scope))
                            <button onclick="showTab('immunisations')" 
                                    id="tab-immunisations"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-bold transition-all border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200">
                                <i class="fas fa-syringe mr-2"></i>
                                Immunisations
                                <span class="ml-2 bg-gray-50 text-gray-400 px-2 py-0.5 rounded-full text-[10px] border border-gray-100">{{ $patient->immunisations->count() }}</span>
                            </button>
                            @endif

                            @if($isAll || in_array('lab_tests', $scope))
                            <button onclick="showTab('labs')" 
                                    id="tab-labs"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-bold transition-all border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200">
                                <i class="fas fa-flask mr-2"></i>
                                Lab Tests
                                <span class="ml-2 bg-gray-50 text-gray-400 px-2 py-0.5 rounded-full text-[10px] border border-gray-100">{{ $patient->labs->count() }}</span>
                            </button>
                            @endif
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
                        @if($isAll || in_array('medical_conditions', $scope))
                        <!-- Medical Conditions Tab -->
                        <div id="content-conditions" class="tab-content">
                            @if($patient->conditions->count() > 0)
                                @php
                                    $conditionsPerPage = 5;
                                    $conditionsPage = request()->get('conditions_page', 1);
                                    $conditionsTotal = $patient->conditions->count();
                                    $conditionsTotalPages = ceil($conditionsTotal / $conditionsPerPage);
                                    $conditionsOffset = ($conditionsPage - 1) * $conditionsPerPage;
                                    $paginatedConditions = $patient->conditions->slice($conditionsOffset, $conditionsPerPage);
                                @endphp

                                <!-- Pagination & Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <p class="text-sm text-gray-500">
                                        Showing <span class="font-medium text-gray-900">{{ $paginatedConditions->count() }}</span> of <span class="font-medium text-gray-900">{{ $conditionsTotal }}</span> conditions
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                            <span class="hidden sm:inline">Most recent first</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($conditionsPage > 1)
                                                <a href="?conditions_page={{ $conditionsPage - 1 }}" 
                                                   onclick="showTab('conditions')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </button>
                                            @endif

                                            <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium">
                                                Page {{ $conditionsPage }} of {{ $conditionsTotalPages }}
                                            </span>

                                            @if($conditionsPage < $conditionsTotalPages)
                                                <a href="?conditions_page={{ $conditionsPage + 1 }}" 
                                                   onclick="showTab('conditions')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Condition Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Diagnosed Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($paginatedConditions as $condition)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $condition->condition_name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $condition->diagnosed_date ? $condition->diagnosed_date->format('d M Y') : 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                                            {{ $condition->status === 'Active' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                                            {{ $condition->status ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.condition', $condition->id) }}" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold rounded-lg transition-all border border-blue-100">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-heartbeat text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No medical conditions recorded</p>
                                </div>
                            @endif
                        </div>
                        @endif

                        @if($isAll || in_array('medications', $scope))
                        <!-- Medications Tab -->
                        <div id="content-medications" class="tab-content hidden">
                            @if($patient->medications->count() > 0)
                                @php
                                    $medicationsPerPage = 5;
                                    $medicationsPage = request()->get('medications_page', 1);
                                    $medicationsTotal = $patient->medications->count();
                                    $medicationsTotalPages = ceil($medicationsTotal / $medicationsPerPage);
                                    $medicationsOffset = ($medicationsPage - 1) * $medicationsPerPage;
                                    $paginatedMedications = $patient->medications->slice($medicationsOffset, $medicationsPerPage);
                                @endphp

                                <!-- Pagination & Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <p class="text-sm text-gray-500">
                                        Showing <span class="font-medium text-gray-900">{{ $paginatedMedications->count() }}</span> of <span class="font-medium text-gray-900">{{ $medicationsTotal }}</span> medications
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                            <span class="hidden sm:inline">Most recent first</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($medicationsPage > 1)
                                                <a href="?medications_page={{ $medicationsPage - 1 }}" 
                                                   onclick="showTab('medications')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </button>
                                            @endif

                                            <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium">
                                                Page {{ $medicationsPage }} of {{ $medicationsTotalPages }}
                                            </span>

                                            @if($medicationsPage < $medicationsTotalPages)
                                                <a href="?medications_page={{ $medicationsPage + 1 }}" 
                                                   onclick="showTab('medications')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Medication Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Dosage</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Frequency</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Start Date</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($paginatedMedications as $medication)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $medication->medication_name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $medication->dosage ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $medication->frequency ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $medication->start_date ? $medication->start_date->format('d M Y') : 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.medication', $medication->id) }}" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold rounded-lg transition-all border border-blue-100">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-pills text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No medications recorded</p>
                                </div>
                            @endif
                        </div>
                        @endif

                        @if($isAll || in_array('allergies', $scope))
                        <!-- Allergies Tab -->
                        <div id="content-allergies" class="tab-content hidden">
                            @if($patient->allergies->count() > 0)
                                @php
                                    $allergiesPerPage = 5;
                                    $allergiesPage = request()->get('allergies_page', 1);
                                    $allergiesTotal = $patient->allergies->count();
                                    $allergiesTotalPages = ceil($allergiesTotal / $allergiesPerPage);
                                    $allergiesOffset = ($allergiesPage - 1) * $allergiesPerPage;
                                    $paginatedAllergies = $patient->allergies->slice($allergiesOffset, $allergiesPerPage);
                                @endphp

                                <!-- Pagination & Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <p class="text-sm text-gray-500">
                                        Showing <span class="font-medium text-gray-900">{{ $paginatedAllergies->count() }}</span> of <span class="font-medium text-gray-900">{{ $allergiesTotal }}</span> allergies
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                            <span class="hidden sm:inline">Most recent first</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($allergiesPage > 1)
                                                <a href="?allergies_page={{ $allergiesPage - 1 }}" 
                                                   onclick="showTab('allergies')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </button>
                                            @endif

                                            <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium">
                                                Page {{ $allergiesPage }} of {{ $allergiesTotalPages }}
                                            </span>

                                            @if($allergiesPage < $allergiesTotalPages)
                                                <a href="?allergies_page={{ $allergiesPage + 1 }}" 
                                                   onclick="showTab('allergies')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Allergen</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Type</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Severity</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($paginatedAllergies as $allergy)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $allergy->allergen }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $allergy->allergy_type ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                                            {{ $allergy->severity === 'Severe' ? 'bg-red-600 text-white border-red-700' : 
                                                               ($allergy->severity === 'Moderate' ? 'bg-orange-500 text-white border-orange-600' : 'bg-yellow-500 text-white border-yellow-600') }}">
                                                            {{ $allergy->severity ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.allergy', $allergy->id) }}" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold rounded-lg transition-all border border-blue-100">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-allergies text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No allergies recorded</p>
                                </div>
                            @endif
                        </div>
                        @endif

                        @if($isAll || in_array('immunisations', $scope))
                        <!-- Immunisations Tab -->
                        <div id="content-immunisations" class="tab-content hidden">
                            @if($patient->immunisations->count() > 0)
                                @php
                                    $immunisationsPerPage = 5;
                                    $immunisationsPage = request()->get('immunisations_page', 1);
                                    $immunisationsTotal = $patient->immunisations->count();
                                    $immunisationsTotalPages = ceil($immunisationsTotal / $immunisationsPerPage);
                                    $immunisationsOffset = ($immunisationsPage - 1) * $immunisationsPerPage;
                                    $paginatedImmunisations = $patient->immunisations->slice($immunisationsOffset, $immunisationsPerPage);
                                @endphp

                                <!-- Pagination & Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <p class="text-sm text-gray-500">
                                        Showing <span class="font-medium text-gray-900">{{ $paginatedImmunisations->count() }}</span> of <span class="font-medium text-gray-900">{{ $immunisationsTotal }}</span> immunisations
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                            <span class="hidden sm:inline">Most recent first</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($immunisationsPage > 1)
                                                <a href="?immunisations_page={{ $immunisationsPage - 1 }}" 
                                                   onclick="showTab('immunisations')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </button>
                                            @endif

                                            <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium">
                                                Page {{ $immunisationsPage }} of {{ $immunisationsTotalPages }}
                                            </span>

                                            @if($immunisationsPage < $immunisationsTotalPages)
                                                <a href="?immunisations_page={{ $immunisationsPage + 1 }}" 
                                                   onclick="showTab('immunisations')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Vaccine Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Date Given</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Dose</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Next Dose</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($paginatedImmunisations as $immunisation)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $immunisation->vaccine_name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $immunisation->date_given ? $immunisation->date_given->format('d M Y') : 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $immunisation->dose_number ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                                        @if($immunisation->next_dose_date)
                                                            <span class="text-blue-600">{{ $immunisation->next_dose_date->format('d M Y') }}</span>
                                                        @else
                                                            <span class="text-gray-400">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.immunisation', $immunisation->id) }}" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold rounded-lg transition-all border border-blue-100">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-syringe text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No immunisations recorded</p>
                                </div>
                            @endif
                        </div>
                        @endif

                        @if($isAll || in_array('lab_tests', $scope))
                        <!-- Lab Tests Tab -->
                        <div id="content-labs" class="tab-content hidden">
                            @if($patient->labs->count() > 0)
                                @php
                                    $labsPerPage = 5;
                                    $labsPage = request()->get('labs_page', 1);
                                    $labsTotal = $patient->labs->count();
                                    $labsTotalPages = ceil($labsTotal / $labsPerPage);
                                    $labsOffset = ($labsPage - 1) * $labsPerPage;
                                    $paginatedLabs = $patient->labs->slice($labsOffset, $labsPerPage);
                                @endphp

                                <!-- Pagination & Info -->
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                    <p class="text-sm text-gray-500">
                                        Showing <span class="font-medium text-gray-900">{{ $paginatedLabs->count() }}</span> of <span class="font-medium text-gray-900">{{ $labsTotal }}</span> lab tests
                                    </p>
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                            <span class="hidden sm:inline">Most recent first</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($labsPage > 1)
                                                <a href="?labs_page={{ $labsPage - 1 }}" 
                                                   onclick="showTab('labs')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left text-xs"></i>
                                                    <span class="hidden sm:inline">Previous</span>
                                                </button>
                                            @endif

                                            <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium">
                                                Page {{ $labsPage }} of {{ $labsTotalPages }}
                                            </span>

                                            @if($labsPage < $labsTotalPages)
                                                <a href="?labs_page={{ $labsPage + 1 }}" 
                                                   onclick="showTab('labs')"
                                                   class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </a>
                                            @else
                                                <button disabled class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium opacity-40 cursor-not-allowed">
                                                    <span class="hidden sm:inline">Next</span>
                                                    <i class="fas fa-chevron-right text-xs"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto border border-gray-100 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Test Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Test Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Result</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($paginatedLabs as $lab)
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-gray-900">{{ $lab->test_name }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $lab->test_date ? $lab->test_date->format('d M Y') : 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                        {{ $lab->result ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                                            {{ $lab->status === 'Normal' ? 'bg-green-50 text-green-600 border-green-100' : 
                                                               ($lab->status === 'Abnormal' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-gray-50 text-gray-600 border-gray-100') }}">
                                                            {{ $lab->status ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.lab', $lab->id) }}" 
                                                           class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white text-[10px] font-bold rounded-lg transition-all border border-blue-100">
                                                            View Details
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-flask text-gray-300 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No lab tests recorded</p>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Actions Section -->
                <div class="mt-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-gear text-gray-400"></i> ACTIONS
                            </h3>
                        </div>
                        
                        <div class="p-4 sm:p-6 space-y-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between py-4 gap-3">
                                <div>
                                    <p class="text-sm font-medium text-red-600">Terminate Access</p>
                                    <p class="text-xs text-red-400">Permanently terminate your access to this patient's medical records. You will need to request access again if needed.</p>
                                </div>
                                <button id="terminateAccessBtn" 
                                        data-permission-id="{{ $permission->id }}"
                                        data-patient-name="{{ $patient->full_name }}"
                                        class="w-full sm:w-auto px-4 py-2 text-xs font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                                    Terminate Access
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Terminate Access Modal -->
    @include('doctor.modules.permission.terminateAccess')

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 z-[200] transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-white shadow-xl rounded-lg p-4 flex items-center gap-3 min-w-[300px] border border-gray-100">
            <div id="toastIcon" class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <p id="toastTitle" class="text-sm font-bold text-gray-900">Success</p>
                <p id="toastMessage" class="text-xs text-gray-500">Action completed successfully.</p>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

    <!-- Patient Details Tabs Script -->
    @vite(['resources/js/main/doctor/patientDetailsTabs.js', 'resources/js/main/doctor/terminateAccess.js'])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('medications_page')) showTab('medications');
            else if (urlParams.has('allergies_page')) showTab('allergies');
            else if (urlParams.has('immunisations_page')) showTab('immunisations');
            else if (urlParams.has('labs_page')) showTab('labs');
            // Default is conditions, which is already active in HTML
        });
    </script>

</body>

</html>
