<!-- Sidebar -->
<aside id="sidebar"
    class="fixed inset-y-0 left-0 bg-white shadow-lg transform transition-transform z-50 duration-300 ease-in-out w-68 pt-[68px] lg:pt-0 -translate-x-full lg:translate-x-0">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center p-4 border-b bg-blue-100 border-gray-200">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                    <small class="text-[10px] font-normal text-gray-500">Admin Portal</small>
                </div>
            </a>
            <button id="sidebarCloseBtn" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Admin Info -->
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user-shield text-blue-600 text-lg"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ Auth::guard('admin')->user()->full_name ?? 'Admin' }}
                    </p>
                    <p class="text-xs text-gray-500 truncate capitalize">
                        {{ Auth::guard('admin')->user()->role ?? 'Administrator' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <!-- Dashboard -->
            <div>
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Home</p>

                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i
                        class="fas fa-home w-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-bell w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Notifications</span>
                    <span class="ml-auto bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                </a>
            </div>

            <!-- Administration Section -->
            @if(Auth::guard('admin')->user()->role === 'superadmin')
                <div class="pt-2">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Administration</p>

                    <a href="{{ route('admin.management') }}"
                        class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.management') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i
                            class="fas fa-user-shield w-5 {{ request()->routeIs('admin.management') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                        <span class="ml-3">Admin Management</span>
                    </a>
                </div>
            @endif

            <!-- Healthcare Providers Section -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Healthcare Providers
                </p>

                <a href="{{ route('organisation.providerManagement') }}"
                    class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.providerManagement') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i
                        class="fas fa-hospital w-5 {{ request()->routeIs('organisation.providerManagement') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                    <span class="ml-3">Provider Management</span>
                </a>
            </div>

            <!-- Reports & Analytics -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Reports & Analytics
                </p>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-clipboard-list w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Activity Log</span>
                </a>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-download w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Export Data</span>
                </a>
            </div>

            <!-- Settings -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Settings</p>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-user w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">My Profile</span>
                </a>

                <a href="#"
                    class="sidebar-link group flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-cog w-5 text-gray-400 group-hover:text-gray-600"></i>
                    <span class="ml-3">Settings</span>
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
            <form action="{{ route('admin.logout') }}" method="POST">
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

@vite('resources/js/main/admin/sidebar.js')