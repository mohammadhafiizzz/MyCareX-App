<!-- Edit Emergency Contact Modal -->
<div id="editEmergencyInfo"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="editEmergencyInfoContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Edit Emergency Contact</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" id="closeeditEmergencyInfo">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="{{ route('patient.auth.profile.update.emergency') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Contact Name & IC Number -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="edit_emergency_contact_name"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Contact Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_emergency_contact_name" name="emergency_contact_name" required
                                value="{{ Auth::guard('patient')->user()->emergency_contact_name }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                                placeholder="Full name">
                        </div>

                        <div>
                            <label for="edit_emergency_contact_ic_number"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                IC Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="edit_emergency_contact_ic_number" name="emergency_contact_ic_number"
                                required maxlength="14"
                                value="{{ Auth::guard('patient')->user()->emergency_contact_ic_number }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                                placeholder="123456-78-9012">
                        </div>
                    </div>

                    <!-- Phone & Relationship -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="edit_emergency_contact_number"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" id="edit_emergency_contact_number" name="emergency_contact_number"
                                required value="{{ Auth::guard('patient')->user()->emergency_contact_number }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                                placeholder="01X-XXX XXXX">
                        </div>

                        <div>
                            <label for="edit_emergency_contact_relationship"
                                class="block text-sm font-medium text-gray-700 mb-2">
                                Relationship <span class="text-red-500">*</span>
                            </label>
                            <select id="edit_emergency_contact_relationship" name="emergency_contact_relationship"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base">
                                @php
                                    $userRelationship = Auth::guard('patient')->user()->emergency_contact_relationship;
                                    $predefinedRelationships = ['Spouse', 'Parent', 'Child', 'Sibling', 'Friend'];
                                    $isOtherRelationship = $userRelationship && !in_array($userRelationship, $predefinedRelationships);
                                @endphp
                                <option value="">Select Relationship</option>
                                <option value="Spouse" {{ $userRelationship === 'Spouse' ? 'selected' : '' }}>Spouse
                                </option>
                                <option value="Parent" {{ $userRelationship === 'Parent' ? 'selected' : '' }}>Parent
                                </option>
                                <option value="Child" {{ $userRelationship === 'Child' ? 'selected' : '' }}>Child</option>
                                <option value="Sibling" {{ $userRelationship === 'Sibling' ? 'selected' : '' }}>Sibling
                                </option>
                                <option value="Friend" {{ $userRelationship === 'Friend' ? 'selected' : '' }}>Friend
                                </option>
                                <option value="Other" {{ $isOtherRelationship ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" id="edit_other_emergency_relationship"
                                name="other_emergency_relationship"
                                class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base {{ $isOtherRelationship ? '' : 'hidden' }}"
                                placeholder="Please specify relationship"
                                value="{{ $isOtherRelationship ? $userRelationship : '' }}">
                        </div>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="bg-red-50 p-4 rounded-lg mt-6">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-1"></i>
                        <div class="text-sm text-red-800">
                            <p class="font-medium mb-1">Important:</p>
                            <p>This person will be contacted in case of medical emergencies. Please ensure all
                                information is accurate and up-to-date.</p>
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
                        onclick="closeModal('editEmergencyInfo', 'editEmergencyInfoContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>