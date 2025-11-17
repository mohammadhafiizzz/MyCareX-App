document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');

    toggleButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'password') {
            passwordIcon.className = 'fas fa-eye text-gray-400 hover:text-gray-600 transition-colors';
        } else {
            passwordIcon.className = 'fas fa-eye-slash text-gray-400 hover:text-gray-600 transition-colors';
        }
    });

    // Auto-hide error messages after 5 seconds
    const errorAlert = document.querySelector('.bg-red-50');
    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.opacity = '0';
            setTimeout(() => errorAlert.remove(), 300);
        }, 5000);
    }
});
