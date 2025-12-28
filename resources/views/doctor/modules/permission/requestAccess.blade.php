<!-- Request Access Modal -->
<div id="requestAccess" class="hidden fixed inset-0 bg-gray-600/50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 w-full max-w-md shadow-lg rounded-lg bg-white">
        <div>
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-user-lock text-blue-600 mr-2"></i>
                    Request Access
                </h3>
                <button type="button" id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 mb-4">
                    You are requesting access to <span id="patientNameDisplay" class="font-semibold text-gray-900"></span>'s medical records.
                </p>

                <!-- Permission Scope Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Select Records to Access <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="medications" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Medications</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="medical_conditions" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Conditions</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="allergies" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Allergies</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="lab_tests" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Lab Results</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="immunisations" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Immunisations</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="permission_scope[]" value="surgeries" class="scope-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Surgeries</span>
                        </label>
                    </div>
                    <p id="scopeError" class="hidden mt-1 text-xs text-red-500">Please select at least one record type.</p>
                </div>
                
                <!-- Notes Input -->
                <div class="mb-4">
                    <label for="accessNotes" class="block text-sm font-medium text-gray-700 mb-2">
                        Notes (Optional)
                    </label>
                    <textarea 
                        id="accessNotes" 
                        rows="3" 
                        class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                        placeholder="Add any notes or reason for this request..."></textarea>
                    <p class="mt-1 text-xs text-gray-500">Maximum 500 characters</p>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <p class="text-xs text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        The patient will receive a notification and can approve or deny your request.
                    </p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 justify-end">
                <button 
                    type="button" 
                    id="cancelRequestBtn"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                    Cancel
                </button>
                <button 
                    type="button" 
                    id="confirmRequestBtn"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200">
                    Send Request
                </button>
            </div>
        </div>
    </div>
</div>
