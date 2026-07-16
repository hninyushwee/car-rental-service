import $ from 'jquery';
import { jsonRequest, normalizeRecords } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function initDepositSettingsPage() {
    const $page = $('[data-page="admin-deposit-settings"]');
    if (!$page.length || $page.data('initialized')) return;

    const isSuperAdmin = $page.data('is-super-admin') === true;
    const apiBase = $page.data('api-base');
    const $tbody = $('#depositSettingsTableBody');
    const $searchInput = $('#searchInput');
    const $activeFilter = $('#activeFilter');
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

    function showSuccess(msg) { notify(msg, 'success'); }
    function showError(msg) { notify(msg, 'error'); }

    function renderTableRow(item, index) {
        const activeBadge = item.is_active
            ? '<span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">Active</span>'
            : '<span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">Inactive</span>';
        const depositType = item.deposit_type === 'percentage' ? '%' : 'MMK';
        const amount = item.deposit_type === 'percentage' ? `${Number(item.amount).toFixed(1)}%` : `MMK ${Number(item.amount).toFixed(2)}`;
        const editBtn = isSuperAdmin ? `<a href="/admin/deposit-settings/${item.id}/edit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:bg-green-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-green-400 dark:hover:bg-green-950/30" title="Edit"><i data-lucide="edit" class="h-4 w-4 text-green-600 dark:text-green-400"></i></a>` : '';
        const deleteBtn = isSuperAdmin ? `<button type="button" class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30" data-id="${item.id}" title="Delete"><i data-lucide="trash-2" class="h-4 w-4"></i></button>` : '';

        return `<tr class="border-b border-slate-100 transition-colors hover:bg-slate-50/50 dark:border-slate-700/30 dark:hover:bg-slate-700/20">
            <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">${index}</td>
            <td class="px-4 py-3 text-sm font-mono text-slate-900 dark:text-white">${escapeHtml(item.service_key)}</td>
            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">${depositType}</td>
            <td class="px-4 py-3 text-sm font-medium text-slate-900 dark:text-white">${amount}</td>
            <td class="px-4 py-3">${activeBadge}</td>
            <td class="px-4 py-3 text-right">
                <div class="flex items-center justify-end gap-1">
                    ${editBtn}
                    ${deleteBtn}
                </div>
            </td>
        </tr>`;
    }

    async function loadData(page = 1) {
        $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Loading...</td></tr>');
        try {
            const params = { page, per_page: 15 };
            const search = $searchInput.val().trim();
            if (search) params.search = search;
            const active = $activeFilter.val();
            if (active !== '') params.is_active = active;
            const payload = await jsonRequest(`${apiBase}?${$.param(params)}`);
            const data = normalizeRecords(payload);
            const meta = payload?.data?.meta || payload?.meta || {};
            const total = meta?.total || 0;
            const current = meta?.current_page || 1;
            const last = meta?.last_page || 1;
            const from = meta?.from || 0;
            const to = meta?.to || 0;

            if (!data.length) {
                $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">No deposit settings found.</td></tr>');
            } else {
                $tbody.html(data.map((item, i) => renderTableRow(item, from + i)).join(''));
            }

            $paginationInfoStart.text(from);
            $paginationInfoEnd.text(to);
            $paginationInfoTotal.text(total);
            renderPagination(current, last);
            refreshIcons();
            currentPage = current;
        } catch (err) {
            showError(err.payload?.message || err.message);
            $tbody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Failed to load deposit settings.</td></tr>');
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
    $activeFilter.on('change', () => loadData(1));
    $refreshBtn.on('click', () => { $searchInput.val(''); $activeFilter.val(''); loadData(1); });

    $tbody.on('click', '.delete-btn', function () {
        deleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
    });
    $closeDeleteModalBtn.on('click', () => { $deleteModal.addClass('hidden').removeClass('flex'); deleteId = null; });
    $confirmDeleteBtn.on('click', async function () {
        if (!deleteId) return;
        try {
            await jsonRequest(`${apiBase}/${deleteId}`, { method: 'DELETE' });
            showSuccess('Deposit setting deleted successfully');
            $deleteModal.addClass('hidden').removeClass('flex');
            deleteId = null;
            loadData(currentPage);
        } catch (err) { showError(err.message); }
    });

    $page.data('initialized', true);
    loadData(1);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-deposit-settings"]')) initDepositSettingsPage();
});
