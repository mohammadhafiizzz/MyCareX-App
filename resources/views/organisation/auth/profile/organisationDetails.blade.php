<div id="editDetailsModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40 close-modal" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Edit Organisation Details</h3>
                <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form id="editDetailsForm" action="{{ route('organisation.profile.update.details') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-4">
                    <div>
                        <label for="organisation_name" class="block text-xs font-bold text-gray-400 uppercase mb-1">Organisation Name</label>
                        <input type="text" name="organisation_name" id="organisation_name" value="{{ $organisation->organisation_name }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                    </div>

                    <div>
                        <label for="organisation_type" class="block text-xs font-bold text-gray-400 uppercase mb-1">Organisation Type</label>
                        <select name="organisation_type" id="organisation_type" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" required>
                            <option value="Hospital" {{ $organisation->organisation_type == 'Hospital' ? 'selected' : '' }}>Hospital</option>
                            <option value="Clinic" {{ $organisation->organisation_type == 'Clinic' ? 'selected' : '' }}>Clinic</option>
                            <option value="Pharmacy" {{ $organisation->organisation_type == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
                            <option value="Laboratory" {{ $organisation->organisation_type == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                            <option value="Other" {{ $organisation->organisation_type == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div>
                        <label for="establishment_date" class="block text-xs font-bold text-gray-400 uppercase mb-1">Establishment Date</label>
                        <input type="date" name="establishment_date" id="establishment_date" value="{{ $organisation->establishment_date }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none">
                    </div>

                    <div>
                        <label for="website_url" class="block text-xs font-bold text-gray-400 uppercase mb-1">Website URL</label>
                        <input type="url" name="website_url" id="website_url" value="{{ $organisation->website_url }}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-sm outline-none" placeholder="https://example.com">
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
