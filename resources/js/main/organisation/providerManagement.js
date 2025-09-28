/*

Author: Mohammad Hafiz bin Mohan
Description: JavaScript for Provider Management page
File: resources/js/main/organisation/providerManagement.js

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

    // close modal
    mCancel.addEventListener('click', () => modal.classList.add('hidden'));

    /* ---------- header text map ---------- */
    const headerMap = {
        pending: {
            page: 'Pending Healthcare Provider Verifications',
            table: 'Pending Verification Requests'
        },
        approved: {
            page: 'Approved Healthcare Provider Accounts',
            table: 'Approved List'
        },
        rejected: {
            page: 'Rejected Healthcare Provider Accounts',
            table: 'Rejected List'
        }
    };

    /* ---------- status-card clicks ---------- */
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('click', () => {
            const status = card.dataset.status;

            // fetch data
            fetch(`/admin/providers/list/${status}`)
                .then(r => r.json())
                .then(data => renderTable(status, data));

            // highlight card
            document
                .querySelectorAll('.status-card')
                .forEach(c => c.classList.remove('ring-1', 'ring-blue-500'));
            card.classList.add('ring-1', 'ring-blue-500');

            // headers
            document.getElementById('pageHeader').textContent =
                headerMap[status].page;
            document.getElementById('tableHeader').textContent =
                headerMap[status].table;
        });
    });

    /* ---------- table rendering ---------- */
    const tbody = document.getElementById('providerTableBody');

    function renderTable(status, list) {
        tbody.innerHTML = '';

        if (!list.length) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="p-6 text-center text-gray-500">` +
                `No ${status} healthcare providers found.</td></tr>`;
            return;
        }

        list.forEach(p => {
            const initials = p.organisation_name
                .split(' ')
                .map(p => p[0])
                .join('');
            const regDate = new Date(p.created_at).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            const formattedId = 'HCP' + String(p.id).padStart(4, '0');

            let label, color, icon;
            if (p.verification_status === 'Approved') {
                label = 'Approved';
                color = 'green';
                icon = 'check-circle';
            } else if (p.verification_status === 'Rejected') {
                label = 'Rejected';
                color = 'red';
                icon = 'times-circle';
            } else {
                label = 'Pending';
                color = 'yellow';
                icon = 'clock';
            }

            /* buttons depend on filter status */
            const btnHTML =
                status === 'pending'
                    ? ` <button type="button" title="Approve" class="action-btn approve inline-flex items-center px-3 py-1 border border-transparent
                                        text-sm leading-4 font-medium rounded-md text-white bg-green-600
                                        hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                        focus:ring-green-500 cursor-pointer" data-id="${p.id}">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" title="Reject" class="action-btn reject inline-flex items-center px-3 py-1 border border-transparent
                                        text-sm leading-4 font-medium rounded-md text-white bg-red-600
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                        focus:ring-red-500 cursor-pointer" data-id="${p.id}">
                            <i class="fas fa-times"></i>
                        </button>`
                    : ` <button type="button" title="Delete" class="action-btn delete inline-flex items-center px-3 py-2 border border-transparent
                                        text-sm leading-4 font-medium rounded-md text-white bg-red-600
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                        focus:ring-red-500 cursor-pointer" data-id="${p.id}">
                            <p>Delete</p>
                        </button>`;

            tbody.insertAdjacentHTML(
                'beforeend',
                `<tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">${initials}</span>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">${p.organisation_name}</div>
                                <div class="text-sm text-gray-500">${formattedId}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${p.email}</div>
                        <div class="text-sm text-gray-500">${p.phone_number ?? '-'}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${regDate}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${color}-100 text-${color}-800">
                            <i class="fas fa-${icon} mr-1"></i> ${label}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            ${btnHTML}
                        </div>
                    </td>
                </tr>`
            );
        });
    }

    /*----------- action buttons functionality ---------- */
    let pendingAction = null;
    let targetId = null;

    function openModal(action, id, title, msg, color) {
        pendingAction = action;
        targetId = id;
        showModal(title, msg, color);
    }

    /* ---------- event delegation for buttons ---------- */
    tbody.addEventListener('click', e => {
        if (!e.target.closest('.action-btn')) return;
        const btn = e.target.closest('.action-btn');

        const id = btn.dataset.id;

        if (btn.classList.contains('approve')) {
            openModal(
                'approve',
                id,
                'Approve Provider',
                'Are you sure you want to approve this provider account?',
                'green'
            );
        } else if (btn.classList.contains('reject')) {
            openModal(
                'reject',
                id,
                'Reject Provider',
                'Are you sure you want to reject this provider account?',
                'red'
            );
        } else if (btn.classList.contains('delete')) {
            openModal(
                'delete',
                id,
                'Delete Provider',
                'Are you sure you want to delete this provider account?',
                'red'
            );
        }
    });

    function refreshCounters(c) {
        document.getElementById('pendingCount').textContent = c.pending;
        document.getElementById('approvedCount').textContent = c.approved;
        document.getElementById('rejectedCount').textContent = c.rejected;
    }

    /* ---------- confirm modal action ---------- */
    mConfirm.addEventListener('click', () => {
        if (!pendingAction || !targetId) return;

        fetch(`/admin/providers/${pendingAction}/${targetId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(data => { // <-- FIXED: Capture response data
                modal.classList.add('hidden');

                // update counts
                refreshCounters(data.counts);  // <-- FIXED: Use captured data

                // show notification
                showNotification(data.message, data.type);

                // simply trigger the active card again to refresh counts + table
                document.querySelector('.status-card.ring-blue-500').click();
            })
            .catch(() => alert('Action failed, please try again.'));
    });

    /* ---------- notification system ---------- */
    const notification = document.getElementById('successNotification');
    const notificationMsg = document.getElementById('notificationMessage');
    const closeNotificationBtn = document.getElementById('closeNotification');

    function showNotification(message, type) {
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500'
        };

        const notificationDiv = notification.querySelector('div');
        // Remove existing color classes
        notificationDiv.className = notificationDiv.className.replace(/bg-\w+-500/g, '');
        // Add new color class
        notificationDiv.classList.add(colors[type]);

        notificationMsg.textContent = message;
        notification.classList.remove('hidden');

        setTimeout(() => {
            hideNotification();
        }, 5000);
    }

    function hideNotification() {
        notification.classList.add('hidden');
    }

    // Close notification on click
    closeNotificationBtn?.addEventListener('click', hideNotification);
});