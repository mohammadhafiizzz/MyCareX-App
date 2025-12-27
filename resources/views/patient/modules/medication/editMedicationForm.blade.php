<div 
    id="edit-medication-modal"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-950/50 items-center justify-center p-4"
    style="display: none;"
    aria-labelledby="edit-modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="edit-modal-panel"
        class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-md shadow-xl max-h-[90vh] overflow-y-auto"
    >
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="edit-modal-title">
                Edit Medication
            </h3>
            <button 
                type="button" 
                id="edit-modal-close-button"
                class="text-gray-400 hover:text-gray-600 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
            >
                <i class="fas fa-times" aria-hidden="true"></i>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        {{-- This form is for UPDATING the medication --}}
        <form id="edit-medication-form" class="mt-6 space-y-6" method="POST" action="#">
            @csrf 
            @method('PUT')

            <div id="edit-form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
            </div>

            {{-- All form fields now have 'edit_' prefixed IDs --}}
            <div>
                <label for="edit_medication_name" class="block text-sm font-medium text-gray-700">Medication Name <span class="text-red-500">*</span></label>
                
                <div id="edit_medication_select_wrapper" class="relative mt-1">
                    <select 
                        id="edit_medication_select"
                        class="block w-full p-3 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white"
                    >
                        <option value="" disabled>Select a medication...</option>
                        
                        <optgroup label="Common Medications">
                            <option value="Metformin">Metformin</option>
                            <option value="Atorvastatin">Atorvastatin</option>
                            <option value="Levothyroxine">Levothyroxine</option>
                            <option value="Lisinopril">Lisinopril</option>
                            <option value="Amlodipine">Amlodipine</option>
                        </option>

                        <optgroup label="Pain Relief">
                            <option value="Paracetamol">Paracetamol</option>
                            <option value="Ibuprofen">Ibuprofen</option>
                            <option value="Aspirin">Aspirin</option>
                        </optgroup>

                        <optgroup label="Other">
                            <option value="other">Other (Type manually...)</option>
                        </optgroup>
                    </select>
                </div>

                <div id="edit_medication_manual_wrapper" class="hidden mt-1 relative">
                    <input 
                        type="text" 
                        name="medication_name" 
                        id="edit_medication_name" 
                        required
                        class="block w-full p-3 pr-10 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Type medication name here..."
                    >
                    <button 
                        type="button" 
                        id="edit_switch_to_select"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-600 cursor-pointer"
                        title="Back to list"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="edit_dosage" class="block text-sm font-medium text-gray-700">Dosage (mg) <span class="text-red-500">*</span></label>
                    <input 
                        type="number"
                        name="dosage" 
                        id="edit_dosage" 
                        required
                        min="1"
                        max="999999"
                        class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value=""
                    >
                    <p class="mt-1 text-xs text-gray-500">Enter numeric value only (unit: mg)</p>
                </div>

                <div>
                    <label for="edit_status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                    <select 
                        id="edit_status" 
                        name="status" 
                        required
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="">Select status</option>
                        <option value="Active">Active</option>
                        <option value="On Hold">On Hold</option>
                        <option value="Completed">Completed</option>
                        <option value="Discontinued">Discontinued</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Frequency <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-4 gap-3">
                    <div>
                        <input 
                            type="number" 
                            id="edit_frequency_number" 
                            name="frequency_number" 
                            min="1" 
                            max="99" 
                            required
                            class="block w-full p-3 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                            placeholder="Times"
                            value=""
                        >
                    </div>
                    <div class="col-span-3">
                        <select 
                            id="edit_frequency_period" 
                            name="frequency_period" 
                            required
                            class="block w-full p-3 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        >
                            <option value="">Select period</option>
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="edit_frequency" name="frequency" value="">
                <p class="mt-1 text-xs text-gray-500">E.g., "2" times "Daily" = 2 times daily</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="edit_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="edit_start_date" 
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value=""
                    >
                </div>

                <div>
                    <label for="edit_end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        id="edit_end_date" 
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value=""
                    >
                </div>
            </div>

            <div>
                <label for="edit_reason_for_med" class="block text-sm font-medium text-gray-700">Reason for Medication</label>
                <textarea 
                    id="edit_reason_for_med" 
                    name="reason_for_med" 
                    rows="2" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="E.g., Type 2 Diabetes Management"
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Why is this medication prescribed?</p>
            </div>

            <div>
                <label for="edit_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                <textarea 
                    id="edit_notes" 
                    name="notes" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    placeholder="Add any additional information or instructions..."
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Optional: Add any special instructions or reminders.</p>
            </div>
        </form>

        <div class="pt-4 mt-2 flex gap-2 flex-col-reverse sm:flex-row sm:justify-end sm:space-x-8 lg:space-x-0">
            <button 
                type="button" 
                id="edit-modal-cancel-button"
                class="justify-center inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
            >
                Cancel
            </button>
            <button 
                type="submit" 
                id="update-medication-button"
                form="edit-medication-form"
                class="justify-center inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0"
            >
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span id="save-button-text">Save Changes</span>
            </button>
        </div>
    </div>
</div>
