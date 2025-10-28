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

    // Mobile menu active state
    const mobileNavLinks = document.querySelectorAll('#mobileMenu a[href]:not([href="#"])');
    
    // Active state classes for mobile menu
    const activeClasses = {
        link: ['bg-blue-100', 'text-blue-700'],
        icon: ['text-blue-500']
    };

    const inactiveClasses = {
        link: ['text-gray-800', 'hover:bg-gray-50'],
        icon: ['text-gray-700']
    };

    // Function to set active state for mobile menu
    function setActiveMobileNav(activeLink) {
        // Remove active state from all mobile nav links
        mobileNavLinks.forEach(link => {
            const icon = link.querySelector('i');
            
            // Remove active classes
            link.classList.remove(...activeClasses.link);
            if (icon) {
                icon.classList.remove(...activeClasses.icon);
            }
            
            // Add inactive classes
            link.classList.add(...inactiveClasses.link);
            if (icon && !icon.classList.contains('fa-user-edit') && !icon.classList.contains('fa-cog')) {
                icon.classList.add(...inactiveClasses.icon);
            }
        });

        // Set active state for the active link
        const activeIcon = activeLink.querySelector('i');
        
        // Remove inactive classes
        activeLink.classList.remove(...inactiveClasses.link);
        if (activeIcon) {
            activeIcon.classList.remove(...inactiveClasses.icon);
        }
        
        // Add active classes
        activeLink.classList.add(...activeClasses.link);
        if (activeIcon) {
            activeIcon.classList.add(...activeClasses.icon);
        }
    }

    // Set initial active state based on current page
    function setInitialMobileActiveState() {
        const currentPath = window.location.pathname;

        mobileNavLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && currentPath.includes(href.replace(window.location.origin, ''))) {
                setActiveMobileNav(link);
                return;
            }
        });
    }

    // Add click event listeners to mobile nav links
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            setActiveMobileNav(link);
        });
    });

    // Initialize mobile menu active state
    setInitialMobileActiveState();

    // Mobile search modal functionality
    const mobileSearchButton = document.getElementById('mobileSearchButton');
    const searchModal = document.getElementById('searchModal');
    const closeSearchModal = document.getElementById('closeSearchModal');

    if (mobileSearchButton && searchModal) {
        mobileSearchButton.addEventListener('click', function() {
            searchModal.classList.remove('hidden');
        });
    }

    if (closeSearchModal && searchModal) {
        closeSearchModal.addEventListener('click', function() {
            searchModal.classList.add('hidden');
        });

        // Close modal when clicking on backdrop
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) {
                searchModal.classList.add('hidden');
            }
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