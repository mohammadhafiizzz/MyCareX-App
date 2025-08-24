// Patient Profile JavaScript Functions

// Modal Elements
const editPersonalModal = document.getElementById('editPersonalInfo');
const editPersonalModalContent = document.getElementById('editPersonalInfoContent');

function openProfilePictureModal() {
    alert('Profile Picture Upload Modal - To be implemented');
    console.log('Opening profile picture upload modal');
}

window.editPersonalInfo = function() {
    // Show the personal info edit modal
    showModal('editPersonalInfo', 'editPersonalInfoContent');
}

function editPhysicalInfo() {
    // You can implement similar modal for physical info
    showModal('editPhysicalInfo', 'editPhysicalInfoContent');
}

function editAddressInfo() {
    showModal('editAddressInfo', 'editAddressInfoContent');
}

function editEmergencyInfo() {
    showModal('editEmergencyInfo', 'editEmergencyInfoContent');
}

function changePassword() {
    showModal('changePasswordModal', 'changePasswordModalContent');
}

function deleteAccount() {
    showModal('deleteAccountModal', 'deleteAccountModalContent');
}

// Generic Modal Functions
function showModal(modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);
    
    if (modal && modalContent) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scroll
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }
}

function closeModal(modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);
    
    if (modal && modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Restore scroll
        }, 300);
    }
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    console.log('Patient Profile page loaded');
    
    // Close modals when clicking outside or on close button
    setupModalEventListeners();
});

function setupModalEventListeners() {
    // List of all modals
    const modals = [
        { modalId: 'editPersonalInfo', contentId: 'editPersonalInfoContent' },
        { modalId: 'editPhysicalInfo', contentId: 'editPhysicalInfoContent' },
        { modalId: 'editAddressInfo', contentId: 'editAddressInfoContent' },
        { modalId: 'editEmergencyInfo', contentId: 'editEmergencyInfoContent' },
        { modalId: 'changePasswordModal', contentId: 'changePasswordModalContent' },
        { modalId: 'deleteAccountModal', contentId: 'deleteAccountModalContent' }
    ];

    modals.forEach(({ modalId, contentId }) => {
        const modal = document.getElementById(modalId);
        const closeBtn = document.getElementById(`close${modalId}`);
        
        if (modal) {
            // Close modal on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modalId, contentId);
                }
            });
        }
        
        // Close modal on close button click
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeModal(modalId, contentId);
            });
        }
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modals.forEach(({ modalId, contentId }) => {
                const modal = document.getElementById(modalId);
                if (modal && !modal.classList.contains('hidden')) {
                    closeModal(modalId, contentId);
                }
            });
        }
    });
}