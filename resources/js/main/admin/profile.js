document.addEventListener('DOMContentLoaded', function() {
    // Toast Notification Logic
    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');

    window.showToast = function(message, type = 'success') {
        toastMessage.innerText = message;
        
        if (type === 'success') {
            toast.querySelector('div').classList.replace('border-red-500', 'border-green-500');
            toastIcon.classList.replace('bg-red-100', 'bg-green-100');
            toastIcon.classList.replace('text-red-600', 'text-green-600');
            toastIcon.innerHTML = '<i class="fa-solid fa-check"></i>';
            toastTitle.innerText = 'Success';
        } else {
            toast.querySelector('div').classList.replace('border-green-500', 'border-red-500');
            toastIcon.classList.replace('bg-green-100', 'bg-red-100');
            toastIcon.classList.replace('text-green-600', 'text-red-600');
            toastIcon.innerHTML = '<i class="fa-solid fa-exclamation"></i>';
            toastTitle.innerText = 'Error';
        }

        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(hideToast, 5000);
    };

    window.hideToast = function() {
        toast.classList.add('translate-y-20', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    };

    // Modal Toggle Logic
    const modals = {
        'openEditPersonal': 'editPersonalModal',
        'openEditPassword': 'modalEditPassword'
    };

    // Open Modals
    Object.keys(modals).forEach(buttonId => {
        const btn = document.getElementById(buttonId);
        const modalId = modals[buttonId];
        const modal = document.getElementById(modalId);

        if (btn && modal) {
            btn.addEventListener('click', () => {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent scroll
            });
        }
    });

    // Close Modals
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.fixed.inset-0[id]');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Restore scroll
            }
        });
    });

    // Close on outside click
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('close-modal')) {
            const modal = e.target.closest('.fixed.inset-0[id]');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    });

    // Password Validation Logic (Change Password Modal)
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const strengthIndicator = document.getElementById('passwordStrength');
    const matchIndicator = document.getElementById('passwordMatch');

    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            const errors = [];
            
            if (password.length < 8) errors.push('At least 8 characters');
            if (!/\d/.test(password)) errors.push('At least one number');
            if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) errors.push('At least one special character');
            
            if (password.length > 0) {
                strengthIndicator.classList.remove('hidden');
                if (errors.length === 0) {
                    strengthIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600 font-medium">Strong password</span>';
                } else {
                    strengthIndicator.innerHTML = '<i class="fas fa-exclamation-circle text-amber-600 mr-1"></i><span class="text-amber-600 font-medium">Must have: ' + errors.join(', ') + '</span>';
                }
            } else {
                strengthIndicator.classList.add('hidden');
            }
        });
    }

    if (confirmPasswordInput && newPasswordInput) {
        const validateMatch = function() {
            const password = newPasswordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            if (confirmPassword.length > 0) {
                matchIndicator.classList.remove('hidden');
                if (password === confirmPassword) {
                    matchIndicator.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-1"></i><span class="text-green-600 font-medium">Passwords match</span>';
                } else {
                    matchIndicator.innerHTML = '<i class="fas fa-times-circle text-red-600 mr-1"></i><span class="text-red-600 font-medium">Passwords do not match</span>';
                }
            } else {
                matchIndicator.classList.add('hidden');
            }
        };

        confirmPasswordInput.addEventListener('input', validateMatch);
        newPasswordInput.addEventListener('input', validateMatch);
    }

    // Password Visibility Toggle
    const setupToggle = (buttonId, inputId, iconId) => {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (btn && input && icon) {
            btn.addEventListener('click', () => {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    };

    setupToggle('toggleCurrentPassword', 'current_password', 'currentPasswordIcon');
    setupToggle('toggleNewPassword', 'new_password', 'newPasswordIcon');
    setupToggle('toggleConfirmPassword', 'new_password_confirmation', 'confirmPasswordIcon');

    // Form Submission with AJAX
    const forms = [
        'editPersonalForm', 
        'formEditPassword'
    ];

    forms.forEach(formId => {
        const form = document.getElementById(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Additional validation for password form
                if (formId === 'formEditPassword') {
                    const password = newPasswordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    const errors = [];

                    if (password.length < 8) errors.push('Password must be at least 8 characters long');
                    if (!/\d/.test(password)) errors.push('Password must contain at least one number');
                    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) errors.push('Password must contain at least one special character');
                    if (password !== confirmPassword) errors.push('Passwords do not match');

                    if (errors.length > 0) {
                        showToast('Please fix the validation errors.', 'error');
                        return false;
                    }
                }
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                const formData = new FormData(form);
                
                // Disable button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin mr-2"></i> Updating...';

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showToast(data.message || 'Something went wrong', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });
        }
    });

    // Profile Picture Auto-submit with AJAX
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    
    if (avatarInput && avatarForm) {
        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const formData = new FormData(avatarForm);
                
                fetch(avatarForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Failed to upload image.', 'error');
                });
            }
        });
    }
});
