<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Allergy - Doctor Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>
<body class="font-[Inter] bg-gray-50">

    @include('doctor.components.header')
    @include('doctor.components.sidebar')

    <main class="lg:ml-68 mt-20 min-h-screen transition-all duration-300" id="mainContent">
        <div class="bg-gray-50 min-h-screen py-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('doctor.medical.records') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1 mb-4">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Medical Records
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Add Allergy</h1>
                <p class="text-sm text-gray-500 mt-1">Record a new patient allergy.</p>
            </div>

            <form action="{{ route('doctor.medical.records.store.allergy') }}" method="POST" class="space-y-6">
                @csrf
                
                @if(session('error'))
                    <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <!-- Section: Patient Selection -->
                    <div class="p-6 md:p-8 space-y-8">
                        <div class="space-y-6 sm:space-y-5">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Patient Information</h3>
                            
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Select Patient <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select name="patient_id" id="patient_id" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="" disabled selected>Select a patient...</option>
                                            @foreach($patients as $patient)
                                                <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                    {{ $patient->full_name }} ({{ $patient->ic_number }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Only patients who have granted you access are listed.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pt-8">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Allergy Details</h3>

                            <!-- Allergen -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="allergen_select" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Allergen <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-2xl">
                                        <div id="allergen_select_wrapper" class="relative">
                                            <select id="allergen_select" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                                <option value="" selected disabled>Select an allergen...</option>
                                                <option value="Peanuts">Peanuts</option>
                                                <option value="Tree Nuts">Tree Nuts</option>
                                                <option value="Milk">Milk</option>
                                                <option value="Eggs">Eggs</option>
                                                <option value="Wheat">Wheat</option>
                                                <option value="Soy">Soy</option>
                                                <option value="Fish">Fish</option>
                                                <option value="Shellfish">Shellfish</option>
                                                <option value="Penicillin">Penicillin</option>
                                                <option value="Sulfa Drugs">Sulfa Drugs</option>
                                                <option value="Aspirin">Aspirin</option>
                                                <option value="NSAIDs">NSAIDs</option>
                                                <option value="Pollen">Pollen</option>
                                                <option value="Dust Mites">Dust Mites</option>
                                                <option value="Mold">Mold</option>
                                                <option value="Pet Dander">Pet Dander</option>
                                                <option value="Latex">Latex</option>
                                                <option value="Insect Stings">Insect Stings</option>
                                                <option value="manual_entry" class="font-bold text-blue-600">Other...</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <div id="allergen_manual_wrapper" class="hidden mt-2 relative">
                                            <input type="text" name="allergen" id="allergen" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm pr-10" placeholder="Type allergen name here..." value="{{ old('allergen') }}">
                                            <button type="button" id="switch_to_select_allergen" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Allergy Type -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="allergy_type_select" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Allergy Type <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-2xl">
                                        <div id="allergy_type_select_wrapper" class="relative">
                                            <select id="allergy_type_select" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                                <option value="" selected disabled>Select allergy type...</option>
                                                <option value="Food">Food</option>
                                                <option value="Medication">Medication</option>
                                                <option value="Environmental">Environmental</option>
                                                <option value="Insect">Insect</option>
                                                <option value="Latex">Latex</option>
                                                <option value="manual_entry" class="font-bold text-blue-600">Other...</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <div id="allergy_type_manual_wrapper" class="hidden mt-2 relative">
                                            <input type="text" name="allergy_type" id="allergy_type" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm pr-10" placeholder="Type allergy type here..." value="{{ old('allergy_type') }}">
                                            <button type="button" id="switch_to_select_type" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Reaction Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="reaction_desc" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Reaction Description</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="reaction_desc" name="reaction_desc" rows="3" class="max-w-2xl block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="e.g., Hives, swelling, difficulty breathing...">{{ old('reaction_desc') }}</textarea>
                                </div>
                            </div>

                            <!-- First Observed Date -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="first_observed_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">First Observed Date <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" name="first_observed_date" id="first_observed_date" required class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" value="{{ old('first_observed_date', date('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- Severity -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="severity" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Severity <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select id="severity" name="severity" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="" disabled selected>Select severity</option>
                                            <option value="Mild" {{ old('severity') == 'Mild' ? 'selected' : '' }}>Mild</option>
                                            <option value="Moderate" {{ old('severity') == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                            <option value="Severe" {{ old('severity') == 'Severe' ? 'selected' : '' }}>Severe</option>
                                            <option value="Life-threatening" {{ old('severity') == 'Life-threatening' ? 'selected' : '' }}>Life-threatening</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Status <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select id="status" name="status" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="Suspected" {{ old('status') == 'Suspected' ? 'selected' : '' }}>Suspected</option>
                                            <option value="Resolved" {{ old('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('doctor.medical.records') }}" class="px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-all duration-200">Cancel</a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-700 transition-all duration-200">
                            <span>Save Record</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    @include('doctor.components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Allergen Logic
            const allergenSelect = document.getElementById('allergen_select');
            const allergenInput = document.getElementById('allergen');
            const allergenSelectWrapper = document.getElementById('allergen_select_wrapper');
            const allergenManualWrapper = document.getElementById('allergen_manual_wrapper');
            const switchAllergen = document.getElementById('switch_to_select_allergen');

            allergenSelect.addEventListener('change', function() {
                if (this.value === 'manual_entry') {
                    allergenSelectWrapper.classList.add('hidden');
                    allergenManualWrapper.classList.remove('hidden');
                    allergenInput.value = '';
                    allergenInput.focus();
                    allergenSelect.removeAttribute('name');
                    allergenInput.setAttribute('name', 'allergen');
                } else {
                    allergenInput.value = this.value;
                    allergenSelect.removeAttribute('name');
                    allergenInput.setAttribute('name', 'allergen');
                }
            });

            switchAllergen.addEventListener('click', function() {
                allergenManualWrapper.classList.add('hidden');
                allergenSelectWrapper.classList.remove('hidden');
                allergenSelect.value = '';
                allergenInput.value = '';
            });

            // Allergy Type Logic
            const typeSelect = document.getElementById('allergy_type_select');
            const typeInput = document.getElementById('allergy_type');
            const typeSelectWrapper = document.getElementById('allergy_type_select_wrapper');
            const typeManualWrapper = document.getElementById('allergy_type_manual_wrapper');
            const switchType = document.getElementById('switch_to_select_type');

            typeSelect.addEventListener('change', function() {
                if (this.value === 'manual_entry') {
                    typeSelectWrapper.classList.add('hidden');
                    typeManualWrapper.classList.remove('hidden');
                    typeInput.value = '';
                    typeInput.focus();
                    typeSelect.removeAttribute('name');
                    typeInput.setAttribute('name', 'allergy_type');
                } else {
                    typeInput.value = this.value;
                    typeSelect.removeAttribute('name');
                    typeInput.setAttribute('name', 'allergy_type');
                }
            });

            switchType.addEventListener('click', function() {
                typeManualWrapper.classList.add('hidden');
                typeSelectWrapper.classList.remove('hidden');
                typeSelect.value = '';
                typeInput.value = '';
            });
        });
    </script>
</body>
</html>
