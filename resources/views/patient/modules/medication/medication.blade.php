<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Medication</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <a href="{{ route('patient.myrecords') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-3 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                <i class="fas fa-arrow-left" aria-hidden="true"></i>
                Back to My Records
            </a>
            
            <h1 class="text-3xl font-bold text-gray-900">
                Medications
            </h1>
            <p class="mt-1 text-lg text-gray-700">A complete record of your medications.</p>
        </div>

        {{-- Success Message --}}
        @if (session('message'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('message') }}
            </div>
        @endif

        <section class="bg-white rounded-xl mb-7 shadow-sm border border-gray-200" aria-labelledby="conditions-heading">
            <div class="p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h2 id="medications-heading" class="text-xl font-semibold text-gray-900">
                        Medications
                    </h2>
                    <button 
                        type="button" 
                        id="show-add-medication-modal"
                        class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-plus"></i>
                        Add Medication
                    </button>
                </div>
            </div>
            
            <div class="flow-root">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Medication</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dosage</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Frequency</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Notes</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">More</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Medication Name</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Dosage</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Frequency</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Status</span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">Notes</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="#" class="medication-info-btn text-blue-600 hover:underline hover:text-blue-900 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1"
                                    data-id="">More Info</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>