<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <div class="max-w-md mx-auto mt-20 p-6 bg-white rounded-lg shadow-md">
        <div class="text-center mb-6">
            <i class="fas fa-envelope text-blue-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900">Verify Your Email</h1>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <p class="text-gray-600 mb-6">
            A verification link has been sent to your email address. Please click the link to verify your account before
            logging in.
        </p>

        <div class="bg-blue-50 p-4 rounded-lg mb-6">
            <p class="text-sm text-blue-800">
                <strong>Note:</strong> If you don't see the email, check your spam folder or
                <a href="{{ route('verification.resend') }}" class="text-blue-600 hover:underline">
                    click here to resend
                </a>
            </p>
        </div>

        <a href="{{ route('index') }}"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors block text-center">
            Return to Login
        </a>
    </div>
</body>

</html>