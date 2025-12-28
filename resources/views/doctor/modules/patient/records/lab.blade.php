<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Lab Test Details</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Lab Test Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about the patient's laboratory test.</p>
                </div>

                <!-- Single Card Layout -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-flask text-gray-400"></i> LAB TEST INFORMATION
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Record ID: #{{ $lab->id }}</span>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <!-- Top Section: Test Name & Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Test Name</label>
                                <p class="text-xl font-bold text-gray-900">{{ $lab->test_name }}</p>
                            </div>
                            <div class="flex flex-wrap gap-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Test Date</label>
                                    <p class="text-sm text-gray-900 font-bold">{{ \Carbon\Carbon::parse($lab->test_date)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Category</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border bg-orange-50 text-orange-600 border-orange-100">
                                        {{ ucfirst($lab->test_category ?? 'General') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Section: Grid of Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Facility Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $lab->facility_name ?? 'Unknown Facility' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Ordered By</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $lab->doctor->full_name ?? 'Unknown Doctor' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-bold">{{ $lab->doctor->specialisation ?? 'Healthcare Professional' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Patient</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-medium">{{ $lab->patient->full_name }}</p>
                                    <a href="{{ route('doctor.patient.details', $lab->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold uppercase flex items-center gap-1">
                                        View Profile <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                                    </a>
                                </div>
                                <p class="text-[10px] text-gray-500 font-medium">IC: {{ $lab->patient->ic_number }}</p>
                            </div>
                        </div>

                        <!-- Patient Info Section (Alternative style for variety but keeping it consistent) -->
                        <div class="mb-10 p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                    {{ substr($lab->patient->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $lab->patient->full_name }}</p>
                                    <p class="text-[10px] text-gray-500">IC: {{ $lab->patient->ic_number }} • {{ $lab->patient->age }} yrs • {{ ucfirst($lab->patient->gender) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('doctor.patient.details', $lab->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold uppercase flex items-center gap-1">
                                View Profile <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                            </a>
                        </div>

                        <!-- Bottom Section: Notes & Results -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Additional Notes</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $lab->notes ?? 'No additional notes provided.' }}</p>
                                </div>
                            </div>
                            @if($lab->file_attachment_url)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Test Results</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-file-medical text-blue-500 text-2xl"></i>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">Lab Report Document</p>
                                            <p class="text-[10px] text-gray-500">PDF / Image Format</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $lab->file_attachment_url) }}" target="_blank" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all">
                                        View Results
                                    </a>
                                </div>
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

</body>

</html>
