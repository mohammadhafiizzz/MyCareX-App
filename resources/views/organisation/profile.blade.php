<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Provider Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    @include('organisation.components.header')

    @include('organisation.components.sidebar')

    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Organisation Profile</h1>
                    <p class="text-sm text-gray-500">Manage your facility details and account settings.</p>
                </div>

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
                                <form id="avatarForm" action="{{ route('organisation.profile.update.picture') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <label for="avatarInput" class="absolute bottom-0 right-0 bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-md border border-gray-100 text-blue-600 hover:text-blue-700 hover:bg-gray-100 cursor-pointer transition-transform hover:scale-110 z-10">
                                        <i class="fa-solid fa-camera text-xs"></i>
                                        <input type="file" id="avatarInput" name="profile_picture" class="hidden" accept="image/*">
                                    </label>
                                </form>
                            </div>

                            <h2 class="text-xl font-bold text-gray-900">{{ $organisation->organisation_name }}</h2>
                            <p class="text-sm text-gray-500 mb-2">{{ $organisation->organisation_type }}</p>

                            <div class="mb-4">
                                @if($isVerified)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-clock"></i> Unverified
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
                            <button id="openEditDetails" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                Edit Details
                            </button>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Organisation Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $organisation->organisation_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Organisation Type</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $organisation->organisation_type }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Establishment Date</label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ $organisation->establishment_date ? date('d M Y', strtotime($organisation->establishment_date)) : 'Not set' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Official Email</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->email }}</p>
                                    @if($organisation->email_verified_at)
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-100">
                                            <i class="fa-solid fa-circle-check"></i> Verified
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Website URL</label>
                                <p class="text-sm text-gray-900 font-medium">
                                    @if($organisation->website_url)
                                        <a href="{{ $organisation->website_url }}" target="_blank" class="text-blue-600 hover:underline">
                                            {{ $organisation->website_url }}
                                        </a>
                                    @else
                                        Not provided
                                    @endif
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Verification Status</label>
                                <div>
                                    @if($isVerified)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                            VERIFIED
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
                                <button id="openEditContact" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                    Edit Contact
                                </button>
                            </div>
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Office Phone</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->phone_number }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Emergency Contact</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->emergency_contact ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Street Address</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->address }}</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Postal Code</label>
                                        <p class="text-sm text-gray-900 font-medium">{{ $organisation->postal_code }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase block mb-1">State</label>
                                        <p class="text-sm text-gray-900 font-medium">{{ $organisation->state }}</p>
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Address</label>
                                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <p class="text-sm text-gray-900 font-medium leading-relaxed">
                                            {{ $organisation->address }}, {{ $organisation->postal_code }} {{ $organisation->state }}
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
                                <button id="openEditPic" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                    Edit PIC
                                </button>
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->contact_person_name }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Designation</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->contact_person_designation }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Direct Contact</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->contact_person_phone_number }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / ID Number</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->contact_person_ic_number }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fa-solid fa-file-contract text-gray-400"></i> LEGAL & LICENSING
                                </h3>
                                <button id="openEditLegal" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                    Edit Info
                                </button>
                            </div>
                            
                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Registration Number</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->registration_number }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">License Number</label>
                                    <p class="text-sm text-gray-900 font-medium">{{ $organisation->license_number ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase block mb-1">License Expiry Date</label>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $organisation->license_expiry_date ? date('d M Y', strtotime($organisation->license_expiry_date)) : 'Not set' }}
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
                                    <i class="fa-solid fa-shield-halved text-gray-400"></i> SECURITY & ACCOUNT
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-2">
                                <div class="flex items-center justify-between py-3 border-b border-gray-50">
                                    <label class="text-sm font-medium text-gray-800">Last Login</label>
                                    <p class="text-sm text-gray-900 font-medium">
                                        {{ $organisation->last_login ? date('d M Y, h:i A', strtotime($organisation->last_login)) : 'Never' }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between py-4 border-b border-gray-50">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Change Password</p>
                                        <p class="text-xs text-gray-500">Update your account password</p>
                                    </div>
                                    <button id="openEditPassword" class="px-4 py-2 text-xs font-bold text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-100">
                                        Change Password
                                    </button>
                                </div>

                                <div class="flex items-center justify-between py-4">
                                    <div>
                                        <p class="text-sm font-medium text-red-600">Logout</p>
                                        <p class="text-xs text-red-400">Sign out of your current session</p>
                                    </div>
                                    <form action="{{ route('organisation.logout') }}" method="POST">
                                        @csrf
                                        <button class="px-4 py-2 text-xs font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('organisation.components.footer')

    <!-- Modals -->
    @include('organisation.auth.profile.organisationDetails')
    @include('organisation.auth.profile.contactDetails')
    @include('organisation.auth.profile.picDetails')
    @include('organisation.auth.profile.licenseDetails')
    @include('organisation.auth.profile.passwordDetails')

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

    @vite(['resources/js/main/organisation/header.js', 'resources/js/main/organisation/profile.js'])
</body>
</html>