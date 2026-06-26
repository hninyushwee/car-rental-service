import $ from 'jquery';
import { jsonRequest, normalizeRecords } from './http';
import { notify } from './notify';

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
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(Number(value || 0));
}

function statusClasses(status) {
    const map = {
        available: ['bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', 'bg-green-500'],
        rented: ['bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400', 'bg-yellow-500'],
        maintenance: ['bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400', 'bg-red-500'],
    };

    return map[status] || map.maintenance;
}

function calculateStats(list) {
    return {
        total: list.length,
        available: list.filter((vehicle) => vehicle.status === 'available').length,
        rented: list.filter((vehicle) => vehicle.status === 'rented').length,
        maintenance: list.filter((vehicle) => vehicle.status === 'maintenance').length,
    };
}

function initVehiclePage() {
    const $page = $('[data-page="admin-vehicles"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const $tableBody = $('#vehiclesTableBody');
    const $searchInput = $('#searchInput');
    const $statusFilter = $('#statusFilter');
    const $refreshBtn = $('#refreshBtn');
    const $deleteModal = $('#deleteConfirmationModal');
    const apiBase = $page.data('apiBase') || '/api/admin/vehicles';
    const loginUrl = $page.data('loginUrl') || '/login';

    let vehicles = [];
    let filteredVehicles = [];
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
        $('#statRented').text(stats.rented ?? 0);
        $('#statMaintenance').text(stats.maintenance ?? 0);
    }

    function filterVehicles() {
        const search = $searchInput.val().toLowerCase().trim();
        const status = $statusFilter.val().toLowerCase();

        filteredVehicles = vehicles.filter((vehicle) => {
            const haystack = [
                vehicle.brand?.name,
                vehicle.model,
                vehicle.license_plate,
                vehicle.category?.name,
            ].join(' ').toLowerCase();

            return haystack.includes(search) && (!status || vehicle.status === status);
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

    function renderRow(vehicle, index) {
        const status = escapeHtml(vehicle.status || 'maintenance');
        const [badgeColor, dotColor] = statusClasses(status);
        const statusLabel = status.charAt(0).toUpperCase() + status.slice(1);

        return `
            <tr class="border-b border-slate-200/60 transition-colors hover:bg-slate-50/50 dark:border-slate-700/60 dark:hover:bg-slate-700/30">
                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${index}</td>
                <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">${escapeHtml(vehicle.brand?.name || 'Unknown')}</td>
                <td class="px-4 py-3 font-medium text-slate-700 dark:text-slate-300">${escapeHtml(vehicle.model)}</td>
                <td class="px-4 py-3 font-mono text-xs tracking-wider text-slate-600 dark:text-slate-400">${escapeHtml(vehicle.license_plate)}</td>
                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${escapeHtml(vehicle.category?.name || 'N/A')}</td>
                <td class="px-4 py-3 font-medium text-slate-600 dark:text-slate-400">${escapeHtml(vehicle.year)}</td>
                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">${money(vehicle.price_per_day)}</td>
                <td class="px-4 py-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${badgeColor}">
                        <span class="inline-block h-1.5 w-1.5 rounded-full ${dotColor}"></span>
                        ${statusLabel}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="/admin/vehicles/${escapeHtml(vehicle.id)}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-slate-500 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900" title="View Details">
                            <i class="h-4 w-4" data-lucide="eye"></i>
                        </a>
                        <a href="/admin/vehicles/${escapeHtml(vehicle.id)}/edit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-cyan-600 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900" title="Edit">
                            <i class="h-4 w-4" data-lucide="pencil"></i>
                        </a>
                        <button type="button" data-id="${escapeHtml(vehicle.id)}" class="delete-btn inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900" title="Delete">
                            <i class="h-4 w-4" data-lucide="trash-2"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }

    function renderTable() {
        const total = filteredVehicles.length;

        if (!total) {
            $tableBody.html(`
                <tr>
                    <td colspan="9" class="py-12 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                            <span>No vehicles match your active filters.</span>
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
        const pageItems = filteredVehicles.slice(startOffset, endOffset);

        $tableBody.html(pageItems.map((vehicle, index) => renderRow(vehicle, startOffset + index + 1)).join(''));
        renderPagination(startOffset + 1, endOffset, total);
        refreshIcons();
    }

    async function loadVehicles() {
        $tableBody.html('<tr><td colspan="9" class="px-4 py-12 text-center text-slate-400">Loading fleet information...</td></tr>');

        try {
            const result = await jsonRequest(apiBase);
            vehicles = normalizeRecords(result);
            filteredVehicles = [...vehicles];
            updateStats(result.stats || calculateStats(vehicles));
            renderTable();
        } catch (error) {
            $tableBody.html('<tr><td colspan="9" class="px-4 py-12 text-center font-medium text-red-500">Failed to update inventory.</td></tr>');
            handleError(error, 'Failed to fetch vehicle details.');
        }
    }

    function closeDeleteModal() {
        targetDeleteId = null;
        $deleteModal.addClass('hidden').removeClass('flex');
        document.body.style.overflow = '';
    }

    async function deleteVehicle() {
        if (!targetDeleteId) return;

        try {
            const response = await jsonRequest(`${apiBase}/${targetDeleteId}`, { method: 'DELETE' });
            closeDeleteModal();
            await loadVehicles();
            showAlert('success', response.message || 'Vehicle deleted successfully.');
        } catch (error) {
            closeDeleteModal();
            handleError(error, 'Could not delete the selected vehicle.');
        }
    }

    $searchInput.on('input', filterVehicles);
    $statusFilter.on('change', filterVehicles);
    $refreshBtn.on('click', function () {
        $searchInput.val('');
        $statusFilter.val('');
        loadVehicles();
    });

    $tableBody.on('click', '.delete-btn', function () {
        targetDeleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
        document.body.style.overflow = 'hidden';
    });

    $('#closeDeleteModalBtn').on('click', closeDeleteModal);
    $('#confirmDeleteBtn').on('click', deleteVehicle);
    $deleteModal.on('click', function (event) {
        if (event.target === this) closeDeleteModal();
    });

    $(document).on('click', '.pagination-trigger', function () {
        if ($(this).prop('disabled')) return;
        currentPage = Number($(this).data('page'));
        renderTable();
    });

    loadVehicles();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initVehiclePage();
} else {
    window.addEventListener('DOMContentLoaded', initVehiclePage);
    window.addEventListener('load', initVehiclePage);
}
