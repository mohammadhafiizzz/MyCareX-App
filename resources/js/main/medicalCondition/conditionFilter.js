document.addEventListener('DOMContentLoaded', () => {
    
    let activeSeverityFilter = 'all';
    let activeStatusFilter = 'all';

    // Get all filter buttons - wait a bit for DOM to be fully ready
    setTimeout(() => {
        initializeFilters();
    }, 100);

    function initializeFilters() {
        const severityButtons = document.querySelectorAll('#filters-section > div > div:nth-child(1) .flex button');
        const statusButtons = document.querySelectorAll('#filters-section > div > div:nth-child(2) .flex button');
        
        // Get all condition cards
        const conditionCards = document.querySelectorAll('[data-severity][data-status]');
        
        console.log('Severity buttons found:', severityButtons.length);
        console.log('Status buttons found:', statusButtons.length);
        console.log('Condition cards found:', conditionCards.length);

        /**
         * Update button states (active/inactive styling)
         */
        function updateButtonStates(buttons, activeIndex) {
        buttons.forEach((btn, index) => {
            if (index === activeIndex) {
                btn.classList.add('bg-blue-500/10', 'backdrop-blur-sm', 'border-blue-400/30', 'text-blue-700', 'shadow-sm');
                btn.classList.remove('bg-gray-100/60', 'border-white/20', 'text-gray-700', 'hover:bg-gray-200/80', 'hover:shadow-md');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('bg-blue-500/10', 'border-blue-400/30', 'text-blue-700', 'shadow-sm');
                btn.classList.add('bg-gray-100/60', 'backdrop-blur-sm', 'border-white/20', 'text-gray-700', 'hover:bg-gray-200/80', 'hover:shadow-md');
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
        
        // Trigger pagination update
        document.dispatchEvent(new Event('filtersChanged'));
        if (typeof window.updateConditionPagination === 'function') {
            window.updateConditionPagination();
        }
    }

        /**
         * Show/hide no results message and update counter
         */
        function updateNoResultsMessage(visibleCount) {
        const noResultsDiv = document.getElementById('no-filter-results');
        const conditionsCountEl = document.getElementById('conditions-count');

        // Update the counter
        if (conditionsCountEl) {
            const countSpan = conditionsCountEl.querySelector('span');
            if (countSpan) {
                countSpan.textContent = visibleCount;
            }
            // Update plural/singular
            const conditionText = visibleCount !== 1 ? 's' : '';
            conditionsCountEl.innerHTML = `Showing <span class="font-medium text-gray-900">${visibleCount}</span> condition${conditionText}`;
        }

        // Show/hide no results message
        if (visibleCount === 0 && conditionCards.length > 0) {
            if (noResultsDiv) {
                noResultsDiv.classList.remove('hidden');
            }
        } else if (noResultsDiv) {
            noResultsDiv.classList.add('hidden');
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

        // Set up the no-results reset button
        const resetFromEmpty = document.getElementById('reset-filters-from-empty');
        if (resetFromEmpty) {
            resetFromEmpty.addEventListener('click', resetFilters);
        }

        // Initialize filters (show all by default)
        filterConditions();
    }
});