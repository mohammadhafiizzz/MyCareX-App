<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Admin</title>
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
    <div class="max-w-lg mx-auto mt-2 bg-white p-8 rounded-xl shadow-md">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Admin Portal <i class="fas fa-user text-blue-600"></i></h1>
        </div>

        <form action="#" method="POST" id="adminLoginForm">
            @csrf

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">

                <!-- Staff ID Field -->
                <div>
                    <label for="staffId" class="block text-sm font-medium text-gray-700 mb-2">Staff ID</label>
                    <input type="text" id="staffId" name="staff_id" oninput="this.value = this.value.toUpperCase()"
                        placeholder="MCX12345"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Enter your password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        Sign In
                    </button>
                </div>
            </div>
        </form>
        <div class="text-center mt-6">
            <hr class="my-8 border-gray-300">
            <a href="{{ route('admin.register.form') }}" class="text-sm border rounded-lg p-3 text-blue-600 hover:text-white hover:bg-blue-600 transition-colors">
                Register new staff
            </a>
        </div>
    </div>

    <!-- Copyright footer -->
    <footer class="text-center mt-8 pb-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>

    <!-- Include the JavaScript file -->
    @vite(['resources/js/main/admin/adminLogin.js']);
</body>

</html>