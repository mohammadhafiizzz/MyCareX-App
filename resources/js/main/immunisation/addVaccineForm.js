document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('add-vaccine-modal');
    const showButton = document.getElementById('show-add-vaccine-modal');
    const closeButton = document.getElementById('modal-close-button');
    const cancelButton = document.getElementById('modal-cancel-button');
    const modalPanel = document.getElementById('modal-panel');
    const form = document.getElementById('add-vaccine-form');

    const showModal = () => {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Use flex for centering
            document.body.classList.add('overflow-hidden'); // Prevent background scrolling
        }
    };

    const hideModal = () => {
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden'); // Restore background scrolling
        }
    };

    // Show modal when the "Add Vaccination" button is clicked
    if (showButton) {
        showButton.addEventListener('click', showModal);
    }

    // Hide modal when the 'X' button is clicked
    if (closeButton) {
        closeButton.addEventListener('click', hideModal);
    }

    // Hide modal when the "Cancel" button is clicked
    if (cancelButton) {
        cancelButton.addEventListener('click', hideModal);
    }

    // Hide modal when clicking on the background (outside the panel)
    if (modal) {
        modal.addEventListener('click', (event) => {
            // Check if the click is on the modal background itself,
            // not on its children (the panel)
            if (event.target === modal) {
                hideModal();
            }
        });
    }

    // Hide any server-rendered error container when user focuses inputs
    const errorMessageDiv = document.getElementById('form-error-message');
    if (errorMessageDiv && form) { // Add form check here
        form.addEventListener('input', () => {
            if (!errorMessageDiv.classList.contains('hidden')) {
                errorMessageDiv.classList.add('hidden');
                errorMessageDiv.innerHTML = '';
            }
        });
    }

    // File upload handling for add form
    const addFileInput = document.getElementById('add_certificate');
    const addFileDropArea = document.getElementById('add_fileDropArea');
    const addFileDropContent = document.getElementById('add_fileDropContent');
    const addFilePreview = document.getElementById('add_filePreview');
    const addFileName = document.getElementById('add_fileName');
    const addFileSize = document.getElementById('add_fileSize');
    const addRemoveFileBtn = document.getElementById('add_removeFile');
    const addUploadError = document.getElementById('add_uploadError');
    const addUploadErrorMessage = document.getElementById('add_uploadErrorMessage');

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Show error message
    function showAddError(message) {
        if (addUploadErrorMessage && addUploadError) {
            addUploadErrorMessage.textContent = message;
            addUploadError.classList.remove('hidden');
        }
    }

    // Hide error message
    function hideAddError() {
        if (addUploadError) {
            addUploadError.classList.add('hidden');
        }
    }

    // Handle file selection
    function handleAddFileSelect(file) {
        if (!file) return;

        hideAddError();

        // Validate file size (10MB max)
        const maxSize = 10 * 1024 * 1024;
        if (file.size > maxSize) {
            showAddError('File size exceeds 10MB. Please select a smaller file.');
            addFileInput.value = '';
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
        if (addFileName && addFileSize && addFileDropContent && addFilePreview) {
            addFileName.textContent = file.name;
            addFileSize.textContent = formatFileSize(file.size);
            addFileDropContent.classList.add('hidden');
            addFilePreview.classList.remove('hidden');
        }
    }

    // File drop area click
    if (addFileDropArea && addFileInput) {
        addFileDropArea.addEventListener('click', function() {
            addFileInput.click();
        });
    }

    // File input change
    if (addFileInput) {
        addFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            handleAddFileSelect(file);
        });
    }

    // Remove file button
    if (addRemoveFileBtn && addFileInput) {
        addRemoveFileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            addFileInput.value = '';
            if (addFileDropContent && addFilePreview) {
                addFileDropContent.classList.remove('hidden');
                addFilePreview.classList.add('hidden');
            }
            hideAddError();
        });
    }

    // Drag and drop functionality
    if (addFileDropArea) {
        addFileDropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            addFileDropArea.classList.add('border-blue-400', 'bg-blue-50');
        });

        addFileDropArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            addFileDropArea.classList.remove('border-blue-400', 'bg-blue-50');
        });

        addFileDropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            addFileDropArea.classList.remove('border-blue-400', 'bg-blue-50');

            const files = e.dataTransfer.files;
            if (files.length > 0 && addFileInput) {
                addFileInput.files = files;
                handleAddFileSelect(files[0]);
            }
        });
    }
});
