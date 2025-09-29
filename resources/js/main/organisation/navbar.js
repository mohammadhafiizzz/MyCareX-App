document.addEventListener('DOMContentLoaded', () => {
    // Get all navigation links from navbar
    const navLinks = document.querySelectorAll('nav .md\\:flex a');

    // Active state classes
    const activeClasses = {
        link: ['bg-blue-100', 'text-blue-700'],
        icon: ['text-blue-500']
    };

    // Inactive state classes  
    const inactiveClasses = {
        link: ['text-gray-700', 'hover:bg-gray-100'],
        icon: ['text-gray-400', 'group-hover:text-gray-600']
    };

    // Function to set active state
    function setActiveNav(activeLink) {
        // Remove active state from all links
        navLinks.forEach(link => {
            const icon = link.querySelector('i');

            // Remove active classes
            link.classList.remove(...activeClasses.link);
            if (icon) {
                icon.classList.remove(...activeClasses.icon);
            }

            // Add inactive classes
            link.classList.add(...inactiveClasses.link);
            if (icon) {
                icon.classList.add(...inactiveClasses.icon);
            }
        });

        // Set active state for clicked link
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

    // Function to determine current active page based on URL
    function setInitialActiveState() {
        const currentPath = window.location.pathname;

        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && currentPath.includes(href.replace(window.location.origin, ''))) {
                setActiveNav(link);
                return;
            }
        });
    }

    // Add click event listeners to all nav links
    navLinks.forEach(link => {
        // Skip if it's a placeholder link (#)
        if (link.getAttribute('href') === '#') {
            return;
        }

        link.addEventListener('click', (e) => {
            // Set active state
            setActiveNav(link);
        });
    });

    // Set initial active state based on current page
    setInitialActiveState();
});