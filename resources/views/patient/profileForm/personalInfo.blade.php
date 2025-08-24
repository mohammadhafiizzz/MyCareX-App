<!-- Personal Information Modals (hidden by default) -->
<!-- Edit Personal Information Modal -->
<div id="editPersonalInfo" class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl transform transition-all duration-300 scale-95"
        id="editPersonalInfoContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Edit Personal Information</h2>
            <button class="text-gray-400 hover:text-gray-600 transition-colors" id="closeeditPersonalInfo">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <form action="#" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div class="md:col-span-2">
                    <label for="edit_full_name" class="block text-sm font-medium text-gray-700 mb-2">Full
                        Name</label>
                    <input type="text" id="edit_full_name" name="full_name"
                        value="{{ Auth::guard('patient')->user()->full_name }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                </div>

                <!-- Email -->
                <div>
                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email
                        Address</label>
                    <input type="email" id="edit_email" name="email" value="{{ Auth::guard('patient')->user()->email }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="edit_phone_number" class="block text-sm font-medium text-gray-700 mb-2">Phone
                        Number</label>
                    <input type="text" id="edit_phone_number" name="phone_number"
                        value="{{ Auth::guard('patient')->user()->phone_number }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label for="edit_date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of
                        Birth</label>
                    <input type="date" id="edit_date_of_birth" name="date_of_birth"
                        value="{{ Auth::guard('patient')->user()->date_of_birth->format('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                </div>

                <!-- Gender -->
                <div>
                    <label for="edit_gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select id="edit_gender" name="gender"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                        <option value="male" {{ Auth::guard('patient')->user()->gender === 'male' ? 'selected' : '' }}>
                            Male</option>
                        <option value="female" {{ Auth::guard('patient')->user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Blood Type -->
                <div>
                    <label for="edit_blood_type" class="block text-sm font-medium text-gray-700 mb-2">Blood
                        Type</label>
                    <select id="edit_blood_type" name="blood_type"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                        <option value="A+" {{ Auth::guard('patient')->user()->blood_type === 'A+' ? 'selected' : '' }}>A+
                        </option>
                        <option value="A-" {{ Auth::guard('patient')->user()->blood_type === 'A-' ? 'selected' : '' }}>A-
                        </option>
                        <option value="B+" {{ Auth::guard('patient')->user()->blood_type === 'B+' ? 'selected' : '' }}>B+
                        </option>
                        <option value="B-" {{ Auth::guard('patient')->user()->blood_type === 'B-' ? 'selected' : '' }}>B-
                        </option>
                        <option value="AB+" {{ Auth::guard('patient')->user()->blood_type === 'AB+' ? 'selected' : '' }}>
                            AB+</option>
                        <option value="AB-" {{ Auth::guard('patient')->user()->blood_type === 'AB-' ? 'selected' : '' }}>
                            AB-</option>
                        <option value="O+" {{ Auth::guard('patient')->user()->blood_type === 'O+' ? 'selected' : '' }}>O+
                        </option>
                        <option value="O-" {{ Auth::guard('patient')->user()->blood_type === 'O-' ? 'selected' : '' }}>O-
                        </option>
                    </select>
                </div>

                <!-- Race -->
                <div>
                    <label for="edit_race" class="block text-sm font-medium text-gray-700 mb-2">Race</label>
                    <select id="edit_race" name="race"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        required>
                        <option value="Malay" {{ Auth::guard('patient')->user()->race === 'Malay' ? 'selected' : '' }}>
                            Malay</option>
                        <option value="Chinese" {{ Auth::guard('patient')->user()->race === 'Chinese' ? 'selected' : '' }}>Chinese</option>
                        <option value="Indian" {{ Auth::guard('patient')->user()->race === 'Indian' ? 'selected' : '' }}>
                            Indian</option>
                        <option value="Others" {{ Auth::guard('patient')->user()->race === 'Others' ? 'selected' : '' }}>
                            Others</option>
                    </select>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <button type="button"
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    onclick="closeModal('editPersonalInfo', 'editPersonalInfoContent')">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>