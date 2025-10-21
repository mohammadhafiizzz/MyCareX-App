document.addEventListener('DOMContentLoaded', function () {
    // Profile dropdown functionality
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

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

    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Notification functionality (placeholder)
    const notificationBtn = document.getElementById('notificationBtn');
    const mobileNotificationBtn = document.getElementById('mobileNotificationBtn');

    if (notificationBtn) {
        notificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Add your notification functionality here
            alert('Notifications clicked! Implement notification modal/dropdown here.');
        });
    }

    if (mobileNotificationBtn) {
        mobileNotificationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Add your mobile notification functionality here
            alert('Mobile notifications clicked!');
        });
    }
});