<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medication Details</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Medication Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about the prescribed medication.</p>
                </div>

                <!-- Single Card Layout -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-pills text-gray-400"></i> MEDICATION INFORMATION
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Record ID: #{{ $medication->id }}</span>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <!-- Top Section: Medication & Status -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Medication Name</label>
                                <p class="text-xl font-bold text-gray-900">{{ $medication->medication_name }}</p>
                            </div>
                            <div class="flex flex-wrap gap-6">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Status</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border 
                                        {{ $medication->status === 'active' ? 'bg-green-50 text-green-600 border-green-100' : 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                        {{ ucfirst($medication->status ?? 'N/A') }}
                                    </span>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Dosage</label>
                                    <p class="text-sm text-gray-900 font-bold">{{ $medication->dosage }} mg</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Frequency</label>
                                    <p class="text-sm text-gray-900 font-bold">{{ $medication->frequency ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Section: Grid of Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Duration</label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($medication->start_date)->format('d M Y') }} - 
                                    {{ $medication->end_date ? \Carbon\Carbon::parse($medication->end_date)->format('d M Y') : 'Ongoing' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Prescribed By</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $medication->doctor->full_name ?? 'Unknown Doctor' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-bold">{{ $medication->doctor->specialisation ?? 'Healthcare Professional' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Patient</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-medium">{{ $medication->patient->full_name }}</p>
                                    <a href="{{ route('doctor.patient.details', $medication->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold uppercase flex items-center gap-1">
                                        View Profile <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                                    </a>
                                </div>
                                <p class="text-[10px] text-gray-500 font-medium">IC: {{ $medication->patient->ic_number }}</p>
                            </div>
                        </div>

                        <!-- Bottom Section: Reason & Notes -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Reason for Medication</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $medication->reason_for_med ?? 'No reason provided.' }}</p>
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Additional Notes</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $medication->notes ?? 'No additional notes provided.' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Medication Image -->
                        @if($medication->med_image_url)
                        <div class="mt-8 pt-8 border-t border-gray-100">
                            <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Medication Image</label>
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 inline-block">
                                <img src="{{ asset('storage/' . $medication->med_image_url) }}" alt="Medication Image" class="max-w-full h-auto rounded-lg shadow-sm max-h-64">
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

</body>

</html>
