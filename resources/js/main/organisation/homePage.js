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
    // using getElementById id property in HTML
    const loginModal = document.getElementById('loginModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const loginModalContent = document.getElementById('loginModalContent');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // button to open login modal using class property in HTML
    const loginModalBtns = document.querySelectorAll('.login-modal-btn');

    // Reusable: open the login modal
    function openLoginModal() {
        if (!loginModal || !loginModalContent) return;
        loginModal.classList.remove('hidden');
        setTimeout(() => {
            loginModalContent.classList.remove('scale-95');
            loginModalContent.classList.add('scale-100');
        }, 10);
        document.body.style.overflow = 'hidden'; // Prevent background scroll
    }

    // Toast popup
    function showToast(message, type = 'error') {
        const wrap = document.createElement('div');
        wrap.id = 'authToast';
        wrap.className =
            'fixed top-4 right-4 z-50 max-w-sm w-full transform transition-all duration-200';
        const bg =
            type === 'success'
                ? 'bg-green-600'
                : type === 'warning'
                    ? 'bg-yellow-600'
                    : 'bg-red-600';
        wrap.innerHTML = `<div class="flex items-start space-x-3 ${bg} text-white px-4 py-3 rounded-lg shadow-lg">
                        <i class="fas fa-exclamation-circle mt-0.5"></i>
                        <div class="flex-1 text-sm">${message}</div>
                        <button id="authToastClose" class="text-white/80 hover:text-white">
                        <i class="fas fa-times"></i>
                        </button>
                        </div>
                        `;
        document.body.appendChild(wrap);

        const closeBtn = document.getElementById('authToastClose');
        const hide = () => {
            wrap.style.opacity = '0';
            wrap.style.transform = 'translateX(12px)';
            setTimeout(() => wrap.remove(), 220);
        };
        closeBtn?.addEventListener('click', hide);
        setTimeout(hide, 4000);
    }

    // Open modal
    loginModalBtns.forEach((btn) => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            openLoginModal();
        });
    });

    // Close modal function
    function closeModal() {
        if (!loginModal || !loginModalContent) return;
        loginModalContent.classList.remove('scale-100');
        loginModalContent.classList.add('scale-95');
        setTimeout(() => {
            loginModal.classList.add('hidden');
        }, 300);
        document.body.style.overflow = 'auto'; // Restore scroll
    }

    // Close modal on X button
    closeModalBtn?.addEventListener('click', closeModal);

    // Close modal on backdrop click
    loginModal?.addEventListener('click', function (e) {
        if (e.target === loginModal) {
            closeModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && loginModal && !loginModal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Provider password toggle
    togglePassword?.addEventListener('click', function () {
        if (!passwordInput) return;
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const icon = this.querySelector('i');
        if (!icon) return;
        if (type === 'password') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
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