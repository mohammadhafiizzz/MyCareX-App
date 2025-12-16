<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Add to Emergency Kit</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Main Content -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
        <a href="{{ route('patient.emergency-kit.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-700 mb-4">
            <i class="fas fa-arrow-left"></i> Back
        </a>

        <div class="mb-8">
            <h2 class="mt-2 text-2xl font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Add Item to Emergency Kit
            </h2>
        </div>

        @if($errors->any())
            <div class="rounded-md bg-red-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-times-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
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

        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('patient.emergency-kit.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Record Type</label>
                            <select id="type" name="type" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select a type...</option>
                                <option value="condition">Condition</option>
                                <option value="medication">Medication</option>
                                <option value="allergy">Allergy</option>
                            </select>
                            <p class="mt-2 text-sm text-gray-500">Select the type of medical record you want to add.</p>
                        </div>

                        <div id="record-container" class="hidden">
                            <label for="record_id" class="block text-sm font-medium leading-6 text-gray-900">Select Record</label>
                            <select id="record_id" name="record_id" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                <option value="" disabled selected>Select a record...</option>
                            </select>
                            <p class="mt-2 text-sm text-gray-500">Choose from your existing records.</p>
                        </div>

                        <div class="flex justify-end gap-x-3">
                            <a href="{{ route('patient.emergency-kit.index') }}" class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                            <button type="submit" class="rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Add to Kit</button>
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
