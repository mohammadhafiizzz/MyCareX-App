<!-- Profile Picture Upload Modal -->
<div id="profilePictureModal"
    class="fixed inset-0 bg-gray-950/50 z-50 flex hidden items-start justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 my-4 min-h-fit max-h-screen overflow-y-auto"
        id="profilePictureModalContent">
        <!-- Modal Header -->
        <div
            class="flex items-center justify-between p-6 border-b border-gray-200 sticky top-0 bg-white rounded-t-xl z-10">
            <h2 class="text-xl font-bold text-gray-900">Update Profile Picture</h2>
            <button class="text-gray-400 cursor-pointer hover:text-gray-600 transition-colors" id="closeprofilePictureModal">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body - Scrollable Content -->
        <div class="overflow-y-auto flex-1">
            <form action="#" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <!-- Current Profile Picture -->
                <div class="text-center mb-6">
                    <div class="relative inline-block">
                        @if(Auth::guard('patient')->user()->profile_image_url)
                            <img id="currentProfileImage" src="{{ Auth::guard('patient')->user()->profile_image_url }}"
                                alt="Current Profile Picture"
                                class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        @else
                            <div id="currentProfileImage"
                                class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center border-4 border-gray-300">
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Current profile picture</p>
                </div>

                <!-- File Upload Section -->
                <div class="space-y-4">
                    <!-- Drag & Drop Area -->
                    <div id="dropZone"
                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <div id="uploadPrompt">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <p class="text-lg font-medium text-gray-700 mb-2">Drop your image here</p>
                            <p class="text-sm text-gray-500 mb-4">or click to browse files</p>
                            <input type="file" id="profileImageInput" name="profile_image" accept="image/*"
                                class="hidden">
                            <button type="button"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                onclick="document.getElementById('profileImageInput').click()">
                                Choose File
                            </button>
                        </div>

                        <!-- Preview Section (Hidden by default) -->
                        <div id="imagePreview" class="hidden">
                            <img id="previewImage"
                                class="w-32 h-32 rounded-full object-cover mx-auto border-4 border-blue-200">
                            <p id="fileName" class="text-sm text-gray-600 mt-2"></p>
                            <button type="button" class="text-red-600 hover:text-red-700 text-sm mt-2"
                                onclick="removePreview()">
                                <i class="fas fa-trash mr-1"></i>Remove
                            </button>
                        </div>
                    </div>

                    <!-- File Requirements -->
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-medium mb-1">Image Requirements:</p>
                                <ul class="space-y-1">
                                    <li>• Maximum file size: 5MB</li>
                                    <li>• Supported formats: JPG, PNG, GIF</li>
                                    <li>• Recommended: Square images (1:1 ratio)</li>
                                    <li>• Minimum resolution: 200x200 pixels</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Remove Current Picture Option -->
                @if(Auth::guard('patient')->user()->profile_image_url)
                    <div class="mt-6 p-4 border border-red-200 rounded-lg bg-red-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium text-red-900">Remove Current Picture</h4>
                                <p class="text-sm text-red-700">This will set your profile picture back to default</p>
                            </div>
                            <button type="button"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm"
                                onclick="confirmRemoveImage()">
                                Remove
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Modal Footer - Sticky at bottom -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-start space-y-3 sm:space-y-0 sm:space-x-4 mt-8 pt-6 border-t border-gray-200 sticky bottom-0 bg-white">
                    <button type="submit" id="uploadBtn"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        <i class="fas fa-upload mr-2"></i>Upload Picture
                    </button>
                    <button type="button"
                        class="w-full cursor-pointer sm:w-auto px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                        onclick="closeModal('profilePictureModal', 'profilePictureModalContent')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>