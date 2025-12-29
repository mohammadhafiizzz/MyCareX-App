/*

Author: Mohammad Hafiz bin Mohan
Description: JavaScript for Admin Management and Profile actions
File: resources/js/main/admin/adminManagement.js

*/
document.addEventListener('DOMContentLoaded', () => {
    /* ---------- sidebar toggle (mobile) ---------- */
    const mobileBtn = document.getElementById('mobileMenuButton');
    const sidebar = document.getElementById('sidebar');
    const sidebarOv = document.getElementById('sidebarOverlay');

    mobileBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        sidebarOv.classList.toggle('hidden');
    });
    sidebarOv?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        sidebarOv.classList.add('hidden');
    });

    /* ---------- modal helpers ---------- */
    const modal = document.getElementById('confirmationModal');
    // If modal elements don't exist in current view, skip modal setup
    if (modal) {
        const mTitle = document.getElementById('modalTitle');
        const mMsg = document.getElementById('modalMessage');
        const mIconWrap = document.getElementById('modalIcon');
        const mIcon = document.getElementById('modalIconClass');
        const mConfirm = document.getElementById('modalConfirm');
        const mCancel = document.getElementById('modalCancel');

        function showModal(title, msg, color) {
            mTitle.textContent = title;
            mMsg.textContent = msg;
            mIconWrap.className =
                `mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-${color}-100`;
            mIcon.className = `fas fa-exclamation-triangle text-${color}-600`;
            mConfirm.className =
                `px-4 py-2 bg-${color}-500 cursor-pointer text-white text-base font-medium ` +
                `rounded-md w-full shadow-sm hover:bg-${color}-700 ` +
                `focus:outline-none focus:ring-2 focus:ring-${color}-300`;
            modal.classList.remove('hidden');
        }

        mCancel?.addEventListener('click', () => modal.classList.add('hidden'));

        /*----------- action buttons functionality ---------- */
        let pendingAction = null;
        let targetId = null;

        function openModal(action, adminId, title, msg, color) {
            pendingAction = action;
            targetId = adminId;
            showModal(title, msg, color);
        }

        /* ---------- event delegation for buttons ---------- */
        document.addEventListener('click', e => {
            // Support for various button classes
            const btn = e.target.closest('.approve-admin-btn, .reject-admin-btn, .remove-admin-btn, .action-btn');
            if (!btn) return;

            const id = btn.dataset.id;

            if (btn.classList.contains('approve-admin-btn') || btn.classList.contains('approve')) {
                openModal(
                    'approve',
                    id,
                    'Approve Admin',
                    'Are you sure you want to approve this admin account?',
                    'green'
                );
            } else if (btn.classList.contains('reject-admin-btn') || btn.classList.contains('reject')) {
                openModal(
                    'reject',
                    id,
                    'Reject Admin',
                    'Are you sure you want to reject this admin account?',
                    'red'
                );
            } else if (btn.classList.contains('remove-admin-btn') || btn.classList.contains('delete')) {
                openModal(
                    'delete',
                    id,
                    'Delete Admin',
                    'Are you sure you want to delete this admin account?',
                    'red'
                );
            }
        });

        /* ---------- confirm modal action ---------- */
        mConfirm?.addEventListener('click', () => {
            if (!pendingAction || !targetId) return;

            fetch(`/admin/management/${pendingAction}/${targetId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(data => {
                    modal.classList.add('hidden');
                    
                    // Show notification
                    showNotification(data.message, data.type);

                    // Redirect after a short delay if we are on a detail page
                    setTimeout(() => {
                        if (window.location.pathname.includes('/profile/') || window.location.pathname.includes('/request/')) {
                            if (pendingAction === 'delete') {
                                window.location.href = '/admin/management';
                            } else {
                                window.location.href = '/admin/management/requests';
                            }
                        } else {
                            // If on a list page with status cards, refresh them
                            const activeCard = document.querySelector('.status-card.ring-blue-500');
                            if (activeCard) {
                                activeCard.click();
                            } else {
                                window.location.reload();
                            }
                        }
                    }, 1500);
                })
                .catch(() => alert('Action failed, please try again.'));
        });
    }

    /* ---------- notification system ---------- */
    const notification = document.getElementById('successNotification');
    if (notification) {
        const notificationMsg = document.getElementById('notificationMessage');
        const closeNotificationBtn = document.getElementById('closeNotification');

        window.showNotification = function(message, type) {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500'
            };

            const notificationDiv = notification.querySelector('div');
            // Remove existing color classes
            notificationDiv.className = notificationDiv.className.replace(/bg-\w+-500/g, '');
            // Add new color class
            notificationDiv.classList.add(colors[type] || 'bg-blue-500');

            notificationMsg.textContent = message;
            notification.classList.remove('hidden');

            setTimeout(() => {
                hideNotification();
            }, 5000);
        }

        function hideNotification() {
            notification.classList.add('hidden');
        }

        closeNotificationBtn?.addEventListener('click', hideNotification);
    }
});