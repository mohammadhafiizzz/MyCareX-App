<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Request Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('admin.components.header')

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('admin.providers.requests') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Request List
                    </a>
                </div>

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Request Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about healthcare provider access request.</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 gap-6 mb-8">
                    <!-- Access Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-hospital text-gray-400"></i> ACCESS DETAILS
                            </h3>
                            <div>
                                @if($healthcareProvider->verification_status === 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @elseif($healthcareProvider->verification_status === 'Approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Approved
                                    </span>
                                @elseif($healthcareProvider->verification_status === 'Rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Rejected
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Organisation Name</label>
                                <p class="text-sm {{ $healthcareProvider->organisation_name ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->organisation_name ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Provider Type</label>
                                <p class="text-sm {{ $healthcareProvider->organisation_type ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->organisation_type ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Registration Number</label>
                                <p class="text-sm {{ $healthcareProvider->registration_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->registration_number ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">License Number</label>
                                <p class="text-sm {{ $healthcareProvider->license_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->license_number ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm {{ $healthcareProvider->email ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->email ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm {{ $healthcareProvider->phone_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->phone_number ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Contact Person Name</label>
                                <p class="text-sm {{ $healthcareProvider->contact_person_name ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->contact_person_name ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Contact Person Phone Number</label>
                                <p class="text-sm {{ $healthcareProvider->contact_person_phone_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->contact_person_phone_number ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Request Date</label>
                                <p class="text-sm {{ $healthcareProvider->registration_date ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->registration_date ? \Carbon\Carbon::parse($healthcareProvider->registration_date)->format('d M Y, h:i A') : 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Status</label>
                                <p class="text-sm {{ $healthcareProvider->verification_status ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $healthcareProvider->verification_status ?? 'Not Provided' }}</p>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Business License:</label>
                                @if($healthcareProvider->business_license_document)
                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-file-pdf text-red-600 text-xl" aria-hidden="true"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Medical Document</p>
                                                <p class="text-xs text-gray-500 mt-1">PDF Document</p>
                                            </div>
                                            <a href="{{ $healthcareProvider->business_license_document }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                                                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">Not Provided</p>
                                @endif
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Medical License:</label>
                                @if($healthcareProvider->medical_license_document)
                                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <i class="fas fa-file-pdf text-red-600 text-xl" aria-hidden="true"></i>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Medical Document</p>
                                                <p class="text-xs text-gray-500 mt-1">PDF Document</p>
                                            </div>
                                            <a href="{{ $healthcareProvider->medical_license_document }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-200 hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400">
                                                <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                                                View
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 italic">Not Provided</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions Section -->
                    @if($healthcareProvider->verification_status === 'Pending')
                        <div class="flex flex-col text-sm sm:flex-row justify-end gap-2 border-t border-gray-100">
                            <button type="button" onclick="openRejectModal()" id="rejectRequestBtn" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-500/5 backdrop-blur-md text-red-700 rounded-xl border border-red-400/20 shadow-sm text-sm font-medium hover:bg-red-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                                Reject
                            </button>
                            <form action="{{ route('admin.provider.approve', $healthcareProvider->id) }}" method="POST">
                                @csrf
                                <button type="submit" id="approveRequestBtn" class="w-full inline-flex items-center cursor-pointer px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @elseif($healthcareProvider->verification_status === 'Rejected')
                        <div class="flex flex-col text-sm sm:flex-row justify-end gap-2 border-t border-gray-100">
                            <button type="button" onclick="openRemoveModal()" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-500/5 backdrop-blur-md text-red-700 rounded-xl border border-red-400/20 shadow-sm text-sm font-medium hover:bg-red-500/20 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-400/50 focus-visible:ring-offset-0">
                                Remove
                            </button>
                            <form action="{{ route('admin.provider.approve', $healthcareProvider->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center cursor-pointer px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    Approve
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if($healthcareProvider->verification_status === 'Pending')
    <!-- Reject Request Confirmation Modal -->
    <div id="rejectModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeRejectModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Reject Healthcare Provider</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to reject this healthcare provider registration? This action will notify the provider and cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form action="{{ route('admin.provider.reject', $healthcareProvider->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Reject Provider
                        </button>
                    </form>
                    <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Back
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($healthcareProvider->verification_status === 'Rejected')
    <!-- Remove Provider Confirmation Modal -->
    <div id="removeModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeRemoveModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-trash-alt text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Remove Healthcare Provider</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to permanently delete this healthcare provider from the database? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form action="{{ route('admin.providers.delete', $healthcareProvider->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Remove Permanently
                        </button>
                    </form>
                    <button type="button" onclick="closeRemoveModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Back
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Javascript and Footer -->
    @include('admin.components.footer')

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openRemoveModal() {
            document.getElementById('removeModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRemoveModal() {
            document.getElementById('removeModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals on outside click
        window.onclick = function(event) {
            const rejectModal = document.getElementById('rejectModal');
            const removeModal = document.getElementById('removeModal');
            if (event.target == rejectModal) closeRejectModal();
            if (event.target == removeModal) closeRemoveModal();
        }
    </script>

</body>

</html>
