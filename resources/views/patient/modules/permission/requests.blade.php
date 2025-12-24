<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Access Requests</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-7">
            <a href="{{ route('patient.permission') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left text-xs"></i> Back to Permissions
            </a>
        </div>

        <!-- Requests List -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                            Pending Access Requests
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">Review doctors who are requesting access to your medical records.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @forelse ($requests as $permission)
                        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
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
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('patient.permission.confirm', $permission->id) }}" class="inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                        Review <i class="fas fa-arrow-right text-xs"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-50 pt-4">
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Facility</p>
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $permission->provider->organisation_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Requested On</p>
                                    <p class="text-sm font-medium text-gray-900">{{ $permission->requested_at ? $permission->requested_at->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-bold text-gray-400">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        <i class="fas fa-clock mr-1.5 text-[10px]"></i> Pending
                                    </span>
                                </div>
                            </div>

                            @if($permission->notes)
                                <div class="mt-4 p-3 bg-blue-50/50 rounded-lg border border-blue-100/50">
                                    <p class="text-xs text-gray-600 italic">
                                        <i class="fas fa-quote-left text-blue-300 mr-2"></i>
                                        {{ $permission->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-16 bg-gray-50 rounded-lg">
                            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-hand-holding-medical text-blue-600 text-3xl"></i>
                            </div>
                            <p class="text-gray-600 font-medium text-lg">No pending requests</p>
                            <p class="text-sm text-gray-500 mt-2">
                                You don't have any pending access requests at the moment
                            </p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if ($requests->hasPages())
                    <div class="mt-8">
                        {{ $requests->links() }}
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
