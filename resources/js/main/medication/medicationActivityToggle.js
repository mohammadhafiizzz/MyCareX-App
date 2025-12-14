// Medication Activity Toggle Functionality
function toggleMedicationActivity(medicationId) {
    const activitySection = document.getElementById(`medication-activity-${medicationId}`);
    const button = event.currentTarget;
    const icon = button.querySelector('i');
    const text = button.querySelector('.activity-toggle-text');
    
    if (activitySection) {
        // Toggle the activity section
        activitySection.classList.toggle('hidden');
        
        // Update button appearance
        if (activitySection.classList.contains('hidden')) {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
            text.textContent = 'Show activity';
        } else {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
            text.textContent = 'Hide activity';
        }
    }
}

// Make the function globally accessible
window.toggleMedicationActivity = toggleMedicationActivity;
