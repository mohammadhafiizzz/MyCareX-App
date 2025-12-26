<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medical Condition Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter]">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen bg-gray-50/50">
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('doctor.medical.records') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Medical Records
                    </a>
                </div>

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Condition Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about the medical diagnosis.</p>
                </div>

                <!-- Single Card Layout -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-notes-medical text-gray-400"></i> CONDITION INFORMATION
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Record ID: #{{ $condition->id }}</span>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <!-- Top Section: Condition & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Condition Name</label>
                                <p class="text-xl font-bold text-gray-900">{{ $condition->condition_name }}</p>
                            </div>
                            <div class="flex flex-wrap gap-6">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                        {{ $condition->status === 'active' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100' }}">
                                        {{ ucfirst($condition->status ?? 'N/A') }}
                                    </span>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Severity</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                        {{ $condition->severity === 'severe' ? 'bg-red-600 text-white border-red-700' : 
                                           ($condition->severity === 'moderate' ? 'bg-orange-500 text-white border-orange-600' : 'bg-blue-500 text-white border-blue-600') }}">
                                        {{ ucfirst($condition->severity ?? 'N/A') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Section: Grid of Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Diagnosis Date</label>
                                <p class="text-sm text-gray-900 font-medium">{{ \Carbon\Carbon::parse($condition->diagnosis_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Diagnosed By</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $condition->doctor->full_name ?? 'Unknown Doctor' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-bold">{{ $condition->doctor->specialisation ?? 'Healthcare Professional' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Patient</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-medium">{{ $condition->patient->full_name }}</p>
                                    <a href="{{ route('doctor.patient.details', $condition->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold uppercase flex items-center gap-1">
                                        View Profile <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                                    </a>
                                </div>
                                <p class="text-[10px] text-gray-500 font-medium">IC: {{ $condition->patient->ic_number }}</p>
                            </div>
                        </div>

                        <!-- Bottom Section: Description -->
                        <div class="pt-8 border-t border-gray-100">
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Description / Clinical Notes</label>
                            <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $condition->description ?? 'No additional notes provided.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

</body>

</html>
