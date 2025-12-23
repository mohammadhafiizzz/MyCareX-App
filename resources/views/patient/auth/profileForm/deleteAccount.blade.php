<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('deleteAccountModal', 'deleteAccountModalContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="deleteAccountModalContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-red-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-red-900">Delete Account</h3>
                <button type="button" onclick="closeModal('deleteAccountModal', 'deleteAccountModalContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="px-6 py-6">
                <!-- Warning Icon -->
                <div class="flex justify-center mb-6">
                    <div class="bg-red-100 rounded-full p-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Are you sure?</h3>
                    <p class="text-sm text-gray-600">This action cannot be undone. This will permanently delete your account and all associated data.</p>
                </div>

                <!-- What will be deleted -->
                <div class="bg-red-50/50 border border-red-100 rounded-lg p-4 mb-6">
                    <h4 class="text-xs font-bold text-red-900 mb-3 uppercase">The following data will be permanently deleted:</h4>
                    <ul class="space-y-2 text-xs text-red-800">
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            Personal information and profile
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            Medical records and health data
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            Emergency contact information
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            Account credentials and settings
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-times-circle text-red-500"></i>
                            All uploaded documents and images
                        </li>
                    </ul>
                </div>

                <!-- Confirmation Form -->
                <form action="{{ route('patient.profile.delete.account') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Password Confirmation -->
                    <div class="mb-6">
                        <label for="delete_password" class="block text-xs font-bold text-gray-400 uppercase mb-1">Confirm your password to proceed</label>
                        <div class="relative">
                            <input type="password" id="delete_password" name="password" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all text-sm outline-none pr-12"
                                placeholder="Enter your password">
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                onclick="togglePasswordVisibility('delete_password', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Final Confirmation Checkbox -->
                    <div class="mb-6">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="delete_confirmation" name="delete_confirmation" required
                                class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 mt-0.5">
                            <label for="delete_confirmation" class="text-xs text-gray-700 leading-relaxed">
                                I understand that this action is permanent and irreversible. I want to delete my account and all associated data.
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeModal('deleteAccountModal', 'deleteAccountModalContent')" class="px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-800 border hover:bg-gray-100 border-gray-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                            Cancel
                        </button>
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 shadow-sm transition-all">
                            Delete Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>