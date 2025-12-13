document.addEventListener('DOMContentLoaded', () => {
    
    let activeSeverityFilter = 'all';
    let activeStatusFilter = 'all';

    // Get all filter buttons
    const severityButtons = document.querySelectorAll('[aria-labelledby="conditions-controls-heading"] .space-y-5 > div:first-child button');
    const statusButtons = document.querySelectorAll('[aria-labelledby="conditions-controls-heading"] .space-y-5 > div:last-child button');
    
    // Get all condition cards
    const conditionCards = document.querySelectorAll('[data-severity][data-status]');

    /**
     * Update button states (active/inactive styling)
     */
    function updateButtonStates(buttons, activeIndex) {
        buttons.forEach((btn, index) => {
            if (index === activeIndex) {
                btn.classList.add('bg-blue-50', 'border-blue-400', 'text-blue-800');
                btn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('bg-blue-50', 'border-blue-400', 'text-blue-800');
                btn.classList.add('bg-white', 'border-gray-300', 'text-gray-700', 'hover:bg-gray-50');
                btn.setAttribute('aria-pressed', 'false');
            }
        });
    }

    /**
     * Filter conditions based on active filters
     */
    function filterConditions() {
        let visibleCount = 0;

        conditionCards.forEach(card => {
            const cardSeverity = card.dataset.severity;
            const cardStatus = card.dataset.status;

            const severityMatch = activeSeverityFilter === 'all' || cardSeverity === activeSeverityFilter;
            const statusMatch = activeStatusFilter === 'all' || cardStatus === activeStatusFilter;

            if (severityMatch && statusMatch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show "no results" message if no conditions match
        updateNoResultsMessage(visibleCount);
    }

    /**
     * Show/hide no results message
     */
    function updateNoResultsMessage(visibleCount) {
        const conditionsList = document.getElementById('conditions-list');
        let noResultsDiv = document.getElementById('filter-no-results');

        if (visibleCount === 0 && conditionCards.length > 0) {
            // Create no results message if it doesn't exist
            if (!noResultsDiv) {
                noResultsDiv = document.createElement('div');
                noResultsDiv.id = 'filter-no-results';
                noResultsDiv.className = 'text-center py-12';
                noResultsDiv.innerHTML = `
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full mb-4">
                        <i class="fas fa-search text-gray-600 text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No conditions match your filters</h3>
                    <p class="text-sm text-gray-600 mb-4">Try adjusting your severity or status filters to see more results.</p>
                    <button type="button" id="reset-filters-btn" class="min-h-11 inline-flex items-center gap-3 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                        Reset filters
                    </button>
                `;
                conditionsList.appendChild(noResultsDiv);

                // Add event listener to reset button
                document.getElementById('reset-filters-btn').addEventListener('click', resetFilters);
            } else {
                noResultsDiv.style.display = '';
            }
        } else if (noResultsDiv) {
            noResultsDiv.style.display = 'none';
        }
    }

    /**
     * Reset all filters to "All"
     */
    function resetFilters() {
        activeSeverityFilter = 'all';
        activeStatusFilter = 'all';
        
        updateButtonStates(severityButtons, 0);
        updateButtonStates(statusButtons, 0);
        filterConditions();
    }

    /**
     * Set up severity filter buttons
     */
    severityButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const filterText = button.textContent.trim().toLowerCase();
            activeSeverityFilter = filterText;
            
            updateButtonStates(severityButtons, index);
            filterConditions();
        });
    });

    /**
     * Set up status filter buttons
     */
    statusButtons.forEach((button, index) => {
        button.addEventListener('click', () => {
            const filterText = button.textContent.trim().toLowerCase();
            activeStatusFilter = filterText;
            
            updateButtonStates(statusButtons, index);
            filterConditions();
        });
    });

    /**
     * Set up reset filters button (main button)
     */
    const resetFiltersButton = document.getElementById('reset-all-filters');
    if (resetFiltersButton) {
        resetFiltersButton.addEventListener('click', resetFilters);
    }

    // Initialize filters (show all by default)
    filterConditions();
});