/**
 * Add Surgery Form Handler
 * 
 * Manages the Add Surgery modal dialog and form submission.
 * Handles validation errors from Laravel backend and displays them to the user.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // --- Modal Elements ---
    const modal = document.getElementById('add-surgery-modal');
    const showButton = document.getElementById('show-add-surgery-modal');
    const closeButton = document.getElementById('modal-close-button');
    const cancelButton = document.getElementById('modal-cancel-button');
    const form = document.getElementById('add-surgery-form');

    // Exit if modal doesn't exist on this page
    if (!modal || !form) return;

    // --- Modal Control Functions ---
    const showModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };

    const hideModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        
        // Clear form and errors when closing
        form.reset();
        clearErrors();
    };

    // --- Error Handling ---
    const errorContainer = document.getElementById('form-error-message');

    const showErrors = (errors) => {
        if (!errorContainer) return;

        let errorHTML = '<ul class="list-disc list-inside space-y-1">';
        
        if (typeof errors === 'object') {
            // Laravel validation errors (object with field names as keys)
            Object.values(errors).forEach(fieldErrors => {
                if (Array.isArray(fieldErrors)) {
                    fieldErrors.forEach(error => {
                        errorHTML += `<li>${error}</li>`;
                    });
                } else {
                    errorHTML += `<li>${fieldErrors}</li>`;
                }
            });
        } else if (typeof errors === 'string') {
            // Single error message
            errorHTML += `<li>${errors}</li>`;
        }
        
        errorHTML += '</ul>';
        
        errorContainer.innerHTML = errorHTML;
        errorContainer.classList.remove('hidden');
    };

    const clearErrors = () => {
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
        
        // Clear individual field errors if they exist
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-300').forEach(el => {
            el.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        });
    };

    // --- Event Listeners ---
    
    // Show modal
    if (showButton) {
        showButton.addEventListener('click', showModal);
    }

    // Close modal
    if (closeButton) {
        closeButton.addEventListener('click', hideModal);
    }

    if (cancelButton) {
        cancelButton.addEventListener('click', hideModal);
    }

    // Click outside modal to close
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            hideModal();
        }
    });

    // Clear errors on input
    form.addEventListener('input', () => {
        if (errorContainer && !errorContainer.classList.contains('hidden')) {
            clearErrors();
        }
    });

    // --- Form Submission ---
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        clearErrors();
        
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            showErrors('CSRF token not found. Please refresh the page.');
            return;
        }

        // Get form data
        const formData = new FormData(form);
        
        // Get the submit button to show loading state
        const submitButton = form.querySelector('button[type="submit"]');
        const originalButtonText = submitButton?.innerHTML;
        
        // Show loading state
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Adding...';
        }

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Success - reload page to show new surgery
                window.location.reload();
            } else {
                // Validation or other errors
                if (data.errors) {
                    showErrors(data.errors);
                } else if (data.message) {
                    showErrors(data.message);
                } else {
                    showErrors('An error occurred. Please try again.');
                }
                
                // Restore button state
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            showErrors('A network error occurred. Please check your connection and try again.');
            
            // Restore button state
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        }
    });
});
