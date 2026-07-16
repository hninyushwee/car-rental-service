import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function refreshIcons() {
    window.initLucideIcons?.();
}

function initNotificationPage() {
    const $page = $('[data-page="admin-notifications"]');

    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const $tableBody = $('#notificationsTableBody');
    const $searchInput = $('#searchInput');
    const $statusFilter = $('#statusFilter');
    const $dateFrom = $('#dateFrom');
    const $dateTo = $('#dateTo');
    const $refreshBtn = $('#refreshBtn');
    const apiBase = $page.data('apiBase') || '/api/admin/notifications';
    const loginUrl = $page.data('loginUrl') || '/login';

    let currentPage = 1;

    function handleError(error, fallbackMessage) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }
        notify(error.payload?.message || fallbackMessage, 'error');
    }

    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    function renderPagination(pagination) {
        $('#paginationInfoStart').text(pagination.from ?? 0);
        $('#paginationInfoEnd').text(pagination.to ?? 0);
        $('#paginationInfoTotal').text(pagination.total ?? 0);

        const totalPages = pagination.last_page ?? 1;
        const $container = $('#paginationControlsContainer').empty();

        if (totalPages <= 1) return;

        const buttonClass = 'pagination-trigger rounded-lg border border-slate-300 p-2 transition-colors hover:bg-slate-50 disabled:opacity-40 dark:border-slate-600 dark:hover:bg-slate-700';

        $container.append(`
            <button type="button" data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''} class="${buttonClass}">
                <i data-lucide="chevron-left" class="h-4 w-4"></i>
            </button>
        `);

        for (let page = 1; page <= totalPages; page++) {
            const activeClass = page === currentPage
                ? 'border-transparent bg-gradient-to-r from-cyan-500 to-blue-600 text-white'
                : 'border-slate-300 text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700';
            $container.append(`
                <button type="button" data-page="${page}" class="pagination-trigger rounded-lg border px-3 py-1.5 text-xs font-semibold shadow-sm transition-all ${activeClass}">
                    ${page}
                </button>
            `);
        }

        $container.append(`
            <button type="button" data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''} class="${buttonClass}">
                <i data-lucide="chevron-right" class="h-4 w-4"></i>
            </button>
        `);
    }

    function renderRow(notif, index) {
        const isUnread = notif.is_read === false || notif.is_read === 0;
        const badgeClass = isUnread
            ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'
            : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400';
        const rowClass = isUnread ? 'font-semibold' : '';

        return `
            <tr class="border-b border-slate-200/60 transition-colors hover:bg-slate-50/50 dark:border-slate-700/60 dark:hover:bg-slate-700/30 ${rowClass}">
                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${index}</td>
                <td class="px-4 py-3 text-slate-900 dark:text-white">${escapeHtml(notif.from || 'System')}</td>
                <td class="px-4 py-3 text-slate-900 dark:text-white">${escapeHtml(notif.title)}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 max-w-xs truncate">${escapeHtml(notif.message)}</td>
                <td class="px-4 py-3">
                    <span class="status-badge inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${badgeClass}">
                        <span class="status-dot inline-block h-1.5 w-1.5 rounded-full ${isUnread ? 'bg-amber-500' : 'bg-emerald-500'}"></span>
                        ${isUnread ? 'Unread' : 'Read'}
                    </span>
                </td>
                <td class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400">${formatDate(notif.created_at)}</td>
                <td class="px-4 py-3 text-center">
                    <button type="button" class="view-notification-btn inline-flex items-center justify-center rounded-lg p-1.5 text-slate-400 transition-colors hover:bg-cyan-50 hover:text-cyan-600 dark:hover:bg-cyan-900/20 dark:hover:text-cyan-400" data-id="${notif.id}" data-unread="${isUnread}">
                        <i data-lucide="eye" class="h-4 w-4"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    function renderTable(payload) {
        const data = payload?.data ?? {};
        const notifications = data.data ?? [];
        const pagination = {
            from: data.from,
            to: data.to,
            total: data.total,
            last_page: data.last_page,
        };

        if (!notifications.length) {
            $tableBody.html(`
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="bell-off" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                            <span>No notifications found.</span>
                        </div>
                    </td>
                </tr>
            `);
            renderPagination({ from: 0, to: 0, total: 0, last_page: 1 });
            refreshIcons();
            return;
        }

        $tableBody.html(notifications.map((n, i) => renderRow(n, (currentPage - 1) * 10 + i + 1)).join(''));
        renderPagination(pagination);
        refreshIcons();
    }

    async function loadNotifications() {
        $tableBody.html('<tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">Loading notifications...</td></tr>');

        const params = { page: currentPage, per_page: 10 };
        const search = $searchInput.val().trim();
        if (search) params.search = search;
        const status = $statusFilter.val();
        if (status) params.is_read = status;
        const dateFrom = $dateFrom.val();
        if (dateFrom) params.date_from = dateFrom;
        const dateTo = $dateTo.val();
        if (dateTo) params.date_to = dateTo;

        try {
            const result = await jsonRequest(`${apiBase}?${$.param(params)}`);
            renderTable(result);
        } catch (error) {
            $tableBody.html('<tr><td colspan="7" class="px-4 py-12 text-center font-medium text-red-500">Failed to load notifications.</td></tr>');
            handleError(error, 'Failed to fetch notifications.');
        }
    }

    $searchInput.on('input', function () {
        currentPage = 1;
        loadNotifications();
    });

    $statusFilter.on('change', function () {
        currentPage = 1;
        loadNotifications();
    });

    $dateFrom.on('change', function () {
        currentPage = 1;
        loadNotifications();
    });

    $dateTo.on('change', function () {
        currentPage = 1;
        loadNotifications();
    });

    $refreshBtn.on('click', function () {
        $searchInput.val('');
        $statusFilter.val('');
        $dateFrom.val('');
        $dateTo.val('');
        currentPage = 1;
        loadNotifications();
    });

    $(document).on('click', '.pagination-trigger', function () {
        if ($(this).prop('disabled')) return;
        currentPage = Number($(this).data('page'));
        loadNotifications();
    });

    // close modal on overlay click
    $(document).on('click', '#notificationDetailModal', function (e) {
        if (e.target === this) $(this).addClass('hidden').removeClass('flex');
    });

    $(document).on('click', '.close-notification-modal', function () {
        $('#notificationDetailModal').addClass('hidden').removeClass('flex');
    });

    $(document).on('click', '.view-notification-btn', async function () {
        const $btn = $(this);
        const id = $btn.data('id');

        try {
            await jsonRequest(`${apiBase}/${id}/read`, { method: 'PUT' });
            if (window.fetchUnreadCount) window.fetchUnreadCount();
            const $row = $btn.closest('tr');
            $row.removeClass('font-semibold');
            $row.find('.status-badge').html(
                '<span class="status-dot inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Read'
            ).removeClass('bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400')
                .addClass('bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400');
        } catch (e) {
            // silently fail — still open modal
        }

        try {
            const result = await jsonRequest(`${apiBase}/${id}`);
            renderNotificationModal(result.data);
        } catch (e) {
            notify('Failed to load notification details.', 'error');
        }
    });

    function renderNotificationModal(notif) {
        function escapeHtml(value) {
            return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }

        function formatDate(dateStr) {
            if (!dateStr) return 'N/A';
            const d = new Date(dateStr);
            return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
        }

        function statusBadge(status) {
            const map = {
                open: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                resolved: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                closed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
            };
            return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${map[status] || map.open}">${escapeHtml(status)}</span>`;
        }

        const isUnread = notif.is_read === false || notif.is_read === 0;
        const typeColors = {
            booking: 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
            payment: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            promotion: 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
            system: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
            inquiry: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        };

        let linkedSection = '';
        if (notif.notifiable_type === 'App\\Models\\Inquiry' && notif.inquiry) {
            const inq = notif.inquiry;
            linkedSection = `
                <div class="rounded-xl border border-blue-500/20 bg-blue-500/5 p-4">
                    <h3 class="mb-3 text-sm font-semibold text-slate-800 dark:text-slate-200">
                        <i data-lucide="message-circle" class="mr-1 inline-block h-4 w-4"></i> Related Inquiry
                    </h3>
                    <div class="mb-3 grid gap-2 text-sm sm:grid-cols-2">
                        <div><span class="text-slate-500 dark:text-slate-400">Subject:</span> <span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(inq.subject)}</span></div>
                        <div><span class="text-slate-500 dark:text-slate-400">Status:</span> ${statusBadge(inq.status)}</div>
                        <div><span class="text-slate-500 dark:text-slate-400">From:</span> <span class="text-slate-800 dark:text-slate-200">${escapeHtml(inq.user?.name || 'Unknown')}</span></div>
                        <div><span class="text-slate-500 dark:text-slate-400">Date:</span> <span class="text-slate-800 dark:text-slate-200">${formatDate(inq.created_at)}</span></div>
                    </div>
                    <div class="mb-3">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Message:</span>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">${escapeHtml(inq.message)}</p>
                    </div>
                    ${inq.admin_response ? `
                    <div class="mb-3 rounded-lg border border-emerald-500/20 bg-emerald-500/5 p-3">
                        <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Admin Response:</span>
                        <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">${escapeHtml(inq.admin_response)}</p>
                    </div>` : ''}
                    ${inq.status !== 'resolved' ? `
                    <div class="mt-4 border-t border-slate-200 pt-4 dark:border-slate-700">
                        <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Reply to Inquiry</label>
                        <textarea id="modalInquiryReplyInput" rows="3" class="mb-2 w-full rounded-lg border border-slate-300 bg-white p-2.5 text-sm transition-all focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500" placeholder="Write your reply..."></textarea>
                        <div class="flex items-center gap-2">
                            <button type="button" class="modal-send-reply-btn rounded-lg bg-cyan-400 px-4 py-2 text-xs font-medium text-black hover:bg-cyan-500" data-inquiry-id="${inq.id}">Send Reply</button>
                            <span class="modal-reply-sending hidden text-xs text-slate-400">Sending...</span>
                        </div>
                    </div>` : ''}
                </div>`;
        }

        const $modal = $('#notificationModalBody');
        $modal.html(`
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">${escapeHtml(notif.title)}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">${formatDate(notif.created_at)}</p>
                </div>
                <button type="button" class="close-notification-modal rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium ${typeColors[notif.type] || typeColors.system}">${escapeHtml(notif.type)}</span>
                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${isUnread ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'}">
                    <span class="inline-block h-1.5 w-1.5 rounded-full ${isUnread ? 'bg-amber-500' : 'bg-emerald-500'}"></span>
                    ${isUnread ? 'Unread' : 'Read'}
                </span>
            </div>
            <div class="mb-4 rounded-xl border border-slate-200/60 bg-slate-50/50 p-4 dark:border-slate-700/60 dark:bg-slate-900/30">
                <div class="mb-3 text-xs text-slate-500 dark:text-slate-400">
                    From: <span class="font-medium text-slate-700 dark:text-slate-300">${escapeHtml(notif.from || 'System')}</span>
                </div>
                <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">${escapeHtml(notif.message)}</p>
            </div>
            ${linkedSection}
        `);

        window.initLucideIcons?.();
        $('#notificationDetailModal').data('notifId', notif.id);
        attachModalReplyEvents();
        $('#notificationDetailModal').removeClass('hidden').addClass('flex');
    }

    function attachModalReplyEvents() {
        $(document).off('click', '.modal-send-reply-btn').on('click', '.modal-send-reply-btn', async function () {
            const inquiryId = $(this).data('inquiry-id');
            const $input = $('#modalInquiryReplyInput');
            const reply = $input.val().trim();
            if (!reply) { notify('Please write a reply.', 'error'); return; }

            const $sending = $('.modal-reply-sending').removeClass('hidden');
            $(this).prop('disabled', true);

            try {
                await jsonRequest(`/api/admin/inquiries/${inquiryId}`, {
                    method: 'PUT',
                    body: {
                        admin_response: reply,
                        status: 'resolved',
                    },
                });
                notify('Reply sent successfully.', 'success');
                $input.val('');
                // reload modal to refresh inquiry section
                const result = await jsonRequest(`${apiBase}/${$('#notificationDetailModal').data('notifId')}`);
                renderNotificationModal(result.data);
            } catch (err) {
                notify(err.payload?.message || 'Failed to send reply.', 'error');
            } finally {
                $sending.addClass('hidden');
                $(this).prop('disabled', false);
            }
        });
    }

    loadNotifications();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initNotificationPage();
} else {
    window.addEventListener('DOMContentLoaded', initNotificationPage);
    window.addEventListener('load', initNotificationPage);
}
