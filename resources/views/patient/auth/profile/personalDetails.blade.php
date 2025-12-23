<!-- Edit Personal Information Modal -->
<div id="editPersonalInfo" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('editPersonalInfo', 'editPersonalInfoContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="editPersonalInfoContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Personal Information</h3>
                <button type="button" onclick="closeModal('editPersonalInfo', 'editPersonalInfoContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.personal') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Full Name -->
                        <div class="md:col-span-2">
                            <label for="edit_full_name" class="block text-xs font-bold text-gray-400 uppercase mb-1">Full Name</label>
                            <input type="text" id="edit_full_name" name="full_name"
                                value="{{ Auth::guard('patient')->user()->full_name }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="edit_email" class="block text-xs font-bold text-gray-400 uppercase mb-1">Email Address</label>
                            <input type="email" id="edit_email" name="email"
                                value="{{ Auth::guard('patient')->user()->email }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="edit_phone_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">Phone Number</label>
                            <input type="text" id="edit_phone_number" name="phone_number"
                                value="{{ Auth::guard('patient')->user()->phone_number }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="edit_date_of_birth" class="block text-xs font-bold text-gray-400 uppercase mb-1">Date of Birth</label>
                            <input type="date" id="edit_date_of_birth" name="date_of_birth"
                                value="{{ Auth::guard('patient')->user()->date_of_birth ? Auth::guard('patient')->user()->date_of_birth->format('Y-m-d') : '' }}"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="edit_gender" class="block text-xs font-bold text-gray-400 uppercase mb-1">Gender</label>
                            <select id="edit_gender" name="gender"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                                <option value="" {{ !Auth::guard('patient')->user()->gender ? 'selected' : '' }}>Select Gender</option>
                                <option value="Male" {{ Auth::guard('patient')->user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ Auth::guard('patient')->user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <!-- Blood Type -->
                        <div>
                            <label for="edit_blood_type" class="block text-xs font-bold text-gray-400 uppercase mb-1">Blood Type</label>
                            <select id="edit_blood_type" name="blood_type"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                                <option value="" {{ !Auth::guard('patient')->user()->blood_type ? 'selected' : '' }}>Select Blood Type</option>
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
                            <label for="edit_race" class="block text-xs font-bold text-gray-400 uppercase mb-1">Race</label>
                            <select id="edit_race" name="race"
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none"
                                required>
                                @php
                                    $userRace = Auth::guard('patient')->user()->race;
                                    $predefinedRaces = ['Malay', 'Chinese', 'Indian'];
                                    $isOtherRace = $userRace && !in_array($userRace, $predefinedRaces);
                                @endphp
                                <option value="" {{ !$userRace ? 'selected' : '' }}>Select Race</option>
                                <option value="Malay" {{ $userRace === 'Malay' ? 'selected' : '' }}>Malay</option>
                                <option value="Chinese" {{ $userRace === 'Chinese' ? 'selected' : '' }}>Chinese</option>
                                <option value="Indian" {{ $userRace === 'Indian' ? 'selected' : '' }}>Indian</option>
                                <option value="Other" {{ $isOtherRace ? 'selected' : '' }}>Other</option>
                            </select>
                            <input type="text" id="edit_other_race" name="other_race"
                                class="mt-2 w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none {{ $isOtherRace ? '' : 'hidden' }}"
                                placeholder="Please specify your race" value="{{ $isOtherRace ? $userRace : '' }}">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('editPersonalInfo', 'editPersonalInfoContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
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