<!-- Edit Permission Modal -->
<div id="editPermissionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Background overlay -->
    <div class="absolute inset-0 bg-gray-500/30 transition-opacity" aria-hidden="true"></div>

    <div class="relative flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Modal panel -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <div>
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                Edit Access Scope
                            </h3>
                            <p class="text-sm text-gray-500">
                                Modify the medical records <span class="font-semibold text-gray-900">{{ $permission->doctor->full_name }}</span> can access.
                            </p>
                        </div>
                    </div>

                    <form id="updatePermissionForm" data-permission-id="{{ $permission->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @php
                                $scopes = [
                                    'medical_conditions' => ['label' => 'Medical Conditions', 'icon' => 'fas fa-heartbeat'],
                                    'medications' => ['label' => 'Medications', 'icon' => 'fas fa-pills'],
                                    'allergies' => ['label' => 'Allergies', 'icon' => 'fas fa-allergies'],
                                    'immunisations' => ['label' => 'Immunisations', 'icon' => 'fas fa-syringe'],
                                    'lab_tests' => ['label' => 'Lab Tests', 'icon' => 'fas fa-flask'],
                                ];
                                $grantedScopes = is_array($permission->permission_scope) ? $permission->permission_scope : [];
                            @endphp

                            @foreach($scopes as $key => $data)
                            <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors group">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="permission_scope[]" value="{{ $key }}" 
                                        {{ in_array($key, $grantedScopes) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                </div>
                                <div class="ml-4 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                        <i class="fas {{ $data['icon'] }} text-sm"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $data['label'] }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>

                        <div class="mb-2">
                            <label for="expiry_date" class="block text-sm font-semibold text-gray-900 mb-2">Access Expiry Date</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar text-gray-400"></i>
                                </div>
                                <input type="date" id="expiry_date" name="expiry_date" required
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    value="{{ $permission->expiry_date ? $permission->expiry_date->format('Y-m-d') : date('Y-m-d', strtotime('+1 month')) }}"
                                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">The doctor's access will automatically expire after this date.</p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                <button type="submit" form="updatePermissionForm" id="updateAccessBtn" class="inline-flex items-center cursor-pointer px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0">
                    Update
                </button>
                <button type="button" id="closeEditModal" class="inline-flex gap-2 items-center justify-center px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200/30 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
