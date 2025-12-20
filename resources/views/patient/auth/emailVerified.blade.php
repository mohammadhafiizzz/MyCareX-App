<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="refresh" content="5; url={{ route('patient.login.form') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Email Verified</title>
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
                        <i class="fas fa-circle-check text-green-600 text-3xl mb-4"></i>
                        <h2 class="text-2xl font-semibold text-gray-900">Email Verified Successfully!</h2>
                        <p class="mt-4 text-sm text-gray-600 mb-8">
                            You can now sign in with to MyCareX.
                            You will be redirected to the login page in <span id="countdown">5</span> seconds.
                        </p>
                    </div>

                    <!-- Login Button -->
                    <div>
                        <a href="{{ route('patient.login.form') }}"
                            class="cursor-pointer w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Login Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Copyright footer -->
            <footer class="text-center mt-8 pb-4">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
            </footer>
        </div>
    </div>
    
    <script>
        let seconds = 5;
        const el = document.getElementById('countdown');
        const t = setInterval(() => {
            seconds--;
            el.textContent = seconds;
            if (seconds <= 0) clearInterval(t);
        }, 1000);
    </script>
</body>

</html>