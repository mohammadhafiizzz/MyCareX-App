<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('index') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-xl font-semibold text-gray-900">MyCareX</span>
                        <small class="text-xs font-normal text-gray-500">
                            Personal Healthcare Records
                        </small>
                    </div>
                </a>

                <!-- Mobile Menu Button -->
                <button class="lg:hidden focus:outline-none" id="mobileMenuButton">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-16 6h16"></path>
                    </svg>
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-4 font-medium">
                    <a href="#"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Organization Portal <i class="fas fa-hospital"></i>
                    </a>
                    <a href="#"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        About Us
                    </a>
                    <a href="#"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 login-modal-btn">
                        Sign In <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden hidden" id="mobileMenu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
                    <a href="#" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        Organization Portal <i class="fas fa-hospital"></i>
                    </a>
                    <a href="#" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">About Us</a>
                    <a href="#"
                        class="block px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 login-modal-btn">
                        Sign In <i class="fas fa-sign-in-alt"></i></a>
                </div>
            </div>
        </div>
    </nav>

    @include('auth.patientLoginForm')

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20 lg:py-25">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    Your Digital<br>Health Records
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Securely manage your complete medical history, medications, and health data
                    in one platform designed specifically for Malaysians
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                        Get Started
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#features"
                        class="inline-flex items-center px-6 py-3 border border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors duration-200">
                        Learn More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-file-medical text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Medical Records</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Store and manage all your medical records in one secure place
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Safety Guaranteed</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Control who can access your health information with granular permissions
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-globe text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Access Anywhere</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Access it anywhere and everywhere. Responsive web platform for all devices
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-users text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Interoperability</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Share information with doctors with full control
                    </p>
                </div>
            </div>
        </div>
    </section>

    <script src="{{asset('js/main.js')}}"></script>
    @include('components.footer')

</body>

</html>