<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Patient Registration - MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('index') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-xl font-semibold text-gray-900">MyCareX</span>
                        <small class="text-xs font-normal text-gray-500">Personal Healthcare Records</small>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Already have an account?</span>
                    <a href="{{ route('index') }}"
                        class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                        Sign In <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Your MyCareX Account</h1>
            <p class="text-lg text-gray-600">Join thousands of Malaysians managing their healthcare records securely</p>
        </div>

        <!-- Registration Form -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('patient.register') }}" method="POST" id="registrationForm" class="space-y-8">
            @csrf

            @include('patient.auth.registrationForm')

        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} MyCareX. All rights reserved.
            </p>
        </div>
    </footer>

    @vite(['resources/js/main/userAuth/registration.js'])
</body>

</html>