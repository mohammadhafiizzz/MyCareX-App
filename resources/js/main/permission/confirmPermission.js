document.addEventListener('DOMContentLoaded', function () {
    const approveForm = document.getElementById('approvePermissionForm');
    const declineBtn = document.getElementById('declineRequestBtn');
    const grantAccessBtn = document.getElementById('grantAccessBtn');

    if (approveForm) {
        approveForm.addEventListener('submit', function (e) {
            e.preventDefault();
            
            const permissionId = this.getAttribute('data-permission-id');
            const formData = new FormData(this);
            const scopes = [];
            
            this.querySelectorAll('input[name="permission_scope[]"]:checked').forEach(checkbox => {
                scopes.push(checkbox.value);
            });

            if (scopes.length === 0) {
                alert('Please select at least one record type to share.');
                return;
            }

            // Disable button and show loading state
            grantAccessBtn.disabled = true;
            grantAccessBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Granting...';

            fetch(`/patient/permissions/approve/${permissionId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    expiry_date: formData.get('expiry_date'),
                    permission_scope: scopes
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/patient/permissions/requests';
                } else {
                    alert(data.message || 'An error occurred.');
                    grantAccessBtn.disabled = false;
                    grantAccessBtn.innerHTML = '<i class="fas fa-check-circle"></i> Grant Access';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
                grantAccessBtn.disabled = false;
                grantAccessBtn.innerHTML = '<i class="fas fa-check-circle"></i> Grant Access';
            });
        });
    }

    if (declineBtn) {
        declineBtn.addEventListener('click', function () {
            if (!confirm('Are you sure you want to decline this access request?')) {
                return;
            }

            const permissionId = approveForm.getAttribute('data-permission-id');

            // Disable button and show loading state
            declineBtn.disabled = true;
            declineBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Declining...';

            fetch(`/patient/permissions/decline/${permissionId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/patient/permissions/requests';
                } else {
                    alert(data.message || 'An error occurred.');
                    declineBtn.disabled = false;
                    declineBtn.innerHTML = '<i class="fas fa-times-circle"></i> Decline Request';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
                declineBtn.disabled = false;
                declineBtn.innerHTML = '<i class="fas fa-times-circle"></i> Decline Request';
            });
        });
    }
});
