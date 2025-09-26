<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5; url={{ route('index') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Email Verified - MyCareX</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Logo Branding -->
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

    <!-- Email Verification Success Message -->
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <div class="text-center mb-4 mt-4">
            <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
            <h1 class="text-2xl font-bold text-gray-900">Email Verified Successfully!</h1>
        </div>

        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded mb-6">
            <p>Organisation email has been successfully verified. You can now access all features of MyCareX.</p>
        </div>

        <p class="text-gray-600 mb-6">
            You will be automatically redirected to the homepage in <span id="countdown">5</span> seconds.
        </p>

        <div class="text-center">
            <a href="{{ route('organisation.home') }}"
                class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Go to Homepage Now
            </a>
        </div>
    </div>

    <!-- Copyright footer -->
    <footer class="text-center mt-8 pb-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>

    <script>
        // Countdown timer
        let seconds = 5;
        const countdownElement = document.getElementById('countdown');

        const countdown = setInterval(() => {
            seconds--;
            countdownElement.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(countdown);
            }
        }, 1000);
    </script>
</body>

</html>