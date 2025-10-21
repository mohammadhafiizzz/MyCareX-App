document.addEventListener('DOMContentLoaded', () => {
    
    const modal = document.getElementById('add-condition-modal');
    const showButton = document.getElementById('show-add-condition-modal');
    const closeButton = document.getElementById('modal-close-button');
    const cancelButton = document.getElementById('modal-cancel-button');
    const modalPanel = document.getElementById('modal-panel');

    const showModal = () => {
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Use flex for centering
        }
    };

    const hideModal = () => {
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };

    // Show modal when the "Add Condition" button is clicked
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
    if (errorMessageDiv) {
        form.addEventListener('input', () => {
            if (!errorMessageDiv.classList.contains('hidden')) {
                errorMessageDiv.classList.add('hidden');
                errorMessageDiv.innerHTML = '';
            }
        });
    }
});