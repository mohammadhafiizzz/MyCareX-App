document.addEventListener('DOMContentLoaded', () => {
    // Get all immunisation cards
    const immunisationCards = document.querySelectorAll('[data-verification]');
    
    // Get all filter buttons
    const verificationFilterButtons = document.querySelectorAll('button[aria-pressed]');
    
    // Get reset button
    const resetButton = document.getElementById('reset-all-filters');

    // Active filters
    let activeVerificationFilter = 'all';

    // Filter function
    function applyFilters() {
        immunisationCards.forEach(card => {
            const cardVerification = card.dataset.verification;
            
            // Check verification filter
            const verificationMatch = activeVerificationFilter === 'all' || 
                                     cardVerification === activeVerificationFilter;
            
            // Show or hide the card
            if (verificationMatch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Add event listeners to verification filter buttons
    verificationFilterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filterText = button.textContent.trim();
            const filterValue = filterText.toLowerCase().replace(/\s+/g, '-');
            
            // Update active filter
            if (filterText === 'All') {
                activeVerificationFilter = 'all';
            } else {
                activeVerificationFilter = filterValue;
            }
            
            // Update button states
            verificationFilterButtons.forEach(btn => {
                btn.classList.remove('bg-blue-50', 'border-blue-300', 'text-blue-700');
                btn.classList.add('bg-white', 'border-gray-200', 'text-gray-600', 'hover:bg-gray-50');
                btn.setAttribute('aria-pressed', 'false');
            });
            
            button.classList.remove('bg-white', 'border-gray-200', 'text-gray-600', 'hover:bg-gray-50');
            button.classList.add('bg-blue-50', 'border-blue-300', 'text-blue-700');
            button.setAttribute('aria-pressed', 'true');
            
            // Apply filters
            applyFilters();
        });
    });

    // Reset all filters
    if (resetButton) {
        resetButton.addEventListener('click', () => {
            activeVerificationFilter = 'all';
            
            // Reset all filter buttons to default state
            verificationFilterButtons.forEach((btn, index) => {
                if (index === 0) { // First button is "All"
                    btn.classList.remove('bg-white', 'border-gray-200', 'text-gray-600', 'hover:bg-gray-50');
                    btn.classList.add('bg-blue-50', 'border-blue-300', 'text-blue-700');
                    btn.setAttribute('aria-pressed', 'true');
                } else {
                    btn.classList.remove('bg-blue-50', 'border-blue-300', 'text-blue-700');
                    btn.classList.add('bg-white', 'border-gray-200', 'text-gray-600', 'hover:bg-gray-50');
                    btn.setAttribute('aria-pressed', 'false');
                }
            });
            
            // Show all cards
            applyFilters();
        });
    }
});
