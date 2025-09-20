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

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->

    <!-- Main Content -->
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <p>
            <label for="fullName">Full Name </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="fullName" name="full_name" required>
        </p>

        <p>
            <label for="icNumber">IC Number </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="icNumber" name="ic_number" required>
        </p>

        <p>
            <label for="emailAddress">Email Address </label>
            <input class="border border-gray-300 p-2 rounded" type="email" id="emailAddress" name="email" required>
        </p>

        <p>
            <label for="phoneNumber">Phone Number </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="phoneNumber" name="phone_number" required>
        </p>

        <p>
            <label for="password">Password </label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="password" name="password" required>
        </p>

        <p>
            <label for="confirmPassword">Confirm Password </label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="confirmPassword" name="password_confirmation" required>
        </p>

        <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer" type="submit">Register</button>
    </form>

    @if (!$recordExists)
        <p class="text-red-500">No admin user is registered. Please fill out the form to register the first admin for this system. The admin will be the "Super Admin"</p>
    @endif

    <!-- Footer -->
</body>

</html>