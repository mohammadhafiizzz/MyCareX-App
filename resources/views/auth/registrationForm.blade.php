<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
        <h2 class="text-xl font-semibold text-blue-900 flex items-center">
            <i class="fas fa-user-circle text-blue-600 mr-3"></i>
            Personal Information
            <span class="ml-2 text-sm font-normal text-red-500">* Required</span>
        </h2>
    </div>

    <div class="p-6 space-y-6">
        <!-- Full Name & IC Number -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fullName" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="fullName" name="full_name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Enter your full name as per IC">
            </div>
            <div>
                <label for="icNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    IC Number <span class="text-red-500">*</span>
                </label>
                <input type="text" id="icNumber" name="ic_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="123456-78-9012" maxlength="14">
            </div>
        </div>

        <!-- Phone & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="phoneNumber" name="phone_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="01X-XXX XXXX">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="your.email@example.com">
            </div>
        </div>

        <!-- Date of Birth & Gender -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="dateOfBirth" class="block text-sm font-medium text-gray-700 mb-2">
                    Date of Birth <span class="text-red-500">*</span>
                </label>
                <input type="date" id="dateOfBirth" name="date_of_birth" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                    Gender <span class="text-red-500">*</span>
                </label>
                <select id="gender" name="gender" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
        </div>

        <!-- Blood Type & Race -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="bloodType" class="block text-sm font-medium text-gray-700 mb-2">
                    Blood Type <span class="text-red-500">*</span>
                </label>
                <select name="blood_type" id="bloodType" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select Blood Type</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="unknown">Do not know</option>
                </select>
            </div>
            <div>
                <!-- TODO: check for input validation when user select 'Other' -->
                <label for="race" class="block text-sm font-medium text-gray-700 mb-2">
                    Race <span class="text-red-500">*</span>
                </label>
                <select id="race" name="race" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select Race</option>
                    <option value="Malay">Malay</option>
                    <option value="Chinese">Chinese</option>
                    <option value="Indian">Indian</option>
                    <option value="Other">Other</option>
                </select>
                <input type="text"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hidden"
                    id="otherRace" name="other_race" placeholder="Please specify your race">
            </div>
        </div>

        <!-- Address Section -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-map-marker-alt text-green-700 mr-2"></i>
                Address
            </h3>
        </div>

        <!-- Home Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                Home Address <span class="text-red-500">*</span>
            </label>
            <textarea id="address" name="address" rows="3" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                placeholder="Enter your complete home address"></textarea>
        </div>

        <!-- Postal Code & State -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                    Postal Code <span class="text-red-500">*</span>
                </label>
                <input type="number" id="postal_code" name="postal_code" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="e.g. for Sabah, 88000">
            </div>
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                    State <span class="text-red-500">*</span>
                </label>
                <select id="state" name="state" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select State</option>
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Malacca">Malacca</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Penang">Penang</option>
                    <option value="Perak">Perak</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Kuala Lumpur">W.P. Kuala Lumpur</option>
                    <option value="Labuan">W.P. Labuan</option>
                    <option value="Putrajaya">W.P. Putrajaya</option>
                </select>
            </div>
        </div>

        <!-- Emergency Contact Section -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-phone-alt text-red-600 mr-2"></i>
                Emergency Contact
            </h3>
        </div>

        <!-- Emergency Name & IC Number -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="emergencyContactName" class="block text-sm font-medium text-gray-700 mb-2">
                    Contact Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="emergencyContactName" name="emergency_contact_name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Full name">
            </div>
            <div>
                <label for="emergencyContactIcNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    IC Number <span class="text-red-500">*</span>
                </label>
                <input type="text" id="emergencyContactIcNumber" name="emergency_contact_ic_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="123456-78-9012" maxlength="14">
            </div>
        </div>

        <!-- Emergency Contact & Relationship -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="emergencyContactNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Contact Phone <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="emergencyContactNumber" name="emergency_contact_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="01X-XXX XXXX">
            </div>
            <div>
                <!-- TODO: check for input validation when user select 'Other' -->
                <label for="emergencyContactRelationship" class="block text-sm font-medium text-gray-700 mb-2">
                    Relationship <span class="text-red-500">*</span>
                </label>
                <select id="emergencyContactRelationship" name="emergency_contact_relationship" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select Relationship</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Parent">Parent</option>
                    <option value="Child">Child</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Friend">Friend</option>
                    <option value="Other">Other</option>
                </select>

                <!-- Other Relationship (Appear when "Other" is selected) -->
                <input type="text" id="otherRelationship" name="other_relationship"
                    class="mt-2 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors hidden"
                    placeholder="Please specify relationship">
            </div>
        </div>

        <!-- Password -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-lock text-blue-700 mr-2"></i>
                Account Security
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pr-12"
                            placeholder="Create a strong password">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                            id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters and numbers
                    </p>
                </div>
                <div>
                    <label for="passwordConfirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" id="passwordConfirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        placeholder="Confirm your password">
                </div>
            </div>
        </div>

        <!-- Terms and Conditions -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-start space-x-3">
                <input type="checkbox" id="terms_agreement" name="terms_agreement" required
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                <div class="text-sm text-gray-600">
                    <label for="terms_agreement" class="cursor-pointer">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 underline">Terms of
                            Service</a>
                        and <a href="#" class="text-blue-600 hover:text-blue-700 underline">Privacy
                            Policy</a>.
                        I understand that my health information will be stored securely and used only
                        for healthcare purposes.
                    </label>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-green-50 p-4 rounded-lg">
            <h3 class="font-medium text-green-900 mb-2">What happens next?</h3>
            <ul class="text-sm text-green-800 space-y-1">
                <li>• Your account will be created instantly</li>
                <li>• You'll receive a verification email</li>
                <li>• You can start managing your health records immediately</li>
                <li>• You can add or update medical information anytime</li>
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="flex mt-8">
            <button type="submit" id="submitBtn"
                class="px-8 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Create My Account
            </button>
        </div>
    </div>
</div>