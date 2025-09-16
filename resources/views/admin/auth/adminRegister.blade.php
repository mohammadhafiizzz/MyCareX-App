<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Patient</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">

    <!-- Header -->

    <!-- Main Content -->
    <form action="#" method="POST">
        @csrf
        <p>
            <label for="fullName">Full Name </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="fullName" name="fullName" required>
        </p>

        <p>
            <label for="icNumber">IC Number </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="icNumber" name="icNumber" required>
        </p>

        <p>
            <label for="emailAddress">Email Address </label>
            <input class="border border-gray-300 p-2 rounded" type="email" id="emailAddress" name="emailAddress" required>
        </p>

        <p>
            <label for="phoneNumber">Phone Number </label>
            <input class="border border-gray-300 p-2 rounded" type="text" id="phoneNumber" name="phoneNumber" required>
        </p>

        <p>
            <label for="password">Password </label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="password" name="password" required>
        </p>

        <p>
            <label for="confirmPassword">Confirm Password </label>
            <input class="border border-gray-300 p-2 rounded" type="password" id="confirmPassword" name="confirmPassword" required>
        </p>

        <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer" type="submit">Register</button>
    </form>

    <!-- Footer -->
</body>

</html>