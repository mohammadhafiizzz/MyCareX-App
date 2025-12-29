<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Healthcare Provider Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    @include('admin.components.header')

    @include('admin.components.sidebar')

    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-4">
                    <a href="{{ route('admin.providers') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to Provider List
                    </a>
                </div>

                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Healthcare Provider Profile</h1>
                    <p class="text-sm text-gray-500">View and manage healthcare provider details</p>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-3 text-green-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="space-y-6">
                        
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
                            <div class="relative w-24 h-24 mb-4 mx-auto shrink-0">
                                <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                    @if($organisation->profile_image_url)
                                        <img src="{{ asset($organisation->profile_image_url) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-hospital"></i>
                                    @endif
                                </div>
                            </div>

                            <h2 class="text-xl font-bold text-gray-900">{{ $organisation->organisation_name }}</h2>
                            <p class="text-sm text-gray-500 mb-2">{{ $organisation->organisation_type }}</p>

                            <div class="mb-4">
                                @if($isVerified)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-check-circle"></i> Approved
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </div>

                            <div class="w-full border-t border-gray-100 pt-4 grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 uppercase font-bold">Joined</span>
                                    <span class="text-sm font-semibold">{{ date('M Y', strtotime($organisation->created_at)) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 uppercase font-bold">Reg. No</span>
                                    <span class="text-sm font-semibold">{{ $organisation->registration_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-hospital text-gray-400"></i> ORGANISATION DETAILS
                            </h3>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Organisation Name</label>
                                <p class="text-sm {{ $organisation->organisation_name ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->organisation_name ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Organisation Type</label>
                                <p class="text-sm {{ $organisation->organisation_type ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->organisation_type ?? 'Not Provided' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Establishment Date</label>
                                <p class="text-sm {{ $organisation->establishment_date ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">
                                    {{ $organisation->establishment_date ? date('d M Y', strtotime($organisation->establishment_date)) : 'Not Provided' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Official Email</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm {{ $organisation->email ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->email ?? 'Not Provided' }}</p>
                                    @if($organisation->email_verified_at)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                            <i class="fa-solid fa-circle-check"></i> Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Website URL</label>
                                <p class="text-sm {{ $organisation->website_url ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">
                                    @if($organisation->website_url)
                                        <a href="{{ $organisation->website_url }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $organisation->website_url }}
                                        </a>
                                    @else
                                        Not Provided
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Verification Status</label>
                                <div>
                                    @if($isVerified)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                            APPROVED
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 uppercase">
                                            {{ $organisation->verification_status ?? 'PENDING' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-3 space-y-6">

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-gray-400"></i> CONTACT & LOCATION
                                </h3>
                            </div>
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Office Phone</label>
                                    <p class="text-sm {{ $organisation->phone_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->phone_number ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Emergency Contact</label>
                                    <p class="text-sm {{ $organisation->emergency_contact ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->emergency_contact ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Street Address</label>
                                    <p class="text-sm {{ $organisation->address ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->address ?? 'Not Provided' }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Postal Code</label>
                                        <p class="text-sm {{ $organisation->postal_code ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->postal_code ?? 'Not Provided' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">State</label>
                                        <p class="text-sm {{ $organisation->state ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->state ?? 'Not Provided' }}</p>
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Address</label>
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-sm {{ ($organisation->address || $organisation->postal_code || $organisation->state) ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }} leading-relaxed">
                                            @if($organisation->address || $organisation->postal_code || $organisation->state)
                                                {{ $organisation->address }}, {{ $organisation->postal_code }} {{ $organisation->state }}
                                            @else
                                                Not Provided
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fa-solid fa-user text-gray-400"></i> PERSON IN CHARGE (PIC)
                                </h3>
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                    <p class="text-sm {{ $organisation->contact_person_name ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->contact_person_name ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Designation</label>
                                    <p class="text-sm {{ $organisation->contact_person_designation ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->contact_person_designation ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Direct Contact</label>
                                    <p class="text-sm {{ $organisation->contact_person_phone_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->contact_person_phone_number ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / ID Number</label>
                                    <p class="text-sm {{ $organisation->contact_person_ic_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->contact_person_ic_number ?? 'Not Provided' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fa-solid fa-file-contract text-gray-400"></i> LEGAL & LICENSING
                                </h3>
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Registration Number</label>
                                    <p class="text-sm {{ $organisation->registration_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->registration_number ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">License Number</label>
                                    <p class="text-sm {{ $organisation->license_number ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">{{ $organisation->license_number ?? 'Not Provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">License Expiry Date</label>
                                    <p class="text-sm {{ $organisation->license_expiry_date ? 'text-gray-900 font-medium' : 'text-gray-500 italic' }}">
                                        {{ $organisation->license_expiry_date ? date('d M Y', strtotime($organisation->license_expiry_date)) : 'Not Provided' }}
                                    </p>
                                </div>
                                <div class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-2">Business License</label>
                                        @if($organisation->business_license_document)
                                            <a href="{{ asset($organisation->business_license_document) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-semibold">
                                                <i class="fa-solid {{ in_array(strtolower(pathinfo($organisation->business_license_document, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']) ? 'fa-file-image' : 'fa-file-pdf' }} text-lg"></i> View Document
                                            </a>
                                        @else
                                            <p class="text-xs text-gray-400 italic">No document uploaded</p>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-2">Medical License</label>
                                        @if($organisation->medical_license_document)
                                            <a href="{{ asset($organisation->medical_license_document) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-700 font-semibold">
                                                <i class="fa-solid {{ in_array(strtolower(pathinfo($organisation->medical_license_document, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']) ? 'fa-file-image' : 'fa-file-pdf' }} text-lg"></i> View Document
                                            </a>
                                        @else
                                            <p class="text-xs text-gray-400 italic">No document uploaded</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-gear text-gray-400"></i> ACTIONS
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-2">
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Last Login</p>
                                        <p class="text-xs text-gray-500">Last login: {{ $organisation->last_login ? $organisation->last_login->diffForHumans() : 'Never' }}</p>
                                    </div>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $organisation->last_login ? $organisation->last_login->format('d M Y, h:i A') : 'Never' }}
                                    </p>
                                </div>

                                @if($organisation->verification_status === 'Pending' || $organisation->verification_status === 'Rejected')
                                    <div class="flex items-center justify-between py-4 border-t border-gray-50">
                                        <div>
                                            <p class="text-sm font-medium text-green-600">Approve Organisation</p>
                                            <p class="text-xs text-green-400">Re-approve this previously rejected healthcare provider</p>
                                        </div>
                                        <form action="{{ route('admin.provider.approve', $organisation->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this healthcare provider?');">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 text-xs font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors border border-green-100">
                                                Approve
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                <div class="flex items-center justify-between py-4">
                                    <div>
                                        <p class="text-sm font-medium text-red-600">Remove Organisation</p>
                                        <p class="text-xs text-red-400">Remove organisation completely from the system</p>
                                    </div>
                                    <button type="button" onclick="openRemoveModal()" class="px-4 py-2 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                            <i class="fas fa-trash text-red-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">Remove Healthcare Provider</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Are you sure you want to permanently delete this healthcare provider from the database? This action cannot be undone.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="{{ route('admin.providers.delete', $organisation->id) }}" method="POST">
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

    @include('admin.components.footer')

    <script>
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
            const removeModal = document.getElementById('removeModal');
            if (event.target == removeModal) closeRemoveModal();
        }
    </script>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-5 right-5 z-[100] transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
        <div class="bg-white shadow-xl rounded-lg p-4 flex items-center gap-3 min-w-[300px]">
            <div id="toastIcon" class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <p id="toastTitle" class="text-sm font-bold text-gray-900">Success</p>
                <p id="toastMessage" class="text-xs text-gray-500">Details updated successfully.</p>
            </div>
            <button onclick="hideToast()" class="ml-auto text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    @vite(['resources/js/main/admin/header.js', 'resources/js/main/admin/profile.js'])
</body>
</html>