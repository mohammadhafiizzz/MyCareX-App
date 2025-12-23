<!-- Edit Emergency Contact Modal -->
<div id="editEmergencyInfo" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('editEmergencyInfo', 'editEmergencyInfoContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="editEmergencyInfoContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Emergency Contact</h3>
                <button type="button" onclick="closeModal('editEmergencyInfo', 'editEmergencyInfoContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.emergency') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <!-- Contact Name & IC Number -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_emergency_contact_name" class="block text-xs font-bold text-gray-400 uppercase mb-1">Contact Name</label>
                            <input type="text" id="edit_emergency_contact_name" name="emergency_contact_name" required
                                value="{{ Auth::guard('patient')->user()->emergency_contact_name }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="Full name">
                        </div>

                        <div>
                            <label for="edit_emergency_contact_ic_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">IC Number</label>
                            <input type="text" id="edit_emergency_contact_ic_number" name="emergency_contact_ic_number"
                                required maxlength="14"
                                value="{{ Auth::guard('patient')->user()->emergency_contact_ic_number }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="123456-78-9012">
                        </div>
                    </div>

                    <!-- Phone & Relationship -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_emergency_contact_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">Phone Number</label>
                            <input type="tel" id="edit_emergency_contact_number" name="emergency_contact_number"
                                required value="{{ Auth::guard('patient')->user()->emergency_contact_number }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                placeholder="01X-XXX XXXX">
                        </div>

                        <div>
                            <label for="edit_emergency_contact_relationship" class="block text-xs font-bold text-gray-400 uppercase mb-1">Relationship</label>
                            <select id="edit_emergency_contact_relationship" name="emergency_contact_relationship"
                                required
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
                                @php
                                    $userRelationship = Auth::guard('patient')->user()->emergency_contact_relationship;
                                    $predefinedRelationships = ['Spouse', 'Parent', 'Child', 'Sibling', 'Friend'];
                                    $isOtherRelationship = $userRelationship && !in_array($userRelationship, $predefinedRelationships);
                                @endphp
                                <option value="">Select Relationship</option>
                                <option value="Spouse" {{ $userRelationship === 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                <option value="Parent" {{ $userRelationship === 'Parent' ? 'selected' : '' }}>Parent</option>
                                <option value="Child" {{ $userRelationship === 'Child' ? 'selected' : '' }}>Child</option>
                                <option value="Sibling" {{ $userRelationship === 'Sibling' ? 'selected' : '' }}>Sibling</option>
                                <option value="Friend" {{ $userRelationship === 'Friend' ? 'selected' : '' }}>Friend</option>
                                <option value="Other" {{ $isOtherRelationship ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" id="edit_other_emergency_relationship"
                                name="other_emergency_relationship"
                                class="mt-2 w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none {{ $isOtherRelationship ? '' : 'hidden' }}"
                                placeholder="Please specify relationship"
                                value="{{ $isOtherRelationship ? $userRelationship : '' }}">
                        </div>
                    </div>

                    <!-- Info Box -->
                    <div class="bg-red-50/50 p-4 rounded-lg border border-red-100">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                            <div class="text-xs text-red-800">
                                <p class="font-bold mb-1 uppercase">Important:</p>
                                <p>This person will be contacted in case of medical emergencies. Please ensure all information is accurate and up-to-date.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editEmergencyInfo', 'editEmergencyInfoContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
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