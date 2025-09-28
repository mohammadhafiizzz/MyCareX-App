<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Admin Template</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        
        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Main Content -->
        
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden" id="sidebar-overlay"></div>

    <!-- Javascript and Footer -->
    
</body>

</html>