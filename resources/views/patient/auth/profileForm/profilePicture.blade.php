<!-- Profile Picture Upload Modal -->
<div id="profilePictureModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500/40" aria-hidden="true" onclick="closeModal('profilePictureModal', 'profilePictureModalContent')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div id="profilePictureModalContent" class="inline-block align-bottom bg-white rounded-md text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full relative z-10">
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Update Profile Picture</h3>
                <button type="button" onclick="closeModal('profilePictureModal', 'profilePictureModalContent')" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form action="{{ route('patient.profile.update.picture') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="px-6 py-6 space-y-6">
                    <!-- Current Profile Picture -->
                    <div class="text-center">
                        <div class="relative inline-block">
                            @if(Auth::guard('patient')->user()->profile_image_url)
                                <img id="currentProfileImage" src="{{ Auth::guard('patient')->user()->profile_image_url }}"
                                    alt="Current Profile Picture"
                                    class="w-32 h-32 rounded-full object-cover border-4 border-blue-50 shadow-sm">
                            @else
                                <div id="currentProfileImage"
                                    class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center border-4 border-white shadow-sm">
                                    <i class="fas fa-user text-4xl text-blue-200"></i>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs font-bold text-gray-400 uppercase mt-3">Current Profile Picture</p>
                    </div>

                    <!-- File Upload Section -->
                    <div class="space-y-4">
                        <div id="dropZone"
                            class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all cursor-pointer group">
                            <div id="uploadPrompt">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-3 group-hover:text-blue-400 transition-colors"></i>
                                <p class="text-sm font-bold text-gray-700 mb-1">Drop your image here</p>
                                <p class="text-xs text-gray-500 mb-4">or click to browse files</p>
                                <input type="file" id="profileImageInput" name="profile_image" accept="image/*" class="hidden">
                                <button type="button"
                                    class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-lg hover:bg-gray-50 shadow-sm transition-all"
                                    onclick="document.getElementById('profileImageInput').click()">
                                    Choose File
                                </button>
                            </div>

                            <!-- Preview Section (Hidden by default) -->
                            <div id="imagePreview" class="hidden">
                                <img id="previewImage" class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-100 shadow-sm">
                                <p id="fileName" class="text-xs font-medium text-gray-600 mt-3 truncate max-w-[200px] mx-auto"></p>
                                <button type="button" class="text-red-500 hover:text-red-700 text-xs font-bold mt-2 flex items-center justify-center gap-1 mx-auto"
                                    onclick="removePreview()">
                                    <i class="fas fa-trash-can"></i> Remove
                                </button>
                            </div>
                        </div>

                        <!-- File Requirements -->
                        <div class="bg-blue-50/50 p-4 rounded-lg border border-blue-100">
                            <div class="flex items-start gap-3">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <div class="text-[11px] text-blue-800 leading-relaxed">
                                    <p class="font-bold mb-1 uppercase">Requirements:</p>
                                    <div class="grid grid-cols-2 gap-x-4">
                                        <p>• Max size: 5MB</p>
                                        <p>• Formats: JPG, PNG, GIF</p>
                                        <p>• Ratio: 1:1 (Square)</p>
                                        <p>• Min: 200x200px</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remove Current Picture Option -->
                    @if(Auth::guard('patient')->user()->profile_image_url)
                        <div class="p-4 border border-red-100 rounded-lg bg-red-50/30 flex items-center justify-between gap-4">
                            <div>
                                <h4 class="text-xs font-bold text-red-900 uppercase">Remove Picture</h4>
                                <p class="text-[10px] text-red-700 mt-0.5">Reset to default avatar</p>
                            </div>
                            <button type="submit" form="deleteProfilePictureForm"
                                class="px-3 py-1.5 bg-white border border-red-200 text-red-600 text-xs font-bold rounded-lg hover:bg-red-50 shadow-sm transition-all"
                                onclick="return confirm('Are you sure you want to remove your current profile picture?')">
                                Remove
                            </button>
                        </div>
                    @endif
                </div>

                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('profilePictureModal', 'profilePictureModalContent')" class="px-4 py-2 text-sm font-semibold text-blue-600 hover:text-blue-800 border hover:bg-blue-100 border-blue-200 bg-white rounded-lg shadow-sm hover:shadow transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="uploadBtn"
                        class="px-6 py-2 bg-blue-600 text-white text-sm font-bold rounded-lg hover:bg-blue-700 shadow-sm transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Upload
                    </button>
                </div>
            </form>
            @if(Auth::guard('patient')->user()->profile_image_url)
                <form id="deleteProfilePictureForm" method="POST"
                    action="{{ route('patient.profile.delete.picture') }}" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>