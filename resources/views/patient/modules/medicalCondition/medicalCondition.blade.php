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

        @if ($totalConditions > 0)
        {{-- Filters & Quick Actions --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="conditions-controls-heading">
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 id="conditions-controls-heading" class="text-xl font-semibold text-gray-900">Manage Medical Conditions</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter and organise your records to focus on what needs attention today.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button 
                            type="button" 
                            id="show-add-condition-modal"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Severity</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($severityOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-400 text-blue-800' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="Filter by {{ $option }} severity">
                                    <i class="fas fa-circle text-xs {{ $severityFilterColors[$option] ?? 'text-blue-500' }}" aria-hidden="true"></i>
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Status</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($statusOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-400 text-blue-800' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-label="Filter by {{ $option }} status">
                                    <i class="fas {{ $statusFilterIcons[$option] ?? 'fa-circle text-blue-500' }}" aria-hidden="true"></i>
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fas fa-filter text-blue-500" aria-hidden="true"></i>
                        <span>Tip: Combine filters to target conditions that need urgent attention.</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" id="reset-all-filters" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-sm font-medium hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            Reset filters
                        </button>
                        <a href="{{ route('patient.condition.export.pdf') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2" aria-label="Download all conditions as PDF" title="Export your complete condition history as PDF">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            <span class="hidden sm:inline">Export PDF</span>
                            <span class="sm:hidden">Export</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @endif

        {{-- Medical Conditions List --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="conditions-heading">
            <div class="p-6" id="conditions-list">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="conditions-heading" class="text-xl font-semibold text-gray-900">Medical Conditions</h2>
                        <p class="mt-1 text-sm text-gray-600">Highlights severity, status, and the latest updates for quick review.</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500" aria-hidden="true"></i>
                        <span>Sorted by most recent activity</span>
                    </div>
                </div>

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
                                <a href="{{ route('patient.condition.info', $condition['data']->id) }}" class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
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

                        <button type="button" onclick="document.getElementById('add-condition-modal')?.classList.remove('hidden'); document.getElementById('add-condition-modal')?.classList.add('flex'); document.body.classList.add('overflow-hidden');" class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg text-base font-semibold hover:bg-blue-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first condition
                        </button>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- TODO: combine with the above (all records) for UX enhancements -->
        @if ($totalConditions > 0)
            {{-- Timeline View --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" id="conditions-timeline" aria-labelledby="conditions-timeline-heading">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 id="conditions-timeline-heading" class="text-xl font-semibold text-gray-900">Health Timeline</h2>
                            <p class="mt-1 text-sm text-gray-600">Review significant updates in chronological order to spot trends and progress.</p>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-stream text-blue-500" aria-hidden="true"></i>
                            <span>Showing latest 6 updates</span>
                        </div>
                    </div>

                    <div class="relative mt-6">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200" aria-hidden="true"></div>
                        <div class="space-y-6">
                            @foreach ($timelineConditions as $timelineCondition)
                                <div class="relative flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full border-4 border-white shadow flex items-center justify-center">
                                        <span class="w-3 h-3 rounded-full {{ $timelineCondition['severityBorder'] }}" aria-hidden="true"></span>
                                    </div>
                                    <div class="flex-1 bg-gray-50 rounded-xl border border-gray-200 p-5">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-heartbeat {{ $timelineCondition['severityIcon'] }}" aria-hidden="true"></i>
                                                <h3 class="text-base font-semibold text-gray-900">{{ $timelineCondition['data']->condition_name }}</h3>
                                            </div>
                                            <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                                                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                                {{ $timelineCondition['dateLabel'] }}
                                            </span>
                                        </div>
                                        @if ($timelineCondition['data']->description)
                                            <p class="mt-3 text-sm text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($timelineCondition['data']->description, 160, '…') }}
                                            </p>
                                        @endif
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $timelineCondition['statusBadge'] }}" role="status">
                                                <span class="sr-only">Status:</span>
                                                {{ $timelineCondition['data']->status ?? 'Not set' }}
                                            </span>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 text-gray-600 bg-white" role="status">
                                                <span class="sr-only">Severity:</span>
                                                {{ $timelineCondition['data']->severity ?? 'Undefined' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="#conditions-list" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            Back to conditions list
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <!-- Add Condition Form -->
    @include('patient.modules.medicalCondition.addConditionForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medicalCondition/addConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/editConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/conditionFilter.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

</body>
</html>
