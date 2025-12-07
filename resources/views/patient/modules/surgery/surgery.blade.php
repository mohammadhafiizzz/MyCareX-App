<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Surgery</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Past Surgeries
            </h1>
            <p class="mt-1 text-lg text-gray-700">Manage your past surgeries</p>
        </div>
        {{-- Success Message --}}
        @if (session('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        {{-- Surgeries List --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="surgeries-heading">
            <div class="p-6" id="surgeries-list">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="surgeries-heading" class="text-xl font-semibold text-gray-900">List of past Surgeries</h2>
                        <p class="mt-1 text-sm text-gray-600">See all your past surgeries here</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <button 
                            type="button" 
                            id="show-add-surgery-modal"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                <!-- showing real time data from the database (surgeries) -->
                @forelse ($surgeries as $surgery)
                    <article 
                        class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition"
                        data-surgery-id="{{ $surgery->id }}"
                        data-provider-created="{{ $surgery->doctor_id !== null ? 'true' : 'false' }}"
                        data-doctor-id="{{ $surgery->doctor_id }}">
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-500" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex-shrink-0">
                                        <i class="fas fa-procedures text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $surgery->procedure_name }}</h3>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span>
                                                Procedure Date <span class="sr-only">on</span> {{ \Carbon\Carbon::parse($surgery->procedure_date)->format('d M Y') }}
                                            </span>
                                        </p>
                                        @if($surgery->surgeon_name)
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-user-md" aria-hidden="true"></i>
                                            <span>Surgeon: {{ $surgery->surgeon_name }}</span>
                                        </p>
                                        @endif
                                        @if($surgery->hospital_name)
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-hospital" aria-hidden="true"></i>
                                            <span>Hospital: {{ $surgery->hospital_name }}</span>
                                        </p>
                                        @endif
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>
                                                Last updated <span class="sr-only">relative time</span> {{ \Carbon\Carbon::parse($surgery->updated_at ?? $surgery->created_at)->format('d M Y') }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                
                                {{-- Badges for verification status --}}
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @if($surgery->verification_status)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">
                                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <button 
                                    type="button" 
                                    class="edit-surgery-btn inline-flex gap-2 items-center justify-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-sm font-medium hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2"
                                    data-id="{{ $surgery->id }}">
                                    <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                    Edit
                                </button>
                                <button 
                                    type="button" 
                                    class="delete-surgery-btn inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-red-600 rounded-lg border border-red-200 text-sm font-medium hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2"
                                    data-id="{{ $surgery->id }}"
                                    data-procedure="{{ $surgery->procedure_name }}">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                    Delete
                                </button>
                                <a href="#" class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    More info
                                </a>
                            </div>
                        </div>
                    </article>
                    
                @empty
                    <div class="text-center py-16">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-file-medical text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                            
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No medical surgeries tracked yet</h3>
                        <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                            Tracking your surgeries helps your care team respond faster, personalise treatments, and monitor progress over time.
                        </p>

                        <div class="max-w-lg mx-auto mb-8 text-left bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-yellow-500" aria-hidden="true"></i>
                                Why start tracking?
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Spot warning signs early and share updates with your doctor.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Keep medication and treatment plans aligned across appointments.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Celebrate progress with clear, shareable health milestones.</span>
                                </li>
                            </ul>
                        </div>

                        <button type="button" onclick="document.getElementById('show-add-surgery-modal')?.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg text-base font-semibold hover:bg-blue-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first surgery
                        </button>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    <!-- Add Surgery Form -->
    @include('patient.modules.surgery.addSurgeryForm')
    
    <!-- Edit Surgery Form -->
    @include('patient.modules.surgery.editSurgeryForm')
    
    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/surgery/addSurgeryForm.js'])
    @vite(['resources/js/main/surgery/editSurgeryForm.js'])
    @vite(['resources/js/main/surgery/deleteSurgery.js'])
    @vite(['resources/js/main/surgery/surgeryPermissions.js'])
    @include('patient.components.footer')

</body>
</html>
