<div id="editContactModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40 close-modal" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Contact & Location</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="editContactForm" action="{{ route('organisation.profile.update.contact') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">Office Phone</label>
                            <input type="text" name="phone_number" id="phone_number" value="{{ $organisation->phone_number }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                        </div>
                        <div>
                            <label for="emergency_contact" class="block text-xs font-bold text-gray-400 uppercase mb-1">Emergency Contact</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" value="{{ $organisation->emergency_contact }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-xs font-bold text-gray-400 uppercase mb-1">Street Address</label>
                        <textarea name="address" id="address" rows="3" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none resize-none" required>{{ $organisation->address }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="postal_code" class="block text-xs font-bold text-gray-400 uppercase mb-1">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ $organisation->postal_code }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                        </div>
                        <div>
                            <label for="state" class="block text-xs font-bold text-gray-400 uppercase mb-1">State</label>
                            <select name="state" id="state" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                                <option value="Johor" {{ $organisation->state == 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ $organisation->state == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ $organisation->state == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                <option value="Melaka" {{ $organisation->state == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                <option value="Negeri Sembilan" {{ $organisation->state == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                <option value="Pahang" {{ $organisation->state == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Perak" {{ $organisation->state == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ $organisation->state == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Pulau Pinang" {{ $organisation->state == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                <option value="Sabah" {{ $organisation->state == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ $organisation->state == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ $organisation->state == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                <option value="Terengganu" {{ $organisation->state == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                <option value="W.P. Kuala Lumpur" {{ $organisation->state == 'W.P. Kuala Lumpur' ? 'selected' : '' }}>W.P. Kuala Lumpur</option>
                                <option value="W.P. Labuan" {{ $organisation->state == 'W.P. Labuan' ? 'selected' : '' }}>W.P. Labuan</option>
                                <option value="W.P. Putrajaya" {{ $organisation->state == 'W.P. Putrajaya' ? 'selected' : '' }}>W.P. Putrajaya</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="close-modal px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
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
