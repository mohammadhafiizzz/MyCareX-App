// Patient Profile JavaScript Functions - Complete File

// Modal Elements
const editPersonalModal = document.getElementById('editPersonalInfo');
const editPersonalModalContent = document.getElementById('editPersonalInfoContent');

// Profile Picture Upload Modal Function
window.openProfilePictureModal = function () {
    showModal('profilePictureModal', 'profilePictureModalContent');
    setupImageUpload();
}

// Personal Information Modal Function
window.editPersonalInfo = function () {
    showModal('editPersonalInfo', 'editPersonalInfoContent');
    setupEditPersonalFormListeners();
}

// Physical Information Modal Function
function editPhysicalInfo() {
    showModal('editPhysicalInfo', 'editPhysicalInfoContent');
}

// Address Information Modal Function
function editAddressInfo() {
    showModal('editAddressInfo', 'editAddressInfoContent');
}

// Emergency Contact Modal Function
function editEmergencyInfo() {
    showModal('editEmergencyInfo', 'editEmergencyInfoContent');
    setupEditEmergencyFormListeners();
}

// Change Password Modal Function
function changePassword() {
    showModal('changePasswordModal', 'changePasswordModalContent');
}

// Delete Account Modal Function
function deleteAccount() {
    showModal('deleteAccountModal', 'deleteAccountModalContent');
}

// Generic Modal Functions
function showModal(modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);

    if (modal && modalContent) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }
}

// Make closeModal globally accessible
window.closeModal = function (modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);

    if (modal && modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

// Personal Information Form Event Listeners
function setupEditPersonalFormListeners() {
    const editRaceSelect = document.getElementById('edit_race');
    const editOtherRaceInput = document.getElementById('edit_other_race');

    if (editRaceSelect && editOtherRaceInput) {
        editRaceSelect.addEventListener('change', function () {
            if (this.value === 'Other') {
                editOtherRaceInput.classList.remove('hidden');
                editOtherRaceInput.required = true;
            } else {
                editOtherRaceInput.classList.add('hidden');
                editOtherRaceInput.required = false;
                editOtherRaceInput.value = '';
            }
        });
    }
}

// Emergency Contact Form Event Listeners
function setupEditEmergencyFormListeners() {
    const editRelationshipSelect = document.getElementById('edit_emergency_contact_relationship');
    const editOtherRelationshipInput = document.getElementById('edit_other_emergency_relationship');

    if (editRelationshipSelect && editOtherRelationshipInput) {
        editRelationshipSelect.addEventListener('change', function () {
            if (this.value === 'Other') {
                editOtherRelationshipInput.classList.remove('hidden');
                editOtherRelationshipInput.required = true;
            } else {
                editOtherRelationshipInput.classList.add('hidden');
                editOtherRelationshipInput.required = false;
                editOtherRelationshipInput.value = '';
            }
        });
    }
}

// Password Visibility Toggle Function
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

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

// Profile Picture Upload Functions
function setupImageUpload() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('profileImageInput');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const uploadBtn = document.getElementById('uploadBtn');

    if (!dropZone || !fileInput) return;

    // File input change handler
    fileInput.addEventListener('change', function (e) {
        handleFileSelect(e.target.files[0]);
    });

    // Drag and drop handlers
    dropZone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', function (e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        handleFileSelect(e.dataTransfer.files[0]);
    });

    function handleFileSelect(file) {
        if (!file) return;

        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select a valid image file.');
            return;
        }

        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB.');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function (e) {
            if (previewImage && fileName && uploadPrompt && imagePreview && uploadBtn) {
                previewImage.src = e.target.result;
                fileName.textContent = file.name;
                uploadPrompt.classList.add('hidden');
                imagePreview.classList.remove('hidden');
                uploadBtn.disabled = false;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removePreview() {
    const fileInput = document.getElementById('profileImageInput');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const imagePreview = document.getElementById('imagePreview');
    const uploadBtn = document.getElementById('uploadBtn');

    if (fileInput && uploadPrompt && imagePreview && uploadBtn) {
        fileInput.value = '';
        uploadPrompt.classList.remove('hidden');
        imagePreview.classList.add('hidden');
        uploadBtn.disabled = true;
    }
}

// Main Event Listeners Setup
function setupModalEventListeners() {
    const modals = [
        { modalId: 'editPersonalInfo', contentId: 'editPersonalInfoContent' },
        { modalId: 'editPhysicalInfo', contentId: 'editPhysicalInfoContent' },
        { modalId: 'editAddressInfo', contentId: 'editAddressInfoContent' },
        { modalId: 'editEmergencyInfo', contentId: 'editEmergencyInfoContent' },
        { modalId: 'changePasswordModal', contentId: 'changePasswordModalContent' },
        { modalId: 'deleteAccountModal', contentId: 'deleteAccountModalContent' },
        { modalId: 'profilePictureModal', contentId: 'profilePictureModalContent' }
    ];

    modals.forEach(({ modalId, contentId }) => {
        const modal = document.getElementById(modalId);
        const closeBtn = document.getElementById(`close${modalId}`);

        if (modal) {
            // Close modal on backdrop click
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeModal(modalId, contentId);
                }
            });
        }

        // Close modal on close button click
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                closeModal(modalId, contentId);
            });
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            modals.forEach(({ modalId, contentId }) => {
                const modal = document.getElementById(modalId);
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal(modalId, contentId);
                }
            });
        }
    });
}

