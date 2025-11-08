// Upload Medication Image Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const uploadModal = document.getElementById('uploadMedicationImageModal');
    const uploadBtn = document.getElementById('uploadMedicationImageBtn');
    const uploadBtnEmpty = document.getElementById('uploadMedicationImageBtnEmpty');
    const closeModalBtn = document.getElementById('closeMedicationImageModal');
    const cancelBtn = document.getElementById('cancelMedicationImageBtn');
    const uploadForm = document.getElementById('uploadMedicationImageForm');
    const fileInput = document.getElementById('med_image');
    const fileDropArea = document.getElementById('imageDropArea');
    const fileDropContent = document.getElementById('imageDropContent');
    const filePreview = document.getElementById('imagePreviewContainer');
    const previewImg = document.getElementById('imagePreviewImg');
    const fileName = document.getElementById('imageFileName');
    const fileSize = document.getElementById('imageFileSize');
    const removeFileBtn = document.getElementById('removeImageFile');
    const uploadError = document.getElementById('uploadImageError');
    const uploadErrorMessage = document.getElementById('uploadImageErrorMessage');
    const submitBtn = document.getElementById('submitMedicationImageBtn');

    // Open modal when upload button is clicked
    function openModal() {
        if (uploadModal) {
            uploadModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
            resetForm();
        }
    }

    // Close modal
    function closeModal() {
        if (uploadModal) {
            uploadModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore background scrolling
            resetForm();
        }
    }

    // Reset form
    function resetForm() {
        if (uploadForm) {
            uploadForm.reset();
        }
        if (fileInput) {
            fileInput.value = '';
        }
        if (fileDropContent) {
            fileDropContent.classList.remove('hidden');
        }
        if (filePreview) {
            filePreview.classList.add('hidden');
        }
        if (previewImg) {
            previewImg.src = '';
        }
        if (uploadError) {
            uploadError.classList.add('hidden');
        }
        if (submitBtn) {
            submitBtn.disabled = false;
        }
    }

    // Show error message
    function showError(message) {
        if (uploadErrorMessage && uploadError) {
            uploadErrorMessage.textContent = message;
            uploadError.classList.remove('hidden');
        }
    }

    // Hide error message
    function hideError() {
        if (uploadError) {
            uploadError.classList.add('hidden');
        }
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Handle file selection
    function handleFileSelect(file) {
        if (!file) return;

        hideError();

        // Validate file size (10MB max)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            showError('File size exceeds 10MB. Please select a smaller file.');
            if (fileInput) fileInput.value = '';
            return;
        }

        // Validate file type - only images
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showError('Invalid file type. Please select a JPG, JPEG, or PNG image.');
            if (fileInput) fileInput.value = '';
            return;
        }

        // Show image preview
        if (fileName && fileSize && fileDropContent && filePreview && previewImg) {
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Create image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            fileDropContent.classList.add('hidden');
            filePreview.classList.remove('hidden');
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    // Event Listeners
    if (uploadBtn) {
        uploadBtn.addEventListener('click', openModal);
    }

    if (uploadBtnEmpty) {
        uploadBtnEmpty.addEventListener('click', openModal);
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    // Click outside modal to close
    if (uploadModal) {
        uploadModal.addEventListener('click', function(e) {
            if (e.target === uploadModal) {
                closeModal();
            }
        });
    }

    // File drop area click
    if (fileDropArea) {
        fileDropArea.addEventListener('click', function() {
            if (fileInput) fileInput.click();
        });
    }

    // File input change
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            handleFileSelect(file);
        });
    }

    // Remove file button
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            if (fileInput) fileInput.value = '';
            if (previewImg) previewImg.src = '';
            if (fileDropContent) fileDropContent.classList.remove('hidden');
            if (filePreview) filePreview.classList.add('hidden');
            hideError();
        });
    }

    // Drag and drop functionality
    if (fileDropArea) {
        fileDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileDropArea.classList.add('border-blue-400', 'bg-blue-50');
        });

        fileDropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileDropArea.classList.remove('border-blue-400', 'bg-blue-50');
        });

        fileDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileDropArea.classList.remove('border-blue-400', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0 && fileInput) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });
    }

    // Form submission
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                showError('Please select an image to upload.');
                return;
            }

            // Disable submit button to prevent double submission
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
            }
        });
    }

    // Keyboard accessibility - ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && uploadModal && uploadModal.style.display === 'flex') {
            closeModal();
        }
    });
});
