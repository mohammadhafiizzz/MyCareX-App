<div 
    id="edit-allergy-modal"
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
                Edit Allergy
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
        
        {{-- This form is for UPDATING the record --}}
        <form id="edit-allergy-form" class="mt-6 space-y-6" method="POST" action="#">
            @csrf 
            @method('PUT') {{-- Use PUT or PATCH for updates --}}

            <div id="edit-form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
                </div>

            {{-- All form fields now have 'edit_' prefixed IDs --}}
            <div>
                <label for="edit_allergen" class="block text-sm font-medium text-gray-700">Allergen <span class="text-red-500">*</span></label>
                
                <div id="edit_allergen_select_wrapper" class="relative mt-1">
                    <select 
                        id="edit_allergen_select"
                        class="block w-full p-3 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white"
                    >
                        <option value="" disabled>Select an allergen...</option>
                        
                        <optgroup label="Common Food Allergies">
                            <option value="Peanuts">Peanuts</option>
                            <option value="Tree Nuts">Tree Nuts</option>
                            <option value="Milk">Milk</option>
                            <option value="Eggs">Eggs</option>
                            <option value="Wheat">Wheat</option>
                            <option value="Soy">Soy</option>
                            <option value="Fish">Fish</option>
                            <option value="Shellfish">Shellfish</option>
                        </optgroup>

                        <optgroup label="Medication Allergies">
                            <option value="Penicillin">Penicillin</option>
                            <option value="Sulfa Drugs">Sulfa Drugs</option>
                            <option value="Aspirin">Aspirin</option>
                            <option value="NSAIDs">NSAIDs</option>
                        </optgroup>

                        <optgroup label="Environmental & Other">
                            <option value="Pollen">Pollen</option>
                            <option value="Dust Mites">Dust Mites</option>
                            <option value="Mold">Mold</option>
                            <option value="Pet Dander">Pet Dander</option>
                            <option value="Latex">Latex</option>
                            <option value="Insect Stings">Insect Stings</option>
                        </optgroup>

                        <optgroup label="Other">
                            <option value="manual_entry">Other...</option>
                        </optgroup>
                    </select>
                </div>

                <div id="edit_allergen_manual_wrapper" class="hidden mt-1 relative">
                    <input 
                        type="text" 
                        name="allergen" 
                        id="edit_allergen" 
                        required
                        class="block w-full p-3 pr-10 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Type allergen name here..."
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

            <div>
                <label for="edit_allergy_type" class="block text-sm font-medium text-gray-700">Allergy Type <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="allergy_type" 
                    id="edit_allergy_type" 
                    required
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value="" {{-- Value must be populated by JavaScript --}}
                >
            </div>

            <div>
                <label for="edit_reaction_desc" class="block text-sm font-medium text-gray-700">Reaction Description</label>
                <textarea 
                    id="edit_reaction_desc" 
                    name="reaction_desc" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                ></textarea> {{-- Inner text must be populated by JavaScript --}}
                <p class="mt-1 text-xs text-gray-500">Describe the allergic reaction symptoms.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="edit_first_observed_date" class="block text-sm font-medium text-gray-700">First Observed Date <span class="text-red-500">*</span></label>
                    <input 
                        type="date" 
                        name="first_observed_date" 
                        id="edit_first_observed_date" 
                        required
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value="" {{-- Value must be populated by JavaScript --}}
                    >
                </div>

                <div>
                    <label for="edit_severity" class="block text-sm font-medium text-gray-700">Severity <span class="text-red-500">*</span></label>
                    <select 
                        id="edit_severity" 
                        name="severity"
                        required
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        {{-- JavaScript will need to set the 'selected' attribute on the correct option --}}
                        <option value="">Select severity</option>
                        <option value="Mild">Mild</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Severe">Severe</option>
                        <option value="Life-threatening">Life-threatening</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="edit_status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select 
                    id="edit_status" 
                    name="status"
                    required
                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    {{-- JavaScript will need to set the 'selected' attribute on the correct option --}}
                    <option value="" selected>Select status</option>
                    <option value="Active">Active</option>
                    <option value="Suspected">Suspected</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Inactive">Inactive</option>
                </select>
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
                id="update-allergy-button"
                form="edit-allergy-form"
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
