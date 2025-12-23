<!-- Edit Address Information Modal -->
<div id="editAddressInfo" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('editAddressInfo', 'editAddressInfoContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="editAddressInfoContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Address Information</h3>
                <button type="button" onclick="closeModal('editAddressInfo', 'editAddressInfoContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.address') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <!-- Home Address -->
                    <div>
                        <label for="edit_address" class="block text-xs font-bold text-gray-400 uppercase mb-1">Home Address</label>
                        <textarea id="edit_address" name="address" rows="3" required
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none resize-none"
                            placeholder="Enter your complete home address">{{ Auth::guard('patient')->user()->address }}</textarea>
                    </div>

                    <!-- Postal Code & State -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_postal_code" class="block text-xs font-bold text-gray-400 uppercase mb-1">Postal Code</label>
                            <input type="text" id="edit_postal_code" name="postal_code" required maxlength="5"
                                value="{{ Auth::guard('patient')->user()->postal_code }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="e.g. 88000">
                        </div>

                        <div>
                            <label for="edit_state" class="block text-xs font-bold text-gray-400 uppercase mb-1">State</label>
                            <select id="edit_state" name="state" required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
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
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Complete Address Preview</label>
                        <div class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 italic">
                            {{ Auth::guard('patient')->user()->full_address ?: 'Address will be displayed here' }}
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editAddressInfo', 'editAddressInfoContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>