// Request Access Modal Handler
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('requestAccessModal');
    const openModalBtn = document.getElementById('openRequestAccessModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const cancelRequestBtn = document.getElementById('cancelRequestBtn');
    const confirmRequestBtn = document.getElementById('confirmRequestBtn');
    const accessNotes = document.getElementById('accessNotes');
    const patientNameDisplay = document.getElementById('patientNameDisplay');

    // Store patient data
    let currentPatientId = null;
    let currentPatientName = null;

    // Open modal
    if (openModalBtn) {
        openModalBtn.addEventListener('click', function() {
            currentPatientId = this.dataset.patientId;
            currentPatientName = this.dataset.patientName;
            
            // Update patient name in modal
            patientNameDisplay.textContent = currentPatientName;
            
            // Reset notes
            accessNotes.value = '';
            
            // Show modal
            modal.classList.remove('hidden');
        });
    }

    // Close modal function
    function closeModal() {
        modal.classList.add('hidden');
        accessNotes.value = '';
        currentPatientId = null;
        currentPatientName = null;
    }

    // Close modal on X button
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Close modal on Cancel button
    if (cancelRequestBtn) {
        cancelRequestBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });

    // Handle confirm request
    if (confirmRequestBtn) {
        confirmRequestBtn.addEventListener('click', function() {
            // Disable button to prevent double submission
            confirmRequestBtn.disabled = true;
            confirmRequestBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending...';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Prepare data
            const requestData = {
                patient_id: currentPatientId,
                notes: accessNotes.value.trim()
            };

            // Send AJAX request
            fetch('/doctor/permission/request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('success', data.message);
                    
                    // Close modal
                    closeModal();
                    
                    // Optional: Disable the request access button after successful request
                    if (openModalBtn) {
                        openModalBtn.disabled = true;
                        openModalBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        openModalBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                        openModalBtn.innerHTML = '<i class="fas fa-check mr-1"></i> Request Sent';
                    }
                } else {
                    // Show error message
                    showNotification('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('error', 'An error occurred. Please try again.');
            })
            .finally(() => {
                // Re-enable button
                confirmRequestBtn.disabled = false;
                confirmRequestBtn.innerHTML = 'Send Request';
            });
        });
    }

    // Notification function
    function showNotification(type, message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} text-xl"></i>
                <p class="font-medium">${message}</p>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // Character limit for notes
    if (accessNotes) {
        accessNotes.addEventListener('input', function() {
            if (this.value.length > 500) {
                this.value = this.value.substring(0, 500);
            }
        });
    }
});
