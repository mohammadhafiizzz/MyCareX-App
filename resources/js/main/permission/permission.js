document.addEventListener('DOMContentLoaded', function () {
    const revokeBtns = document.querySelectorAll('.revoke-access-btn');
    const revokeModal = document.getElementById('revokePermissionModal');
    const closeRevokeModal = document.getElementById('closeRevokeModal');
    const confirmRevokeBtn = document.getElementById('confirmRevokeBtn');
    const confirmInput = document.getElementById('confirm_revoke_word');
    const revokeError = document.getElementById('revoke_error');
    const doctorNameSpan = document.getElementById('revokeDoctorName');

    let currentProviderId = null;
    let currentDoctorId = null;

    // Open Modal
    revokeBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            currentProviderId = this.getAttribute('data-provider-id');
            currentDoctorId = this.getAttribute('data-doctor-id');
            const doctorName = this.getAttribute('data-doctor-name');
            
            if (doctorNameSpan) doctorNameSpan.textContent = doctorName;
            
            if (revokeModal) {
                revokeModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    });

    // Close Modal
    if (closeRevokeModal) {
        closeRevokeModal.addEventListener('click', function () {
            if (revokeModal) {
                revokeModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                confirmInput.value = '';
                revokeError.classList.add('hidden');
                currentProviderId = null;
                currentDoctorId = null;
            }
        });
    }

    // Confirm Revoke
    if (confirmRevokeBtn) {
        confirmRevokeBtn.addEventListener('click', function () {
            const confirmationWord = confirmInput.value.trim();

            if (confirmationWord !== 'REVOKE') {
                revokeError.classList.remove('hidden');
                return;
            }

            // Disable button and show loading state
            confirmRevokeBtn.disabled = true;
            confirmRevokeBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Revoking...';

            fetch(`/patient/permissions/revoke`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    provider_id: currentProviderId,
                    doctor_id: currentDoctorId,
                    confirmation: confirmationWord
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect || '/patient/permissions';
                } else {
                    revokeError.textContent = data.message || 'An error occurred.';
                    revokeError.classList.remove('hidden');
                    confirmRevokeBtn.disabled = false;
                    confirmRevokeBtn.innerHTML = 'Revoke Access';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                revokeError.textContent = 'An unexpected error occurred. Please try again.';
                revokeError.classList.remove('hidden');
                confirmRevokeBtn.disabled = false;
                confirmRevokeBtn.innerHTML = 'Revoke Access';
            });
        });
    }

    // Clear error on input
    if (confirmInput) {
        confirmInput.addEventListener('input', function() {
            revokeError.classList.add('hidden');
        });
    }

    // --- Search and Pagination Logic ---
    const ITEMS_PER_PAGE = 5;
    let currentPage = 1;
    let filteredCards = [];
    
    const searchInput = document.getElementById('doctor-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const clearSearchEmptyBtn = document.getElementById('clear-search-empty');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const pageInfo = document.getElementById('page-info');
    const doctorsCount = document.getElementById('doctors-count');
    
    const doctorCards = Array.from(document.querySelectorAll('.doctor-card'));
    
    /**
     * Get all visible cards based on search
     */
    function getVisibleCards() {
        return doctorCards.filter(card => {
            // Check search term
            if (searchInput && searchInput.value.trim()) {
                const searchTerm = searchInput.value.toLowerCase();
                const doctorName = card.dataset.doctorName || '';
                const facilityName = card.dataset.facilityName || '';
                return doctorName.includes(searchTerm) || facilityName.includes(searchTerm);
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
        doctorCards.forEach(card => {
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
     * Update the doctors counter
     */
    function updateCounter() {
        if (doctorsCount) {
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE + 1;
            const endIndex = Math.min(currentPage * ITEMS_PER_PAGE, filteredCards.length);
            const total = filteredCards.length;
            
            if (total === 0) {
                doctorsCount.innerHTML = `Showing <span class="font-medium text-gray-900">0</span> doctors`;
            } else {
                doctorsCount.innerHTML = `Showing <span class="font-medium text-gray-900">${startIndex}-${endIndex}</span> of <span class="font-medium text-gray-900">${total}</span> doctor${total !== 1 ? 's' : ''}`;
            }
        }
    }
    
    /**
     * Check if we should show no results message
     */
    function checkNoResults() {
        const noSearchResults = document.getElementById('no-search-results');
        const paginationControls = document.getElementById('pagination-controls');
        
        if (filteredCards.length === 0 && doctorCards.length > 0) {
            // Hide pagination if no results
            if (paginationControls) {
                paginationControls.classList.add('hidden');
            }
            
            // Show appropriate no results message
            if (searchInput && searchInput.value.trim()) {
                if (noSearchResults) {
                    noSearchResults.classList.remove('hidden');
                }
            }
        } else {
            // Show pagination
            if (paginationControls) {
                paginationControls.classList.remove('hidden');
            }
            
            // Hide no results message
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
    function clearSearch() {
        if (searchInput) {
            searchInput.value = '';
            if (clearSearchBtn) clearSearchBtn.classList.add('hidden');
            currentPage = 1;
            updatePagination();
            searchInput.focus();
        }
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', clearSearch);
    }

    if (clearSearchEmptyBtn) {
        clearSearchEmptyBtn.addEventListener('click', clearSearch);
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
    
    // Initial pagination setup
    if (doctorCards.length > 0) {
        updatePagination();
    }
});