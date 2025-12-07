<div 
    id="edit-surgery-modal"
    class="fixed inset-0 z-50 bg-gray-950/50 hidden items-center justify-center p-4 overflow-y-auto"
    aria-labelledby="edit-surgery-modal-title"
    role="dialog"
    aria-modal="true"
>
    <div class="relative w-full max-w-lg p-6 my-8 text-left align-middle bg-white rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-pen-to-square text-purple-600" aria-hidden="true"></i>
                </div>
                <h3 class="text-xl font-semibold leading-6 text-gray-900" id="edit-surgery-modal-title">
                    Edit Surgery Record
                </h3>
            </div>
            <button 
                type="button" 
                id="edit-modal-close-button"
                class="text-gray-400 hover:text-gray-600 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 p-1"
            >
                <i class="fas fa-times text-lg" aria-hidden="true"></i>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        {{-- Error Container --}}
        <div id="edit-form-error-message" class="hidden mb-4 p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm">
        </div>

        <form id="edit-surgery-form" class="space-y-5" method="POST">
            @csrf 
            @method('PUT')

            {{-- Procedure Name --}}
            <div>
                <label for="edit_procedure_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Procedure Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="procedure_name" 
                    id="edit_procedure_name" 
                    required
                    class="block p-3 w-full border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500 sm:text-sm transition" 
                    placeholder="e.g., Appendectomy, Knee Replacement"
                >
                <p class="mt-1.5 text-xs text-gray-500">Enter the name or type of the surgical procedure</p>
            </div>

            {{-- Procedure Date --}}
            <div>
                <label for="edit_procedure_date" class="block text-sm font-semibold text-gray-700 mb-2">
                    Procedure Date <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    name="procedure_date" 
                    id="edit_procedure_date" 
                    required
                    max="{{ date('Y-m-d') }}"
                    class="block p-3 w-full rounded-lg border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 sm:text-sm transition"
                >
                <p class="mt-1.5 text-xs text-gray-500">When did the surgery take place?</p>
            </div>

            {{-- Surgeon Name --}}
            <div>
                <label for="edit_surgeon_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Surgeon Name (Optional)
                </label>
                <input 
                    type="text" 
                    name="surgeon_name" 
                    id="edit_surgeon_name" 
                    class="block p-3 w-full border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500 sm:text-sm transition" 
                    placeholder="e.g., Dr. John Smith"
                >
                <p class="mt-1.5 text-xs text-gray-500">Name of the surgeon who performed the procedure</p>
            </div>

            {{-- Hospital Name --}}
            <div>
                <label for="edit_hospital_name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Hospital / Facility (Optional)
                </label>
                <input 
                    type="text" 
                    name="hospital_name" 
                    id="edit_hospital_name" 
                    class="block p-3 w-full border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-500 sm:text-sm transition" 
                    placeholder="e.g., City General Hospital"
                >
                <p class="mt-1.5 text-xs text-gray-500">Where was the surgery performed?</p>
            </div>

            {{-- Notes --}}
            <div>
                <label for="edit_notes" class="block text-sm font-semibold text-gray-700 mb-2">
                    Notes / Additional Information (Optional)
                </label>
                <textarea 
                    id="edit_notes" 
                    name="notes" 
                    rows="4" 
                    maxlength="1000"
                    class="block p-3 w-full rounded-lg border border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 sm:text-sm transition resize-none"
                    placeholder="Any additional details about the surgery, complications, or recovery..."
                ></textarea>
                <p class="mt-1.5 text-xs text-gray-500">Maximum 1000 characters</p>
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse sm:flex-row gap-3 pt-4 border-t border-gray-200">
                <button 
                    type="button" 
                    id="edit-modal-cancel-button"
                    class="flex-1 inline-flex justify-center items-center px-4 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-semibold hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 focus-visible:ring-offset-2 transition"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-purple-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-purple-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-purple-500 focus-visible:ring-offset-2 transition"
                >
                    <i class="fas fa-save" aria-hidden="true"></i>
                    Update Surgery
                </button>
            </div>
        </form>
    </div>
</div>
