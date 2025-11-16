<!-- organisation Navigation Header -->
<nav class="bg-white shadow-sm fixed top-0 right-0 left-0 lg:left-64 z-30 transition-all duration-300" id="topHeader">
    <div class="px-4 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-between h-15">
            <!-- Mobile Menu Button & Logo -->
            <div class="flex items-center space-x-4">
                <button class="lg:hidden focus:outline-none" id="sidebarToggleBtn">
                    <i class="fas fa-bars text-gray-600 text-xl"></i>
                </button>
                <a href="{{ route('organisation.dashboard') }}" class="lg:hidden flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                        <small class="text-[10px] font-normal text-gray-500">
                            Provider Portal
                        </small>
                    </div>
                </a>
            </div>

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
                        <i class="fas fa-chevron-down ml-1 text-[10px]"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50" id="profileDropdownMenu">
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

    </div>
</nav>