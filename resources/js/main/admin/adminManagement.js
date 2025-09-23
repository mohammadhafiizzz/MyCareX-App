/*

Author: Mohammad Hafiz bin Mohan
Description: JavaScript for Admin Management page
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
            `px-4 py-2 bg-${color}-500 text-white text-base font-medium ` +
            `rounded-md w-full shadow-sm hover:bg-${color}-700 ` +
            `focus:outline-none focus:ring-2 focus:ring-${color}-300`;
        modal.classList.remove('hidden');
    }

    mCancel.addEventListener('click', () => modal.classList.add('hidden'));
    mConfirm.addEventListener('click', () => {
        /* backend call placeholder */
        modal.classList.add('hidden');
    });

    /* ---------- header text map ---------- */
    const headerMap = {
        pending: {
            page: 'Pending Admin Verifications',
            table: 'Pending Verification Requests'
        },
        approved: {
            page: 'Approved Admin Accounts',
            table: 'Approved Admin List'
        },
        rejected: {
            page: 'Rejected Admin Accounts',
            table: 'Rejected Admin List'
        }
    };

    /* ---------- status-card clicks ---------- */
    document.querySelectorAll('.status-card').forEach(card => {
        card.addEventListener('click', () => {
            const status = card.dataset.status;

            // fetch data
            fetch(`/admin/management/list/${status}`)
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
    const tbody = document.getElementById('adminTableBody');

    function renderTable(status, list) {
        tbody.innerHTML = '';

        if (!list.length) {
            tbody.innerHTML =
                `<tr><td colspan="5" class="p-6 text-center text-gray-500">` +
                `No ${status} admins found.</td></tr>`;
            return;
        }

        list.forEach(a => {
            const initials = a.full_name
                .split(' ')
                .map(p => p[0])
                .join('');
            const regDate = new Date(a.created_at).toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });

            let label, color, icon;
            if (a.account_verified_at) {
                label = 'Approved';
                color = 'green';
                icon = 'check-circle';
            } else if (a.account_rejected_at) {
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
                                        focus:ring-green-500">
                            <i class="fas fa-check"></i>
                        </button>
                        <button type="button" title="Reject" class="action-btn reject inline-flex items-center px-3 py-1 border border-transparent
                                        text-sm leading-4 font-medium rounded-md text-white bg-red-600
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                        focus:ring-red-500">
                            <i class="fas fa-times"></i>
                        </button>`
                    : ` <button type="button" title="Delete" class="action-btn delete inline-flex items-center px-3 py-2 border border-transparent
                                        text-sm leading-4 font-medium rounded-md text-white bg-red-600
                                        hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                                        focus:ring-red-500">
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
                                <div class="text-sm font-medium text-gray-900">${a.full_name}</div>
                                <div class="text-sm text-gray-500">${a.admin_id}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${a.email}</div>
                        <div class="text-sm text-gray-500">${a.phone_number ?? '-'}</div>
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

    function openModal(action, adminId, title, msg, color) {
        pendingAction = action;
        targetId = adminId;
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
                'Approve Admin',
                'Are you sure you want to approve this admin account?',
                'green'
            );
        } else if (btn.classList.contains('reject')) {
            openModal(
                'reject',
                id,
                'Reject Admin',
                'Are you sure you want to reject this admin account?',
                'red'
            );
        } else if (btn.classList.contains('delete')) {
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
    mConfirm.addEventListener('click', () => {
        if (!pendingAction || !targetId) return;

        fetch(`/admin/management/${pendingAction}/${targetId}`, {
            method : 'POST',
            headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept'      : 'application/json'
            }
        })
            .then(r => r.ok ? r.json() : Promise.reject())
            .then(() => {
            modal.classList.add('hidden');
            // simply trigger the active card again to refresh counts + table
            document.querySelector('.status-card.ring-blue-500').click();
            })
            .catch(() => alert('Action failed, please try again.'));
        });
});