/**
 * Medical Records Pagination
 * Handles pagination for the medical records table
 * Shows 10 records per page
 */

document.addEventListener('DOMContentLoaded', function() {
    const recordsPerPage = 10;
    let currentPage = 1;
    let totalPages = 1;
    let allRows = [];
    let visibleRows = [];
    
    // Get DOM elements
    const tableBody = document.getElementById('recordsTableBody');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const paginationInfo = document.getElementById('page-info');
    const paginationControls = document.getElementById('pagination-controls');
    const recordsCountText = document.getElementById('doctors-count');
    
    /**
     * Initialize pagination
     */
    function initPagination() {
        if (!tableBody) return;
        
        allRows = Array.from(tableBody.querySelectorAll('.record-row'));
        updateVisibleRows();
        updatePagination();
        
        // Add event listeners
        if (prevPageBtn) {
            prevPageBtn.addEventListener('click', goToPreviousPage);
        }
        
        if (nextPageBtn) {
            nextPageBtn.addEventListener('click', goToNextPage);
        }
    }
    
    /**
     * Update which rows are currently visible (based on filters)
     */
    function updateVisibleRows() {
        visibleRows = allRows.filter(row => {
            return row.style.display !== 'none';
        });
        
        totalPages = Math.max(1, Math.ceil(visibleRows.length / recordsPerPage));
        
        // Reset to page 1 if current page is beyond total pages
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        
        // Hide pagination only if no records at all
        if (paginationControls) {
            if (visibleRows.length === 0) {
                paginationControls.classList.add('hidden');
            } else {
                paginationControls.classList.remove('hidden');
            }
        }
    }
    
    /**
     * Update pagination display and button states
     */
    function updatePagination() {
        updateVisibleRows();
        displayCurrentPage();
        updatePaginationInfo();
        updateButtonStates();
    }
    
    /**
     * Display only the records for the current page
     */
    function displayCurrentPage() {
        // Hide all rows first
        allRows.forEach(row => {
            row.classList.add('pagination-hidden');
        });
        
        // Show only the rows for current page
        const startIndex = (currentPage - 1) * recordsPerPage;
        const endIndex = startIndex + recordsPerPage;
        
        visibleRows.slice(startIndex, endIndex).forEach(row => {
            row.classList.remove('pagination-hidden');
        });
    }
    
    /**
     * Update pagination info text
     */
    function updatePaginationInfo() {
        if (!paginationInfo) return;
        
        if (visibleRows.length === 0) {
            paginationInfo.textContent = 'Page 0 of 0';
        } else {
            paginationInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }
        
        // Update total count text
        if (recordsCountText) {
            const total = visibleRows.length;
            if (total === 0) {
                recordsCountText.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> records`;
            } else {
                const startIndex = (currentPage - 1) * recordsPerPage + 1;
                const endIndex = Math.min(currentPage * recordsPerPage, total);
                recordsCountText.innerHTML = `Showing <span class="font-medium text-gray-900">${startIndex}-${endIndex}</span> of <span class="font-medium text-gray-900">${total}</span> record${total !== 1 ? 's' : ''}`;
            }
        }
    }
    
    /**
     * Update button states (enabled/disabled)
     */
    function updateButtonStates() {
        if (!prevPageBtn || !nextPageBtn) return;
        
        // Previous button
        if (currentPage <= 1) {
            prevPageBtn.disabled = true;
        } else {
            prevPageBtn.disabled = false;
        }
        
        // Next button
        if (currentPage >= totalPages || totalPages === 0) {
            nextPageBtn.disabled = true;
        } else {
            nextPageBtn.disabled = false;
        }
    }
    
    /**
     * Go to previous page
     */
    function goToPreviousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
        }
    }
    
    /**
     * Go to next page
     */
    function goToNextPage() {
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
        }
    }
    
    /**
     * Go to specific page
     * @param {number} pageNumber - The page number to go to
     */
    function goToPage(pageNumber) {
        if (pageNumber >= 1 && pageNumber <= totalPages) {
            currentPage = pageNumber;
            updatePagination();
        }
    }
    
    /**
     * Reset pagination to page 1
     */
    function resetPagination() {
        currentPage = 1;
        updatePagination();
    }
    
    /**
     * Refresh pagination (call this when filters change)
     */
    window.refreshPagination = function() {
        resetPagination();
    };
    
    /**
     * Keyboard shortcuts for pagination
     */
    document.addEventListener('keydown', function(e) {
        // Don't trigger if user is typing in an input
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
            return;
        }
        
        // Arrow left = previous page
        if (e.key === 'ArrowLeft' && e.altKey) {
            e.preventDefault();
            goToPreviousPage();
        }
        
        // Arrow right = next page
        if (e.key === 'ArrowRight' && e.altKey) {
            e.preventDefault();
            goToNextPage();
        }
        
        // Home = first page
        if (e.key === 'Home' && e.altKey) {
            e.preventDefault();
            goToPage(1);
        }
        
        // End = last page
        if (e.key === 'End' && e.altKey) {
            e.preventDefault();
            goToPage(totalPages);
        }
    });
    
    // Add CSS for pagination-hidden class
    const style = document.createElement('style');
    style.textContent = `
        .pagination-hidden {
            display: none !important;
        }
    `;
    document.head.appendChild(style);
    
    // Initialize pagination on page load
    initPagination();
    
    // Listen for filter changes (if filter functionality is implemented)
    document.addEventListener('filterApplied', function() {
        resetPagination();
    });
    
    // Observe changes to table rows (for dynamic content)
    if (tableBody) {
        const observer = new MutationObserver(function(mutations) {
            // Check if rows were added or removed
            const rowsChanged = mutations.some(mutation => {
                return Array.from(mutation.addedNodes).some(node => node.classList && node.classList.contains('record-row')) ||
                       Array.from(mutation.removedNodes).some(node => node.classList && node.classList.contains('record-row'));
            });
            
            if (rowsChanged) {
                allRows = Array.from(tableBody.querySelectorAll('.record-row'));
                updatePagination();
            }
        });
        
        observer.observe(tableBody, { childList: true });
    }
});
