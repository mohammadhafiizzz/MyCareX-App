/**
 * Delete Surgery Handler
 * 
 * Handles surgery deletion with permission checks.
 * Prevents deletion of provider-created records.
 */

document.addEventListener('DOMContentLoaded', () => {

    // Attach listeners to all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-surgery-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Check if button is disabled (provider-created record)
            if (button.disabled || button.classList.contains('cursor-not-allowed')) {
                showNotPermittedToast();
                return;
            }
            
            const surgeryId = button.dataset.id;
            const procedureName = button.dataset.procedure || 'this surgery';
            
            // Show confirmation dialog
            const confirmed = confirm(
                `Are you sure you want to delete "${procedureName}"?\n\n` +
                'This action cannot be undone.'
            );
            
            if (!confirmed) {
                return;
            }
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                alert('CSRF token not found. Please refresh the page.');
                return;
            }
            
            // Show loading state on button
            const originalButtonContent = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            try {
                const response = await fetch(`/patient/medical-history/surgery/${surgeryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Success - show toast and reload
                    showSuccessToast('Surgery deleted successfully');
                    
                    // Reload after short delay
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    // Handle errors
                    let errorMessage = 'Failed to delete surgery.';
                    
                    if (data.message) {
                        errorMessage = data.message;
                    } else if (data.error) {
                        errorMessage = data.error;
                    }
                    
                    alert(errorMessage);
                    
                    // Restore button state
                    button.disabled = false;
                    button.innerHTML = originalButtonContent;
                }
            } catch (error) {
                console.error('Error deleting surgery:', error);
                alert('A network error occurred. Please check your connection and try again.');
                
                // Restore button state
                button.disabled = false;
                button.innerHTML = originalButtonContent;
            }
        });
    });

    /**
     * Show success toast notification
     */
    function showSuccessToast(message) {
        const toast = document.createElement('div');
        toast.className = 'fixed top-20 right-4 bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in';
        toast.innerHTML = `
            <i class="fas fa-check-circle text-green-600"></i>
            <p class="font-semibold">${message}</p>
            <button class="ml-4 text-green-600 hover:text-green-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    /**
     * Show permission denied toast notification
     */
    function showNotPermittedToast() {
        const toast = document.createElement('div');
        toast.className = 'fixed top-20 right-4 bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in';
        toast.innerHTML = `
            <i class="fas fa-exclamation-circle text-red-600"></i>
            <div>
                <p class="font-semibold">Action Not Permitted</p>
                <p class="text-sm">You cannot delete records created by healthcare providers.</p>
            </div>
            <button class="ml-4 text-red-600 hover:text-red-800" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }
});
