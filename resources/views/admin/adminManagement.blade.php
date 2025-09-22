<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>MyCareX - Admin Management</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
    <script src="https://kit.fontawesome.com/1bdb4b0595.js" crossorigin="anonymous"></script>
</head>

<body class="font-[Inter] bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        
        <!-- Sidebar -->
        @include('admin.components.sidebar')

        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button type="button" class="fixed top-4 left-4 z-50 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" id="mobile-menu-button">
                <span class="sr-only">Open sidebar</span>
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 w-max flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b h-20 border-gray-200">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <h1 class="text-2xl font-semibold text-gray-900">Admin Management</h1>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">
                                {{ now()->format('F j, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    
                    <!-- Page Header -->
                    <div class="md:flex md:items-center md:justify-between mb-6">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-xl font-bold leading-7 text-gray-900 sm:text-2xl sm:truncate">
                                Pending Admin Verifications
                            </h2>
                            <p class="mt-1 text-sm text-gray-500">
                                Review and manage admin account verification requests
                            </p>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-clock text-yellow-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Pending</p>
                                        <p class="text-lg font-semibold text-gray-900">3</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Approved</p>
                                        <p class="text-lg font-semibold text-gray-900">12</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-500">Rejected</p>
                                        <p class="text-lg font-semibold text-gray-900">2</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Admins Table -->
                    <div class="bg-white shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Pending Verification Requests</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Admin accounts awaiting verification approval
                            </p>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Admin Details
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact Info
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Registration Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    
                                    <!-- Sample Row 1 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">JD</span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">John Doe</div>
                                                    <div class="text-sm text-gray-500">MCX0002</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">john.doe@example.com</div>
                                            <div class="text-sm text-gray-500">+60123456789</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ now()->subDays(2)->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Empty State (Hidden) -->
                                    <tr class="hidden" id="empty-state">
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <i class="fas fa-inbox text-gray-300 text-4xl mb-4"></i>
                                                <h3 class="text-lg font-medium text-gray-900 mb-2">No pending verifications</h3>
                                                <p class="text-gray-500">All admin accounts have been processed.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="lg:hidden fixed inset-0 z-40 bg-gray-600 bg-opacity-75 hidden" id="sidebar-overlay"></div>

    <!-- Confirmation Modal -->
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" id="confirmation-modal">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100" id="modal-icon">
                    <i class="fas fa-exclamation-triangle text-red-600" id="modal-icon-class"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-2" id="modal-title">Confirm Action</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modal-message">
                        Are you sure you want to perform this action? This cannot be undone.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="modal-confirm" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Confirm
                    </button>
                    <button id="modal-cancel" class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });

        // Modal functionality
        const modal = document.getElementById('confirmation-modal');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modal-message');
        const modalIcon = document.getElementById('modal-icon');
        const modalIconClass = document.getElementById('modal-icon-class');
        const modalConfirm = document.getElementById('modal-confirm');
        const modalCancel = document.getElementById('modal-cancel');

        // Action buttons
        document.querySelectorAll('button[title="Approve"]').forEach(button => {
            button.addEventListener('click', function() {
                showModal('Approve Admin', 'Are you sure you want to approve this admin account?', 'approve', 'green');
            });
        });

        document.querySelectorAll('button[title="Reject"]').forEach(button => {
            button.addEventListener('click', function() {
                showModal('Reject Admin', 'Are you sure you want to reject this admin account?', 'reject', 'red');
            });
        });

        document.querySelectorAll('button[title="Suspend"]').forEach(button => {
            button.addEventListener('click', function() {
                showModal('Suspend Admin', 'Are you sure you want to suspend this admin account?', 'suspend', 'orange');
            });
        });

        function showModal(title, message, action, color) {
            modalTitle.textContent = title;
            modalMessage.textContent = message;
            
            // Update modal colors
            modalIcon.className = `mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-${color}-100`;
            modalIconClass.className = `fas fa-exclamation-triangle text-${color}-600`;
            modalConfirm.className = `px-4 py-2 bg-${color}-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-${color}-700 focus:outline-none focus:ring-2 focus:ring-${color}-300`;
            
            modal.classList.remove('hidden');
        }

        modalCancel.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        modalConfirm.addEventListener('click', function() {
            // Handle the confirmation logic here
            modal.classList.add('hidden');
            // Add your backend logic here
        });
    </script>
</body>

</html>