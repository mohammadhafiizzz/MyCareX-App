document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');
    const icNumberInput = document.getElementById('icNumber');
    const emailInput = document.getElementById('email');
    const staffIdInput = document.getElementById('staffId');
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

    // Email Validation (for Doctor and Provider login)
    if (emailInput) {
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

    // Staff ID Validation (for Admin login)
    if (staffIdInput) {
        const staffIdContainer = staffIdInput.parentElement;
        const staffIdIndicator = document.createElement('div');
        staffIdIndicator.id = 'staffIdValidation';
        staffIdIndicator.className = 'mt-2 text-xs hidden';
        staffIdContainer.appendChild(staffIdIndicator);

        staffIdInput.addEventListener('input', function() {
            let value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            // Limit to 8 characters
            if (value.length > 8) {
                value = value.substring(0, 8);
            }

            this.value = value;

            // Validate Staff ID format (MCX followed by numbers)
            const staffIdRegex = /^MCX\d{1,5}$/;
            const isValidFormat = staffIdRegex.test(value);

            if (value.length > 0) {
                staffIdIndicator.classList.remove('hidden');
                if (isValidFormat) {
                    staffIdIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid Staff ID format</span>';
                } else if (!value.startsWith('MCX')) {
                    staffIdIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Staff ID must start with MCX</span>';
                } else if (value.length < 4) {
                    staffIdIndicator.innerHTML = '<i class="fas fa-info-circle text-gray-600 mr-1"></i><span class="text-gray-600">Enter Staff ID (e.g., MCX12345)</span>';
                } else {
                    staffIdIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Invalid Staff ID format (must be MCX followed by numbers)</span>';
                }
            } else {
                staffIdIndicator.classList.add('hidden');
            }
        });
    }

    // IC Number Formatting and Validation (for Patient login)
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
    }

    // Searchable Dropdown for Healthcare Provider
    const providerSearch = document.getElementById('provider_search');
    const providerList = document.getElementById('provider_list');
    const providerIdInput = document.getElementById('provider_id');
    const providerOptions = document.querySelectorAll('.provider-option');
    const noProviderFound = document.getElementById('no-provider-found');

    if (providerSearch && providerList) {
        // Initialize if old value exists
        if (providerIdInput.value) {
            const selectedOption = Array.from(providerOptions).find(opt => opt.dataset.id === providerIdInput.value);
            if (selectedOption) {
                providerSearch.value = selectedOption.dataset.name;
            }
        }

        // Show list on focus
        providerSearch.addEventListener('focus', () => {
            providerList.classList.remove('hidden');
        });

        // Filter list on input
        providerSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            let hasResults = false;

            providerOptions.forEach(option => {
                const name = option.dataset.name.toLowerCase();
                if (name.includes(searchTerm)) {
                    option.classList.remove('hidden');
                    hasResults = true;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (hasResults) {
                noProviderFound.classList.add('hidden');
            } else {
                noProviderFound.classList.remove('hidden');
            }
            
            // Clear ID if input is cleared or changed manually
            if (this.value === '') {
                providerIdInput.value = '';
            }
        });

        // Select option
        providerOptions.forEach(option => {
            option.addEventListener('click', function() {
                providerSearch.value = this.dataset.name;
                providerIdInput.value = this.dataset.id;
                providerList.classList.add('hidden');
            });
        });

        // Close list when clicking outside
        document.addEventListener('click', function(e) {
            if (!providerSearch.contains(e.target) && !providerList.contains(e.target)) {
                providerList.classList.add('hidden');
            }
        });
    }

    // Form Validation on Submit
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const errors = [];

            // Validate Provider (Doctor login)
            if (providerIdInput) {
                if (providerIdInput.value === '') {
                    errors.push('Please select a healthcare institution');
                }
            }

            // Validate IC Number (Patient login)
            if (icNumberInput) {
                const icRaw = icNumberInput.dataset.rawValue || icNumberInput.value.replace(/\D/g, '');
                
                if (icRaw.length === 0) {
                    errors.push('IC number is required');
                } else if (icRaw.length !== 12) {
                    errors.push('IC number must be 12 digits');
                } else if (!isMiddleSegmentValid(icRaw)) {
                    errors.push('Digits 7-8 of the IC number must be between 01 and 15');
                }

                // Set raw value before submission
                if (icNumberInput.dataset.rawValue) {
                    icNumberInput.value = icNumberInput.dataset.rawValue;
                }
            }

            // Validate Email (Doctor/Provider login)
            if (emailInput) {
                const email = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email.length === 0) {
                    errors.push('Email address is required');
                } else if (!emailRegex.test(email)) {
                    errors.push('Please enter a valid email address');
                }
            }

            // Validate Staff ID (Admin login)
            if (staffIdInput) {
                const staffId = staffIdInput.value.trim();
                const staffIdRegex = /^MCX\d{1,5}$/;

                if (staffId.length === 0) {
                    errors.push('Staff ID is required');
                } else if (!staffIdRegex.test(staffId)) {
                    errors.push('Staff ID must be in format MCX##### (e.g., MCX12345)');
                }
            }

            // Validate Password (all login types)
            if (passwordInput && passwordInput.value.length === 0) {
                errors.push('Password is required');
            }

            // Show errors if any
            if (errors.length > 0) {
                e.preventDefault();
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
        });
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
