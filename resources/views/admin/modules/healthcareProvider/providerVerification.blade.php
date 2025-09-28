<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Healthcare Provider Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <div class="flex h-screen bg-gray-100">

        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Main Content -->
        <div class="flex-1 w-max flex flex-col overflow-hidden">

            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b h-20 border-gray-200">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900">Healthcare Provider Management</h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">
                                {{ now()->format('F j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

                    <!-- Page Header -->
                    <div class="md:flex md:items-center md:justify-between mb-6">
                        <div class="flex-1 min-w-0">
                            <div class="mb-4">
                                <button class="text-blue-500 hover:underline cursor-pointer">
                                    <i class="fas fa-arrow-left text-blue-500"></i>
                                    <a href="{{ route('organisation.providerManagement') }}" class="text-sm font-medium truncate">Back</a>
                                </button>
                            </div>
                            <h2 id="pageHeader" class="text-xl font-bold leading-7 text-gray-900 sm:text-2xl sm:truncate">
                                Pending Healthcare Provider Verifications
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Review and manage healthcare provider verification requests
                            </p>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                        <div data-status="pending" class="status-card bg-white overflow-hidden shadow rounded-lg cursor-pointer {{ $defaultStatus == 'pending' ? 'ring-1 ring-blue-500' : '' }}">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Pending</p>
                                        <p class="text-lg font-semibold text-gray-900" id="pendingCount">{{ $pendingCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-status="approved" class="status-card bg-white overflow-hidden shadow rounded-lg cursor-pointer {{ $defaultStatus == 'approved' ? 'ring-1 ring-blue-500' : '' }}">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Approved</p>
                                        <p class="text-lg font-semibold text-gray-900" id="approvedCount">{{ $approvedCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-status="rejected" class="status-card bg-white overflow-hidden shadow rounded-lg cursor-pointer {{ $defaultStatus == 'rejected' ? 'ring-1 ring-blue-500' : '' }}">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Rejected</p>
                                        <p class="text-lg font-semibold text-gray-900" id="rejectedCount">{{ $rejectedCount }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Providers Table -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 id="tableHeader" class="text-lg leading-6 font-medium text-gray-900">Pending Verification Requests</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Provider accounts awaiting verification approval
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
                                            Contact Info
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Registration Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="providerTableBody" class="bg-white divide-y divide-gray-200">
                                    @forelse ($providers as $provider)
                                        <tr class="hover:bg-gray-50">
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

                                            <!-- Contact -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $provider->email }}</div>
                                                <div class="text-sm text-gray-500">{{ $provider->phone_number }}</div>
                                            </td>

                                            <!-- Registration date -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $provider->created_at->format('M j, Y') }}
                                            </td>

                                            <!-- Status badge -->
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $status = $provider->verification_status;
                                                    $colors = [
                                                        'Approved' => ['bg' => 'green', 'icon' => 'check-circle'],
                                                        'Rejected' => ['bg' => 'red', 'icon' => 'times-circle'],
                                                        'Pending' => ['bg' => 'yellow', 'icon' => 'clock']
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    bg-{{ $colors[$status]['bg'] }}-100 text-{{ $colors[$status]['bg'] }}-800">
                                                    <i class="fas fa-{{ $colors[$status]['icon'] }} mr-1"></i> {{ $status }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-2">
                                                    <button type="button" data-id="{{ $provider->id }}" class="action-btn approve cursor-pointer inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" data-id="{{ $provider->id }}" class="action-btn reject cursor-pointer inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
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
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden" id="sidebarOverlay"></div>

    <!-- Confirmation Modal -->
    <div class="fixed inset-0 bg-gray-950/50 overflow-y-auto h-full w-full hidden" id="confirmationModal">
        <div class="relative top-50 left-30 mx-auto p-5 w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100" id="modalIcon">
                    <i class="fas fa-exclamation-triangle text-red-600" id="modalIconClass"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2" id="modalTitle">Confirm Action</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modalMessage">
                        Are you sure you want to perform this action? This cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="modalConfirm"
                        class="cursor-pointer px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Confirm
                    </button>
                    <button id="modalCancel"
                        class="cursor-pointer mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="successNotification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3">
            <i class="fas fa-check-circle"></i>
            <span id="notificationMessage">Action completed successfully</span>
            <button id="closeNotification" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    @vite('resources/js/main/organisation/providerManagement.js')
</body>

</html>