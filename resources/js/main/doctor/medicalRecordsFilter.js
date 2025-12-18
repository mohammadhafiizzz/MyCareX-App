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
    const mainEmptyState = document.querySelector('.text-center.py-12:not(#filteredEmptyState)');
    const filteredEmptyState = document.getElementById('filteredEmptyState');
    
    // Get the table body
    const tableBody = document.getElementById('recordsTableBody');
    
    // Add click event to each filter button
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filterType = this.getAttribute('data-filter');
            
            // Update active button styling
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            });
            
            this.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
            this.classList.add('bg-blue-600', 'text-white');
            
            // Filter the records
            filterRecords(filterType);
        });
    });
    
    /**
     * Filter records based on selected type
     * @param {string} filterType - The type to filter by ('all' or specific type)
     */
    function filterRecords(filterType) {
        let visibleCount = 0;
        
        recordRows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            
            if (filterType === 'all') {
                // Show all records
                row.style.display = '';
                visibleCount++;
            } else if (rowType === filterType) {
                // Show only matching records
                row.style.display = '';
                visibleCount++;
            } else {
                // Hide non-matching records
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
        // This will be handled by pagination script
        // const countElement = document.querySelector('.text-sm.text-gray-600.mt-1');
        // if (countElement) {
        //     countElement.textContent = `Total: ${count} record${count !== 1 ? 's' : ''}`;
        // }
    }
    
    /**
     * Toggle empty state visibility based on record count
     * @param {number} count - Number of visible records
     */
    function toggleEmptyState(count) {
        if (count === 0) {
            // Hide table, show filtered empty state
            if (tableBody) {
                tableBody.closest('.overflow-x-auto').style.display = 'none';
            }
            if (filteredEmptyState) {
                filteredEmptyState.classList.remove('hidden');
            }
        } else {
            // Show table, hide filtered empty state
            if (tableBody) {
                tableBody.closest('.overflow-x-auto').style.display = '';
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
