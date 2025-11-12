<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Access Requests</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 lg:px-8 py-8">

        {{-- Breadcrumb Navigation --}}
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('patient.permission') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Access & Permissions
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2" aria-hidden="true"></i>
                        <span class="text-sm font-medium text-gray-500">Authorised Providers</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Back Button -->
        <!--
        <div class="mb-6">
            <a href="{{ route('patient.permission') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-arrow-left"></i>
                Back to Permissions
            </a>
        </div>
        -->

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Access Requests
            </h1>
            <p class="mt-1 text-lg text-gray-700">Manage Review pending requests from healthcare providers.</p>
        </div>

        <!-- Requests List -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Pending Access Requests
                    </h2>
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg font-medium">
                        {{ $requests->total() }} {{ Str::plural('Request', $requests->total()) }}
                    </span>
                </div>

                @forelse ($requests as $permission)
                    <div class="bg-gradient-to-r from-amber-50 to-white border-2 border-amber-200 rounded-xl p-6 mb-4 hover:shadow-md transition-all duration-200">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Provider Avatar -->
                                <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user-md text-amber-600 text-xl"></i>
                                </div>

                                <!-- Request Info -->
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $permission->provider->name ?? 'N/A' }}
                                        </h3>
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium">
                                            Pending Review
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ $permission->provider->specialty ?? 'Healthcare Provider' }}
                                    </p>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                        <div class="text-sm">
                                            <span class="text-gray-500">Facility:</span>
                                            <span class="font-medium text-gray-900 ml-1">
                                                {{ $permission->provider->facility_name ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="text-sm">
                                            <span class="text-gray-500">Requested:</span>
                                            <span class="font-medium text-gray-900 ml-1">
                                                {{ $permission->requested_at ? $permission->requested_at->format('M d, Y g:i A') : 'N/A' }}
                                            </span>
                                        </div>
                                        @if ($permission->permission_scope)
                                            <div class="text-sm md:col-span-2">
                                                <span class="text-gray-500">Requested Access To:</span>
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    @foreach (is_array($permission->permission_scope) ? $permission->permission_scope : [$permission->permission_scope] as $scope)
                                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                                            {{ ucfirst($scope) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($permission->notes)
                                        <div class="mt-3 p-3 bg-white border border-amber-200 rounded-lg">
                                            <p class="text-sm text-gray-700">
                                                <i class="fas fa-comment-alt text-amber-500 mr-2"></i>
                                                <span class="font-medium">Reason:</span> {{ $permission->notes }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col gap-2 ml-4">
                                <button class="px-5 py-2.5 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 focus-visible:ring-offset-2">
                                    <i class="fas fa-check mr-1"></i>
                                    Approve
                                </button>
                                <button class="px-5 py-2.5 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-600 focus-visible:ring-offset-2">
                                    <i class="fas fa-times mr-1"></i>
                                    Deny
                                </button>
                                <button class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Details
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-50 rounded-lg">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-blue-600 text-3xl"></i>
                        </div>
                        <p class="text-gray-600 font-medium text-lg">No pending requests</p>
                        <p class="text-sm text-gray-500 mt-2">
                            You don't have any pending access requests at the moment
                        </p>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($requests->hasPages())
                    <div class="mt-6 pt-6 border-t border-gray-200">
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
