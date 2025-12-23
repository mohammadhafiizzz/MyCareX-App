<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Admin Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 text-gray-800">

    @include('admin.components.header')

    @include('admin.components.sidebar')

    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="min-h-screen">
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">Admin Profile</h1>
                    <p class="text-sm text-gray-500">Manage your personal details and account settings.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="space-y-6">
                        
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center">
                            <div class="relative w-24 h-24 mb-4 mx-auto shrink-0">
                                <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-3xl font-bold border-4 border-white shadow-sm overflow-hidden shrink-0">
                                    @if($admin->profile_image_url)
                                        <img src="{{ asset($admin->profile_image_url) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user"></i>
                                    @endif
                                </div>
                                <form id="avatarForm" action="{{ route('admin.profile.update.picture') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <label for="avatarInput" class="absolute bottom-0 right-0 bg-white w-8 h-8 flex items-center justify-center rounded-full shadow-md border border-gray-100 text-blue-600 hover:text-blue-700 hover:bg-gray-100 cursor-pointer transition-transform hover:scale-110 z-10">
                                        <i class="fa-solid fa-camera text-xs"></i>
                                        <input type="file" id="avatarInput" name="profile_picture" class="hidden" accept="image/*">
                                    </label>
                                </form>
                            </div>

                            <h2 class="text-xl font-bold text-gray-900">{{ $admin->full_name }}</h2>
                            <p class="text-sm text-gray-500 mb-2">{{ $admin->role }}</p>

                            <div class="mb-4">
                                @if($admin->account_verified_at)
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold border border-green-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-check-circle"></i> Verified
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold border border-amber-200 flex items-center gap-2 mx-auto w-fit">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </div>

                            <div class="w-full border-t border-gray-100 pt-4 grid grid-cols-2 gap-4">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 uppercase font-bold">Admin ID</span>
                                    <span class="text-sm font-semibold">{{ $admin->admin_id }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-400 uppercase font-bold">Role</span>
                                    <span class="text-sm font-semibold uppercase">{{ $admin->role }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl lg:col-span-2 shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-md font-bold text-gray-900 flex items-center gap-2">
                                <i class="fas fa-user text-gray-400"></i> PERSONAL DETAILS
                            </h3>
                            <button id="openEditPersonal" class="text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white px-3 py-1.5 rounded-lg shadow-sm hover:shadow transition-all">
                                Edit Details
                            </button>
                        </div>
                        
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-8">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Full Name</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->full_name }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">IC Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->ic_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Phone Number</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->phone_number }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Email Address</label>
                                <p class="text-sm text-gray-900 font-medium">{{ $admin->email }}</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Last Login</label>
                                <p class="text-sm text-gray-900 font-medium">
                                    {{ $admin->last_login ? $admin->last_login->format('d M Y, h:i A') : 'Never' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase block mb-1">Account Status</label>
                                <div>
                                    @if($admin->account_verified_at)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                            VERIFIED
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 uppercase">
                                            PENDING
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
                                    <i class="fa-solid fa-shield-halved text-gray-400"></i> SECURITY & ACCOUNT
                                </h3>
                            </div>
                            
                            <div class="p-6 space-y-2">
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
                                    <form action="{{ route('admin.logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 text-xs font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
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

    @include('admin.components.footer')

    <!-- Modals -->
    @include('admin.auth.profile.personalDetails')
    @include('admin.auth.profile.passwordDetails')

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
