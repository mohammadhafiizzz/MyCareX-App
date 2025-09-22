<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Admin Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        
        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button type="button" class="fixed top-4 left-4 z-50 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" id="mobile-menu-button">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b h-20 border-gray-200">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">
                                {{ now()->format('F j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    
                    <!-- Welcome Card -->
                    <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-user-crown text-blue-500 text-3xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-lg font-medium text-gray-900">
                                        Welcome back, {{ Auth::guard('admin')->user()->full_name }}!
                                    </h2>
                                    <p class="text-sm text-gray-500">
                                        You are logged in as {{ ucfirst(Auth::guard('admin')->user()->role) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        
                        <!-- Total Patients -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-users text-blue-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">Total Patients</p>
                                        <p class="text-2xl font-semibold text-gray-900">1,234</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Healthcare Providers -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-hospital text-green-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">Providers</p>
                                        <p class="text-2xl font-semibold text-gray-900">45</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(Auth::guard('admin')->user()->role === 'superadmin')
                        <!-- Total Admins -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-user-shield text-purple-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">Admins</p>
                                        <p class="text-2xl font-semibold text-gray-900">12</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Status -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-server text-green-500 text-2xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">System Status</p>
                                        <p class="text-lg font-semibold text-green-600">Online</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Recent Activities</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">Latest system activities and updates</p>
                        </div>
                        <ul class="divide-y divide-gray-200">
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-user-plus text-green-500 mr-3"></i>
                                        <span class="text-sm text-gray-900">New patient registered</span>
                                    </div>
                                    <span class="text-sm text-gray-500">2 hours ago</span>
                                </div>
                            </li>
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-hospital text-blue-500 mr-3"></i>
                                        <span class="text-sm text-gray-900">Healthcare provider updated</span>
                                    </div>
                                    <span class="text-sm text-gray-500">4 hours ago</span>
                                </div>
                            </li>
                            @if(Auth::guard('admin')->user()->role === 'superadmin')
                            <li class="px-6 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-shield-alt text-purple-500 mr-3"></i>
                                        <span class="text-sm text-gray-900">System backup completed</span>
                                    </div>
                                    <span class="text-sm text-gray-500">6 hours ago</span>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden" id="sidebar-overlay"></div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    </script>
</body>

</html>