// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
    const mainContent = document.getElementById('mainContent');
    const topHeader = document.getElementById('topHeader');

    // Toggle sidebar on mobile
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function() {
            openSidebar();
        });
    }

    // Close sidebar button
    if (sidebarCloseBtn) {
        sidebarCloseBtn.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    // Open sidebar
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        }
        if (sidebarOverlay) {
            sidebarOverlay.classList.remove('hidden');
        }
    }

    // Close sidebar
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }
        if (sidebarOverlay) {
            sidebarOverlay.classList.add('hidden');
        }
    }

    // Handle window resize
    function handleResize() {
        if (window.innerWidth >= 1024) {
            // Desktop view
            if (sidebar) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
            }
            if (sidebarOverlay) {
                sidebarOverlay.classList.add('hidden');
            }
        } else {
            // Mobile view - close sidebar by default
            closeSidebar();
        }
    }

    // Initial check
    handleResize();

    // Listen for window resize
    window.addEventListener('resize', handleResize);

    // Highlight active link
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    
    sidebarLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (!href || href === '#') return;

        // Create a URL object to handle both relative and absolute URLs
        try {
            const linkPath = new URL(link.href, window.location.origin).pathname;
            
            // Check if paths match (ignoring trailing slashes)
            const normalizedLinkPath = linkPath.replace(/\/$/, '');
            const normalizedCurrentPath = currentPath.replace(/\/$/, '');

            if (normalizedLinkPath === normalizedCurrentPath) {
                link.classList.add('bg-blue-50', 'text-blue-700');
                link.classList.remove('text-gray-700', 'hover:bg-gray-100');
                
                const icon = link.querySelector('i');
                if (icon) {
                    icon.classList.remove('text-gray-400');
                    icon.classList.add('text-blue-600');
                }
            }
        } catch (e) {
            console.error('Error parsing link href:', e);
        }
    });

    // Smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});
