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
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <a href="{{ route('doctor.patients') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium mb-6">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to My Patients
                </a>

                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Patient Information</h1>
                    <p class="mt-2 text-sm text-gray-600">Detailed medical records and information</p>
                </div>

                <!-- Profile Header -->
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Profile Picture -->
                        <div class="flex-shrink-0">
                            @if($patient->profile_image_url)
                                <img src="{{ asset($patient->profile_image_url) }}" 
                                     alt="{{ $patient->full_name }}"
                                     class="w-28 h-28 rounded-full object-cover border-4 border-gray-100">
                            @else
                                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-4 border-blue-100">
                                    <i class="fas fa-user text-blue-600 text-4xl"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Basic Info -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $patient->full_name }}</h2>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-calendar mr-1.5"></i>
                                    {{ $patient->age }} years old
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-100 text-{{ $patient->gender === 'Male' ? 'blue' : 'pink' }}-800">
                                    <i class="fas fa-{{ $patient->gender === 'Male' ? 'mars' : 'venus' }} mr-1.5"></i>
                                    {{ $patient->gender }}
                                </span>
                                @if($patient->blood_type)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-tint mr-1.5"></i>
                                    {{ $patient->blood_type }}
                                </span>
                                @endif
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
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
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-ruler-vertical w-5 text-gray-400 mr-2"></i>
                                    <span class="font-medium text-gray-700 mr-1">Height:</span>
                                    {{ $patient->height ? $patient->height . ' cm' : 'N/A' }}
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-weight w-5 text-gray-400 mr-2"></i>
                                    <span class="font-medium text-gray-700 mr-1">Weight:</span>
                                    {{ $patient->weight ? $patient->weight . ' kg' : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical Records Section -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="flex overflow-x-auto" aria-label="Tabs">
                            <button onclick="showTab('conditions')" 
                                    id="tab-conditions"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-medium transition-colors border-blue-500 text-blue-600 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-notes-medical mr-2"></i>
                                Medical Conditions
                                <span class="ml-2 bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full text-xs">{{ $patient->conditions->count() }}</span>
                            </button>
                            <button onclick="showTab('medications')" 
                                    id="tab-medications"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-medium transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-pills mr-2"></i>
                                Medications
                                <span class="ml-2 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $patient->medications->count() }}</span>
                            </button>
                            <button onclick="showTab('allergies')" 
                                    id="tab-allergies"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-medium transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Allergies
                                <span class="ml-2 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $patient->allergies->count() }}</span>
                            </button>
                            <button onclick="showTab('immunisations')" 
                                    id="tab-immunisations"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-medium transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-syringe mr-2"></i>
                                Immunisations
                                <span class="ml-2 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $patient->immunisations->count() }}</span>
                            </button>
                            <button onclick="showTab('labs')" 
                                    id="tab-labs"
                                    class="tab-button whitespace-nowrap border-b-2 px-6 py-4 text-sm font-medium transition-colors border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-flask mr-2"></i>
                                Lab Tests
                                <span class="ml-2 bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full text-xs">{{ $patient->labs->count() }}</span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="p-6">
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

                                <!-- Pagination -->
                                @if($conditionsTotalPages > 1)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                                        <div class="text-sm text-gray-600">
                                            Page {{ $conditionsPage }} of {{ $conditionsTotalPages }}
                                        </div>
                                        <div class="flex gap-1">
                                            @if($conditionsPage > 1)
                                                <a href="?conditions_page={{ $conditionsPage - 1 }}" 
                                                   onclick="showTab('conditions')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            @endif
                                            @if($conditionsPage < $conditionsTotalPages)
                                                <a href="?conditions_page={{ $conditionsPage + 1 }}" 
                                                   onclick="showTab('conditions')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    @foreach($paginatedConditions as $condition)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $condition->condition_name }}</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Diagnosed:</span> 
                                                            {{ $condition->diagnosed_date ? $condition->diagnosed_date->format('d M Y') : 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Status:</span> 
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $condition->status === 'Active' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                                                                {{ $condition->status ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if($condition->notes)
                                                        <div class="mt-3 text-sm text-gray-600">
                                                            <span class="font-medium">Notes:</span>
                                                            <p class="mt-1 line-clamp-2">{{ $condition->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('doctor.medical.records.condition', $condition->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-notes-medical text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500">No medical conditions recorded</p>
                                </div>
                            @endif
                        </div>

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

                                <!-- Pagination -->
                                @if($medicationsTotalPages > 1)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                                        <div class="text-sm text-gray-600">
                                            Page {{ $medicationsPage }} of {{ $medicationsTotalPages }}
                                        </div>
                                        <div class="flex gap-1">
                                            @if($medicationsPage > 1)
                                                <a href="?medications_page={{ $medicationsPage - 1 }}" 
                                                   onclick="showTab('medications')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            @endif
                                            @if($medicationsPage < $medicationsTotalPages)
                                                <a href="?medications_page={{ $medicationsPage + 1 }}" 
                                                   onclick="showTab('medications')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    @foreach($paginatedMedications as $medication)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $medication->medication_name }}</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Dosage:</span> 
                                                            {{ $medication->dosage ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Frequency:</span> 
                                                            {{ $medication->frequency ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Started:</span> 
                                                            {{ $medication->start_date ? $medication->start_date->format('d M Y') : 'N/A' }}
                                                        </div>
                                                    </div>
                                                    @if($medication->notes)
                                                        <div class="mt-3 text-sm text-gray-600">
                                                            <span class="font-medium">Notes:</span>
                                                            <p class="mt-1 line-clamp-2">{{ $medication->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('doctor.medical.records.medication', $medication->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-pills text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500">No medications recorded</p>
                                </div>
                            @endif
                        </div>

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

                                <!-- Pagination -->
                                @if($allergiesTotalPages > 1)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                                        <div class="text-sm text-gray-600">
                                            Page {{ $allergiesPage }} of {{ $allergiesTotalPages }}
                                        </div>
                                        <div class="flex gap-1">
                                            @if($allergiesPage > 1)
                                                <a href="?allergies_page={{ $allergiesPage - 1 }}" 
                                                   onclick="showTab('allergies')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            @endif
                                            @if($allergiesPage < $allergiesTotalPages)
                                                <a href="?allergies_page={{ $allergiesPage + 1 }}" 
                                                   onclick="showTab('allergies')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    @foreach($paginatedAllergies as $allergy)
                                        <div class="border border-red-200 bg-red-50 rounded-lg p-4 hover:border-red-300 transition-colors">
                                            <div class="flex items-start gap-4">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $allergy->allergen }}</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                                        <div class="text-gray-700">
                                                            <span class="font-medium">Type:</span> 
                                                            {{ $allergy->allergy_type ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-700">
                                                            <span class="font-medium">Severity:</span> 
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $allergy->severity === 'Severe' ? 'bg-red-600 text-white' : 
                                                                   ($allergy->severity === 'Moderate' ? 'bg-orange-500 text-white' : 'bg-yellow-500 text-white') }}">
                                                                {{ $allergy->severity ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if($allergy->reaction)
                                                        <div class="mt-3 text-sm text-gray-700">
                                                            <span class="font-medium">Reaction:</span>
                                                            <p class="mt-1 line-clamp-2">{{ $allergy->reaction }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('doctor.medical.records.allergy', $allergy->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-exclamation-triangle text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500">No allergies recorded</p>
                                </div>
                            @endif
                        </div>

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

                                <!-- Pagination -->
                                @if($immunisationsTotalPages > 1)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                                        <div class="text-sm text-gray-600">
                                            Page {{ $immunisationsPage }} of {{ $immunisationsTotalPages }}
                                        </div>
                                        <div class="flex gap-1">
                                            @if($immunisationsPage > 1)
                                                <a href="?immunisations_page={{ $immunisationsPage - 1 }}" 
                                                   onclick="showTab('immunisations')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            @endif
                                            @if($immunisationsPage < $immunisationsTotalPages)
                                                <a href="?immunisations_page={{ $immunisationsPage + 1 }}" 
                                                   onclick="showTab('immunisations')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    @foreach($paginatedImmunisations as $immunisation)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $immunisation->vaccine_name }}</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Date Given:</span> 
                                                            {{ $immunisation->date_given ? $immunisation->date_given->format('d M Y') : 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Dose Number:</span> 
                                                            {{ $immunisation->dose_number ?? 'N/A' }}
                                                        </div>
                                                        @if($immunisation->next_dose_date)
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Next Dose:</span> 
                                                            {{ $immunisation->next_dose_date->format('d M Y') }}
                                                        </div>
                                                        @endif
                                                    </div>
                                                    @if($immunisation->notes)
                                                        <div class="mt-3 text-sm text-gray-600">
                                                            <span class="font-medium">Notes:</span>
                                                            <p class="mt-1 line-clamp-2">{{ $immunisation->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('doctor.medical.records.immunisation', $immunisation->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-syringe text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500">No immunisations recorded</p>
                                </div>
                            @endif
                        </div>

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

                                <!-- Pagination -->
                                @if($labsTotalPages > 1)
                                    <div class="flex items-center justify-between border-b border-gray-200 pb-4 mb-6">
                                        <div class="text-sm text-gray-600">
                                            Page {{ $labsPage }} of {{ $labsTotalPages }}
                                        </div>
                                        <div class="flex gap-1">
                                            @if($labsPage > 1)
                                                <a href="?labs_page={{ $labsPage - 1 }}" 
                                                   onclick="showTab('labs')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                            @endif
                                            @if($labsPage < $labsTotalPages)
                                                <a href="?labs_page={{ $labsPage + 1 }}" 
                                                   onclick="showTab('labs')"
                                                   class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            @else
                                                <button disabled class="px-3 py-1 bg-gray-100 text-gray-600 rounded opacity-50 cursor-not-allowed">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="space-y-4">
                                    @foreach($paginatedLabs as $lab)
                                        <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                            <div class="flex items-start justify-between gap-4">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $lab->test_name }}</h4>
                                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Test Date:</span> 
                                                            {{ $lab->test_date ? $lab->test_date->format('d M Y') : 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Result:</span> 
                                                            {{ $lab->result ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-gray-600">
                                                            <span class="font-medium">Status:</span> 
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                                {{ $lab->status === 'Normal' ? 'bg-green-100 text-green-800' : 
                                                                   ($lab->status === 'Abnormal' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                                {{ $lab->status ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if($lab->notes)
                                                        <div class="mt-3 text-sm text-gray-600">
                                                            <span class="font-medium">Notes:</span>
                                                            <p class="mt-1 line-clamp-2">{{ $lab->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('doctor.medical.records.lab', $lab->id) }}" 
                                                       class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                        
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <i class="fas fa-flask text-gray-300 text-5xl mb-4"></i>
                                    <p class="text-gray-500">No lab tests recorded</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

    <!-- Patient Details Tabs Script -->
    @vite('resources/js/main/doctor/patientProfileTabs.js')

</body>

</html>
