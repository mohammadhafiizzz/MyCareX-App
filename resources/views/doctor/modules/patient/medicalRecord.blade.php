<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medical Records</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter]">

    <!-- Header -->
    @include('doctor.components.header')

    <!-- Sidebar -->
    @include('doctor.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Medical Records</h1>
                    <p class="text-xs sm:text-sm text-gray-500">Manage and monitor patient medical records you have access to.</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                    <!-- Conditions Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                                <i class="fas fa-heartbeat text-blue-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['conditions'] }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-900">Conditions</p>
                            <p class="text-xs text-gray-500">Total medical conditions</p>
                        </div>
                    </div>

                    <!-- Medications Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                                <i class="fas fa-pills text-blue-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['medications'] }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-900">Medications</p>
                            <p class="text-xs text-gray-500">Active prescriptions</p>
                        </div>
                    </div>

                    <!-- Allergies Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                                <i class="fas fa-allergies text-blue-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['allergies'] }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-900">Allergies</p>
                            <p class="text-xs text-gray-500">Known patient allergies</p>
                        </div>
                    </div>

                    <!-- Immunisations Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                                <i class="fas fa-syringe text-blue-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['immunisations'] }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-900">Immunisations</p>
                            <p class="text-xs text-gray-500">Vaccination records</p>
                        </div>
                    </div>

                    <!-- Lab Tests Card -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center justify-center h-12 w-12 rounded-xl bg-blue-100">
                                <i class="fas fa-flask text-blue-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <span class="text-3xl font-bold text-gray-900">{{ $stats['labs'] }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-900">Lab Tests</p>
                            <p class="text-xs text-gray-500">Diagnostic test results</p>
                        </div>
                    </div>
                </div>

                <!-- Records Section -->
                <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8" aria-labelledby="records-heading">
                    <div class="p-4 sm:p-6">
                        {{-- Header with Actions --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <div>
                                <h2 id="records-heading" class="text-lg sm:text-xl font-semibold text-gray-900">All Medical Records</h2>
                                <p class="mt-1 text-xs sm:text-sm text-gray-600">Search and filter patient medical records you have access to.</p>
                            </div>
                        </div>

                        {{-- Search Bar --}}
                        <div class="mb-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400" aria-hidden="true"></i>
                                </div>
                                <input 
                                    type="text" 
                                    id="doctor-search"
                                    placeholder="Search by patient name, IC number, or record name..."
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-md text-sm leading-4 text-gray-700 bg-white hover:bg-gray-50"
                                    aria-label="Search records"
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

                        {{-- Filter by Type --}}
                        <div class="mb-6 flex flex-wrap gap-2">
                            <button type="button" data-filter="all" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-blue-600 text-white">
                                <i class="fas fa-list mr-2"></i> All Records
                            </button>
                            <button type="button" data-filter="condition" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-heartbeat mr-2"></i> Conditions
                            </button>
                            <button type="button" data-filter="medication" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-pills mr-2"></i> Medications
                            </button>
                            <button type="button" data-filter="allergy" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-allergies mr-2"></i> Allergies
                            </button>
                            <button type="button" data-filter="immunisation" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-syringe mr-2"></i> Immunisations
                            </button>
                            <button type="button" data-filter="lab" class="filter-btn px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <i class="fas fa-flask mr-2"></i> Lab Tests
                            </button>
                        </div>

                        {{-- Records List Header with Pagination --}}
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                            <p class="text-sm text-gray-500" id="doctors-count">
                                Showing <span class="font-medium text-gray-900">{{ count($allRecords) }}</span> record{{ count($allRecords) !== 1 ? 's' : '' }}
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

                        {{-- Records Table --}}
                        <div id="records-list">
                            @if($allRecords->count() > 0)
                                <div class="overflow-x-auto border border-gray-200 rounded-xl">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                                                <th scope="col" class="hidden md:table-cell px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Record Name</th>
                                                <th scope="col" class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                                <th scope="col" class="px-4 sm:px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">View More</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" id="recordsTableBody">
                                            @foreach($allRecords as $record)
                                                <tr class="record-row hover:bg-gray-50 transition-colors" data-type="{{ $record['type'] }}">
                                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center overflow-hidden">
                                                                @if(isset($record['patient_image']) && $record['patient_image'])
                                                                    <img src="{{ asset($record['patient_image']) }}" alt="{{ $record['patient_name'] }}" class="h-full w-full object-cover">
                                                                @else
                                                                    <span class="text-xs sm:text-sm font-bold">{{ substr($record['patient_name'], 0, 1) }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="ml-3 sm:ml-4">
                                                                <div class="text-xs sm:text-sm font-medium text-gray-900">{{ $record['patient_name'] }}</div>
                                                                <div class="text-[10px] sm:text-xs text-gray-500">Granted: {{ \Carbon\Carbon::parse($record['granted_at'])->format('d M Y') }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="hidden md:table-cell px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $record['patient_ic'] }}
                                                    </td>
                                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $record['name'] }}
                                                    </td>
                                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap">
                                                        @php
                                                            $typeColors = [
                                                                'condition' => 'bg-blue-100 text-blue-800',
                                                                'medication' => 'bg-green-100 text-green-800',
                                                                'allergy' => 'bg-red-100 text-red-800',
                                                                'immunisation' => 'bg-purple-100 text-purple-800',
                                                                'lab' => 'bg-orange-100 text-orange-800'
                                                            ];
                                                        @endphp
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] sm:text-xs font-medium {{ $typeColors[$record['type']] }}">
                                                            {{ ucfirst($record['type']) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 sm:px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href="{{ route('doctor.medical.records.' . $record['type'], $record['id']) }}" 
                                                            class="px-2 py-1 sm:px-4 sm:py-2 text-[10px] sm:text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors border border-blue-100">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="relative inline-block mb-6">
                                        <div class="w-32 h-32 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-folder-open text-blue-600 text-5xl" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No records found</h3>
                                    <p class="max-w-xl mx-auto text-base text-gray-600 mb-8">
                                        @if($search)
                                            No records match your search criteria. Try adjusting your search terms.
                                        @else
                                            You currently have no access to any patient records.
                                        @endif
                                    </p>
                                </div>
                            @endif

                            {{-- Filtered Empty State --}}
                            <div id="filteredEmptyState" class="hidden text-center py-12">
                                <i class="fas fa-search text-gray-300 text-5xl mb-4" aria-hidden="true"></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">No records found</h3>
                                <p class="text-sm text-gray-600 mb-4">We couldn't find any records matching your search</p>
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
    @include('doctor.components.footer')

    <!-- Medical Records Filter and Pagination Scripts -->
    @vite('resources/js/main/doctor/medicalRecordsFilter.js')
    @vite('resources/js/main/doctor/medicalRecordsPagination.js')

</body>

</html>