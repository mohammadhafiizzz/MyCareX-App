<!-- patient Navigation Header -->
<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-between h-15">
            <a href="{{ route('patient.dashboard') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                    <small class="text-[10px] font-normal text-gray-500">
                        Personal Healthcare Records
                    </small>
                </div>
            </a>

            <!-- Mobile Search & Menu Buttons -->
            <div class="lg:hidden flex items-center space-x-2">
                <button class="focus:outline-none px-2 py-2 text-gray-800 rounded-lg hover:bg-gray-100" id="mobileSearchButton">
                    <i class="fas fa-search"></i>
                </button>
                <button class="focus:outline-none" id="mobileMenuButton">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-4 text-sm font-normal">
                <!-- Notification Button -->
                <button aria-label="Notifications. You have 3 unread notifications" class="relative px-2 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200" id="notificationBtn">
                    <i class="fas fa-bell" aria-hidden="true"></i>
                    <span class="sr-only">3 unread</span>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[7px] rounded-full h-3 w-3 flex items-center justify-center" aria-hidden="true"></span>
                </button>

                <!-- Profile Dropdown Button -->
                <div class="relative" id="profileDropdown">
                    <button class="flex items-center px-2 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200" id="profileBtn">
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ Auth::guard('patient')->user()->full_name ?? 'Profile' }}</span>
                        <i class="fas fa-chevron-down ml-1 text-[10px]"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden z-50" id="profileDropdownMenu">
                        <div class="py-2">
                            <a href="{{ route('patient.profile') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>My Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 transition-colors">
                                <i class="fas fa-cog mr-2"></i>Settings
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form action="{{ route('patient.logout') }}" method="POST" class="block">
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
        <div class="lg:hidden hidden z-50" id="mobileMenu">
            <div class="px-2 pt-2 pb-3 space-y-1 text-sm border-t border-gray-200">
                <div class="px-3 py-2 text-sm text-gray-500">
                    {{ Auth::guard('patient')->user()->full_name ?? 'patient' }}
                </div>
                <!-- Main Navigation Links -->
                <a href="{{ route('patient.dashboard') }}" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-home mr-3"></i>Dashboard
                </a>
                <a href="{{ route('patient.myrecords') }}" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-file-medical-alt mr-3"></i>My Records
                </a>
                <a href="{{ route('patient.medicalHistory') }}" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-book-medical mr-3"></i>Medical History
                </a>
                <a href="{{ route('patient.permission') }}" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                    <i class="fas fa-shield-halved mr-3"></i>Access & Permissions
                </a>
                
                <!-- Mobile Notifications -->
                <button class="flex items-center w-full px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md" id="mobileNotificationBtn">
                    <i class="fas fa-bell mr-3"></i>Notifications
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </button>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-2"></div>

                <!-- Mobile Profile Section -->
                <div class="pt-2 mt-2">
                    <a href="{{ route('patient.profile') }}" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-user-edit mr-3"></i>Profile
                    </a>
                    <a href="#" class="flex items-center px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        <i class="fas fa-cog mr-3"></i>Settings
                    </a>
                    <form action="{{ route('patient.logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-3 py-2 text-red-600 hover:bg-red-50 rounded-md">
                            <i class="fas fa-sign-out-alt mr-3"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Search Modal -->
        <div class="lg:hidden hidden fixed inset-0 bg-gray-950/50 z-50" id="searchModal">
            <div class="bg-white w-full p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Search</h3>
                    <button class="text-gray-600 hover:text-gray-900" id="closeSearchModal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form action="{{ route('patient.myrecords') }}" method="GET">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg text-base text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            name="search" placeholder="Search records, medications..." autofocus>
                    </div>
                    <button type="submit" class="mt-3 w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>             