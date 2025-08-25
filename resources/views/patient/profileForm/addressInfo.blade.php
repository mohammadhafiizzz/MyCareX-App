<!-- Edit Address Information Modal -->
<div id="editAddressInfo"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="editAddressInfoContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Edit Address Information</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" id="closeeditAddressInfo">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="#" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Home Address -->
                    <div>
                        <label for="edit_address" class="block text-sm font-medium text-gray-700 mb-2">
                            Home Address <span class="text-red-500">*</span>
                        </label>
                        <textarea id="edit_address" name="address" rows="3" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none text-sm sm:text-base"
                            placeholder="Enter your complete home address">{{ Auth::guard('patient')->user()->address }}</textarea>
                    </div>

                    <!-- Postal Code & State -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="edit_postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Postal Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_postal_code" name="postal_code" required maxlength="5"
                                value="{{ Auth::guard('patient')->user()->postal_code }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                                placeholder="e.g. 88000">
                        </div>

                        <div>
                            <label for="edit_state" class="block text-sm font-medium text-gray-700 mb-2">
                                State <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_state" name="state" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base">
                                <option value="">Select State</option>
                                <option value="Johor" {{ Auth::guard('patient')->user()->state === 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ Auth::guard('patient')->user()->state === 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ Auth::guard('patient')->user()->state === 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                <option value="Malacca" {{ Auth::guard('patient')->user()->state === 'Malacca' ? 'selected' : '' }}>Malacca</option>
                                <option value="Negeri Sembilan" {{ Auth::guard('patient')->user()->state === 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                <option value="Pahang" {{ Auth::guard('patient')->user()->state === 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Penang" {{ Auth::guard('patient')->user()->state === 'Penang' ? 'selected' : '' }}>Penang</option>
                                <option value="Perak" {{ Auth::guard('patient')->user()->state === 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ Auth::guard('patient')->user()->state === 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Sabah" {{ Auth::guard('patient')->user()->state === 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ Auth::guard('patient')->user()->state === 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ Auth::guard('patient')->user()->state === 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                <option value="Terengganu" {{ Auth::guard('patient')->user()->state === 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                <option value="Kuala Lumpur" {{ Auth::guard('patient')->user()->state === 'Kuala Lumpur' ? 'selected' : '' }}>W.P. Kuala Lumpur</option>
                                <option value="Labuan" {{ Auth::guard('patient')->user()->state === 'Labuan' ? 'selected' : '' }}>W.P. Labuan</option>
                                <option value="Putrajaya" {{ Auth::guard('patient')->user()->state === 'Putrajaya' ? 'selected' : '' }}>W.P. Putrajaya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Full Address Display -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Complete Address Preview</label>
                        <div
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg text-sm sm:text-base text-gray-700">
                            {{ Auth::guard('patient')->user()->full_address ?: 'Address will be displayed here' }}
                        </div>
                    </div>
                </div>

                <!-- Modal Footer - Sticky at bottom -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-start space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200 sticky bottom-0 bg-white">
                    <button type="submit"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm sm:text-base">
                        <i class="fas fa-save mr-2"></i>Save Changes
                    </button>
                    <button type="button"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm sm:text-base"
                        onclick="closeModal('editAddressInfo', 'editAddressInfoContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>