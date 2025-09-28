<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Healthcare Provider Registration - MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('organisation.index') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-xl font-semibold text-gray-900">MyCareX</span>
                        <small class="text-xs font-normal text-gray-500">Healthcare Provider Portal</small>
                    </div>
                </a>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-600">Already registered?</span>
                    <a href="{{ route('organisation.index') }}"
                        class="px-4 py-2 text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition-colors duration-200">
                        Sign In <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Register Your Healthcare Organisation</h1>
            <p class="text-lg text-gray-600">Join Malaysia's leading healthcare interoperability platform</p>
        </div>

        <!-- Registration Process Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between max-w-md mx-auto">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-blue-600 rounded-full text-white text-sm font-medium">1</div>
                    <span class="ml-2 text-sm text-gray-600">Register</span>
                </div>
                <div class="flex-1 h-px bg-gray-300 mx-4"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full text-gray-500 text-sm font-medium">2</div>
                    <span class="ml-2 text-sm text-gray-500">Review</span>
                </div>
                <div class="flex-1 h-px bg-gray-300 mx-4"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 bg-gray-300 rounded-full text-gray-500 text-sm font-medium">3</div>
                    <span class="ml-2 text-sm text-gray-500">Approved</span>
                </div>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('organisation.register') }}" method="POST" enctype="multipart/form-data" id="registrationForm" class="space-y-8">
            @csrf
            @include('organisation.auth.signupForm')
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
        </div>
    </footer>

    @vite(['resources/js/main/organisation/providerRegistration.js'])
</body>
</html>