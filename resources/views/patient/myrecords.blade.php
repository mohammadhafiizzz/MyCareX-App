<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - My Records</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <!-- Banner -->
    <section class="relative h-80 bg-gray-900 overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/my_records.png') }}" 
                alt="" 
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gray-900/40"></div>
        </div>
        
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
                    My Records
                </h1>
                <p class="text-lg md:text-xl text-gray-200">
                    Manage your own medical records
                </p>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 lg:px-8 py-8">

        @include('patient.components.recordNav')

        <div class="mb-8">
            <h1 class="text-2xl font-semibold text-gray-700">
                Total Records Overview:
            </h1>
        </div>

        {{-- Health Stats Dashboard --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8" aria-label="Health statistics summary cards">
            
            {{-- Conditions Stats Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/15 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-12 mb-4"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Conditions</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalConditions }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($severeConditions > 0)
                            {{ $severeConditions }} {{ Str::plural('condition', $severeConditions) }} need immediate attention
                        @else
                            All conditions are being monitored appropriately
                        @endif
                    </p>
                </div>
            </article>

            {{-- Medications Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/15 rounded-full -mr-6 -mt-6"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/85">Medications</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalMedications }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($totalMedications > 0)
                            Stay on schedule with your prescriptions and refills
                        @else
                            No medications currently tracked
                        @endif
                    </p>
                </div>
            </article>

            {{-- Allergies Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Allergies</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalAllergies }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-allergies text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($severeAllergies > 0)
                            Severe reactions: <span class="font-semibold">{{ $severeAllergies }}</span>. Always inform your healthcare providers
                        @elseif($totalAllergies > 0)
                            Keep your healthcare providers informed about your allergies
                        @else
                            No allergies recorded
                        @endif
                    </p>
                </div>
            </article>

            {{-- Vaccinations Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-teal-500 to-teal-600 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Vaccinations</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalVaccinations }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-syringe text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($totalVaccinations > 0)
                            Stay up to date with your immunizations
                        @else
                            No vaccinations recorded yet
                        @endif
                    </p>
                </div>
            </article>

            {{-- Lab Results Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/25 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Lab Tests</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalLabTests }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($totalLabTests > 0)
                            Keep tracking your health metrics and test results
                        @else
                            No lab tests recorded yet
                        @endif
                    </p>
                </div>
            </article>
        </section>

        {{-- 3-Row Responsive Grid Layout --}}
        <div class="space-y-6">

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

                                    <div class="flex flex-wrap gap-2">
                                        {{-- Status Badge --}}
                                        @php
                                            $statusColors = [
                                                'Active' => 'bg-green-100 text-green-800',
                                                'Inactive' => 'bg-gray-100 text-gray-800',
                                                'Resolved' => 'bg-blue-100 text-blue-800',
                                                'Chronic' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $statusColor = $statusColors[$condition->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ $condition->status }}
                                        </span>

                                        {{-- Severity Badge --}}
                                        @php
                                            $severityColors = [
                                                'Mild' => 'bg-yellow-100 text-yellow-800',
                                                'Moderate' => 'bg-orange-100 text-orange-800',
                                                'Severe' => 'bg-red-100 text-red-800',
                                            ];
                                            $severityColor = $severityColors[$condition->severity] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium {{ $severityColor }}">
                                            {{ $condition->severity }}
                                        </span>
                                    </div>
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-4">
                                    <a href="{{ route('patient.condition.info', $condition->id) }}" 
                                       class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                        <i class="fas fa-info-circle" aria-hidden="true"></i>
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

            {{-- Medication Card & Allergy Card --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
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
                                           class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                            <i class="fas fa-info-circle" aria-hidden="true"></i>
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
                                            <div class="flex gap-2 mt-2">
                                                @php
                                                    $severityColors = [
                                                        'Mild' => 'bg-yellow-100 text-yellow-800',
                                                        'Moderate' => 'bg-amber-100 text-amber-800',
                                                        'Severe' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $severityColor = $severityColors[$allergy->severity] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $severityColor }}">
                                                    {{ $allergy->severity }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- More Info Button --}}
                                    <div class="ml-3">
                                        <a href="{{ route('patient.allergy.info', $allergy->id) }}" 
                                           class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                            <i class="fas fa-info-circle" aria-hidden="true"></i>
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

            </div>

            {{-- Vaccination Card & Lab Test Card --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
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
                                           class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                            <i class="fas fa-info-circle" aria-hidden="true"></i>
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
                                           class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                            <i class="fas fa-info-circle" aria-hidden="true"></i>
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
    </div>

    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')
</body>

</html>
