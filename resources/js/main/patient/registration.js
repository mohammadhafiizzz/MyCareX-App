document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const fullNameInput = document.getElementById('full_name');
    const icNumberInput = document.getElementById('ic_number');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const registrationForm = document.querySelector('form');
    const emailInput = document.getElementById('email');

    const isMiddleSegmentValid = (value) => {
        if (value.length < 8) {
            return false;
        }
        const segment = value.slice(6, 8);
        if (!/^\d{2}$/.test(segment)) {
            return false;
        }
        const numericValue = parseInt(segment, 10);
        return numericValue >= 1 && numericValue <= 15;
    };

    // Full Name - Auto uppercase
    if (fullNameInput) {
        fullNameInput.addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
    }

    // Email Validation
    if (emailInput) {
        // Create email validation indicator
        const emailContainer = emailInput.parentElement;
        const emailIndicator = document.createElement('div');
        emailIndicator.id = 'emailValidation';
        emailIndicator.className = 'mt-2 text-xs hidden';
        emailContainer.appendChild(emailIndicator);

        emailInput.addEventListener('input', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email.length > 0) {
                emailIndicator.classList.remove('hidden');
                if (emailRegex.test(email)) {
                    emailIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid email address</span>';
                } else {
                    emailIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Please enter a valid email address</span>';
                }
            } else {
                emailIndicator.classList.add('hidden');
            }
        });
    }

    // IC Number Formatting
    if (icNumberInput) {
        // Create IC number validation indicator
        const icContainer = icNumberInput.parentElement;
        const icIndicator = document.createElement('div');
        icIndicator.id = 'icValidation';
        icIndicator.className = 'mt-2 text-xs hidden';
        icContainer.appendChild(icIndicator);

        icNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            
            // Limit to 12 digits
            if (value.length > 12) {
                value = value.slice(0, 12);
            }
            
            // Format as XXXXXX-XX-XXXX
            let formatted = value;
            if (value.length > 6) {
                formatted = value.slice(0, 6) + '-' + value.slice(6);
            }
            if (value.length > 8) {
                formatted = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8);
            }
            
            e.target.value = formatted;
            
            // Store the raw value in a data attribute
            e.target.dataset.rawValue = value;

            // Validate IC number
            const lengthValid = value.length === 12;
            const middleValid = isMiddleSegmentValid(value);
            if (value.length > 0) {
                icIndicator.classList.remove('hidden');
                if (lengthValid && middleValid) {
                    icIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid IC number</span>';
                } else if (!lengthValid) {
                    icIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">IC number must be 12 digits (' + value.length + '/12)</span>';
                } else {
                    icIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Digits in the middle must be between 01 and 15</span>';
                }
            } else {
                icIndicator.classList.add('hidden');
            }
        });

        // Before form submission, set the raw value
        registrationForm.addEventListener('submit', function(e) {
            if (icNumberInput.dataset.rawValue) {
                icNumberInput.value = icNumberInput.dataset.rawValue;
            }
        });
    }

    // Password Toggle Functionality
    const togglePassword = document.getElementById('togglePassword');
    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordIcon = document.getElementById('passwordIcon');
    const passwordConfirmationIcon = document.getElementById('passwordConfirmationIcon');

    if (togglePassword && passwordIcon) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle icon
            if (type === 'text') {
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        });
    }

    if (togglePasswordConfirmation && passwordConfirmationIcon) {
        togglePasswordConfirmation.addEventListener('click', function() {
            const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationInput.setAttribute('type', type);
            
            // Toggle icon
            if (type === 'text') {
                passwordConfirmationIcon.classList.remove('fa-eye');
                passwordConfirmationIcon.classList.add('fa-eye-slash');
            } else {
                passwordConfirmationIcon.classList.remove('fa-eye-slash');
                passwordConfirmationIcon.classList.add('fa-eye');
            }
        });
    }

    // Password Validation
    if (passwordInput) {
        // Create password strength indicator
        const passwordContainer = passwordInput.parentElement;
        const outerPasswordContainer = passwordContainer.parentElement;
        const strengthIndicator = document.createElement('div');
        strengthIndicator.id = 'passwordStrength';
        strengthIndicator.className = 'mt-2 text-xs hidden';
        outerPasswordContainer.appendChild(strengthIndicator);

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const errors = [];
            
            // Check minimum length
            if (password.length < 8) {
                errors.push('At least 8 characters');
            }
            
            // Check for at least one number
            if (!/\d/.test(password)) {
                errors.push('At least one number');
            }
            
            // Check for at least one special character
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                errors.push('At least one special character (e.g., -, _, $, etc.)');
            }
            
            // Display validation feedback
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
        const confirmContainer = passwordConfirmationInput.parentElement;
        const outerConfirmContainer = confirmContainer.parentElement;
        const matchIndicator = document.createElement('div');
        matchIndicator.id = 'passwordMatch';
        matchIndicator.className = 'mt-2 text-xs hidden';
        outerConfirmContainer.appendChild(matchIndicator);

        passwordConfirmationInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;
            
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
        });

        // Also check when password field changes
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const confirmPassword = passwordConfirmationInput.value;
            
            if (confirmPassword.length > 0) {
                matchIndicator.classList.remove('hidden');
                if (password === confirmPassword) {
                    matchIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Passwords match</span>';
                } else {
                    matchIndicator.innerHTML = '<i class="fas fa-times-circle text-red-600 mr-1"></i><span class="text-red-600">Passwords do not match</span>';
                }
            }
        });
    }

    // Form Validation on Submit
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmationInput.value;
            const errors = [];

            // Validate password
            if (password.length < 8) {
                errors.push('Password must be at least 8 characters long');
            }
            if (!/\d/.test(password)) {
                errors.push('Password must contain at least one number');
            }
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
                errors.push('Password must contain at least one special character');
            }
            if (password !== confirmPassword) {
                errors.push('Passwords do not match');
            }

            // Validate IC number
            const icRaw = icNumberInput.dataset.rawValue || icNumberInput.value.replace(/\D/g, '');
            if (icRaw.length !== 12) {
                errors.push('IC number must be 12 digits');
            } else if (!isMiddleSegmentValid(icRaw)) {
                errors.push('Digits 7-8 of the IC number must be between 01 and 15');
            }

            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
        });
    }
});
