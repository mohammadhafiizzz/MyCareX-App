// Medication Pagination Functionality
document.addEventListener('DOMContentLoaded', function() {
    const medicationsContainer = document.getElementById('medications-list');
    const prevButton = document.getElementById('prev-page');
    const nextButton = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    
    const itemsPerPage = 5;
    let currentPage = 1;
    let totalPages = 1;
    
    // Initialize pagination
    function initializePagination() {
        updatePagination();
        
        if (prevButton) {
            prevButton.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });
        }
        
        if (nextButton) {
            nextButton.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });
        }
    }
    
    function updatePagination() {
        if (!medicationsContainer) return;
        
        // Get all visible medications (not hidden by filters)
        const allMedications = Array.from(medicationsContainer.querySelectorAll('article'));
        const visibleMedications = allMedications.filter(med => med.style.display !== 'none');
        
        // Calculate total pages
        totalPages = Math.ceil(visibleMedications.length / itemsPerPage) || 1;
        
        // Ensure current page is valid
        if (currentPage > totalPages) {
            currentPage = totalPages;
        }
        
        // Calculate start and end indices
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        
        // Hide all medications first
        allMedications.forEach(med => {
            if (med.style.display !== 'none') {
                med.classList.add('pagination-hidden');
            }
        });
        
        // Show only medications for current page
        visibleMedications.forEach((med, index) => {
            if (index >= startIndex && index < endIndex) {
                med.classList.remove('pagination-hidden');
            }
        });
        
        // Update page info
        if (pageInfo) {
            pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;
        }
        
        // Update counter
        updateCounter();
        
        // Update button states
        if (prevButton) {
            prevButton.disabled = currentPage === 1;
        }
        
        if (nextButton) {
            nextButton.disabled = currentPage === totalPages;
        }
    }
    
    // Update the medications counter
    function updateCounter() {
        const medicationsCount = document.getElementById('medications-count');
        if (medicationsCount) {
            const allMedications = Array.from(medicationsContainer.querySelectorAll('article'));
            const visibleMedications = allMedications.filter(med => med.style.display !== 'none');
            
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, visibleMedications.length);
            const total = visibleMedications.length;
            
            if (total === 0) {
                medicationsCount.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> medications`;
            } else {
                medicationsCount.innerHTML = `Showing <span class="font-medium text-gray-900">${startItem}-${endItem}</span> of <span class="font-medium text-gray-900">${total}</span> medication${total !== 1 ? 's' : ''}`;
            }
        }
    }
    
    // Make updatePagination available globally for filter integration
    window.updatePagination = function() {
        currentPage = 1; // Reset to first page when filters change
        updatePagination();
    };
    
    // Initialize
    initializePagination();
    
    // Add CSS for pagination hidden state
    const style = document.createElement('style');
    style.textContent = `
        article.pagination-hidden {
            display: none !important;
        }
    `;
    document.head.appendChild(style);
});
