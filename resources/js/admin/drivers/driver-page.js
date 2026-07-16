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

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function statusClasses(status) {
    const map = {
        available: ['bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', 'bg-green-500'],
        on_trip: ['bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400', 'bg-yellow-500'],
        off_duty: ['bg-slate-100 text-slate-800 dark:bg-slate-900/30 dark:text-slate-400', 'bg-slate-500'],
    };

    return map[status] || map.off_duty;
}

function calculateStats(list) {
    return {
        total: list.length,
        available: list.filter((driver) => driver.status === 'available').length,
        on_trip: list.filter((driver) => driver.status === 'on_trip').length,
        off_duty: list.filter((driver) => driver.status === 'off_duty').length,
    };
}

function initDriverPage() {
    const $page = $('[data-page="admin-drivers"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const $tableBody = $('#driversTableBody');
    const $searchInput = $('#searchInput');
    const $licenseTypeFilter = $('#licenseTypeFilter');
    const $statusFilter = $('#statusFilter');
    const $refreshBtn = $('#refreshBtn');
    const $deleteModal = $('#deleteConfirmationModal');
    const apiBase = $page.data('apiBase') || '/api/admin/drivers';
    const loginUrl = $page.data('loginUrl') || '/login';
    const adminUrl = $page.data('adminUrl') || '/admin';
    const isSuperAdmin = $page.data('is-super-admin') === true;

    let drivers = [];
    let filteredDrivers = [];
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
        $('#statAvailable').text(stats.available ?? 0);
        $('#statOnTrip').text(stats.on_trip ?? 0);
        $('#statOffDuty').text(stats.off_duty ?? 0);
    }

    function filterDrivers() {
        const search = $searchInput.val().toLowerCase().trim();
        const licenseTypeId = $licenseTypeFilter.val();
        const status = $statusFilter.val().toLowerCase();

        filteredDrivers = drivers.filter((driver) => {
            const haystack = [
                driver.name,
                driver.phone,
                driver.license_number,
                driver.driving_license_type?.type || '',
            ].join(' ').toLowerCase();

            return haystack.includes(search)
                && (!licenseTypeId || String(driver.driving_license_type_id) === licenseTypeId)
                && (!status || driver.status === status);
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

    function renderRow(driver, index) {
        const status = escapeHtml(driver.status || 'off_duty');
        const [badgeColor, dotColor] = statusClasses(status);
        const statusLabel = status === 'on_trip' ? 'On Trip' : status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ');
        const editBtn = isSuperAdmin ? `<a href="${adminUrl}/drivers/${escapeHtml(driver.id)}/edit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:bg-green-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-green-400 dark:hover:bg-green-950/30" title="Edit"><i class="h-4 w-4 text-green-600 dark:text-green-400" data-lucide="edit"></i></a>` : '';
        const deleteBtn = isSuperAdmin ? `<button type="button" data-id="${escapeHtml(driver.id)}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30" title="Delete"><i class="h-4 w-4" data-lucide="trash-2"></i></button>` : '';

        return `
            <tr class="border-b border-slate-200/60 transition-colors hover:bg-slate-50/50 dark:border-slate-700/60 dark:hover:bg-slate-700/30">
                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${index}</td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-cyan-400 to-blue-600 text-xs font-bold text-white">
                            ${escapeHtml((driver.name || '?').charAt(0).toUpperCase())}
                        </div>
                        <span class="font-semibold text-slate-900 dark:text-white">${escapeHtml(driver.name)}</span>
                    </div>
                </td>
                <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300">${escapeHtml(driver.phone)}</td>
                <td class="px-4 py-3 font-mono text-xs tracking-wider text-slate-600 dark:text-slate-400">${escapeHtml(driver.license_number)}</td>
                <td class="px-4 py-3">
                    ${driver.driving_license_type
                        ? `<span class="inline-flex items-center rounded-full bg-cyan-100 px-2.5 py-1 text-xs font-medium text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-300">${escapeHtml(driver.driving_license_type.type)}</span>`
                        : '<span class="text-xs text-slate-400">-</span>'}
                </td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${badgeColor}">
                        <span class="inline-block h-1.5 w-1.5 rounded-full ${dotColor}"></span>
                        ${statusLabel}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="${adminUrl}/drivers/${escapeHtml(driver.id)}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-cyan-400 dark:hover:bg-cyan-950/30" title="View Details">
                            <i class="h-4 w-4 text-cyan-600 dark:text-cyan-400" data-lucide="eye"></i>
                        </a>
                        ${editBtn}
                        ${deleteBtn}
                    </div>
                </td>
            </tr>
        `;
    }

    function renderTable() {
        const total = filteredDrivers.length;

        if (!total) {
            $tableBody.html(`
                <tr>
                    <td colspan="8" class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                            <span>No drivers match your active filters.</span>
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
        const pageItems = filteredDrivers.slice(startOffset, endOffset);

        $tableBody.html(pageItems.map((driver, index) => renderRow(driver, startOffset + index + 1)).join(''));
        renderPagination(startOffset + 1, endOffset, total);
        refreshIcons();
    }

    function populateLicenseTypeFilter() {
        const ids = new Set();
        drivers.forEach(d => { if (d.driving_license_type_id) ids.add(d.driving_license_type_id); });
        const current = $licenseTypeFilter.val();
        $licenseTypeFilter.html('<option value="">All Licenses</option>');
        ids.forEach(id => {
            const d = drivers.find(d => d.driving_license_type_id === id);
            if (d?.driving_license_type) {
                $licenseTypeFilter.append(`<option value="${id}">${escapeHtml(d.driving_license_type.type)}</option>`);
            }
        });
        $licenseTypeFilter.val(current);
    }

    async function loadDrivers() {
        $tableBody.html('<tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Loading driver profiles...</td></tr>');

        try {
            const result = await jsonRequest(apiBase);
            drivers = normalizeRecords(result);
            filteredDrivers = [...drivers];
            populateLicenseTypeFilter();
            updateStats(result.stats || calculateStats(drivers));
            renderTable();
        } catch (error) {
            $tableBody.html('<tr><td colspan="8" class="px-4 py-12 text-center font-medium text-red-500">Failed to load driver profiles.</td></tr>');
            handleError(error, 'Failed to fetch driver records.');
        }
    }

    function closeDeleteModal() {
        targetDeleteId = null;
        $deleteModal.addClass('hidden').removeClass('flex');
        document.body.style.overflow = '';
    }

    async function deleteDriver() {
        if (!targetDeleteId) return;

        try {
            const response = await jsonRequest(`${apiBase}/${targetDeleteId}`, { method: 'DELETE' });
            closeDeleteModal();
            await loadDrivers();
            showAlert('success', response.message || 'Driver deleted successfully.');
        } catch (error) {
            closeDeleteModal();
            handleError(error, 'Could not delete the selected driver.');
        }
    }

    $searchInput.on('input', filterDrivers);
    $licenseTypeFilter.on('change', filterDrivers);
    $statusFilter.on('change', filterDrivers);
    $refreshBtn.on('click', function () {
        $searchInput.val('');
        $licenseTypeFilter.val('');
        $statusFilter.val('');
        loadDrivers();
    });

    $tableBody.on('click', '.delete-btn', function () {
        targetDeleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
        document.body.style.overflow = 'hidden';
    });

    $('#closeDeleteModalBtn').on('click', closeDeleteModal);
    $('#confirmDeleteBtn').on('click', deleteDriver);
    $deleteModal.on('click', function (event) {
        if (event.target === this) closeDeleteModal();
    });

    $(document).on('click', '.pagination-trigger', function () {
        if ($(this).prop('disabled')) return;
        currentPage = Number($(this).data('page'));
        renderTable();
    });

    loadDrivers();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initDriverPage();
} else {
    window.addEventListener('DOMContentLoaded', initDriverPage);
    window.addEventListener('load', initDriverPage);
}
