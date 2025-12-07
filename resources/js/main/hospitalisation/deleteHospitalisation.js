/**
 * Delete Hospitalisation Handler
 * 
 * Handles hospitalisation deletion with permission checks.
 * Prevents deletion of provider-created records.
 */

document.addEventListener('DOMContentLoaded', () => {

    // Attach listeners to all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-hospitalisation-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Check if button is disabled (provider-created record)
            if (button.disabled || button.classList.contains('cursor-not-allowed')) {
                showNotPermittedToast();
                return;
            }
            
            const hospitalisationId = button.dataset.id;
            const reason = button.dataset.reason || 'this hospitalisation';
            
            // Show confirmation dialog
            const confirmed = confirm(
                `Are you sure you want to delete "${reason}"?\n\n` +
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
                const response = await fetch(`/patient/medical-history/hospitalisation/${hospitalisationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                // Check if response is a redirect (Laravel returns HTML for redirects)
                if (response.redirected || response.url.includes('/patient/medical-history/hospitalisation')) {
                    // Follow the redirect
                    window.location.href = response.url;
                    return;
                }

                const data = await response.json();

                if (response.ok) {
                    // Success - redirect to hospitalisation page
                    window.location.href = '/patient/medical-history/hospitalisation';
                } else {
                    // Handle errors
                    let errorMessage = 'Failed to delete hospitalisation.';
                    
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
                console.error('Error deleting hospitalisation:', error);
                alert('A network error occurred. Please check your connection and try again.');
                
                // Restore button state
                button.disabled = false;
                button.innerHTML = originalButtonContent;
            }
        });
    });

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
