<!-- Organisation Information -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
        <h2 class="text-xl font-semibold text-blue-900 flex items-center">
            <i class="fas fa-hospital text-blue-600 mr-3"></i>
            Organisation Information
            <span class="ml-2 text-sm font-normal text-red-500">* Required</span>
        </h2>
    </div>

    <div class="p-6 space-y-6">
        <!-- Organisation Name & Type -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="organisationName" class="block text-sm font-medium text-gray-700 mb-2">
                    Organisation Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="organisationName" name="organisation_name" required 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Enter your organisation name" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label for="organisationType" class="block text-sm font-medium text-gray-700 mb-2">
                    Organisation Type <span class="text-red-500">*</span>
                </label>
                <select id="organisationType" name="organisation_type" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Select Type</option>
                    <option value="Hospital">Hospital</option>
                    <option value="Clinic">Clinic</option>
                    <option value="Pharmacy">Pharmacy</option>
                    <option value="Laboratory">Laboratory</option>
                    <option value="Diagnostic Center">Diagnostic Center</option>
                    <option value="Nursing Home">Nursing Home</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        <!-- Registration & License Numbers -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="registrationNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Business Registration Number <span class="text-red-500">*</span>
                </label>
                <input type="text" id="registrationNumber" name="registration_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="ROC/ROB Number">
            </div>
            <div>
                <label for="licenseNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    MOH License Number <span class="text-red-500">*</span>
                </label>
                <input type="text" id="licenseNumber" name="license_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Ministry of Health License Number">
            </div>
        </div>

        <!-- License Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="licenseExpiryDate" class="block text-sm font-medium text-gray-700 mb-2">
                    License Expiry Date <span class="text-red-500">*</span>
                </label>
                <input type="date" id="licenseExpiryDate" name="license_expiry_date" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
            <div>
                <label for="establishmentDate" class="block text-sm font-medium text-gray-700 mb-2">
                    Establishment Date <span class="text-red-500">*</span>
                </label>
                <input type="date" id="establishmentDate" name="establishment_date" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>
        </div>
    </div>
</div>

<!-- Contact Information -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-green-50 px-6 py-4 border-b border-green-100">
        <h2 class="text-xl font-semibold text-green-900 flex items-center">
            <i class="fas fa-address-book text-green-600 mr-3"></i>
            Contact Information
        </h2>
    </div>

    <div class="p-6 space-y-6">
        <!-- Email & Phone -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Organisation Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="organisation@example.com">
            </div>
            <div>
                <label for="phoneNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Main Phone Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="phoneNumber" name="phone_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="03-XXXX XXXX">
            </div>
        </div>

        <!-- Emergency Contact & Website -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="emergencyContactNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Emergency Contact Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="emergencyContactNumber" name="emergency_contact" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="24/7 Emergency Line">
            </div>
            <div>
                <label for="websiteUrl" class="block text-sm font-medium text-gray-700 mb-2">
                    Website URL
                </label>
                <input type="url" id="websiteUrl" name="website_url"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="https://yourorganisation.com">
            </div>
        </div>

        <!-- Contact Person Section -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-tie text-blue-600 mr-2"></i>
                Contact Person (Registrant)
            </h3>
        </div>

        <!-- Contact Person Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="contactPersonName" class="block text-sm font-medium text-gray-700 mb-2">
                    Full Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="contactPersonName" name="contact_person_name" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="Contact person full name" oninput="this.value = this.value.toUpperCase()">
            </div>
            <div>
                <label for="contactPersonDesignation" class="block text-sm font-medium text-gray-700 mb-2">
                    Designation <span class="text-red-500">*</span>
                </label>
                <input type="text" id="contactPersonDesignation" name="contact_person_designation" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="e.g., Chief Medical Officer, Administrator">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="contactPersonIcNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    IC Number <span class="text-red-500">*</span>
                </label>
                <input type="text" id="contactPersonIcNumber" name="contact_person_ic_number" required maxlength="14"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="123456-78-9012">
            </div>
            <div>
                <label for="contactPersonPhone" class="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number <span class="text-red-500">*</span>
                </label>
                <input type="tel" id="contactPersonPhone" name="contact_person_phone_number" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="01X-XXX XXXX">
            </div>
        </div>
    </div>
