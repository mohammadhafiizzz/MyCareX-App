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
                <input 
                    type="text" 
                    name="condition_name" 
                    id="edit_condition_name" 
                    required
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value="" {{-- Value must be populated by JavaScript --}}
                >
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
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value="" {{-- Value must be populated by JavaScript --}}
                    >
                </div>

                <div>
                    <label for="edit_severity" class="block text-sm font-medium text-gray-700">Severity</label>
                    <select 
                        id="edit_severity" 
                        name="severity" 
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
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
                    class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    {{-- JavaScript will need to set the 'selected' attribute on the correct option --}}
                    <option value="" selected>Select status</option>
                    <option value="Active">Active</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Chronic">Chronic</option>
                    {{-- Note: Your 'add' form had 'Inactive', but your migration has 'Chronic'. I used 'Chronic'. --}}
                </select>
            </div>
        </form>

        <div class="pt-6 mt-6 border-t border-gray-200 flex justify-end gap-3">
            <button 
                type="button" 
                id="edit-modal-cancel-button"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
            >
                Cancel
            </button>

            <button 
                type="submit" 
                form="edit-condition-form"
                id="update-condition-button"
                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
            >
                <span id="update-button-text">Save Changes</span>
            </button>
        </div>
    </div>
</div>