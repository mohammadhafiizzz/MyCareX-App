<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Immunisation Details</title>
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
                    <h1 class="text-2xl font-bold text-gray-900">Immunisation Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about the patient's vaccination.</p>
                </div>

                <!-- Single Card Layout -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <i class="fa-solid fa-syringe text-gray-400"></i> IMMUNISATION INFORMATION
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase">Record ID: #{{ $immunisation->id }}</span>
                    </div>
                    
                    <div class="p-6 sm:p-8">
                        <!-- Top Section: Vaccine & Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Vaccine Name</label>
                                <p class="text-xl font-bold text-gray-900">{{ $immunisation->vaccine_name }}</p>
                            </div>
                            <div class="flex flex-wrap gap-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Vaccination Date</label>
                                    <p class="text-sm text-gray-900 font-bold">{{ \Carbon\Carbon::parse($immunisation->vaccination_date)->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Lot Number</label>
                                    <p class="text-sm text-gray-900 font-bold">{{ $immunisation->vaccine_lot_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Middle Section: Grid of Info -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Dose Details</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $immunisation->dose_details ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Administered By</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $immunisation->administered_by ?? 'Unknown' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Recorded By</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $immunisation->doctor->full_name ?? 'Unknown Doctor' }}</p>
                                <p class="text-[10px] text-gray-500 uppercase font-bold">{{ $immunisation->doctor->specialisation ?? 'Healthcare Professional' }}</p>
                            </div>
                        </div>

                        <!-- Patient Info Section -->
                        <div class="mb-10 p-4 bg-blue-50/50 rounded-xl border border-blue-100 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                    {{ substr($immunisation->patient->full_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $immunisation->patient->full_name }}</p>
                                    <p class="text-[10px] text-gray-500">IC: {{ $immunisation->patient->ic_number }} • {{ $immunisation->patient->age }} yrs • {{ ucfirst($immunisation->patient->gender) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('doctor.patient.details', $immunisation->patient->id) }}" class="text-blue-600 hover:text-blue-800 text-[10px] font-bold uppercase flex items-center gap-1">
                                View Profile <i class="fa-solid fa-arrow-up-right-from-square text-[8px]"></i>
                            </a>
                        </div>

                        <!-- Bottom Section: Notes & Certificate -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 pt-8 border-t border-gray-100">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Additional Notes</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $immunisation->notes ?? 'No additional notes provided.' }}</p>
                                </div>
                            </div>
                            @if($immunisation->certificate_url)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-3">Vaccination Certificate</label>
                                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i class="fa-solid fa-file-pdf text-red-500 text-2xl"></i>
                                        <div>
                                            <p class="text-xs font-bold text-gray-900">Certificate Document</p>
                                            <p class="text-[10px] text-gray-500">PDF Format</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $immunisation->certificate_url) }}" target="_blank" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 hover:bg-gray-50 transition-all">
                                        View Document
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
