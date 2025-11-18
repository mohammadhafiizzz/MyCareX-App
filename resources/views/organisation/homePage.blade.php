<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Healthcare Provider Portal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <!-- Navigation Header -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-2">
            <div class="flex items-center justify-between h-15">
                <a href="{{ route('organisation.index') }}" class="flex items-center space-x-3">
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
                    <a href="{{ route('index') }}"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Patient Portal</i>
                    </a>
                    <a href="#features"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Features
                    </a>
                    <a href="#contact"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Contact
                    </a>
                    <a href="{{ route('organisation.login.form') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Sign In</i>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden hidden" id="mobileMenu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t text-[15px] border-gray-200">
                    <a href="{{ route('index') }}" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        Patient Portal</i>
                    </a>
                    <a href="#features" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">Features</a>
                    <a href="#contact" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">Contact</a>
                    <a href="{{ route('organisation.login.form') }}"
                        class="block px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Sign In</i></a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white py-20 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                            <i class="fas fa-hospital mr-2"></i>
                            Healthcare Providers
                        </span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Enhanced Patient Care Through Digital Records
                    </h1>
                    <p class="text-lg md:text-xl text-green-100 mb-8 max-w-2xl leading-relaxed">
                        Join Malaysia’s leading healthcare interoperability platform designed to give you secure access
                        to complete patient records,
                        optimize workflows, and enhance care coordination across the entire healthcare ecosystem.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#register-provider"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 rounded-2xl font-semibold shadow-lg hover:bg-white/90 hover:backdrop-blur-xl transition-all duration-300">
                            Join as Provider
                            <i class="fas fa-hospital ml-2"></i>
                        </a>
                        <a href="#features"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white/10 text-white rounded-2xl font-semibold backdrop-blur-xl border border-white/20 shadow-lg hover:bg-white/20 hover:border-white/30 transition-all duration-300 text-center">
                            Learn More
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>

                <!-- Hero Stats -->
                <div class="lg:pl-8">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">500+</div>
                                <div class="text-sm text-green-100">Healthcare Providers</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">1M+</div>
                                <div class="text-sm text-green-100">Patient Records</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">99.9%</div>
                                <div class="text-sm text-green-100">System Uptime</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold mb-2">24/7</div>
                                <div class="text-sm text-green-100">Support Available</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-3xl font-bold text-gray-900 mb-4">
                    Why Choose MyCareX?
                </h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Enhance your healthcare practice with cutting-edge technology designed for Malaysian healthcare
                    providers
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-rose-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-users text-rose-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patients</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-hand-holding-medical text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Records Access</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access complete patient medical histories, medications, allergies, and treatment
                        plans in real-time across your network.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-heart-circle-check text-green-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Real-time Data</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-cyan-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-handshake text-cyan-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Interoperability</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-universal-access text-slate-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Access & Permissions</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                    </p>
                </div>

                <div
                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-12 h-12 bg-indigo-100 rounded-md flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-indigo-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security+</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Registration CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800" id="register-provider">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 md:p-12">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                    Ready to Join MyCareX?
                </h2>
                <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                    Connect your healthcare organisation to Malaysia's leading patient record platform and enhance care
                    coordination today.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{  route('organisation.register.form') }}"
                        class="inline-flex items-center px-8 py-4 bg-white text-blue-600 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-hospital mr-3"></i>
                        Register Healthcare Provider
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    @include('patient.components.footer')

    <!-- JavaScript -->
    @vite(['resources/js/main/organisation/homePage.js'])

</body>

</html>