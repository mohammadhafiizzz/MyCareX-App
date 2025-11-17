document.addEventListener('DOMContentLoaded', function () {
    // Profile dropdown functionality (placeholder for future implementation)
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    // Desktop profile dropdown
    if (profileBtn && profileDropdownMenu) {
        profileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            profileDropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
    }

    // Notification functionality (placeholder)
    const notificationBtn = document.getElementById('notificationBtn');

    if (notificationBtn) {
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Add your notification functionality here
            alert('Notifications clicked! Implement notification modal/dropdown here.');
        });
    }
});
