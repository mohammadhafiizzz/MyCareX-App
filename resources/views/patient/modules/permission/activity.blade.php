<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Activity History</title>
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
                        <span class="text-sm font-medium text-gray-500">Activity History</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Activity History
            </h1>
            <p class="mt-1 text-lg text-gray-700">Complete record of modifications to your medical data.</p>
        </div>

        <!-- Activity Table -->
        <section class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Complete Activity Log
                    </h2>
                </div>

                <p class="text-sm text-gray-600 mb-6">
                    This table shows all modifications made to your medical records by healthcare providers. Activities are tracked in real-time and displayed with the most recent changes first.
                </p>

                @if (count($activities) > 0)
                    <!-- Activity Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date & Time
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Provider
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Record Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Facility
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($activities as $activity)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $activity->created_at->format('M d, Y') }}<br>
                                            <span class="text-gray-500">{{ $activity->created_at->format('g:i A') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user-md text-blue-600"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $activity->provider_name ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-medium
                                                {{ $activity->action_type === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $activity->action_type === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $activity->action_type === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ !in_array($activity->action_type, ['created', 'updated', 'deleted']) ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($activity->action_type ?? 'modified') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $activity->record_type ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <p class="font-medium">{{ $activity->record_name ?? 'N/A' }}</p>
                                            @if (!empty($activity->description))
                                                <p class="text-xs text-gray-500 mt-1">{{ $activity->description }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $activity->facility_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">{{ count($activities) }}</span> of <span class="font-medium">{{ count($activities) }}</span> results
                            </div>
                            <div class="flex gap-2">
                                <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                                    Previous
                                </button>
                                <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-medium cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16 bg-gray-50 rounded-lg">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-history text-blue-600 text-3xl"></i>
                        </div>
                        <p class="text-gray-600 font-medium text-lg">No activity history available</p>
                        <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                            Activity tracking is not yet implemented. Once the modification tracking tables are created, all changes made by healthcare providers to your records will be displayed here.
                        </p>
                        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg max-w-2xl mx-auto">
                            <p class="text-sm text-blue-800">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Coming Soon:</strong> Detailed tracking of all modifications including who made changes, what was changed, and when it occurred.
                            </p>
                        </div>
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
