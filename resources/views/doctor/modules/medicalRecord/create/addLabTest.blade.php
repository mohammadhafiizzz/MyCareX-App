<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Lab Test - Doctor Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>
<body class="font-[Inter] bg-gray-50">

    @include('doctor.components.header')
    @include('doctor.components.sidebar')

    <main class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Breadcrumbs & Header -->
            <div class="mb-8">
                <nav class="flex mb-4 text-sm text-gray-500">
                    <a href="{{ route('doctor.medical.records') }}" class="hover:text-blue-600 transition-colors">Medical Records</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900 font-medium">Add Lab Test</span>
                </nav>
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Add Lab Test</h1>
                        <p class="text-sm text-gray-500 mt-1">Record a new laboratory test result for a patient.</p>
                    </div>
                    <a href="{{ route('doctor.medical.records') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Records
                    </a>
                </div>
            </div>

            <div class="max-w-4xl">
                <form action="{{ route('doctor.medical.records.store.lab') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-3"></i>
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 text-sm">
                            <div class="flex items-center mb-2 font-semibold">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Please correct the following errors:
                            </div>
                            <ul class="list-disc list-inside space-y-1 ml-6">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Section 1: Patient Information -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900">Patient Information</h2>
                            </div>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="patient_id" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Select Patient <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <select name="patient_id" id="patient_id" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors">
                                        <option value="" disabled selected>Select a patient...</option>
                                        @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                                {{ $patient->full_name }} ({{ $patient->ic_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Lab Test Details -->
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50 border-t">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                                    <i class="fas fa-flask"></i>
                                </div>
                                <h2 class="text-lg font-semibold text-gray-900">Lab Test Details</h2>
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <!-- Test Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="test_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Test Name <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div id="test_select_wrapper">
                                        <select id="test_select" name="test_name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors bg-white">
                                            <option value="" disabled selected>Select a lab test</option>
                                            @foreach(['Complete Blood Count (CBC)', 'Lipid Profile', 'Blood Glucose (Fasting)', 'HbA1c', 'Liver Function Test (LFT)', 'Kidney Function Test (KFT)', 'Thyroid Function Test (TFT)', 'Urinalysis', 'Electrolyte Panel', 'Vitamin D'] as $test)
                                                <option value="{{ $test }}" {{ old('test_name') == $test ? 'selected' : '' }}>{{ $test }}</option>
                                            @endforeach
                                            <option value="other">Other...</option>
                                        </select>
                                    </div>
                                    <div id="test_manual_wrapper" class="hidden mt-2 relative">
                                        <input type="text" id="test_name_manual" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors pr-10" placeholder="Type test name here...">
                                        <button type="button" id="switch_to_select" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Test Category -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="test_category" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Test Category <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div id="category_select_wrapper">
                                        <select id="category_select" name="test_category" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors bg-white">
                                            <option value="" disabled selected>Select a category</option>
                                            @foreach(['Hematology', 'Biochemistry', 'Microbiology', 'Immunology', 'Pathology', 'Radiology', 'Cardiology', 'Endocrinology', 'Genetics'] as $category)
                                                <option value="{{ $category }}" {{ old('test_category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                            @endforeach
                                            <option value="other_category">Other...</option>
                                        </select>
                                    </div>
                                    <div id="category_manual_wrapper" class="hidden mt-2 relative">
                                        <input type="text" id="test_category_manual" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors pr-10" placeholder="Type category here...">
                                        <button type="button" id="switch_to_select_category" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Test Date -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="test_date" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Test Date <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="date" name="test_date" id="test_date" required class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" value="{{ old('test_date', date('Y-m-d')) }}">
                                </div>
                            </div>

                            <!-- Facility Name -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="facility_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Facility Name
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <input type="text" name="facility_name" id="facility_name" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" placeholder="e.g., City Lab" value="{{ old('facility_name') }}">
                                </div>
                            </div>

                            <!-- Attachment -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Test Results Attachment <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition-colors cursor-pointer" id="drop-area">
                                        <div class="space-y-1 text-center">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" aria-hidden="true"></i>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="file_attachment" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Upload a file</span>
                                                    <input id="file_attachment" name="file_attachment" type="file" class="sr-only" accept=".pdf,.png,.jpg,.jpeg" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, PNG, JPG, JPEG up to 10MB</p>
                                            <p id="file-name" class="text-sm text-gray-700 mt-2 font-medium hidden"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
                                <label for="notes" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Notes / Additional Info
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    <textarea id="notes" name="notes" rows="4" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm transition-colors" placeholder="e.g., Critical results marked...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="p-6 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                            <a href="{{ route('doctor.medical.records') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors shadow-sm">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors shadow-sm flex items-center">
                                <i class="fas fa-save mr-2"></i> Save Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('doctor.components.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Test Name Logic
            const testSelect = document.getElementById('test_select');
            const testInputManual = document.getElementById('test_name_manual');
            const testWrapper = document.getElementById('test_select_wrapper');
            const testManual = document.getElementById('test_manual_wrapper');
            const switchTest = document.getElementById('switch_to_select');

            testSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    testWrapper.classList.add('hidden');
                    testManual.classList.remove('hidden');
                    testInputManual.focus();
                    
                    // Switch name attribute to manual input
                    testSelect.removeAttribute('name');
                    testInputManual.setAttribute('name', 'test_name');
                }
            });

            switchTest.addEventListener('click', function() {
                testManual.classList.add('hidden');
                testWrapper.classList.remove('hidden');
                testSelect.value = '';
                
                // Switch name attribute back to select
                testInputManual.removeAttribute('name');
                testSelect.setAttribute('name', 'test_name');
            });

            // Category Logic
            const catSelect = document.getElementById('category_select');
            const catInputManual = document.getElementById('test_category_manual');
            const catWrapper = document.getElementById('category_select_wrapper');
            const catManual = document.getElementById('category_manual_wrapper');
            const switchCat = document.getElementById('switch_to_select_category');

            catSelect.addEventListener('change', function() {
                if (this.value === 'other_category') {
                    catWrapper.classList.add('hidden');
                    catManual.classList.remove('hidden');
                    catInputManual.focus();
                    
                    // Switch name attribute to manual input
                    catSelect.removeAttribute('name');
                    catInputManual.setAttribute('name', 'test_category');
                }
            });

            switchCat.addEventListener('click', function() {
                catManual.classList.add('hidden');
                catWrapper.classList.remove('hidden');
                catSelect.value = '';
                
                // Switch name attribute back to select
                catInputManual.removeAttribute('name');
                catSelect.setAttribute('name', 'test_category');
            });

            // File Upload Logic
            const fileInput = document.getElementById('file_attachment');
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

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    dropArea.classList.add('bg-blue-50', 'border-blue-300');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, () => {
                    if (!fileInput.files.length) {
                        dropArea.classList.remove('bg-blue-50', 'border-blue-300');
                    }
                }, false);
            });

            dropArea.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                // Trigger change event
                const event = new Event('change');
                fileInput.dispatchEvent(event);
            }, false);
        });
    </script>
</body>
</html>
