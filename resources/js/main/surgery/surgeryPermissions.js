/**
 * Surgery Permissions Handler
 * 
 * Controls UI elements based on surgery ownership.
 * Disables Edit and Delete buttons for provider-created records.
 * 
 * This script scans all surgery cards on page load and applies
 * Tailwind CSS classes to disable action buttons for records
 * created by healthcare providers (doctor_id is not null).
 */

document.addEventListener('DOMContentLoaded', () => {
    
    // Find all surgery cards/rows
    const surgeryCards = document.querySelectorAll('[data-surgery-id]');
    
    surgeryCards.forEach(card => {
        // Check if this surgery was created by a provider
        const isProviderCreated = card.dataset.providerCreated === 'true';
        const doctorId = card.dataset.doctorId;
        
        // If created by provider, disable edit and delete buttons
        if (isProviderCreated || (doctorId && doctorId !== 'null' && doctorId !== '')) {
            disableActionButtons(card);
        }
    });
    
    /**
     * Disable Edit and Delete buttons for a surgery card
     * @param {HTMLElement} card - The surgery card element
     */
    function disableActionButtons(card) {
        // Find Edit button
        const editButton = card.querySelector('.edit-surgery-btn');
        if (editButton) {
            // Disable the button
            editButton.disabled = true;
            
            // Apply Tailwind CSS classes for disabled state
            editButton.classList.add(
                'opacity-50',
                'cursor-not-allowed',
                'pointer-events-none'
            );
            
            // Remove hover effects
            editButton.classList.remove(
                'hover:bg-gray-50',
                'hover:bg-blue-100'
            );
            
            // Add a visual indicator
            const icon = editButton.querySelector('i');
            if (icon) {
                icon.classList.add('text-gray-400');
            }
            
            // Add tooltip/title
            editButton.title = 'Cannot edit provider-created records';
            
            // Optionally, add a lock icon
            const lockIcon = document.createElement('i');
            lockIcon.className = 'fas fa-lock text-xs ml-1 text-gray-400';
            lockIcon.setAttribute('aria-hidden', 'true');
            editButton.appendChild(lockIcon);
        }
        
        // Find Delete button
        const deleteButton = card.querySelector('.delete-surgery-btn');
        if (deleteButton) {
            // Disable the button
            deleteButton.disabled = true;
            
            // Apply Tailwind CSS classes for disabled state
            deleteButton.classList.add(
                'opacity-50',
                'cursor-not-allowed',
                'pointer-events-none'
            );
            
            // Remove hover effects
            deleteButton.classList.remove(
                'hover:bg-red-50',
                'hover:bg-red-100',
                'hover:text-red-700'
            );
            
            // Add a visual indicator
            const icon = deleteButton.querySelector('i');
            if (icon) {
                icon.classList.add('text-gray-400');
            }
            
            // Add tooltip/title
            deleteButton.title = 'Cannot delete provider-created records';
            
            // Optionally, add a lock icon
            const lockIcon = document.createElement('i');
            lockIcon.className = 'fas fa-lock text-xs ml-1 text-gray-400';
            lockIcon.setAttribute('aria-hidden', 'true');
            deleteButton.appendChild(lockIcon);
        }
        
        // Add a badge/indicator to the card itself
        addProviderBadge(card);
    }
    
    /**
     * Add a visual badge to indicate provider-created record
     * @param {HTMLElement} card - The surgery card element
     */
    function addProviderBadge(card) {
        // Check if badge already exists
        if (card.querySelector('.provider-verified-badge')) {
            return;
        }
        
        // Create the badge
        const badge = document.createElement('span');
        badge.className = 'provider-verified-badge inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200';
        badge.innerHTML = `
            <i class="fas fa-shield-alt" aria-hidden="true"></i>
            Provider Verified
        `;
        
        // Find the badges container (usually with status and other badges)
        const badgesContainer = card.querySelector('.flex.flex-wrap.gap-2');
        if (badgesContainer) {
            badgesContainer.appendChild(badge);
        } else {
            // If no badges container, create one
            const detailsSection = card.querySelector('.flex-1');
            if (detailsSection) {
                const newBadgesContainer = document.createElement('div');
                newBadgesContainer.className = 'mt-4 flex flex-wrap gap-2';
                newBadgesContainer.appendChild(badge);
                detailsSection.appendChild(newBadgesContainer);
            }
        }
    }
    
    /**
     * Initialize event listeners for dynamic content
     * Call this if surgeries are loaded via AJAX
     */
    window.initializeSurgeryPermissions = function() {
        const surgeryCards = document.querySelectorAll('[data-surgery-id]');
        surgeryCards.forEach(card => {
            const isProviderCreated = card.dataset.providerCreated === 'true';
            const doctorId = card.dataset.doctorId;
            
            if (isProviderCreated || (doctorId && doctorId !== 'null' && doctorId !== '')) {
                disableActionButtons(card);
            }
        });
    };
});
