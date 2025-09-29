<!-- organisation Navigation Header -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-between h-15">
            <a href="{{ route('organisation.dashboard') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                    <small class="text-[10px] font-normal text-gray-500">
                        Personal Healthcare Records
                    </small>
                </div>
            </a>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden focus:outline-none" id="mobileMenuButton">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16">
                    </path>
                </svg>
            </button>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-4 text-sm font-normal">
                <!-- Notification Button -->
                <button class="relative p-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200" id="notificationBtn">
                    <i class="fas fa-bell"></i>
                    <!-- Notification Badge (optional) -->
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[7px] rounded-full h-3 w-3 flex items-center justify-center"></span>
                </button>

                <!-- Profile Dropdown Button -->
                <div class="relative" id="profileDropdown">
                    <button class="flex items-center p-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200" id="profileBtn">
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ Auth::guard('organisation')->user()->organisation_name ?? 'Profile' }}</span>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden" id="profileDropdownMenu">
                        <div class="py-2">
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>My Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form action="{{ route('organisation.logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="lg:hidden hidden" id="mobileMenu">
            <div class="px-2 pt-2 pb-3 space-y-1 text-sm border-t border-gray-200">
                <!-- Mobile Notifications -->
                <button class="flex items-center w-full px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md" id="mobileNotificationBtn">
                    <i class="fas fa-bell mr-3"></i>Notifications
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>

                <!-- Mobile Profile Section -->
                <div class="border-t border-gray-200 pt-2 mt-2">
                    <div class="px-3 py-2 text-sm text-gray-500">
                        {{ Auth::guard('organisation')->user()->organisation_name ?? 'Organisation' }}
                    </div>
                    <a href="#" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-user-edit mr-3"></i>My Profile
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-cog mr-3"></i>Settings
                    </a>
                    <form action="{{ route('organisation.logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2 text-red-600 hover:bg-red-50 rounded-md">
                            <i class="fas fa-sign-out-alt mr-3"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>