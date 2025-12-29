<!-- Delete Doctor Modal -->
<div id="deleteDoctorModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true"></div>

    <div class="relative flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-col items-center text-center">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-2" id="modal-title">
                        Remove Doctor
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to remove <span class="font-bold text-gray-900">{{ $doctor->full_name }}</span>? This action cannot be undone.
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Please enter the doctor's <span class="font-bold text-gray-900">IC Number</span> to confirm:
                        </p>
                        <div class="mt-4">
                            <input type="text" id="confirm_ic_number" name="ic_number" class="block w-full px-4 py-3 rounded-lg border border-gray-200 transition-all text-sm" placeholder="Enter IC Number">
                            <p id="ic_error" class="mt-1 text-xs text-red-600 hidden">IC number does not match.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="button" id="confirmDeleteBtn" data-doctor-id="{{ $doctor->id }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold shadow-sm hover:bg-red-700 transition-all duration-200">
                    Remove Permanently
                </button>
                <button type="button" id="closeDeleteModal" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>