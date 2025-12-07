/**
 * Add Hospitalisation Form Handler
 * 
 * Handles the add hospitalisation modal and form submission.
 * Includes CSRF token handling and validation error display.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('add-hospitalisation-modal');
    const openButton = document.getElementById('show-add-hospitalisation-modal');
    const closeButton = document.getElementById('close-add-hospitalisation-modal');
    const cancelButton = document.getElementById('cancel-add-hospitalisation');
    const form = document.getElementById('add-hospitalisation-form');

    // Open modal
    if (openButton) {
        openButton.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    }

    // Close modal handlers
    if (closeButton) {
        closeButton.addEventListener('click', (e) => {
            e.preventDefault();
            closeModal();
        });
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', (e) => {
            e.preventDefault();
            closeModal();
        });
    }

    // Close on backdrop click
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Form submission
    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showErrors({ general: ['CSRF token not found. Please refresh the page.'] });
                return;
            }
            
            // Get form data
            const formData = new FormData(form);
            
            // Show loading state
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Success - redirect to hospitalisation page
                    window.location.href = '/patient/medical-history/hospitalisation';
                } else {
                    // Show validation errors
                    if (data.errors) {
                        showErrors(data.errors);
                    } else if (data.message) {
                        showErrors({ general: [data.message] });
                    } else {
                        showErrors({ general: ['An error occurred. Please try again.'] });
                    }
                    
                    // Restore button state
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            } catch (error) {
                console.error('Error adding hospitalisation:', error);
                showErrors({ general: ['A network error occurred. Please check your connection and try again.'] });
                
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    /**
     * Open the add hospitalisation modal
     */
    function openModal() {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            
            // Clear form
            if (form) {
                form.reset();
                clearErrors();
            }
        }
    }

    /**
     * Close the add hospitalisation modal
     */
    function closeModal() {
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
            
            // Clear form and errors
            if (form) {
                form.reset();
                clearErrors();
            }
        }
    }

    /**
     * Display validation errors
     */
    function showErrors(errors) {
        const errorContainer = document.getElementById('form-error-message');
        
        if (!errorContainer) return;
        
        // Build error messages HTML
        let errorHtml = '<ul class="list-disc list-inside space-y-1">';
        
        for (const field in errors) {
            errors[field].forEach(message => {
                errorHtml += `<li>${message}</li>`;
            });
        }
        
        errorHtml += '</ul>';
        
        errorContainer.innerHTML = errorHtml;
        errorContainer.classList.remove('hidden');
        
        // Scroll to error container
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Clear all error messages
     */
    function clearErrors() {
        const errorContainer = document.getElementById('form-error-message');
        
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
    }
});
