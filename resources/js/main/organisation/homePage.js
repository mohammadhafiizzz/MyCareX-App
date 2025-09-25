/*
Author: Mohammad Hafiz bin Mohan
Description: Healthcare Provider Homepage JavaScript
File: resources/js/main/organisation/homePage.js
*/

document.addEventListener('DOMContentLoaded', () => {
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuButton?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Provider login modal
    const providerLoginButtons = document.querySelectorAll('.provider-login-btn');
    const providerModal = document.getElementById('providerLoginModal');
    const closeProviderModal = document.getElementById('closeProviderModal');

    providerLoginButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            providerModal.classList.remove('hidden');
        });
    });

    closeProviderModal?.addEventListener('click', () => {
        providerModal.classList.add('hidden');
    });

    // Close modal when clicking outside
    providerModal?.addEventListener('click', (e) => {
        if (e.target === providerModal) {
            providerModal.classList.add('hidden');
        }
    });

    // Provider password toggle
    const toggleProviderPassword = document.getElementById('toggleProviderPassword');
    const providerPasswordInput = document.getElementById('provider_password');

    toggleProviderPassword?.addEventListener('click', () => {
        const type = providerPasswordInput.type === 'password' ? 'text' : 'password';
        providerPasswordInput.type = type;

        const icon = toggleProviderPassword.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Show provider login error if exists
    if (window.PROVIDER_LOGIN_ERROR) {
        providerModal.classList.remove('hidden');
        // You can add error display logic here
    }
});