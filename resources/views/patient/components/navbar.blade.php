<nav class="bg-white shadow-sm border-b border-t border-gray-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between h-15">
            <div class="flex items-center">
                <!-- Main Navigation -->
                <div class="hidden md:ml-8 md:flex md:space-x-1">
                    <a href="{{ route('patient.dashboard') }}"
                       class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-home text-gray-400 group-hover:text-gray-600 mr-2"></i>Dashboard
                    </a>
                    <a href="{{ route('patient.myrecords') }}"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-file-medical-alt text-gray-400 group-hover:text-gray-600 mr-2"></i>My Records
                    </a>
                    <a href="#"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-shield-halved text-gray-400 group-hover:text-gray-600 mr-2"></i>Access & Permissions
                    </a>
                    <a href="#"
                        class="text-gray-700 hover:bg-gray-100 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-clock-rotate-left text-gray-400 group-hover:text-gray-600 mr-2"></i>History
                    </a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center space-x-4">
                <!-- Logout -->
                <form action="#" method="POST" class="hidden md:block">
                    @csrf
                    <input type="text"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        id="searchInput" name="search_value" placeholder="Search">
                </form>
            </div>
        </div>
    </div>
</nav>

@vite('resources/js/main/patient/navbar.js')