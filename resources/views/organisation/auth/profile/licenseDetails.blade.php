<div id="editLegalModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40 close-modal" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Legal & Licensing</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="editLegalForm" action="{{ route('organisation.profile.update.legal') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label for="registration_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">Registration Number</label>
                        <input type="text" name="registration_number" id="registration_number" value="{{ $organisation->registration_number }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="license_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">License Number</label>
                            <input type="text" name="license_number" id="license_number" value="{{ $organisation->license_number }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
                        </div>
                        <div>
                            <label for="license_expiry_date" class="block text-xs font-bold text-gray-400 uppercase mb-1">License Expiry Date</label>
                            <input type="date" name="license_expiry_date" id="license_expiry_date" value="{{ $organisation->license_expiry_date }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
                        </div>
                    </div>

                    <div class="space-y-4 pt-2">
                        <div>
                            <label for="business_license_document" class="block text-xs font-bold text-gray-400 uppercase mb-2">Business License Document (PDF/JPG)</label>
                            <input type="file" name="business_license_document" id="business_license_document" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        </div>
                        <div>
                            <label for="medical_license_document" class="block text-xs font-bold text-gray-400 uppercase mb-2">Medical License Document (PDF/JPG)</label>
                            <input type="file" name="medical_license_document" id="medical_license_document" accept=".pdf,.jpg,.jpeg,.png"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="close-modal px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
