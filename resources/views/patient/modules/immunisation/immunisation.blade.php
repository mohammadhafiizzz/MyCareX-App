<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Immunisations</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                My Records
            </h1>
            <p class="mt-1 text-lg text-gray-700">Manage your own medical records.</p>
        </div>

        {{-- Success Message --}}
        @if (session('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('patient.components.recordNav')

        {{-- Immunisations List with Integrated Filters --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="immunisations-heading">
            <div class="p-6">
                {{-- Header with Actions --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="immunisations-heading" class="text-xl font-semibold text-gray-900">Vaccination Records</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter and manage your immunisation records with ease.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($totalImmunisations > 0)
                            <a href="{{ route('patient.immunisation.export.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0" aria-label="Download all immunisations as PDF" title="Export your complete immunisation history as PDF">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Export</span>
                            </a>
                        @endif
                        <button 
                            type="button" 
                            id="show-add-vaccine-modal"
                            class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                @if ($totalImmunisations > 0)
                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="immunisation-search" 
                                placeholder="Search by vaccination name..." 
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                aria-label="Search immunisations"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                            </div>
                            <button 
                                type="button" 
                                id="clear-search" 
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                                aria-label="Clear search"
                            >
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Immunisations List Header with Pagination --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <p class="text-sm text-gray-500" id="immunisations-count">
                            Showing <span class="font-medium text-gray-900">{{ $totalImmunisations }}</span> vaccination {{ $totalImmunisations !== 1 ? 's' : '' }}
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Most recent first</span>
                            </div>
                            <div id="pagination-controls" class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    id="prev-page"
                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
                                    disabled>
                                    <i class="fas fa-chevron-left text-xs" aria-hidden="true"></i>
                                    <span class="hidden sm:inline">Previous</span>
                                </button>
                                <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium" id="page-info">Page 1 of 1</span>
                                <button 
                                    type="button" 
                                    id="next-page"
                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
                                    disabled>
                                    <span class="hidden sm:inline">Next</span>
                                    <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Immunisations List --}}
                <div id="immunisations-list">

                @forelse ($immunisations as $immunisation)
                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-verification="{{ $immunisation['data']->verification_status ?? 'Unverified' }}">
                        <span class="absolute inset-y-0 left-0 w-1" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-500 flex-shrink-0">
                                        <i class="fas fa-syringe text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $immunisation['data']->vaccine_name }}</h3>
                                        @if ($immunisation['data']->dose_details)
                                            <p class="mt-1 text-sm text-gray-600">{{ $immunisation['data']->dose_details }}</p>
                                        @endif
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span>
                                                Vaccinated on <span class="sr-only">date</span> {{ $immunisation['vaccinationLabel'] }}
                                            </span>
                                        </p>
                                        @if ($immunisation['data']->administered_by)
                                            <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                                <i class="fas fa-user-doctor" aria-hidden="true"></i>
                                                <span>
                                                    Administered by {{ $immunisation['data']->administered_by }}
                                                </span>
                                            </p>
                                        @endif
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>
                                                Last updated <span class="sr-only">relative time</span> {{ $immunisation['lastUpdatedLabel'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if ($immunisation['data']->notes)
                                    <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                        {{ $immunisation['data']->notes }}
                                    </p>
                                @endif

                                @if ($immunisation['data']->vaccine_lot_number)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200" role="status">
                                        <span class="sr-only">Lot Number:</span>
                                        <i class="fas fa-barcode" aria-hidden="true"></i>
                                        Lot: {{ $immunisation['data']->vaccine_lot_number }}
                                    </span>
                                @endif
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <a href="{{ route('patient.immunisation.info', $immunisation['data']->id) }}" class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    More info
                                </a>
                                <button type="button" 
                                    onclick="toggleActivity({{ $immunisation['data']->id }})"
                                    class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                    <span class="activity-toggle-text">Show activity</span>
                                </button>
                            </div>
                        </div>

                        {{-- Recent Activity Section (collapsed by default) --}}
                        <div id="activity-{{ $immunisation['data']->id }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-900">Recent Activity</h4>
                                <span class="text-xs text-gray-500">Last 5 updates</span>
                            </div>
                            <div class="space-y-3">
                                {{-- Activity: Created --}}
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-plus text-blue-600 text-xs" aria-hidden="true"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-medium">Vaccination added</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ \Carbon\Carbon::parse($immunisation['data']->created_at)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($immunisation['data']->created_at)->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Activity: Last Updated --}}
                                @if ($immunisation['data']->updated_at != $immunisation['data']->created_at)
                                <div class="flex gap-3">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                        <i class="fas fa-edit text-amber-600 text-xs" aria-hidden="true"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">
                                            <span class="font-medium">Record updated</span>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ \Carbon\Carbon::parse($immunisation['data']->updated_at)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($immunisation['data']->updated_at)->format('h:i A') }}
                                        </p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-16">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-syringe text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No immunisations tracked yet</h3>
                        <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                            Keep your vaccination records organized to stay protected and meet health requirements for travel, work, or school.
                        </p>

                        <div class="max-w-lg mx-auto mb-8 text-left bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-yellow-500" aria-hidden="true"></i>
                                Why track immunisations?
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Maintain accurate records for travel, education, and employment requirements.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Track booster shots and stay current with recommended vaccines.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Share verified records with healthcare providers quickly and easily.</span>
                                </li>
                            </ul>
                        </div>

                        <button type="button" onclick="document.getElementById('add-vaccine-modal')?.classList.remove('hidden'); document.getElementById('add-vaccine-modal')?.classList.add('flex'); document.body.classList.add('overflow-hidden');" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white rounded-2xl text-base font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first vaccination
                        </button>
                    </div>
                @endforelse
                
                {{-- No Results After Filtering --}}
                <div id="no-filter-results" class="hidden text-center py-12">
                    <i class="fas fa-filter text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No immunisations match your filters</h3>
                    <p class="text-sm text-gray-600 mb-4">Try adjusting or resetting your filter selections</p>
                    <button type="button" id="reset-filters-from-empty" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                        Reset filters
                    </button>
                </div>
                
                {{-- No Results After Search --}}
                <div id="no-search-results" class="hidden text-center py-12">
                    <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No immunisations found</h3>
                    <p class="text-sm text-gray-600 mb-4">We couldn't find any immunisations matching your search</p>
                    <button type="button" onclick="document.getElementById('immunisation-search').value = ''; document.getElementById('clear-search').click();" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times" aria-hidden="true"></i>
                        Clear search
                    </button>
                </div>
                </div>
            </div>
        </section>

    </div>

    <!-- Add Vaccine Form -->
    @include('patient.modules.immunisation.addVaccineForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/immunisation/addVaccineForm.js'])
    @vite(['resources/js/main/immunisation/editVaccine.js'])
    @vite(['resources/js/main/immunisation/immunisationFilter.js'])
    @vite(['resources/js/main/immunisation/immunisationActivityToggle.js'])
    @vite(['resources/js/main/immunisation/immunisationFilterToggle.js'])
    @vite(['resources/js/main/immunisation/immunisationPagination.js'])

    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

</body>
</html>
