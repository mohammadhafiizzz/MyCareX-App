<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - My Records</title>
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

        @include('patient.components.recordNav')

        {{-- Health Stats Dashboard --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8" aria-label="Health statistics summary cards">
            
            {{-- Conditions Stats Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-blue-600 to-blue-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/15 rounded-full -mr-10 -mt-10"></div>
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-12 mb-4"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Active Conditions</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">{{ $conditions->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical-alt text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">
                        @if($conditions->where('severity', 'Severe')->count() > 0)
                            {{ $conditions->where('severity', 'Severe')->count() }} conditions need immediate attention
                        @else
                            All conditions are being monitored appropriately
                        @endif
                    </p>
                    <a href="#conditions-list" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-blue-600 transition" aria-label="View all conditions">
                        <i class="fas fa-list" aria-hidden="true"></i>
                        View details
                    </a>
                </div>
            </article>

            {{-- Medications Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-purple-600 to-purple-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-16 h-16 bg-white/15 rounded-full -mr-6 -mt-6"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/85">Current Medications</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">8</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Stay on schedule with your prescriptions and refills.</p>
                    <button type="button" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-purple-600 transition" aria-label="View medication schedule">
                        <i class="fas fa-bell" aria-hidden="true"></i>
                        2 due today
                    </button>
                </div>
            </article>

            {{-- Lab Results Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-green-600 to-green-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/25 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Lab Results</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">4</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">All results within normal range. Keep tracking your health metrics.</p>
                    <a href="#lab-results" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-green-600 transition" aria-label="View lab results history">
                        <i class="fas fa-chart-line" aria-hidden="true"></i>
                        View history
                    </a>
                </div>
            </article>

            {{-- Allergies Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-red-600 to-red-500 text-white rounded-xl p-6 shadow-md">
                <div class="absolute top-0 right-0 w-20 h-20 bg-white/15 rounded-full -mr-8 -mt-8"></div>
                <div class="relative flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/80">Active Allergies</p>
                            <p class="text-4xl font-bold mt-2" aria-live="polite">3</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    <p class="text-xs text-white/80">Severe reactions: <span class="font-semibold">2</span>. Always inform your healthcare providers.</p>
                    <button type="button" class="inline-flex items-center gap-2 self-start px-4 py-2 text-sm font-semibold bg-white/15 rounded-lg border border-white/25 hover:bg-white/25 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-red-600 transition" aria-label="Manage allergy information">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                        Manage allergies
                    </button>
                </div>
            </article>
        </section>

        <div class="space-y-6">

            {{-- Recent Medical Conditions - Card Layout --}}
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="condition-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 id="condition-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-heartbeat text-blue-600"></i>
                            Recent Medical Conditions
                        </h2>
                        <a href="{{ route('patient.medicalCondition') }}" 
                           aria-label="View all medical conditions"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            View all <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    @forelse ($conditions as $condition)
                        <div class="group relative bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 mb-4 hover:shadow-md transition-all duration-200 hover:border-blue-300">
                            {{-- Severity Indicator Bar --}}
                            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-xl 
                                {{ $condition->severity === 'Severe' ? 'bg-red-500' : 
                                   ($condition->severity === 'Moderate' ? 'bg-yellow-500' : 'bg-green-500') }}">
                            </div>

                            <div class="flex items-start justify-between">
                                <div class="flex-1 ml-4">
                                    {{-- Condition Icon + Name --}}
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-heartbeat text-blue-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                {{ $condition->condition_name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                <i class="far fa-calendar mr-1"></i>
                                                Diagnosed: {{ $condition->diagnosis_date ? $condition->diagnosis_date->format('M d, Y') : 'N/A' }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Description --}}
                                    @if($condition->description)
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                            {{ $condition->description }}
                                        </p>
                                    @endif

                                    {{-- Status & Severity Badges --}}
                                    <div class="flex flex-wrap gap-2">
                                        {{-- Status Badge --}}
                                        @switch($condition->status)
                                            @case('Active')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                                    <i class="fas fa-circle-dot"></i> Active
                                                </span>
                                                @break
                                            @case('Chronic')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                    <i class="fas fa-clock"></i> Chronic
                                                </span>
                                                @break
                                            @case('Resolved')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                                    <i class="fas fa-check-circle"></i> Resolved
                                                </span>
                                                @break
                                        @endswitch

                                        {{-- Severity Badge --}}
                                        @switch($condition->severity)
                                            @case('Severe')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                                    <i class="fas fa-exclamation-triangle"></i> High Risk
                                                </span>
                                                @break
                                            @case('Moderate')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                    <i class="fas fa-info-circle"></i> Moderate
                                                </span>
                                                @break
                                            @case('Mild')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                    <i class="fas fa-heart-circle-check"></i> Mild
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                </div>

                                {{-- Quick Action --}}
                                <div class="ml-4">
                                    <a href="{{ route('patient.medicalCondition') }}" 
                                       class="text-gray-400 hover:text-blue-600 transition-colors">
                                        <i class="fas fa-chevron-right text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State with Illustration --}}
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

                            <a href="{{ route('patient.medicalCondition') }}" 
                               class="inline-flex items-center gap-3 px-6 py-3 bg-blue-600 text-white rounded-lg text-base font-semibold hover:bg-blue-700 shadow-lg hover:shadow-xl focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition">
                                <i class="fas fa-plus-circle"></i>
                                Add Your First Condition
                            </a>
                    </div>
                    @endforelse
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="meds-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="meds-heading" class="text-xl font-semibold text-gray-900">
                            Current Medications
                        </h2>
                        <a href="{{ route('patient.medication') }}" 
                           aria-label="Manage medications"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            Manage
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        {{-- Desktop Table View --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Medication</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dosage</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Frequency</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Medication Name</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Dosage</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Frequency</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-600">Notes</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile List View --}}
                        <div class="md:hidden space-y-3">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-semibold text-gray-900 text-base">Medication Name</h3>
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                </div>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Dosage:</dt>
                                        <dd class="text-gray-900 font-medium">Dosage</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Frequency:</dt>
                                        <dd class="text-gray-900 font-medium">Frequency</dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-600 mb-1">Notes:</dt>
                                        <dd class="text-gray-900">Notes</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="labs-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="labs-heading" class="text-xl font-semibold text-gray-900">
                            Recent Lab Results
                        </h2>
                        <a href="#" 
                           aria-label="View all lab results"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            View all
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        {{-- Desktop Table View --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Test Name</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Complete Blood Count (CBC)</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Action Required</span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Oct 18, 2025</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Lipid Panel</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">In Range</span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Oct 18, 2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile List View --}}
                        <div class="md:hidden space-y-3">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-semibold text-gray-900 text-base">Complete Blood Count (CBC)</h3>
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Action Required</span>
                                </div>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Date:</dt>
                                        <dd class="text-gray-900 font-medium">Oct 18, 2025</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-semibold text-gray-900 text-base">Lipid Panel</h3>
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">In Range</span>
                                </div>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Date:</dt>
                                        <dd class="text-gray-900 font-medium">Oct 18, 2025</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="vax-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="vax-heading" class="text-xl font-semibold text-gray-900">
                            Recent Vaccinations
                        </h2>
                        <a href="#" 
                           aria-label="View all vaccinations"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            View all
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        {{-- Desktop Table View --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Vaccine</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dose</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">COVID-19 (Moderna)</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Booster</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Sep 30, 2025</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Influenza (Flu Shot)</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Annual</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Sep 30, 2025</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile List View --}}
                        <div class="md:hidden space-y-3">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-base mb-3">COVID-19 (Moderna)</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Dose:</dt>
                                        <dd class="text-gray-900 font-medium">Booster</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Date:</dt>
                                        <dd class="text-gray-900 font-medium">Sep 30, 2025</dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-base mb-3">Influenza (Flu Shot)</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Dose:</dt>
                                        <dd class="text-gray-900 font-medium">Annual</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Date:</dt>
                                        <dd class="text-gray-900 font-medium">Sep 30, 2025</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="allergy-heading">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h2 id="allergy-heading" class="text-xl font-semibold text-gray-900">
                            Active Allergies
                        </h2>
                        <a href="#" 
                           aria-label="Manage allergies"
                           class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            Manage
                        </a>
                    </div>
                    <div class="mt-4 flow-root">
                        {{-- Desktop Table View --}}
                        <div class="hidden md:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Allergen</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Reaction</th>
                                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Severity</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Penicillin</td>
                                        <td class="px-4 py-4 text-sm text-gray-600">Anaphylaxis</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center font-medium text-red-700" role="status">
                                                <i class="fas fa-circle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">High severity:</span>
                                                Severe
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Peanuts</td>
                                        <td class="px-4 py-4 text-sm text-gray-600">Hives, Swelling</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center font-medium text-red-700" role="status">
                                                <i class="fas fa-circle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">High severity:</span>
                                                Severe
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">Pollen</td>
                                        <td class="px-4 py-4 text-sm text-gray-600">Itchy Eyes, Sneezing</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="inline-flex items-center font-medium text-yellow-700" role="status">
                                                <i class="fas fa-triangle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">Medium severity:</span>
                                                Moderate
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile List View --}}
                        <div class="md:hidden space-y-3">
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-base mb-3">Penicillin</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Reaction:</dt>
                                        <dd class="text-gray-900 font-medium">Anaphylaxis</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Severity:</dt>
                                        <dd>
                                            <span class="inline-flex items-center font-medium text-red-700" role="status">
                                                <i class="fas fa-circle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">High severity:</span>
                                                Severe
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-base mb-3">Peanuts</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Reaction:</dt>
                                        <dd class="text-gray-900 font-medium">Hives, Swelling</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Severity:</dt>
                                        <dd>
                                            <span class="inline-flex items-center font-medium text-red-700" role="status">
                                                <i class="fas fa-circle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">High severity:</span>
                                                Severe
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 text-base mb-3">Pollen</h3>
                                <dl class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Reaction:</dt>
                                        <dd class="text-gray-900 font-medium">Itchy Eyes, Sneezing</dd>
                                    </div>
                                    <div class="flex justify-between">
                                        <dt class="text-gray-600">Severity:</dt>
                                        <dd>
                                            <span class="inline-flex items-center font-medium text-yellow-700" role="status">
                                                <i class="fas fa-triangle-exclamation mr-1.5" aria-hidden="true"></i>
                                                <span class="sr-only">Medium severity:</span>
                                                Moderate
                                            </span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>

    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>