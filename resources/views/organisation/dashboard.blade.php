<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-50">

    <!-- Header -->
    @include('organisation.components.header')

    <!-- Sidebar -->
    @include('organisation.components.sidebar')

    <!-- Main Content -->
    <div class="lg:ml-68 transition-all duration-300 mt-20" id="mainContent">
        <div class="bg-gray-50 min-h-screen">
            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">

                <!-- Dashboard Content - Verified provider -->
                @if ($isVerified)
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="mt-1 text-sm text-gray-600">Welcome back! Here's what's happening with your current
                            status.</p>
                    </div>

                @else
                    <!-- Dashboard Content - Unverified provider -->
                    <p class="text-lg text-red-600 max-w-3xl mt-10 mx-auto">
                        Your organisation is currently unverified. Please contact the
                        <a href="mailto:support@mycarex.gov.my" class="underline text-blue-600">support@mycarex.gov.my</a>
                    </p>

                @endif

                @if ($isVerified)
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-6">
                        <!-- Total Doctors -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-blue-100 p-3">
                                            <i class="fas fa-user-doctor text-blue-600 text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Total Doctors</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">{{ $totalDoctors }}</div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Doctors -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-blue-100 p-3">
                                            <i class="fas fa-user-check text-blue-600 text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Active Doctors</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">{{ $activeDoctors }}</div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inactive Doctors -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-blue-100 p-3">
                                            <i class="fas fa-user-clock text-blue-600 text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Inactive Doctors</dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">{{ $inactiveDoctors }}</div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-5 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
                        </div>
                        <div class="p-5">
                            <div class="text-center py-12">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">No recent activity to display</p>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- Features Section -->
                    <section class="py-10" id="features">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-10">
                                <h2 class="text-2xl md:text-xl font-bold text-gray-900 mb-4">
                                    Available Features:
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-users text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patients</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                                    </p>
                                </div>

                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-hand-holding-medical text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Records Access</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Access complete patient medical histories, medications, allergies, and treatment
                                        plans in real-time across your network.
                                    </p>
                                </div>

                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-heart-circle-check text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Real-time Data</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                                    </p>
                                </div>

                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-handshake text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Interoperability</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                                    </p>
                                </div>

                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-universal-access text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Access & Permissions</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                                    </p>
                                </div>

                                <div
                                    class="bg-white p-8 rounded-lg shadow-sm hover:shadow-lg transition-all duration-200 border border-gray-100">
                                    <div class="w-12 h-12 bg-blue-100 rounded-md flex items-center justify-center mb-6">
                                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Security+</h3>
                                    <p class="text-gray-600 text-sm leading-relaxed">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Suspendisse turpis magna, vestibulum ut arcu non, iaculis bibendum ligula.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>

    <!-- Javascript and Footer -->

    @include('organisation.components.footer')

    @vite(['resources/js/main/organisation/header.js'])
</body>

</html>