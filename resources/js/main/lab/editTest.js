document.addEventListener('DOMContentLoaded', () => {

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-test-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-test-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldTestName = document.getElementById('edit_test_name');
    const fieldTestCategory = document.getElementById('edit_test_category');
    const fieldTestDate = document.getElementById('edit_test_date');
    const fieldFacilityName = document.getElementById('edit_facility_name');
    const fieldVerificationStatus = document.getElementById('edit_verification_status');
    const fieldNotes = document.getElementById('edit_notes');
    const errorMessages = document.getElementById('edit-form-error-message');

    // Lab Test Name Select/Manual Toggle for Edit Form
    const editTestSelect = document.getElementById('edit_test_select');
    const editTestManualWrapper = document.getElementById('edit_test_manual_wrapper');
    const editTestSelectWrapper = document.getElementById('edit_test_select_wrapper');
    const editSwitchToSelectBtn = document.getElementById('edit_switch_to_select');

    if (editTestSelect && editTestManualWrapper && editTestSelectWrapper && editSwitchToSelectBtn && fieldTestName) {
        editTestSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                editTestSelectWrapper.classList.add('hidden');
                editTestManualWrapper.classList.remove('hidden');
                fieldTestName.value = '';
                fieldTestName.focus();
                fieldTestName.required = true;
            } else {
                fieldTestName.value = this.value;
                fieldTestName.required = false;
            }
        });

        editSwitchToSelectBtn.addEventListener('click', function() {
            editTestManualWrapper.classList.add('hidden');
            editTestSelectWrapper.classList.remove('hidden');
            editTestSelect.value = '';
            fieldTestName.value = '';
            fieldTestName.required = false;
        });
    }

    // Lab Test Category Select/Manual Toggle for Edit Form
    const editCategorySelect = document.getElementById('edit_test_category_select');
    const editCategoryManualWrapper = document.getElementById('edit_test_category_manual_wrapper');
    const editCategorySelectWrapper = document.getElementById('edit_test_category_select_wrapper');
    const editSwitchToSelectCategoryBtn = document.getElementById('edit_switch_to_select_category');

    if (editCategorySelect && editCategoryManualWrapper && editCategorySelectWrapper && editSwitchToSelectCategoryBtn && fieldTestCategory) {
        editCategorySelect.addEventListener('change', function() {
            if (this.value === 'other_category') {
                editCategorySelectWrapper.classList.add('hidden');
                editCategoryManualWrapper.classList.remove('hidden');
                fieldTestCategory.value = '';
                fieldTestCategory.focus();
                fieldTestCategory.required = true;
            } else {
                fieldTestCategory.value = this.value;
                fieldTestCategory.required = false;
            }
        });

        editSwitchToSelectCategoryBtn.addEventListener('click', function() {
            editCategoryManualWrapper.classList.add('hidden');
            editCategorySelectWrapper.classList.remove('hidden');
            editCategorySelect.value = '';
            fieldTestCategory.value = '';
            fieldTestCategory.required = false;
        });
    }

    // ============================================================
    // HELPER FUNCTIONS: Call these when opening the Edit Modal
    // ============================================================
    
    // Pass the existing test name
    window.populateEditTestName = function(existingValue) {
        let valueExistsInDropdown = false;
        for(let i = 0; i < editTestSelect.options.length; i++) {
            if(editTestSelect.options[i].value === existingValue) {
                valueExistsInDropdown = true;
                break;
            }
        }

        if (valueExistsInDropdown) {
            editTestSelectWrapper.classList.remove('hidden');
            editTestManualWrapper.classList.add('hidden');
            editTestSelect.value = existingValue;
            fieldTestName.value = existingValue;
            fieldTestName.required = false;
        } else {
            editTestSelectWrapper.classList.add('hidden');
            editTestManualWrapper.classList.remove('hidden');
            editTestSelect.value = 'other';
            fieldTestName.value = existingValue;
            fieldTestName.required = true;
        }
    };

    // Pass the existing test category
    window.populateEditTestCategory = function(existingValue) {
        let valueExistsInDropdown = false;
        for(let i = 0; i < editCategorySelect.options.length; i++) {
            if(editCategorySelect.options[i].value === existingValue) {
                valueExistsInDropdown = true;
                break;
            }
        }

        if (valueExistsInDropdown) {
            editCategorySelectWrapper.classList.remove('hidden');
            editCategoryManualWrapper.classList.add('hidden');
            editCategorySelect.value = existingValue;
            fieldTestCategory.value = existingValue;
            fieldTestCategory.required = false;
        } else {
            editCategorySelectWrapper.classList.add('hidden');
            editCategoryManualWrapper.classList.remove('hidden');
            editCategorySelect.value = 'other_category';
            fieldTestCategory.value = existingValue;
            fieldTestCategory.required = true;
        }
    };

    // --- Modal Control Functions ---
    const openModal = () => {
        editModal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
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
    const editButtons = document.querySelectorAll('.edit-test-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const labTestId = button.dataset.id;
            
            // 1. Fetch data from the server
            try {
                const response = await fetch(`/patient/my-records/lab-tests/test/${labTestId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve lab test data.');
                }
                
                const data = await response.json();
                
                // 2. Populate the form fields
                populateForm(data.labTest, labTestId);

                // 3. Open the modal
                openModal();

            } catch (error) {
                // Handle fetch error
                console.error(error);
                alert('Error: Could not load lab test details.');
            }
        });
    });

    /**
     * Fills the modal's form fields and sets form action URLs.
     * @param {object} labTest - The lab test data object from the server.
     * @param {string} id - The ID of the lab test.
     */
    function populateForm(labTest, id) {
        // Set form action URLs
        const updateUrl = `/patient/my-records/lab-tests/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Set field values using helper functions
        window.populateEditTestName(labTest.test_name || '');
        window.populateEditTestCategory(labTest.test_category || '');
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (labTest.test_date) {
            fieldTestDate.value = labTest.test_date.split('T')[0];
        } else {
            fieldTestDate.value = '';
        }

        fieldFacilityName.value = labTest.facility_name || '';
        fieldNotes.value = labTest.notes || '';
    }
});
