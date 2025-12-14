document.addEventListener('DOMContentLoaded', () => {
    
    let activeVerificationFilter = 'all';

    // Get all filter buttons - wait a bit for DOM to be fully ready
    setTimeout(() => {
        initializeFilters();
    }, 100);

    function initializeFilters() {
        const verificationButtons = document.querySelectorAll('#filters-section > div > div .flex button');
        
        // Get all immunisation cards
        const immunisationCards = document.querySelectorAll('[data-verification]');
        
        console.log('Verification buttons found:', verificationButtons.length);
        console.log('Immunisation cards found:', immunisationCards.length);

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
         * Filter immunisations based on active filters
         */
        function filterImmunisations() {
            let visibleCount = 0;

            immunisationCards.forEach(card => {
                const cardVerification = card.dataset.verification;

                const verificationMatch = activeVerificationFilter === 'all' || cardVerification === activeVerificationFilter;

                if (verificationMatch) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show "no results" message if no immunisations match
            updateNoResultsMessage(visibleCount);
            
            // Trigger pagination update
            document.dispatchEvent(new Event('filtersChanged'));
            if (typeof window.updateImmunisationPagination === 'function') {
                window.updateImmunisationPagination();
            }
        }

        /**
         * Show/hide no results message and update counter
         */
        function updateNoResultsMessage(visibleCount) {
            const noResultsDiv = document.getElementById('no-filter-results');
            const immunisationsCountEl = document.getElementById('immunisations-count');

            // Update the counter
            if (immunisationsCountEl) {
                const countSpan = immunisationsCountEl.querySelector('span');
                if (countSpan) {
                    countSpan.textContent = visibleCount;
                }
                // Update plural/singular
                const vaccinationText = visibleCount !== 1 ? 's' : '';
                immunisationsCountEl.innerHTML = `Showing <span class="font-medium text-gray-900">${visibleCount}</span> vaccination${vaccinationText}`;
            }

            // Show/hide no results message
            if (visibleCount === 0 && immunisationCards.length > 0) {
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
            activeVerificationFilter = 'all';
            
            updateButtonStates(verificationButtons, 0);
            filterImmunisations();
        }

        /**
         * Set up verification filter buttons
         */
        verificationButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const filterText = button.textContent.trim().toLowerCase();
                activeVerificationFilter = filterText;
                
                updateButtonStates(verificationButtons, index);
                filterImmunisations();
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
        filterImmunisations();
    }
});
