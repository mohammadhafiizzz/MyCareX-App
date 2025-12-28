<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/registration.js'])
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="min-h-screen flex">
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
                        <i class="fas fa-envelope text-blue-600 text-3xl mb-4"></i>
                        <h2 class="text-2xl font-semibold text-gray-900">Forgot Password</h2>
                        <p class="mt-4 text-sm text-gray-600 mb-8">Enter the email address you used to register. We will send you a link to reset your password.</p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-400"></i>
                                </div>
                                <div class="ml-3 text-red-700 text-sm">
                                    <p>
                                        @foreach ($errors->all() as $error)
                                            {{ $error }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Registration Form -->
                    <form action="{{ route('patient.password.email') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-600 mr-2"></i>Email Address
                            </label>
                            <input type="email" id="email" name="email" required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your email address">
                            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Reset Button -->
                        <div>
                            <button type="submit"
                                class="cursor-pointer mt-8 w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Reset
                            </button>
                        </div>
                        
                        <!-- Divider -->
                        <div class="relative mt-6 mb-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-gray-50 text-gray-500"></span>
                            </div>
                        </div>

                        <!-- Providers Login -->
                        <div>
                            <a href="{{ route('patient.login.form') }}"
                                class="cursor-pointer w-full flex justify-center py-3 px-4 border border-blue-300 rounded-lg shadow-sm text-sm font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-arrow-left mr-2 mt-0.5"></i>Back to login
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