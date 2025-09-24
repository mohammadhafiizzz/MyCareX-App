<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-75 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
    id="sidebar">

    <!-- Logo -->
    <div class="flex items-center justify-center h-20 shadow-md bg-blue-600">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
            <div class="flex flex-col">
                <span class="text-xl font-semibold text-white">MyCareX</span>
                <small class="text-xs font-normal text-blue-100">Admin Portal</small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="mt-5 flex-1 px-2 bg-white space-y-1">

        <!-- Dashboard - remove default blue classes -->
        <a href="{{ route('admin.dashboard') }}"
            class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md"
            data-nav-item="dashboard">
            <i class="fas fa-tachometer-alt text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
            Dashboard
        </a>

        <!-- Admin Management - Superadmin only -->
        @if(Auth::guard('admin')->user()->role === 'superadmin')
            <a href="{{ route('admin.management') }}"
                class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md"
                data-nav-item="admin-management">
                <i class="fas fa-user-shield text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
                Admin Management
            </a>
        @endif

        <!-- Healthcare Provider Management -->
        <a href="#"
            class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <i class="fas fa-hospital text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
            Healthcare Providers
        </a>

        <!-- User Growth - Superadmin only -->
        @if(Auth::guard('admin')->user()->role === 'superadmin')
            <a href="#"
                class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <i class="fas fa-chart-line text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
                User Growth
            </a>
        @endif

        <!-- Reports -->
        <a href="#"
            class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <i class="fas fa-file-alt text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
            Reports
        </a>

        <!-- System Logs - Superadmin only -->
        @if(Auth::guard('admin')->user()->role === 'superadmin')
            <a href="#"
                class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                <i class="fas fa-clipboard-list text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
                System Logs
            </a>
        @endif

        <!-- Settings -->
        <a href="#"
            class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <i class="fas fa-cogs text-gray-400 group-hover:text-gray-600 mr-3 text-lg"></i>
            Settings
        </a>
    </nav>

    <!-- User Profile & Logout -->
    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-sm"></i>
                </div>
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-medium text-gray-700">
                    {{ Auth::guard('admin')->user()->full_name }}
                </p>
                <p class="text-xs text-gray-500 capitalize">
                    {{ Auth::guard('admin')->user()->role }}
                </p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST" class="ml-2">
                @csrf
                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer"
                    title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </div>
</div>

@vite('resources/js/main/admin/sidebarNav.js')