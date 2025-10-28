<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medication</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Medications
            </h1>
            <p class="mt-1 text-lg text-gray-700">A complete record of your medications.</p>
        </div>

        {{-- Success Message --}}
        @if (session('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        @include('patient.components.recordNav')

        @php
            $today = \Illuminate\Support\Carbon::today();
            $totalMedications = $medications->count();
            $activeMedications = $medications->where('status', 'Active')->count();
            $refillWindowEnd = $today->copy()->addDays(7);
            $upcomingRefills = $medications->filter(function ($med) use ($today, $refillWindowEnd) {
                return $med->end_date && $med->end_date->between($today, $refillWindowEnd, true);
            })->count();
            $dailyMedications = $medications->filter(function ($med) {
                $frequency = strtolower($med->frequency ?? '');
                return \Illuminate\Support\Str::contains($frequency, 'day');
            })->count();
            $lastUpdatedMedication = $medications->sortByDesc(function ($med) {
                return $med->updated_at ?? $med->start_date ?? $med->created_at;
            })->first();
            $lastUpdatedLabel = $lastUpdatedMedication ? \Illuminate\Support\Carbon::parse($lastUpdatedMedication->updated_at ?? $lastUpdatedMedication->start_date ?? $lastUpdatedMedication->created_at)->format('M d, Y') : 'Not recorded';
            $statusOptions = $medications->pluck('status')->filter()->unique()->values()->all();
            if (empty($statusOptions)) {
                $statusOptions = ['Active', 'On Hold', 'Completed'];
            }
            array_unshift($statusOptions, 'All');
            $frequencyOptions = $medications->pluck('frequency')->filter()->map(function ($freq) {
                return \Illuminate\Support\Str::title($freq);
            })->unique()->values()->all();
            if (empty($frequencyOptions)) {
                $frequencyOptions = ['Daily', 'Weekly', 'As Needed'];
            }
            array_unshift($frequencyOptions, 'All');
            $statusFilterStyles = [
                'Active' => 'fa-circle-dot text-emerald-500',
                'On Hold' => 'fa-pause-circle text-amber-500',
                'Completed' => 'fa-check-circle text-blue-500',
                'Discontinued' => 'fa-ban text-red-500',
                'All' => 'fa-layer-group text-gray-500'
            ];
            $frequencyFilterStyles = [
                'Daily' => 'text-blue-500',
                'Weekly' => 'text-purple-500',
                'Monthly' => 'text-indigo-500',
                'As Needed' => 'text-amber-500',
                'All' => 'text-gray-500'
            ];
        @endphp

        {{-- Summary Dashboard --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8" aria-label="Medication summary cards">
            <article class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/15 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-12 mb-4"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Total Medications</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $totalMedications }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Keep your medications list current for accurate reminders and safe care coordination.</p>
                    <button
                        type="button"
                        onclick="document.getElementById('show-add-medication-modal')?.click()"
                        class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-600 transition"
                        aria-label="Add a new medication">
                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                        Add medication
                    </button>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Active Medications</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $activeMedications }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-heartbeat text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Log doses to stay on track and share updates with your care provider.</p>
                    <button type="button" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-emerald-500 transition" aria-label="Log medication dose">
                        <i class="fas fa-clipboard-check" aria-hidden="true"></i>
                        Log a dose
                    </button>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-400 text-gray-900 rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/25 rounded-full -mr-6 -mt-6"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-amber-900/80">Refill Soon</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $upcomingRefills }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/40 rounded-lg flex items-center justify-center">
                            <i class="fas fa-prescription-bottle text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-amber-900/80">Schedule refills at least a week ahead to avoid gaps in treatment.</p>
                    <button type="button" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/40 rounded-lg border border-white/60 hover:bg-white/55 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-700/50 transition" aria-label="Set a refill reminder">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        Set reminder
                    </button>
                </div>
            </article>

            <article class="relative overflow-hidden bg-gradient-to-br from-purple-600 to-indigo-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Daily Routine</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $dailyMedications }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-sun text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Check your morning and evening routines to stay consistent.</p>
                    <a href="#medications-list" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-purple-600 transition" aria-label="Jump to medication list">
                        <i class="fas fa-list-check" aria-hidden="true"></i>
                        Review schedule
                    </a>
                </div>
            </article>
        </section>

        {{-- Filters & Quick Actions --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="medications-controls-heading">
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 id="medications-controls-heading" class="text-xl font-semibold text-gray-900">Manage Medications</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter by status or schedule and stay ahead of upcoming doses or refills.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button 
                            type="button" 
                            id="show-add-medication-modal"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add medication
                        </button>
                        <button type="button" class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300 focus-visible:ring-offset-2">
                            <i class="fas fa-file-export" aria-hidden="true"></i>
                            Export list
                        </button>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Status</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($statusOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-300 text-blue-700' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                                    <i class="fas {{ $statusFilterStyles[$option] ?? 'fa-circle text-gray-500' }}" aria-hidden="true"></i>
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Frequency</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($frequencyOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-300 text-blue-700' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                                    <i class="fas fa-clock text-xs {{ $frequencyFilterStyles[$option] ?? 'text-gray-500' }}" aria-hidden="true"></i>
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fas fa-lightbulb text-amber-400" aria-hidden="true"></i>
                        <span>Tip: Mark a medication as completed when treatment ends to keep active reminders clean.</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-sm font-medium hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                            <i class="fas fa-bell" aria-hidden="true"></i>
                            Set daily reminder
                        </button>
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share with caregiver
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Medications List --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="medications-heading">
            <div class="p-6" id="medications-list">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="medications-heading" class="text-xl font-semibold text-gray-900">Medication Schedule</h2>
                        <p class="mt-1 text-sm text-gray-600">Review dosage, timing, and status for each medication in one glance.</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500" aria-hidden="true"></i>
                        <span>Sorted by most recent updates</span>
                    </div>
                </div>

                @forelse ($medications as $medication)
                    @php
                        $status = $medication->status ?? 'Not set';
                        $statusBadgeStyles = match ($status) {
                            'Active' => 'bg-emerald-100 text-emerald-700 border border-emerald-200',
                            'On Hold' => 'bg-amber-100 text-amber-700 border border-amber-200',
                            'Completed' => 'bg-blue-100 text-blue-700 border border-blue-200',
                            'Discontinued' => 'bg-red-100 text-red-700 border border-red-200',
                            default => 'bg-gray-100 text-gray-600 border border-gray-200',
                        };
                        $statusIcon = match ($status) {
                            'Active' => 'fas fa-circle-dot',
                            'On Hold' => 'fas fa-pause-circle',
                            'Completed' => 'fas fa-check-circle',
                            'Discontinued' => 'fas fa-ban',
                            default => 'fas fa-circle',
                        };
                        $frequency = $medication->frequency ? \Illuminate\Support\Str::title($medication->frequency) : 'Not specified';
                        $dosage = $medication->dosage ?? 'No dosage recorded';
                        $notes = $medication->notes ?? 'No notes added yet.';
                        $startDateLabel = $medication->start_date ? $medication->start_date->format('M d, Y') : 'Not scheduled';
                        $endDateLabel = $medication->end_date ? $medication->end_date->format('M d, Y') : 'No end date';
                        $lastUpdated = $medication->updated_at ?? $medication->start_date ?? $medication->created_at;
                        $lastUpdatedLabel = $lastUpdated ? \Illuminate\Support\Carbon::parse($lastUpdated)->diffForHumans() : 'No recent updates';
                        $refillDueSoon = $medication->end_date && $medication->end_date->between($today, $today->copy()->addDays(7), true);
                        $dataStatus = \Illuminate\Support\Str::slug(strtolower($status));
                        $dataFrequency = \Illuminate\Support\Str::slug(strtolower($medication->frequency ?? 'unknown'));
                    @endphp

                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-status="{{ $dataStatus }}" data-frequency="{{ $dataFrequency }}">
                        <span class="absolute inset-y-0 left-0 w-1 {{ $refillDueSoon ? 'bg-amber-500' : 'bg-blue-500' }}" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex-shrink-0">
                                        <i class="fas fa-capsules text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $medication->medication_name }}</h3>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-prescription" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Dosage:</strong> {{ $dosage }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="fas fa-clock" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Frequency:</strong> {{ $frequency }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span><strong class="text-gray-800">Start:</strong> {{ $startDateLabel }} &bull; <strong class="text-gray-800">End:</strong> {{ $endDateLabel }}</span>
                                        </p>
                                        <p class="mt-2 text-sm text-gray-500 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>Last updated {{ $lastUpdatedLabel }}</span>
                                        </p>
                                    </div>
                                </div>

                                @if ($notes)
                                    <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                        {{ $notes }}
                                    </p>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusBadgeStyles }}" role="status">
                                        <span class="sr-only">Status:</span>
                                        <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                        {{ $status }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200" role="status">
                                        <span class="sr-only">Frequency:</span>
                                        <i class="fas fa-clock" aria-hidden="true"></i>
                                        {{ $frequency }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200" role="status">
                                        <span class="sr-only">Refill status:</span>
                                        <i class="fas {{ $refillDueSoon ? 'fa-hourglass-half text-amber-500' : 'fa-check text-emerald-500' }}" aria-hidden="true"></i>
                                        {{ $refillDueSoon ? 'Refill soon' : 'Refill on track' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <button type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                                    <i class="fas fa-notes-medical" aria-hidden="true"></i>
                                    Log dose
                                </button>
                                <button type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                    <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                                    Edit medication
                                </button>
                                <button type="button" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                                    <i class="fas fa-bell" aria-hidden="true"></i>
                                    Reminder options
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-16">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-gradient-to-br from-blue-100 via-teal-100 to-indigo-100 rounded-full flex items-center justify-center animate-pulse">
                                <i class="fas fa-pills text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                            <div class="absolute -top-3 -right-3 w-10 h-10 bg-emerald-400 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                <i class="fas fa-plus text-white text-lg" aria-hidden="true"></i>
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

                        <button type="button" onclick="document.getElementById('show-add-medication-modal')?.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-blue-600 to-teal-600 text-white rounded-xl text-base font-semibold hover:from-blue-700 hover:to-teal-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first medication
                        </button>
                    </div>
                @endforelse
            </div>
        </section>

        @if ($totalMedications > 0)
            {{-- Timeline View --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" id="medication-timeline" aria-labelledby="medications-timeline-heading">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 id="medications-timeline-heading" class="text-xl font-semibold text-gray-900">Medication Timeline</h2>
                            <p class="mt-1 text-sm text-gray-600">See when treatments started or changed to understand your progress.</p>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-stream text-blue-500" aria-hidden="true"></i>
                            <span>Showing latest 6 updates</span>
                        </div>
                    </div>

                    <div class="relative mt-6">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200" aria-hidden="true"></div>
                        <div class="space-y-6">
                            @foreach ($medications->sortByDesc(function ($med) {
                                return $med->updated_at ?? $med->start_date ?? $med->created_at;
                            })->take(6) as $timelineMedication)
                                @php
                                    $timelineStatus = $timelineMedication->status ?? 'Not set';
                                    $timelineStatusBadge = match ($timelineStatus) {
                                        'Active' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                        'On Hold' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'Completed' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                        'Discontinued' => 'bg-red-50 text-red-700 border border-red-200',
                                        default => 'bg-gray-50 text-gray-600 border border-gray-200',
                                    };
                                    $timelineDate = $timelineMedication->updated_at ?? $timelineMedication->start_date ?? $timelineMedication->created_at;
                                    $timelineDateLabel = $timelineDate ? \Illuminate\Support\Carbon::parse($timelineDate)->format('M d, Y') : 'Date unavailable';
                                    $timelineFrequency = $timelineMedication->frequency ? \Illuminate\Support\Str::title($timelineMedication->frequency) : 'Not specified';
                                @endphp
                                <div class="relative flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full border-4 border-white shadow flex items-center justify-center">
                                        <span class="w-3 h-3 rounded-full bg-blue-500" aria-hidden="true"></span>
                                    </div>
                                    <div class="flex-1 bg-gray-50 rounded-xl border border-gray-200 p-5">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-capsules text-blue-500" aria-hidden="true"></i>
                                                <h3 class="text-base font-semibold text-gray-900">{{ $timelineMedication->medication_name }}</h3>
                                            </div>
                                            <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                                                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                                {{ $timelineDateLabel }}
                                            </span>
                                        </div>
                                        @if ($timelineMedication->notes)
                                            <p class="mt-3 text-sm text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($timelineMedication->notes, 160, '…') }}
                                            </p>
                                        @endif
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $timelineStatusBadge }}" role="status">
                                                <span class="sr-only">Status:</span>
                                                {{ $timelineStatus }}
                                            </span>
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 text-gray-600 bg-white" role="status">
                                                <span class="sr-only">Frequency:</span>
                                                {{ $timelineFrequency }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="#medications-list" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            Back to medication list
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>