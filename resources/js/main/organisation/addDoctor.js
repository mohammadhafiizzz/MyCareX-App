// Toggle Password Visibility
function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// IC Number Formatting
document.getElementById('ic_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 6 && value.length <= 8) {
        value = value.slice(0, 6) + '-' + value.slice(6);
    } else if (value.length > 8) {
        value = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8, 12);
    }
    e.target.value = value;
});

// Phone Number Formatting
document.getElementById('phone_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length > 3 && value.length <= 10) {
        value = value.slice(0, 3) + '-' + value.slice(3);
    } else if (value.length > 10) {
        value = value.slice(0, 3) + '-' + value.slice(3, 10);
    }
    e.target.value = value;
});

// File Upload Handling
const fileInput = document.getElementById('profile_image');
const fileDropArea = document.getElementById('fileDropArea');
const fileDropContent = document.getElementById('fileDropContent');
const filePreview = document.getElementById('filePreview');
const imagePreview = document.getElementById('imagePreview');
const fileName = document.getElementById('fileName');
const fileSize = document.getElementById('fileSize');
const removeFileBtn = document.getElementById('removeFile');
const uploadError = document.getElementById('uploadError');
const uploadErrorMessage = document.getElementById('uploadErrorMessage');

// Click to upload
fileDropArea.addEventListener('click', (e) => {
    if (!e.target.closest('#removeFile')) {
        fileInput.click();
    }
});

// Drag and drop events
fileDropArea.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileDropArea.classList.add('border-blue-400', 'bg-blue-50/50');
});

fileDropArea.addEventListener('dragleave', () => {
    fileDropArea.classList.remove('border-blue-400', 'bg-blue-50/50');
});

fileDropArea.addEventListener('drop', (e) => {
    e.preventDefault();
    fileDropArea.classList.remove('border-blue-400', 'bg-blue-50/50');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect(files[0]);
    }
});

// File input change
fileInput.addEventListener('change', (e) => {
    if (e.target.files.length > 0) {
        handleFileSelect(e.target.files[0]);
    }
});

// Remove file button
removeFileBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    fileInput.value = '';
    fileDropContent.classList.remove('hidden');
    filePreview.classList.add('hidden');
    uploadError.classList.add('hidden');
});

// Handle file selection
function handleFileSelect(file) {
    uploadError.classList.add('hidden');

    // Validate file type
    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!validTypes.includes(file.type)) {
        uploadErrorMessage.textContent = 'Invalid file type. Please upload JPG or PNG only.';
        uploadError.classList.remove('hidden');
        fileInput.value = '';
        return;
    }

    // Validate file size (2MB)
    const maxSize = 2 * 1024 * 1024;
    if (file.size > maxSize) {
        uploadErrorMessage.textContent = 'File size exceeds 2MB. Please choose a smaller file.';
        uploadError.classList.remove('hidden');
        fileInput.value = '';
        return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileDropContent.classList.add('hidden');
        filePreview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Form submission handling
const form = document.getElementById('add-doctor-form');
const submitButton = document.getElementById('save-doctor-button');
const buttonText = document.getElementById('save-button-text');
const spinner = submitButton.querySelector('svg');

form.addEventListener('submit', function(e) {
    // Show loading state
    submitButton.disabled = true;
    spinner.classList.remove('hidden');
    buttonText.textContent = 'Adding...';
});

// Make togglePasswordVisibility available globally
window.togglePasswordVisibility = togglePasswordVisibility;
