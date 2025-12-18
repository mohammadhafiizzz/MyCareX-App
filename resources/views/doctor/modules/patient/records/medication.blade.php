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
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <div class="mb-6">
                    <a href="{{ route('doctor.medical.records') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Medical Records
                    </a>
                </div>

                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Medication Details</h1>
                    <p class="mt-2 text-sm text-gray-600">Detailed information about the medication</p>
                </div>

                <!-- Medication Details Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-green-50 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $medication->medication_name }}</h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Patient Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Patient Information</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Patient Name</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $medication->patient->full_name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">IC Number</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $medication->patient->ic_number }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Age</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $medication->patient->age }} years old</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Gender</label>
                                    <p class="mt-1 text-base text-gray-900">{{ ucfirst($medication->patient->gender) }}</p>
                                </div>
                            </div>

                            <!-- Medication Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Medication Details</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Dosage</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $medication->dosage }} mg</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Frequency</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $medication->frequency ?? 'Not specified' }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Start Date</label>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ \Carbon\Carbon::parse($medication->start_date)->format('d F Y') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">End Date</label>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ $medication->end_date ? \Carbon\Carbon::parse($medication->end_date)->format('d F Y') : 'Ongoing' }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status</label>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $medication->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($medication->status ?? 'Unknown') }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Prescribed By</label>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ $medication->doctor->full_name ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Reason for Medication -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4">Reason for Medication</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $medication->reason_for_med ?? 'No reason provided.' }}</p>
                            </div>
                        </div>

                        <!-- Notes -->
                        @if($medication->notes)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4">Additional Notes</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $medication->notes }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Medication Image -->
                        @if($medication->med_image_url)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4">Medication Image</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <img src="{{ asset('storage/' . $medication->med_image_url) }}" alt="Medication Image" class="max-w-md rounded-lg shadow-md">
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
