document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add-doctor-form');
    const icInput = document.getElementById('ic_number');
    const phoneInput = document.getElementById('phone_number');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const profileImageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const removeImageBtn = document.getElementById('remove-image');
    const submitBtn = document.getElementById('submit-btn');

    // Password Toggle Functionality
    document.querySelectorAll('.toggle-password-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    // Helper to check middle segment of IC (01-15)
    function isMiddleSegmentValid(ic) {
        if (ic.length < 8) return true;
        const middle = parseInt(ic.substring(6, 8));
        return middle >= 1 && middle <= 15;
    }

    // IC Number Formatting and Validation
    if (icInput) {
        const icContainer = icInput.parentElement;
        const icIndicator = document.createElement('div');
        icIndicator.className = 'mt-1 text-xs hidden';
        icContainer.appendChild(icIndicator);

        icInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 12) value = value.slice(0, 12);
            
            let formatted = value;
            if (value.length > 6) formatted = value.slice(0, 6) + '-' + value.slice(6);
            if (value.length > 8) formatted = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8);
            
            e.target.value = formatted;
            e.target.dataset.rawValue = value;

            if (value.length > 0) {
                icIndicator.classList.remove('hidden');
                const lengthValid = value.length === 12;
                const middleValid = isMiddleSegmentValid(value);
                
                if (lengthValid && middleValid) {
                    icIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid IC number</span>';
                } else if (!lengthValid) {
                    icIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">IC number must be 12 digits.</span>';
                } else {
                    icIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Digits in the middle must be between 01 and 15</span>';
                }
            } else {
                icIndicator.classList.add('hidden');
            }
        });
    }

    // Phone Number Formatting
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) value = value.slice(0, 10);
            
            let formatted = value;
            if (value.length > 2) formatted = value.slice(0, 2) + '-' + value.slice(2);
            
            e.target.value = formatted;
            e.target.dataset.rawValue = value;
        });
    }

    // Password Validation (Matching registration.js)
    if (passwordInput) {
        const passwordContainer = passwordInput.parentElement.parentElement;
        const strengthIndicator = document.createElement('div');
        strengthIndicator.id = 'passwordStrength';
        strengthIndicator.className = 'mt-2 text-xs hidden';
        passwordContainer.appendChild(strengthIndicator);

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const errors = [];
            
            if (password.length < 8) errors.push('At least 8 characters');
            if (!/\d/.test(password)) errors.push('At least one number');
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                errors.push('At least one special character (e.g., -, _, $, etc.)');
            }
            
            if (password.length > 0) {
                strengthIndicator.classList.remove('hidden');
                if (errors.length === 0) {
                    strengthIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Strong password</span>';
                } else {
                    strengthIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Password must have: ' + errors.join(', ') + '</span>';
                }
            } else {
                strengthIndicator.classList.add('hidden');
            }
        });
    }

    // Password Match Validation
    if (passwordConfirmationInput && passwordInput) {
        const confirmContainer = passwordConfirmationInput.parentElement.parentElement;
        const matchIndicator = document.createElement('div');
        matchIndicator.id = 'passwordMatch';
        matchIndicator.className = 'mt-2 text-xs hidden';
        confirmContainer.appendChild(matchIndicator);

        const checkMatch = () => {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmationInput.value;
            
            if (confirmPassword.length > 0) {
                matchIndicator.classList.remove('hidden');
                if (password === confirmPassword) {
                    matchIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Passwords match</span>';
                } else {
                    matchIndicator.innerHTML = '<i class="fas fa-times-circle text-red-600 mr-1"></i><span class="text-red-600">Passwords do not match</span>';
                }
            } else {
                matchIndicator.classList.add('hidden');
            }
        };

        passwordConfirmationInput.addEventListener('input', checkMatch);
        passwordInput.addEventListener('input', checkMatch);
    }

    // Image Preview
    if (profileImageInput) {
        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) {
                    alert('Image size must be less than 5MB');
                    this.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                    uploadPlaceholder.classList.add('hidden');
                    removeImageBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function() {
            profileImageInput.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
        });
    }

    // Form Submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmationInput.value;
        const clientErrors = [];

        // Client-side validation (matching registration.js logic)
        if (password.length < 8) clientErrors.push('Password must be at least 8 characters long');
        if (!/\d/.test(password)) clientErrors.push('Password must contain at least one number');
        if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) clientErrors.push('Password must contain at least one special character');
        if (password !== confirmPassword) clientErrors.push('Passwords do not match');

        const icRaw = icInput.dataset.rawValue || icInput.value.replace(/\D/g, '');
        if (icRaw.length !== 12) {
            clientErrors.push('IC number must be 12 digits');
        } else if (!isMiddleSegmentValid(icRaw)) {
            clientErrors.push('Digits 7-8 of the IC number must be between 01 and 15');
        }

        if (clientErrors.length > 0) {
            alert('Please fix the following errors:\n\n' + clientErrors.join('\n'));
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

        const formData = new FormData(this);
        
        // Use raw values
        if (icInput.dataset.rawValue) formData.set('ic_number', icInput.dataset.rawValue);
        if (phoneInput.dataset.rawValue) formData.set('phone_number', phoneInput.dataset.rawValue);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Register Doctor</span><i class="fas fa-check text-xs"></i>';
                
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(`error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                    const firstError = document.querySelector('[id^="error-"]:not(.hidden)');
                    if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Register Doctor</span><i class="fas fa-check text-xs"></i>';
            alert('An error occurred. Please try again.');
        });
    });
});
