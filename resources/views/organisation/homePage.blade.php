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
            <div class="flex items-center justify-between h-16">
                <a href="#" class="flex items-center space-x-3">
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
                    <a href="{{ route('index') }}"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Patient Portal <i class="fas fa-user"></i>
                    </a>
                    <a href="#features"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Features
                    </a>
                    <a href="#contact"
                        class="px-4 py-2 text-gray-800 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        Contact
                    </a>
                    <a href="#"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 login-modal-btn">
                        Provider Login <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="lg:hidden hidden" id="mobileMenu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gray-200">
                    <a href="{{ route('index') }}" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">
                        Patient Portal <i class="fas fa-user"></i>
                    </a>
                    <a href="#features" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">Features</a>
                    <a href="#contact" class="block px-3 py-2 text-gray-800 hover:bg-gray-50 rounded-md">Contact</a>
                    <a href="#"
                        class="block px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 login-modal-btn">
                        Provider Login <i class="fas fa-sign-in-alt"></i></a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Include Provider Login Modal --}}
    @include('organisation.auth.providerLoginModal')

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
                        Join Malaysia’s leading healthcare interoperability platform designed to give you secure access to complete patient records,
                        optimize workflows, and enhance care coordination across the entire healthcare ecosystem.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#register-provider"
                            class="inline-flex items-center px-8 py-4 bg-white text-blue-700 rounded-lg font-semibold hover:bg-gray-100 transition-colors duration-200 text-center">
                            Join as Provider
                            <i class="fas fa-hospital ml-2"></i>
                        </a>
                        <a href="#features"
                            class="inline-flex items-center px-8 py-4 border border-white text-white rounded-lg font-semibold hover:bg-white hover:text-blue-700 transition-colors duration-200 text-center">
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
    <section class="py-20 bg-gray-50" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Why Choose MyCareX?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Empower your healthcare practice with cutting-edge technology designed for Malaysian healthcare providers
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-database text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Comprehensive Records Access</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access complete patient medical histories, medications, allergies, and treatment plans in real-time across your network.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-network-wired text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Seamless Interoperability</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connect with hospitals, clinics, and specialists across Malaysia. Share information securely with patient consent.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Enterprise Security</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Bank-level encryption, HIPAA compliance, and granular access controls protect sensitive patient data.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Real-Time Updates</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Get instant notifications when patients update their records or when critical information is shared.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Analytics & Reporting</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Generate insights from patient data, track treatment outcomes, and improve care quality with advanced analytics.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6">
                        <i class="fas fa-mobile-alt text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Mobile Access</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Access patient records on-the-go with our responsive web platform optimized for tablets and smartphones.
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
                    Connect your healthcare organization to Malaysia's leading patient record platform and enhance care coordination today.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#"
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

    @if (session('login_error'))
        <script>
            window.PROVIDER_LOGIN_ERROR = @json(session('login_error'));
        </script>
    @endif

    @vite(['resources/js/main/organisation/homePage.js'])
    @vite(['resources/js/main/index.js'])

</body>

</html>