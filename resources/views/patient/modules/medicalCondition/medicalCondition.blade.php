<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medical Conditions</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <a href="{{ route('patient.myrecords') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-3 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Back to My Records
            </a>
            
            <h1 class="text-3xl font-bold text-gray-900">
                Medical Conditions
            </h1>
            <p class="mt-1 text-lg text-gray-700">A complete record of your diagnosed conditions.</p>
        </div>

        {{-- Success Message --}}
        @if (session('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <section class="bg-white rounded-xl mb-7 shadow-sm border border-gray-200" aria-labelledby="conditions-heading">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 id="conditions-heading" class="text-xl font-semibold text-gray-900">
                        Medical Conditions
                    </h2>
                    <button 
                        type="button" 
                        id="show-add-condition-modal"
                        class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-plus"></i>
                        Add Condition
                    </button>
                </div>
            </div>

            <div class="flow-root">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Condition</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Diagnosis Date</th>
                                <th scope="col" class="hidden sm:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Description</th>
                                <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Severity</th>
                                <th scope="col" class="hidden md:table-cell px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($conditions as $condition)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $condition->condition_name }}
                                    </td>
                                    
                                    <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $condition->diagnosis_date ? $condition->diagnosis_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    
                                    <td class="hidden sm:table-cell px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $condition->description ?? 'N/A' }}
                                    </td>
                                    
                                    {{-- Severity Column --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        @switch($condition->severity)
                                            @case('Severe')
                                                <span class="inline-flex items-center font-medium text-red-700">
                                                    <i class="fas fa-circle-exclamation mr-1.5" aria-hidden="true"></i> 
                                                    {{ $condition->severity }}
                                                </span>
                                                @break

                                            @case('Moderate')
                                                <span class="inline-flex items-center font-medium text-yellow-700">
                                                    <i class="fas fa-triangle-exclamation mr-1.5" aria-hidden="true"></i> 
                                                    {{ $condition->severity }}
                                                </span>
                                                @breaks

                                            @case('Mild')
                                            @default
                                                <span class="inline-flex items-center font-medium text-green-700">
                                                    <i class="fas fa-circle-check mr-1.5" aria-hidden="true"></i> 
                                                    {{ $condition->severity }}
                                                </span>
                                        @endswitch
                                    </td>
                                    
                                    {{-- Status Column --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @switch($condition->status)
                                            @case('Active')
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    {{ $condition->status }}
                                                </span>
                                                @break

                                            @case('Chronic')
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    {{ $condition->status }}
                                                </span>
                                                @break

                                            @case('Resolved')
                                            @default
                                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    {{ $condition->status }}
                                                </span>
                                        @endswitch
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="edit-condition-btn text-blue-600 hover:underline hover:text-blue-900 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1"
                                        data-id="{{ $condition->id }}">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                        You have not added any medical conditions yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Condition Form -->
    @include('patient.modules.medicalCondition.addConditionForm')

    <!-- Edit Condition Form -->
    @include('patient.modules.medicalCondition.editConditionForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medicalCondition/addConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/editConditionForm.js'])
    @include('patient.components.footer')

</body>
</html>