/**
 * Patient Details Tabs Handler
 * Manages tab switching for patient medical records view
 */

function showTab(tabName) {
    // Hide all tab content
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active state from all tabs
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
        
        // Reset badge colors to gray
        const badge = button.querySelector('span');
        if (badge) {
            badge.classList.remove('bg-blue-100', 'text-blue-600');
            badge.classList.add('bg-gray-100', 'text-gray-600');
        }
    });

    // Show selected tab content
    const selectedContent = document.getElementById(`content-${tabName}`);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }

    // Add active state to selected tab
    const selectedTab = document.getElementById(`tab-${tabName}`);
    if (selectedTab) {
        selectedTab.classList.remove('border-transparent', 'text-gray-500');
        selectedTab.classList.add('border-blue-500', 'text-blue-600');
        
        // Update badge color to blue
        const activeBadge = selectedTab.querySelector('span');
        if (activeBadge) {
            activeBadge.classList.remove('bg-gray-100', 'text-gray-600');
            activeBadge.classList.add('bg-blue-100', 'text-blue-600');
        }
    }
}

// Make showTab available globally for onclick handlers
window.showTab = showTab;
