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

function refreshIcons() {
    window.initLucideIcons?.();
}

function calculateStats(list) {
    return {
        total: list.length,
        verified: list.filter((u) => u.email_verified_at !== null).length,
        unverified: list.filter((u) => u.email_verified_at === null).length,
        withBookings: list.filter((u) => Number(u.bookings_count ?? u.bookings?.length ?? 0) > 0).length,
    };
}

function initCustomerPage() {
    const $page = $('[data-page="admin-customers"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const $tableBody = $('#customersTableBody');
    const $searchInput = $('#searchInput');
    const $verifiedFilter = $('#verifiedFilter');
    const $refreshBtn = $('#refreshBtn');
    const $deleteModal = $('#deleteConfirmationModal');
    const apiBase = $page.data('apiBase') || '/api/admin/users';
    const loginUrl = $page.data('loginUrl') || '/login';

    let users = [];
    let filteredUsers = [];
    let targetDeleteId = null;
    let currentPage = 1;
    const recordsPerPage = 5;

    function showAlert(type, message) {
        notify(message, type);
        refreshIcons();
    }

    function handleError(error, fallbackMessage) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }

        showAlert('error', error.payload?.message || fallbackMessage);
    }

    function updateStats(stats) {
        $('#statTotal').text(stats.total ?? 0);
        $('#statVerified').text(stats.verified ?? 0);
        $('#statUnverified').text(stats.unverified ?? 0);
        $('#statWithBookings').text(stats.withBookings ?? 0);
    }

    function formatDate(dateStr) {
        if (!dateStr) return 'N/A';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    }

    function filterUsers() {
        const search = $searchInput.val().toLowerCase().trim();
        const verified = $verifiedFilter.val().toLowerCase();

        filteredUsers = users.filter((user) => {
            const haystack = [user.name, user.email, user.phone].join(' ').toLowerCase();
            const isVerified = user.email_verified_at !== null;

            return haystack.includes(search) && (!verified || (verified === 'verified' ? isVerified : !isVerified));
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
        const isVerified = user.email_verified_at !== null;
        const badgeColor = isVerified
            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
            : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
        const dotColor = isVerified ? 'bg-green-500' : 'bg-yellow-500';

        return `
            <tr class="border-b border-slate-200/60 transition-colors hover:bg-slate-50/50 dark:border-slate-700/60 dark:hover:bg-slate-700/30">
                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${index}</td>
                <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">${escapeHtml(user.name)}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${escapeHtml(user.email)}</td>
                <td class="px-4 py-3 font-mono text-xs tracking-wider text-slate-600 dark:text-slate-400">${escapeHtml(user.phone || 'N/A')}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${formatDate(user.created_at)}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${badgeColor}">
                        <span class="inline-block h-1.5 w-1.5 rounded-full ${dotColor}"></span>
                        ${isVerified ? 'Verified' : 'Unverified'}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="/admin/customers/${escapeHtml(user.id)}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-cyan-400 dark:hover:bg-cyan-950/30" title="View Details">
                            <i class="h-4 w-4 text-cyan-600 dark:text-cyan-400" data-lucide="eye"></i>
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
        const total = filteredUsers.length;

        if (!total) {
            $tableBody.html(`
                <tr>
                    <td colspan="7" class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                            <span>No customers match your active filters.</span>
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
        const pageItems = filteredUsers.slice(startOffset, endOffset);

        $tableBody.html(pageItems.map((user, index) => renderRow(user, startOffset + index + 1)).join(''));
        renderPagination(startOffset + 1, endOffset, total);
        refreshIcons();
    }

    async function loadUsers() {
        $tableBody.html('<tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">Loading customer data...</td></tr>');

        try {
            const result = await jsonRequest(apiBase);
            users = normalizeRecords(result);
            filteredUsers = [...users];
            updateStats(calculateStats(users));
            renderTable();
        } catch (error) {
            $tableBody.html('<tr><td colspan="7" class="px-4 py-12 text-center font-medium text-red-500">Failed to load customer data.</td></tr>');
            handleError(error, 'Failed to fetch customer details.');
        }
    }

    function closeDeleteModal() {
        targetDeleteId = null;
        $deleteModal.addClass('hidden').removeClass('flex');
        document.body.style.overflow = '';
    }

    async function deleteUser() {
        if (!targetDeleteId) return;

        try {
            const response = await jsonRequest(`${apiBase}/${targetDeleteId}`, { method: 'DELETE' });
            closeDeleteModal();
            await loadUsers();
            showAlert('success', response.message || 'Customer deleted successfully.');
        } catch (error) {
            closeDeleteModal();
            handleError(error, 'Could not delete the selected customer.');
        }
    }

    $searchInput.on('input', filterUsers);
    $verifiedFilter.on('change', filterUsers);
    $refreshBtn.on('click', function () {
        $searchInput.val('');
        $verifiedFilter.val('');
        loadUsers();
    });

    $tableBody.on('click', '.delete-btn', function () {
        targetDeleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
        document.body.style.overflow = 'hidden';
    });

    $('#closeDeleteModalBtn').on('click', closeDeleteModal);
    $('#confirmDeleteBtn').on('click', deleteUser);
    $deleteModal.on('click', function (event) {
        if (event.target === this) closeDeleteModal();
    });

    $(document).on('click', '.pagination-trigger', function () {
        if ($(this).prop('disabled')) return;
        currentPage = Number($(this).data('page'));
        renderTable();
    });

    loadUsers();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initCustomerPage();
} else {
    window.addEventListener('DOMContentLoaded', initCustomerPage);
    window.addEventListener('load', initCustomerPage);
}
