<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient</title>
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
            <h1 class="text-3xl font-bold text-gray-900">
                My Records
            </h1>
            <p class="mt-1 text-lg text-gray-700">Manage your own medica records.</p>
        </div>

        <!-- Dashboard Cards -->
        <div class="mt-5 mb-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Medical History Card -->
            <a href="#">
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
            </a>

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
        </div>
    </div>

    <!-- Javascript and Footer -->
    @vite(['resources/js/main/patient/header.js'])
    @include('patient.components.footer')
</body>

</html>