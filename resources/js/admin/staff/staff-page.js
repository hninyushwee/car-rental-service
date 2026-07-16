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

function initStaffPage() {
    const $page = $('[data-page="admin-staff"]');

    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const $tableBody = $('#staffTableBody');
    const $searchInput = $('#searchInput');
    const $refreshBtn = $('#refreshBtn');
    const $deleteModal = $('#deleteConfirmationModal');
    const apiBase = $page.data('apiBase') || '/api/admin/staff';
    const loginUrl = $page.data('loginUrl') || '/login';

    let staff = [];
    let filteredStaff = [];
    let targetDeleteId = null;
    let currentPage = 1;
    const recordsPerPage = 10;

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
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }

    function filterStaff() {
        const search = $searchInput.val().toLowerCase().trim();
        filteredStaff = staff.filter((s) => {
            return [s.name, s.email, s.phone].join(' ').toLowerCase().includes(search);
        });
        currentPage = 1;
        renderTable();
    }

    function renderPagination(start, end, total) {
        $('#paginationInfoStart').text(start);
        $('#paginationInfoEnd').text(end);
        $('#paginationInfoTotal').text(total);

        const totalPages = Math.ceil(total / recordsPerPage);
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

    function renderRow(user, index) {
        return `
            <tr class="border-b border-slate-200/60 transition-colors hover:bg-slate-50/50 dark:border-slate-700/60 dark:hover:bg-slate-700/30">
                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${index}</td>
                <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">${escapeHtml(user.name)}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${escapeHtml(user.email)}</td>
                <td class="px-4 py-3 font-mono text-xs tracking-wider text-slate-600 dark:text-slate-400">${escapeHtml(user.phone || 'N/A')}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${formatDate(user.created_at)}</td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="/admin/staff/${escapeHtml(user.id)}/edit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-emerald-500 hover:bg-emerald-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-emerald-400 dark:hover:bg-emerald-950/30" title="Edit">
                            <i class="h-4 w-4 text-emerald-600 dark:text-emerald-400" data-lucide="edit"></i>
                        </a>
                        <button type="button" data-id="${escapeHtml(user.id)}" class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30" title="Delete">
                            <i class="h-4 w-4" data-lucide="trash-2"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderTable() {
        const total = filteredStaff.length;

        if (!total) {
            $tableBody.html(`
                <tr>
                    <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                            <span>No staff members found.</span>
                        </div>
                    </td>
                </tr>
            `);
            renderPagination(0, 0, 0);
            refreshIcons();
            return;
        }

        const totalPages = Math.ceil(total / recordsPerPage);
        currentPage = Math.min(Math.max(currentPage, 1), totalPages);

        const startOffset = (currentPage - 1) * recordsPerPage;
        const endOffset = Math.min(startOffset + recordsPerPage, total);
        const pageItems = filteredStaff.slice(startOffset, endOffset);

        $tableBody.html(pageItems.map((user, index) => renderRow(user, startOffset + index + 1)).join(''));
        renderPagination(startOffset + 1, endOffset, total);
        refreshIcons();
    }

    async function loadStaff() {
        $tableBody.html('<tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Loading staff data...</td></tr>');

        try {
            const result = await jsonRequest(apiBase);
            const payload = result?.data?.data ?? result?.data ?? [];
            staff = Array.isArray(payload) ? payload : [];
            filteredStaff = [...staff];
            $('#statTotal').text(staff.length);
            renderTable();
        } catch (error) {
            $tableBody.html('<tr><td colspan="6" class="px-4 py-12 text-center font-medium text-red-500">Failed to load staff data.</td></tr>');
            handleError(error, 'Failed to fetch staff details.');
        }
    }

    function closeDeleteModal() {
        targetDeleteId = null;
        $deleteModal.addClass('hidden').removeClass('flex');
        document.body.style.overflow = '';
    }

    async function deleteStaff() {
        if (!targetDeleteId) return;

        try {
            const response = await jsonRequest(`${apiBase}/${targetDeleteId}`, { method: 'DELETE' });
            closeDeleteModal();
            await loadStaff();
            notify(response.message || 'Staff deleted successfully.', 'success');
        } catch (error) {
            closeDeleteModal();
            handleError(error, 'Could not delete the selected staff member.');
        }
    }

    $searchInput.on('input', filterStaff);
    $refreshBtn.on('click', function () {
        $searchInput.val('');
        loadStaff();
    });

    $tableBody.on('click', '.delete-btn', function () {
        targetDeleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
        document.body.style.overflow = 'hidden';
    });

    $('#closeDeleteModalBtn').on('click', closeDeleteModal);
    $('#confirmDeleteBtn').on('click', deleteStaff);
    $deleteModal.on('click', function (event) {
        if (event.target === this) closeDeleteModal();
    });

    $(document).on('click', '.pagination-trigger', function () {
        if ($(this).prop('disabled')) return;
        currentPage = Number($(this).data('page'));
        renderTable();
    });

    loadStaff();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initStaffPage();
} else {
    window.addEventListener('DOMContentLoaded', initStaffPage);
    window.addEventListener('load', initStaffPage);
}
