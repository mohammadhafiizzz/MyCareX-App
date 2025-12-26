/**
 * Terminate Access Handler
 * Handles the termination of doctor's access to patient records
 */

document.addEventListener('DOMContentLoaded', function() {
    const terminateBtn = document.getElementById('terminateAccessBtn');
    const modal = document.getElementById('terminateModal');
    const closeModal = document.getElementById('closeTerminateModal');
    const confirmBtn = document.getElementById('confirmTerminateBtn');
    const toast = document.getElementById('toast');
    
    if (!terminateBtn || !modal) return;

    // Show Modal
    terminateBtn.addEventListener('click', () => {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    // Hide Modal
    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });

    // Close modal on outside click
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });

    // Confirm Termination
    confirmBtn.addEventListener('click', async () => {
        const permissionId = terminateBtn.getAttribute('data-permission-id');
        
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Terminating...';

        try {
            const response = await fetch(`/doctor/permission/terminate/${permissionId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                showToast('Success', data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                showToast('Error', data.message || 'Failed to terminate access.', 'error');
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = 'Terminate Access';
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Error', 'An unexpected error occurred.', 'error');
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Terminate Access';
        }
    });

    function showToast(title, message, type = 'success') {
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        if (type === 'success') {
            toastIcon.className = 'w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600';
            toastIcon.innerHTML = '<i class="fa-solid fa-check"></i>';
        } else {
            toastIcon.className = 'w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600';
            toastIcon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
        }

        toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }, 3000);
    }
});
