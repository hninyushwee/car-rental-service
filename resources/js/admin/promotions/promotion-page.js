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

function refreshIcons() { window.initLucideIcons?.(); }

function formatCurrency(amount) {
    return 'MMK ' + Number(amount || 0).toFixed(2);
}

function buildTableRow(promo, index) {
    const status = promo.status || 'disabled';
    const isActive = status === 'active';
    const badge = isActive
        ? `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>`
        : `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Inactive</span>`;
    const discountType = promo.discount_type || 'percentage';
    const discountValue = promo.discount_value || 0;
    const isPercent = discountType === 'percentage';
    const valueDisplay = isPercent ? discountValue + '%' : formatCurrency(discountValue);
    const maxDiscount = promo.max_discount;
    const maxDisplay = maxDiscount ? formatCurrency(maxDiscount) : '∞';
    const endDate = promo.end_date || promo.expires_at;
    const dateDisplay = endDate ? (endDate.split(' ')[0] || endDate.split('T')[0] || 'N/A') : 'N/A';
    const editBtn = isSuperAdmin ? `<a href="/admin/promotions/${promo.id}/edit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:bg-green-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-green-400 dark:hover:bg-green-950/30" title="Edit"><i data-lucide="edit" class="h-4 w-4 text-green-600 dark:text-green-400"></i></a>` : '';
    const deleteBtn = isSuperAdmin ? `<button type="button" class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30" data-id="${promo.id}" title="Delete"><i data-lucide="trash-2" class="h-4 w-4"></i></button>` : '';
    return `<tr class="border-b border-slate-100 transition-colors hover:bg-slate-50/50 dark:border-slate-700/30 dark:hover:bg-slate-700/20">
        <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">${index}</td>
        <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(promo.code)}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${isPercent ? 'Percentage' : 'Fixed Amount'}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${valueDisplay}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${maxDisplay}</td>
        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${escapeHtml(dateDisplay)}</td>
        <td class="px-4 py-3">${badge}</td>
        <td class="px-4 py-3 text-right">
            <div class="flex items-center justify-end gap-1">
                <a href="/admin/promotions/${promo.id}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-cyan-400 dark:hover:bg-cyan-950/30" title="View">
                    <i data-lucide="eye" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                </a>
                ${editBtn}
                ${deleteBtn}
            </div>
        </td>
    </tr>`;
}

let isSuperAdmin = false;

function initPromotionPage() {
    const $page = $('[data-page="admin-promotions"]');
    if (!$page.length || $page.data('initialized')) return;

    isSuperAdmin = $page.data('is-super-admin') === true;
    const apiBase = $page.data('api-base');
    const $tbody = $('#promotionsTableBody');
    const $searchInput = $('#searchInput');
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

    function showSuccess(msg) { $successText.text(msg); $successBox.removeClass('hidden'); }
    function showError(msg) { $errorText.text(msg); $errorBox.removeClass('hidden'); }
    function hideAlerts() { $successBox.addClass('hidden'); $errorBox.addClass('hidden'); }

    async function loadData(page = 1) {
        hideAlerts();
        $tbody.html('<tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Loading...</td></tr>');
        try {
            const params = { page, per_page: 15 };
            const search = $searchInput.val().trim();
            if (search) params.search = search;
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
                $tbody.html('<tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">No promotions found.</td></tr>');
            } else {
                $tbody.html(data.map((p, i) => buildTableRow(p, from + i)).join(''));
            }

            $paginationInfoStart.text(from);
            $paginationInfoEnd.text(to);
            $paginationInfoTotal.text(total);
            renderPagination(current, last);
            refreshIcons();
            currentPage = current;
        } catch (err) {
            showError(err.message);
            $tbody.html('<tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Failed to load promotions.</td></tr>');
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

    $paginationControls.on('click', '.page-btn', function () {
        const page = parseInt($(this).data('page'));
        if (!isNaN(page) && page >= 1) loadData(page);
    });

    let searchTimer;
    $searchInput.on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => loadData(1), 400);
    });
    $refreshBtn.on('click', () => { $searchInput.val(''); loadData(1); });

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
            showSuccess('Promotion deleted successfully');
            $deleteModal.addClass('hidden').removeClass('flex');
            deleteId = null;
            loadData(currentPage);
        } catch (err) { showError(err.message); }
    });

    $('.close-alert').on('click', function () { $(this).closest('#successBox, #errorBox').addClass('hidden'); });

    $page.data('initialized', true);
    loadData(1);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-promotions"]')) initPromotionPage();
});
