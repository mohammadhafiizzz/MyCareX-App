<!-- Delete Account Modal -->
<div id="deleteAccountModal"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="deleteAccountModalContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-red-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-red-900">Delete Account</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors"
                id="closedeleteAccountModal">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <div class="p-6">
                <!-- Warning Icon -->
                <div class="flex justify-center mb-6">
                    <div class="bg-red-100 rounded-full p-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-3xl"></i>
                    </div>
                </div>

                <!-- Warning Message -->
                <div class="text-center mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Are you sure?</h3>
                    <p class="text-gray-600">This action cannot be undone. This will permanently delete your account and
                        all associated data.</p>
                </div>

                <!-- What will be deleted -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <h4 class="font-medium text-red-900 mb-3">The following data will be permanently deleted:</h4>
                    <ul class="space-y-2 text-sm text-red-800">
                        <li class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            Personal information and profile
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            Medical records and health data
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            Emergency contact information
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            Account credentials and settings
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-times-circle text-red-500 mr-2"></i>
                            All uploaded documents and images
                        </li>
                    </ul>
                </div>

                <!-- Confirmation Form -->
                <form action="{{ route('patient.auth.profile.delete.account') }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <!-- Password Confirmation -->
                    <div class="mb-6">
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm your password to proceed <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="delete_password" name="password" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors pr-12"
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
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" id="delete_confirmation" name="delete_confirmation" required
                                class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500 mt-1">
                            <label for="delete_confirmation" class="text-sm text-gray-700">
                                I understand that this action is permanent and irreversible. I want to delete my account
                                and all associated data.
                            </label>
                        </div>
                    </div>

                    <!-- Modal Footer - Sticky at bottom -->
                    <div
                        class="flex flex-col sm:flex-row items-center justify-start space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 sticky bottom-0 bg-white">
                        <button type="submit"
                            class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium">
                            <i class="fas fa-trash-alt mr-2"></i>Delete Account
                        </button>
                        <button type="button"
                            class="w-full cursor-pointer sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                            onclick="closeModal('deleteAccountModal', 'deleteAccountModalContent')">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>