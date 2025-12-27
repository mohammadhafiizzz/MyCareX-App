document.addEventListener('DOMContentLoaded', () => {

    const editSelect = document.getElementById('edit_condition_select');
    const editSelectWrapper = document.getElementById('edit_condition_select_wrapper');
    const editManualWrapper = document.getElementById('edit_condition_manual_wrapper');
    const editManualInput = document.getElementById('edit_condition_name');
    const editSwitchBtn = document.getElementById('edit_switch_to_select');

    // 1. Toggle Logic (Same as Add Form)
    editSelect.addEventListener('change', function() {
        if (this.value === 'manual_entry') {
            editSelectWrapper.classList.add('hidden');
            editManualWrapper.classList.remove('hidden');
            editManualInput.value = ''; 
            editManualInput.focus();
        } else {
            editManualInput.value = this.value;
        }
    });

    // 2. Switch Back Logic
    editSwitchBtn.addEventListener('click', function() {
        editManualWrapper.classList.add('hidden');
        editSelectWrapper.classList.remove('hidden');
        editSelect.value = ""; 
        editManualInput.value = "";
    });

    // Pass the existing condition name
    window.populateEditConditionName = function(existingValue) {
        
        // Check if the existing value is present in the dropdown options
        let valueExistsInDropdown = false;
        
        // Loop through options to see if we have a match
        for(let i = 0; i < editSelect.options.length; i++) {
            if(editSelect.options[i].value === existingValue) {
                valueExistsInDropdown = true;
                break;
            }
        }

        if (valueExistsInDropdown) {
            // Show dropdown, hide manual input, set values
            editSelectWrapper.classList.remove('hidden');
            editManualWrapper.classList.add('hidden');
            editSelect.value = existingValue;
            editManualInput.value = existingValue;
        } else {
            // Hide dropdown, Show manual input, populate text
            editSelectWrapper.classList.add('hidden');
            editManualWrapper.classList.remove('hidden');
            editSelect.value = 'manual_entry';
            editManualInput.value = existingValue;
        }
    };

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-condition-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-condition-form');
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
    const openModal = () => {
        editModal.style.display = 'flex';
        document.body.style.overflow = 'hidden' // Prevent background scrolling
    };
    
    const closeModal = () => {
        editModal.style.display = 'none';
        errorMessages.classList.add('hidden'); // Hide errors
        document.body.style.overflow = 'auto'; // Restore background scrolling
        editForm.reset(); // Clear the form
    };    // --- Attach Close Listeners ---
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
                const response = await fetch(`/patient/my-records/medical-conditions/condition/${conditionId}/json`);
                
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
        // Set form action URLs to match your new routes
        const updateUrl = `/patient/my-records/medical-conditions/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Set field values using the helper function for condition name
        window.populateEditConditionName(condition.condition_name);
        
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