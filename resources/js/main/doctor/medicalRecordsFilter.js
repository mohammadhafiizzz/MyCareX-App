/**
 * Medical Records Filter Functionality
 * Filters records by type on the medical records page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    // Get all record rows
    const recordRows = document.querySelectorAll('.record-row');
    
    // Get the empty state elements
    const filteredEmptyState = document.getElementById('filteredEmptyState');
    
    // Get the table body
    const tableBody = document.getElementById('recordsTableBody');
    
    // Get the count element
    const recordsCountText = document.getElementById('doctors-count');

    // Search elements
    const searchInput = document.getElementById('doctor-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const resetSearchBtn = document.getElementById('reset-search');

    let currentFilter = 'all';
    let currentSearch = '';
    
    // Add click event to each filter button
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentFilter = this.getAttribute('data-filter');
            
            // Update active button styling
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Filter the records
            applyFilters();
        });
    });

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentSearch = this.value.toLowerCase();
            
            if (clearSearchBtn) {
                if (currentSearch.length > 0) {
                    clearSearchBtn.classList.remove('hidden');
                } else {
                    clearSearchBtn.classList.add('hidden');
                }
            }
            
            applyFilters();
        });
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                currentSearch = '';
                this.classList.add('hidden');
                applyFilters();
            }
        });
    }

    if (resetSearchBtn) {
        resetSearchBtn.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                currentSearch = '';
                if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
                applyFilters();
            }
        });
    }
    
    /**
     * Apply both search and type filters
     */
    function applyFilters() {
        let visibleCount = 0;
        
        recordRows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            const rowText = row.textContent.toLowerCase();
            
            const matchesFilter = currentFilter === 'all' || rowType === currentFilter;
            const matchesSearch = currentSearch === '' || rowText.includes(currentSearch);
            
            if (matchesFilter && matchesSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update total count in the header
        updateRecordCount(visibleCount);
        
        // Show/hide empty state based on visible records
        toggleEmptyState(visibleCount);
        
        // Trigger pagination refresh
        if (typeof window.refreshPagination === 'function') {
            window.refreshPagination();
        }
        
        // Dispatch custom event for pagination
        document.dispatchEvent(new CustomEvent('filterApplied'));
    }
    
    /**
     * Update the record count display
     * @param {number} count - Number of visible records
     */
    function updateRecordCount(count) {
        if (recordsCountText) {
            recordsCountText.innerHTML = `Showing <span class="font-medium text-gray-900">${count}</span> record${count !== 1 ? 's' : ''}`;
        }
    }
    
    /**
     * Toggle empty state visibility based on record count
     * @param {number} count - Number of visible records
     */
    function toggleEmptyState(count) {
        const tableContainer = tableBody ? tableBody.closest('.overflow-x-auto') : null;
        const paginationControls = document.getElementById('pagination-controls');
        
        if (count === 0) {
            // Hide table and pagination, show filtered empty state
            if (tableContainer) {
                tableContainer.classList.add('hidden');
            }
            if (paginationControls) {
                paginationControls.classList.add('hidden');
            }
            if (filteredEmptyState) {
                filteredEmptyState.classList.remove('hidden');
            }
        } else {
            // Show table and pagination, hide filtered empty state
            if (tableContainer) {
                tableContainer.classList.remove('hidden');
            }
            if (paginationControls) {
                paginationControls.classList.remove('hidden');
            }
            if (filteredEmptyState) {
                filteredEmptyState.classList.add('hidden');
            }
        }
    }
    
    /**
     * Reset filter to show all records
     */
    function resetFilter() {
        filterRecords('all');
        
        // Reset button styling
        filterButtons.forEach(btn => {
            if (btn.getAttribute('data-filter') === 'all') {
                btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            }
        });
    }
    
    // Optional: Add keyboard shortcuts for filtering
    document.addEventListener('keydown', function(e) {
        // Alt + A = All records
        if (e.altKey && e.key === 'a') {
            e.preventDefault();
            resetFilter();
        }
        
        // Alt + C = Conditions
        if (e.altKey && e.key === 'c') {
            e.preventDefault();
            const conditionBtn = document.querySelector('[data-filter="condition"]');
            if (conditionBtn) conditionBtn.click();
        }
        
        // Alt + M = Medications
        if (e.altKey && e.key === 'm') {
            e.preventDefault();
            const medicationBtn = document.querySelector('[data-filter="medication"]');
            if (medicationBtn) medicationBtn.click();
        }
        
        // Alt + L = Allergies
        if (e.altKey && e.key === 'l') {
            e.preventDefault();
            const allergyBtn = document.querySelector('[data-filter="allergy"]');
            if (allergyBtn) allergyBtn.click();
        }
        
        // Alt + I = Immunisations
        if (e.altKey && e.key === 'i') {
            e.preventDefault();
            const immunisationBtn = document.querySelector('[data-filter="immunisation"]');
            if (immunisationBtn) immunisationBtn.click();
        }
        
        // Alt + B = Lab tests (B for blood tests)
        if (e.altKey && e.key === 'b') {
            e.preventDefault();
            const labBtn = document.querySelector('[data-filter="lab"]');
            if (labBtn) labBtn.click();
        }
    });
    
    // Initialize with all records visible
    filterRecords('all');
});
