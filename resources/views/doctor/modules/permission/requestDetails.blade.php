<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Request Details - {{ $permission->patient->full_name }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Back Button -->
                <div class="mb-4">
                    <a href="{{ route('doctor.permission.requests') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Requests
                    </a>
                </div>

                <!-- Page Header -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Request Details</h1>
                    <p class="text-sm text-gray-500">Detailed information about your access request.</p>
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
                                <i class="fa-solid fa-shield-halved text-gray-400"></i> ACCESS DETAILS
                            </h3>
                            <div>
                                @if($permission->status === 'Pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending
                                    </span>
                                @elseif($permission->status === 'Active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Approved
                                    </span>
                                @elseif($permission->status === 'Rejected')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i> Rejected
                                    </span>
                                @elseif($permission->status === 'Expired')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        <i class="fas fa-calendar-times mr-1"></i> Expired
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Patient Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->patient->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->patient->ic_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->patient->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->patient->phone_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Request Date</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->requested_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Status</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->status }}</p>
                            </div>
                            
                            @if($permission->granted_at)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Granted At</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->granted_at->format('d M Y, h:i A') }}</p>
                            </div>
                            @endif

                            @if($permission->expiry_date)
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Expiry Date</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $permission->expiry_date->format('d M Y') }}</p>
                            </div>
                            @endif

                            <div class="sm:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Permission Scope</label>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    @if(in_array('all', $permission->permission_scope ?? []))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            All Records
                                        </span>
                                    @else
                                        @foreach($permission->permission_scope ?? [] as $scope)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                                {{ ucwords(str_replace('_', ' ', $scope)) }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Notes</label>
                                <p class="text-sm text-gray-900 font-medium bg-gray-50 p-3 rounded-lg border border-gray-100">
                                    {{ $permission->notes ?? 'No notes provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Section -->
                    @if($permission->status === 'Pending')
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <button type="button" 
                                onclick="openCancelModal()"
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white text-red-600 border border-red-200 rounded-xl text-sm font-semibold shadow-sm hover:bg-red-50 transition-all">
                                Cancel Request
                            </button>
                            <button type="button" 
                                onclick="openEditModal()"
                                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-700 transition-all">
                                Edit Request
                            </button>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @if($permission->status === 'Pending')
    <!-- Edit Request Modal -->
    <div id="editModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>
            
            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <form id="editRequestForm" action="{{ route('doctor.permission.request.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-edit text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Edit Access Request</h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Permission Scope</label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @php
                                                $scopes = [
                                                    'medical_conditions' => 'Medical Conditions',
                                                    'medications' => 'Medications',
                                                    'allergies' => 'Allergies',
                                                    'immunisations' => 'Immunisations',
                                                    'lab_tests' => 'Lab Tests'
                                                ];
                                                $currentScope = $permission->permission_scope ?? [];
                                            @endphp
                                            @foreach($scopes as $value => $label)
                                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors">
                                                <input type="checkbox" name="permission_scope[]" value="{{ $value }}" 
                                                    class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                    {{ in_array($value, $currentScope) ? 'checked' : '' }}>
                                                <span class="ml-3 text-sm text-gray-700">{{ $label }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                                        <textarea id="notes" name="notes" rows="3" 
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
                                            placeholder="Reason for requesting access...">{{ $permission->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-bold text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Save Changes
                        </button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Cancel Request Confirmation Modal -->
    <div id="cancelModal" class="fixed inset-0 z-[150] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true" onclick="closeCancelModal()"></div>

            <!-- Modal Content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Cancel Access Request</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to cancel this access request? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <form action="{{ route('doctor.permission.request.cancel', $permission->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancel Request
                        </button>
                    </form>
                    <button type="button" onclick="closeCancelModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Back
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openCancelModal() {
            document.getElementById('cancelModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            document.getElementById('cancelModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals on outside click
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const cancelModal = document.getElementById('cancelModal');
            if (event.target == editModal) closeEditModal();
            if (event.target == cancelModal) closeCancelModal();
        }
    </script>

</body>

</html>
