document.addEventListener('DOMContentLoaded', () => {

    // Edit Allergen Name Select Toggle Logic
    const editSelect = document.getElementById('edit_allergen_select');
    const editSelectWrapper = document.getElementById('edit_allergen_select_wrapper');
    const editManualWrapper = document.getElementById('edit_allergen_manual_wrapper');
    const editManualInput = document.getElementById('edit_allergen');
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

    // ============================================================
    // HELPER FUNCTION: Call this when opening the Edit Modal
    // ============================================================
    // Pass the existing allergen name
    window.populateEditallergenName = function(existingValue) {
        
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
            // SCENARIO A: Value is in the list (e.g., "Asthma")
            // Show dropdown, hide manual input, set values
            editSelectWrapper.classList.remove('hidden');
            editManualWrapper.classList.add('hidden');
            editSelect.value = existingValue;
            editManualInput.value = existingValue; // Ensure hidden input matches
        } else {
            // SCENARIO B: Value is NOT in list (e.g., "Rare Disease X")
            // Hide dropdown, Show manual input, populate text
            editSelectWrapper.classList.add('hidden');
            editManualWrapper.classList.remove('hidden');
            editSelect.value = 'manual_entry'; // Set select to "Other"
            editManualInput.value = existingValue; // Fill text box
        }
    };

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-allergy-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-allergy-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldAllergen = document.getElementById('edit_allergen');
    const fieldAllergyType = document.getElementById('edit_allergy_type');
    const fieldReactionDesc = document.getElementById('edit_reaction_desc');
    const fieldFirstObservedDate = document.getElementById('edit_first_observed_date');
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
    };

    // --- Attach Close Listeners ---
    closeButton.addEventListener('click', closeModal);
    cancelButton.addEventListener('click', closeModal);

    // --- Attach Listeners to all "Edit" buttons on the page ---
    const editButtons = document.querySelectorAll('.edit-allergy-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const allergyId = button.dataset.id;
            
            // 1. Fetch data from the server
            try {
                const response = await fetch(`/patient/my-records/allergies/allergy/${allergyId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve allergy data.');
                }
                
                const data = await response.json();
                
                // 2. Populate the form fields
                populateForm(data.allergy, allergyId);

                // 3. Open the modal
                openModal();

            } catch (error) {
                // Handle fetch error (e.g., show a toast notification)
                console.error(error);
                alert('Error: Could not load allergy details.');
            }
        });
    });

    /**
     * Fills the modal's form fields and sets form action URLs.
     * @param {object} allergy - The allergy data object from the server.
     * @param {string} id - The ID of the allergy.
     */
    function populateForm(allergy, id) {
        // Set form action URLs to match your new routes
        const updateUrl = `/patient/my-records/allergies/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Set field values using the helper function for allergen name
        window.populateEditallergenName(allergy.allergen);

        fieldAllergyType.value = allergy.allergy_type;
        fieldReactionDesc.value = allergy.reaction_desc || '';
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (allergy.first_observed_date) {
            fieldFirstObservedDate.value = allergy.first_observed_date.split('T')[0];
        } else {
            fieldFirstObservedDate.value = '';
        }

        fieldSeverity.value = allergy.severity;
        fieldStatus.value = allergy.status;
    }
});
