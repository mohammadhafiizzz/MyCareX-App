<!-- Upload Medication Image Modal -->
<div id="uploadMedicationImageModal" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-md shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <i class="fas fa-upload" aria-hidden="true"></i>
                    Upload Medication Image
                </h3>
                <button type="button" id="closeMedicationImageModal" class="text-white/80 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-lg p-1">
                    <i class="fas fa-times text-xl" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="uploadMedicationImageForm" method="POST" action="{{ route('patient.medication.upload.image', $medication->id) }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="medImage" class="block text-sm font-medium text-gray-700 mb-2">
                    Select Image
                    <span class="text-red-500">*</span>
                </label>
                
                <!-- File Input Area -->
                <div class="relative">
                    <input type="file" id="medImage" name="med_image_url" accept=".jpg,.jpeg,.png" required class="hidden">
                    <div id="imageDropArea" class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition">
                        <div id="imageDropContent">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3" aria-hidden="true"></i>
                            <p class="text-sm text-gray-600 font-medium mb-1">Click to browse or drag and drop</p>
                            <p class="text-xs text-gray-500">JPG, JPEG, PNG (Max 10MB)</p>
                        </div>
                        <div id="imagePreviewContainer" class="hidden">
                            <img id="imagePreviewImg" src="" alt="Preview" class="max-h-48 mx-auto mb-3 rounded-lg">
                            <p id="imageFileName" class="text-sm text-gray-900 font-medium mb-1"></p>
                            <p id="imageFileSize" class="text-xs text-gray-500 mb-3"></p>
                            <button type="button" id="removeImageFile" class="text-xs text-red-600 hover:text-red-700 font-medium">
                                <i class="fas fa-times-circle" aria-hidden="true"></i>
                                Remove image
                            </button>
                        </div>
                    </div>
                </div>

                <p class="mt-2 text-xs text-gray-500">
                    <i class="fas fa-info-circle" aria-hidden="true"></i>
                    Supported formats: JPG, JPEG, PNG. Maximum file size: 10MB
                </p>
            </div>

            <!-- Error Message Display -->
            <div id="uploadImageError" class="hidden mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-start gap-2">
                    <i class="fas fa-exclamation-circle text-red-600 mt-0.5" aria-hidden="true"></i>
                    <p id="uploadImageErrorMessage" class="text-sm text-red-700"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex gap-3 justify-end">
                <button type="button" id="cancelMedicationImageBtn" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-200">
                    Cancel
                </button>
                <button type="submit" id="submitMedicationImageBtn" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-upload mr-2" aria-hidden="true"></i>
                    Upload Image
                </button>
            </div>
        </form>
    </div>
</div>
