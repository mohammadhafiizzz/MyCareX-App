/**
 * Toggle activity section for medical conditions
 */
function toggleActivity(conditionId) {
    const activitySection = document.getElementById(`activity-${conditionId}`);
    const button = event.currentTarget;
    const icon = button.querySelector('i');
    const text = button.querySelector('.activity-toggle-text');
    
    if (activitySection.classList.contains('hidden')) {
        activitySection.classList.remove('hidden');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
        text.textContent = 'Hide activity';
    } else {
        activitySection.classList.add('hidden');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
        text.textContent = 'Show activity';
    }
}

// Make function available globally
window.toggleActivity = toggleActivity;
