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
    <div class="lg:ml-68 transition-all duration-300 pt-[75px]" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Patient Medical Records</h1>
                    <p class="mt-2 text-sm text-gray-600">View and manage patient records you have been granted access to</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <!-- Conditions Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Conditions</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['conditions'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-stethoscope text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Medications Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Medications</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['medications'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-pills text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Allergies Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Allergies</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['allergies'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-allergies text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Immunisations Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Immunisations</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['immunisations'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-syringe text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Lab Tests Card -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Lab Tests</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $stats['labs'] }}</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-flask text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-gray-200">
                    <form action="{{ route('doctor.medical.records') }}" method="GET" class="flex gap-4 mb-4">
                        <div class="flex-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                Search Records
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="search" 
                                    id="search"
                                    value="{{ $search }}"
                                    placeholder="Search by patient name or IC number..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                >
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                        <div class="flex items-end gap-2">
                            <button 
                                type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
                            >
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                            @if($search)
                            <a 
                                href="{{ route('doctor.medical.records') }}"
                                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium"
                            >
                                Clear
                            </a>
                            @endif
                        </div>
                    </form>

                    <!-- Filter by Type -->
                    <div class="border-t border-gray-200 pt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Filter by Record Type
                        </label>
                        <div class="flex flex-wrap gap-2">
                            <button 
                                type="button" 
                                data-filter="all"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-blue-600 text-white"
                            >
                                <i class="fas fa-list mr-2"></i>
                                All Records
                            </button>
                            <button 
                                type="button" 
                                data-filter="condition"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200"
                            >
                                <i class="fas fa-stethoscope mr-2"></i>
                                Conditions
                            </button>
                            <button 
                                type="button" 
                                data-filter="medication"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200"
                            >
                                <i class="fas fa-pills mr-2"></i>
                                Medications
                            </button>
                            <button 
                                type="button" 
                                data-filter="allergy"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200"
                            >
                                <i class="fas fa-allergies mr-2"></i>
                                Allergies
                            </button>
                            <button 
                                type="button" 
                                data-filter="immunisation"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200"
                            >
                                <i class="fas fa-syringe mr-2"></i>
                                Immunisations
                            </button>
                            <button 
                                type="button" 
                                data-filter="lab"
                                class="filter-btn px-4 py-2 rounded-lg font-medium transition-colors bg-gray-100 text-gray-700 hover:bg-gray-200"
                            >
                                <i class="fas fa-flask mr-2"></i>
                                Lab Tests
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Records Table -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">All Medical Records</h2>
                            <p class="text-sm text-gray-600 mt-1" id="recordsCountText">Total: {{ $allRecords->count() }} records</p>
                        </div>
                        
                        <!-- Pagination Controls -->
                        <div class="flex items-center gap-2" id="paginationControls">
                            <span class="text-sm text-gray-600" id="paginationInfo">Page 1</span>
                            <div class="flex gap-1">
                                <button 
                                    id="prevPageBtn"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled
                                >
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button 
                                    id="nextPageBtn"
                                    class="px-3 py-1 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($allRecords->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Patient
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        IC Number
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Record Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Details
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="recordsTableBody">
                                @foreach($allRecords as $record)
                                <tr class="record-row hover:bg-gray-50 transition-colors" data-type="{{ $record['type'] }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $typeColors = [
                                                'condition' => 'bg-blue-100 text-blue-800',
                                                'medication' => 'bg-green-100 text-green-800',
                                                'allergy' => 'bg-red-100 text-red-800',
                                                'immunisation' => 'bg-purple-100 text-purple-800',
                                                'lab' => 'bg-orange-100 text-orange-800'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeColors[$record['type']] }}">
                                            {{ ucfirst($record['type']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record['patient_name'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $record['patient_ic'] }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $record['name'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($record['date'])->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500">
                                            @if($record['type'] === 'condition')
                                                <span class="block">Status: <span class="font-medium">{{ $record['status'] }}</span></span>
                                                <span class="block">Severity: <span class="font-medium">{{ $record['severity'] }}</span></span>
                                            @elseif($record['type'] === 'medication')
                                                <span class="block">Dosage: <span class="font-medium">{{ $record['dosage'] }}</span></span>
                                                <span class="block">Status: <span class="font-medium">{{ $record['status'] }}</span></span>
                                            @elseif($record['type'] === 'allergy')
                                                <span class="block">Severity: <span class="font-medium">{{ $record['severity'] }}</span></span>
                                                <span class="block">Status: <span class="font-medium">{{ $record['status'] }}</span></span>
                                            @elseif($record['type'] === 'immunisation')
                                                <span class="block">Administered by: <span class="font-medium">{{ $record['administered_by'] }}</span></span>
                                            @elseif($record['type'] === 'lab')
                                                <span class="block">Category: <span class="font-medium">{{ $record['category'] }}</span></span>
                                                <span class="block">Facility: <span class="font-medium">{{ $record['facility'] }}</span></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a 
                                            href="{{ route('doctor.medical.records.' . $record['type'], $record['id']) }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium"
                                        >
                                            View More
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Filtered Empty State (hidden by default) -->
                    <div id="filteredEmptyState" class="text-center py-12 hidden">
                        <i class="fas fa-filter text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Records Match Filter</h3>
                        <p class="text-sm text-gray-600">
                            No records found for the selected type. Try selecting a different filter.
                        </p>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No Records Found</h3>
                        <p class="text-sm text-gray-600">
                            @if($search)
                                No records match your search criteria. Try adjusting your search terms.
                            @else
                                You currently have no access to any patient records. Request access from the permissions page.
                            @endif
                        </p>
                    </div>
                    @endif
                </div>
                
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