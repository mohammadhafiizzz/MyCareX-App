<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Doctors</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('organisation.components.header')

    <!-- Sidebar -->
    @include('organisation.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Doctor Management
                    </h1>
                    <p class="mt-1 text-lg text-gray-700">Manage and monitor your healthcare professionals.</p>
                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Doctors List Section -->
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="doctors-heading">
                    <div class="p-6">
                        {{-- Header with Actions --}}
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                            <div>
                                <h2 id="doctors-heading" class="text-xl font-semibold text-gray-900">Doctors List</h2>
                                <p class="mt-1 text-sm text-gray-600">Search and manage your registered doctors.</p>
                            </div>
                        </div>

                        @if ($totalDoctors > 0)
                            {{-- Search Bar --}}
                            <div class="mb-4">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="doctor-search"
                                        placeholder="Search by doctor name or IC number..."
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
                            <div class="overflow-x-auto border border-gray-200 rounded-xl">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialisation</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse ($doctors as $doctor)
                                            <tr class="doctor-row hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center overflow-hidden">
                                                            @if($doctor->profile_image_url)
                                                                <img src="{{ asset($doctor->profile_image_url) }}" alt="{{ $doctor->full_name }}" class="h-full w-full object-cover">
                                                            @else
                                                                <span class="text-sm font-bold">{{ substr($doctor->full_name, 0, 1) }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 doctor-name">{{ $doctor->full_name }}</div>
                                                            <div class="text-sm text-gray-500">{{ $doctor->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 doctor-ic">
                                                    {{ $doctor->ic_number }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $doctor->specialisation ?? 'General Practitioner' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $doctor->active_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $doctor->active_status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('organisation.doctor.profile', $doctor->id) }}" 
                                                        class="px-4 py-2 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-100">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            {{-- Handled by the empty state below if no doctors exist at all --}}
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if(count($doctors) == 0)
                                <div class="text-center py-16">
                                    <div class="relative inline-block mb-6">
                                        <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-md text-blue-600 text-5xl" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No doctors registered yet</h3>
                                    <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                                        Start by adding doctors to your organisation to manage their profiles and access.
                                    </p>

                                    <a href="{{ route('organisation.addDoctor') }}" class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white rounded-2xl text-base font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                                        <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                        Add your first doctor
                                    </a>
                                </div>
                            @endif

                            {{-- No Results After Search --}}
                            <div id="no-search-results" class="hidden text-center py-12">
                                <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No doctors found</h3>
                                <p class="text-sm text-gray-600 mb-4">We couldn't find any doctors matching your search</p>
                                <button type="button" id="reset-search" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500/10 backdrop-blur-md text-blue-700 rounded-xl border border-blue-400/20 shadow-sm text-sm font-medium hover:bg-blue-500/20 hover:shadow-md transition-all duration-200">
                                    <i class="fas fa-times" aria-hidden="true"></i>
                                    Clear search
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->

    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/header.js', 'resources/js/main/organisation/doctor.js'])
</body>

</html>