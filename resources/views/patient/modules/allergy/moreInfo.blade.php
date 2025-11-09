<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - {{ $allergy->allergen }} Details</title>
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
                    <a href="{{ route('patient.allergy') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Allergies
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Allergy Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Card --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 text-white rounded-xl p-8 mb-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-allergies text-3xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $allergy->allergen }}</h1>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $severityBadgeIcon }}" aria-hidden="true"></i>
                                {{ $allergy->severity ?? 'Undefined' }} Severity
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                {{ $allergy->status ?? 'Not set' }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $verificationIcon }}" aria-hidden="true"></i>
                                {{ $allergy->verification_status ?? 'Unverified' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('patient.allergy') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Back to List
                    </a>
                    <button type="button" class="edit-allergy-btn inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2" data-id="{{ $allergy->id }}">
                        <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                        Edit
                    </button>
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
                        <h2 class="text-xl font-semibold text-gray-900">Reaction Description</h2>
                    </div>

                    @if ($allergy->reaction_desc)
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $allergy->reaction_desc }}</p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                                <i class="fas fa-file-alt text-gray-400 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-sm text-gray-500">No reaction description available for this allergy.</p>
                            <button type="button" class="edit-allergy-btn mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium" data-id="{{ $allergy->id }}">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                Add description
                            </button>
                        </div>
                    @endif
                </section>

                {{-- Allergy Details Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-blue-600" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Allergy Details</h2>
                    </div>

                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Allergen:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $allergy->allergen }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Allergy Type:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $allergy->allergy_type }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">First Observed Date:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-400" aria-hidden="true"></i>
                                {{ $observedLabel }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Severity Level:</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $severityBadgeStyles }}">
                                    <i class="{{ $severityBadgeIcon }}" aria-hidden="true"></i>
                                    {{ $allergy->severity ?? 'Undefined' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Current Status:</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $statusBadgeStyles }}">
                                    <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                    {{ $allergy->status ?? 'Not set' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Verification Status:</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $verificationBadgeStyles }}">
                                    <i class="{{ $verificationIcon }}" aria-hidden="true"></i>
                                    {{ $allergy->verification_status ?? 'Unverified' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Record Created:</dt>
                            <dd class="text-sm text-gray-900">{{ $createdLabel }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Last Updated:</dt>
                            <dd class="text-sm text-gray-900">{{ $updatedLabel }}</dd>
                        </div>
                    </dl>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Actions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <button type="button" class="edit-allergy-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" data-id="{{ $allergy->id }}">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            Edit Allergy
                        </button>
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share with Doctor
                        </button>
                        <form method="POST" action="{{ route('patient.allergy.delete', $allergy->id) }}" class="inline-block w-full" onsubmit="return confirm('Are you sure you want to delete this allergy? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                Delete Allergy
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Status Timeline --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status History</h3>
                    <div class="relative">
                        <div class="absolute left-3 top-3 bottom-3 w-0.5 bg-gray-200"></div>
                        <div class="space-y-4 relative">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Status: {{ $allergy->status }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $updatedLabel }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Allergy Added</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $createdLabel }}</p>
                                </div>
                            </div>
                            @if ($allergy->first_observed_date)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">First Observed</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $observedLabel }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Health Tip --}}
                <section class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl border border-blue-200 p-6">
                    <div class="flex items-start gap-3 mb-3">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-lightbulb text-white" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Health Tip</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Keep your allergy records up to date and share them with all healthcare providers. This helps prevent dangerous reactions and ensures you receive safe treatments.
                    </p>
                </section>

            </div>
        </div>
    </div>

    <!-- Edit Allergy Form -->
    @include('patient.modules.allergy.editAllergyForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/allergy/editAllergy.js'])
    @include('patient.components.footer')

</body>
</html>
