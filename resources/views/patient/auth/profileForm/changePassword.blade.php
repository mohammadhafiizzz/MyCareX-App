<!-- Change Password Modal -->
<div id="changePasswordModal"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="changePasswordModalContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Change Password</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" id="closechangePasswordModal">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="{{ route('patient.auth.profile.update.password') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Current Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                                placeholder="Enter current password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('current_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">
                            New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                                placeholder="Enter new password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('new_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters and numbers</p>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm New Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                                placeholder="Confirm new password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="bg-blue-50 p-4 rounded-lg mt-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-shield-alt text-blue-500 mt-1"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-2">Password Security Tips:</p>
                            <ul class="space-y-1">
                                <li>• Use at least 8 characters</li>
                                <li>• Include uppercase and lowercase letters</li>
                                <li>• Add numbers and special characters</li>
                                <li>• Avoid personal information</li>
                                <li>• Don't reuse old passwords</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer - Sticky at bottom -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-start space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200 sticky bottom-0 bg-white">
                    <button type="submit"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-key mr-2"></i>Change Password
                    </button>
                    <button type="button"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                        onclick="closeModal('changePasswordModal', 'changePasswordModalContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>