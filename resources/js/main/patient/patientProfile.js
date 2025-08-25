// Patient Profile JavaScript Functions - Updated

// Modal Elements
const editPersonalModal = document.getElementById('editPersonalInfo');
const editPersonalModalContent = document.getElementById('editPersonalInfoContent');

function openProfilePictureModal() {
    alert('Profile Picture Upload Modal - To be implemented');
    console.log('Opening profile picture upload modal');
}

window.editPersonalInfo = function() {
    showModal('editPersonalInfo', 'editPersonalInfoContent');
    setupEditPersonalFormListeners();
}

function setupEditPersonalFormListeners() {
    const editRaceSelect = document.getElementById('edit_race');
    const editOtherRaceInput = document.getElementById('edit_other_race');

    if (editRaceSelect && editOtherRaceInput) {
        editRaceSelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                editOtherRaceInput.classList.remove('hidden');
                editOtherRaceInput.required = true;
            } else {
                editOtherRaceInput.classList.add('hidden');
                editOtherRaceInput.required = false;
                editOtherRaceInput.value = '';
            }
        });
    }
}

function editPhysicalInfo() {
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

// Make closeModal globally accessible
window.closeModal = function(modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);
    
    if (modal && modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }
}

function showModal(modalId, modalContentId) {
    const modal = document.getElementById(modalId);
    const modalContent = document.getElementById(modalContentId);
    
    if (modal && modalContent) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Patient Profile page loaded');
    setupModalEventListeners();
});

function setupModalEventListeners() {
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
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modalId, contentId);
                }
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                closeModal(modalId, contentId);
            });
        }
    });

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