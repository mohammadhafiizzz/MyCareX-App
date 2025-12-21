document.addEventListener('DOMContentLoaded', function() {
    // Toast Notification Logic
    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toastIcon');
    const toastTitle = document.getElementById('toastTitle');
    const toastMessage = document.getElementById('toastMessage');

    window.showToast = function(message, type = 'success') {
        toastMessage.innerText = message;
        
        if (type === 'success') {
            toastIcon.className = 'w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600';
            toastIcon.innerHTML = '<i class="fa-solid fa-check"></i>';
            toastTitle.innerText = 'Success';
        } else {
            toastIcon.className = 'w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600';
            toastIcon.innerHTML = '<i class="fa-solid fa-xmark"></i>';
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
                document.body.style.overflow = 'hidden';
            });
        }
    });

    // Close Modals
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('[id$="Modal"]') || btn.closest('#modalEditPassword');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    });

    // Close on outside click
    window.addEventListener('click', (e) => {
        if (e.target.classList.contains('close-modal')) {
            const modal = e.target.closest('[id$="Modal"]') || e.target.closest('#modalEditPassword');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        }
    });

    // Password Validation Logic
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('new_password_confirmation');
    const strengthIndicator = document.getElementById('passwordStrength');
    const matchIndicator = document.getElementById('passwordMatch');

    if (newPasswordInput) {
        newPasswordInput.addEventListener('input', function() {
            const val = this.value;
            strengthIndicator.classList.remove('hidden');
            
            if (val.length === 0) {
                strengthIndicator.classList.add('hidden');
            } else if (val.length < 8) {
                strengthIndicator.innerText = 'Password too short (min 8 characters)';
                strengthIndicator.className = 'mt-2 text-xs text-red-500';
            } else {
                const hasUpper = /[A-Z]/.test(val);
                const hasLower = /[a-z]/.test(val);
                const hasNumber = /[0-9]/.test(val);
                
                if (hasUpper && hasLower && hasNumber) {
                    strengthIndicator.innerText = 'Strong password';
                    strengthIndicator.className = 'mt-2 text-xs text-green-500';
                } else {
                    strengthIndicator.innerText = 'Medium strength (add uppercase, lowercase, and numbers)';
                    strengthIndicator.className = 'mt-2 text-xs text-amber-500';
                }
            }
        });
    }

    if (confirmPasswordInput && newPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            matchIndicator.classList.remove('hidden');
            if (this.value === newPasswordInput.value) {
                matchIndicator.innerText = 'Passwords match';
                matchIndicator.className = 'mt-2 text-xs text-green-500';
            } else {
                matchIndicator.innerText = 'Passwords do not match';
                matchIndicator.className = 'mt-2 text-xs text-red-500';
            }
        });
    }

    // Password Visibility Toggle
    const setupToggle = (buttonId, inputId, iconId) => {
        const btn = document.getElementById(buttonId);
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (btn && input && icon) {
            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                icon.className = isPassword ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
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
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerText;
                submitBtn.disabled = true;
                submitBtn.innerText = 'Saving...';

                const formData = new FormData(this);

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message);
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Something went wrong', 'error');
                        submitBtn.disabled = false;
                        submitBtn.innerText = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred. Please try again.', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerText = originalText;
                });
            });
        }
    });

    // Profile Picture Auto-submit
    const avatarInput = document.getElementById('avatarInput');
    const avatarForm = document.getElementById('avatarForm');
    
    if (avatarInput && avatarForm) {
        avatarInput.addEventListener('change', function() {
            const formData = new FormData();
            formData.append('profile_picture', this.files[0]);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch('/doctor/profile/update-picture', {
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
                    document.getElementById('profileImageDisplay').src = data.url;
                    showToast(data.message);
                } else {
                    showToast(data.message || 'Failed to upload image', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred during upload.', 'error');
            });
        });
    }
});
