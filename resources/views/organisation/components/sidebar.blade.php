<!-- Sidebar -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 bg-white shadow-lg transform transition-transform z-50 duration-300 ease-in-out w-68 pt-[68px] lg:pt-0 -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center p-4 border-b bg-blue-100 border-gray-200">
            <a href="{{ route('organisation.dashboard') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                    <small class="text-[10px] font-normal text-gray-500">Provider Portal</small>
                </div>
            </a>
            <button id="sidebarCloseBtn" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Organisation Info -->
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                        @if(Auth::guard('organisation')->user()->profile_image_url)
                            <img src="{{ asset(Auth::guard('organisation')->user()->profile_image_url) }}" alt="Profile" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-user-shield text-blue-600 text-lg"></i>
                        @endif
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ Auth::guard('organisation')->user()->organisation_name ?? 'Organisation' }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ Auth::guard('organisation')->user()->organisation_type ?? 'Healthcare Provider' }}
                    </p>

                    @if($isVerified)
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 mt-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle text-[10px]"></i>
                            Verified
                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-1 px-2 py-0.5 mt-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <i class="fas fa-clock text-[10px]"></i>
                            Unverified
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <!-- Dashboard -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Home</p>

                <a href="{{ route('organisation.dashboard') }}"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i
                        class="fas fa-home w-5 {{ request()->routeIs('organisation.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bell w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Notifications</span>
                    <span
                        class="ml-auto bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                </a>
            </div>

            @if ($isVerified)  
                <!-- Doctors Section - Unverified providers -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Doctors</p>

                    <a href="{{ route('organisation.doctors') }}"
                        class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.doctors') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-user-doctor w-5 {{ request()->routeIs('organisation.doctors') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                        <span class="ml-3">All Doctors</span>
                        <span
                            class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                    </a>

                    <a href="{{ route('organisation.addDoctor') }}"
                        class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.addDoctor') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-plus w-5 {{ request()->routeIs('organisation.addDoctor') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                        <span class="ml-3">Add Doctor</span>
                    </a>
                </div>

            @else
                <!-- Doctors Section - Unverified providers -->
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Doctors
                        <i class="fas fa-lock"></i>
                    </p>

                    <a href="#"
                        class="sidebar-link group flex cursor-not-allowed items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-search w-5 text-gray-400 group-hover:text-gray-600"></i>
                        <span class="ml-3">Search</span>
                    </a>

                    <a href="#"
                        class="sidebar-link group flex cursor-not-allowed items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-user-doctor w-5 text-gray-400 group-hover:text-gray-600"></i>
                        <span class="ml-3">All Doctors</span>
                        <span
                            class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                    </a>

                    <a href="#"
                        class="sidebar-link group flex cursor-not-allowed items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                        <i class="fas fa-plus w-5 text-gray-400 group-hover:text-gray-600"></i>
                        <span class="ml-3">Add Doctor</span>
                    </a>
                </div>
            @endif

            <!-- Profile -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Profile</p>

                <a href="{{ route('organisation.profile') }}"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.profile') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-building w-5 {{ request()->routeIs('organisation.profile') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                    <span class="ml-3">Organisation Profile</span>
                </a>

            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="mb-3">
                <a href="#"
                    class="group flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-question-circle w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Help & Support</span>
                </a>
            </div>
            <form action="{{ route('organisation.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay (for mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-gray-950/50 z-40 hidden"></div>

@vite('resources/js/main/organisation/sidebar.js')