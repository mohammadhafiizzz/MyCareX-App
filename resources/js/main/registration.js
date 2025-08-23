// Registration Elements

document.addEventListener('DOMContentLoaded', function () {
    // Handle relationship "Other" option
    const relationshipSelect = document.getElementById('emergencyContactRelationship');
    const otherRelationshipInput = document.getElementById('otherRelationship');

    if (relationshipSelect && otherRelationshipInput) {
        relationshipSelect.addEventListener('change', function () {
            if (this.value === 'Other') {
                otherRelationshipInput.classList.remove('hidden');
                otherRelationshipInput.required = true;
            } else {
                otherRelationshipInput.classList.add('hidden');
                otherRelationshipInput.required = false;
                otherRelationshipInput.value = '';
            }
        });
    }

    // Handle race "Other" option
    const raceSelect = document.getElementById('race');
    const otherRaceInput = document.getElementById('otherRace');

    if (raceSelect && otherRaceInput) {
        raceSelect.addEventListener('change', function () {
            if (this.value === 'Other') {
                otherRaceInput.classList.remove('hidden');
                otherRaceInput.required = true;
            } else {
                otherRaceInput.classList.add('hidden');
                otherRaceInput.required = false;
                otherRaceInput.value = '';
            }
        });
    }

    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
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

    // IC Number formatting
    function formatIcNumber(input) {
        let isDeleting = false;

        input.addEventListener('keydown', function (e) {
            // Detect backspace or delete
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        input.addEventListener('input', function (e) {
            // Don't format while deleting
            if (isDeleting) {
                return;
            }

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

            if (value.startsWith('011')) {
                // Format: 011-XXXX XXXX
                formattedValue = '011';
                if (value.length > 3) {
                    formattedValue += '-' + value.substring(3, 7);  // 4 digits
                }
                if (value.length > 7) {
                    formattedValue += ' ' + value.substring(7, 11); // 4 digits
                }
            }
            else if (value.startsWith('01')) {
                // Format: 01X-XXX XXXX  
                formattedValue = value.substring(0, 3);
                if (value.length > 3) {
                    formattedValue += '-' + value.substring(3, 6);  // 3 digits
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10); // 4 digits
                }
            }
            else if (value.startsWith('0')) {
                // Landline format: 0X-XXXX XXXX
                formattedValue = value.substring(0, 2);
                if (value.length > 2) {
                    formattedValue += '-' + value.substring(2, 6);  // 4 digits
                }
                if (value.length > 6) {
                    formattedValue += ' ' + value.substring(6, 10); // 4 digits
                }
            }
            else {
                // International or other
                formattedValue = value;
            }

            e.target.value = formattedValue;
        });
    }

    // Apply formatting to all fields
    formatIcNumber(document.getElementById('icNumber'));
    formatIcNumber(document.getElementById('emergencyContactIcNumber'));

    formatPhoneNumber(document.getElementById('phoneNumber'));
    formatPhoneNumber(document.getElementById('emergencyContactNumber'));
});