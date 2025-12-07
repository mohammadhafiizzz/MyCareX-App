/**
 * Hospitalisation Permissions Handler
 * 
 * Disables edit and delete buttons for provider-created hospitalisation records.
 * Adds visual indicators to distinguish provider-created vs patient-created records.
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // Find all hospitalisation record articles
    const hospitalisationCards = document.querySelectorAll('[data-hospitalisation-id]');
    
    hospitalisationCards.forEach(card => {
        const isProviderCreated = card.dataset.providerCreated === 'true';
        const doctorId = card.dataset.doctorId;
        
        // If the record was created by a provider (doctor_id is not null)
        if (isProviderCreated && doctorId && doctorId !== 'null' && doctorId !== '') {
            disableActionButtons(card);
            addProviderBadge(card);
        }
    });

    /**
     * Disable edit and delete buttons for provider-created records
     */
    function disableActionButtons(card) {
        // Find edit button
        const editButton = card.querySelector('.edit-hospitalisation-btn');
        if (editButton) {
            editButton.disabled = true;
            editButton.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            editButton.classList.remove('hover:bg-blue-100');
            editButton.title = 'Cannot edit provider-created records';
        }
        
        // Find delete button
        const deleteButton = card.querySelector('.delete-hospitalisation-btn');
        if (deleteButton) {
            deleteButton.disabled = true;
            deleteButton.classList.add('opacity-50', 'cursor-not-allowed', 'pointer-events-none');
            deleteButton.classList.remove('hover:bg-red-50');
            deleteButton.title = 'Cannot delete provider-created records';
        }
    }

    /**
     * Add a visual badge to indicate provider-created records
     */
    function addProviderBadge(card) {
        // Check if badge already exists
        const existingBadge = card.querySelector('.provider-badge');
        if (existingBadge) return;
        
        // Find the badges container
        const badgesContainer = card.querySelector('.flex.flex-wrap.gap-2');
        
        if (badgesContainer) {
            // Create provider badge
            const providerBadge = document.createElement('span');
            providerBadge.className = 'provider-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200';
            providerBadge.innerHTML = `
                <i class="fas fa-user-md" aria-hidden="true"></i>
                Provider Created
            `;
            
            // Add badge to container
            badgesContainer.appendChild(providerBadge);
        }
    }
});
