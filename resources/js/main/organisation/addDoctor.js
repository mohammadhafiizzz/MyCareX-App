document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-doctor-form');
    const submitBtn = document.getElementById('submit-btn');
    
    // Input Elements
    const inputs = {
        full_name: document.getElementById('full_name'),
        ic_number: document.getElementById('ic_number'),
        email: document.getElementById('email'),
        phone_number: document.getElementById('phone_number'),
        medical_license_number: document.getElementById('medical_license_number'),
        specialisation: document.getElementById('specialisation'),
        password: document.getElementById('password'),
        password_confirmation: document.getElementById('password_confirmation'),
        profile_image: document.getElementById('profile_image')
    };

    // Error Elements
    const errors = {
        full_name: document.getElementById('error-full_name'),
        ic_number: document.getElementById('error-ic_number'),
        email: document.getElementById('error-email'),
        phone_number: document.getElementById('error-phone_number'),
        medical_license_number: document.getElementById('error-medical_license_number'),
        specialisation: document.getElementById('error-specialisation'),
        password: document.getElementById('error-password'),
        password_confirmation: document.getElementById('error-password_confirmation')
    };

    // Validation State
    const validationState = {
        full_name: false,
        ic_number: false,
        email: false,
        phone_number: false,
        medical_license_number: false,
        specialisation: false,
        password: false,
        password_confirmation: false
    };

    // Helper: Show Error
    const showError = (field, message) => {
        if (errors[field]) {
            errors[field].textContent = message;
            errors[field].classList.remove('hidden');
            inputs[field].classList.add('border-red-500', 'bg-red-50/30');
            inputs[field].classList.remove('border-gray-200', 'bg-gray-50/50');
        }
        validationState[field] = false;
        updateSubmitButton();
    };

    // Helper: Hide Error
    const hideError = (field) => {
        if (errors[field]) {
            errors[field].classList.add('hidden');
            inputs[field].classList.remove('border-red-500', 'bg-red-50/30');
            inputs[field].classList.add('border-gray-200', 'bg-gray-50/50');
        }
        validationState[field] = true;
        updateSubmitButton();
    };

    // Update Submit Button State
    const updateSubmitButton = () => {
        const isValid = Object.values(validationState).every(state => state === true);
        submitBtn.disabled = !isValid;
    };

    // 1. Full Name Validation
    inputs.full_name.addEventListener('input', function() {
        const val = this.value.trim();
        if (val.length < 3) {
            showError('full_name', 'Full name must be at least 3 characters.');
        } else {
            hideError('full_name');
        }
    });

    // 2. IC Number Validation & Formatting
    inputs.ic_number.addEventListener('input', function(e) {
        let val = this.value.replace(/\D/g, '');
        
        // Formatting: 950101-01-5678
        if (val.length > 6 && val.length <= 8) {
            val = val.slice(0, 6) + '-' + val.slice(6);
        } else if (val.length > 8) {
            val = val.slice(0, 6) + '-' + val.slice(6, 8) + '-' + val.slice(8, 12);
        }
        this.value = val;

        const rawVal = val.replace(/-/g, '');
        if (rawVal.length !== 12) {
            showError('ic_number', 'IC Number must be exactly 12 digits.');
        } else {
            // Middle segment validation (01-15)
            const middle = parseInt(rawVal.slice(6, 8));
            if (middle < 1 || middle > 15) {
                showError('ic_number', 'Invalid IC Number (State code error).');
            } else {
                hideError('ic_number');
            }
        }
    });

    // 3. Email Validation
    inputs.email.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.value)) {
            showError('email', 'Please enter a valid email address.');
        } else {
            hideError('email');
        }
    });

    // 4. Phone Number Validation & Formatting
    inputs.phone_number.addEventListener('input', function() {
        let val = this.value.replace(/\D/g, '');
        
        // Formatting: 12-3456789
        if (val.length > 2) {
            val = val.slice(0, 2) + '-' + val.slice(2, 10);
        }
        this.value = val;

        const rawVal = val.replace(/-/g, '');
        if (rawVal.length < 9 || rawVal.length > 10) {
            showError('phone_number', 'Phone number must be 9-10 digits.');
        } else {
            hideError('phone_number');
        }
    });

    // 5. Medical License Validation
    inputs.medical_license_number.addEventListener('input', function() {
        if (this.value.trim().length < 3) {
            showError('medical_license_number', 'Please enter a valid MMC number.');
        } else {
            hideError('medical_license_number');
        }
    });

    // 6. Specialisation Validation
    inputs.specialisation.addEventListener('change', function() {
        if (!this.value) {
            showError('specialisation', 'Please select a specialisation.');
        } else {
            hideError('specialisation');
        }
    });

    // 7. Password Strength & Validation
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    const strengthContainer = document.getElementById('password-strength');

    inputs.password.addEventListener('input', function() {
        const val = this.value;
        strengthContainer.classList.remove('hidden');
        
        let strength = 0;
        if (val.length >= 8) strength++;
        if (/[A-Z]/.test(val)) strength++;
        if (/[0-9]/.test(val)) strength++;
        if (/[^A-Za-z0-9]/.test(val)) strength++;

        const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500'];
        const texts = ['Weak', 'Fair', 'Good', 'Strong'];
        
        strengthBar.className = 'h-full transition-all duration-500 ' + (colors[strength-1] || 'bg-gray-200');
        strengthBar.style.width = (strength * 25) + '%';
        strengthText.textContent = texts[strength-1] || 'Too Short';
        strengthText.className = 'text-[10px] font-medium uppercase tracking-wider ' + (strength > 2 ? 'text-green-600' : 'text-red-600');

        if (strength < 3) {
            showError('password', 'Password must be at least 8 characters with letters, numbers and symbols.');
        } else {
            hideError('password');
        }

        // Re-validate confirmation
        if (inputs.password_confirmation.value) {
            validateConfirmation();
        }
    });

    // 8. Password Confirmation
    const validateConfirmation = () => {
        if (inputs.password_confirmation.value !== inputs.password.value) {
            showError('password_confirmation', 'Passwords do not match.');
        } else {
            hideError('password_confirmation');
        }
    };

    inputs.password_confirmation.addEventListener('input', validateConfirmation);

    // 9. Profile Image Handling
    const imagePreview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('upload-placeholder');
    const removeBtn = document.getElementById('remove-image');
    const imageError = document.getElementById('image-error');

    inputs.profile_image.addEventListener('change', function(e) {
        const file = e.target.files[0];
        imageError.classList.add('hidden');

        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                imageError.textContent = 'File size exceeds 2MB.';
                imageError.classList.remove('hidden');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                removeBtn.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    removeBtn.addEventListener('click', function() {
        inputs.profile_image.value = '';
        imagePreview.src = '';
        imagePreview.classList.add('hidden');
        placeholder.classList.remove('hidden');
        this.classList.add('hidden');
    });

    // Initial validation check
    updateSubmitButton();

    // Form Submission
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Registering...</span>
        `;
    });
});
