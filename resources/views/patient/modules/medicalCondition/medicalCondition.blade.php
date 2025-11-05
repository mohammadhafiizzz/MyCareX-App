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

        @php
            $totalConditions = $conditions->count();
            $severeConditions = $conditions->where('severity', 'Severe')->count();
            $activeConditions = $conditions->whereIn('status', ['Active', 'Chronic'])->count();
            $resolvedConditions = $conditions->where('status', 'Resolved')->count();
            $lastUpdatedCondition = $conditions->sortByDesc(function ($condition) {
                return $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
            })->first();
            $lastUpdatedAt = $lastUpdatedCondition ? ($lastUpdatedCondition->updated_at ?? $lastUpdatedCondition->diagnosis_date ?? $lastUpdatedCondition->created_at) : null;
            $lastUpdatedLabel = $lastUpdatedAt ? \Illuminate\Support\Carbon::parse($lastUpdatedAt)->format('M d, Y') : 'Not recorded';
            $severityOptions = ['All', 'Severe', 'Moderate', 'Mild'];
            $statusOptions = ['All', 'Active', 'Chronic', 'Resolved'];
            $severityFilterColors = [
                'Severe' => 'text-red-500',
                'Moderate' => 'text-amber-500',
                'Mild' => 'text-green-500',
                'All' => 'text-blue-500',
            ];
            $statusFilterIcons = [
                'Active' => 'fa-circle-dot text-red-500',
                'Chronic' => 'fa-clock text-amber-500',
                'Resolved' => 'fa-check-circle text-green-500',
                'All' => 'fa-layer-group text-blue-500',
            ];
        @endphp

        {{-- <!-- Summary Dashboard 
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8" aria-label="Conditions summary cards">
            <article class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/15 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-12 mb-4"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Total Conditions</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalConditions }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Keep your record updated for better insights across your care team.</p>
                    <button
                        type="button"
                        onclick="document.getElementById('show-add-condition-modal')?.click()"
                        class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-600 transition" aria-label="Add a new medical condition">
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        Add condition
                    </button>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-rose-600 to-pink-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/15 rounded-full -mr-6 -mt-6"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/85">High Priority</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $severeConditions }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Check in on severe conditions and follow up with your care provider.</p>
                    <a href="#conditions-list" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-rose-600 transition" aria-label="Jump to severe conditions list">
                        <i class="fas fa-clipboard-list" aria-hidden="true"></i>
                        Review severe cases
                    </a>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-400 text-gray-900 rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/25 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-amber-900/80">Ongoing Care</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $activeConditions }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/40 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-amber-900/80">Track current treatments and log follow-ups to stay on schedule.</p>
                    <button type="button" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/40 rounded-lg border border-white/60 hover:bg-white/55 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-700/50 transition" aria-label="Add follow-up note">
                        <i class="fas fa-notes-medical" aria-hidden="true"></i>
                        Add follow-up
                    </button>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Last Updated</p>
                            <p class="text-2xl font-semibold mt-2" aria-live="polite">{{ $lastUpdatedLabel }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-history text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Resolved conditions: <span class="font-semibold">{{ $resolvedConditions }}</span></p>
                    <a href="#conditions-timeline" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-500 transition" aria-label="View medical history timeline">
                        <i class="fas fa-stream" aria-hidden="true"></i>
                        View timeline
                    </a>
                </div>
            </article>
        </section>
        --> --}}

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
                            Add condition
                        </button>
                        <button type="button" class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300 focus-visible:ring-offset-2">
                            <i class="fas fa-file-download" aria-hidden="true"></i>
                            Download report
                        </button>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Severity</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($severityOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-300 text-blue-700' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
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
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-300 text-blue-700' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
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
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share summary
                        </button>
                    </div>
                </div>
            </div>
        </section>

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
                    @php
                        $severityBorderClass = match ($condition->severity) {
                            'Severe' => 'bg-red-500',
                            'Moderate' => 'bg-amber-500',
                            'Mild' => 'bg-green-500',
                            default => 'bg-gray-300',
                        };

                        $severityIconWrapper = match ($condition->severity) {
                            'Severe' => 'bg-red-100 text-red-600',
                            'Moderate' => 'bg-amber-100 text-amber-600',
                            'Mild' => 'bg-green-100 text-green-600',
                            default => 'bg-gray-100 text-gray-500',
                        };

                        $severityBadgeStyles = match ($condition->severity) {
                            'Severe' => 'bg-red-50 text-red-700 border border-red-200',
                            'Moderate' => 'bg-amber-50 text-amber-700 border border-amber-200',
                            'Mild' => 'bg-green-50 text-green-700 border border-green-200',
                            default => 'bg-gray-50 text-gray-600 border border-gray-200',
                        };

                        $severityBadgeIcon = match ($condition->severity) {
                            'Severe' => 'fas fa-exclamation-triangle',
                            'Moderate' => 'fas fa-info-circle',
                            'Mild' => 'fas fa-shield-check',
                            default => 'fas fa-circle',
                        };

                        $statusBadgeStyles = match ($condition->status) {
                            'Active' => 'bg-red-100 text-red-700 border border-red-200',
                            'Chronic' => 'bg-amber-100 text-amber-700 border border-amber-200',
                            'Resolved' => 'bg-green-100 text-green-700 border border-green-200',
                            default => 'bg-gray-100 text-gray-600 border border-gray-200',
                        };

                        $statusIcon = match ($condition->status) {
                            'Active' => 'fas fa-circle-dot',
                            'Chronic' => 'fas fa-clock',
                            'Resolved' => 'fas fa-check-circle',
                            default => 'fas fa-circle',
                        };

                        $conditionLastUpdated = $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
                        $conditionLastUpdatedLabel = $conditionLastUpdated ? \Illuminate\Support\Carbon::parse($conditionLastUpdated)->diffForHumans() : 'No recent updates';
                        $conditionDiagnosisLabel = $condition->diagnosis_date ? \Illuminate\Support\Carbon::parse($condition->diagnosis_date)->format('M d, Y') : 'Not recorded';
                        $conditionSeverityData = \Illuminate\Support\Str::lower($condition->severity ?? 'unknown');
                        $conditionStatusData = \Illuminate\Support\Str::lower($condition->status ?? 'unknown');
                    @endphp

                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-severity="{{ $conditionSeverityData }}" data-status="{{ $conditionStatusData }}">
                        <span class="absolute inset-y-0 left-0 w-1 {{ $severityBorderClass }}" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $severityIconWrapper }} flex-shrink-0">
                                        <i class="fas fa-heartbeat text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $condition->condition_name }}</h3>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span>
                                                Diagnosed <span class="sr-only">on</span> {{ $conditionDiagnosisLabel }}
                                            </span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>
                                                Last updated <span class="sr-only">relative time</span> {{ $conditionLastUpdatedLabel }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if ($condition->description)
                                    <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                        {{ $condition->description }}
                                    </p>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $severityBadgeStyles }}" role="status">
                                        <span class="sr-only">Severity:</span>
                                        <i class="{{ $severityBadgeIcon }}" aria-hidden="true"></i>
                                        {{ $condition->severity ?? 'Undefined' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgeStyles }}" role="status">
                                        <span class="sr-only">Status:</span>
                                        <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                        {{ $condition->status ?? 'Not set' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <a href="#" class="edit-condition-btn inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2" data-id="{{ $condition->id }}">
                                    <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                    Edit
                                </a>
                                <a href="{{ route('patient.condition.info', $condition->id) }}" class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
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

                        <button type="button" onclick="document.getElementById('show-add-condition-modal')?.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg text-base font-semibold hover:bg-blue-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first condition
                        </button>
                    </div>
                @endforelse
            </div>
        </section>

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
                            @foreach ($conditions->sortByDesc(function ($condition) {
                                return $condition->updated_at ?? $condition->diagnosis_date ?? $condition->created_at;
                            })->take(6) as $timelineCondition)
                                @php
                                    $timelineSeverityBorder = match ($timelineCondition->severity) {
                                        'Severe' => 'bg-red-500',
                                        'Moderate' => 'bg-amber-500',
                                        'Mild' => 'bg-green-500',
                                        default => 'bg-gray-300',
                                    };
                                    $timelineSeverityIcon = match ($timelineCondition->severity) {
                                        'Severe' => 'text-red-600',
                                        'Moderate' => 'text-amber-600',
                                        'Mild' => 'text-green-600',
                                        default => 'text-gray-500',
                                    };
                                    $timelineStatusBadge = match ($timelineCondition->status) {
                                        'Active' => 'bg-red-50 text-red-700 border border-red-200',
                                        'Chronic' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'Resolved' => 'bg-green-50 text-green-700 border border-green-200',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $timelineDate = $timelineCondition->updated_at ?? $timelineCondition->diagnosis_date ?? $timelineCondition->created_at;
                                    $timelineDateLabel = $timelineDate ? \Illuminate\Support\Carbon::parse($timelineDate)->format('M d, Y') : 'Date unavailable';
                                @endphp
                                <div class="relative flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full border-4 border-white shadow flex items-center justify-center">
                                        <span class="w-3 h-3 rounded-full {{ $timelineSeverityBorder }}" aria-hidden="true"></span>
                                    </div>
                                    <div class="flex-1 bg-gray-50 rounded-xl border border-gray-200 p-5">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-heartbeat {{ $timelineSeverityIcon }}" aria-hidden="true"></i>
                                                <h3 class="text-base font-semibold text-gray-900">{{ $timelineCondition->condition_name }}</h3>
                                            </div>
                                            <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                                                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                                {{ $timelineDateLabel }}
                                            </span>
                                        </div>
                                        @if ($timelineCondition->description)
                                            <p class="mt-3 text-sm text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($timelineCondition->description, 160, '…') }}
                                            </p>
                                        @endif
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $timelineStatusBadge }}" role="status">
                                                <span class="sr-only">Status:</span>
                                                {{ $timelineCondition->status ?? 'Not set' }}
                                            </span>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 text-gray-600 bg-white" role="status">
                                                <span class="sr-only">Severity:</span>
                                                {{ $timelineCondition->severity ?? 'Undefined' }}
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

    <!-- Edit Condition Form -->
    @include('patient.modules.medicalCondition.editConditionForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medicalCondition/addConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/editConditionForm.js'])
    @vite(['resources/js/main/medicalCondition/conditionFilter.js'])
    @include('patient.components.footer')

</body>
</html>
