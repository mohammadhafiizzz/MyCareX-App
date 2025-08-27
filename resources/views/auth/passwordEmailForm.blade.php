<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Forgot Password - MyCareX</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Add this to all authentication pages in the header section -->
    <div class="max-w-7xl mx-auto px-4 mt-20 sm:px-6 lg:px-8 p-2">
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
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <div class="text-center mb-4 mt-4">
            <i class="fas fa-unlock-alt text-blue-500 mb-2 text-4xl"></i>
            <h1 class="text-2xl font-bold text-gray-900">Forgot Password</h1>
        </div>

        @if (session('status'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <p class="text-gray-600 mb-6">
            Enter the email address you used to register. We will send you a link to reset your password.
        </p>

        <form action="{{ route('patient.password.email') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="your.email@example.com" />
            </div>
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                Send Reset Link
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-700">Back to Home</a>
        </div>
    </div>

    <!-- Copyright footer -->
    <footer class="text-center mt-8 pb-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>
</body>

</html>