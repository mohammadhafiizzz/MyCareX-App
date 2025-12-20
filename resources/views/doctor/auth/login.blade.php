<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/login.js'])
    <title>Doctor Login - MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Login Form -->
        <div class="w-full lg:w-6/12 flex flex-col justify-center py-12 px-2 sm:px-4 lg:flex-none lg:px-16 xl:px-20">
            <div class="mx-auto w-full max-w-lg lg:w-130">
                <!-- Logo -->
                <div class="flex items-center justify-center mb-8">
                    <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-12 h-12 rounded-lg">
                    <div class="ml-3">
                        <h1 class="text-2xl font-bold text-gray-900">MyCareX</h1>
                        <p class="text-sm text-gray-500">Personal Health Records</p>
                    </div>
                </div>

                <div class="border border-gray-200 p-8 rounded-lg shadow-sm bg-white">
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-semibold text-gray-900">Login to your account</h2>
                        <p class="text-sm text-gray-600 mb-8">Access patients data by using your institutions</p>
                    </div>

                    <!-- Error Messages -->
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3 text-sm text-red-700">
                                    <p>{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Session Expired Alert --}}
                    @if(session('session_expired'))
                    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3" role="alert">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-amber-600"></i>
                            </div>
                            <div class="ml-3 text-sm text-amber-700">
                                <p>{{ session('session_expired') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if ($healthcareProviders->isNotEmpty())
                        <!-- Login Form -->
                        <form action="{{ route('doctor.login') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Healthcare Provider -->
                            <div class="relative" id="provider-search-container">
                                <label for="provider_search" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-hospital text-gray-600 mr-2"></i> Healthcare Institution
                                </label>
                                <div class="relative">
                                    <input type="text" id="provider_search" 
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Find your organisation" autocomplete="off">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <input type="hidden" name="provider_id" id="provider_id" value="{{ old('provider_id') }}" required>
                                
                                <!-- Dropdown List -->
                                <div id="provider_list" class="absolute z-20 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                                    @foreach ($healthcareProviders as $provider)
                                        <div class="provider-option cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-blue-600 hover:text-white text-gray-900" 
                                            data-id="{{ $provider->id }}" 
                                            data-name="{{ $provider->organisation_name }}">
                                            {{ $provider->organisation_name }}
                                        </div>
                                    @endforeach
                                    <div id="no-provider-found" class="px-3 py-2 text-gray-500 hidden">No organisation found</div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-envelope text-gray-600 mr-2"></i> Email address
                                </label>
                                <input type="email" id="email" name="email" required 
                                    value="{{ old('email') }}"
                                    class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter your email address">
                            </div>

                            <!-- Password -->
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                        <i class="fas fa-lock text-gray-600 mr-2"></i> Password
                                    </label>
                                    <a href="#" 
                                    class="text-sm text-blue-600 hover:text-blue-500 transition-colors">
                                        forgot password?
                                    </a>
                                </div>
                                <div class="relative">
                                    <input type="password" id="password" name="password" required
                                        class="w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                        placeholder="Enter your password">
                                    <button type="button" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                        id="togglePassword">
                                        <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors" id="passwordIcon"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center">
                                <input type="checkbox" id="remember" name="remember" 
                                    class="cursor-pointer h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="remember" class="cursor-pointer ml-2 block text-sm text-gray-700">
                                    Remember me on this device
                                </label>
                            </div>

                            <!-- Sign In Button -->
                            <div>
                                <button type="submit"
                                    class="cursor-pointer w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Sign in
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">No Healthcare Providers Found</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        Please contact the system administrator to set up your healthcare institution before logging in.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Divider -->
                    <div class="relative mt-6 mb-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-gray-50 text-gray-500">OR</span>
                        </div>
                    </div>

                    <!-- Providers Login -->
                    <div>
                        <a href="{{ route('organisation.login') }}"
                            class="cursor-pointer w-full flex justify-center py-3 px-4 border border-blue-300 rounded-lg shadow-sm text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-hospital mr-2 mt-0.5"></i>Login as Provider
                        </a>
                    </div>
                </div>

                <!-- Back to Main Site -->
                <div class="mt-8 text-center">
                    <a href="{{ route('organisation.index') }}" 
                       class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to main site
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hidden lg:block relative lg:w-6/12">
            <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-blue-600 to-blue-800">
                <div class="flex items-center justify-center h-full p-12">
                    <div class="text-center">
                        <!-- Healthcare Illustration -->
                        <div class="mb-8">
                            <div class="relative mx-auto w-80 h-80">
                                <!-- Medical Cross Background -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-hospital text-6xl text-white"></i>
                                    </div>
                                </div>
                                
                                <!-- Floating Elements -->
                                <div class="absolute top-8 left-8 w-16 h-16 bg-white/30 rounded-full flex items-center justify-center animate-pulse">
                                    <i class="fas fa-user-md text-2xl text-white"></i>
                                </div>
                                
                                <div class="absolute top-16 right-12 w-12 h-12 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-150">
                                    <i class="fas fa-heartbeat text-xl text-white"></i>
                                </div>
                                
                                <div class="absolute bottom-16 left-12 w-14 h-14 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-300">
                                    <i class="fas fa-pills text-xl text-white"></i>
                                </div>
                                
                                <div class="absolute bottom-8 right-8 w-16 h-16 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-500">
                                    <i class="fas fa-stethoscope text-2xl text-white"></i>
                                </div>

                                <!-- Central Figure -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2">
                                    <div class="w-24 h-32 bg-white/40 rounded-t-full flex items-end justify-center pb-2">
                                        <i class="fas fa-user-tie text-3xl text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text Content -->
                        <div class="text-white">
                            <h2 class="text-3xl font-bold mb-4">Welcome to MyCareX</h2>
                            <p class="text-xl text-blue-100 mb-6 max-w-md mx-auto">
                                Secure access to Malaysia's leading healthcare interoperability platform
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>