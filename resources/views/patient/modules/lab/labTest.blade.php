<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Lab Tests</title>
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

        {{-- Filters & Quick Actions --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="lab-tests-controls-heading">
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 id="lab-tests-controls-heading" class="text-xl font-semibold text-gray-900">Manage Lab Tests</h2>
                        <p class="mt-1 text-sm text-gray-600">Filter and organise your laboratory test records for easy access and sharing.</p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <button 
                            type="button" 
                            id="show-add-test-modal"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <i class="fas fa-plus" aria-hidden="true"></i>
                            Add New
                        </button>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">Verification Status</h3>
                        <div class="mt-2 flex flex-wrap gap-2" role="list">
                            @foreach ($verificationOptions as $option)
                                <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border {{ $loop->first ? 'bg-blue-50 border-blue-300 text-blue-700' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }} text-sm font-medium transition" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                                    <i class="fas {{ $verificationFilterIcons[$option] ?? 'fa-circle text-blue-500' }}" aria-hidden="true"></i>
                                    {{ $option }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="flex items-center gap-3 text-sm text-gray-600">
                        <i class="fas fa-filter text-blue-500" aria-hidden="true"></i>
                        <span>Tip: Keep your lab test records current for accurate health tracking.</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" id="reset-all-filters" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-lg border border-blue-200 text-sm font-medium hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            Reset filters
                        </button>
                        <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share
                        </button>
                    </div>
                </div>
            </div>
        </section>

        {{-- Lab Tests List --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="lab-tests-heading">
            <div class="p-6" id="lab-tests-list">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="lab-tests-heading" class="text-xl font-semibold text-gray-900">Lab Test Records</h2>
                        <p class="mt-1 text-sm text-gray-600">View test details, dates, and verification status at a glance.</p>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle text-blue-500" aria-hidden="true"></i>
                        <span>Sorted by most recent activity</span>
                    </div>
                </div>

                @forelse ($labTests as $labTest)
                    <article class="group relative overflow-hidden border border-gray-200 rounded-2xl p-6 mb-5 shadow-sm hover:shadow-md transition" data-verification="{{ $labTest['verificationData'] }}">
                        <span class="absolute inset-y-0 left-0 w-1 bg-blue-500" aria-hidden="true"></span>
                        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                            <div class="flex-1">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 text-blue-500 flex-shrink-0">
                                        <i class="fas fa-flask text-xl" aria-hidden="true"></i>
                                    </div>
                                    <div class="mt-4 sm:mt-0">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $labTest['data']->test_name }}</h3>
                                        @if ($labTest['data']->test_category)
                                            <p class="mt-1 text-sm text-gray-600">{{ $labTest['data']->test_category }}</p>
                                        @endif
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                            <span>
                                                Test conducted on <span class="sr-only">date</span> {{ $labTest['testLabel'] }}
                                            </span>
                                        </p>
                                        @if ($labTest['data']->facility_name)
                                            <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                                <i class="fas fa-hospital" aria-hidden="true"></i>
                                                <span>
                                                    Facility: {{ $labTest['data']->facility_name }}
                                                </span>
                                            </p>
                                        @endif
                                        <p class="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                            <i class="far fa-clock" aria-hidden="true"></i>
                                            <span>
                                                Last updated <span class="sr-only">relative time</span> {{ $labTest['lastUpdatedLabel'] }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if ($labTest['data']->notes)
                                    <p class="mt-4 text-sm text-gray-700 leading-relaxed">
                                        {{ $labTest['data']->notes }}
                                    </p>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $labTest['verificationBadgeStyles'] }}" role="status">
                                        <span class="sr-only">Verification:</span>
                                        <i class="{{ $labTest['verificationIcon'] }}" aria-hidden="true"></i>
                                        {{ $labTest['data']->verification_status ?? 'Unverified' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200" role="status">
                                        <span class="sr-only">Attachment:</span>
                                        <i class="fas fa-file-pdf" aria-hidden="true"></i>
                                        Attachment Available
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-stretch gap-2">
                                <a href="{{ route('patient.lab.info', $labTest['data']->id) }}" class="inline-flex gap-2 items-center justify-center px-4 py-2 bg-white text-gray-700 rounded-lg border border-gray-200 text-sm font-medium hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
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
                                <i class="fas fa-flask text-blue-600 text-5xl" aria-hidden="true"></i>
                            </div>
                            
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No lab tests tracked yet</h3>
                        <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                            Keep your laboratory test records organized to track your health progress and share results with healthcare providers.
                        </p>

                        <div class="max-w-lg mx-auto mb-8 text-left bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-lightbulb text-yellow-500" aria-hidden="true"></i>
                                Why track lab tests?
                            </h4>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Monitor your health trends with historical test results.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Share verified records with healthcare providers quickly and easily.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                                    <span>Keep all your medical documentation in one secure place.</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-info-circle text-blue-600 mt-0.5" aria-hidden="true"></i>
                                    <span><strong>Note:</strong> Test result attachment (PDF) is required when adding a lab test.</span>
                                </li>
                            </ul>
                        </div>

                        <button type="button" onclick="document.getElementById('show-add-test-modal')?.click()" class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg text-base font-semibold hover:bg-blue-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                            <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            Add your first lab test
                        </button>
                    </div>
                @endforelse
            </div>
        </section>

        @if ($totalLabTests > 0)
            {{-- Timeline View --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" id="lab-tests-timeline" aria-labelledby="lab-tests-timeline-heading">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                        <div>
                            <h2 id="lab-tests-timeline-heading" class="text-xl font-semibold text-gray-900">Lab Test Timeline</h2>
                            <p class="mt-1 text-sm text-gray-600">Review lab test history in chronological order to track your health progress.</p>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i class="fas fa-stream text-blue-500" aria-hidden="true"></i>
                            <span>Showing latest 6 updates</span>
                        </div>
                    </div>

                    <div class="relative mt-6">
                        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-200" aria-hidden="true"></div>
                        <div class="space-y-6">
                            @foreach ($timelineLabTests as $timelineLabTest)
                                <div class="relative flex gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-white rounded-full border-4 border-white shadow flex items-center justify-center">
                                        <span class="w-3 h-3 rounded-full {{ $timelineLabTest['verificationBorder'] }}" aria-hidden="true"></span>
                                    </div>
                                    <div class="flex-1 bg-gray-50 rounded-xl border border-gray-200 p-5">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-flask {{ $timelineLabTest['verificationIcon'] }}" aria-hidden="true"></i>
                                                <h3 class="text-base font-semibold text-gray-900">{{ $timelineLabTest['data']->test_name }}</h3>
                                            </div>
                                            <span class="inline-flex items-center gap-2 text-xs font-medium text-gray-500">
                                                <i class="far fa-calendar-alt" aria-hidden="true"></i>
                                                {{ $timelineLabTest['dateLabel'] }}
                                            </span>
                                        </div>
                                        @if ($timelineLabTest['data']->notes)
                                            <p class="mt-3 text-sm text-gray-600">
                                                {{ \Illuminate\Support\Str::limit($timelineLabTest['data']->notes, 160, '…') }}
                                            </p>
                                        @endif
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $timelineLabTest['verificationBadge'] }}" role="status">
                                                <span class="sr-only">Verification:</span>
                                                {{ $timelineLabTest['data']->verification_status ?? 'Unverified' }}
                                            </span>
                                            @if ($timelineLabTest['data']->test_category)
                                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold border border-gray-200 text-gray-600 bg-white" role="status">
                                                    <span class="sr-only">Category:</span>
                                                    {{ $timelineLabTest['data']->test_category }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="#lab-tests-list" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200 focus-visible:ring-offset-2">
                            <i class="fas fa-arrow-up" aria-hidden="true"></i>
                            Back to lab test list
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <!-- Add Test Form -->
    @include('patient.modules.lab.addTestForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/lab/addTestForm.js'])
    @vite(['resources/js/main/lab/editTest.js'])
    @vite(['resources/js/main/lab/labTestFilter.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')

</body>
</html>
