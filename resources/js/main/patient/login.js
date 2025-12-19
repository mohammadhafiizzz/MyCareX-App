document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');
    const icNumberInput = document.getElementById('icNumber');
    const loginForm = document.querySelector('form');

    // Helper function to validate middle segment of IC
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

    // Password toggle functionality
    if (toggleButton && passwordIcon) {
        toggleButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'password') {
                passwordIcon.className = 'fas fa-eye text-gray-400 hover:text-gray-600 transition-colors';
            } else {
                passwordIcon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600 transition-colors';
            }
        });
    }

    // IC Number Formatting and Validation
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
                    icIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Digits 7-8 must be between 01 and 15</span>';
                }
            } else {
                icIndicator.classList.add('hidden');
            }
        });

        // Before form submission, set the raw value
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                if (icNumberInput.dataset.rawValue) {
                    icNumberInput.value = icNumberInput.dataset.rawValue;
                } else {
                    // If no raw value stored, clean the input
                    icNumberInput.value = icNumberInput.value.replace(/\D/g, '');
                }

                // Validate IC number on submit
                const icRaw = icNumberInput.value;
                const errors = [];

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
    }

    // Auto-hide error messages after 5 seconds
    const errorAlert = document.querySelector('.bg-red-50');
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 300);
        }, 5000);
    }
});
