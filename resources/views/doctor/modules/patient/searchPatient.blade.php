<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Search</title>
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
        <div class="bg-gray-50">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Dashboard Content -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Search</h1>
                    <p class="mt-1 text-sm text-gray-600">Search for patients and request permissions.</p>
                </div>

                <!-- Stats Grid -->
                <div class="mb-6 flex justify-center">
                    <!-- Search form -->
                    <form action="{{ route('doctor.patient.search.results') }}" method="GET" class="flex items-center space-x-4">
                        <input type="text" name="query" placeholder="Search by name or identification number"
                            value="{{ old('query', $query ?? '') }}"
                            class="w-100 px-4 py-2 border-gray-300 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                    @error('query')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Results -->
                <div class="bg-white shadow rounded-lg">
                    <div
                        class="px-5 py-4 border-b border-gray-200 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Results: {{ isset($patients) ? $patients->total() : 0 }}</h3>
                            <p class="text-sm text-gray-500">
                                @if(isset($patients))
                                    Showing {{ $patients->count() }} {{ $patients->count() === 1 ? 'patient' : 'patients' }}
                                @else
                                    Start a search to list patients.
                                @endif
                            </p>
                        </div>
                        @if(!empty($query))
                            <p class="text-sm text-blue-600">Searched for "{{ $query }}"</p>
                        @endif
                    </div>
                    <div class="p-5">
                        @if(isset($patients) && $patients->count())
                            <div class="grid gap-4">
                                @foreach($patients as $patient)
                                    <div class="border border-gray-200 rounded-xl p-5 shadow-md transition-all duration-200 hover:shadow-lg">
                                        <div class="flex items-start gap-4">
                                            <!-- Profile Picture -->
                                            <div class="flex-shrink-0">
                                                @if($patient->profile_image_url)
                                                    <img src="{{ asset($patient->profile_image_url) }}" 
                                                         alt="{{ $patient->full_name }}"
                                                         class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                                                @else
                                                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center border-2 border-blue-300">
                                                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Patient Information -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $patient->full_name }}</h4>
                                                    </div>
                                                </div>

                                                <!-- Details Grid -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-sm">
                                                    <div class="flex items-center text-gray-600">
                                                        <i class="fas fa-id-card w-5 text-gray-400 mr-2"></i>
                                                        <span class="font-medium text-gray-700 mr-1">IC:</span>
                                                        {{ $patient->ic_number }}
                                                    </div>
                                                    <div class="flex items-center text-gray-600">
                                                        <i class="fas fa-envelope w-5 text-gray-400 mr-2"></i>
                                                        <span class="font-medium text-gray-700 mr-1">Email:</span>
                                                        <span class="truncate">{{ $patient->email }}</span>
                                                    </div>
                                                    <div class="flex items-center text-gray-600">
                                                        <i class="fas fa-phone w-5 text-gray-400 mr-2"></i>
                                                        <span class="font-medium text-gray-700 mr-1">Phone:</span>
                                                        {{ $patient->phone_number }}
                                                    </div>
                                                    <div class="flex items-center text-gray-600">
                                                        <i class="fas fa-map-marker-alt w-5 text-gray-400 mr-2"></i>
                                                        <span class="font-medium text-gray-700 mr-1">State:</span>
                                                        {{ $patient->state }}
                                                    </div>
                                                </div>

                                                <!-- Action Button -->
                                                <div class="mt-4 pt-3 border-t border-gray-100">
                                                    <a href="{{ route('doctor.patient.view.profile', ['patientId' => $patient->id]) }}" class="inline-flex items-center mr-2 px-4 py-2 border border-blue-300 shadow-sm text-blue-600 hover:text-blue-800 hover:bg-blue-200 text-sm font-medium rounded-lg transition-colors duration-200">
                                                        View Profile
                                                    </a>
                                                    <button 
                                                        id="openRequestAccessModal"
                                                        data-patient-id="{{ $patient->id }}"
                                                        data-patient-name="{{ $patient->full_name }}"
                                                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                        Request Access
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-6">
                                {{ $patients->links('pagination::tailwind') }}
                            </div>
                        @elseif(isset($patients))
                            <div class="text-center py-12">
                                <i class="fas fa-user text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No patients matched your search.</p>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-user text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No search results to display</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Access Modal -->
    @include('doctor.modules.permission.requestAccessModal')

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

    <!-- requestAccess JS -->
    @vite(['resources/js/main/doctor/requestAccess.js'])

</body>

</html>