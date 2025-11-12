<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

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

        {{-- Access Overview Cards --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            
            {{-- Total Providers with Access Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-sky-500 to-sky-600 text-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/15 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative p-8">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/90 mb-2">Providers with Access</p>
                            <p class="text-5xl font-bold mb-2" aria-live="polite">{{ $totalProvidersWithAccess ?? 0 }}</p>
                            <p class="text-sm text-white/80">
                                Healthcare providers currently accessing your records
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-hospital text-3xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-white/20">
                        <a href="{{ route('patient.permission.providers') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                            <i class="fas fa-users" aria-hidden="true"></i>
                            View All Providers
                            <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Pending Access Requests Card --}}
            <article class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-600 text-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/15 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative p-8">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <p class="text-sm uppercase tracking-wide text-white/90 mb-2">Pending Requests</p>
                            <p class="text-5xl font-bold mb-2" aria-live="polite">{{ $pendingRequests ?? 0 }}</p>
                            <p class="text-sm text-white/80">
                                Providers requesting access to your records
                            </p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-3xl" aria-hidden="true"></i>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-white/20">
                        <a href="{{ route('patient.permission.requests') }}" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 backdrop-blur-sm text-white text-sm font-semibold rounded-lg border border-white/30 hover:bg-white/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2">
                            <i class="fas fa-inbox" aria-hidden="true"></i>
                            Review Requests
                            <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </article>

        </section>

        {{-- Recent Activity Timeline --}}
        <section class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-history text-blue-600" aria-hidden="true"></i>
                        Recent Activity
                    </h2>
                    <a href="{{ route('patient.permission.activity') }}" 
                       aria-label="View all activity"
                       class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                        View Full History <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <p class="text-sm text-gray-600 mb-6">
                    Track the latest changes made to your medical records by healthcare providers
                </p>

                @forelse ($recentActivities ?? [] as $index => $activity)
                    <div class="relative {{ !$loop->last ? 'pb-8' : '' }}">
                        {{-- Timeline Line --}}
                        @if (!$loop->last)
                            <span class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                        @endif

                        <div class="relative flex items-start space-x-4">
                            {{-- Timeline Icon --}}
                            <div class="relative flex items-center justify-center">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center
                                    {{ $activity->action_type === 'created' ? 'bg-green-100' : '' }}
                                    {{ $activity->action_type === 'updated' ? 'bg-blue-100' : '' }}
                                    {{ $activity->action_type === 'deleted' ? 'bg-red-100' : '' }}
                                    {{ !in_array($activity->action_type, ['created', 'updated', 'deleted']) ? 'bg-gray-100' : '' }}">
                                    <i class="
                                        {{ $activity->action_type === 'created' ? 'fas fa-plus text-green-600' : '' }}
                                        {{ $activity->action_type === 'updated' ? 'fas fa-edit text-blue-600' : '' }}
                                        {{ $activity->action_type === 'deleted' ? 'fas fa-trash text-red-600' : '' }}
                                        {{ !in_array($activity->action_type, ['created', 'updated', 'deleted']) ? 'fas fa-file-medical text-gray-600' : '' }}"
                                        aria-hidden="true">
                                    </i>
                                </div>
                            </div>

                            {{-- Activity Content --}}
                            <div class="flex-1 bg-gradient-to-r from-gray-50 to-white border border-gray-200 rounded-xl p-5 hover:shadow-md transition-all duration-200">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-base font-semibold text-gray-900">
                                                {{ $activity->provider_name ?? 'Unknown Provider' }}
                                            </h3>
                                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $activity->action_type === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $activity->action_type === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $activity->action_type === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ !in_array($activity->action_type, ['created', 'updated', 'deleted']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($activity->action_type ?? 'modified') }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-700 mb-2">
                                            <span class="font-medium">{{ $activity->record_type ?? 'Record' }}:</span>
                                            {{ $activity->record_name ?? 'N/A' }}
                                        </p>

                                        @if (!empty($activity->description))
                                            <p class="text-sm text-gray-600 mb-3">
                                                {{ $activity->description }}
                                            </p>
                                        @endif

                                        <div class="flex items-center gap-4 text-xs text-gray-500">
                                            <span class="flex items-center gap-1">
                                                <i class="far fa-clock" aria-hidden="true"></i>
                                                {{ $activity->created_at ? $activity->created_at->format('M d, Y g:i A') : 'N/A' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fas fa-hospital" aria-hidden="true"></i>
                                                {{ $activity->facility_name ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-50 rounded-lg">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-history text-blue-600 text-3xl" aria-hidden="true"></i>
                        </div>
                        <p class="text-gray-600 font-medium text-lg">No recent activity found</p>
                        <p class="text-sm text-gray-500 mt-2">
                            When healthcare providers make changes to your records, they will appear here
                        </p>
                    </div>
                @endforelse

                @if (isset($recentActivities) && count($recentActivities) > 0)
                    <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                        <a href="{{ route('patient.permission.activity') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg font-medium text-sm hover:bg-blue-700 transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600 focus-visible:ring-offset-2">
                            <i class="fas fa-list" aria-hidden="true"></i>
                            View Full Activity History
                        </a>
                    </div>
                @endif
            </div>
        </section>

    </div>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>