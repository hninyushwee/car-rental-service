import $ from 'jquery';
import { jsonRequest, normalizeRecords } from '../common/http';

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

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function statusBadge(status) {
    const map = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        confirmed: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        active: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        completed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        cancelled: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    };
    const cls = map[status] || map.pending;
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${cls}">${escapeHtml(status)}</span>`;
}

function buildTableRow(booking, index, adminUrl) {
    const transRef = Array.isArray(booking.payments) && booking.payments[0]?.transaction_ref
        ? booking.payments[0].transaction_ref : '';
    return `<tr class="border-b border-slate-100 transition-colors hover:bg-slate-50/50 dark:border-slate-700/30 dark:hover:bg-slate-700/20">
        <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">${index}</td>
        <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(booking.user?.name || 'N/A')}</td>
        <td class="px-4 py-3 text-sm font-mono text-slate-600 dark:text-slate-300">${escapeHtml(booking.booking_number || 'N/A')}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300 font-mono">${escapeHtml(transRef)}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${money(booking.total_price)}</td>
        <td class="px-4 py-3">${statusBadge(booking.status)}</td>
        <td class="px-4 py-3 text-right">
            <a href="${adminUrl}/bookings/${booking.id}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-cyan-400 dark:hover:bg-cyan-950/30" title="View">
                <i data-lucide="eye" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
            </a>
        </td>
    </tr>`;
}

function initBookingPage() {
    const $page = $('[data-page="admin-bookings"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const adminUrl = $page.data('admin-url') || '/admin';
    const $tbody = $('#bookingsTableBody');
    const $searchInput = $('#searchInput');
    const $statusFilter = $('#statusFilter');
    const $yearFilter = $('#yearFilter');
    const $monthFilter = $('#monthFilter');
    const $dayFilter = $('#dayFilter');
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

    let currentPage = 1;
    let deleteId = null;

    function populateYearFilter() {
        const current = new Date().getFullYear();
        for (let y = current; y >= current - 10; y--) {
            $yearFilter.append(`<option value="${y}">${y}</option>`);
        }
    }

    function populateDayFilter() {
        for (let d = 1; d <= 31; d++) {
            $dayFilter.append(`<option value="${d}">${d}</option>`);
        }
    }

    function getDateParams() {
        const year = $yearFilter.val();
        const month = $monthFilter.val();
        const day = $dayFilter.val();
        const params = {};
        if (year) params.year = year;
        if (month) params.month = month;
        if (day) params.day = day;
        return params;
    }

    function showSuccess(msg) { $successText.text(msg); $successBox.removeClass('hidden'); }
    function showError(msg) { $errorText.text(msg); $errorBox.removeClass('hidden'); }
    function hideAlerts() { $successBox.addClass('hidden'); $errorBox.addClass('hidden'); }

    async function loadData(page = 1) {
        hideAlerts();
        $tbody.html('<tr><td colspan="7" class="px-4 py-12 text-center text-slate-400"><div class="flex items-center justify-center gap-2"><svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg> Loading...</div></td>');
        try {
            const params = { page, per_page: 15 };
            const search = $searchInput.val().trim();
            if (search) params.search = search;
            const status = $statusFilter.val();
            if (status) params.status = status;
            Object.assign(params, getDateParams());
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
                $tbody.html('<tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">No bookings found.</td></tr>');
            } else {
                $tbody.html(data.map((b, i) => buildTableRow(b, from + i, adminUrl)).join(''));
            }

            $paginationInfoStart.text(from);
            $paginationInfoEnd.text(to);
            $paginationInfoTotal.text(total);
            renderPagination(current, last);
            refreshIcons();
            currentPage = current;
        } catch (err) {
            showError(err.message);
            $tbody.html('<tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">Failed to load bookings.</td></tr>');
        }
    }

    function renderPagination(current, last) {
        $paginationControls.empty();
        if (last <= 1) return;
        const prev = `<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 ${current <= 1 ? 'opacity-50 cursor-not-allowed' : ''}" data-page="${current - 1}" ${current <= 1 ? 'disabled' : ''}>Prev</button>`;
        const next = `<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 ${current >= last ? 'opacity-50 cursor-not-allowed' : ''}" data-page="${current + 1}" ${current >= last ? 'disabled' : ''}>Next</button>`;
        $paginationControls.append(prev);
        for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
            const active = i === current ? 'bg-cyan-500 text-white border-cyan-500' : 'border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700';
            $paginationControls.append(`<button type="button" class="page-btn pagination-btn rounded-lg px-3 py-1.5 text-xs font-medium transition border ${active}" data-page="${i}">${i}</button>`);
        }
        $paginationControls.append(next);
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
    $yearFilter.on('change', () => loadData(1));
    $monthFilter.on('change', () => loadData(1));
    $dayFilter.on('change', () => loadData(1));

    $refreshBtn.on('click', () => {
        $searchInput.val('');
        $statusFilter.val('');
        $yearFilter.val('');
        $monthFilter.val('');
        $dayFilter.val('');
        loadData(1);
    });

    $tbody.on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
    });

    $closeDeleteModalBtn.on('click', () => {
        $deleteModal.addClass('hidden').removeClass('flex');
        deleteId = null;
    });

    $confirmDeleteBtn.on('click', async function () {
        if (!deleteId) return;
        hideAlerts();
        try {
            await jsonRequest(`${apiBase}/${deleteId}`, { method: 'DELETE' });
            showSuccess('Booking deleted successfully');
            $deleteModal.addClass('hidden').removeClass('flex');
            deleteId = null;
            loadData(currentPage);
        } catch (err) {
            showError(err.message);
        }
    });

    $('.close-alert').on('click', function () {
        $(this).closest('#successBox, #errorBox').addClass('hidden');
    });

    populateYearFilter();
    populateDayFilter();

    $page.data('initialized', true);
    loadData(1);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-bookings"]')) {
        initBookingPage();
    }
});
