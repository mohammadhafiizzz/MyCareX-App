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

        {{-- Medical Conditions List with Integrated Filters --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="conditions-heading">
            <div class="p-6">
                {{-- Header with Actions --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="conditions-heading" class="text-xl font-semibold text-gray-900">Medical Conditions</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter and manage your health records with ease.</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @if ($totalConditions > 0)
                            <button 
                                type="button" 
                                id="toggle-filters-btn"
                                class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                                <i class="fas fa-filter" aria-hidden="true"></i>
                                <span>Filters</span>
                            </button>
                            <a href="{{ route('patient.condition.export.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0" aria-label="Download all conditions as PDF" title="Export your complete condition history as PDF">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Export</span>
                            </a>
                        @endif
                        <button 
                            type="button" 
                            id="show-add-condition-modal"
                            class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                @if ($totalConditions > 0)
                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                            </div>
                            <input 
                                type="text" 
                                id="condition-search"
                                placeholder="Search by condition name..."
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md text-sm leading-4 text-gray-700 bg-white hover:bg-gray-50"
                                aria-label="Search conditions"
                            >
                            <button 
                                type="button" 
                                id="clear-search"
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hover:bg-gray-100/50 rounded-full transition-all duration-200"
                                aria-label="Clear search">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Filters Section (Hidden by default) --}}
                    <div id="filters-section" class="hidden mb-6 pb-6 border-b border-gray-200">
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-2">Severity</h3>
                                <div class="flex flex-wrap gap-2" role="list">
                                    @foreach ($severityOptions as $option)
                                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 rounded-full border {{ $loop->first ? 'bg-blue-500/10 backdrop-blur-sm border-blue-400/30 text-blue-700 shadow-sm' : 'bg-gray-100/60 backdrop-blur-sm border-white/20 text-gray-700 hover:bg-gray-200/80 hover:shadow-md' }} text-sm font-medium transition-all duration-200" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="Filter by {{ $option }} severity">
                                            {{ $option }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
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
                                    <span>Combine filters to find specific conditions</span>
                                </p>
                                <button type="button" id="reset-all-filters" class="inline-flex items-center gap-2 px-3 py-1.5 text-blue-600 hover:text-blue-700 hover:bg-blue-50/50 backdrop-blur-sm rounded-lg text-sm font-medium transition-all duration-200">
                                    <i class="fas fa-redo text-xs" aria-hidden="true"></i>
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Conditions List Header with Pagination --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <p class="text-sm text-gray-500" id="conditions-count">
                            Showing <span class="font-medium text-gray-900">{{ count($conditions) }}</span> condition{{ count($conditions) !== 1 ? 's' : '' }}
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

                {{-- Conditions List --}}
                <div id="conditions-list">

                @forelse ($conditions as $condition)
                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-severity="{{ $condition['severityData'] }}" data-status="{{ $condition['statusData'] }}">
                        <span class="absolute inset-y-0 left-0 w-1" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex-shrink-0">
                                        <i class="fas fa-heartbeat text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $condition['data']->condition_name }}</h3>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span>
                                                Diagnosed <span class="sr-only">on</span> {{ $condition['diagnosisLabel'] }}
                                            </span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>
                                                Last updated <span class="sr-only">relative time</span> {{ $condition['lastUpdatedLabel'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if ($condition['data']->description)
                                    <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                        {{ $condition['data']->description }}
                                    </p>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $condition['severityBadgeStyles'] }}" role="status">
                                        <span class="sr-only">Severity:</span>
                                        <i class="{{ $condition['severityBadgeIcon'] }}" aria-hidden="true"></i>
                                        {{ $condition['data']->severity ?? 'Undefined' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $condition['statusBadgeStyles'] }}" role="status">
                                        <span class="sr-only">Status:</span>
                                        <i class="{{ $condition['statusIcon'] }}" aria-hidden="true"></i>
                                        {{ $condition['data']->status ?? 'Not set' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <a href="{{ route('patient.condition.info', $condition['data']->id) }}" class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                                    More info
                                </a>
                                <button type="button" 
                                    onclick="toggleActivity({{ $condition['data']->id }})"
                                    class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                    <span class="activity-toggle-text">Show activity</span>
                                </button>
                            </div>
                        </div>

                        {{-- Recent Activity Section (collapsed by default) --}}
                        <div id="activity-{{ $condition['data']->id }}" class="hidden mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-clock-rotate-left text-blue-500" aria-hidden="true"></i>
                                    Recent Activity
                                </h4>
                                <span class="text-xs text-gray-500">Last 5 updates</span>
                            </div>
                            
                            {{-- Activity Timeline --}}
                            <div class="space-y-3">
                                {{-- Example activity items - You'll need to pass actual activity data from controller --}}
                                @if(isset($condition['recentActivity']) && count($condition['recentActivity']) > 0)
                                    @foreach($condition['recentActivity'] as $activity)
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
                                <i class="fas fa-file-medical text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                            
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No medical conditions tracked yet</h3>
                        <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                            Tracking your conditions helps your care team respond faster, personalise treatments, and monitor progress over time.
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

                        <button type="button" onclick="document.getElementById('add-condition-modal')?.classList.remove('hidden'); document.getElementById('add-condition-modal')?.classList.add('flex'); document.body.classList.add('overflow-hidden');" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white rounded-2xl text-base font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first condition
                        </button>
                    </div>
                @endforelse
                
                {{-- No Results After Filtering --}}
                <div id="no-filter-results" class="hidden text-center py-12">
                    <i class="fas fa-filter text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No conditions match your filters</h3>
                    <p class="text-sm text-gray-600 mb-4">Try adjusting or resetting your filter selections</p>
                    <button type="button" id="reset-filters-from-empty" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                        Reset filters
                    </button>
                </div>
                
                {{-- No Results After Search --}}
                <div id="no-search-results" class="hidden text-center py-12">
                    <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No conditions found</h3>
                    <p class="text-sm text-gray-600 mb-4">We couldn't find any conditions matching your search</p>
                    <button type="button" onclick="document.getElementById('condition-search').value = ''; document.getElementById('clear-search').click();" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times" aria-hidden="true"></i>
                        Clear search
                    </button>
                </div>
                </div>
            </div>
        </section>


    </div>

    <!-- Add Condition Form -->
    @include('patient.modules.medicalCondition.addConditionForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medicalCondition/addConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/editConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/conditionFilter.js'])
    @vite(['resources/js/main/medicalCondition/activityToggle.js'])
    @vite(['resources/js/main/medicalCondition/filterToggle.js'])
    @vite(['resources/js/main/medicalCondition/conditionPagination.js'])

    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

</body>
</html>
