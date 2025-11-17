<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 bg-white shadow-lg transform transition-transform z-30 duration-300 ease-in-out w-68 pt-[68px] lg:pt-0">
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
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-hospital text-blue-600 text-lg"></i>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ Auth::guard('organisation')->user()->organisation_name ?? 'Organisation' }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ Auth::guard('organisation')->user()->organisation_type ?? 'Healthcare Provider' }}
                    </p>
                    @php
                        $organisation = auth()->guard('organisation')->user();
                        $isVerified = $organisation && $organisation->verification_status === 'Approved';
                    @endphp
                    @if($isVerified)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 mt-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle text-[10px]"></i>
                            Verified
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 mt-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
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
            <a href="{{ route('organisation.dashboard') }}" 
               class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('organisation.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <i class="fas fa-home w-5 {{ request()->routeIs('organisation.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                <span class="ml-3">Dashboard</span>
            </a>

            <!-- Patients Section -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Patient Management</p>
                
                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-users w-5 text-gray-400"></i>
                    <span class="ml-3">All Patients</span>
                    <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-user-plus w-5 text-gray-400"></i>
                    <span class="ml-3">Register Patient</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-search w-5 text-gray-400"></i>
                    <span class="ml-3">Search Records</span>
                </a>
            </div>

            <!-- Access & Permissions -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Access Control</p>
                
                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-shield-halved w-5 text-gray-400"></i>
                    <span class="ml-3">Permissions</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-key w-5 text-gray-400"></i>
                    <span class="ml-3">Access Requests</span>
                    <span class="ml-auto bg-amber-100 text-amber-800 text-xs font-semibold px-2 py-0.5 rounded-full">0</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-history w-5 text-gray-400"></i>
                    <span class="ml-3">Audit Log</span>
                </a>
            </div>

            <!-- Reports & Analytics -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Reports</p>
                
                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-chart-bar w-5 text-gray-400"></i>
                    <span class="ml-3">Analytics</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-file-medical w-5 text-gray-400"></i>
                    <span class="ml-3">Medical Reports</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-download w-5 text-gray-400"></i>
                    <span class="ml-3">Export Data</span>
                </a>
            </div>

            <!-- Settings -->
            <div class="pt-2">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Settings</p>
                
                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-building w-5 text-gray-400"></i>
                    <span class="ml-3">Organisation Profile</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-user-md w-5 text-gray-400"></i>
                    <span class="ml-3">Staff Management</span>
                </a>

                <a href="#" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <i class="fas fa-cog w-5 text-gray-400"></i>
                    <span class="ml-3">Settings</span>
                </a>
            </div>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="mb-3">
                <a href="#" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-question-circle w-5 text-gray-400"></i>
                    <span class="ml-3">Help & Support</span>
                </a>
            </div>
            <form action="{{ route('organisation.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span class="ml-3">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay (for mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

@vite('resources/js/main/organisation/sidebar.js')