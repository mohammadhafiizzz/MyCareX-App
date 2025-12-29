<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Medication - Doctor Portal</title>
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
                <h1 class="text-2xl font-bold text-gray-900">Add Medication</h1>
                <p class="text-sm text-gray-500 mt-1">Prescribe or record a new medication for a patient.</p>
            </div>

            <form action="{{ route('doctor.medical.records.store.medication') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Medication Details</h3>

                            <!-- Medication Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="medication_select" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Medication Name <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-2xl">
                                        <div id="medication_select_wrapper" class="relative">
                                            <select id="medication_select" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                                <option value="" selected disabled>Select a medication...</option>
                                                <option value="Metformin">Metformin</option>
                                                <option value="Atorvastatin">Atorvastatin</option>
                                                <option value="Levothyroxine">Levothyroxine</option>
                                                <option value="Lisinopril">Lisinopril</option>
                                                <option value="Amlodipine">Amlodipine</option>
                                                <option value="Paracetamol">Paracetamol</option>
                                                <option value="Ibuprofen">Ibuprofen</option>
                                                <option value="Aspirin">Aspirin</option>
                                                <option value="other" class="font-bold text-blue-600">Other...</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                        <div id="medication_manual_wrapper" class="hidden mt-2 relative">
                                            <input type="text" name="medication_name" id="medication_name" class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm pr-10" placeholder="Type medication name here..." value="{{ old('medication_name') }}">
                                            <button type="button" id="switch_to_select" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dosage -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="dosage" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Dosage (mg) <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="number" name="dosage" id="dosage" min="1" max="999999" required class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="e.g., 500" value="{{ old('dosage') }}">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="status" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Status <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="relative max-w-md">
                                        <select id="status" name="status" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                            <option value="On Hold" {{ old('status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                            <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="Discontinued" {{ old('status') == 'Discontinued' ? 'selected' : '' }}>Discontinued</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                            <i class="fas fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Frequency -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Frequency <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="flex gap-3 max-w-md">
                                        <div class="w-24">
                                            <input type="number" id="frequency_times" name="frequency_times" min="1" max="24" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="Times" value="{{ old('frequency_times') }}">
                                        </div>
                                        <div class="flex-1 relative">
                                            <select id="frequency_period" name="frequency_period" required class="block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm appearance-none">
                                                <option value="" disabled selected>Select period</option>
                                                <option value="daily" {{ old('frequency_period') == 'daily' ? 'selected' : '' }}>Daily</option>
                                                <option value="weekly" {{ old('frequency_period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                <option value="monthly" {{ old('frequency_period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                                <i class="fas fa-chevron-down text-xs"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="frequency" name="frequency" value="{{ old('frequency') }}">
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="start_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Start Date <span class="text-red-500">*</span></label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" name="start_date" id="start_date" required class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" value="{{ old('start_date', date('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- End Date -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="end_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">End Date (Optional)</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" name="end_date" id="end_date" class="max-w-md block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" value="{{ old('end_date') }}">
                                    <p class="mt-2 text-xs text-gray-500">Leave blank if ongoing</p>
                                </div>
                            </div>

                            <!-- Reason -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="reason_for_med" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Reason for Medication</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" name="reason_for_med" id="reason_for_med" class="max-w-2xl block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="e.g., Hypertension treatment" value="{{ old('reason_for_med') }}">
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="notes" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Notes / Instructions</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="notes" name="notes" rows="3" class="max-w-2xl block w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none text-sm" placeholder="e.g., Take with food...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 sm:space-y-5 pt-8">
                            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-4">Supporting Documents</h3>
                            
                            <!-- Attachment -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">Medication Image (Optional)</label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="max-w-2xl mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 transition-colors cursor-pointer" id="drop-area">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" aria-hidden="true"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="attachment" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload an image</span>
                                                    <input id="attachment" name="attachment" type="file" class="sr-only" accept=".jpg,.jpeg,.png">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 10MB</p>
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
            // Medication Name Logic
            const selectWrapper = document.getElementById('medication_select_wrapper');
            const manualWrapper = document.getElementById('medication_manual_wrapper');
            const select = document.getElementById('medication_select');
            const manualInput = document.getElementById('medication_name');
            const switchToSelectBtn = document.getElementById('switch_to_select');

            select.addEventListener('change', function() {
                if (this.value === 'other') {
                    selectWrapper.classList.add('hidden');
                    manualWrapper.classList.remove('hidden');
                    manualInput.value = '';
                    manualInput.focus();
                    select.removeAttribute('name');
                    manualInput.setAttribute('name', 'medication_name');
                } else {
                    manualInput.value = this.value;
                    select.removeAttribute('name');
                    manualInput.setAttribute('name', 'medication_name');
                }
            });

            switchToSelectBtn.addEventListener('click', function() {
                manualWrapper.classList.add('hidden');
                selectWrapper.classList.remove('hidden');
                select.value = '';
                manualInput.value = '';
            });

            // Frequency Combination Logic
            const timesInput = document.getElementById('frequency_times');
            const periodSelect = document.getElementById('frequency_period');
            const frequencyInput = document.getElementById('frequency');

            function updateFrequency() {
                const times = timesInput.value;
                const period = periodSelect.value;
                if (times && period) {
                    frequencyInput.value = `${times} times ${period}`;
                }
            }

            timesInput.addEventListener('input', updateFrequency);
            periodSelect.addEventListener('change', updateFrequency);

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
