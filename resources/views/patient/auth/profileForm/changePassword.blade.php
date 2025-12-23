<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('changePasswordModal', 'changePasswordModalContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="changePasswordModalContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
                <button type="button" onclick="closeModal('changePasswordModal', 'changePasswordModalContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-xs font-bold text-gray-400 uppercase mb-1">Current Password</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none pr-12"
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
                        <label for="new_password" class="block text-xs font-bold text-gray-400 uppercase mb-1">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none pr-12"
                                placeholder="Enter new password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('new_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-1 italic">Minimum 8 characters with letters and numbers</p>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-gray-400 uppercase mb-1">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none pr-12"
                                placeholder="Confirm new password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Security Tips -->
                    <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-shield-alt text-blue-500 mt-0.5"></i>
                            <div class="text-xs text-blue-800">
                                <p class="font-bold mb-2 uppercase">Password Security Tips:</p>
                                <div class="grid grid-cols-1 gap-1">
                                    <p>• Use at least 8 characters</p>
                                    <p>• Include uppercase, lowercase, numbers & symbols</p>
                                    <p>• Avoid personal information or reusing old passwords</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('changePasswordModal', 'changePasswordModalContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>