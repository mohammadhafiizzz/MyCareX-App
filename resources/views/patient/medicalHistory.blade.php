<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Banner -->
    <section class="relative h-80 bg-gray-900 overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/medical_history.png') }}" 
                alt="" 
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gray-900/40"></div>
        </div>
        
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
                    Medical History
                </h1>
                <p class="text-lg md:text-xl text-gray-200">
                    Review your past medical surgeries and hospitalisations
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="space-y-6">

            {{-- Surgeries Section --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="surgeries-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="surgeries-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-procedures text-blue-600" aria-hidden="true"></i>
                            Recent Surgeries
                        </h2>
                        <a href="{{ route('patient.surgery') }}" 
                           aria-label="View all surgeries"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($recentSurgeries as $surgery)
                        <div class="group bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 mb-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">{{ $surgery->procedure_name }}</h3>
                                            <p class="text-xs text-gray-500">
                                                Procedure Date: {{ $surgery->procedure_date ? $surgery->procedure_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        @if($surgery->surgeon_name)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Surgeon:</span> {{ $surgery->surgeon_name }}
                                            </p>
                                        @endif
                                        @if($surgery->hospital_name)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Hospital:</span> {{ $surgery->hospital_name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-4">
                                    <a href="#" 
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
                                <i class="fas fa-procedures text-blue-600 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium">No recent surgeries found.</p>
                            <p class="text-sm text-gray-500 mt-1">Your surgical history will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Hospitalisations Section --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="hospitalisations-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="hospitalisations-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-hospital text-blue-600" aria-hidden="true"></i>
                            Recent Hospitalisations
                        </h2>
                        <a href="{{ route('patient.hospitalisation') }}" 
                           aria-label="View all hospitalisations"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            See All <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($recentHospitalisations as $hospitalisation)
                        <div class="group bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 mb-4 hover:shadow-md transition-all duration-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div>
                                            <h3 class="text-base font-semibold text-gray-900">{{ $hospitalisation->reason_for_admission }}</h3>
                                            <p class="text-xs text-gray-500">
                                                Admitted: {{ $hospitalisation->admission_date ? $hospitalisation->admission_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-1">
                                        @if($hospitalisation->discharge_date)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Discharged:</span> {{ $hospitalisation->discharge_date->format('M d, Y') }}
                                            </p>
                                        @else
                                            <p class="text-sm text-amber-600">
                                                <span class="font-medium">Status:</span> Currently admitted
                                            </p>
                                        @endif
                                        @if($hospitalisation->provider_name)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-medium">Provider:</span> {{ $hospitalisation->provider_name }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- More Info Button --}}
                                <div class="ml-4">
                                    <a href="#" 
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
                                <i class="fas fa-hospital text-blue-600 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium">No recent hospitalisations found.</p>
                            <p class="text-sm text-gray-500 mt-1">Your hospitalisation history will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </section>

        </div>
    </div>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')
</body>

</html>