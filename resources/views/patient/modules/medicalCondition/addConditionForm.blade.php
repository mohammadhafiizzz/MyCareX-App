<div 
    id="add-condition-modal"
    class="fixed inset-0 z-50 overflow-y-auto bg-gray-950/50 hidden items-center justify-center p-4"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="modal-panel"
        class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-md shadow-xl"
    >
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">
                Add New Condition
            </h3>
            <button 
                type="button" 
                id="modal-close-button"
                class="text-gray-400 hover:text-gray-600 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
            >
                <i class="fas fa-times" aria-hidden="true"></i>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        <form id="add-condition-form" class="mt-6 space-y-6" method="POST" action="{{ route('patient.condition.add') }}">
            @csrf 

            <div id="form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
                </div>

            <div>
                <label for="condition_name" class="block text-sm font-medium text-gray-700">Condition Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="condition_name" 
                    id="condition_name" 
                    required
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Asthma"
                >
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description / Notes</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Self-diagnosed, symptoms include..."
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Provide any notes on symptoms or management.</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="diagnosis_date" class="block text-sm font-medium text-gray-700">Diagnosis Date (Approximate)</label>
                    <input 
                        type="date" 
                        name="diagnosis_date" 
                        id="diagnosis_date" 
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                </div>

                <div>
                    <label for="severity" class="block text-sm font-medium text-gray-700">Severity</label>
                    <select 
                        id="severity" 
                        name="severity" 
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="">Select severity</option>
                        <option value="Mild">Mild</option>
                        <option value="Moderate">Moderate</option>
                        <option value="Severe">Severe</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select 
                    id="status" 
                    name="status" 
                    class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="" selected>Select status</option>
                    <option value="Active">Active</option>
                    <option value="Resolved">Resolved</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>

            <div class="pt-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                <button 
                    type="button" 
                    id="modal-cancel-button"
                    class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    id="save-condition-button"
                    class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                >
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="save-button-text">Save</span>
                </button>
            </div>
        </form>
    </div>
</div>