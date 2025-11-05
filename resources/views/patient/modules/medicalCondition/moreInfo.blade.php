<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - {{ $condition->condition_name }} Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb Navigation --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('patient.medicalCondition') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Medical Conditions
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Condition Details</span>
                    </div>
                </li>
            </ol>
        </nav>

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

            $severityGradient = match ($condition->severity) {
                'Severe' => 'from-red-600 to-rose-500',
                'Moderate' => 'from-amber-500 to-orange-500',
                'Mild' => 'from-green-500 to-emerald-500',
                default => 'from-gray-500 to-gray-400',
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

            $diagnosisLabel = $condition->diagnosis_date ? \Illuminate\Support\Carbon::parse($condition->diagnosis_date)->format('F d, Y') : 'Not recorded';
            $createdLabel = $condition->created_at ? \Illuminate\Support\Carbon::parse($condition->created_at)->format('F d, Y') : 'Unknown';
            $updatedLabel = $condition->updated_at ? \Illuminate\Support\Carbon::parse($condition->updated_at)->diffForHumans() : 'Never';
        @endphp

        {{-- Header Card --}}
        <section class="relative overflow-hidden bg-gradient-to-br {{ $severityGradient }} text-white rounded-xl p-8 mb-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-heartbeat text-3xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $condition->condition_name }}</h1>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $severityBadgeIcon }}" aria-hidden="true"></i>
                                {{ $condition->severity ?? 'Undefined' }} Severity
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                {{ $condition->status ?? 'Not set' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('patient.medicalCondition') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Back to List
                    </a>
                    <button type="button" class="edit-condition-btn inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2" data-id="{{ $condition->id }}">
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
                        <h2 class="text-xl font-semibold text-gray-900">Overview</h2>
                    </div>

                    @if ($condition->description)
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $condition->description }}</p>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                                <i class="fas fa-file-alt text-gray-400 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-sm text-gray-500">No description or notes available for this condition.</p>
                            <button type="button" class="edit-condition-btn mt-3 inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium" data-id="{{ $condition->id }}">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                Add description
                            </button>
                        </div>
                    @endif
                </section>

                {{-- Medical Details Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-stethoscope text-purple-600" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Medical Details</h2>
                    </div>

                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Diagnosis Date</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-400" aria-hidden="true"></i>
                                {{ $diagnosisLabel }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Severity Level</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $severityBadgeStyles }}">
                                    <i class="{{ $severityBadgeIcon }}" aria-hidden="true"></i>
                                    {{ $condition->severity ?? 'Undefined' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Current Status</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $statusBadgeStyles }}">
                                    <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                    {{ $condition->status ?? 'Not set' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Record Created</dt>
                            <dd class="text-sm text-gray-900">{{ $createdLabel }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Last Updated</dt>
                            <dd class="text-sm text-gray-900">{{ $updatedLabel }}</dd>
                        </div>
                    </dl>
                </section>

                {{-- Attachments Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-paperclip text-green-600" aria-hidden="true"></i>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">Attachments</h2>
                        </div>
                        <button type="button" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                            <i class="fas fa-upload text-xs" aria-hidden="true"></i>
                            Upload
                        </button>
                    </div>

                    @if ($condition->doc_attachments_url)
                        <div class="space-y-3">
                            <a href="{{ $condition->doc_attachments_url }}" target="_blank" class="group flex items-center gap-4 p-4 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50/50 transition">
                                <div class="flex-shrink-0 w-12 h-12 bg-gray-100 group-hover:bg-blue-100 rounded-lg flex items-center justify-center transition">
                                    <i class="fas fa-file-pdf text-red-500 text-xl" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 truncate">Medical Document</p>
                                    <p class="text-xs text-gray-500 mt-1">Click to view or download</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-external-link-alt text-gray-400 group-hover:text-blue-600" aria-hidden="true"></i>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-3">
                                <i class="fas fa-folder-open text-gray-400 text-2xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-sm text-gray-500 mb-3">No attachments yet</p>
                            <button type="button" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                Upload medical document
                            </button>
                        </div>
                    @endif
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Actions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <button type="button" class="edit-condition-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" data-id="{{ $condition->id }}">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            Edit Condition
                        </button>
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                            <i class="fas fa-print" aria-hidden="true"></i>
                            Print Details
                        </button>
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share with Doctor
                        </button>
                        <form method="POST" action="{{ route('patient.condition.delete', $condition->id) }}" class="inline-block w-full" onsubmit="return confirm('Are you sure you want to delete this condition? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                Delete Condition
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
                                    <p class="text-sm font-semibold text-gray-900">Status: {{ $condition->status }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $updatedLabel }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Condition Added</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $createdLabel }}</p>
                                </div>
                            </div>
                            @if ($condition->diagnosis_date)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Diagnosed</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $diagnosisLabel }}</p>
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
                        Keep your medical records up to date. Regular updates help your healthcare team provide better care and track your progress over time.
                    </p>
                </section>

            </div>
        </div>
    </div>

    <!-- Edit Condition Form -->
    @include('patient.modules.medicalCondition.editConditionForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/medicalCondition/editConditionForm.js'])
    @include('patient.components.footer')

</body>
</html>
