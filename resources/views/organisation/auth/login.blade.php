<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/login.js'])
    <title>Log In as Provider</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
        <!-- Login Form -->
        <div class="w-full flex flex-col justify-center py-12 px-2 sm:px-4 lg:flex-none lg:px-16 xl:px-20">
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
                        <h2 class="text-2xl font-semibold text-gray-900">Login as Provider</h2>
                        <p class="text-sm text-gray-600 mb-8">Access your healthcare provider dashboard</p>
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

                    <!-- Login Form -->
                    <form action="{{ route('organisation.login') }}" method="POST" class="space-y-6">
                        @csrf
                        
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
                                <a href="{{ route('organisation.forgot.form') }}" 
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

                        <!-- Sign Up Link -->
                        <div class="text-center">
                            <span class="text-sm text-gray-600">Don't have account yet? </span>
                            <a href="{{ route('organisation.register.form') }}" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Register here
                            </a>
                        </div>

                        <!-- Divider -->
                        <div class="relative my-4">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-gray-50 text-gray-500">OR</span>
                            </div>
                        </div>


                        <!-- Doctors Login -->
                        <div>
                            <a href="{{ route('doctor.login') }}"
                                class="cursor-pointer w-full flex justify-center py-3 px-4 border border-blue-300 rounded-lg shadow-sm text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-user-doctor mr-2 mt-0.5"></i>Login as Doctor
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Copyright footer -->
            <footer class="text-center mt-8 pb-4">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
            </footer>
        </div>
    </div>
</body>

</html>