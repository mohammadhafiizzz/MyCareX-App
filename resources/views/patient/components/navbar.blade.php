<nav class="bg-white shadow-sm border-b border-t border-gray-200 sticky top-0 z-40 hidden md:block">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between h-15">
            <div class="flex items-center">
                <!-- Main Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-1">
                    <a href="{{ route('patient.dashboard') }}"
                       class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-home  mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('patient.myrecords') }}"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-file-medical-alt  mr-2"></i>My Records
                    </a>
                    <a href="#"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-shield-halved  mr-2"></i>Access & Permissions
                    </a>
                    <a href="#"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-life-ring  mr-2"></i>Help
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Search Form -->
                <form action="{{ route('patient.myrecords') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text"
                            class="pl-10 pr-3 py-2 border border-gray-300 rounded-md text-sm leading-4 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 focus:border-blue-500 transition-colors w-64"
                            id="searchInput" name="search" placeholder="Search records, medications...">
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

@vite('resources/js/main/patient/navbar.js')