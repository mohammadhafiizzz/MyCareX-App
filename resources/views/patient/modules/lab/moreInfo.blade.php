<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Lab Test</title>
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
                    <a href="{{ route('patient.lab') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Lab Tests
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Lab Test Details</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Header Card --}}
        <section class="relative overflow-hidden bg-gradient-to-br from-indigo-500 to-indigo-600 text-white rounded-xl p-8 mb-8 shadow-lg">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-12 -mt-12"></div>
            <div class="absolute bottom-0 left-0 w-40 h-40 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            
            <div class="relative flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0 w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <i class="fas fa-flask text-3xl" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-3">{{ $labTest->test_name }}</h1>
                        <div class="flex flex-wrap gap-3">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                Self Reported
                            </span>
                            @if ($labTest->test_category)
                                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-white/20 backdrop-blur-sm border border-white/30">
                                    {{ $labTest->test_category }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('patient.lab') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                        <i class="fas fa-arrow-left" aria-hidden="true"></i>
                        Back to List
                    </a>
                    <button type="button" class="edit-test-btn inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-900 text-sm font-semibold rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2" data-id="{{ $labTest->id }}">
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
                        <h2 class="text-xl font-semibold text-gray-900">Test Information</h2>
                    </div>

                    {{-- Facility Name --}}
                    @if ($labTest->facility_name)
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                            <h3 class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                                <i class="fas fa-hospital text-blue-600" aria-hidden="true"></i>
                                Facility:
                            </h3>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $labTest->facility_name }}</p>
                        </div>
                    @endif

                    {{-- File Attachment Information --}}
                    @if ($labTest->file_attachment_url)
                        @php
                            $fileExtension = strtolower(pathinfo($labTest->file_attachment_url, PATHINFO_EXTENSION));
                            $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png']);
                        @endphp
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                <i class="fas fa-paperclip text-gray-600" aria-hidden="true"></i>
                                Vaccination Certificate:
                            </h3>
                            
                            @if ($isImage)
                                {{-- Image Preview --}}
                                <div class="rounded-lg border border-gray-200 bg-gray-50 overflow-hidden">
                                    <a href="{{ $labTest->file_attachment_url }}" target="_blank" class="block group">
                                        <div class="relative">
                                            <img src="{{ $labTest->file_attachment_url }}" alt="Vaccination Certificate" class="w-full h-auto max-h-96 object-contain bg-white">
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all duration-200 flex items-center justify-center">
                                                <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 px-4 py-2 bg-white rounded-lg shadow-lg text-sm font-medium text-gray-900 flex items-center gap-2">
                                                    <i class="fas fa-expand-alt" aria-hidden="true"></i>
                                                    Click to view full size
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="p-4 bg-white border-t border-gray-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-image text-emerald-600" aria-hidden="true"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Vaccination Certificate</p>
                                                <p class="text-xs text-gray-500 mt-0.5">{{ strtoupper($fileExtension) }} Image</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- PDF Document View --}}
                                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-file-pdf text-red-600 text-xl" aria-hidden="true"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">Vaccination Certificate</p>
                                            <p class="text-xs text-gray-500 mt-1">PDF Document</p>
                                        </div>
                                        <a href="{{ $labTest->file_attachment_url }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                                            <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                            View
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-3">
                                <button type="button" id="uploadAttachmentBtn" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                                    <i class="fas fa-upload" aria-hidden="true"></i>
                                    Replace Attachment
                                </button>
                            </div>
                        </div>

                    @else
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-file-pdf text-gray-400 text-xl" aria-hidden="true"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">No attachment found</p>
                                    <p class="text-xs text-gray-500 mt-1">This lab test record doesn't have an attachment</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Additional Notes --}}
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            Description / Notes:
                        </h3>
                        @if ($labTest->notes)
                            <div class="text-sm max-w-none">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $labTest->notes }}</p>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-2">
                                    <i class="fas fa-file-alt text-gray-400 text-lg" aria-hidden="true"></i>
                                </div>
                                <p class="text-sm text-gray-500 mb-2">No additional notes available.</p>
                                <button type="button" class="edit-test-btn inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-medium" data-id="{{ $labTest->id }}">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                    Add notes
                                </button>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Test Details Section --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-flask text-blue-600" aria-hidden="true"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Test Details</h2>
                    </div>

                    <dl class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Test Name:</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $labTest->test_name }}</dd>
                        </div>
                        @if ($labTest->test_category)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Test Category:</dt>
                                <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-tag text-gray-400" aria-hidden="true"></i>
                                    {{ $labTest->test_category }}
                                </dd>
                            </div>
                        @endif
                        <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                            <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Test Date:</dt>
                            <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                <i class="far fa-calendar-alt text-gray-400" aria-hidden="true"></i>
                                {{ $testLabel }}
                            </dd>
                        </div>
                        @if ($labTest->facility_name)
                            <div class="flex flex-col sm:flex-row sm:justify-between py-3 border-b border-gray-100">
                                <dt class="text-sm font-medium text-gray-500 mb-1 sm:mb-0">Facility Name:</dt>
                                <dd class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-hospital text-gray-400" aria-hidden="true"></i>
                                    {{ $labTest->facility_name }}
                                </dd>
                            </div>
                        @endif
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
                
                {{-- Actions --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-2">
                        <button type="button" class="edit-test-btn w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 text-sm font-semibold rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400" data-id="{{ $labTest->id }}">
                            <i class="fas fa-pen-to-square" aria-hidden="true"></i>
                            Edit
                        </button>
                        <a href="{{ route('patient.lab.download', $labTest->id) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg border border-gray-200 hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                            <i class="fas fa-download" aria-hidden="true"></i>
                            Download
                        </a>
                        <hr class="mt-4 mb-5 border-gray-300">
                        <button type="button" onclick="openDeleteModal('lab')" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-700 text-sm font-semibold rounded-lg border border-red-200 hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                            Delete
                        </button>
                    </div>
                </section>

                {{-- Status Timeline --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Lab Test Timeline</h3>
                    <div class="relative">
                        <div class="absolute left-3 top-3 bottom-3 w-0.5 bg-gray-200"></div>
                        <div class="space-y-4 relative">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-blue-600 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Status: {{ $labTest->verification_status }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $updatedLabel }}</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1 pb-4">
                                    <p class="text-sm font-semibold text-gray-900">Record Added</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $createdLabel }}</p>
                                </div>
                            </div>
                            @if ($labTest->test_date)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-gray-300 rounded-full border-4 border-white shadow-sm z-10"></div>
                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-gray-900">Test Date</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $testLabel }}</p>
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
                        Keep your lab test records organized and up to date. Regular monitoring of your health through lab tests can help detect potential issues early and track your progress over time.
                    </p>
                </section>

            </div>
        </div>
    </div>

    <!-- Edit Test Form -->
    @include('patient.modules.lab.editTestForm')

    <!-- Upload Attachment Form -->
    @include('patient.modules.lab.uploadAttachmentForm')

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeDeleteModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Delete Confirmation</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500" id="modal-description">Are you sure you want to delete this record? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 flex flex-col sm:flex-row-reverse gap-2">
                    <form id="deleteForm" action="" method="POST" class="w-full sm:w-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="deleteSubmitBtn" class="inline-flex w-full sm:w-auto items-center cursor-pointer gap-2 justify-center px-4 py-2.5 bg-gradient-to-br from-red-500/90 to-red-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:from-red-500 hover:to-red-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                            Delete
                        </button>
                    </form>
                    <button type="button" onclick="closeDeleteModal()" class="inline-flex w-full sm:w-auto justify-center items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                        Back
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(type) {
            const modal = document.getElementById('deleteModal');
            const title = document.getElementById('modal-title');
            const description = document.getElementById('modal-description');
            const form = document.getElementById('deleteForm');
            const submitBtn = document.getElementById('deleteSubmitBtn');

            if (type === 'lab') {
                title.innerText = 'Delete Lab Test Record';
                description.innerText = 'Are you sure you want to delete this lab test record? This action cannot be undone.';
                form.action = "{{ route('patient.lab.delete', $labTest->id) }}";
                submitBtn.innerText = 'Delete';
            }
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @vite(['resources/js/main/lab/editTest.js'])
    @vite(['resources/js/main/lab/uploadDocument.js'])
    @include('patient.components.footer')

</body>
</html>
