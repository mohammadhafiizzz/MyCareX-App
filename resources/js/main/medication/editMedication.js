document.addEventListener('DOMContentLoaded', () => {

    // --- Modal Elements ---
    const editModal = document.getElementById('edit-medication-modal');
    if (!editModal) return; // Stop if the modal isn't on this page

    const editForm = document.getElementById('edit-medication-form');
    const closeButton = document.getElementById('edit-modal-close-button');
    const cancelButton = document.getElementById('edit-modal-cancel-button');

    // --- Form Fields ---
    const fieldMedicationName = document.getElementById('edit_medication_name');
    const fieldDosage = document.getElementById('edit_dosage');
    const fieldStatus = document.getElementById('edit_status');
    const fieldFrequencyNumber = document.getElementById('edit_frequency_number');
    const fieldFrequencyPeriod = document.getElementById('edit_frequency_period');
    const fieldFrequency = document.getElementById('edit_frequency');
    const fieldStartDate = document.getElementById('edit_start_date');
    const fieldEndDate = document.getElementById('edit_end_date');
    const fieldReasonForMed = document.getElementById('edit_reason_for_med');
    const fieldNotes = document.getElementById('edit_notes');
    const errorMessages = document.getElementById('edit-form-error-message');

    // Medication Name Select/Manual Toggle for Edit Form
    const editMedicationSelect = document.getElementById('edit_medication_select');
    const editMedicationManualWrapper = document.getElementById('edit_medication_manual_wrapper');
    const editMedicationSelectWrapper = document.getElementById('edit_medication_select_wrapper');
    const editSwitchToSelectBtn = document.getElementById('edit_switch_to_select');

    if (editMedicationSelect && editMedicationManualWrapper && editMedicationSelectWrapper && editSwitchToSelectBtn && fieldMedicationName) {
        editMedicationSelect.addEventListener('change', function() {
            if (this.value === 'other') {
                editMedicationSelectWrapper.classList.add('hidden');
                editMedicationManualWrapper.classList.remove('hidden');
                fieldMedicationName.value = '';
                fieldMedicationName.focus();
                fieldMedicationName.required = true;
            } else {
                fieldMedicationName.value = this.value;
                fieldMedicationName.required = false;
            }
        });

        editSwitchToSelectBtn.addEventListener('click', function() {
            editMedicationManualWrapper.classList.add('hidden');
            editMedicationSelectWrapper.classList.remove('hidden');
            editMedicationSelect.value = '';
            fieldMedicationName.value = '';
            fieldMedicationName.required = false;
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

    // --- Combine frequency fields before form submission ---
    const combineFrequency = () => {
        const number = fieldFrequencyNumber.value;
        const period = fieldFrequencyPeriod.value;
        
        if (number && period) {
            fieldFrequency.value = `${number} times ${period}`;
        }
    };

    // Update hidden frequency field when either input changes
    if (fieldFrequencyNumber && fieldFrequencyPeriod) {
        fieldFrequencyNumber.addEventListener('change', combineFrequency);
        fieldFrequencyPeriod.addEventListener('change', combineFrequency);
    }

    // --- Attach Listeners to all "Edit" buttons on the page ---
    const editButtons = document.querySelectorAll('.edit-medication-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const medicationId = button.dataset.id;
            
            // 1. Fetch data from the server
            try {
                const response = await fetch(`/patient/my-records/medication/${medicationId}/json`);
                
                if (!response.ok) {
                    throw new Error('Could not retrieve medication data.');
                }
                
                const data = await response.json();
                
                // 2. Populate the form fields
                populateForm(data.medication, medicationId);

                // 3. Open the modal
                openModal();

            } catch (error) {
                // Handle fetch error
                console.error(error);
                alert('Error: Could not load medication details.');
            }
        });
    });

    /**
     * Fills the modal's form fields and sets form action URLs.
     * @param {object} medication - The medication data object from the server.
     * @param {string} id - The ID of the medication.
     */
    function populateForm(medication, id) {
        // Set form action URLs
        const updateUrl = `/patient/my-records/medication/${id}`;
        editForm.setAttribute('action', updateUrl);

        // Set field values
        const medicationName = medication.medication_name || '';
        fieldMedicationName.value = medicationName;

        // Handle medication select/manual toggle
        if (editMedicationSelect && editMedicationSelectWrapper && editMedicationManualWrapper) {
            let optionExists = false;
            for (let i = 0; i < editMedicationSelect.options.length; i++) {
                if (editMedicationSelect.options[i].value === medicationName) {
                    optionExists = true;
                    break;
                }
            }

            if (optionExists) {
                editMedicationSelect.value = medicationName;
                editMedicationSelectWrapper.classList.remove('hidden');
                editMedicationManualWrapper.classList.add('hidden');
                fieldMedicationName.required = false;
            } else if (medicationName !== '') {
                editMedicationSelect.value = 'other';
                editMedicationSelectWrapper.classList.add('hidden');
                editMedicationManualWrapper.classList.remove('hidden');
                fieldMedicationName.required = true;
            } else {
                editMedicationSelect.value = '';
                editMedicationSelectWrapper.classList.remove('hidden');
                editMedicationManualWrapper.classList.add('hidden');
                fieldMedicationName.required = false;
            }
        }

        fieldDosage.value = medication.dosage || '';
        fieldStatus.value = medication.status || '';
        
        // Parse frequency (e.g., "2 times Daily" -> number: 2, period: Daily)
        if (medication.frequency) {
            const frequencyMatch = medication.frequency.match(/^(\d+)\s+times\s+(.+)$/i);
            if (frequencyMatch) {
                fieldFrequencyNumber.value = frequencyMatch[1];
                fieldFrequencyPeriod.value = frequencyMatch[2];
            }
        }
        
        // Combine frequency for hidden field
        combineFrequency();
        
        // Format date from "YYYY-MM-DD ..." to "YYYY-MM-DD" for the input
        if (medication.start_date) {
            fieldStartDate.value = medication.start_date.split('T')[0];
        } else {
            fieldStartDate.value = '';
        }

        if (medication.end_date) {
            fieldEndDate.value = medication.end_date.split('T')[0];
        } else {
            fieldEndDate.value = '';
        }

        fieldReasonForMed.value = medication.reason_for_med || '';
        fieldNotes.value = medication.notes || '';
    }

    // --- Form submission handler ---
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            // Ensure frequency is combined before submission
            combineFrequency();
        });
    }
});