</div>

<!-- Address Information -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
        <h2 class="text-xl font-semibold text-purple-900 flex items-center">
            <i class="fas fa-map-marker-alt text-purple-600 mr-3"></i>
            Address Information
        </h2>
    </div>

    <div class="p-6 space-y-6">
        <!-- Full Address -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                Complete Address <span class="text-red-500">*</span>
            </label>
            <textarea id="address" name="address" rows="3" required
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                placeholder="Enter complete organisation address"></textarea>
        </div>

        <!-- City, Postal Code & State -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                    City <span class="text-red-500">*</span>
                </label>
                <input type="text" id="city" name="city" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="City name">
            </div>
            <div>
                <label for="postalCode" class="block text-sm font-medium text-gray-700 mb-2">
                    Postal Code <span class="text-red-500">*</span>
                </label>
                <input type="text" id="postalCode" name="postal_code" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                    placeholder="e.g., 50450">
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
    </div>
</div>

<!-- Document Upload -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-red-50 px-6 py-4 border-b border-red-100">
        <h2 class="text-xl font-semibold text-red-900 flex items-center">
            <i class="fas fa-file-upload text-red-600 mr-3"></i>
            Required Documents
        </h2>
    </div>

    <div class="p-6 space-y-6">
        <!-- Business License -->
        <div>
            <label for="businessLicense" class="block text-sm font-medium text-gray-700 mb-2">
                Business Registration Certificate <span class="text-red-500">*</span>
            </label>
            <input type="file" id="businessLicense" name="business_license_document" required
                accept=".pdf,.jpg,.jpeg,.png"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            <p class="text-xs text-gray-500 mt-1">Upload ROC/ROB certificate (PDF, JPG, PNG max 5MB)</p>
        </div>

        <!-- Medical License -->
        <div>
            <label for="medicalLicense" class="block text-sm font-medium text-gray-700 mb-2">
                MOH Medical License <span class="text-red-500">*</span>
            </label>
            <input type="file" id="medicalLicense" name="medical_license_document" required
                accept=".pdf,.jpg,.jpeg,.png"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            <p class="text-xs text-gray-500 mt-1">Upload Ministry of Health license (PDF, JPG, PNG max 5MB)</p>
        </div>
    </div>
</div>

<!-- Account Security -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
        <h2 class="text-xl font-semibold text-indigo-900 flex items-center">
            <i class="fas fa-lock text-indigo-600 mr-3"></i>
            Account Security
        </h2>
    </div>

    <div class="p-6 space-y-6">
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
                <p class="text-xs text-gray-500 mt-1">Minimum 8 characters with letters and numbers</p>
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
</div>

<!-- Terms and Submit -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 space-y-6">
        <!-- Terms Agreement -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <div class="flex items-start space-x-3">
                <input type="checkbox" id="termsAgreement" name="terms_agreement" required
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-1">
                <div class="text-sm text-gray-600">
                    <label for="termsAgreement" class="cursor-pointer">
                        I agree to the <a href="#" class="text-blue-600 hover:text-blue-700 underline">Terms of Service</a>
                        and <a href="#" class="text-blue-600 hover:text-blue-700 underline">Privacy Policy</a>.
                        I confirm that all information provided is accurate and I have authority to register this organisation.
                    </label>
                </div>
            </div>
        </div>

        <!-- Verification Notice -->
        <div class="bg-yellow-50 p-4 rounded-lg">
            <h3 class="font-medium text-yellow-900 mb-2">Verification Process</h3>
            <ul class="text-sm text-yellow-800 space-y-1">
                <li>• Your registration will be reviewed by our admin team</li>
                <li>• Verification typically takes 3-5 business days</li>
                <li>• You'll receive email updates on your application status</li>
                <li>• Ensure all documents are clear and valid</li>
            </ul>
        </div>

        <!-- Submit Button -->
        <div class="flex">
            <button type="submit" id="submitBtn"
                class="px-8 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-colors duration-200 flex items-center">
                <i class="fas fa-hospital mr-2"></i>
                Register Organisation
            </button>
        </div>
    </div>
</div>