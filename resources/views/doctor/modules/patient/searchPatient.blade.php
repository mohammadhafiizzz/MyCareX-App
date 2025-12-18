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
        <div class="bg-gray-100">
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
                    <form action="#" method="GET" class="flex items-center space-x-4">
                        <input type="text" name="query" placeholder="Search by name or identification number"
                            class="w-100 px-4 py-2 border-gray-300 bg-white border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Results -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Results: 0</h3>
                    </div>
                    <div class="p-5">
                        <div class="text-center py-12">
                            <i class="fas fa-user text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500">No search results to display</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->
    @include('doctor.components.footer')

</body>

</html>