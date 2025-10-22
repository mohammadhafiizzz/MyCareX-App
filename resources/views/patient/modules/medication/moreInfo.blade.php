{{-- TODO: Implement medication details view --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Assume $medication variable is passed from the controller --}}
    <title>MyCareX - {{ $medication->medication_name }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            {{-- This link should point back to your main medication list page --}}
            <a href="{{ route('patient.medication') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-3 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Back to Medications
            </a>
            
            <h1 class="text-3xl font-bold text-gray-900">
                {{ $medication->medication_name }}
            </h1>
            <p class="mt-1 text-lg text-gray-700">Detailed information about this medication.</p>
        </div>

        <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="medication-details-heading">
            <div class="p-6 sm:p-8">
                {{-- 
                  Using a Definition List (dl) for semantically correct labelled fields.
                  A grid is used for layout.
                --}}
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Dosage</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $medication->dosage ?? 'N/A' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-600">Frequency</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $medication->frequency ?? 'N/A' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-600">Status</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            @switch($medication->status)
                                @case('Active')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $medication->status }}
                                    </span>
                                    @break

                                @case('Refill Due')
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $medication->status }}
                                    </span>
                                    @break
                                
                                @case('Inactive')
                                @default
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $medication->status ?? 'N/A' }}
                                    </span>
                            @endswitch
                        </dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-600">Prescribing Provider</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $medication->prescribing_provider ?? 'N/A' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-600">Start Date</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{-- Assuming start_date is cast to a Carbon object in your Model --}}
                            {{ $medication->start_date ? $medication->start_date->format('M d, Y') : 'N/A' }}
                        </dd>
                    </div>

                    <div>
                        <dt class="text-sm font-medium text-gray-600">End Date</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $medication->end_date ? $medication->end_date->format('M d, Y') : 'Not specified' }}
                        </dd>
                    </div>

                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-600">Reason for Medication</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900">
                            {{ $medication->reason_for_med ?? 'N/A' }}
                        </dd>
                    </div>

                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-600">Instructions / Notes</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-900 whitespace-pre-wrap">
                            {{ $medication->instructions ?? 'N/A' }}
                        </dd>
                    </div>

                </dl>
            </div>
        </section>
    </div>

    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>