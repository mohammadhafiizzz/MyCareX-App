<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Emergency Kit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 mb-4">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        
        <!-- Page Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
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
                <a href="{{ route('patient.emergency-kit.create') }}" class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                    <i class="fas fa-plus"></i> Add Item
                </a>
            </div>
            @endif
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="rounded-lg bg-green-50 p-4 mb-6 border border-green-200">
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
        
        <!-- Patient Summary Card (Simple Horizontal) -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-10">
                    <!-- Profile Section -->
                    <div class="flex flex-col items-center justify-center lg:min-w-[200px]">
                        <div class="w-30 h-30 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-white shadow-sm overflow-hidden mb-6">
                            @if($patient->profile_image_url)
                                <img src="{{ asset($patient->profile_image_url) }}" alt="Profile" class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user"></i>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ $patient->full_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $patient->ic_number }}</p>
                    </div>

                    <!-- Details Section -->
                    <div class="flex-1">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->phone_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Gender</label>
                                <p class="text-sm text-gray-900 font-medium capitalize">{{ $patient->gender ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Date of Birth</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->date_of_birth ? $patient->date_of_birth->format('d M Y') : 'N/A' }} ({{ $patient->age }} years old)</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Blood Type</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->blood_type ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Height</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->height ?? 'N/A' }} cm</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Weight</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $patient->weight ?? 'N/A' }} kg</p>
                            </div>
                            <div class="col-span-1 sm:col-span-2 lg:col-span-3 border-red-100 border p-4 rounded-lg bg-red-200/20">
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Emergency Contact</label>
                                @if($patient->emergency_contact_name)
                                    <p class="text-sm text-gray-900 font-medium">{{ $patient->emergency_contact_name }} ({{ $patient->emergency_contact_relationship }})</p>
                                    <a href="tel:{{ $patient->emergency_contact_number }}" class="text-xs text-blue-600 hover:underline font-semibold">
                                        {{ $patient->emergency_contact_number }}
                                    </a>
                                @else
                                    <p class="text-sm text-gray-500 italic">Not set</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Records Section -->
        @if($isEmpty)
            <div class="text-center py-12 bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-briefcase-medical text-red-600 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Build Your Emergency Kit</h3>
                <p class="text-base text-gray-500 mb-8 max-w-md mx-auto">
                    Add critical medical information that is important during the emergency situation.
                </p>
                <a href="{{ route('patient.emergency-kit.create') }}" class="inline-flex items-center justify-center cursor-pointer px-5 py-3 gap-2 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                    <i class="fas fa-plus"></i> Add Your First Item
                </a>
            </div>
        @else
            <div class="space-y-6">
                <!-- Critical Conditions Section -->
                @if($conditions->isNotEmpty())
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="mb-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-heartbeat text-gray-400"></i> Critical Conditions
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">{{ $conditions->count() }} {{ Str::plural('condition', $conditions->count()) }} on record</p>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condition</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($conditions as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="font-semibold mr-3">{{ $loop->iteration }}.</span>{{ $item->record->condition_name }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold bg-blue-100 text-blue-600">
                                                    {{ $item->record->severity }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" onclick="openRemoveModal('{{ route('patient.emergency-kit.destroy', $item->id) }}')" class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium inline-flex items-center justify-center gap-2 bg-gradient-to-br from-red-50/90 to-red-100/90 backdrop-blur-md text-red-500 text-sm rounded-xl shadow-lg shadow-red-300/30 hover:shadow-lg hover:shadow-red-400/40 hover:from-red-100 hover:to-red-200 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-50/50 focus-visible:ring-offset-0">
                                                    <i class="fas fa-trash"></i>Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Current Medications Section -->
                @if($medications->isNotEmpty())
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="mb-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-pills text-gray-400"></i> Current Medications
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">{{ $medications->count() }} {{ Str::plural('medication', $medications->count()) }} on record</p>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medication</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage & Frequency</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($medications as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="font-semibold mr-3">{{ $loop->iteration }}.</span>{{ $item->record->medication_name }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                <span class="font-semibold text-gray-700">{{ $item->record->formatted_dosage }}</span>
                                                <span class="text-gray-300 mx-2">•</span>
                                                <span>{{ $item->record->frequency }}</span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" onclick="openRemoveModal('{{ route('patient.emergency-kit.destroy', $item->id) }}')" class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium inline-flex items-center justify-center gap-2 bg-gradient-to-br from-red-50/90 to-red-100/90 backdrop-blur-md text-red-500 text-sm rounded-xl shadow-lg shadow-red-300/30 hover:shadow-lg hover:shadow-red-400/40 hover:from-red-100 hover:to-red-200 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-50/50 focus-visible:ring-offset-0">
                                                    <i class="fas fa-trash"></i>Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Allergies Section -->
                @if($allergies->isNotEmpty())
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="mb-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-triangle-exclamation text-gray-400"></i> Known Allergies
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">{{ $allergies->count() }} {{ Str::plural('allergy', $allergies->count()) }} on record</p>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allergen</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($allergies as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="font-semibold mr-3">{{ $loop->iteration }}.</span>{{ $item->record->allergen }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-bold bg-amber-100 text-amber-600">
                                                    {{ $item->record->severity }}
                                                </span>
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" onclick="openRemoveModal('{{ route('patient.emergency-kit.destroy', $item->id) }}')" class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium inline-flex items-center justify-center gap-2 bg-gradient-to-br from-red-50/90 to-red-100/90 backdrop-blur-md text-red-500 text-sm rounded-xl shadow-lg shadow-red-300/30 hover:shadow-lg hover:shadow-red-400/40 hover:from-red-100 hover:to-red-200 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-50/50 focus-visible:ring-offset-0">
                                                    <i class="fas fa-trash"></i>Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Vaccination Section -->
                @if($immunisations->isNotEmpty())
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="mb-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-syringe text-gray-400"></i> Vaccinations
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">{{ $immunisations->count() }} {{ Str::plural('vaccination', $immunisations->count()) }} on record</p>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vaccine</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date Administered</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($immunisations as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="font-semibold mr-3">{{ $loop->iteration }}.</span>{{ $item->record->vaccine_name }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                {{ $item->record->vaccination_date->format('d M Y') }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" onclick="openRemoveModal('{{ route('patient.emergency-kit.destroy', $item->id) }}')" class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium inline-flex items-center justify-center gap-2 bg-gradient-to-br from-red-50/90 to-red-100/90 backdrop-blur-md text-red-500 text-sm rounded-xl shadow-lg shadow-red-300/30 hover:shadow-lg hover:shadow-red-400/40 hover:from-red-100 hover:to-red-200 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-50/50 focus-visible:ring-offset-0">
                                                    <i class="fas fa-trash"></i>Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endif

                <!-- Lab Test Section -->
                @if($labTests->isNotEmpty())
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="mb-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-flask text-gray-400"></i> Lab Tests
                            </h2>
                            <p class="mt-1 text-xs sm:text-sm text-gray-600">{{ $labTests->count() }} {{ Str::plural('lab test', $labTests->count()) }} on record</p>
                        </div>

                        <div class="overflow-x-auto border border-gray-200 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Name</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Test Date</th>
                                        <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($labTests as $item)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                <span class="font-semibold mr-3">{{ $loop->iteration }}.</span>{{ $item->record->test_name }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                {{ $item->record->test_date->format('d M Y') }}
                                            </td>
                                            <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="button" onclick="openRemoveModal('{{ route('patient.emergency-kit.destroy', $item->id) }}')" class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium inline-flex items-center justify-center gap-2 bg-gradient-to-br from-red-50/90 to-red-100/90 backdrop-blur-md text-red-500 text-sm rounded-xl shadow-lg shadow-red-300/30 hover:shadow-lg hover:shadow-red-400/40 hover:from-red-100 hover:to-red-200 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-50/50 focus-visible:ring-offset-0">
                                                    <i class="fas fa-trash"></i>Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                @endif
            </div>
        @endif
    </div>

    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Removal Confirmation Modal -->
    <div id="removeModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeRemoveModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Remove Item</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to remove this item from your Emergency Kit?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form id="removeForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Remove
                        </button>
                    </form>
                    <button type="button" onclick="closeRemoveModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script>
        function openRemoveModal(url) {
            const modal = document.getElementById('removeModal');
            const form = document.getElementById('removeForm');
            form.action = url;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRemoveModal() {
            const modal = document.getElementById('removeModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
    @vite(['resources/js/main/patient/header.js'])
</body>

</html>
