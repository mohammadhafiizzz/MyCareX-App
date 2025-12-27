document.addEventListener('DOMContentLoaded', () => {

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-vaccine-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-vaccine-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldVaccineName = document.getElementById('edit_vaccine_name');
    const fieldDoseDetails = document.getElementById('edit_dose_details');
    const fieldVaccinationDate = document.getElementById('edit_vaccination_date');
    const fieldAdministeredBy = document.getElementById('edit_administered_by');
    const fieldVaccineLotNumber = document.getElementById('edit_vaccine_lot_number');
    const fieldVerificationStatus = document.getElementById('edit_verification_status');
    const fieldNotes = document.getElementById('edit_notes');
    const errorMessages = document.getElementById('edit-form-error-message');

    // Vaccine Name Select/Manual Toggle for Edit Form
    const editVaccineSelect = document.getElementById('edit_vaccine_select');
    const editVaccineManualWrapper = document.getElementById('edit_vaccine_manual_wrapper');
    const editVaccineSelectWrapper = document.getElementById('edit_vaccine_select_wrapper');
    const editSwitchToSelectBtn = document.getElementById('edit_switch_to_select');

    if (editVaccineSelect && editVaccineManualWrapper && editVaccineSelectWrapper && editSwitchToSelectBtn && fieldVaccineName) {
        editVaccineSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                editVaccineSelectWrapper.classList.add('hidden');
                editVaccineManualWrapper.classList.remove('hidden');
                fieldVaccineName.value = '';
                fieldVaccineName.focus();
                fieldVaccineName.required = true;
            } else {
                fieldVaccineName.value = this.value;
                fieldVaccineName.required = false;
            }
        });

        editSwitchToSelectBtn.addEventListener('click', function() {
            editVaccineManualWrapper.classList.add('hidden');
            editVaccineSelectWrapper.classList.remove('hidden');
            editVaccineSelect.value = '';
            fieldVaccineName.value = '';
            fieldVaccineName.required = false;
        });
    }

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
    const editButtons = document.querySelectorAll('.edit-vaccine-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const immunisationId = button.dataset.id;
            
            // 1. Fetch data from the server
            try {
                const response = await fetch(`/patient/my-records/immunisation/immunisation/${immunisationId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve vaccination data.');
                }
                
                const data = await response.json();
                
                // 2. Populate the form fields
                populateForm(data.immunisation, immunisationId);

                // 3. Open the modal
                openModal();

            } catch (error) {
                // Handle fetch error
                console.error(error);
                alert('Error: Could not load vaccination details.');
            }
        });
    });

    /**
     * Fills the modal's form fields and sets form action URLs.
     * @param {object} immunisation - The immunisation data object from the server.
     * @param {string} id - The ID of the immunisation.
     */
    function populateForm(immunisation, id) {
        // Set form action URLs
        const updateUrl = `/patient/my-records/immunisation/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Set field values
        const vaccineName = immunisation.vaccine_name || '';
        fieldVaccineName.value = vaccineName;

        // Handle vaccine select/manual toggle
        if (editVaccineSelect && editVaccineSelectWrapper && editVaccineManualWrapper) {
            let optionExists = false;
            for (let i = 0; i < editVaccineSelect.options.length; i++) {
                if (editVaccineSelect.options[i].value === vaccineName) {
                    optionExists = true;
                    break;
                }
            }

            if (optionExists) {
                editVaccineSelect.value = vaccineName;
                editVaccineSelectWrapper.classList.remove('hidden');
                editVaccineManualWrapper.classList.add('hidden');
                fieldVaccineName.required = false;
            } else if (vaccineName !== '') {
                editVaccineSelect.value = 'other';
                editVaccineSelectWrapper.classList.add('hidden');
                editVaccineManualWrapper.classList.remove('hidden');
                fieldVaccineName.required = true;
            } else {
                editVaccineSelect.value = '';
                editVaccineSelectWrapper.classList.remove('hidden');
                editVaccineManualWrapper.classList.add('hidden');
                fieldVaccineName.required = false;
            }
        }

        fieldDoseDetails.value = immunisation.dose_details || '';
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (immunisation.vaccination_date) {
            fieldVaccinationDate.value = immunisation.vaccination_date.split('T')[0];
        } else {
            fieldVaccinationDate.value = '';
        }

        fieldAdministeredBy.value = immunisation.administered_by || '';
        fieldVaccineLotNumber.value = immunisation.vaccine_lot_number || '';
        fieldNotes.value = immunisation.notes || '';
    }
});
