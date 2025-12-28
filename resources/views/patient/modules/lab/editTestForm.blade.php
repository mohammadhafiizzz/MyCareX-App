<div 
    id="edit-test-modal"
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
                Edit Lab Test
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
        
        {{-- This form is for UPDATING the lab test record --}}
        <form id="edit-test-form" class="mt-6 space-y-6" method="POST" action="#">
            @csrf 
            @method('PUT')

            <div id="edit-form-error-message" class="hidden p-3 rounded-md bg-red-50 border border-red-200">
            </div>

            {{-- All form fields now have 'edit_' prefixed IDs --}}
            <div>
                <label for="edit_test_name" class="block text-sm font-medium text-gray-700">Test Name <span class="text-red-500">*</span></label>
                <div id="edit_test_select_wrapper" class="mt-1">
                    <select 
                        id="edit_test_select" 
                        class="block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="" disabled selected>Select a lab test</option>
                        @foreach($labTestOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                        <option value="other">Other...</option>
                    </select>
                </div>
                <div id="edit_test_manual_wrapper" class="mt-2 relative hidden">
                    <input 
                        type="text" 
                        name="test_name" 
                        id="edit_test_name"
                        required
                        class="block w-full p-3 pr-10 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Enter test name..."
                    >
                    <button
                        type="button" 
                        id="edit_switch_to_select" 
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer" 
                        title="Back to list">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div>
                <label for="edit_test_category" class="block text-sm font-medium text-gray-700">Test Category <span class="text-red-500">*</span></label>
                <div id="edit_test_category_select_wrapper" class="mt-1">
                    <select 
                        id="edit_test_category_select" 
                        class="block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    >
                        <option value="" disabled selected>Select a lab test category</option>
                        @foreach($labTestCategoryOptions as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                        <option value="other_category">Other...</option>
                    </select>
                </div>
                <div id="edit_test_category_manual_wrapper" class="mt-2 relative hidden">
                    <input 
                        type="text" 
                        name="test_category" 
                        id="edit_test_category"
                        required
                        class="block w-full p-3 pr-10 border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                        placeholder="Enter test category..."
                    >
                    <button
                        type="button" 
                        id="edit_switch_to_select_category" 
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer" 
                        title="Back to list">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="mt-1 text-xs text-gray-500">Specify the type or category of lab test.</p>
            </div>

            <div>
                <label for="edit_test_date" class="block text-sm font-medium text-gray-700">Test Date <span class="text-red-500">*</span></label>
                <input 
                    type="date" 
                    name="test_date" 
                    id="edit_test_date" 
                    required
                    class="mt-1 p-3 block w-full rounded-md border border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                    value=""
                >
            </div>

            <div>
                <label for="edit_facility_name" class="block text-sm font-medium text-gray-700">Facility Name</label>
                <input 
                    type="text" 
                    name="facility_name" 
                    id="edit_facility_name" 
                    class="mt-1 block p-3 w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                    value=""
                >
                <p class="mt-1 text-xs text-gray-500">Name of the laboratory or healthcare facility (optional).</p>
            </div>

            <div>
                <label for="edit_notes" class="block text-sm font-medium text-gray-700">Notes / Additional Information</label>
                <textarea 
                    id="edit_notes" 
                    name="notes" 
                    rows="3" 
                    class="mt-1 p-3 block w-full border border-gray-200 rounded-md focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                ></textarea>
                <p class="mt-1 text-xs text-gray-500">Include any additional information about this lab test.</p>
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
                id="update-test-button"
                form="edit-test-form"
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
