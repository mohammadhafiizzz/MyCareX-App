<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Healthcare Provider Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('admin.components.header')

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-100">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                    <!-- Page Header -->
                    <div class="md:flex md:items-center md:justify-between mb-6">
                        <div class="flex-1 min-w-0">
                            <h2 id="pageHeader" class="text-xl font-bold leading-7 text-gray-900 sm:text-2xl sm:truncate">
                                Healthcare Provider
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Review and manage healthcare provider
                            </p>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
                        
                        <!-- Healthcare Providers -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-blue-100 p-3">
                                            <i class="fas fa-hospital text-blue-600 text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">Providers</p>
                                        <p class="text-2xl font-semibold text-gray-900">{{ $providerCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Healthcare Providers Request -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-blue-100 p-3">
                                            <i class="fas fa-hand-holding-medical text-blue-600 text-2xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-500 truncate">New Requests</p>
                                        <p class="text-2xl font-semibold text-gray-900">{{ $requestCount }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('organisation.providerVerification') }}" class="text-xs font-medium px-18 text-blue-500 hover:underline cursor-pointer truncate">View Request</a>
                            </div>
                        </div>
                    </div>

                    <!-- Provider List Table -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 id="tableHeader" class="text-lg leading-6 font-medium text-gray-900">Provider List</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                All registered healthcare providers
                            </p>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Provider Details
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact Info
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Registration Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            More Info
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="providerTableBody" class="bg-white divide-y divide-gray-200">
                                    @forelse ($providers as $provider)
                                        <tr class="hover:bg-gray-50">

                                            <!-- Provider Details -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <div
                                                            class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                            <span class="text-sm font-medium text-white">
                                                                {{ \Illuminate\Support\Str::of($provider->organisation_name)->split('/\s+/')->map(fn($p) => $p[0])->join('') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $provider->organisation_name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $provider->formatted_id }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Provider Type -->
                                            <td class="px-6 py-4 font-medium whitespace-nowrap text-gray-900">
                                                {{ ucfirst($provider->organisation_type) }}
                                            </td>

                                            <!-- Contact -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $provider->email }}</div>
                                                <div class="text-sm text-gray-500">{{ $provider->phone_number }}</div>
                                            </td>

                                            <!-- Registration date -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $provider->created_at->format('M j, Y') }}
                                            </td>

                                            <!-- More Info -->
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button
                                                    class="text-blue-500 cursor-pointer hover:text-blue-600 hover:underline rounded-md font-medium text-sm"
                                                    onclick="viewMore()">
                                                    View More
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="p-6 text-center text-gray-500">
                                                No {{ strtolower($defaultStatus) }} providers found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->

    @include('admin.components.footer')
    
</body>

</html>