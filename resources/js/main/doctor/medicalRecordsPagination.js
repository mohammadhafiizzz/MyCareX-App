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
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationControls = document.getElementById('paginationControls');
    const recordsCountText = document.getElementById('recordsCountText');
    
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
        
        totalPages = Math.ceil(visibleRows.length / recordsPerPage);
        
        // Reset to page 1 if current page is beyond total pages
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = 1;
        }
        
        // Hide pagination if no records or only one page
        if (paginationControls) {
            if (visibleRows.length <= recordsPerPage) {
                paginationControls.style.display = 'none';
            } else {
                paginationControls.style.display = 'flex';
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
            if (row.style.display !== 'none') {
                row.classList.add('pagination-hidden');
            }
        });
        
        // Calculate start and end indices
        const startIndex = (currentPage - 1) * recordsPerPage;
        const endIndex = startIndex + recordsPerPage;
        
        // Show only the rows for current page
        visibleRows.slice(startIndex, endIndex).forEach(row => {
            row.classList.remove('pagination-hidden');
        });
    }
    
    /**
     * Update pagination info text
     */
    function updatePaginationInfo() {
        if (!paginationInfo) return;
        
        if (totalPages === 0) {
            paginationInfo.textContent = 'No records';
        } else {
            const startRecord = ((currentPage - 1) * recordsPerPage) + 1;
            const endRecord = Math.min(currentPage * recordsPerPage, visibleRows.length);
            paginationInfo.textContent = `${startRecord}-${endRecord} of ${visibleRows.length}`;
        }
        
        // Update total count text
        if (recordsCountText) {
            const totalRecords = allRows.length;
            const visibleCount = visibleRows.length;
            
            if (visibleCount === totalRecords) {
                recordsCountText.textContent = `Total: ${totalRecords} record${totalRecords !== 1 ? 's' : ''}`;
            } else {
                recordsCountText.textContent = `Showing: ${visibleCount} of ${totalRecords} record${totalRecords !== 1 ? 's' : ''}`;
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
