<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - {{ $medication->medication_name }} Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    @include('patient.components.header')

    @include('patient.components.navbar')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-check-circle text-green-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start gap-3">
                <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        {{-- Breadcrumb Navigation --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('patient.medication') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Medications
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Medication Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Card --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-8 mb-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-capsules text-3xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $medication->medication_name }}</h1>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                {{ $medication->status ?? 'Not set' }}
                            </span>
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                                {{ $frequency }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('patient.medication') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Back to List
                    </a>
                    <button type="button" class="edit-medication-btn inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2" data-id="{{ $medication->id }}">
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
                        <h2 class="text-xl font-semibold text-gray-900">Medication Information</h2>
                    </div>

                    {{-- Reason for Medication --}}
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            Reason for Medication:
                        </h3>
                        @if ($medication->reason_for_med)
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $medication->reason_for_med }}</p>
                        @else
                            <p class="text-sm text-gray-500 italic">Not set yet</p>
                        @endif
                    </div>

                    {{-- Medication Image --}}
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            Medication Image:
                        </h3>
                        @if ($medication->med_image_url)
                            <div class="rounded-lg overflow-hidden border border-gray-200 bg-white">
                                <img 
                                    src="{{ $medication->med_image_url }}" 
                                    alt="{{ $medication->medication_name }} image" 
                                    class="w-full h-auto max-h-96 object-contain"
                                    onerror="this.onerror=null; this.src=''; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="hidden flex-col items-center justify-center py-16 bg-gray-50">
                                    <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                        <i class="fas fa-prescription-bottle text-gray-400 text-3xl" aria-hidden="true"></i>
                                    </div>
                                    <p class="text-sm text-gray-500">Image not available</p>
                                </div>
                            </div>
                            <div class="mt-3 flex gap-2">
                                <button type="button" id="uploadMedicationImageBtn" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                                    <i class="fas fa-upload" aria-hidden="true"></i>
                                    Replace Image
                                </button>
                                <form method="POST" action="{{ route('patient.medication.delete.image', $medication->id) }}" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this medication image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-medium rounded-lg border border-red-200 hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                        Delete Image
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="rounded-lg border border-gray-200 bg-gray-50 flex flex-col items-center justify-center py-16">
                                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-prescription-bottle text-gray-400 text-3xl" aria-hidden="true"></i>
                                </div>
                                <p class="text-sm text-gray-500 mb-2">No image uploaded</p>
                                <button type="button" id="uploadMedicationImageBtnEmpty" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                    <i class="fas fa-upload" aria-hidden="true"></i>
                                    Upload image
                                </button>
                            </div>
                        @endif
                    </div>

                    {{-- Additional Notes --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-notes-medical text-gray-600" aria-hidden="true"></i>
                            Description / Notes:
                        </h3>
                        @if ($medication->notes)
                            <div class="prose prose-sm max-w-none">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $medication->notes }}</p>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-2">
                                    <i class="fas fa-file-alt text-gray-400 text-lg" aria-hidden="true"></i>
                                </div>
                                <p class="text-sm text-gray-500 mb-2">No additional notes available.</p>
                                <button type="button" class="edit-medication-btn inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium" data-id="{{ $medication->id }}">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                    Add notes
                                </button>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Medication Details Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-prescription-bottle text-blue-600" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Medication Details</h2>
                    </div>

                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Dosage:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-pills text-gray-400" aria-hidden="true"></i>
                                {{ $dosage }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Frequency:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-clock text-gray-400" aria-hidden="true"></i>
                                {{ $frequency }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Current Status:</dt>
                            <dd class="text-sm">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full font-semibold {{ $statusBadgeStyles }}">
                                    <i class="{{ $statusIcon }}" aria-hidden="true"></i>
                                    {{ $medication->status ?? 'Not set' }}
                                </span>
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Start Date:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-400" aria-hidden="true"></i>
                                {{ $startDateLabel }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">End Date:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-400" aria-hidden="true"></i>
                                {{ $endDateLabel }}
                            </dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Record Created:</dt>
                            <dd class="text-sm text-gray-900">{{ $createdLabel }}</dd>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Last Updated:</dt>
                            <dd class="text-sm text-gray-900">{{ $updatedLabel }}</dd>
                        </div>
                    </dl>
                </section>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                
                {{-- Quick Actions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <button type="button" class="edit-medication-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" data-id="{{ $medication->id }}">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            Edit Medication
                        </button>
                        <button type="button" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                            <i class="fas fa-share-alt" aria-hidden="true"></i>
                            Share with Doctor
                        </button>
                        <form method="POST" action="{{ route('patient.medication.delete', $medication->id) }}" class="inline-block w-full" onsubmit="return confirm('Are you sure you want to delete this medication? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                Delete Medication
                            </button>
                        </form>
                        <hr class="mt-4 mb-5 border-gray-300">
                        <button type="button" id="setReminderAction" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                            <i class="fas fa-bell" aria-hidden="true"></i>
                            Set Reminder
                        </button>
                    </div>
                </section>

                {{-- Status Timeline --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Medication Timeline</h3>
                    <div class="relative">
                        <div class="absolute left-3 top-3 bottom-3 w-0.5 bg-gray-200"></div>
                        <div class="space-y-4 relative">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Status: {{ $medication->status }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $updatedLabel }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Medication Added</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $createdLabel }}</p>
                                </div>
                            </div>
                            @if ($medication->start_date)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Treatment Started</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $startDateLabel }}</p>
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
                            <h3 class="text-base font-semibold text-gray-900">Medication Tip</h3>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Take your medication at the same time each day to maintain consistent levels and improve effectiveness. Set reminders to stay on track.
                    </p>
                </section>

            </div>
        </div>
    </div>

    <!-- Upload Medication Image Form -->
    @include('patient.modules.medication.uploadMedicationImageForm')

    <!-- Edit Medication Form -->
    @include('patient.modules.medication.editMedicationForm')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js', 'resources/js/main/medication/uploadMedicationImage.js', 'resources/js/main/medication/editMedication.js'])
    @include('patient.components.footer')

</body>
</html>
