<div 
    id="add-vaccine-modal"
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
                Add New Vaccination
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
        
        <form id="add-vaccine-form" class="mt-6 space-y-6" method="POST" action="{{ route('patient.immunisation.add') }}" enctype="multipart/form-data">
            @csrf 

            <div id="form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
            </div>

            <div>
                <label for="vaccine_name" class="block text-sm font-medium text-gray-700">Vaccine Name <span class="text-red-500">*</span></label>
                <div id="vaccine_select_wrapper" class="mt-1">
                    <select 
                        id="vaccine_select" 
                        class="block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="" disabled selected>Select a vaccine</option>
                        @foreach($vaccineOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                        <option value="other">Other (Type manually)</option>
                    </select>
                </div>
                <div id="vaccine_manual_wrapper" class="mt-2 hidden">
                    <div class="flex gap-2">
                        <input 
                            type="text" 
                            name="vaccine_name" 
                            id="vaccine_name" 
                            class="block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                            placeholder="Enter vaccine name"
                        >
                        <button type="button" id="switch_to_select" class="px-3 py-2 bg-gray-100 text-gray-600 rounded-md hover:bg-gray-200 transition-colors" title="Back to list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <label for="dose_details" class="block text-sm font-medium text-gray-700">Dose Details</label>
                <input 
                    type="text" 
                    name="dose_details" 
                    id="dose_details" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., First dose, Booster, 0.5ml"
                >
                <p class="mt-1 text-xs text-gray-500">Specify dose number or amount (optional).</p>
            </div>

            <div>
                <label for="vaccination_date" class="block text-sm font-medium text-gray-700">Vaccination Date <span class="text-red-500">*</span></label>
                <input 
                    type="date" 
                    name="vaccination_date" 
                    id="vaccination_date"
                    required
                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                >
            </div>

            <div>
                <label for="administered_by" class="block text-sm font-medium text-gray-700">Administered By</label>
                <input 
                    type="text" 
                    name="administered_by" 
                    id="administered_by" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Dr. Smith, City Health Clinic"
                >
                <p class="mt-1 text-xs text-gray-500">Name of healthcare provider or facility (optional).</p>
            </div>

            <div>
                <label for="vaccine_lot_number" class="block text-sm font-medium text-gray-700">Vaccine Lot Number</label>
                <input 
                    type="text" 
                    name="vaccine_lot_number" 
                    id="vaccine_lot_number" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., AB123456"
                >
                <p class="mt-1 text-xs text-gray-500">Lot number from vaccine vial or certificate (optional).</p>
            </div>

            <div>
                <label for="add_certificate" class="block text-sm font-medium text-gray-700">Vaccination Certificate (Optional)</label>
                <div class="mt-1">
                    <input 
                        type="file" 
                        id="add_certificate" 
                        name="certificate" 
                        accept=".pdf, .png, .jpg, .jpeg"
                        class="hidden"
                    >
                    <div id="add_fileDropArea" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition">
                        <div id="add_fileDropContent">
                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2" aria-hidden="true"></i>
                            <p class="text-sm text-gray-600 font-medium mb-1">Click to browse or drag and drop</p>
                            <p class="text-xs text-gray-500">PDF, PNG, JPG, and JPEG only (Max 10MB)</p>
                        </div>
                        <div id="add_filePreview" class="hidden">
                            <i class="fas fa-file-pdf text-3xl text-blue-600 mb-2" aria-hidden="true"></i>
                            <p id="add_fileName" class="text-sm text-gray-900 font-medium mb-1"></p>
                            <p id="add_fileSize" class="text-xs text-gray-500 mb-2"></p>
                            <button type="button" id="add_removeFile" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                <i class="fas fa-times-circle" aria-hidden="true"></i>
                                Remove file
                            </button>
                        </div>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                        You can also upload a certificate later from the vaccination details page.
                    </p>
                </div>
                <div id="add_uploadError" class="hidden mt-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-2">
                        <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                        <p id="add_uploadErrorMessage" class="text-xs text-red-700"></p>
                    </div>
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes / Additional Information</label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    placeholder="e.g., Any side effects experienced, next booster due date..."
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Include any additional information about this vaccination.</p>
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
                    id="save-vaccine-button"
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
