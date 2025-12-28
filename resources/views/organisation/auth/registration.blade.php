<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/main/registration.js'])
    <title>New Organisation Account</title>
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
                        <h2 class="text-2xl font-semibold text-gray-900">Sign Up for MyCareX</h2>
                        <p class="text-sm text-gray-600 mb-8">Create a new organisation account</p>
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
                    <form action="{{ route('organisation.register') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Organisation Name -->
                        <div>
                            <label for="organisation_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-hospital text-gray-600 mr-2"></i>Organisation Name
                            </label>
                            <input type="text" id="organisation_name" name="organisation_name" data-uppercase="true" required 
                                value="{{ old('organisation_name') }}"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your organisation name">
                            @error('organisation_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Registrant Name -->
                        <div>
                            <label for="contact_person_name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user text-gray-600 mr-2"></i>Registrant Name
                            </label>
                            <input type="text" id="contact_person_name" name="contact_person_name" data-uppercase="true" required 
                                value="{{ old('contact_person_name') }}"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your full name">
                            @error('contact_person_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope text-gray-600 mr-2"></i>Email Address
                            </label>
                            <input type="email" id="email" name="email" required 
                                value="{{ old('email') }}"
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                placeholder="Enter your organisation email address">
                            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Divider -->
                        <div class="relative mb-12">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-600 mr-2"></i>Password
                            </label>
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
                            @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-lock text-gray-600 mr-2"></i>Confirm Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                    class="w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    placeholder="Confirm your password">
                                <button type="button" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                    id="togglePasswordConfirmation">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors" id="passwordConfirmationIcon"></i>
                                </button>
                            </div>
                            @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="text-xs text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <p><i class="fas fa-info-circle mr-1 text-blue-500"></i> By creating an account, you agree to our <a href="#" class="text-blue-600 hover:text-blue-700 hover:underline">Terms of Service</a> and have read and acknowledge our <a href="#" class="text-blue-600 hover:text-blue-700 hover:underline">Privacy Policy</a>. You understand that your organisation's information will be stored securely and used only for healthcare purposes.</p>
                        </div>

                        <!-- Sign Up Button -->
                        <div>
                            <button type="submit"
                                class="cursor-pointer w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Sign Up
                            </button>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <span class="text-sm text-gray-600">Already have an account? </span>
                            <a href="{{ route('organisation.login.form') }}" 
                               class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">
                                Log in here
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