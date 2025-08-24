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
    @include('components.patientHeader')

    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ Auth::guard('patient')->user()->full_name }}!</h1>
            <p class="text-gray-600 mt-2">Manage your healthcare records and medical information</p>
        </div>

        <!-- Quick Stats Section (Optional) -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Quick Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-blue-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Last Visit</p>
                            <p class="text-lg font-semibold text-gray-900">Dec 15, 2024</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-heartbeat text-blue-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Health Status</p>
                            <p class="text-lg font-semibold text-gray-900">Good</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-600">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-bell text-blue-800 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                            <p class="text-lg font-semibold text-gray-900">2</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr class="my-8 border-t border-gray-200">

        <!-- Dashboard Cards -->
        <div class="mt-10 mb-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Medical History Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-file-medical-alt text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Medical History
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">View your complete medical records and history</p>
                </div>
            </div>

            <!-- Lab Results Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-flask text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Lab
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Access your laboratory test results</p>
                </div>
            </div>

            <!-- Vaccination Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-syringe text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Vaccination
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Track your vaccination records</p>
                </div>
            </div>

            <!-- Allergy Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-exclamation-triangle text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Allergy
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Manage your allergy information</p>
                </div>
            </div>

            <!-- Medication Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-pills text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Medication
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">View your current medications</p>
                </div>
            </div>

            <!-- Requests Card -->
            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 cursor-pointer group">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-md flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition-colors duration-200">
                        <i class="fas fa-user-shield text-blue-700 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                        Requests
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Control access to your medical records</p>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Footer -->
    @include('components.footer')

    <!-- Javascript -->
    @vite(['resources/js/main/main.js'])
    @vite(['resources/js/main/patient/patientHeader.js'])
</body>

</html>