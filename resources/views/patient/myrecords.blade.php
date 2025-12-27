<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>My Records</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    @include('patient.components.banner')

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 lg:px-8 py-8">

        @include('patient.components.recordNav')

        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-700">
                Total Records Overview:
            </h1>
        </div>

        {{-- Health Stats Dashboard --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 mb-8" aria-label="Health statistics summary cards">

            <!-- Conditions Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-heartbeat text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalConditions }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Conditions</p>
                    <p class="text-xs text-gray-500">Total medical conditions</p>
                </div>
            </div>

            <!-- Medications Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-pills text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalMedications }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Medications</p>
                    <p class="text-xs text-gray-500">Active prescriptions</p>
                </div>
            </div>

            <!-- Allergies Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-allergies text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalAllergies }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Allergies</p>
                    <p class="text-xs text-gray-500">Known patient allergies</p>
                </div>
            </div>

            <!-- Immunisations Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-syringe text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalVaccinations }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Immunisations</p>
                    <p class="text-xs text-gray-500">Vaccination records</p>
                </div>
            </div>

            <!-- Lab Tests Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-flask text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalLabTests }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Lab Tests</p>
                    <p class="text-xs text-gray-500">Diagnostic test results</p>
                </div>
            </div>
        </section>

        {{-- 3-Row Responsive Grid Layout --}}
        <div class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Medical Conditions Card --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="conditions-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="conditions-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-heartbeat text-blue-600" aria-hidden="true"></i>
                            Recent Medical Conditions
                        </h2>
                        <a href="{{ route('patient.medicalCondition') }}" 
                           aria-label="View all medical conditions"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($recentConditions as $condition)
                        <div class="group bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 mb-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">{{ $condition->condition_name }}</h3>
                                            <p class="text-xs text-gray-500">
                                                Diagnosed: {{ $condition->diagnosis_date ? $condition->diagnosis_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($condition->description)
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                            {{ $condition->description }}
                                        </p>
                                    @endif
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-4">
                                    <a href="{{ route('patient.condition.info', $condition->id) }}" 
                                       class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                        More info
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-file-medical text-blue-600 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium">No recent medical conditions found.</p>
                            <p class="text-sm text-gray-500 mt-1">Start tracking your health conditions to see them here.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Medication Card --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="medications-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="medications-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-pills text-blue-600" aria-hidden="true"></i>
                            Current Medications
                        </h2>
                        <a href="{{ route('patient.medication') }}" 
                            aria-label="View all medications"
                            class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($recentMedications as $medication)
                        <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 mb-3 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-base font-semibold text-gray-900">{{ $medication->medication_name }}</h3>
                                    </div>
                                    
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Dosage:</span> {{ $medication->formatted_dosage }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Frequency:</span> {{ $medication->frequency ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-3">
                                    <a href="{{ route('patient.medication.info', $medication->id) }}" 
                                        class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                        More info
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-pills text-blue-600 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium">No recent medications found.</p>
                            <p class="text-sm text-gray-500 mt-1">Add your medications to track them here.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

            {{-- Medication Card & Allergy Card --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Allergy Card --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="allergies-heading">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 id="allergies-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-allergies text-blue-600" aria-hidden="true"></i>
                                Active Allergies
                            </h2>
                            <a href="{{ route('patient.allergy') }}" 
                               aria-label="View all allergies"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                                See All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @forelse ($recentAllergies as $allergy)
                            <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 mb-3 hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h3 class="text-base font-semibold text-gray-900">{{ $allergy->allergen }}</h3>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Type:</span> {{ $allergy->allergy_type ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">First Observed:</span> {{ $allergy->first_observed_date ? $allergy->first_observed_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- More Info Button --}}
                                    <div class="ml-3">
                                        <a href="{{ route('patient.allergy.info', $allergy->id) }}" 
                                           class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                            More info
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-allergies text-blue-600 text-2xl" aria-hidden="true"></i>
                                </div>
                                <p class="text-gray-600 font-medium">No active allergies found.</p>
                                <p class="text-sm text-gray-500 mt-1">Record your allergies to keep track of them.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                {{-- Vaccination Card --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="vaccinations-heading">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 id="vaccinations-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-syringe text-blue-600" aria-hidden="true"></i>
                                Recent Vaccinations
                            </h2>
                            <a href="{{ route('patient.immunisation') }}" 
                               aria-label="View all vaccinations"
                               class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                                See All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @forelse ($recentVaccinations as $vaccination)
                            <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 mb-3 hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <h3 class="text-base font-semibold text-gray-900">{{ $vaccination->vaccine_name }}</h3>
                                        </div>
                                        
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Dose:</span> {{ $vaccination->dose_details ?? 'N/A' }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Date:</span> {{ $vaccination->vaccination_date ? $vaccination->vaccination_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- More Info Button --}}
                                    <div class="ml-3">
                                        <a href="{{ route('patient.immunisation.info', $vaccination->id) }}" 
                                           class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                            More info
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50 rounded-lg">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-syringe text-blue-600 text-2xl" aria-hidden="true"></i>
                                </div>
                                <p class="text-gray-600 font-medium">No recent vaccinations found.</p>
                                <p class="text-sm text-gray-500 mt-1">Keep track of your immunization records here.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

                {{-- Lab Test Card --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="lab-tests-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="lab-tests-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-flask text-blue-600" aria-hidden="true"></i>
                            Recent Lab Tests
                        </h2>
                        <a href="{{ route('patient.lab') }}" 
                            aria-label="View all lab tests"
                            class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($recentLabTests as $labTest)
                        <div class="bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-4 mb-3 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-base font-semibold text-gray-900">{{ $labTest->test_name }}</h3>
                                    </div>
                                    
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Category:</span> {{ $labTest->test_category ?? 'N/A' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Date:</span> {{ $labTest->test_date ? $labTest->test_date->format('M d, Y') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-3">
                                    <a href="{{ route('patient.lab.info', $labTest->id) }}" 
                                        class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                        More info
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-flask text-blue-600 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium">No recent lab tests found.</p>
                            <p class="text-sm text-gray-500 mt-1">Add your lab test results to monitor your health.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')
</body>

</html>
