<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
            <div class="flex items-center justify-between h-15">
                <a href="{{ route('index') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                    <div class="flex flex-col">
                        <span class="text-lg font-semibold text-gray-900">MyCareX</span>
                        <small class="text-[10px] font-normal text-gray-500">
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
                <div class="hidden lg:flex items-center text-[15px] space-x-4 font-medium">
                    <a href="{{ route('organisation.index') }}"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Organisation Portal
                    </a>
                    <a href="#"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        About Us
                    </a>
                    <a href="{{ route('patient.login.form') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Sign In</i>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden hidden" id="mobileMenu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t text-[15px] border-gray-200">
                    <a href="{{ route('organisation.index') }}"
                        class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        Organisation Portal
                    </a>
                    <a href="#" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">About Us</a>
                    <a href="{{ route('patient.login.form') }}"
                        class="block px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Sign In</i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-23 lg:py-30">
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
                    <a href="{{ route('patient.register.form') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-2xl font-semibold shadow-lg hover:bg-white/90 hover:backdrop-blur-xl transition-all duration-300">
                        Get Started
                    </a>
                    <a href="#features"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white/10 text-white rounded-2xl font-semibold backdrop-blur-xl border border-white/20 shadow-lg hover:bg-white/20 hover:border-white/30 transition-all duration-300">
                        Learn More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-15 bg-gray-50" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-3xl font-bold text-gray-900 mb-4">
                    Why Choose MyCareX?
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Enhance your healthcare experience with MyCareX's features designed to put you in control of your
                    personal health records.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-screen text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Web-App</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access your records on-the-go with our responsive web platform optimised for tablets and
                        smartphones.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-hand-holding-medical text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Complete Control</h3>
                    <p class="text-gray-600 leading-relaxed">
                        You own your medical records. Decide who can access them and manage permissions easily.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-rose-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-heart-circle-exclamation text-rose-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Emergency</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access critical health information instantly during emergencies to ensure accurate and effective
                        care.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-cyan-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-handshake text-cyan-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Easy Sharing</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Allow you to easily change healthcare providers and share your health records securely.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-amber-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-amber-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Real-time Tracking</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Monitor who accessed your records with activities and notifications for enhanced transparency.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security+</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Advanced security mechanisms to protect your personal health information and ensure privacy.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if (session('login_error'))
        <script>
            window.LOGIN_ERROR = @json(session('login_error'));
        </script>
    @endif

    @include('patient.components.footer')
    @vite(['resources/js/main/index.js'])

</body>

</html>