// Form Validation Functions
function validatePasswordMatch() {
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('new_password_confirmation');

    if (newPassword && confirmPassword) {
        confirmPassword.addEventListener('input', function () {
            if (this.value && newPassword.value && this.value !== newPassword.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        newPassword.addEventListener('input', function () {
            if (confirmPassword.value && this.value && confirmPassword.value !== this.value) {
                confirmPassword.setCustomValidity('Passwords do not match');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    }
}

// IC Number Formatting for Emergency Contact
function formatEmergencyIcNumber() {
    const icInput = document.getElementById('edit_emergency_contact_ic_number');

    if (icInput) {
        let isDeleting = false;

        icInput.addEventListener('keydown', function (e) {
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        icInput.addEventListener('input', function (e) {
            if (isDeleting) return;

            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = value.substring(0, 6);
                if (value.length >= 6) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                if (value.length >= 8) {
                    formattedValue += '-' + value.substring(8, 12);
                }
            }

            e.target.value = formattedValue;
        });
    }
}

// Phone Number Formatting for Emergency Contact
function formatEmergencyPhoneNumber() {
    const phoneInput = document.getElementById('edit_emergency_contact_number');

    if (phoneInput) {
        let isDeleting = false;

        phoneInput.addEventListener('keydown', function (e) {
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        phoneInput.addEventListener('input', function (e) {
            if (isDeleting) return;

            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';

            if (value.length === 0) return;

            if (value.startsWith('011')) {
                // Format: 011-XXXX XXXX
                formattedValue = '011';
                if (value.length > 3) {
                    formattedValue += '-' + value.substring(3, 7);
                }
                if (value.length > 7) {
                    formattedValue += ' ' + value.substring(7, 11);
                }
            }
            else if (value.startsWith('01')) {
                // Format: 01X-XXX XXXX  
                formattedValue = value.substring(0, 3);
                if (value.length > 3) {
                    formattedValue += '-' + value.substring(3, 6);
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10);
                }
            }
            else if (value.startsWith('0')) {
                // Landline format: 0X-XXXX XXXX
                formattedValue = value.substring(0, 2);
                if (value.length > 2) {
                    formattedValue += '-' + value.substring(2, 6);
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10);
                }
            }
            else {
                // International or other
                formattedValue = value;
            }

            e.target.value = formattedValue;
        });
    }
}

// BMI Calculator for Physical Info
function setupBMICalculator() {
    const heightInput = document.getElementById('edit_height');
    const weightInput = document.getElementById('edit_weight');

    if (heightInput && weightInput) {
        function calculateBMI() {
            const height = parseFloat(heightInput.value);
            const weight = parseFloat(weightInput.value);

            if (height && weight && height > 0 && weight > 0) {
                const heightInMeters = height / 100;
                const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);

                // You can display the calculated BMI somewhere if needed
                console.log('Calculated BMI:', bmi);
            }
        }

        heightInput.addEventListener('input', calculateBMI);
        weightInput.addEventListener('input', calculateBMI);
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function () {
    console.log('Patient Profile page loaded');

    // Setup all event listeners
    setupModalEventListeners();
    validatePasswordMatch();
    formatEmergencyIcNumber();
    formatEmergencyPhoneNumber();
    setupBMICalculator();

    // Make functions globally accessible
    window.togglePasswordVisibility = togglePasswordVisibility;
    window.removePreview = removePreview;
    window.editPhysicalInfo = editPhysicalInfo;
    window.editAddressInfo = editAddressInfo;
    window.editEmergencyInfo = editEmergencyInfo;
    window.changePassword = changePassword;
    window.deleteAccount = deleteAccount;
});

// Additional utility functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;

    // Set notification type styling
    switch (type) {
        case 'success':
            notification.className += ' bg-green-500 text-white';
            break;
        case 'error':
            notification.className += ' bg-red-500 text-white';
            break;
        case 'warning':
            notification.className += ' bg-yellow-500 text-white';
            break;
        default:
            notification.className += ' bg-blue-500 text-white';
    }

    notification.innerHTML = `
        <div class="flex items-center space-x-2">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Show notification
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Auto hide after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    }, 5000);
}

// Export functions for use in other files if needed
window.PatientProfile = {
    showModal,
    closeModal,
    showNotification,
    togglePasswordVisibility,
    openProfilePictureModal,
    editPersonalInfo,
    editPhysicalInfo,
    editAddressInfo,
    editEmergencyInfo,
    changePassword,
    deleteAccount
};