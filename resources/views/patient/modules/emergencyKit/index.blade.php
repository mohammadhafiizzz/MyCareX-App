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

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 mb-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Emergency Kit
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Your digital medical ID card. Critical information for emergency responders.
                </p>
            </div>
            @if(!$isEmpty)
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="{{ route('patient.emergency-kit.create') }}" class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i> Add Item
                </a>
            </div>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 mb-6 border border-green-200 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Patient Summary Card -->
            <div class="lg:col-span-1">
                <div class="rounded-xl border border-gray-200 shadow-lg overflow-hidden sticky top-6">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            Medical ID
                        </h3>
                    </div>
                    <div class="px-6 py-6">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="relative mb-4">
                                @if($patient->profile_image_url)
                                    <img class="h-28 w-28 rounded-full object-cover border-4 border-white shadow-lg" src="{{ $patient->profile_image_url }}" alt="{{ $patient->full_name }}">
                                @else
                                    <div class="h-28 w-28 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center border-4 border-white shadow-lg">
                                        <i class="fas fa-user text-gray-500 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $patient->date_of_birth ? $patient->date_of_birth->format('M d, Y') : 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-500">({{ $patient->age }} years old)</p>
                        </div>
                        
                        <!-- Blood Type Badge -->
                        <div class="flex justify-center mb-6">
                            <div class="inline-flex items-center bg-red-100 border-2 border-red-300 rounded-full px-4 py-2">
                                <i class="fas fa-droplet text-red-600 mr-2"></i>
                                <span class="text-sm font-bold text-red-900">{{ $patient->blood_type ?? 'Unknown' }}</span>
                            </div>
                        </div>
                        
                        <!-- Divider -->
                        <div class="border-t border-gray-200 my-6"></div>
                        
                        <!-- Emergency Contact -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center">Emergency Contact: </h4>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                @if($patient->emergency_contact_name)
                                    <p class="text-sm font-semibold text-gray-900">{{ $patient->emergency_contact_name }}</p>
                                    @if($patient->emergency_contact_relationship)
                                        <p class="text-xs text-gray-500 mt-1">{{ $patient->emergency_contact_relationship }}</p>
                                    @endif
                                    @if($patient->emergency_contact_number)
                                        <a href="tel:{{ $patient->emergency_contact_number }}" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 mt-2">
                                            <i class="fas fa-phone text-red-500 mr-2"></i> {{ $patient->emergency_contact_number }}
                                        </a>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-500 italic">No emergency contact set</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            @if($isEmpty)
                <div class="text-center lg:col-span-2 py-12">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 mt-10">
                        <i class="fas fa-kit-medical text-red-600 text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Build Your Emergency Kit</h3>
                    <p class="text-base text-gray-500 mb-8 max-w-md mx-auto">
                        Add critical medical information that emergency responders need to know.
                    </p>
                    <a href="{{ route('patient.emergency-kit.create') }}" class="inline-flex items-center cursor-pointer gap-2 px-4 py-3 bg-gradient-to-br from-red-500/90 to-red-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:from-red-500 hover:to-red-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                        <i class="fas fa-plus mr-2"></i> Add Your First Item
                    </a>
                </div>
            @else
                <!-- Emergency Items -->
                <div class="lg:col-span-2 space-y-6">
                
                    <!-- Critical Conditions Section -->
                    @if($conditions->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-blue-100">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-heart-pulse mr-2"></i> Critical Conditions
                            </h3>
                            <p class="text-blue-100 text-sm mt-1">{{ $conditions->count() }} {{ Str::plural('condition', $conditions->count()) }} on record</p>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($conditions as $item)
                                <li class="px-6 py-5 hover:bg-blue-50 transition-colors duration-150">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                    <i class="fas fa-heart-pulse text-blue-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 leading-tight">{{ $item->record->condition_name }}</p>
                                                    <div class="mt-2 flex items-center">
                                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                                            @if($item->record->severity === 'Mild') bg-yellow-100 text-yellow-800
                                                            @elseif($item->record->severity === 'Moderate') bg-orange-100 text-orange-800
                                                            @elseif($item->record->severity === 'Severe') bg-red-100 text-red-800
                                                            @else bg-gray-100 text-gray-800
                                                            @endif">
                                                            <i class="fas fa-circle text-xs mr-1"></i> {{ $item->record->severity }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this condition from your Emergency Kit?');" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors duration-150">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Current Medications Section -->
                    @if($medications->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-green-100">
                        <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-pills mr-2"></i> Current Medications
                            </h3>
                            <p class="text-green-100 text-sm mt-1">{{ $medications->count() }} active {{ Str::plural('medication', $medications->count()) }}</p>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($medications as $item)
                                <li class="px-6 py-5 hover:bg-green-50 transition-colors duration-150">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                    <i class="fas fa-pills text-green-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 leading-tight">{{ $item->record->medication_name }}</p>
                                                    <p class="text-sm text-gray-600 mt-1">
                                                        <span class="font-medium">{{ $item->record->formatted_dosage }}</span>
                                                        <span class="text-gray-400 mx-2">•</span>
                                                        <span>{{ $item->record->frequency }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this medication from your Emergency Kit?');" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors duration-150">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <!-- Allergies Section -->
                    @if($allergies->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-orange-100">
                        <div class="bg-gradient-to-r from-orange-600 to-orange-500 px-6 py-4">
                            <h3 class="text-lg font-bold text-white flex items-center">
                                <i class="fas fa-triangle-exclamation mr-2"></i> Known Allergies
                            </h3>
                            <p class="text-orange-100 text-sm mt-1">{{ $allergies->count() }} documented {{ Str::plural('allergy', $allergies->count()) }}</p>
                        </div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($allergies as $item)
                                <li class="px-6 py-5 hover:bg-orange-50 transition-colors duration-150">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                                    <i class="fas fa-triangle-exclamation text-orange-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-base font-semibold text-gray-900 leading-tight">{{ $item->record->allergen }}</p>
                                                    <div class="mt-2 flex items-center">
                                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium
                                                            @if($item->record->severity === 'Mild') bg-yellow-100 text-yellow-800
                                                            @elseif($item->record->severity === 'Moderate') bg-orange-100 text-orange-800
                                                            @elseif($item->record->severity === 'Severe') bg-red-100 text-red-800
                                                            @else bg-gray-100 text-gray-800
                                                            @endif">
                                                            <i class="fas fa-circle text-xs mr-1"></i> {{ $item->record->severity }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('patient.emergency-kit.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this allergy from your Emergency Kit?');" class="ml-4">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors duration-150">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/patient/header.js'])
</body>

</html>
