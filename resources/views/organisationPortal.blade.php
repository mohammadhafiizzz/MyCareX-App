<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Organisation Portal</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" />
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>
<body class="font-[Inter] bg-gray-50 min-h-screen">
    <!-- Logo Branding -->
    <div class="max-w-7xl mx-auto px-4 mt-15 sm:px-6 lg:px-8 p-2">
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
    
    <div class="max-w-xl mx-auto mt-2 bg-white p-8 rounded-xl shadow-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Organisation Portal <i class="fas fa-hospital text-blue-600"></i></h1>
            <p class="text-gray-600 mt-2">Access your healthcare organisation account</p>
        </div>
        
        <!-- Organisation Login Form -->
        <form id="orgLoginForm" action="#" method="POST">
            <!-- Organisation Field -->
            <div class="mb-6">
                <label for="organisation" class="block text-sm font-medium text-gray-700 mb-2">Select Your Organisation</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="organisation" 
                        name="organisation" 
                        list="organisationList"
                        placeholder="Type or select an organisation..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        autocomplete="off"
                    >
                    <datalist id="organisationList">
                        <option value="City General Hospital">
                        <option value="Metropolitan Medical Center">
                        <option value="Sunset Healthcare Clinic">
                        <option value="Green Valley Medical Group">
                        <option value="Riverside Hospital">
                        <option value="Central Health Services">
                        <option value="Unity Medical Center">
                    </datalist>
                </div>
            </div>
            
            <!-- Dynamic Fields (Initially Hidden) -->
            <div id="loginFields" class="hidden space-y-4">
                <!-- Medical ID Field -->
                <div>
                    <label for="medicalId" class="block text-sm font-medium text-gray-700 mb-2">Medical ID</label>
                    <input 
                        type="text" 
                        id="medicalId" 
                        name="medical_id" 
                        placeholder="Enter your Medical ID"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    >
                </div>
                
                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    >
                </div>
                
                <!-- Submit Button -->
                <div class="mt-6">
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition"
                    >
                        Sign In
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Copyright footer -->
    <footer class="text-center mt-8 pb-4">
        <p class="text-xs text-gray-500">&copy; {{ date('Y') }} MyCareX. All rights reserved.</p>
    </footer>
    
    <!-- Include the JavaScript file -->
    @vite(['resources/js/main/organisation/orgLogin.js'])
</body>
</html>