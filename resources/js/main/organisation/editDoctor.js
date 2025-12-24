document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-doctor-form');
    const icInput = document.getElementById('ic_number');
    const phoneInput = document.getElementById('phone_number');
    const emailInput = document.getElementById('email');
    const profileImageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('upload-placeholder');
    const removeImageBtn = document.getElementById('remove-image');
    const submitBtn = document.getElementById('submit-btn');

    const isMiddleSegmentValid = (value) => {
        if (value.length < 8) return false;
        const segment = value.slice(6, 8);
        if (!/^\d{2}$/.test(segment)) return false;
        const numericValue = parseInt(segment, 10);
        return numericValue >= 1 && numericValue <= 15;
    };

    // IC Number Formatting and Validation
    if (icInput) {
        const icContainer = icInput.parentElement;
        const icIndicator = document.createElement('div');
        icIndicator.id = 'icValidation';
        icIndicator.className = 'mt-2 text-xs hidden';
        icContainer.appendChild(icIndicator);

        const formatIC = (val) => {
            let value = val.replace(/\D/g, '');
            if (value.length > 12) value = value.slice(0, 12);
            
            let formatted = value;
            if (value.length > 6) formatted = value.slice(0, 6) + '-' + value.slice(6);
            if (value.length > 8) formatted = value.slice(0, 6) + '-' + value.slice(6, 8) + '-' + value.slice(8);
            return { formatted, raw: value };
        };

        // Initial format
        const initial = formatIC(icInput.value);
        icInput.value = initial.formatted;
        icInput.dataset.rawValue = initial.raw;

        icInput.addEventListener('input', function(e) {
            const { formatted, raw } = formatIC(e.target.value);
            e.target.value = formatted;
            e.target.dataset.rawValue = raw;

            if (raw.length > 0) {
                icIndicator.classList.remove('hidden');
                const lengthValid = raw.length === 12;
                const middleValid = isMiddleSegmentValid(raw);
                
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

    // Email Validation
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

    // Phone Number Formatting and Validation
    if (phoneInput) {
        const phoneContainer = phoneInput.parentElement;
        const phoneIndicator = document.createElement('div');
        phoneIndicator.id = 'phoneValidation';
        phoneIndicator.className = 'mt-2 text-xs hidden';
        phoneContainer.appendChild(phoneIndicator);

        const formatPhone = (val) => {
            const rawDigits = val.replace(/\D/g, '');
            let localNumber = rawDigits;
            
            if (rawDigits.startsWith('60')) {
                localNumber = '0' + rawDigits.slice(2);
            } else if (rawDigits.length > 0 && !rawDigits.startsWith('0')) {
                localNumber = '0' + rawDigits;
            }

            if (localNumber.length > 0 && !localNumber.startsWith('01')) {
                localNumber = '01' + localNumber.replace(/^0+/, '');
            }

            const digitsWithoutZero = localNumber.slice(1);
            const prefix = digitsWithoutZero.slice(0, 2);
            const isSpecialPrefix = prefix === '11' || prefix === '15';
            const value = digitsWithoutZero.slice(0, isSpecialPrefix ? 10 : 9);

            let formatted = '';
            if (value.length > 0) {
                formatted = '+60 ' + value.slice(0, 2);
                if (isSpecialPrefix) {
                    if (value.length > 2) formatted += '-' + value.slice(2, 6);
                    if (value.length > 6) formatted += '-' + value.slice(6, 10);
                } else {
                    if (value.length > 2) formatted += '-' + value.slice(2, 5);
                    if (value.length > 5) formatted += ' ' + value.slice(5, 9);
                }
            }

            return { formatted, raw: value };
        };

        // Initial format
        const initial = formatPhone(phoneInput.value);
        phoneInput.value = initial.formatted;
        phoneInput.dataset.rawValue = initial.raw;

        phoneInput.addEventListener('input', function(e) {
            const { formatted, raw } = formatPhone(e.target.value);
            e.target.value = formatted;
            e.target.dataset.rawValue = raw;

            const digitsOnly = raw;
            const prefix = digitsOnly.slice(0, 2);
            const validPrefixes = ['11', '12', '13', '14', '15', '16', '17', '18', '19'];
            const isPrefixValid = validPrefixes.includes(prefix);
            const isSpecialPrefix = prefix === '11' || prefix === '15';
            const requiredLength = isSpecialPrefix ? 10 : 9;
            const isLengthValid = digitsOnly.length === requiredLength;

            if (digitsOnly.length > 0) {
                phoneIndicator.classList.remove('hidden');
                if (isPrefixValid && isLengthValid) {
                    phoneIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600">Valid phone number</span>';
                } else {
                    phoneIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600">Please enter a valid phone number.</span>';
                }
            } else {
                phoneIndicator.classList.add('hidden');
            }
        });
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
                    if (uploadPlaceholder) uploadPlaceholder.classList.add('hidden');
                    removeImageBtn.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        removeImageBtn.addEventListener('click', function() {
            profileImageInput.value = '';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            if (uploadPlaceholder) uploadPlaceholder.classList.remove('hidden');
            removeImageBtn.classList.add('hidden');
        });
    }

    // Form Submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        document.querySelectorAll('[id^="error-"]').forEach(el => el.classList.add('hidden'));
        
        const clientErrors = [];

        // IC Validation
        const icRaw = icInput.dataset.rawValue || icInput.value.replace(/\D/g, '');
        if (icRaw.length !== 12) {
            clientErrors.push('IC number must be 12 digits');
        } else if (!isMiddleSegmentValid(icRaw)) {
            clientErrors.push('Digits 7-8 of the IC number must be between 01 and 15');
        }

        // Email Validation
        const email = emailInput.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            clientErrors.push('Please enter a valid email address');
        }

        // Phone Validation
        const phoneRaw = phoneInput.dataset.rawValue || '';
        const digitsOnly = phoneRaw;
        const prefix = digitsOnly.slice(0, 2);
        const validPrefixes = ['11', '12', '13', '14', '15', '16', '17', '18', '19'];
        const isSpecialPrefix = prefix === '11' || prefix === '15';
        const requiredLength = isSpecialPrefix ? 10 : 9;

        if (digitsOnly.length === 0) {
            clientErrors.push('Phone number is required');
        } else if (!validPrefixes.includes(prefix)) {
            clientErrors.push('Phone number must start with a valid Malaysian prefix (011-019)');
        } else if (digitsOnly.length !== requiredLength) {
            clientErrors.push('Phone number with prefix ' + prefix + ' must have ' + requiredLength + ' digits');
        }

        if (clientErrors.length > 0) {
            alert('Please fix the following errors:\n\n' + clientErrors.join('\n'));
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';

        const formData = new FormData(this);
        
        // Use raw values
        if (icInput.dataset.rawValue) formData.set('ic_number', icInput.dataset.rawValue);
        if (phoneInput.dataset.rawValue) formData.set('phone_number', phoneInput.dataset.rawValue);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-HTTP-Method-Override': 'PUT'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Save Changes</span>';
                
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
            submitBtn.innerHTML = '<span>Save Changes</span>';
            alert('An error occurred. Please try again.');
        });
    });
});
