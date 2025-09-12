document.addEventListener('DOMContentLoaded', function () {
    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
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

    // Staff ID Formatting e.g., MCX12345
    function formatStaffId(input) {
        input.addEventListener('input', function () {
            let value = input.value.toUpperCase().replace(/[^A-Z0-9]/g, '');

            if (value.length > 8) {
                value = value.substring(0, 8);
            }

            input.value = value;
        });
    }

    formatStaffId(document.getElementById('staffId'));
});