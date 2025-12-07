<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - {{ $surgery->procedure_name }} Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Breadcrumb Navigation --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('patient.surgery') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Surgeries
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Surgery Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Card --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-8 mb-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-procedures text-3xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $surgery->procedure_name }}</h1>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $verificationIcon }}" aria-hidden="true"></i>
                                {{ $verificationStatus }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                {{ $procedureDateLabel }}
                            </span>
                            @if($isProviderCreated)
                                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-purple-500/40 backdrop-blur-sm border border-white/30">
                                    <i class="fas fa-user-md" aria-hidden="true"></i>
                                    Provider Created
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('patient.surgery') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Back to List
                    </a>
                    @if(!$isProviderCreated)
                        <button type="button" class="edit-surgery-btn inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2" data-id="{{ $surgery->id }}">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            Edit
                        </button>
                    @else
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-white/60 text-sm font-semibold rounded-lg border border-white/20 cursor-not-allowed">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            Provider Managed
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- Overview Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical-alt text-blue-600" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Surgery Information</h2>
                    </div>

                    {{-- Surgery Details Grid --}}
                    <div class="space-y-6">
                        
                        {{-- Procedure Name --}}
                        <div class="p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-procedures text-blue-600" aria-hidden="true"></i>
                                Procedure Name:
                            </h3>
                            <p class="text-sm text-gray-900 font-medium">{{ $surgery->procedure_name }}</p>
                        </div>

                        {{-- Procedure Date --}}
                        <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-600" aria-hidden="true"></i>
                                Procedure Date:
                            </h3>
                            <p class="text-sm text-gray-900 font-medium">{{ $procedureDateLabel }}</p>
                        </div>

                        {{-- Surgeon Name --}}
                        @if($surgery->surgeon_name)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-user-md text-gray-600" aria-hidden="true"></i>
                                    Surgeon Name:
                                </h3>
                                <p class="text-sm text-gray-900 font-medium">{{ $surgery->surgeon_name }}</p>
                            </div>
                        @endif

                        {{-- Hospital Name --}}
                        @if($surgery->hospital_name)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                    <i class="fas fa-hospital text-gray-600" aria-hidden="true"></i>
                                    Hospital Name:
                                </h3>
                                <p class="text-sm text-gray-900 font-medium">{{ $surgery->hospital_name }}</p>
                            </div>
                        @endif

                        {{-- Additional Notes --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-notes-medical text-gray-600" aria-hidden="true"></i>
                                Notes:
                            </h3>
                            @if ($surgery->notes)
                                <div class="prose prose-sm max-w-none p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $surgery->notes }}</p>
                                </div>
                            @else
                                <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-2">
                                        <i class="fas fa-file-alt text-gray-400 text-lg" aria-hidden="true"></i>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-2">No additional notes available.</p>
                                    @if(!$isProviderCreated)
                                        <button type="button" class="edit-surgery-btn inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium" data-id="{{ $surgery->id }}">
                                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                            Add notes
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Stats Card --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-chart-line text-blue-600" aria-hidden="true"></i>
                        Quick Stats
                    </h2>
                    <dl class="space-y-4">
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-600">Verification Status:</dt>
                            <dd>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $verificationBadgeStyles }}">
                                    <i class="{{ $verificationIcon }}" aria-hidden="true"></i>
                                    {{ $verificationStatus }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-600">Record Type:</dt>
                            <dd class="text-sm font-medium text-gray-900">
                                @if($isProviderCreated)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 border border-purple-200">
                                        <i class="fas fa-user-md" aria-hidden="true"></i>
                                        Provider
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 border border-blue-200">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                        Self-Reported
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                            <dt class="text-sm text-gray-600">Created On:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $createdLabel }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-sm text-gray-600">Last Updated:</dt>
                            <dd class="text-sm font-medium text-gray-900">{{ $updatedLabel }}</dd>
                        </div>
                    </dl>
                </section>

                {{-- Actions Card --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-blue-600" aria-hidden="true"></i>
                        Actions
                    </h2>
                    <div class="space-y-3">
                        @if(!$isProviderCreated)
                            <button type="button" class="edit-surgery-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2" data-id="{{ $surgery->id }}">
                                <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                Edit Surgery
                            </button>
                            <button type="button" class="delete-surgery-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-red-600 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2" data-id="{{ $surgery->id }}" data-procedure="{{ $surgery->procedure_name }}">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                Delete Surgery
                            </button>
                        @else
                            <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-info-circle text-purple-600 mt-0.5" aria-hidden="true"></i>
                                    <div>
                                        <p class="text-sm font-medium text-purple-900 mb-1">Provider Managed Record</p>
                                        <p class="text-xs text-purple-700">This surgery was created by your healthcare provider and cannot be edited or deleted.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('patient.surgery') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            Back to List
                        </a>
                    </div>
                </section>

                {{-- Info Card --}}
                <section class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <i class="fas fa-lightbulb text-yellow-600 text-xl mt-0.5" aria-hidden="true"></i>
                        <h3 class="text-sm font-semibold text-gray-900">Helpful Tip</h3>
                    </div>
                    <p class="text-xs text-gray-700 leading-relaxed">
                        Keep your surgery records up-to-date to help your healthcare providers make informed decisions about your treatment plan.
                    </p>
                </section>
            </div>
        </div>
    </div>

    <!-- Edit Surgery Form -->
    @include('patient.modules.surgery.editSurgeryForm')
    
    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/surgery/editSurgeryForm.js'])
    @vite(['resources/js/main/surgery/deleteSurgery.js'])
    @include('patient.components.footer')

</body>
</html>
