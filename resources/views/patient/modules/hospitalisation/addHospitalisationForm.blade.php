
<div id="add-hospitalisation-modal" class="fixed inset-0 z-50 bg-gray-950/50 hidden items-center justify-center p-4 overflow-y-auto" role="dialog" aria-labelledby="add-hospitalisation-title" aria-modal="true">
    <div class="relative w-full max-w-lg p-6 my-8 text-left align-middle bg-white rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto">
        
        {{-- Modal Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hospital-alt text-blue-600" aria-hidden="true"></i>
                </div>
                <h3 id="add-hospitalisation-title" class="text-xl font-semibold leading-6 text-gray-900">
                    Add New Hospitalisation
                </h3>
            </div>
            <button type="button" id="close-add-hospitalisation-modal" class="text-gray-400 hover:text-gray-600 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 p-1">
                <i class="fas fa-times text-lg" aria-hidden="true"></i>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        {{-- Error Message Container --}}
        <div id="form-error-message" class="hidden mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-sm text-red-800" role="alert">
            <!-- Errors will be inserted here by JavaScript -->
        </div>

        {{-- Modal Body --}}
        <form id="add-hospitalisation-form" action="{{ route('patient.hospitalisation.add') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Admission Date --}}
            <div>
                <label for="admission-date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Admission Date <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    id="admission-date" 
                    name="admission_date" 
                    required
                    max="{{ date('Y-m-d') }}"
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm"
                >
                <p class="mt-1.5 text-xs text-gray-500">When were you admitted to the hospital?</p>
            </div>

            {{-- Discharge Date --}}
            <div>
                <label for="discharge-date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Discharge Date <span class="text-gray-500 text-xs font-normal">(Optional)</span>
                </label>
                <input 
                    type="date" 
                    id="discharge-date" 
                    name="discharge_date"
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm"
                >
                <p class="mt-1.5 text-xs text-gray-500">Leave blank if still hospitalized</p>
            </div>

            {{-- Reason for Admission --}}
            <div>
                <label for="reason-for-admission" class="block text-sm font-semibold text-gray-700 mb-2">
                    Reason for Admission <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="reason-for-admission" 
                    name="reason_for_admission" 
                    required
                    maxlength="255"
                    placeholder="e.g., Pneumonia, Surgery, etc."
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm"
                >
                <p class="mt-1.5 text-xs text-gray-500">Enter the reason or diagnosis for the hospitalisation</p>
            </div>

            {{-- Provider Name --}}
            <div>
                <label for="provider-name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Hospital/Provider Name <span class="text-gray-500 text-xs font-normal">(Optional)</span>
                </label>
                <input 
                    type="text" 
                    id="provider-name" 
                    name="provider_name"
                    maxlength="255"
                    placeholder="e.g., City General Hospital"
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition sm:text-sm"
                >
                <p class="mt-1.5 text-xs text-gray-500">Name of the hospital or healthcare facility</p>
            </div>

            {{-- Notes --}}
            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                    Additional Notes <span class="text-gray-500 text-xs font-normal">(Optional)</span>
                </label>
                <textarea 
                    id="notes" 
                    name="notes" 
                    rows="4"
                    maxlength="1000"
                    placeholder="Add any relevant details about the hospitalisation..."
                    class="block w-full p-3 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none transition sm:text-sm"
                ></textarea>
                <p class="mt-1.5 text-xs text-gray-500">Maximum 1000 characters</p>
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    id="cancel-add-hospitalisation"
                    class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 transition"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-lg shadow-sm hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 transition"
                >
                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                    Add Hospitalisation
                </button>
            </div>
        </form>
    </div>
</div>
