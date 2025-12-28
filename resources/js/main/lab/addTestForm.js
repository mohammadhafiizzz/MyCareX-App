document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('add-test-modal');
    const showButton = document.getElementById('show-add-test-modal');
    const closeButton = document.getElementById('modal-close-button');
    const cancelButton = document.getElementById('modal-cancel-button');
    const modalPanel = document.getElementById('modal-panel');
    const form = document.getElementById('add-test-form');

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

    // Show modal when the "Add Lab Test" button is clicked
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

    // Lab Test Name Select/Manual Toggle
    const testSelect = document.getElementById('test_select');
    const testManualWrapper = document.getElementById('test_manual_wrapper');
    const testSelectWrapper = document.getElementById('test_select_wrapper');
    const testNameInput = document.getElementById('test_name');
    const switchToSelectBtn = document.getElementById('switch_to_select');

    if (testSelect && testManualWrapper && testSelectWrapper && testNameInput && switchToSelectBtn) {
        testSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                testSelectWrapper.classList.add('hidden');
                testManualWrapper.classList.remove('hidden');
                testNameInput.value = '';
                testNameInput.focus();
                testNameInput.required = true;
            } else {
                testNameInput.value = this.value;
                testNameInput.required = false;
            }
        });

        switchToSelectBtn.addEventListener('click', function() {
            testManualWrapper.classList.add('hidden');
            testSelectWrapper.classList.remove('hidden');
            testSelect.value = '';
            testNameInput.value = '';
            testNameInput.required = false;
        });
    }

    const testCategorySelect = document.getElementById('test_category_select');
    const testCategoryManualWrapper = document.getElementById('test_category_manual_wrapper');
    const testCategorySelectWrapper = document.getElementById('test_category_select_wrapper');
    const testCategoryInput = document.getElementById('test_category');
    const switchToSelectCategoryBtn = document.getElementById('switch_to_select_category');

    if (testCategorySelect && testCategoryManualWrapper && testCategorySelectWrapper && testCategoryInput && switchToSelectCategoryBtn) {
        testCategorySelect.addEventListener('change', function() {
            if (this.value === 'other_category') {
                testCategorySelectWrapper.classList.add('hidden');
                testCategoryManualWrapper.classList.remove('hidden');
                testCategoryInput.value = '';
                testCategoryInput.focus();
                testCategoryInput.required = true;
            } else {
                testCategoryInput.value = this.value;
                testCategoryInput.required = false;
            }
        });

        switchToSelectCategoryBtn.addEventListener('click', function() {
            testCategoryManualWrapper.classList.add('hidden');
            testCategorySelectWrapper.classList.remove('hidden');
            testCategorySelect.value = '';
            testCategoryInput.value = '';
            testCategoryInput.required = false;
        });
    }

    // File upload handling for add form
    const addFileInput = document.getElementById('add_file_attachment');
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

        // Validate file type
        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            showAddError('Invalid file type. Please select a PDF, JPG, JPEG, or PNG file.');
            addFileInput.value = '';
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
