/*
Author: Mohammad Hafiz bin Mohan
Description: Healthcare Provider Registration JavaScript
File: resources/js/main/organisation/providerRegistration.js
*/

document.addEventListener('DOMContentLoaded', function () {
    // Show/hide beds field based on organisation type
    const orgTypeSelect = document.getElementById('organisationType');
    const bedCountSection = document.getElementById('bedCountSection');
    const bedsInput = document.getElementById('numberOfBeds');

    if (orgTypeSelect && bedCountSection) {
        orgTypeSelect.addEventListener('change', function () {
            const hospitalTypes = ['Hospital', 'Nursing Home'];
            if (hospitalTypes.includes(this.value)) {
                bedCountSection.classList.remove('hidden');
                bedsInput.required = true;
            } else {
                bedCountSection.classList.add('hidden');
                bedsInput.required = false;
                bedsInput.value = '';
            }
        });
    }

    // Password toggle functionality
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    }

    // IC Number formatting
    function formatIcNumber(input) {
        let isDeleting = false;

        input.addEventListener('keydown', function (e) {
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        input.addEventListener('input', function (e) {
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

    // Phone number formatting
    function formatPhoneNumber(input) {
        let isDeleting = false;

        input.addEventListener('keydown', function (e) {
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        input.addEventListener('input', function (e) {
            if (isDeleting) return;

            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';

            if (value.length === 0) return;

            if (value.startsWith('03')) {
                // Landline: 03-XXXX XXXX
                formattedValue = '03';
                if (value.length > 2) {
                    formattedValue += '-' + value.substring(2, 6);
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10);
                }
            } else if (value.startsWith('01')) {
                // Mobile: 01X-XXX XXXX
                formattedValue = value.substring(0, 3);
                if (value.length > 3) {
                    formattedValue += '-' + value.substring(3, 6);
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10);
                }
            } else {
                formattedValue = value;
            }

            e.target.value = formattedValue;
        });
    }

    // Apply formatting
    formatIcNumber(document.getElementById('contactPersonIcNumber'));
    formatPhoneNumber(document.getElementById('phoneNumber'));
    formatPhoneNumber(document.getElementById('emergencyContactNumber'));
    formatPhoneNumber(document.getElementById('contactPersonPhone'));

    // File upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function () {
            const maxSize = 5 * 1024 * 1024; // 5MB
            const file = this.files[0];
            
            if (file && file.size > maxSize) {
                alert('File size must be less than 5MB');
                this.value = '';
            }
        });
    });

    // Form submission handling
    const form = document.getElementById('providerRegistrationForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form && submitBtn) {
        form.addEventListener('submit', function (e) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        });
    }
});