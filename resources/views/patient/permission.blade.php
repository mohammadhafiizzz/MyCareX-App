<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Access & Permissions</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Banner -->
    <section class="relative h-80 bg-gray-900 overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/access_permission.png') }}" 
                alt="" 
                class="w-full h-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gray-900/40"></div>
        </div>
        
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3">
                    Access & Permissions
                </h1>
                <p class="text-lg md:text-xl text-gray-200">
                    Manage who can access your records
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 lg:px-8 py-8">

        {{-- Success Message --}}
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Access Overview Cards --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            {{-- Total Doctors with Access Card --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                        <i class="fas fa-user-doctor text-blue-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $totalProvidersWithAccess ?? 0 }}</span>
                </div>
                <div class="mt-3">
                    <p class="text-sm font-medium text-gray-900">Doctors with Access</p>
                    <p class="text-xs text-gray-500">Currently accessing your records</p>
                </div>
            </div>

            {{-- Pending Access Requests Card --}}
            <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-amber-100">
                        <i class="fas fa-clock text-amber-600 text-xl" aria-hidden="true"></i>
                    </div>
                    <span class="text-3xl font-bold text-gray-900">{{ $pendingRequests ?? 0 }}</span>
                </div>
                <div class="mt-3 flex items-end justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Pending Requests</p>
                        <p class="text-xs text-gray-500">Awaiting your review</p>
                    </div>
                    <a href="{{ route('patient.permission.requests') }}" class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                        View <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>

        </section>

        {{-- Authorized Doctors List --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="doctors-heading">
            <div class="p-6">
                {{-- Header with Actions --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 id="doctors-heading" class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            All Authorized Doctors
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">Manage healthcare providers who currently have access to your medical records.</p>
                    </div>
                </div>

                @if ($totalProvidersWithAccess > 0)
                    {{-- Search Bar --}}
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                            </div>
                            <input 
                                type="text" 
                                id="doctor-search"
                                placeholder="Search by doctor name or facility..."
                                class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md text-sm leading-4 text-gray-700 bg-white hover:bg-gray-50"
                                aria-label="Search doctors"
                            >
                            <button 
                                type="button" 
                                id="clear-search"
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hover:bg-gray-100/50 rounded-full transition-all duration-200"
                                aria-label="Clear search">
                                <i class="fas fa-times" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Doctors List Header with Pagination --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <p class="text-sm text-gray-500" id="doctors-count">
                            Showing <span class="font-medium text-gray-900">{{ count($doctors) }}</span> doctor{{ count($doctors) !== 1 ? 's' : '' }}
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <i class="fas fa-sort-amount-down" aria-hidden="true"></i>
                                <span class="hidden sm:inline">Most recent first</span>
                            </div>
                            <div id="pagination-controls" class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    id="prev-page"
                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
                                    disabled>
                                    <i class="fas fa-chevron-left text-xs" aria-hidden="true"></i>
                                    <span class="hidden sm:inline">Previous</span>
                                </button>
                                <span class="text-sm text-gray-600 px-3 py-1.5 bg-gray-100/50 backdrop-blur-sm rounded-lg font-medium" id="page-info">Page 1 of 1</span>
                                <button 
                                    type="button" 
                                    id="next-page"
                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-white/20 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
                                    disabled>
                                    <span class="hidden sm:inline">Next</span>
                                    <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Doctors List --}}
                <div id="doctors-list">
                    @forelse ($doctors as $permission)
                        <div class="doctor-card bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow mb-4" 
                             data-doctor-name="{{ strtolower($permission->doctor->full_name ?? '') }}"
                             data-facility-name="{{ strtolower($permission->provider->organisation_name ?? '') }}">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100 overflow-hidden">
                                        @if($permission->doctor->profile_image_url)
                                            <img src="{{ asset($permission->doctor->profile_image_url) }}" alt="{{ $permission->doctor->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-user-md text-blue-600 text-xl" aria-hidden="true"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-md font-bold text-gray-900">{{ $permission->doctor->full_name ?? 'N/A' }}</h3>
                                        <p class="text-sm text-gray-500">{{ $permission->doctor->specialisation ?? 'Healthcare Provider' }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('patient.permission.view', $permission->id) }}" class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                    View <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4 border-t border-gray-50 pt-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Facility</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $permission->provider->organisation_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Granted</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $permission->granted_at ? $permission->granted_at->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Expires</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $permission->expiry_date ? $permission->expiry_date->format('M d, Y') : 'No Expiry' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50 rounded-lg">
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-doctor text-blue-600 text-3xl" aria-hidden="true"></i>
                            </div>
                            <p class="text-gray-600 font-medium text-lg">No authorized doctors found</p>
                            <p class="text-sm text-gray-500 mt-2">
                                No doctors currently have access to your records
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- No Results After Search --}}
                <div id="no-search-results" class="hidden text-center py-12">
                    <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No doctors found</h3>
                    <p class="text-sm text-gray-600 mb-4">We couldn't find any doctors matching your search</p>
                    <button type="button" id="clear-search-empty" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                        <i class="fas fa-times" aria-hidden="true"></i>
                        Clear search
                    </button>
                </div>
            </div>
        </section>

    </div>

    <!-- Revoke Permission Modal -->
    @include('patient.modules.permission.revokePermission')

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js', 'resources/js/main/permission/permission.js'])
    @include('patient.components.footer')

    <!-- Emergency Kit Floating Action Button -->
    @include('patient.components.emergencyFab')
</body>

</html>