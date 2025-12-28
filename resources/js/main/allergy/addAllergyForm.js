document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('add-allergy-modal');
    const showButton = document.getElementById('show-add-allergy-modal');
    const closeButton = document.getElementById('modal-close-button');
    const cancelButton = document.getElementById('modal-cancel-button');
    const modalPanel = document.getElementById('modal-panel');
    const form = document.getElementById('add-allergy-form');

    const showModal = () => {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Use flex for centering
            document.body.classList.add('overflow-hidden'); // Prevent background scrolling
        }
    };

    const hideModal = () => {
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden'); // Restore background scrolling
        }
    };

    // Show modal when the "Add Allergy" button is clicked
    if (showButton) {
        showButton.addEventListener('click', showModal);
    }

    // Hide modal when the 'X' button is clicked
    if (closeButton) {
        closeButton.addEventListener('click', hideModal);
    }

    // Hide modal when the "Cancel" button is clicked
    if (cancelButton) {
        cancelButton.addEventListener('click', hideModal);
    }

    // Hide modal when clicking on the background (outside the panel)
    if (modal) {
        modal.addEventListener('click', (event) => {
            // Check if the click is on the modal background itself,
            // not on its children (the panel)
            if (event.target === modal) {
                hideModal();
            }
        });
    }

    // Hide any server-rendered error container when user focuses inputs
    const errorMessageDiv = document.getElementById('form-error-message');
    if (errorMessageDiv && form) { // Add form check here
        form.addEventListener('input', () => {
            if (!errorMessageDiv.classList.contains('hidden')) {
                errorMessageDiv.classList.add('hidden');
                errorMessageDiv.innerHTML = '';
            }
        });
    }

    // Allergy Select Toggle Logic
    const select = document.getElementById('allergen_select');
    const selectWrapper = document.getElementById('allergen_select_wrapper');
    const manualWrapper = document.getElementById('allergen_manual_wrapper');
    const manualInput = document.getElementById('allergen');
    const switchToSelectBtn = document.getElementById('switch_to_select');

    // Logic to toggle between Select and Manual Input
    select.addEventListener('change', function() {
        if (this.value === 'manual_entry') {
            // User chose "Other" -> Hide select, Show input
            selectWrapper.classList.add('hidden');
            manualWrapper.classList.remove('hidden');
            manualInput.value = ''; // Clear input for fresh typing
            manualInput.focus();
        } else {
            // User chose a standard option -> Update hidden input
            manualInput.value = this.value;
        }
    });

    // Logic to switch back to Dropdown
    switchToSelectBtn.addEventListener('click', function() {
        manualWrapper.classList.add('hidden');
        selectWrapper.classList.remove('hidden');
        select.value = ""; // Reset dropdown
        manualInput.value = ""; // Clear value
    });

    // Initialize input with select value if one exists (e.g. on re-edit)
    if(select.value && select.value !== 'manual_entry') {
            manualInput.value = select.value;
    }

    // Allergy Type Select Toggle Logic
    const selectType = document.getElementById('allergy_type_select');
    const selectTypeWrapper = document.getElementById('allergy_type_select_wrapper');
    const manualTypeWrapper = document.getElementById('allergy_type_manual_wrapper');
    const manualTypeInput = document.getElementById('allergy_type');
    const TypeswitchToSelectBtn = document.getElementById('type_switch_to_select');
    // Logic to toggle between Select and Manual Input
    selectType.addEventListener('change', function() {
        if (this.value === 'manual_entry') {
            // User chose "Other" -> Hide select, Show input
            selectTypeWrapper.classList.add('hidden');
            manualTypeWrapper.classList.remove('hidden');
            manualTypeInput.value = ''; // Clear input for fresh typing
            manualTypeInput.focus();
        } else {
            // User chose a standard option -> Update hidden input
            manualTypeInput.value = this.value;
        }
    });

    // Logic to switch back to Dropdown
    TypeswitchToSelectBtn.addEventListener('click', function() {
        manualTypeWrapper.classList.add('hidden');
        selectTypeWrapper.classList.remove('hidden');
        selectType.value = ""; // Reset dropdown
        manualTypeInput.value = ""; // Clear value
    });

    // Initialize input with select value if one exists (e.g. on re-edit)
    if(selectType.value && selectType.value !== 'manual_entry') {
            manualTypeInput.value = selectType.value;
    }
});
