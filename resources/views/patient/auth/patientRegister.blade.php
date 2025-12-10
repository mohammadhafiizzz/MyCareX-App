<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Registration</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">

    <!-- Logo Branding -->
    <div class="max-w-4xl mx-auto mt-6 sm:mt-10 px-4">
        <div class="flex items-center justify-center h-16">
            <div class="flex items-center space-x-2 sm:space-x-3 mb-2">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-lg sm:text-xl font-semibold text-gray-800">MyCareX</span>
                    <small class="text-xs font-normal text-gray-500">
                        Personal Healthcare Records
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">

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
        <div class="border border-gray-200 bg-white rounded-md sm:rounded-xl shadow-md p-6 sm:p-8 lg:p-12">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Sign Up for MyCareX</h1>
                <p class="text-sm sm:text-base text-gray-600 mt-2">Create an account or <a href="{{ route('patient.login') }}" class="text-blue-600 hover:underline">log in</a></p>
            </div>

            <form action="{{ route('patient.register') }}" method="POST" id="registrationForm" class="grid gap-4 sm:gap-5">
                @csrf

                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user text-gray-600 mr-2"></i>Full Name</label>
                    <input id="full_name" name="full_name" type="text" required value="{{ old('full_name') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter your full name">
                    @error('full_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card text-gray-600 mr-2"></i>IC Number</label>
                    <input id="ic_number" name="ic_number" type="text" required value="{{ old('ic_number') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter your IC number">
                    @error('ic_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope text-gray-600 mr-2"></i>Email Address</label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter your email address">
                    @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Divider -->
                <div class="relative my-3 sm:my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-600 mr-2"></i>Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter your password">
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-600 mr-2"></i>Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Confirm your password">
                    @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="text-xs sm:text-sm text-gray-600 mt-3 mb-0.5">
                    <p><i class="fas fa-info-circle mr-1 text-blue-500"></i> By creating an account, you agree to our <a href="#" class="text-blue-600 hover:text-blue-700 hover:underline">
                        Terms of Service</a> and have read and acknowledge our <a href="#" class="text-blue-600 hover:text-blue-700 hover:underline">
                            Privacy Policy</a>. You understand that your health information will be stored securely and used only
                        for healthcare purposes.</p>
                </div>

                <div class="pt-2 sm:pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 cursor-pointer text-white py-2.5 sm:py-3 px-4 rounded-lg hover:bg-blue-700 active:bg-blue-800 transition-colors font-semibold text-base sm:text-lg shadow-sm">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Copyright footer -->
    <footer class="text-center mt-5 sm:mt-6 mb-6 sm:mb-10 pb-4 px-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>

    @vite(['resources/js/main/userAuth/registration.js'])
</body>

</html>