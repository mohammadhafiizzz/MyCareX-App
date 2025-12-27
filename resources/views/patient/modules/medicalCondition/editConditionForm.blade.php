<div 
    id="edit-condition-modal"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-950/50 items-center justify-center p-4"
    style="display: none;"
    aria-labelledby="edit-modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="edit-modal-panel"
        class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-md shadow-xl"
    >
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="edit-modal-title">
                Edit Medical Condition
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
        <form id="edit-condition-form" class="mt-6 space-y-6" method="POST" action="#">
            @csrf 
            @method('PUT') {{-- Use PUT or PATCH for updates --}}

            <div id="edit-form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
                </div>

            {{-- All form fields now have 'edit_' prefixed IDs --}}
            <div>
                <label for="edit_condition_name" class="block text-sm font-medium text-gray-700">Condition Name <span class="text-red-500">*</span></label>
                
                <div id="edit_condition_select_wrapper" class="relative mt-1">
                    <select 
                        id="edit_condition_select"
                        class="block w-full p-3 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm bg-white"
                    >
                        <option value="" disabled>Select a condition...</option>
                        
                        <optgroup label="Common Chronic Conditions">
                            <option value="Hypertension">Hypertension (High Blood Pressure)</option>
                            <option value="Type 2 Diabetes Mellitus">Type 2 Diabetes</option>
                            <option value="Hyperlipidemia">Hyperlipidemia (High Cholesterol)</option>
                            <option value="Asthma">Asthma</option>
                            <option value="Osteoarthritis">Osteoarthritis</option>
                            <option value="Gastroesophageal Reflux Disease (GERD)">GERD (Acid Reflux)</option>
                        </optgroup>

                        <optgroup label="Acute & Infectious">
                            <option value="Upper Respiratory Infection">Upper Respiratory Infection</option>
                            <option value="Influenza">Influenza</option>
                            <option value="COVID-19">COVID-19</option>
                            <option value="Urinary Tract Infection">Urinary Tract Infection</option>
                        </optgroup>

                        <optgroup label="Other">
                            <option value="Allergic Rhinitis">Allergic Rhinitis</option>
                            <option value="Migraine">Migraine</option>
                            <option value="manual_entry" class="font-bold text-blue-600">Other...</option>
                        </optgroup>
                    </select>
                </div>

                <div id="edit_condition_manual_wrapper" class="hidden mt-1 relative">
                    <input 
                        type="text" 
                        name="condition_name" 
                        id="edit_condition_name" 
                        required
                        class="block w-full p-3 pr-10 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Type condition name here..."
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
                <label for="edit_description" class="block text-sm font-medium text-gray-700">Description / Notes</label>
                <textarea 
                    id="edit_description" 
                    name="description" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                ></textarea> {{-- Inner text must be populated by JavaScript --}}
                <p class="mt-1 text-xs text-gray-500">Provide any notes on symptoms or management.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="edit_diagnosis_date" class="block text-sm font-medium text-gray-700">Diagnosis Date (Approximate)</label>
                    <input 
                        type="date" 
                        name="diagnosis_date" 
                        id="edit_diagnosis_date" 
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value="" {{-- Value must be populated by JavaScript --}}
                    >
                </div>

                <div>
                    <label for="edit_severity" class="block text-sm font-medium text-gray-700">Severity</label>
                    <select 
                        id="edit_severity" 
                        name="severity" 
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        {{-- JavaScript will need to set the 'selected' attribute on the correct option --}}
                        <option value="">Select severity</option>
                        <option value="Mild">Mild</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Severe">Severe</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="edit_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select 
                    id="edit_status" 
                    name="status" 
                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    {{-- JavaScript will need to set the 'selected' attribute on the correct option --}}
                    <option value="" selected>Select status</option>
                    <option value="Active">Active</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Chronic">Chronic</option>
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
                id="update-condition-button"
                form="edit-condition-form"
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