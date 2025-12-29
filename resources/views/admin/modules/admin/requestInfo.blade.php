<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Request Information</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    <!-- Header -->
    @include('admin.components.header')

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-4">
                    <a href="{{ route('admin.management.newRequests') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Back to New Requests
                    </a>
                </div>

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Request Information</h1>
                    <p class="text-sm text-gray-500">Review admin registration request details.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <!-- Left Column: Profile Summary -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                                <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-user text-gray-400"></i> REQUEST SUMMARY
                                </h3>
                            </div>
                            <div class="p-6 sm:p-8 flex flex-col items-center text-center">
                                <div class="relative w-24 h-24 sm:w-32 sm:h-32 mb-4 sm:mb-5 mx-auto shrink-0">
                                    <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl sm:text-4xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                        @if($admin->profile_image_url)
                                            <img src="{{ asset($admin->profile_image_url) }}" alt="{{ $admin->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user-shield"></i>
                                        @endif
                                    </div>
                                </div>

                                <h2 class="text-xl font-bold text-gray-900">{{ $admin->full_name }}</h2>
                                <p class="text-sm text-gray-500 mb-3 uppercase">{{ $admin->role }}</p>

                                <div class="mb-2">
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-clock"></i> Pending Verification
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Admin Information -->
                    <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fa-solid fa-id-card text-gray-400"></i> REGISTRATION DETAILS
                            </h3>
                        </div>
                        
                        <div class="p-4 sm:p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-6 sm:gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Admin ID</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->admin_id }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->phone_number ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Role Requested</label>
                                <p class="text-sm text-gray-900 font-medium uppercase">{{ $admin->role }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC / ID Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->ic_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Registration Date</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Account Status</label>
                                <div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                        PENDING
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Sections -->
                    <div class="lg:col-span-3 space-y-6">
                        <!-- Actions -->
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                                <h3 class="text-sm sm:text-md font-bold text-gray-900 flex items-center gap-2">
                                    <i class="fas fa-gavel text-gray-400"></i> DECISION
                                </h3>
                            </div>
                            
                            <div class="p-4 sm:p-6 space-y-4">
                                <div class="flex flex-col md:flex-row gap-4">
                                    <div class="flex-1 p-4 bg-green-50 border border-green-100 rounded-xl">
                                        <h4 class="text-sm font-bold text-green-800 mb-1">Approve Request</h4>
                                        <p class="text-xs text-green-600 mb-4">The admin will be granted access to the system immediately.</p>
                                        <button class="approve-admin-btn w-full px-4 py-2 text-xs font-bold text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors" data-id="{{ $admin->admin_id }}">
                                            Approve Admin
                                        </button>
                                    </div>
                                    <div class="flex-1 p-4 bg-red-50 border border-red-100 rounded-xl">
                                        <h4 class="text-sm font-bold text-red-800 mb-1">Reject Request</h4>
                                        <p class="text-xs text-red-600 mb-4">The registration request will be declined.</p>
                                        <button class="reject-admin-btn w-full px-4 py-2 text-xs font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors" data-id="{{ $admin->admin_id }}">
                                            Reject Admin
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('admin.components.footer')

    @include('admin.components.modals')
    @include('admin.components.notifications')

    @vite(['resources/js/main/admin/header.js', 'resources/js/main/admin/adminManagement.js'])

</body>

</html>
