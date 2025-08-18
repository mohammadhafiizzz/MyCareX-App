// Registration Elements

document.addEventListener('DOMContentLoaded', function () {
    // Handle relationship "Other" option
    const relationshipSelect = document.getElementById('emergencyContactRelationship');
    const otherRelationshipInput = document.getElementById('otherRelationship');

    if (relationshipSelect && otherRelationshipInput) {
        relationshipSelect.addEventListener('change', function () {
            if (this.value === 'other') {
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
    const otherRaceLabel = document.getElementById('otherRaceLabel');

    if (raceSelect && otherRaceInput) {
        raceSelect.addEventListener('change', function () {
            if (this.value === 'other') {
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
    document.getElementById('icNumber').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.substring(0, 6) + '-' + value.substring(6);
        }
        if (value.length >= 9) {
            value = value.substring(0, 9) + '-' + value.substring(9, 13);
        }
        e.target.value = value;
    });

    // Phone number formatting
    function formatPhoneNumber(input) {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 3) {
                value = value.substring(0, 3) + '-' + value.substring(3);
            }
            if (value.length >= 7) {
                value = value.substring(0, 7) + ' ' + value.substring(7, 11);
            }
            e.target.value = value;
        });
    }

    formatPhoneNumber(document.getElementById('phoneNumber'));
    formatPhoneNumber(document.getElementById('emergencyContactPhone'));
});