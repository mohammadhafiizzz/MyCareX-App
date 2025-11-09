<div 
    id="edit-vaccine-modal"
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
                Edit Vaccination
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
        
        {{-- This form is for UPDATING the vaccination record --}}
        <form id="edit-vaccine-form" class="mt-6 space-y-6" method="POST" action="#">
            @csrf 
            @method('PUT')

            <div id="edit-form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
            </div>

            {{-- All form fields now have 'edit_' prefixed IDs --}}
            <div>
                <label for="edit_vaccine_name" class="block text-sm font-medium text-gray-700">Vaccine Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    name="vaccine_name" 
                    id="edit_vaccine_name" 
                    required
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value=""
                >
            </div>

            <div>
                <label for="edit_dose_details" class="block text-sm font-medium text-gray-700">Dose Details</label>
                <input 
                    type="text" 
                    name="dose_details" 
                    id="edit_dose_details" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value=""
                >
                <p class="mt-1 text-xs text-gray-500">Specify dose number or amount (optional).</p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="edit_vaccination_date" class="block text-sm font-medium text-gray-700">Vaccination Date <span class="text-red-500">*</span></label>
                    <input 
                        type="date" 
                        name="vaccination_date" 
                        id="edit_vaccination_date" 
                        required
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        value=""
                    >
                </div>

                <div>
                    <label for="edit_verification_status" class="block text-sm font-medium text-gray-700">Verification Status <span class="text-red-500">*</span></label>
                    <select 
                        id="edit_verification_status" 
                        name="verification_status"
                        required
                        class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="">Select status</option>
                        <option value="Unverified">Unverified</option>
                        <option value="Patient Reported">Patient Reported</option>
                        <option value="Provider Confirmed">Provider Confirmed</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="edit_administered_by" class="block text-sm font-medium text-gray-700">Administered By</label>
                <input 
                    type="text" 
                    name="administered_by" 
                    id="edit_administered_by" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value=""
                >
                <p class="mt-1 text-xs text-gray-500">Name of healthcare provider or facility (optional).</p>
            </div>

            <div>
                <label for="edit_vaccine_lot_number" class="block text-sm font-medium text-gray-700">Vaccine Lot Number</label>
                <input 
                    type="text" 
                    name="vaccine_lot_number" 
                    id="edit_vaccine_lot_number" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value=""
                >
                <p class="mt-1 text-xs text-gray-500">Lot number from vaccine vial or certificate (optional).</p>
            </div>

            <div>
                <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes / Additional Information</label>
                <textarea 
                    id="edit_notes" 
                    name="notes" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Include any additional information about this vaccination.</p>
            </div>
        </form>

        <div class="pt-6 mt-6 flex justify-end gap-3">
            <button 
                type="button" 
                id="edit-modal-cancel-button"
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
            >
                Cancel
            </button>

            <button 
                type="submit" 
                form="edit-vaccine-form"
                id="update-vaccine-button"
                class="inline-flex justify-center items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
            >
                <span id="update-button-text">Save Changes</span>
            </button>
        </div>
    </div>
</div>
