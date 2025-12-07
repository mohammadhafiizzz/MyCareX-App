/**
 * Edit Surgery Form Handler
 * 
 * Manages the Edit Surgery modal dialog, fetches surgery data from server,
 * populates the form, and handles update submissions with permission checks.
 */

document.addEventListener('DOMContentLoaded', () => {

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-surgery-modal');
    if (!editModal) return; // Exit if modal doesn't exist on this page

    const editForm = document.getElementById('edit-surgery-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldProcedureName = document.getElementById('edit_procedure_name');
    const fieldProcedureDate = document.getElementById('edit_procedure_date');
    const fieldSurgeonName = document.getElementById('edit_surgeon_name');
    const fieldHospitalName = document.getElementById('edit_hospital_name');
    const fieldNotes = document.getElementById('edit_notes');
    const errorContainer = document.getElementById('edit-form-error-message');

    // --- Modal Control Functions ---
    const openModal = () => {
        editModal.classList.remove('hidden');
        editModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    };
    
    const closeModal = () => {
        editModal.classList.add('hidden');
        editModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
        editForm?.reset();
        clearErrors();
    };

    // --- Error Handling ---
    const showErrors = (errors) => {
        if (!errorContainer) return;

        let errorHTML = '<ul class="list-disc list-inside space-y-1">';
        
        if (typeof errors === 'object') {
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
        
        document.querySelectorAll('.field-error').forEach(el => el.remove());
        document.querySelectorAll('.border-red-300').forEach(el => {
            el.classList.remove('border-red-300', 'focus:border-red-500', 'focus:ring-red-500');
        });
    };

    // --- Attach Close Listeners ---
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }
    
    if (cancelButton) {
        cancelButton.addEventListener('click', closeModal);
    }

    // Click outside to close
    editModal.addEventListener('click', (event) => {
        if (event.target === editModal) {
            closeModal();
        }
    });

    // Clear errors on input
    if (editForm) {
        editForm.addEventListener('input', () => {
            if (errorContainer && !errorContainer.classList.contains('hidden')) {
                clearErrors();
            }
        });
    }

    // --- Attach Listeners to all "Edit" buttons ---
    const editButtons = document.querySelectorAll('.edit-surgery-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Check if button is disabled (provider-created record)
            if (button.disabled || button.classList.contains('cursor-not-allowed')) {
                showNotPermittedToast();
                return;
            }
            
            const surgeryId = button.dataset.id;
            
            try {
                // Fetch surgery data from server
                const response = await fetch(`/patient/medical-history/surgery/${surgeryId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve surgery data.');
                }
                
                const data = await response.json();
                
                // Check if patient has permission to edit
                if (data.surgery.doctor_id !== null) {
                    showNotPermittedToast();
                    return;
                }
                
                // Populate the form
                populateForm(data.surgery, surgeryId);
                
                // Open the modal
                openModal();

            } catch (error) {
                console.error('Error loading surgery data:', error);
                alert('Error: Could not load surgery details.');
            }
        });
    });

    /**
     * Populate form fields with surgery data
     * @param {object} surgery - Surgery data from server
     * @param {string} id - Surgery ID
     */
    function populateForm(surgery, id) {
        // Set form action URL for update
        const updateUrl = `/patient/medical-history/surgery/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Populate fields
        fieldProcedureName.value = surgery.procedure_name || '';
        fieldSurgeonName.value = surgery.surgeon_name || '';
        fieldHospitalName.value = surgery.hospital_name || '';
        fieldNotes.value = surgery.notes || '';
        
        // Format date for input (YYYY-MM-DD)
        if (surgery.procedure_date) {
            fieldProcedureDate.value = surgery.procedure_date.split('T')[0];
        } else {
            fieldProcedureDate.value = '';
        }
    }

    // --- Form Submission ---
    if (editForm) {
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            clearErrors();
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                showErrors('CSRF token not found. Please refresh the page.');
                return;
            }

            // Get form data
            const formData = new FormData(editForm);
            
            // Get submit button for loading state
            const submitButton = editForm.querySelector('button[type="submit"]');
            const originalButtonText = submitButton?.innerHTML;
            
            // Show loading state
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
            }

            try {
                const response = await fetch(editForm.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Success - reload page
                    window.location.reload();
                } else {
                    // Handle errors
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
                console.error('Error updating surgery:', error);
                showErrors('A network error occurred. Please check your connection and try again.');
                
                // Restore button state
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                }
            }
        });
    }

    /**
     * Show toast notification for permission denied
     */
    function showNotPermittedToast() {
        // Create toast element
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
