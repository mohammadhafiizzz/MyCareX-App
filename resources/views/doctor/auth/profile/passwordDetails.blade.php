<!-- Change Password Modal -->
<div id="modalEditPassword" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40 close-modal" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-md shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Change Password</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="formEditPassword" action="{{ route('doctor.profile.update.password') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <!-- Current Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Current Password</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                            <button type="button" id="toggleCurrentPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i id="currentPasswordIcon" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                            <button type="button" id="toggleNewPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i id="newPasswordIcon" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordStrength" class="mt-2 text-xs hidden"></div>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                            <button type="button" id="toggleConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i id="confirmPasswordIcon" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatch" class="mt-2 text-xs hidden"></div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="close-modal px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-200 rounded-lg hover:bg-blue-100">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
