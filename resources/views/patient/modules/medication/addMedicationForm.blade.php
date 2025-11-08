<div 
    id="add-medication-modal"
    class="fixed inset-0 z-50 bg-gray-950/50 hidden items-center justify-center p-4 overflow-y-auto"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        id="modal-panel"
        class="relative w-full max-w-lg p-6 my-8 text-left align-middle bg-white rounded-md shadow-xl max-h-[90vh] overflow-y-auto"
    >
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold leading-6 text-gray-900" id="modal-title">
                Add New Medication
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
        
        <form id="add-medication-form" class="mt-6 space-y-6" method="POST" action="{{ route('patient.medication.add') }}" enctype="multipart/form-data">
            @csrf 

            <div id="form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
            </div>

            <div>
                <label for="medication_name" class="block text-sm font-medium text-gray-700">Medication Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="medication_name" 
                    id="medication_name" 
                    required
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Metformin"
                >
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="dosage" class="block text-sm font-medium text-gray-700">Dosage <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="dosage" 
                        id="dosage" 
                        required
                        class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="e.g., 500mg"
                    >
                </div>

                <div>
                    <label for="frequency" class="block text-sm font-medium text-gray-700">Frequency <span class="text-red-500">*</span></label>
                    <select 
                        id="frequency" 
                        name="frequency"
                        required
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="">Select frequency</option>
                        <option value="Daily">Daily</option>
                        <option value="Twice daily">Twice daily</option>
                        <option value="Three times daily">Three times daily</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="As needed">As needed</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date <span class="text-red-500">*</span></label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="start_date" 
                        required
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date (Optional)</label>
                    <input 
                        type="date" 
                        name="end_date" 
                        id="end_date" 
                        class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                    <p class="mt-1 text-xs text-gray-500">Leave blank if ongoing</p>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select 
                    id="status" 
                    name="status" 
                    required
                    class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
                    <option value="">Select status</option>
                    <option value="Active">Active</option>
                    <option value="On Hold">On Hold</option>
                    <option value="Completed">Completed</option>
                    <option value="Discontinued">Discontinued</option>
                </select>
            </div>

            <div>
                <label for="reason_for_med" class="block text-sm font-medium text-gray-700">Reason for Medication</label>
                <input 
                    type="text" 
                    name="reason_for_med" 
                    id="reason_for_med" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Type 2 Diabetes"
                >
                <p class="mt-1 text-xs text-gray-500">What condition is this medication treating?</p>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes / Instructions</label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Take with food, avoid alcohol..."
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Include special instructions or side effects to watch for.</p>
            </div>

            <div>
                <label for="add_attachment" class="block text-sm font-medium text-gray-700">Medication Image (Optional)</label>
                <div class="mt-1">
                    <input 
                        type="file" 
                        id="add_attachment" 
                        name="attachment" 
                        accept="image/jpeg,image/jpg,image/png"
                        class="hidden"
                    >
                    <div id="add_fileDropArea" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition">
                        <div id="add_fileDropContent">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2" aria-hidden="true"></i>
                            <p class="text-sm text-gray-600 font-medium mb-1">Click to browse or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, JPEG (Max 10MB)</p>
                        </div>
                        <div id="add_filePreview" class="hidden space-y-3">
                            <img id="add_imagePreview" src="" alt="Preview" class="mx-auto max-h-40 rounded-lg border border-gray-200">
                            <div>
                                <p id="add_fileName" class="text-sm text-gray-900 font-medium mb-1"></p>
                                <p id="add_fileSize" class="text-xs text-gray-500 mb-2"></p>
                                <button type="button" id="add_removeFile" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                    <i class="fas fa-times-circle" aria-hidden="true"></i>
                                    Remove image
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        Upload a photo of your medication bottle or packaging.
                    </p>
                </div>
                <div id="add_uploadError" class="hidden mt-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                        <p id="add_uploadErrorMessage" class="text-xs text-red-700"></p>
                    </div>
                </div>
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
                    id="save-medication-button"
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
