<!-- Doctor Navigation Header -->
<nav class="bg-white shadow-sm fixed top-0 right-0 left-0 z-30 lg:left-64 transition-all duration-300" id="topHeader">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-between h-15">
            <!-- Mobile Menu Button & Logo -->
            <div class="flex items-center space-x-4">
                <button class="lg:hidden focus:outline-none" id="sidebarToggleBtn">
                    <i class="fas fa-bars text-gray-600 text-xl"></i>
                </button>
                <a href="{{ route('doctor.dashboard') }}" class="lg:hidden flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                        <small class="text-[10px] font-normal text-gray-500">
                            Doctor Portal
                        </small>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-4 text-sm font-normal">
                <!-- Today's Date -->
                <div class="flex items-center gap-2 px-3 py-1.5 text-gray-600">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ date('F j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</nav>