// Medication Filter and Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    
    let activeStatusFilter = 'all';
    let currentSearchTerm = '';

    // Wait for DOM to be fully ready
    setTimeout(() => {
        initializeFilters();
    }, 100);

    function initializeFilters() {
        const searchInput = document.getElementById('medication-search');
        const clearSearchBtn = document.getElementById('clear-search');
        const medicationsContainer = document.getElementById('medications-list');
        const noFilterResults = document.getElementById('no-filter-results');
        const noSearchResults = document.getElementById('no-search-results');
        const resetFiltersBtn = document.getElementById('reset-all-filters');
        const resetFiltersFromEmptyBtn = document.getElementById('reset-filters-from-empty');
        
        // Get status filter buttons
        const statusButtons = document.querySelectorAll('#filters-section button[aria-label*="status"]');
        
        // Get all medication articles
        const medicationCards = document.querySelectorAll('[data-status]');
        
        console.log('Status buttons found:', statusButtons.length);
        console.log('Medication cards found:', medicationCards.length);
        
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
         * Filter medications based on active filters and search
         */
        function filterMedications() {
            let visibleCount = 0;

            medicationCards.forEach(card => {
                const cardStatus = card.dataset.status.toLowerCase();
                
                // Check status filter
                const statusMatch = activeStatusFilter === 'all' || cardStatus === activeStatusFilter;
                
                // Check search term
                let searchMatch = true;
                if (currentSearchTerm) {
                    const medicationName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                    searchMatch = medicationName.includes(currentSearchTerm);
                }

                if (statusMatch && searchMatch) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show "no results" message if no medications match
            updateNoResultsMessage(visibleCount);
            
            // Trigger pagination update
            if (typeof window.updatePagination === 'function') {
                window.updatePagination();
            }
        }

        /**
         * Show/hide no results message
         */
        function updateNoResultsMessage(visibleCount) {
            // Show appropriate empty state
            if (visibleCount === 0 && medicationCards.length > 0) {
                if (currentSearchTerm) {
                    // Search returned no results
                    if (noSearchResults) {
                        noSearchResults.classList.remove('hidden');
                    }
                    if (noFilterResults) {
                        noFilterResults.classList.add('hidden');
                    }
                } else {
                    // Filters returned no results
                    if (noFilterResults) {
                        noFilterResults.classList.remove('hidden');
                    }
                    if (noSearchResults) {
                        noSearchResults.classList.add('hidden');
                    }
                }
            } else {
                // Hide all no results messages
                if (noFilterResults) {
                    noFilterResults.classList.add('hidden');
                }
                if (noSearchResults) {
                    noSearchResults.classList.add('hidden');
                }
            }
        }

        /**
         * Reset all filters to "All"
         */
        function resetFilters() {
            activeStatusFilter = 'all';
            currentSearchTerm = '';
            
            updateButtonStates(statusButtons, 0);
            
            // Reset search input
            if (searchInput) {
                searchInput.value = '';
            }
            if (clearSearchBtn) {
                clearSearchBtn.classList.add('hidden');
                clearSearchBtn.classList.remove('flex');
            }
            
            filterMedications();
        }

        /**
         * Set up status filter buttons
         */
        statusButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const filterText = button.textContent.trim().toLowerCase();
                activeStatusFilter = filterText;
                
                updateButtonStates(statusButtons, index);
                filterMedications();
            });
        });

        // Set up search
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                currentSearchTerm = e.target.value.toLowerCase().trim();
                
                // Show/hide clear button
                if (currentSearchTerm) {
                    if (clearSearchBtn) {
                        clearSearchBtn.classList.remove('hidden');
                        clearSearchBtn.classList.add('flex');
                    }
                } else {
                    if (clearSearchBtn) {
                        clearSearchBtn.classList.add('hidden');
                        clearSearchBtn.classList.remove('flex');
                    }
                }
                
                filterMedications();
            });
        }
        
        // Clear search button
        if (clearSearchBtn) {
            clearSearchBtn.addEventListener('click', () => {
                searchInput.value = '';
                currentSearchTerm = '';
                clearSearchBtn.classList.add('hidden');
                clearSearchBtn.classList.remove('flex');
                filterMedications();
                searchInput.focus();
            });
        }
        
        // Reset filters button (main button)
        if (resetFiltersBtn) {
            resetFiltersBtn.addEventListener('click', resetFilters);
        }
        
        // Set up the no-results reset button
        if (resetFiltersFromEmptyBtn) {
            resetFiltersFromEmptyBtn.addEventListener('click', resetFilters);
        }
        
        // Initialize filters (show all by default)
        filterMedications();
    }
});
