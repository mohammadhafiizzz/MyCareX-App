<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('patient.components.header')

    <!-- Navbar -->
    @include('patient.components.navbar')

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Welcome, {{ Auth::guard('patient')->user()->full_name ?? 'Profile' }}
            </h1>
            <p class="mt-1 text-lg text-gray-700">Here is your health summary.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">

                {{-- Medications Reminder --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="labs-heading">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h2 id="labs-heading" class="text-xl font-semibold text-gray-900">
                                Medications
                            </h2>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                View all
                            </a>
                        </div>
                        
                        <div class="mt-6 flow-root">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                <li class="py-4 flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-pills text-blue-700 text-lg" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-md font-medium text-gray-900 truncate">Name of the Drugs</p>
                                        <p class="text-sm text-gray-500">Taken At: Datetime</p>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            Status
                                        </span>
                                    </div>
                                </li>
                                <li class="py-4 flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-pills text-blue-700 text-lg" aria-hidden="true"></i>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-md font-medium text-gray-900 truncate">Name of the Drugs</p>
                                        <p class="text-sm text-gray-500">Taken At: Datetime</p>
                                    </div>
                                    <div>
                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                                            Status
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- Medical History --}}
                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="appointments-heading">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h2 id="appointments-heading" class="text-xl font-semibold text-gray-900">
                                Medical History
                            </h2>
                            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                                View all
                            </a>
                        </div>
                        
                        <div class="mt-6 flow-root">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                <li class="py-5">
                                    <div class="relative flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100">
                                                <i class="fas fa-heart-pulse text-blue-700 text-xl" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-md font-semibold text-gray-900">
                                                <a href="#" class="hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                                    Name of the Treatment/Conditions
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-700">Healthcare Provider</p>
                                            <p class="text-sm text-gray-500">Date</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <i class="fas fa-chevron-right text-gray-400" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-5">
                                    <div class="relative flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-blue-100">
                                                <i class="fas fa-heart-pulse text-blue-700 text-xl" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-md font-semibold text-gray-900">
                                                <a href="#" class="hover:underline rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                                    Name of the Treatment/Conditions
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-700">Healthcare Provider</p>
                                            <p class="text-sm text-gray-500">Date</p>
                                        </div>
                                        <div class="flex-shrink-0 ml-4">
                                            <i class="fas fa-chevron-right text-gray-400" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>

            </div>

            <div class="space-y-8">

                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="privacy-heading">
                    <div class="p-6">
                        <h2 id="privacy-heading" class="text-xl font-semibold text-gray-900 mb-4">
                            Access & Privacy
                        </h2>
                        
                        <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <i class="fas fa-bell text-yellow-600 text-xl" aria-hidden="true"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-semibold text-yellow-800">2 Pending Requests</p>
                                <p class="text-sm text-yellow-700">Review requests for your data</p>
                            </div>
                            <a href="#" class="ml-2 flex-shrink-0 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                            <i class="fas fa-arrow-right text-yellow-700" aria-hidden="true"></i>
                            </a>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-700">Your last login was:</p>
                            <p class="text-sm font-medium text-gray-900">{{ Auth::guard('patient')->user()->last_login ? Auth::guard('patient')->user()->last_login->format('M d, Y \a\t h:i A') : 'Never logged in' }}</p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-xl shadow-sm border border-gray-200" aria-labelledby="record-heading">
                    <div class="p-6">
                        <h2 id="record-heading" class="text-xl font-semibold text-gray-900 mb-4">
                            My Medical Record
                        </h2>
                        
                        <nav>
                            <ul role="list" class="space-y-1">
                                <li>
                                    <a href="#" class="group flex items-center p-3 text-md font-medium text-gray-800 rounded-lg hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                        <i class="fas fa-file-medical-alt text-blue-700 w-6 text-center" aria-hidden="true"></i>
                                        <span class="ml-3">Medical History</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="group flex items-center p-3 text-md font-medium text-gray-800 rounded-lg hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                        <i class="fas fa-pills text-blue-700 w-6 text-center" aria-hidden="true"></i>
                                        <span class="ml-3">Medications</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="group flex items-center p-3 text-md font-medium text-gray-800 rounded-lg hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                        <i class="fas fa-exclamation-triangle text-blue-700 w-6 text-center" aria-hidden="true"></i>
                                        <span class="ml-3">Allergies</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="group flex items-center p-3 text-md font-medium text-gray-800 rounded-lg hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                        <i class="fas fa-syringe text-blue-700 w-6 text-center" aria-hidden="true"></i>
                                        <span class="ml-3">Vaccinations</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="group flex items-center p-3 text-md font-medium text-gray-800 rounded-lg hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-1">
                                        <i class="fas fa-flask text-blue-700 w-6 text-center" aria-hidden="true"></i>
                                        <span class="ml-3">Lab Results</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </section>

            </div>
        </div>
    </div>
    
    <!-- Footer -->
    @include('patient.components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/main.js'])
    @vite(['resources/js/main/patient/patientHeader.js'])
</body>

</html>