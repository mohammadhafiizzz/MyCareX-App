// Permission Request Management
let currentPermissionId = null;

// Open the confirm access modal
function openConfirmAccessModal(permissionId, doctorName, providerName, accessScope) {
    currentPermissionId = permissionId;
    
    // Set modal content
    document.getElementById('doctorName').textContent = doctorName;
    document.getElementById('providerName').textContent = providerName;
    
    // Format and display access scope
    const scopeElement = document.getElementById('accessScope');
    if (Array.isArray(accessScope)) {
        scopeElement.textContent = accessScope.map(s => s.charAt(0).toUpperCase() + s.slice(1)).join(', ');
    } else {
        scopeElement.textContent = accessScope || 'All Records';
    }
    
    // Set default expiry date (1 year from now)
    const expiryDateInput = document.getElementById('expiryDate');
    const oneYearFromNow = new Date();
    oneYearFromNow.setFullYear(oneYearFromNow.getFullYear() + 1);
    expiryDateInput.value = oneYearFromNow.toISOString().split('T')[0];
    expiryDateInput.min = new Date().toISOString().split('T')[0]; // Can't set past dates
    
    // Show modal with animation
    const modal = document.getElementById('confirmAccessModal');
    const modalContent = document.getElementById('modalContent');
    
    // First remove hidden to make element part of layout
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Force a reflow to ensure the display change is registered
    modal.offsetHeight;
    
    // Trigger animation
    setTimeout(() => {
        modal.classList.remove('bg-opacity-0', 'opacity-0');
        modal.classList.add('bg-opacity-50');
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Close the confirm access modal
function closeConfirmAccessModal() {
    const modal = document.getElementById('confirmAccessModal');
    const modalContent = document.getElementById('modalContent');
    
    // Animate out
    modal.classList.remove('bg-opacity-50');
    modal.classList.add('bg-opacity-0', 'opacity-0');
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        currentPermissionId = null;
    }, 300);
}

// Confirm and grant access
function confirmAccessGrant() {
    if (!currentPermissionId) {
        showNotification('Error: No permission selected', 'error');
        return;
    }
    
    const expiryDate = document.getElementById('expiryDate').value;
    
    if (!expiryDate) {
        showNotification('Please select an expiry date', 'error');
        return;
    }
    
    // Show loading state
    const confirmBtn = document.getElementById('confirmBtn');
    const confirmBtnText = document.getElementById('confirmBtnText');
    const confirmBtnLoader = document.getElementById('confirmBtnLoader');
    
    confirmBtn.disabled = true;
    confirmBtnText.classList.add('hidden');
    confirmBtnLoader.classList.remove('hidden');
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Send AJAX request
    fetch(`/patient/permissions/approve/${currentPermissionId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            expiry_date: expiryDate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Access granted successfully!', 'success');
            closeConfirmAccessModal();
            
            // Reload page after short delay to show updated list
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Failed to grant access', 'error');
            // Reset button state
            confirmBtn.disabled = false;
            confirmBtnText.classList.remove('hidden');
            confirmBtnLoader.classList.add('hidden');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
        // Reset button state
        confirmBtn.disabled = false;
        confirmBtnText.classList.remove('hidden');
        confirmBtnLoader.classList.add('hidden');
    });
}

// Show notification message
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    } text-white`;
    
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas ${
                type === 'success' ? 'fa-check-circle' : 
                type === 'error' ? 'fa-exclamation-circle' : 
                'fa-info-circle'
            }"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 10);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.classList.remove('translate-x-0');
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Expose functions to global scope for inline onclick handlers
window.openConfirmAccessModal = openConfirmAccessModal;
window.closeConfirmAccessModal = closeConfirmAccessModal;
window.confirmAccessGrant = confirmAccessGrant;

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('confirmAccessModal');
    
    // Attach click handlers to all confirm buttons
    document.querySelectorAll('.confirm-access-btn').forEach(button => {
        button.addEventListener('click', function() {
            const permissionId = parseInt(this.dataset.permissionId);
            const doctorName = this.dataset.doctorName;
            const providerName = this.dataset.providerName;
            let accessScope;
            
            try {
                accessScope = JSON.parse(this.dataset.accessScope);
            } catch (e) {
                accessScope = [];
            }
            
            openConfirmAccessModal(permissionId, doctorName, providerName, accessScope);
        });
    });
    
    // Close modal when clicking outside
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeConfirmAccessModal();
            }
        });
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeConfirmAccessModal();
        }
    });
});
