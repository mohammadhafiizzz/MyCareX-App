/**
 * Edit Hospitalisation Form Handler
 * 
 * Handles the edit hospitalisation modal, data fetching, and form submission.
 * Includes permission checks and validation error display.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('edit-hospitalisation-modal');
    const closeButton = document.getElementById('close-edit-hospitalisation-modal');
    const cancelButton = document.getElementById('cancel-edit-hospitalisation');
    const form = document.getElementById('edit-hospitalisation-form');
    const editButtons = document.querySelectorAll('.edit-hospitalisation-btn');

    // Attach click handlers to all edit buttons
    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Check if button is disabled (provider-created record)
            if (button.disabled || button.classList.contains('cursor-not-allowed')) {
                showNotPermittedToast();
                return;
            }
            
            const hospitalisationId = button.dataset.id;
            
            if (hospitalisationId) {
                await loadHospitalisationData(hospitalisationId);
            }
        });
    });

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
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            
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
                console.error('Error updating hospitalisation:', error);
                showErrors({ general: ['A network error occurred. Please check your connection and try again.'] });
                
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonText;
            }
        });
    }

    /**
     * Load hospitalisation data from server
     */
    async function loadHospitalisationData(hospitalisationId) {
        try {
            const response = await fetch(`/patient/medical-history/hospitalisation/${hospitalisationId}/json`, {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                if (response.status === 403) {
                    showNotPermittedToast();
                    return;
                }
                throw new Error('Failed to load hospitalisation data');
            }

            const data = await response.json();
            
            if (data.hospitalisation) {
                populateForm(data.hospitalisation);
                openModal();
            }
        } catch (error) {
            console.error('Error loading hospitalisation data:', error);
            alert('Failed to load hospitalisation data. Please try again.');
        }
    }

    /**
     * Populate form with hospitalisation data
     */
    function populateForm(hospitalisation) {
        // Set form action URL
        form.action = `/patient/medical-history/hospitalisation/${hospitalisation.id}`;
        
        // Populate fields
        document.getElementById('edit-admission-date').value = hospitalisation.admission_date || '';
        document.getElementById('edit-discharge-date').value = hospitalisation.discharge_date || '';
        document.getElementById('edit-reason-for-admission').value = hospitalisation.reason_for_admission || '';
        document.getElementById('edit-provider-name').value = hospitalisation.provider_name || '';
        document.getElementById('edit-notes').value = hospitalisation.notes || '';
    }

    /**
     * Open the edit hospitalisation modal
     */
    function openModal() {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            clearErrors();
        }
    }

    /**
     * Close the edit hospitalisation modal
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
        const errorContainer = document.getElementById('edit-form-error-message');
        
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
        const errorContainer = document.getElementById('edit-form-error-message');
        
        if (errorContainer) {
            errorContainer.innerHTML = '';
            errorContainer.classList.add('hidden');
        }
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
                <p class="text-sm">You cannot edit records created by healthcare providers.</p>
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
