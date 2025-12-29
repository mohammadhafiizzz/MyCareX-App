<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Medical Condition</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Add Medical Condition</h1>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to create a new medical condition record for a patient.</p>
            </div>

            <form action="{{ route('doctor.medical.records.store.condition') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Condition Details</h3>

                            <!-- Condition Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="condition_select" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Condition Name <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-2xl">
                                        <div id="condition_select_wrapper" class="relative">
                                            <select id="condition_select" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                                <option value="" selected disabled>Select a condition...</option>
                                                <option value="Hypertension">Hypertension (High Blood Pressure)</option>
                                                <option value="Type 2 Diabetes Mellitus">Type 2 Diabetes</option>
                                                <option value="Hyperlipidemia">Hyperlipidemia (High Cholesterol)</option>
                                                <option value="Asthma">Asthma</option>
                                                <option value="Osteoarthritis">Osteoarthritis</option>
                                                <option value="Gastroesophageal Reflux Disease (GERD)">GERD (Acid Reflux)</option>
                                                <option value="Upper Respiratory Infection">Upper Respiratory Infection</option>
                                                <option value="Influenza">Influenza</option>
                                                <option value="COVID-19">COVID-19</option>
                                                <option value="Urinary Tract Infection">Urinary Tract Infection</option>
                                                <option value="Allergic Rhinitis">Allergic Rhinitis</option>
                                                <option value="Migraine">Migraine</option>
                                                <option value="manual_entry" class="font-bold text-blue-600">Other...</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <div id="condition_manual_wrapper" class="hidden mt-2 relative">
                                            <input type="text" name="condition_name" id="condition_name" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm pr-10" placeholder="Type condition name here..." value="{{ old('condition_name') }}">
                                            <button type="button" id="switch_to_select" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="description" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Description / Notes</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="description" name="description" rows="4" class="max-w-2xl block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="e.g., Clinical notes, symptoms, management plan...">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <!-- Diagnosis Date -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="diagnosis_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Diagnosis Date</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" name="diagnosis_date" id="diagnosis_date" value="{{ old('diagnosis_date', date('Y-m-d')) }}" class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm">
                                </div>
                            </div>

                            <!-- Severity -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="severity" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Severity <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select id="severity" name="severity" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="" disabled {{ old('severity') ? '' : 'selected' }}>Select severity</option>
                                            <option value="Mild" {{ old('severity') == 'Mild' ? 'selected' : '' }}>Mild</option>
                                            <option value="Moderate" {{ old('severity') == 'Moderate' ? 'selected' : '' }}>Moderate</option>
                                            <option value="Severe" {{ old('severity') == 'Severe' ? 'selected' : '' }}>Severe</option>
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
                                            <option value="Chronic" {{ old('status') == 'Chronic' ? 'selected' : '' }}>Chronic</option>
                                            <option value="Resolved" {{ old('status') == 'Resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pt-8">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Supporting Documents</h3>
                            
                            <!-- Attachment -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Attachment (Optional)</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-2xl mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors cursor-pointer" id="drop-area">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" aria-hidden="true"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="attachment" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload a file</span>
                                                    <input id="attachment" name="attachment" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, PNG, JPG, JPEG up to 10MB</p>
                                            <p id="file-name" class="text-sm text-gray-700 mt-2 font-medium hidden"></p>
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
            // Condition Select Logic
            const selectWrapper = document.getElementById('condition_select_wrapper');
            const manualWrapper = document.getElementById('condition_manual_wrapper');
            const select = document.getElementById('condition_select');
            const manualInput = document.getElementById('condition_name');
            const switchToSelectBtn = document.getElementById('switch_to_select');

            // Handle manual entry selection
            select.addEventListener('change', function() {
                if (this.value === 'manual_entry') {
                    selectWrapper.classList.add('hidden');
                    manualWrapper.classList.remove('hidden');
                    manualInput.value = '';
                    manualInput.focus();
                    // Keep the name attribute on the input
                    select.removeAttribute('name');
                    manualInput.setAttribute('name', 'condition_name');
                } else {
                    manualInput.value = this.value;
                    // Ensure name attribute is on input (or handle in backend by checking both?)
                    // For simplicity, we'll keep the value in the hidden input or just use one name
                    // But here we have two fields swapping.
                    // Better approach: have a hidden input that holds the final value, 
                    // or toggle name attribute.
                    
                    // Simple approach: Set value to manual input (which has name)
                    // But manual input is hidden. If we submit, we need the value.
                    // Let's use the input 'condition_name' as the source of truth if visible
                    // If select is visible, we need to copy value to a hidden field or rename?
                    
                    // Let's try: 'condition_name' is the main input.
                    // If select is used, we copy value to a hidden input or just use select's name?
                    // Controller expects 'condition_name'.
                    
                    // Strategy:
                    // 1. Initially: select has NO name. manualInput has name="condition_name".
                    //    Wait, if select has no name, it won't submit.
                    //    If manualInput is hidden, it will submit its value (empty?).
                    
                    // Let's fix:
                    // Remove name from select initially.
                    // Add hidden input with name="condition_name".
                    // On select change -> update hidden input.
                    // On manual input change -> update hidden input?
                    
                    // Actually, simpler:
                    // Toggle name attribute.
                    select.removeAttribute('name');
                    manualInput.setAttribute('name', 'condition_name');
                    manualInput.value = this.value;
                }
            });

            switchToSelectBtn.addEventListener('click', function() {
                manualWrapper.classList.add('hidden');
                selectWrapper.classList.remove('hidden');
                select.value = ''; // Reset select
                manualInput.value = '';
                // Logic: if user selects from dropdown later, it fills manualInput?
                // The previous logic: `manualInput.value = this.value` assumes manualInput is the one being submitted.
                // Let's stick to that: manualInput is ALWAYS the field being submitted (name="condition_name").
                // But it's hidden when select is shown? No, `type="hidden"`?
                // No, the UI swaps them.
                
                // Correct Logic:
                // When Select is visible:
                //   Select has NO name.
                //   We need a hidden input with name="condition_name" that gets updated by select?
                //   OR we use JS to set the value of the visible input.
                
                // Let's go with: `manualInput` is the real input.
                // When Select is visible, `manualInput` is hidden (class="hidden").
                // When Select changes, update `manualInput.value`.
                // When "Other" is picked, hide Select, show `manualInput` (remove class "hidden").
                // `manualInput` always has `name="condition_name"`.
            });

            // Initial setup for select logic
            // Ensure select updates the input value on change (for non-manual options)
             select.addEventListener('change', function() {
                if (this.value !== 'manual_entry') {
                    manualInput.value = this.value;
                }
             });

            // File Upload Preview
            const fileInput = document.getElementById('attachment');
            const fileNameDisplay = document.getElementById('file-name');
            const dropArea = document.getElementById('drop-area');

            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    fileNameDisplay.textContent = 'Selected file: ' + this.files[0].name;
                    fileNameDisplay.classList.remove('hidden');
                    dropArea.classList.add('bg-blue-50', 'border-blue-300');
                } else {
                    fileNameDisplay.classList.add('hidden');
                    dropArea.classList.remove('bg-blue-50', 'border-blue-300');
                }
            });

            // Drag and drop support
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.classList.add('bg-blue-50', 'border-blue-400');
            }

            function unhighlight(e) {
                dropArea.classList.remove('bg-blue-50', 'border-blue-400');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                if (files.length > 0) {
                    fileNameDisplay.textContent = 'Selected file: ' + files[0].name;
                    fileNameDisplay.classList.remove('hidden');
                }
            }
        });
    </script>
</body>
</html>
