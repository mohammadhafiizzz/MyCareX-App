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

        {{-- Health Profile Completion --}}
        <section class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl shadow-sm border border-green-200 mb-6 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-trophy text-yellow-500"></i>
                            Health Profile Completion
                        </h2>
                        <p class="text-sm text-gray-600">Complete your profile for better health tracking</p>
                    </div>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-green-600">{{ $conditions->count() > 0 ? '68' : '25' }}%</span>
                    </div>
                </div>
                
                {{-- Progress Bar --}}
                <div class="w-full bg-gray-200 rounded-full h-3 mb-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-blue-500 h-3 rounded-full transition-all duration-500" 
                         style="width: {{ $conditions->count() > 0 ? '68' : '25' }}%"></div>
                </div>
                
                {{-- Next Steps --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">Basic Info Added</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg border {{ $conditions->count() > 0 ? 'border-gray-200' : 'border-blue-200 border-dashed' }}">
                        <div class="w-8 h-8 {{ $conditions->count() > 0 ? 'bg-green-100' : 'bg-blue-100' }} rounded-full flex items-center justify-center">
                            <i class="fas {{ $conditions->count() > 0 ? 'fa-check text-green-600' : 'fa-file-medical text-blue-600' }}"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700">{{ $conditions->count() > 0 ? 'Conditions Added' : 'Add medical conditions' }}</span>
                    </div>
                    <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 border-dashed">
                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-syringe text-gray-400"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Upload vaccination records</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Health Stats Dashboard --}}
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Conditions Stats Card --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                            <i class="fas fa-file-medical-alt text-2xl"></i>
                        </div>
                        <span class="text-4xl font-bold">{{ $conditions->count() }}</span>
                    </div>
                    <h3 class="text-sm font-medium opacity-90">Active Conditions</h3>
                    <p class="text-xs opacity-75 mt-1">
                        @if($conditions->where('severity', 'Severe')->count() > 0)
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $conditions->where('severity', 'Severe')->count() }} need attention
                        @else
                            <i class="fas fa-check-circle mr-1"></i>
                            All monitored
                        @endif
                    </p>
                </div>
            </div>

            {{-- Medications Card --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                            <i class="fas fa-pills text-2xl"></i>
                        </div>
                        <span class="text-4xl font-bold">8</span>
                    </div>
                    <h3 class="text-sm font-medium opacity-90">Current Medications</h3>
                    <p class="text-xs opacity-75 mt-1">
                        <i class="fas fa-bell mr-1"></i>
                        2 due today
                    </p>
                </div>
            </div>

            {{-- Lab Results Card --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-2xl"></i>
                        </div>
                        <span class="text-4xl font-bold">4</span>
                    </div>
                    <h3 class="text-sm font-medium opacity-90">Lab Results</h3>
                    <p class="text-xs opacity-75 mt-1">
                        <i class="fas fa-check-circle mr-1"></i>
                        All normal range
                    </p>
                </div>
            </div>

            {{-- Allergies Card --}}
            <div class="relative overflow-hidden bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-8 -mt-8"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-2xl"></i>
                        </div>
                        <span class="text-4xl font-bold">3</span>
                    </div>
                    <h3 class="text-sm font-medium opacity-90">Active Allergies</h3>
                    <p class="text-xs opacity-75 mt-1">
                        <i class="fas fa-shield-alt mr-1"></i>
                        2 severe reactions
                    </p>
                </div>
            </div>
        </section>

        {{-- Quick Actions --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-bolt text-yellow-500"></i>
                    Quick Actions
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('patient.medicalCondition') }}" 
                       class="group flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-all">
                        <div class="w-14 h-14 bg-blue-100 group-hover:bg-blue-200 rounded-full flex items-center justify-center mb-3 transition-colors">
                            <i class="fas fa-plus text-blue-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700 text-center">Add Condition</span>
                    </a>

                    <a href="{{ route('patient.medication') }}" 
                       class="group flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-400 hover:bg-purple-50 transition-all">
                        <div class="w-14 h-14 bg-purple-100 group-hover:bg-purple-200 rounded-full flex items-center justify-center mb-3 transition-colors">
                            <i class="fas fa-pills text-purple-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700 text-center">Add Medication</span>
                    </a>

                    <a href="#" 
                       class="group flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-green-400 hover:bg-green-50 transition-all">
                        <div class="w-14 h-14 bg-green-100 group-hover:bg-green-200 rounded-full flex items-center justify-center mb-3 transition-colors">
                            <i class="fas fa-download text-green-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-green-700 text-center">Download Report</span>
                    </a>

                    <a href="#" 
                       class="group flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-orange-400 hover:bg-orange-50 transition-all">
                        <div class="w-14 h-14 bg-orange-100 group-hover:bg-orange-200 rounded-full flex items-center justify-center mb-3 transition-colors">
                            <i class="fas fa-share-nodes text-orange-600 text-xl"></i>
                        </div>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-orange-700 text-center">Share Records</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- Visual Navigation Grid --}}
        <nav class="mb-10" aria-label="My Records Sections">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                {{-- Overview --}}
                <a href="{{ route('patient.myrecords') }}" 
                   aria-label="Medical records overview{{ request()->routeIs('patient.myrecords') ? ' - current page' : '' }}"
                   {{ request()->routeIs('patient.myrecords') ? 'aria-current="page"' : '' }}
                   class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.myrecords') ? 'border-blue-600 bg-gradient-to-br from-blue-50 to-blue-100' : 'border-gray-200 bg-white hover:border-blue-300' }}">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.myrecords') ? 'bg-blue-600' : 'bg-gray-100' }}">
                            <i class="fas fa-home text-xl {{ request()->routeIs('patient.myrecords') ? 'text-white' : 'text-blue-600' }}" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold {{ request()->routeIs('patient.myrecords') ? 'text-blue-900' : 'text-gray-700' }}">
                            Overview
                        </span>
                        @if(request()->routeIs('patient.myrecords'))
                            <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-600"></div>
                        @endif
                    </div>
                </a>

                {{-- Conditions --}}
                <a href="{{ route('patient.medicalCondition') }}" 
                   aria-label="Medical conditions{{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? ' - current page' : '' }}"
                   {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'aria-current="page"' : '' }}
                   class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'border-purple-600 bg-gradient-to-br from-purple-50 to-purple-100' : 'border-gray-200 bg-white hover:border-purple-300' }}">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'bg-purple-600' : 'bg-gray-100' }}">
                            <i class="fas fa-file-medical-alt text-xl {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-white' : 'text-purple-600' }}" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold {{ request()->routeIs('patient.medicalCondition') || request()->routeIs('patient.condition.*') ? 'text-purple-900' : 'text-gray-700' }}">
                            Conditions
                        </span>
                        @if($conditions->count() > 0)
                            <span class="absolute -top-2 -right-2 w-7 h-7 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center shadow-lg">
                                {{ $conditions->count() }}
                            </span>
                        @endif
                    </div>
                </a>

                {{-- Medication --}}
                <a href="{{ route('patient.medication') }}" 
                   aria-label="Medications{{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? ' - current page' : '' }}"
                   {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'aria-current="page"' : '' }}
                   class="group relative overflow-hidden rounded-xl border-2 transition-all hover:shadow-lg {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'border-pink-600 bg-gradient-to-br from-pink-50 to-pink-100' : 'border-gray-200 bg-white hover:border-pink-300' }}">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'bg-pink-600' : 'bg-gray-100' }}">
                            <i class="fas fa-pills text-xl {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-white' : 'text-pink-600' }}" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold {{ request()->routeIs('patient.medication') || request()->routeIs('patient.medication.*') ? 'text-pink-900' : 'text-gray-700' }}">
                            Medication
                        </span>
                    </div>
                </a>

                {{-- Lab Results --}}
                <a href="#" 
                   aria-label="Lab results (coming soon)"
                   class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-green-300 transition-all hover:shadow-lg">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                            <i class="fas fa-flask text-xl text-green-600" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold text-gray-700">
                            Lab Results
                        </span>
                    </div>
                </a>

                {{-- Vaccination --}}
                <a href="#" 
                   aria-label="Vaccinations (coming soon)"
                   class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-teal-300 transition-all hover:shadow-lg">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                            <i class="fas fa-syringe text-xl text-teal-600" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold text-gray-700">
                            Vaccination
                        </span>
                    </div>
                </a>

                {{-- Allergy --}}
                <a href="#" 
                   aria-label="Allergies (coming soon)"
                   class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white hover:border-red-300 transition-all hover:shadow-lg">
                    <div class="p-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-xl bg-gray-100 flex items-center justify-center transition-transform group-hover:scale-110">
                            <i class="fas fa-exclamation-triangle text-xl text-red-600" aria-hidden="true"></i>
                        </div>
                        <span class="block text-sm font-semibold text-gray-700">
                            Allergy
                        </span>
                    </div>
                </a>
            </div>
        </nav>

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
                                                    <i class="fas fa-shield-check"></i> Mild
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
                                <div class="w-32 h-32 bg-gradient-to-br from-blue-100 via-purple-100 to-pink-100 rounded-full flex items-center justify-center animate-pulse">
                                    <i class="fas fa-file-medical text-blue-600 text-5xl"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                    <i class="fas fa-plus text-white text-lg"></i>
                                </div>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Start Your Health Journey</h3>
                            <p class="text-gray-600 max-w-md mx-auto mb-8 text-lg">
                                No medical conditions recorded yet. Add your first condition to keep track of your health history.
                            </p>
                            
                            {{-- Benefits list --}}
                            <div class="max-w-lg mx-auto mb-8 text-left bg-blue-50 rounded-lg p-6 border border-blue-200">
                                <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                    <i class="fas fa-lightbulb text-yellow-500"></i>
                                    Why track your conditions?
                                </h4>
                                <ul class="space-y-2 text-sm text-gray-700">
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Better communication with healthcare providers</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Track symptoms and progress over time</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="fas fa-check-circle text-green-600 mt-0.5"></i>
                                        <span>Receive personalized health insights</span>
                                    </li>
                                </ul>
                            </div>
                            
                            <a href="{{ route('patient.medicalCondition') }}" 
                               class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl hover:from-blue-700 hover:to-purple-700 shadow-lg hover:shadow-xl transition-all transform hover:scale-105 text-lg font-medium">
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