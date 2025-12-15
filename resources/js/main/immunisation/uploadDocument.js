// Upload Certificate Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const uploadModal = document.getElementById('uploadCertificateModal');
    const uploadBtn = document.getElementById('uploadCertificateBtn');
    const uploadBtnEmpty = document.getElementById('uploadCertificateBtnEmpty');
    const closeModalBtn = document.getElementById('closeUploadModal');
    const cancelBtn = document.getElementById('cancelUploadBtn');
    const uploadForm = document.getElementById('uploadCertificateForm');
    const fileInput = document.getElementById('certificate');
    const fileDropArea = document.getElementById('fileDropArea');
    const fileDropContent = document.getElementById('fileDropContent');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const removeFileBtn = document.getElementById('removeFile');
    const uploadError = document.getElementById('uploadError');
    const uploadErrorMessage = document.getElementById('uploadErrorMessage');
    const submitBtn = document.getElementById('submitUploadBtn');

    // Open modal when upload button is clicked
    function openModal() {
        uploadModal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        resetForm();
    }

    // Close modal
    function closeModal() {
        uploadModal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore background scrolling
        resetForm();
    }

    // Reset form
    function resetForm() {
        uploadForm.reset();
        fileInput.value = '';
        fileDropContent.classList.remove('hidden');
        filePreview.classList.add('hidden');
        uploadError.classList.add('hidden');
        submitBtn.disabled = false;
    }

    // Show error message
    function showError(message) {
        uploadErrorMessage.textContent = message;
        uploadError.classList.remove('hidden');
    }

    // Hide error message
    function hideError() {
        uploadError.classList.add('hidden');
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
            fileInput.value = '';
            return;
        }

        // Validate file type - PDF, PNG, JPG, and JPEG only
        const allowedTypes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
        if (!allowedTypes.includes(file.type)) {
            showError('Invalid file type. Please select a PDF, PNG, JPG, or JPEG file only.');
            fileInput.value = '';
            return;
        }

        // Show file preview
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileDropContent.classList.add('hidden');
        filePreview.classList.remove('hidden');
        submitBtn.disabled = false;
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
            fileInput.click();
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
            fileInput.value = '';
            fileDropContent.classList.remove('hidden');
            filePreview.classList.add('hidden');
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
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });
    }

    // Form submission
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                showError('Please select a file to upload.');
                return;
            }

            // Disable submit button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
        });
    }

    // Keyboard accessibility - ESC to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && uploadModal.style.display === 'flex') {
            closeModal();
        }
    });
});
