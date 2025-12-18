<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Request Access</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Access Requests</h1>
                    <p class="mt-1 text-sm text-gray-600">View and manage all permission requests you've made to patients.</p>
                </div>

                <!-- Search Bar -->
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <form action="{{ route('doctor.permission.requests') }}" method="GET" class="flex gap-3">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input 
                                    type="text" 
                                    name="query" 
                                    value="{{ $query ?? '' }}"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    placeholder="Search by patient name or IC number...">
                            </div>
                        </div>
                        <button 
                            type="submit"
                            class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                        @if($query)
                            <a 
                                href="{{ route('doctor.permission.requests') }}"
                                class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Clear
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Results Info -->
                @if($query)
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">
                            Showing results for "<span class="font-semibold text-gray-900">{{ $query }}</span>"
                            <span class="text-gray-400">•</span>
                            {{ $permissions->total() }} {{ Str::plural('result', $permissions->total()) }} found
                        </p>
                    </div>
                @endif

                <!-- Permissions List -->
                @if($permissions->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            IC Number
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Requested Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Notes
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            More Info
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($permissions as $permission)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        @if($permission->patient->profile_image_url)
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($permission->patient->profile_image_url) }}" alt="{{ $permission->patient->full_name }}">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                                <i class="fas fa-user text-blue-600 text-sm"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $permission->patient->full_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $permission->patient->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $permission->patient->ic_number }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    {{ $permission->requested_at->format('d M Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $permission->requested_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($permission->status === 'Pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Pending
                                                    </span>
                                                @elseif($permission->status === 'Active')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Approved
                                                    </span>
                                                @elseif($permission->status === 'Rejected')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        Rejected
                                                    </span>
                                                @elseif($permission->status === 'Expired')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <i class="fas fa-calendar-times mr-1"></i>
                                                        Expired
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        {{ $permission->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($permission->notes)
                                                    <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $permission->notes }}">
                                                        {{ $permission->notes }}
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400 italic">No notes</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" class="inline-flex items-center mr-2 px-4 py-2 border border-blue-300 shadow-sm text-blue-600 hover:text-blue-800 hover:bg-blue-200 text-sm font-medium rounded-lg transition-colors duration-200">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($permissions->hasPages())
                            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                {{ $permissions->links() }}
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            @if($query)
                                No results found
                            @else
                                No access requests yet
                            @endif
                        </h3>
                        <p class="text-gray-500 mb-6">
                            @if($query)
                                Try adjusting your search criteria or clear the search to see all requests.
                            @else
                                You haven't requested access to any patient records yet.
                            @endif
                        </p>
                        @if($query)
                            <a href="{{ route('doctor.permission.requests') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-list mr-2"></i>
                                View All Requests
                            </a>
                        @else
                            <a href="{{ route('doctor.patient.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Search Patients
                            </a>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

</body>

</html>