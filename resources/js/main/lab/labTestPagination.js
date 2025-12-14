/**
 * Pagination and Search functionality for Lab Tests
 */
document.addEventListener('DOMContentLoaded', () => {
    const ITEMS_PER_PAGE = 5;
    let currentPage = 1;
    let filteredCards = [];
    
    const searchInput = document.getElementById('labtest-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    const labTestsCount = document.getElementById('labtests-count');
    
    const labTestCards = Array.from(document.querySelectorAll('[data-verification]'));
    
    /**
     * Get all visible cards based on current filters and search
     */
    function getVisibleCards() {
        return labTestCards.filter(card => {
            // Check if card is hidden by filters
            if (card.style.display === 'none') {
                return false;
            }
            
            // Check search term
            if (searchInput && searchInput.value.trim()) {
                const searchTerm = searchInput.value.toLowerCase();
                const labTestName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                return labTestName.includes(searchTerm);
            }
            
            return true;
        });
    }
    
    /**
     * Update pagination display
     */
    function updatePagination() {
        filteredCards = getVisibleCards();
        const totalPages = Math.max(1, Math.ceil(filteredCards.length / ITEMS_PER_PAGE));
        
        // Adjust current page if necessary
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        
        // Update page info
        if (pageInfo) {
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }
        
        // Update button states
        if (prevPageBtn) {
            prevPageBtn.disabled = currentPage === 1;
        }
        if (nextPageBtn) {
            nextPageBtn.disabled = currentPage === totalPages;
        }
        
        // Update counter
        updateCounter();
        
        // Show/hide cards based on current page
        showCurrentPage();
    }
    
    /**
     * Show cards for current page only
     */
    function showCurrentPage() {
        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;
        
        // First, hide all cards
        labTestCards.forEach(card => {
            card.classList.add('hidden');
        });
        
        // Show only cards on current page
        filteredCards.slice(startIndex, endIndex).forEach(card => {
            card.classList.remove('hidden');
        });
        
        // Check if we need to show no results message
        checkNoResults();
    }
    
    /**
     * Update the lab tests counter
     */
    function updateCounter() {
        if (labTestsCount) {
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const endIndex = Math.min(currentPage * ITEMS_PER_PAGE, filteredCards.length);
            const total = filteredCards.length;
            
            if (total === 0) {
                labTestsCount.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> tests`;
            } else {
                const testText = total !== 1 ? 's' : '';
                labTestsCount.innerHTML = `Showing <span class="font-medium text-gray-900">${startIndex}-${endIndex}</span> of <span class="font-medium text-gray-900">${total}</span> test${testText}`;
            }
        }
    }
    
    /**
     * Check if we should show no results message
     */
    function checkNoResults() {
        const noResultsDiv = document.getElementById('no-filter-results');
        const noSearchResults = document.getElementById('no-search-results');
        
        if (filteredCards.length === 0 && labTestCards.length > 0) {
            // Hide pagination if no results
            if (document.getElementById('pagination-controls')) {
                document.getElementById('pagination-controls').classList.add('hidden');
            }
            
            // Show appropriate no results message
            if (searchInput && searchInput.value.trim()) {
                // Search returned no results
                if (noSearchResults) {
                    noSearchResults.classList.remove('hidden');
                }
                if (noResultsDiv) {
                    noResultsDiv.classList.add('hidden');
                }
            } else {
                // Filters returned no results
                if (noResultsDiv) {
                    noResultsDiv.classList.remove('hidden');
                }
                if (noSearchResults) {
                    noSearchResults.classList.add('hidden');
                }
            }
        } else {
            // Show pagination
            if (document.getElementById('pagination-controls')) {
                document.getElementById('pagination-controls').classList.remove('hidden');
            }
            
            // Hide all no results messages
            if (noResultsDiv) {
                noResultsDiv.classList.add('hidden');
            }
            if (noSearchResults) {
                noSearchResults.classList.add('hidden');
            }
        }
    }
    
    /**
     * Handle search input
     */
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const value = e.target.value.trim();
            
            // Show/hide clear button
            if (clearSearchBtn) {
                if (value) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }
            }
            
            // Reset to first page and update
            currentPage = 1;
            updatePagination();
        });
    }
    
    /**
     * Handle clear search button
     */
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearSearchBtn.classList.add('hidden');
            currentPage = 1;
            updatePagination();
            searchInput.focus();
        });
    }
    
    /**
     * Handle previous page button
     */
    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updatePagination();
            }
        });
    }
    
    /**
     * Handle next page button
     */
    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredCards.length / ITEMS_PER_PAGE);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
            }
        });
    }
    
    /**
     * Listen for filter changes from labTestFilter.js
     * This is triggered when filters are applied
     */
    document.addEventListener('filtersChanged', () => {
        currentPage = 1;
        updatePagination();
    });
    
    // Initial pagination setup
    updatePagination();
    
    // Make updatePagination available globally for filter integration
    window.updateLabTestPagination = updatePagination;
});
