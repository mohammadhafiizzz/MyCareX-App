<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Medications</title>
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

        {{-- Medications List with Integrated Filters --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="medications-heading">
            <div class="p-6">
                {{-- Header with Actions --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="medications-heading" class="text-xl font-semibold text-gray-900">Medications</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter and manage your medication records with ease.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($totalMedications > 0)
                            <button 
                                type="button" 
                                id="toggle-filters-btn"
                                class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                                <i class="fas fa-filter" aria-hidden="true"></i>
                                <span>Filters</span>
                            </button>
                            <a href="{{ route('patient.medication.export.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0" aria-label="Export medications as PDF" title="Download your medications as PDF">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Export</span>
                            </a>
                        @endif
                        <button 
                            type="button" 
                            id="show-add-medication-modal"
                            class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                @if ($totalMedications > 0)
                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                            </div>
                            <input 
                                type="text" 
                                id="medication-search"
                                placeholder="Search by medication name..."
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md text-sm leading-4 text-gray-700 bg-white hover:bg-gray-50"
                                aria-label="Search medications"
                            >
                            <button 
                                type="button" 
                                id="clear-search"
                                class="hidden absolute inset-y-0 right-0 pr-3 items-center text-gray-400 hover:text-gray-600 hover:bg-gray-100/50 rounded-full transition-all duration-200"
                                aria-label="Clear search">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Filters Section (Hidden by default) --}}
                    <div id="filters-section" class="hidden mb-6 pb-6 border-b border-gray-200">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Status</h3>
                                <div class="flex flex-wrap gap-2" role="list">
                                    @foreach ($statusOptions as $option)
                                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $loop->first ? 'bg-blue-500/10 backdrop-blur-sm border-blue-400/30 text-blue-700 shadow-sm' : 'bg-gray-100/60 backdrop-blur-sm border-white/20 text-gray-700 hover:bg-gray-200/80 hover:shadow-md' }} text-sm font-medium transition-all duration-200" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="Filter by {{ $option }} status">
                                            {{ $option }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex items-center justify-between">
                                <p class="text-xs text-gray-500 flex items-center gap-2">
                                    <i class="fas fa-lightbulb text-gray-500" aria-hidden="true"></i>
                                    <span>Combine filters to find specific medications</span>
                                </p>
                                <button type="button" id="reset-all-filters" class="inline-flex items-center gap-2 px-3 py-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50/50 backdrop-blur-sm rounded-lg text-sm font-medium transition-all duration-200">
                                    <i class="fas fa-redo text-xs" aria-hidden="true"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Medications List Header with Pagination --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <p class="text-sm text-gray-500" id="medications-count">
                            {{-- JavaScript will update this with "Showing 1-5 of X medications" --}}
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

                {{-- Medications List --}}
                <div id="medications-list">

                @forelse ($medications as $medication)
                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-status="{{ $medication['dataStatus'] }}" data-frequency="{{ $medication['dataFrequency'] }}">
                        <span class="absolute inset-y-0 left-0 w-1" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex-shrink-0">
                                        <i class="fas fa-capsules text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $medication['data']->medication_name }}</h3>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-prescription" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Dosage:</strong> {{ $medication['dosage'] }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Frequency:</strong> {{ $medication['frequency'] }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Start:</strong> {{ $medication['startDateLabel'] }} &bull; <strong class="text-gray-800">End:</strong> {{ $medication['endDateLabel'] }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>Last updated <span class="sr-only">relative time</span> {{ $medication['lastUpdatedLabel'] }}</span>
                                        </p>
                                    </div>
                                </div>

                                <p class="text-sm font-semibold mt-4 text-gray-400">Notes:</p>
                                @if ($medication['notes'])
                                    <p class="text-sm text-gray-700 leading-relaxed">
                                        {{ $medication['notes'] }}
                                    </p>
                                @endif

                                <p class="text-sm font-semibold mt-4 text-gray-400">Status & Frequency:</p>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $medication['statusBadgeStyles'] }}" role="status">
                                        <span class="sr-only">Status:</span>
                                        <i class="{{ $medication['statusIcon'] }}" aria-hidden="true"></i>
                                        {{ $medication['data']->status ?? 'Not set' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200" role="status">
                                        <span class="sr-only">Frequency:</span>
                                        <i class="fas fa-clock" aria-hidden="true"></i>
                                        {{ $medication['frequency'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <a href="{{ route('patient.medication.info', $medication['data']->id) }}" class="inline-flex items-center justify-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    View Details
                                </a>
                                <button type="button" 
                                    onclick="toggleMedicationActivity({{ $medication['data']->id }})"
                                    class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                    <span class="activity-toggle-text">Show activity</span>
                                </button>
                            </div>
                        </div>

                        {{-- Recent Activity Section (collapsed by default) --}}
                        <div id="medication-activity-{{ $medication['data']->id }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-clock-rotate-left text-blue-500" aria-hidden="true"></i>
                                    Recent Activity
                                </h4>
                                <span class="text-xs text-gray-500">Last 5 updates</span>
                            </div>
                            
                            {{-- Activity Timeline --}}
                            <div class="space-y-3">
                                @if(isset($medication['recentActivity']) && count($medication['recentActivity']) > 0)
                                    @foreach($medication['recentActivity'] as $activity)
                                        <div class="flex gap-3 text-sm">
                                            <div class="flex-shrink-0 mt-0.5">
                                                <div class="w-2 h-2 rounded-full {{ $activity['dotColor'] ?? 'bg-blue-500' }}"></div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-gray-900">
                                                    <span class="font-medium">{{ $activity['action'] }}</span>
                                                    @if(isset($activity['details']))
                                                        <span class="text-gray-600"> – {{ $activity['details'] }}</span>
                                                    @endif
                                                </p>
                                                <p class="text-gray-500 text-xs mt-0.5">{{ $activity['timestamp'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-6 text-gray-500">
                                        <i class="fas fa-inbox text-2xl mb-2 text-gray-400" aria-hidden="true"></i>
                                        <p class="text-sm">No recent activity to display</p>
                                        <p class="text-xs mt-1">Updates will appear here when any modifications are made to this record</p>
                                    </div>
                                @endif
                            </div>

                            {{-- View Full History Link --}}
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <a href="#" class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-700">
                                    <span>View full activity history</span>
                                    <i class="fas fa-arrow-right text-xs" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-16">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-pills text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No medications on file yet</h3>
                        <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                            Add your medications to receive reminders, share summaries with providers, and spot gaps in treatment early.
                        </p>

                        <div class="max-w-lg mx-auto mb-8 text-left bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-yellow-500" aria-hidden="true"></i>
                                Benefits of tracking
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Automatic reminders keep you on schedule and prevent missed doses.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Share accurate lists with pharmacies, doctors, or caregivers instantly.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Track side effects and progress to guide treatment adjustments.</span>
                                </li>
                            </ul>
                        </div>

                        <button type="button" onclick="document.getElementById('show-add-medication-modal')?.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white rounded-2xl text-base font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first medication
                        </button>
                    </div>
                @endforelse
                
                {{-- No Results After Filtering --}}
                <div id="no-filter-results" class="hidden text-center py-12">
                    <i class="fas fa-filter text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No medications match your filters</h3>
                    <p class="text-sm text-gray-600 mb-4">Try adjusting or resetting your filter selections</p>
                    <button type="button" id="reset-filters-from-empty" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                        Reset filters
                    </button>
                </div>
                
                {{-- No Results After Search --}}
                <div id="no-search-results" class="hidden text-center py-12">
                    <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No medications found</h3>
                    <p class="text-sm text-gray-600 mb-4">We couldn't find any medications matching your search</p>
                    <button type="button" onclick="document.getElementById('medication-search').value = ''; document.getElementById('clear-search').click();" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times" aria-hidden="true"></i>
                        Clear search
                    </button>
                </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Medication Modal -->
    @include('patient.modules.medication.addMedicationForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medication/addMedicationForm.js'])
    @vite(['resources/js/main/medication/medicationFilter.js'])
    @vite(['resources/js/main/medication/medicationActivityToggle.js'])
    @vite(['resources/js/main/medication/medicationFilterToggle.js'])
    @vite(['resources/js/main/medication/medicationPagination.js'])

    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

    @if ($errors->any())
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('show-add-medication-modal');
        if (btn) btn.click();
    });
    </script>
    @endif
</body>

</html>