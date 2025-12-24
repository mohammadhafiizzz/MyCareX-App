document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editPermissionModal');
    const openEditModalBtn = document.getElementById('openEditModalBtn');
    const closeEditModalBtn = document.getElementById('closeEditModal');
    const updateForm = document.getElementById('updatePermissionForm');
    const updateAccessBtn = document.getElementById('updateAccessBtn');

    // Open Modal
    if (openEditModalBtn && editModal) {
        openEditModalBtn.addEventListener('click', function () {
            editModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close Modal
    if (closeEditModalBtn && editModal) {
        closeEditModalBtn.addEventListener('click', function () {
            editModal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    }

    // Close modal on outside click
    if (editModal) {
        editModal.addEventListener('click', function (e) {
            if (e.target === editModal) {
                editModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
    }

    if (updateForm) {
        updateForm.addEventListener('submit', function (e) {
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
            updateAccessBtn.disabled = true;
            updateAccessBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';

            fetch(`/patient/permissions/doctors/update/${permissionId}`, {
                method: 'PUT',
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
                    window.location.reload();
                } else {
                    alert(data.message || 'An error occurred.');
                    updateAccessBtn.disabled = false;
                    updateAccessBtn.innerHTML = 'Update Access';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred. Please try again.');
                updateAccessBtn.disabled = false;
                updateAccessBtn.innerHTML = 'Update Access';
            });
        });
    }
});