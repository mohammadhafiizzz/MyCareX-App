<!-- Upload Medication Image Modal -->
<div id="uploadMedicationImageModal" class="fixed inset-0 bg-gray-900/50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-md shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-upload" aria-hidden="true"></i>
                    Upload Medication Image
                </h3>
                <button type="button" id="closeMedicationImageModal" class="text-gray-700 hover:text-gray-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 rounded-lg p-1">
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
            <div class="flex gap-2 flex-col-reverse sm:flex-row sm:justify-end sm:space-x-8 lg:space-x-0">
                <button 
                    type="button"  
                    id="cancelMedicationImageBtn"
                    class="justify-center inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100/60 backdrop-blur-md text-gray-700 rounded-xl border border-gray-200 shadow-sm text-sm font-medium hover:bg-gray-100/80 hover:shadow-md transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-300/50 focus-visible:ring-offset-0"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    id="submitMedicationImageBtn"
                    class="justify-center inline-flex items-center cursor-pointer gap-2 px-4 py-2.5 bg-gradient-to-br from-blue-500/90 to-blue-600/90 backdrop-blur-md text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:from-blue-500 hover:to-blue-600 transition-all duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-400/50 focus-visible:ring-offset-0"
                >
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="save-button-text">Upload</span>
                </button>
            </div>
        </form>
    </div>
</div>
