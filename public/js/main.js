document.addEventListener('DOMContentLoaded', function () {
    // using getElementById id property in HTML
    const loginModal = document.getElementById('loginModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const loginModalContent = document.getElementById('loginModalContent');
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    // button to open login modal using class property in HTML
    const loginModalBtns = document.querySelectorAll('.login-modal-btn');

    // Open modal
    loginModalBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            loginModal.classList.remove('hidden');
            setTimeout(() => {
                loginModalContent.classList.remove('scale-95');
                loginModalContent.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden'; // Prevent background scroll
        });
    });

    // Close modal function
    function closeModal() {
        loginModalContent.classList.remove('scale-100');
        loginModalContent.classList.add('scale-95');
        setTimeout(() => {
            loginModal.classList.add('hidden');
        }, 300);
        document.body.style.overflow = 'auto'; // Restore scroll
    }

    // Close modal on X button
    closeModalBtn.addEventListener('click', closeModal);

    // Close modal on backdrop click
    loginModal.addEventListener('click', function (e) {
        if (e.target === loginModal) {
            closeModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !loginModal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Toggle password visibility
    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const icon = this.querySelector('i');
        if (type === 'password') {
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });

    // Format IC Number
    function formatIcNumber(input) {
        if (!input) return; // Guard against null elements
        
        let isDeleting = false;

        input.addEventListener('keydown', function (e) {
            isDeleting = e.key === 'Backspace' || e.key === 'Delete';
        });

        input.addEventListener('input', function (e) {
            if (isDeleting) return;

            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = value.substring(0, 6);
                if (value.length >= 6) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                if (value.length >= 8) {
                    formattedValue += '-' + value.substring(8, 12);
                }
            }

            e.target.value = formattedValue;
        });

        // Handle paste events
        input.addEventListener('paste', function (e) {
            setTimeout(() => {
                let value = e.target.value.replace(/\D/g, '');
                let formattedValue = '';

                if (value.length > 0) {
                    formattedValue = value.substring(0, 6);
                    if (value.length >= 6) {
                        formattedValue += '-' + value.substring(6, 8);
                    }
                    if (value.length >= 8) {
                        formattedValue += '-' + value.substring(8, 12);
                    }
                }

                e.target.value = formattedValue;
            }, 10);
        });
    }

    // **Apply formatting to login IC number field**
    const loginIcNumber = document.getElementById('icNumber');
    formatIcNumber(loginIcNumber);
});

// Mobile menu toggle
document.getElementById('mobileMenuButton')?.addEventListener('click', function () {
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenu.classList.toggle('hidden');
});
