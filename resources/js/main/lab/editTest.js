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

        // Set field values
        fieldTestName.value = labTest.test_name || '';
        fieldTestCategory.value = labTest.test_category || '';
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (labTest.test_date) {
            fieldTestDate.value = labTest.test_date.split('T')[0];
        } else {
            fieldTestDate.value = '';
        }

        fieldFacilityName.value = labTest.facility_name || '';
        fieldVerificationStatus.value = labTest.verification_status || '';
        fieldNotes.value = labTest.notes || '';
    }
});
