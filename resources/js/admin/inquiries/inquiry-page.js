import $ from 'jquery';
import { jsonRequest, normalizeRecords } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function statusBadge(status) {
    const map = {
        open: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        resolved: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        closed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
    };
    const cls = map[status] || map.open;
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${cls}">${escapeHtml(status)}</span>`;
}

function buildTableRow(inquiry, index) {
    return `<tr class="border-b border-slate-100 transition-colors hover:bg-slate-50/50 dark:border-slate-700/30 dark:hover:bg-slate-700/20">
        <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">${index}</td>
        <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(inquiry.user?.name || 'N/A')}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${escapeHtml(inquiry.subject)}</td>
        <td class="px-4 py-3">${statusBadge(inquiry.status)}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${escapeHtml(inquiry.created_at?.split('T')[0] || '')}</td>
        <td class="px-4 py-3 text-right">
            <div class="flex items-center justify-end gap-1">
                <button type="button" class="view-inquiry-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-cyan-400 dark:hover:bg-cyan-950/30" data-id="${inquiry.id}" title="View">
                    <i data-lucide="eye" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                </button>
                <button type="button" class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30" data-id="${inquiry.id}" title="Delete">
                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                </button>
            </div>
        </td>
    </tr>`;
}

function initInquiryPage() {
    const $page = $('[data-page="admin-inquiries"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const $tbody = $('#inquiriesTableBody');
    const $searchInput = $('#searchInput');
    const $statusFilter = $('#statusFilter');
    const $refreshBtn = $('#refreshBtn');
    const $paginationInfoStart = $('#paginationInfoStart');
    const $paginationInfoEnd = $('#paginationInfoEnd');
    const $paginationInfoTotal = $('#paginationInfoTotal');
    const $paginationControls = $('#paginationControlsContainer');
    const $successBox = $('#successBox');
    const $errorBox = $('#errorBox');
    const $successText = $('#successText');
    const $errorText = $('#errorText');
    const $deleteModal = $('#deleteConfirmationModal');
    const $confirmDeleteBtn = $('#confirmDeleteBtn');
    const $closeDeleteModalBtn = $('#closeDeleteModalBtn');
    const $detailModal = $('#inquiryDetailModal');
    const $modalBody = $('#inquiryModalBody');

    let currentPage = 1;
    let deleteId = null;

    function showSuccess(msg) { $successText.text(msg); $successBox.removeClass('hidden'); }
    function showError(msg) { $errorText.text(msg); $errorBox.removeClass('hidden'); }
    function hideAlerts() { $successBox.addClass('hidden'); $errorBox.addClass('hidden'); }

    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
    }

    async function loadData(page = 1) {
        hideAlerts();
        $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Loading...</td></tr>');
        try {
            const params = { page, per_page: 15 };
            const search = $searchInput.val().trim();
            if (search) params.search = search;
            const status = $statusFilter.val();
            if (status) params.status = status;
            const payload = await jsonRequest(`${apiBase}?${$.param(params)}`);
            const data = normalizeRecords(payload);
            const pagination = payload?.data || payload;
            const meta = pagination?.meta || pagination;
            const total = meta?.total || 0;
            const current = meta?.current_page || 1;
            const last = meta?.last_page || 1;
            const from = meta?.from || 0;
            const to = meta?.to || 0;

            if (!data.length) {
                $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">No inquiries found.</td></tr>');
            } else {
                $tbody.html(data.map((item, i) => buildTableRow(item, from + i)).join(''));
            }

            $paginationInfoStart.text(from);
            $paginationInfoEnd.text(to);
            $paginationInfoTotal.text(total);
            renderPagination(current, last);
            refreshIcons();
            currentPage = current;
        } catch (err) {
            showError(err.message);
            $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Failed to load inquiries.</td></tr>');
        }
    }

    function renderPagination(current, last) {
        $paginationControls.empty();
        if (last <= 1) return;
        $paginationControls.append(`<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 ${current <= 1 ? 'opacity-50 cursor-not-allowed' : ''}" data-page="${current - 1}" ${current <= 1 ? 'disabled' : ''}>Prev</button>`);
        for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
            const active = i === current ? 'bg-cyan-500 text-white border-cyan-500' : 'border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700';
            $paginationControls.append(`<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border ${active}" data-page="${i}">${i}</button>`);
        }
        $paginationControls.append(`<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 ${current >= last ? 'opacity-50 cursor-not-allowed' : ''}" data-page="${current + 1}" ${current >= last ? 'disabled' : ''}>Next</button>`);
    }

    function renderDetailModal(inquiry) {
        const isResolved = inquiry.status === 'resolved' || inquiry.status === 'closed';

        $modalBody.html(`
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">${escapeHtml(inquiry.subject)}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">${formatDate(inquiry.created_at)}</p>
                </div>
                <button type="button" class="close-inquiry-modal rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
            <div class="mb-4 flex flex-wrap gap-2">
                ${statusBadge(inquiry.status)}
            </div>
            <div class="mb-4 rounded-xl border border-slate-200/60 bg-slate-50/50 p-4 dark:border-slate-700/60 dark:bg-slate-900/30">
                <div class="mb-3 grid gap-2 text-sm sm:grid-cols-2">
                    <div><span class="text-slate-500 dark:text-slate-400">From:</span> <span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(inquiry.user?.name || 'Unknown')}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Email:</span> <span class="text-slate-800 dark:text-slate-200">${escapeHtml(inquiry.email || 'N/A')}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Phone:</span> <span class="text-slate-800 dark:text-slate-200">${escapeHtml(inquiry.phone || 'N/A')}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Status:</span> <span class="text-slate-800 dark:text-slate-200">${escapeHtml(inquiry.status)}</span></div>
                </div>
                <div>
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Message:</span>
                    <p class="mt-1 text-sm leading-relaxed text-slate-700 dark:text-slate-300">${escapeHtml(inquiry.message)}</p>
                </div>
            </div>
            ${inquiry.admin_response ? `
            <div class="mb-4 rounded-xl border border-emerald-500/20 bg-emerald-500/5 p-4">
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Admin Response:</span>
                <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">${escapeHtml(inquiry.admin_response)}</p>
            </div>` : ''}
            ${!isResolved ? `
            <div class="border-t border-slate-200 pt-4 dark:border-slate-700">
                <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Reply to Inquiry</label>
                <textarea id="modalInquiryReplyInput" rows="3" class="mb-2 w-full rounded-lg border border-slate-300 bg-white p-2.5 text-sm transition-all focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500" placeholder="Write your reply..."></textarea>
                <div class="flex items-center gap-2">
                    <button type="button" class="modal-send-reply-btn rounded-lg bg-cyan-400 px-4 py-2 text-xs font-medium text-black hover:bg-cyan-500" data-inquiry-id="${inquiry.id}">Send Reply</button>
                    <span class="modal-reply-sending hidden text-xs text-slate-400">Sending...</span>
                </div>
            </div>` : ''}
        `);

        refreshIcons();
        $detailModal.removeClass('hidden').addClass('flex');
    }

    $paginationControls.on('click', '.page-btn', function () {
        const page = parseInt($(this).data('page'));
        if (!isNaN(page) && page >= 1) loadData(page);
    });

    let searchTimer;
    $searchInput.on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadData(1), 400);
    });
    $statusFilter.on('change', () => loadData(1));
    $refreshBtn.on('click', () => { $searchInput.val(''); $statusFilter.val(''); loadData(1); });

    $tbody.on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
    });
    $closeDeleteModalBtn.on('click', () => { $deleteModal.addClass('hidden').removeClass('flex'); deleteId = null; });
    $confirmDeleteBtn.on('click', async function () {
        if (!deleteId) return;
        hideAlerts();
        try {
            await jsonRequest(`${apiBase}/${deleteId}`, { method: 'DELETE' });
            showSuccess('Inquiry deleted successfully');
            $deleteModal.addClass('hidden').removeClass('flex');
            deleteId = null;
            loadData(currentPage);
        } catch (err) { showError(err.message); }
    });

    $('.close-alert').on('click', function () { $(this).closest('#successBox, #errorBox').addClass('hidden'); });

    // open detail modal
    $tbody.on('click', '.view-inquiry-btn', async function () {
        const id = $(this).data('id');
        try {
            const result = await jsonRequest(`${apiBase}/${id}`);
            renderDetailModal(result.data);
        } catch (err) {
            notify('Failed to load inquiry details.', 'error');
        }
    });

    // close detail modal on overlay click
    $(document).on('click', '#inquiryDetailModal', function (e) {
        if (e.target === this) $(this).addClass('hidden').removeClass('flex');
    });

    $(document).on('click', '.close-inquiry-modal', function () {
        $detailModal.addClass('hidden').removeClass('flex');
    });

    // send reply from modal
    $(document).off('click', '.modal-send-reply-btn').on('click', '.modal-send-reply-btn', async function () {
        const inquiryId = $(this).data('inquiry-id');
        const $input = $('#modalInquiryReplyInput');
        const reply = $input.val().trim();
        if (!reply) { notify('Please write a reply.', 'error'); return; }

        const $sending = $('.modal-reply-sending').removeClass('hidden');
        $(this).prop('disabled', true);

        try {
            await jsonRequest(`${apiBase}/${inquiryId}`, {
                method: 'PUT',
                body: {
                    admin_response: reply,
                    status: 'resolved',
                },
            });
            notify('Reply sent successfully.', 'success');
            $input.val('');
            // reload modal
            const result = await jsonRequest(`${apiBase}/${inquiryId}`);
            renderDetailModal(result.data);
            loadData(currentPage);
        } catch (err) {
            notify(err.payload?.message || 'Failed to send reply.', 'error');
        } finally {
            $sending.addClass('hidden');
            $(this).prop('disabled', false);
        }
    });

    $page.data('initialized', true);
    loadData(1);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-inquiries"]')) initInquiryPage();
});
