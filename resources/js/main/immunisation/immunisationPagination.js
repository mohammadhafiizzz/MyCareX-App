/**
 * Pagination and Search functionality for Immunisations
 */
document.addEventListener('DOMContentLoaded', () => {
    const ITEMS_PER_PAGE = 5;
    let currentPage = 1;
    let filteredCards = [];
    
    const searchInput = document.getElementById('immunisation-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    const immunisationsCount = document.getElementById('immunisations-count');
    
    const immunisationCards = Array.from(document.querySelectorAll('[data-verification]'));
    
    /**
     * Get cards based on search only (filters removed)
     */
    function getVisibleCards() {
        return immunisationCards.filter(card => {
            // Search by immunisation name
            if (searchInput && searchInput.value.trim()) {
                const searchTerm = searchInput.value.toLowerCase();
                const immunisationName = card.querySelector('h3')?.textContent.toLowerCase() || '';
                return immunisationName.includes(searchTerm);
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
        immunisationCards.forEach(card => {
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
     * Update the immunisations counter
     */
    function updateCounter() {
        if (immunisationsCount) {
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const endIndex = Math.min(currentPage * ITEMS_PER_PAGE, filteredCards.length);
            const total = filteredCards.length;
            
            if (total === 0) {
                immunisationsCount.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> vaccinations`;
            } else {
                const vaccinationText = total !== 1 ? 's' : '';
                immunisationsCount.innerHTML = `Showing <span class="font-medium text-gray-900">${startIndex}-${endIndex}</span> of <span class="font-medium text-gray-900">${total}</span> vaccination${vaccinationText}`;
            }
        }
    }
    
    /**
     * Show no results message (filters removed, only search considered)
     */
    function checkNoResults() {
        const noSearchResults = document.getElementById('no-search-results');
        const paginationControls = document.getElementById('pagination-controls');

        if (filteredCards.length === 0 && immunisationCards.length > 0) {
            if (paginationControls) paginationControls.classList.add('hidden');
            if (noSearchResults) noSearchResults.classList.remove('hidden');
        } else {
            if (paginationControls) paginationControls.classList.remove('hidden');
            if (noSearchResults) noSearchResults.classList.add('hidden');
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
    
    // Removed filter integration: no longer listening for filter changes
    
    // Initial pagination setup
    updatePagination();
    
    // Expose pagination update if needed elsewhere (optional)
    window.updateImmunisationPagination = updatePagination;
});
