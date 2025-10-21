<!-- Edit Personal Information Modal -->
<div id="editPersonalInfo"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-200 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="editPersonalInfoContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Edit Personal Information</h2>
            <button class="cursor-pointer text-gray-400 hover:text-gray-600 transition-colors"
                id="closeeditPersonalInfo">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="{{ route('patient.auth.profile.update.personal') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <!-- Full Name -->
                    <div class="md:col-span-2">
                        <label for="edit_full_name" class="block text-sm font-medium text-gray-700 mb-2">Full
                            Name</label>
                        <input type="text" id="edit_full_name" name="full_name"
                            value="{{ Auth::guard('patient')->user()->full_name }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                            Address</label>
                        <input type="email" id="edit_email" name="email"
                            value="{{ Auth::guard('patient')->user()->email }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="edit_phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone
                            Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number"
                            value="{{ Auth::guard('patient')->user()->phone_number }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="edit_date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of
                            Birth</label>
                        <input type="date" id="edit_date_of_birth" name="date_of_birth"
                            value="{{ Auth::guard('patient')->user()->date_of_birth->format('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="edit_gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                        <select id="edit_gender" name="gender"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                            <option value="Male" {{ Auth::guard('patient')->user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ Auth::guard('patient')->user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Blood Type -->
                    <div>
                        <label for="edit_blood_type" class="block text-sm font-medium text-gray-700 mb-2">Blood
                            Type</label>
                        <select id="edit_blood_type" name="blood_type"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                            <option value="A+" {{ Auth::guard('patient')->user()->blood_type === 'A+' ? 'selected' : '' }}>A+</option>
                            <option value="A-" {{ Auth::guard('patient')->user()->blood_type === 'A-' ? 'selected' : '' }}>A-</option>
                            <option value="B+" {{ Auth::guard('patient')->user()->blood_type === 'B+' ? 'selected' : '' }}>B+</option>
                            <option value="B-" {{ Auth::guard('patient')->user()->blood_type === 'B-' ? 'selected' : '' }}>B-</option>
                            <option value="AB+" {{ Auth::guard('patient')->user()->blood_type === 'AB+' ? 'selected' : '' }}>AB+</option>
                            <option value="AB-" {{ Auth::guard('patient')->user()->blood_type === 'AB-' ? 'selected' : '' }}>AB-</option>
                            <option value="O+" {{ Auth::guard('patient')->user()->blood_type === 'O+' ? 'selected' : '' }}>O+</option>
                            <option value="O-" {{ Auth::guard('patient')->user()->blood_type === 'O-' ? 'selected' : '' }}>O-</option>
                            <option value="unknown" {{ Auth::guard('patient')->user()->blood_type === 'unknown' ? 'selected' : '' }}>Do Not Know</option>
                        </select>
                    </div>

                    <!-- Race -->
                    <div>
                        <label for="edit_race" class="block text-sm font-medium text-gray-700 mb-2">Race</label>
                        <select id="edit_race" name="race"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base"
                            required>
                            @php
                                $userRace = Auth::guard('patient')->user()->race;
                                $predefinedRaces = ['Malay', 'Chinese', 'Indian'];
                                $isOtherRace = !in_array($userRace, $predefinedRaces);
                            @endphp
                            <option value="Malay" {{ $userRace === 'Malay' ? 'selected' : '' }}>Malay</option>
                            <option value="Chinese" {{ $userRace === 'Chinese' ? 'selected' : '' }}>Chinese</option>
                            <option value="Indian" {{ $userRace === 'Indian' ? 'selected' : '' }}>Indian</option>
                            <option value="Other" {{ $isOtherRace ? 'selected' : '' }}>Other</option>
                        </select>
                        <input type="text" id="edit_other_race" name="other_race"
                            class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm sm:text-base {{ $isOtherRace ? '' : 'hidden' }}"
                            placeholder="Please specify your race" value="{{ $isOtherRace ? $userRace : '' }}">
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
                        onclick="closeModal('editPersonalInfo', 'editPersonalInfoContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>