/**
 * Pagination and Search functionality for Access Requests List
 */
document.addEventListener('DOMContentLoaded', () => {
    const ITEMS_PER_PAGE = 10;
    let currentPage = 1;
    let filteredRows = [];
    
    const searchInput = document.getElementById('request-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const resetSearchBtn = document.getElementById('reset-search');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    const requestsCount = document.getElementById('requests-count');
    
    const requestRows = Array.from(document.querySelectorAll('.request-row'));
    
    /**
     * Get all visible rows based on search
     */
    function getVisibleRows() {
        return requestRows.filter(row => {
            // Check search term
            if (searchInput && searchInput.value.trim()) {
                const searchTerm = searchInput.value.toLowerCase();
                const patientName = row.querySelector('.patient-name')?.textContent.toLowerCase() || '';
                const patientIC = row.querySelector('.patient-ic')?.textContent.toLowerCase() || '';
                const patientEmail = row.querySelector('.patient-email')?.textContent.toLowerCase() || '';
                return patientName.includes(searchTerm) || patientIC.includes(searchTerm) || patientEmail.includes(searchTerm);
            }
            
            return true;
        });
    }
    
    /**
     * Update pagination display
     */
    function updatePagination() {
        filteredRows = getVisibleRows();
        const totalPages = Math.max(1, Math.ceil(filteredRows.length / ITEMS_PER_PAGE));
        
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
        
        // Show/hide rows based on current page
        showCurrentPage();
    }
    
    /**
     * Show rows for current page only
     */
    function showCurrentPage() {
        const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
        const endIndex = startIndex + ITEMS_PER_PAGE;
        
        // First, hide all rows
        requestRows.forEach(row => {
            row.classList.add('hidden');
        });
        
        // Show only rows on current page
        filteredRows.slice(startIndex, endIndex).forEach(row => {
            row.classList.remove('hidden');
        });
        
        // Check if we need to show no results message
        checkNoResults();
    }
    
    /**
     * Update the requests counter
     */
    function updateCounter() {
        if (requestsCount) {
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const endIndex = Math.min(currentPage * ITEMS_PER_PAGE, filteredRows.length);
            const total = filteredRows.length;
            
            if (total === 0) {
                requestsCount.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> requests`;
            } else {
                requestsCount.innerHTML = `Showing <span class="font-medium text-gray-900">${startIndex}-${endIndex}</span> of <span class="font-medium text-gray-900">${total}</span> request${total !== 1 ? 's' : ''}`;
            }
        }
    }
    
    /**
     * Check if we should show no results message
     */
    function checkNoResults() {
        const noSearchResults = document.getElementById('no-search-results');
        const paginationControls = document.getElementById('pagination-controls');
        const tableContainer = document.querySelector('.overflow-x-auto');
        
        if (filteredRows.length === 0 && requestRows.length > 0) {
            // Hide pagination and table if no results
            if (paginationControls) paginationControls.classList.add('hidden');
            if (tableContainer) tableContainer.classList.add('hidden');
            
            // Show appropriate no results message
            if (noSearchResults) {
                noSearchResults.classList.remove('hidden');
            }
        } else {
            // Show pagination and table
            if (paginationControls) paginationControls.classList.remove('hidden');
            if (tableContainer) tableContainer.classList.remove('hidden');
            
            // Hide all no results messages
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
     * Handle reset search button (from no results)
     */
    if (resetSearchBtn) {
        resetSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
            currentPage = 1;
            updatePagination();
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
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
    
    /**
     * Handle next page button
     */
    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', () => {
            const totalPages = Math.ceil(filteredRows.length / ITEMS_PER_PAGE);
            if (currentPage < totalPages) {
                currentPage++;
                updatePagination();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
    
    // Initial pagination setup
    updatePagination();
});
