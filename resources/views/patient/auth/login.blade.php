<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/patient/login.js'])
    <title>Patient Login - MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Left Side - Illustration -->
        <div class="hidden lg:block relative lg:w-6/12">
            <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-blue-600 to-blue-800">
                <div class="flex items-center justify-center h-full p-12">
                    <div class="text-center">
                        <!-- Healthcare Illustration -->
                        <div class="mb-8">
                            <div class="relative mx-auto w-80 h-80">
                                <!-- Medical Heart Background -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center">
                                        <i class="fas fa-heartbeat text-6xl text-white"></i>
                                    </div>
                                </div>

                                <!-- Floating Elements -->
                                <div
                                    class="absolute top-8 left-8 w-16 h-16 bg-white/30 rounded-full flex items-center justify-center animate-pulse">
                                    <i class="fas fa-notes-medical text-2xl text-white"></i>
                                </div>

                                <div
                                    class="absolute top-16 right-12 w-12 h-12 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-150">
                                    <i class="fas fa-file-medical text-xl text-white"></i>
                                </div>

                                <div
                                    class="absolute bottom-16 left-12 w-14 h-14 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-300">
                                    <i class="fas fa-prescription-bottle-alt text-xl text-white"></i>
                                </div>

                                <div
                                    class="absolute bottom-8 right-8 w-16 h-16 bg-white/30 rounded-full flex items-center justify-center animate-pulse delay-500">
                                    <i class="fas fa-syringe text-2xl text-white"></i>
                                </div>

                                <!-- Central Figure -->
                                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2">
                                    <div
                                        class="w-24 h-32 bg-white/40 rounded-t-full flex items-end justify-center pb-2">
                                        <i class="fas fa-user text-3xl text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Text Content -->
                        <div class="text-white">
                            <h2 class="text-3xl font-bold mb-4">Welcome to MyCareX</h2>
                            <p class="text-xl text-blue-100 mb-6 max-w-md mx-auto">
                                Access your personal health records securely from anywhere, anytime
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
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
                        <p class="text-sm text-gray-600 mb-8">Access your personal health records</p>
                    </div>

                    <!-- Error Messages -->
                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Authentication failed</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Session Expired Alert --}}
                    @if(session('session_expired'))
                    <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-lg shadow-sm animate-pulse" role="alert">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-amber-600 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-semibold text-amber-800">Session Expired</h3>
                                <p class="mt-1 text-sm text-amber-700">{{ session('session_expired') }}</p>
                            </div>
                            <button type="button" onclick="this.parentElement.parentElement.remove()" class="ml-auto text-amber-600 hover:text-amber-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Login Form -->
                    <form action="{{ route('patient.login') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- IC Number -->
                        <div>
                            <label for="icNumber" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-id-card text-gray-600 mr-2"></i>IC Number
                            </label>
                            <input type="text" id="icNumber" name="ic_number" required maxlength="14"
                                value="{{ old('ic_number') }}"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your IC number">
                        </div>

                        <!-- Password -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    <i class="fas fa-lock text-gray-600 mr-2"></i>Password
                                </label>
                                <a href="{{ route('patient.password.request') }}"
                                    class="text-sm text-blue-600 hover:text-blue-500 transition-colors">
                                    Forgot password?
                                </a>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Enter your password">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    id="togglePassword">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"
                                        id="passwordIcon"></i>
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

                        <!-- Divider -->
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">OR</span>
                            </div>
                        </div>

                        <!-- Google Sign In Button -->
                        <div>
                            <a href="#"
                                class="cursor-pointer w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                        fill="#4285F4" />
                                    <path
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                        fill="#34A853" />
                                    <path
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                        fill="#FBBC05" />
                                    <path
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                        fill="#EA4335" />
                                </svg>
                                Sign in with Google
                            </a>
                        </div>

                        <!-- Sign Up Link -->
                        <div class="text-center mt-4">
                            <span class="text-sm text-gray-600">Don't have an account yet? </span>
                            <a href="{{ route('patient.register.form') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Create one here
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Back to Main Site -->
                <div class="mt-8 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Back to home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>