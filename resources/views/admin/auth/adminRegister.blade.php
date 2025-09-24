<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Register Admin</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Logo Branding -->
    <div class="max-w-7xl mx-auto px-4 mt-8 sm:px-6 lg:px-8 p-2">
        <div class="flex items-center justify-center h-16">
            <div class="flex items-center space-x-3 mb-2">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-10 h-10 rounded-lg">
                <div class="flex flex-col">
                    <span class="text-xl font-semibold text-gray-900">MyCareX</span>
                    <small class="text-xs font-normal text-gray-500">
                        Personal Healthcare Records
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="max-w-2xl mx-auto mt-4 bg-white p-8 rounded-xl shadow-md">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Admin Registration 
                <i class="fas fa-user-plus text-blue-600"></i>
            </h1>
            <p class="text-sm text-gray-600 mt-2">Create a new administrator account</p>
        </div>

        <!-- First Admin Notice -->
        @if (!$recordExists)
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <p class="text-sm font-medium">
                        No admin user is registered. You are registering the first admin who will be the "Super Admin" with full system privileges.
                    </p>
                </div>
            </div>
        @endif

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle mr-2 mt-0.5"></i>
                    <div>
                        <p class="font-medium text-sm mb-2">Please correct the following errors:</p>
                        <ul class="list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.register') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Row 1: Full Name & IC Number -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="fullName" 
                           name="full_name" 
                           value="{{ old('full_name') }}"
                           placeholder="Enter your full name"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('full_name') border-red-300 @enderror" 
                           required>
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icNumber" class="block text-sm font-medium text-gray-700 mb-2">
                        IC Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="icNumber" 
                           name="ic_number" 
                           value="{{ old('ic_number') }}"
                           placeholder="123456-78-9012"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('ic_number') border-red-300 @enderror" 
                           required>
                    @error('ic_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 2: Email & Phone -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="emailAddress" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="emailAddress" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="admin@mycarex.com"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-300 @enderror" 
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" 
                           id="phoneNumber" 
                           name="phone_number" 
                           value="{{ old('phone_number') }}"
                           placeholder="+60123456789"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('phone_number') border-red-300 @enderror" 
                           required>
                    @error('phone_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 3: Password Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               placeholder="Enter secure password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-300 @enderror" 
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="confirmPassword" 
                               name="password_confirmation" 
                               placeholder="Confirm your password"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" 
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                id="toggleConfirmPassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Password Requirements:</h4>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>At least 8 characters long</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Contains both letters and numbers</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Passwords must match</li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition font-medium">
                    <i class="fas fa-user-plus mr-2"></i>
                    Create Admin Account
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="text-center mt-6">
            <hr class="my-6 border-gray-300">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('admin.login') }}" 
                   class="text-blue-600 hover:text-blue-800 font-medium">
                    Sign in here
                </a>
            </p>
        </div>
    </div>

    <!-- Copyright Footer -->
    <footer class="text-center mt-8 pb-8">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>

    <!-- JavaScript for password toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const toggleButtons = [
                { btn: 'togglePassword', input: 'password' },
                { btn: 'toggleConfirmPassword', input: 'confirmPassword' }
            ];

            toggleButtons.forEach(item => {
                const button = document.getElementById(item.btn);
                const input = document.getElementById(item.input);
                
                if (button && input) {
                    button.addEventListener('click', function() {
                        const type = input.type === 'password' ? 'text' : 'password';
                        input.type = type;
                        
                        const icon = button.querySelector('i');
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    });
                }
            });
        });
    </script>
</body>

</html>