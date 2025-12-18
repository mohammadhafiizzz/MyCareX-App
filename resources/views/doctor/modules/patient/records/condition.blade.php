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
                    <h1 class="text-3xl font-bold text-gray-900">Medical Condition Details</h1>
                    <p class="mt-2 text-sm text-gray-600">Detailed information about the medical condition</p>
                </div>

                <!-- Condition Details Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="px-6 py-4 bg-blue-50 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">{{ $condition->condition_name }}</h2>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Patient Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Patient Information</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Patient Name</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $condition->patient->full_name }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">IC Number</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $condition->patient->ic_number }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Age</label>
                                    <p class="mt-1 text-base text-gray-900">{{ $condition->patient->age }} years old</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Gender</label>
                                    <p class="mt-1 text-base text-gray-900">{{ ucfirst($condition->patient->gender) }}</p>
                                </div>
                            </div>

                            <!-- Condition Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 border-b pb-2">Condition Details</h3>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Diagnosis Date</label>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ \Carbon\Carbon::parse($condition->diagnosis_date)->format('d F Y') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Status</label>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $condition->status === 'active' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($condition->status ?? 'Unknown') }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Severity</label>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $condition->severity === 'severe' ? 'bg-red-100 text-red-800' : ($condition->severity === 'moderate' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($condition->severity ?? 'Not specified') }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Diagnosed By</label>
                                    <p class="mt-1 text-base text-gray-900">
                                        {{ $condition->doctor->full_name ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b pb-2 mb-4">Description</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 whitespace-pre-wrap">{{ $condition->description ?? 'No description provided.' }}</p>
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
