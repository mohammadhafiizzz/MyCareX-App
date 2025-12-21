<div id="editPicModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40 close-modal" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Person In Charge (PIC)</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="editPicForm" action="{{ route('organisation.profile.update.pic') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label for="contact_person_name" class="block text-xs font-bold text-gray-400 uppercase mb-1">Full Name</label>
                        <input type="text" name="contact_person_name" id="contact_person_name" value="{{ $organisation->contact_person_name }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                    </div>

                    <div>
                        <label for="contact_person_designation" class="block text-xs font-bold text-gray-400 uppercase mb-1">Designation</label>
                        <input type="text" name="contact_person_designation" id="contact_person_designation" value="{{ $organisation->contact_person_designation }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="contact_person_phone_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">Direct Contact</label>
                            <input type="text" name="contact_person_phone_number" id="contact_person_phone_number" value="{{ $organisation->contact_person_phone_number }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                        </div>
                        <div>
                            <label for="contact_person_ic_number" class="block text-xs font-bold text-gray-400 uppercase mb-1">IC / ID Number</label>
                            <input type="text" name="contact_person_ic_number" id="contact_person_ic_number" value="{{ $organisation->contact_person_ic_number }}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
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
