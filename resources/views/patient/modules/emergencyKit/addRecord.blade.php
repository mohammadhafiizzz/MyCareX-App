<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Add Record</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
        <a href="{{ route('patient.emergency-kit.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 mb-6 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Back to Emergency Kit
        </a>

        <div class="mb-6">
            <h2 class="text-3xl font-bold text-gray-900 sm:tracking-tight">
                Add to Emergency Kit
            </h2>
            <p class="mt-2 text-sm text-gray-500">
                Select a medical record to include in your digital medical ID.
            </p>
        </div>

        @if($errors->any())
            <div class="rounded-xl bg-red-50 p-4 mb-8 border border-red-100 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Please correct the following errors:</h3>
                        <div class="mt-1 text-sm text-red-700">
                            <ul role="list" class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-8 sm:p-10">
                <form action="{{ route('patient.emergency-kit.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-10">
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="flex items-center mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-sm font-bold mr-3">1</span>
                                <label for="type" class="text-lg font-semibold text-gray-900">Select Record Type</label>
                            </div>
                            <div class="relative group">
                                <select id="type" name="type" class="block w-full rounded-xl border border-gray-200 py-4 pl-5 pr-12 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-all shadow-sm appearance-none bg-gray-50 hover:bg-gray-100">
                                    <option value="" disabled selected>Choose a category...</option>
                                    <option value="condition">Medical Condition</option>
                                    <option value="medication">Medication</option>
                                    <option value="allergy">Allergy</option>
                                    <option value="vaccination">Vaccination</option>
                                    <option value="lab">Lab Test</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                This will filter your existing medical records.
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div id="record-container" class="hidden transition-all duration-500">
                            <div class="flex items-center mb-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-sm font-bold mr-3">2</span>
                                <label for="record_id" class="text-lg font-semibold text-gray-900">Select Specific Record</label>
                            </div>
                            <div class="relative group">
                                <select id="record_id" name="record_id" class="block w-full rounded-xl border border-gray-200 py-4 pl-5 pr-12 text-gray-900 focus:border-blue-500 focus:ring-blue-500 sm:text-sm transition-all shadow-sm appearance-none bg-gray-50 hover:bg-gray-100">
                                    <option value="" disabled selected>Choose a record...</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                            <p class="mt-3 text-xs text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-2 text-blue-400"></i>
                                Only records not already in your kit will be shown.
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col sm:flex-row justify-end gap-2">
                            <a href="{{ route('patient.emergency-kit.index') }}" class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200/30 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center cursor-pointer px-4 py-2.5 gap-2 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                <i class="fas fa-plus"></i> Add Record
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/patient/header.js', 'resources/js/main/emergencyKit/emergency.js'])
</body>

</html>
