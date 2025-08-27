<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Reset Password - MyCareX</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md">
        <div class="text-center mb-6">
            <i class="fas fa-key text-blue-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900">Reset Your Password</h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('patient.password.update') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}" />
            <input type="hidden" name="email" value="{{ $email }}" />

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Enter new password" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm New Password
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Re-type new password" />
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                Reset Password
            </button>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-700">Back to Home</a>
        </div>
    </div>
</body>

</html>