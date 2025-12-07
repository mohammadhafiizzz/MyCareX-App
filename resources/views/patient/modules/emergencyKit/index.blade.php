<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Emergency Kit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Emergency Kit
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Your digital medical ID card. This information is critical in case of emergency.
                </p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('patient.emergency-kit.create') }}" class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                    <i class="fas fa-plus mr-2"></i> Add Item
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Patient Summary Card -->
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow rounded-lg border-t-4 border-red-600">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center space-x-5">
                            <div class="flex-shrink-0">
                                @if($patient->profile_image_url)
                                    <img class="h-24 w-24 rounded-full object-cover border-2 border-gray-200" src="{{ $patient->profile_image_url }}" alt="{{ $patient->full_name }}">
                                @else
                                    <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h3>
                                <p class="text-sm text-gray-500">DOB: {{ $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : 'N/A' }} ({{ $patient->age }} yrs)</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                        Blood Type: {{ $patient->blood_type ?? 'Unknown' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t border-gray-100 pt-4">
                            <h4 class="text-sm font-medium text-gray-900">Emergency Contact</h4>
                            <div class="mt-2 flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-phone text-gray-400 mt-1"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $patient->emergency_contact_name ?? 'Not set' }}</p>
                                    <p class="text-sm text-gray-500">{{ $patient->emergency_contact_relationship ?? '' }}</p>
                                    <p class="text-sm text-blue-600 font-semibold">{{ $patient->emergency_contact_number ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emergency Items -->
            <div class="lg:col-span-2 space-y-6">
                
                @php
                    $conditions = $emergencyItems->where('record_type', 'App\Models\Condition');
                    $medications = $emergencyItems->where('record_type', 'App\Models\Medication');
                    $allergies = $emergencyItems->where('record_type', 'App\Models\Allergy');
                @endphp

                <!-- Conditions -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            <i class="fas fa-heart-pulse text-red-500 mr-2"></i> Critical Conditions
                        </h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($conditions as $item)
                            <li class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->record->condition_name }}</p>
                                    <p class="text-sm text-gray-500">Severity: {{ $item->record->severity }}</p>
                                </div>
                                <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-sm text-gray-500 italic">No conditions added.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Medications -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            <i class="fas fa-pills text-blue-500 mr-2"></i> Current Medications
                        </h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($medications as $item)
                            <li class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->record->medication_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $item->record->formatted_dosage }} - {{ $item->record->frequency }}</p>
                                </div>
                                <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-sm text-gray-500 italic">No medications added.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Allergies -->
                <div class="bg-white shadow sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> Allergies
                        </h3>
                    </div>
                    <ul role="list" class="divide-y divide-gray-200">
                        @forelse($allergies as $item)
                            <li class="px-4 py-4 sm:px-6 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $item->record->allergen }}</p>
                                    <p class="text-sm text-gray-500">Severity: {{ $item->record->severity }}</p>
                                </div>
                                <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-sm text-gray-500 italic">No allergies added.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/patient/header.js'])
</body>

</html>
