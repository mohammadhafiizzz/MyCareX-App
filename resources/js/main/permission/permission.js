document.addEventListener('DOMContentLoaded', function () {
    const revokeBtns = document.querySelectorAll('.revoke-access-btn');
    const revokeModal = document.getElementById('revokePermissionModal');
    const closeRevokeModal = document.getElementById('closeRevokeModal');
    const confirmRevokeBtn = document.getElementById('confirmRevokeBtn');
    const confirmInput = document.getElementById('confirm_revoke_word');
    const revokeError = document.getElementById('revoke_error');
    const doctorNameSpan = document.getElementById('revokeDoctorName');

    let currentProviderId = null;
    let currentDoctorId = null;

    // Open Modal
    revokeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            currentProviderId = this.getAttribute('data-provider-id');
            currentDoctorId = this.getAttribute('data-doctor-id');
            const doctorName = this.getAttribute('data-doctor-name');
            
            if (doctorNameSpan) doctorNameSpan.textContent = doctorName;
            
            if (revokeModal) {
                revokeModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close Modal
    if (closeRevokeModal) {
        closeRevokeModal.addEventListener('click', function () {
            if (revokeModal) {
                revokeModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                confirmInput.value = '';
                revokeError.classList.add('hidden');
                currentProviderId = null;
                currentDoctorId = null;
            }
        });
    }

    // Confirm Revoke
    if (confirmRevokeBtn) {
        confirmRevokeBtn.addEventListener('click', function () {
            const confirmationWord = confirmInput.value.trim();

            if (confirmationWord !== 'REVOKE') {
                revokeError.classList.remove('hidden');
                return;
            }

            // Disable button and show loading state
            confirmRevokeBtn.disabled = true;
            confirmRevokeBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Revoking...';

            fetch(`/patient/permissions/revoke`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    provider_id: currentProviderId,
                    doctor_id: currentDoctorId,
                    confirmation: confirmationWord
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    revokeError.textContent = data.message || 'An error occurred.';
                    revokeError.classList.remove('hidden');
                    confirmRevokeBtn.disabled = false;
                    confirmRevokeBtn.innerHTML = 'Revoke Access';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                revokeError.textContent = 'An unexpected error occurred. Please try again.';
                revokeError.classList.remove('hidden');
                confirmRevokeBtn.disabled = false;
                confirmRevokeBtn.innerHTML = 'Revoke Access';
            });
        });
    }

    // Clear error on input
    if (confirmInput) {
        confirmInput.addEventListener('input', function() {
            revokeError.classList.add('hidden');
        });
    }
});