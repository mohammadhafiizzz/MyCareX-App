document.addEventListener('DOMContentLoaded', () => {

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-condition-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-condition-form');
    const deleteForm = document.getElementById('delete-condition-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldConditionName = document.getElementById('edit_condition_name');
    const fieldDescription = document.getElementById('edit_description');
    const fieldDiagnosisDate = document.getElementById('edit_diagnosis_date');
    const fieldSeverity = document.getElementById('edit_severity');
    const fieldStatus = document.getElementById('edit_status');
    const errorMessages = document.getElementById('edit-form-error-message');

    // --- Modal Control Functions ---
    const openModal = () => editModal.classList.remove('hidden');
    const closeModal = () => {
        editModal.classList.add('hidden');
        errorMessages.classList.add('hidden'); // Hide errors
        editForm.reset(); // Clear the form
    };

    // --- Attach Close Listeners ---
    closeButton.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    // --- Attach Listeners to all "Edit" buttons on the page ---
    const editButtons = document.querySelectorAll('.edit-condition-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const conditionId = button.dataset.id;
            
            // 1. Fetch data from the server
            try {
                const response = await fetch(`/patient/my-records/condition/${conditionId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve condition data.');
                }
                
                const data = await response.json();
                
                // 2. Populate the form fields
                populateForm(data.condition, conditionId);

                // 3. Open the modal
                openModal();

            } catch (error) {
                // Handle fetch error (e.g., show a toast notification)
                console.error(error);
                alert('Error: Could not load condition details.');
            }
        });
    });

    /**
     * Fills the modal's form fields and sets form action URLs.
     * @param {object} condition - The condition data object from the server.
     * @param {string} id - The ID of the condition.
     */
    function populateForm(condition, id) {
        // Set form action URLs
        const updateUrl = `/patient/my-records/condition/${id}`;
        editForm.setAttribute('action', updateUrl);
        deleteForm.setAttribute('action', updateUrl); // Delete also points to the same base URL

        // Set field values
        fieldConditionName.value = condition.condition_name;
        fieldDescription.value = condition.description || '';
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (condition.diagnosis_date) {
            fieldDiagnosisDate.value = condition.diagnosis_date.split('T')[0];
        } else {
            fieldDiagnosisDate.value = '';
        }

        fieldSeverity.value = condition.severity;
        fieldStatus.value = condition.status;
    }
});