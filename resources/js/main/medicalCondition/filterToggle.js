/**
 * Toggle filters section on mobile
 */
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggle-filters-btn');
    const filtersSection = document.getElementById('filters-section');
    
    if (toggleBtn && filtersSection) {
        toggleBtn.addEventListener('click', function() {
            const isHidden = filtersSection.classList.contains('hidden');
            
            if (isHidden) {
                filtersSection.classList.remove('hidden');
                toggleBtn.innerHTML = '<i class="fas fa-times" aria-hidden="true"></i><span>Close filters</span>';
                toggleBtn.classList.add('bg-blue-500/10', 'text-blue-700', 'border-blue-400/20');
                toggleBtn.classList.remove('bg-gray-100/60', 'text-gray-700', 'border-white/20');
            } else {
                filtersSection.classList.add('hidden');
                toggleBtn.innerHTML = '<i class="fas fa-filter" aria-hidden="true"></i><span>Filters</span>';
                toggleBtn.classList.remove('bg-blue-500/10', 'text-blue-700', 'border-blue-400/20');
                toggleBtn.classList.add('bg-gray-100/60', 'text-gray-700', 'border-white/20');
            }
        });
    }
    
    // Wire up the reset button in the no-results state
    const resetFromEmpty = document.getElementById('reset-filters-from-empty');
    const resetAllFilters = document.getElementById('reset-all-filters');
    
    if (resetFromEmpty && resetAllFilters) {
        resetFromEmpty.addEventListener('click', function() {
            resetAllFilters.click();
        });
    }
});
