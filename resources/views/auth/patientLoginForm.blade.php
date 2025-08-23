<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95"
        id="loginModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/MyCareX_Logo.png') }}" alt="MyCareX Logo" class="w-8 h-8 rounded-lg">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Sign In to MyCareX</h2>
                    <p class="text-sm text-gray-500">Access your health records</p>
                </div>
            </div>
            <button class="text-gray-400 hover:text-gray-600 transition-colors" id="closeModalBtn">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form action="{{ route('patient.login') }}" method="POST" class="space-y-4">
                @csrf
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- IC Number Field -->
                <div>
                    <label for="icNumber" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-id-card text-gray-600 mr-2"></i>IC Number
                    </label>
                    <input type="text" id="icNumber" name="ic_number" required maxlength="14"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Enter your IC number without dashes">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock text-gray-600 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                            placeholder="Enter your password">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 transition-colors">
                        Forgot password?
                    </a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or login with</span>
                    </div>
                </div>

                <!-- MyKad Login (Optional) -->
                <div class="grid gap-3">
                    <button type="button"
                        class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-envelope text-blue-600 mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">E-Mail</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="px-6 py-4 bg-gray-50 rounded-b-xl">
            <p class="text-center text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('patient.register.form') }}" class="text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    Create one here
                </a>
            </p>
        </div>
    </div>
</div>