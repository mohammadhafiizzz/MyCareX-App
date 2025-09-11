<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Admin - MyCareX</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>
<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Logo Branding -->
    <div class="max-w-7xl mx-auto px-4 mt-15 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-center h-16">
            <div class="flex items-center space-x-3 mb-2">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-xl font-semibold text-gray-900">MyCareX</span>
                    <small class="text-xs font-normal text-gray-500">
                        Personal Healthcare Records
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Form (Admin) -->
    <div class="max-w-xl mx-auto mt-2 bg-white p-8 rounded-xl shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Admin Portal <i class="fas fa-user text-blue-600"></i></h1>
            <p class="text-gray-600 mt-2">Admin Login</p>
        </div>

        <form action="#" method="POST" id="adminLoginForm">
            @csrf
            <!-- Staff ID Field -->
        </form>
    </div>
    
    <!-- Copyright footer -->
    <footer class="text-center mt-8 pb-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>
    
    <!-- Include the JavaScript file -->
</body>
</html>