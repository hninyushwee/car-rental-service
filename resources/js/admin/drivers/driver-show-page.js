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

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function statusClass(status) {
    if (status === 'available') {
        return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300';
    }

    if (status === 'on_trip') {
        return 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300';
    }

    return 'bg-slate-100 text-slate-700 dark:bg-slate-950 dark:text-slate-300';
}

function initDriverShowPage() {
    const $page = $('[data-page="admin-driver-show"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const driverId = $page.data('id');
    const apiBase = $page.data('apiBase') || '/api/admin/drivers';
    const loginUrl = $page.data('loginUrl') || '/login';
    const adminUrl = $page.data('adminUrl') || '/admin';

    function showLoadError(error) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }

        $('#loadingState').html(`
            <div class="p-6 text-center text-red-500">
                <i data-lucide="alert-circle" class="mx-auto mb-2 h-10 w-10"></i>
                <p class="font-bold">Failed to load driver details.</p>
            </div>
        `);
        notify(error.payload?.message || 'Failed to load driver details.', 'error');
        refreshIcons();
    }

    function renderSpecs(driver) {
        const specs = [
            ['Name', driver.name || 'N/A'],
            ['Email', driver.email || 'N/A'],
            ['Phone', driver.phone || 'N/A'],
            ['License Type', driver.driving_license_type?.type || 'N/A'],
            ['License Number', driver.license_number || 'N/A'],
            ['License Expiry', driver.license_expiry_date || 'N/A'],
            ['Address', driver.address || 'N/A'],
            ['Status', driver.status ? driver.status.replace('_', ' ').replace(/\b\w/g, (c) => c.toUpperCase()) : 'N/A'],
        ];

        $('#specsContainer').html(specs.map(([label, value]) => `
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                <span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(label)}</span>
                <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(value)}</span>
            </div>
        `).join(''));
    }

    function renderVehicles(driver) {
        const vehicles = driver.vehicles;
        if (!vehicles || !vehicles.length) {
            $('#vehiclesSection').addClass('hidden');
            return;
        }

        const items = vehicles.map(v => {
            const brandName = v.brand?.name || '';
            const modelName = v.model || 'Unknown';
            const year = v.year || '';
            const color = v.color || '';
            const isPrimary = v.pivot?.is_primary;
            const assignedAt = v.pivot?.assigned_at ? new Date(v.pivot.assigned_at).toLocaleDateString() : '';

            let label = `${brandName} ${modelName}`;
            if (year) label += ` (${year})`;
            if (color) label += ` — ${color}`;

            return `
                <div class="flex items-center justify-between gap-3 rounded-lg border border-slate-100 bg-slate-50/50 p-3 dark:border-slate-700 dark:bg-slate-900/50">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="shrink-0 flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400">
                            <i data-lucide="truck" class="h-4 w-4"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">${escapeHtml(label)}</p>
                            ${assignedAt ? `<p class="text-xs text-slate-500 dark:text-slate-400">Assigned ${assignedAt}</p>` : ''}
                        </div>
                    </div>
                    ${isPrimary ? '<span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Primary</span>' : ''}
                </div>
            `;
        }).join('');

        $('#vehiclesList').html(items);
        $('#vehiclesSection').removeClass('hidden');
    }

    function renderDriver(driver) {
        const name = driver.name || 'Unknown Driver';
        const rawStatus = (driver.status || 'off_duty').toLowerCase();

        $('#driverTitleName').text(name);
        $('#driverSubtitleDesc').text(`${name} — driver profile details.`);
        $('#mainSectionHeader').text(name);
        $('#mainSectionSubtext').text(`License: ${driver.license_number || 'N/A'}`);
        $('#cardPhone').text(driver.phone || '-');
        $('#cardLicenseType').text(driver.driving_license_type?.type || '-');
        $('#cardEmail').text(driver.email || '-');
        $('#cardLicense').text(driver.license_number || '-');
        $('#editDriverBtn').attr('href', `${adminUrl}/drivers/${driver.id}/edit`);

        if (driver.image?.trim()) {
            const imagePath = driver.image.startsWith('http') ? driver.image : `/storage/${driver.image}`;
            $('#driverImage').attr('src', imagePath).removeClass('hidden');
            $('#imageFallback').addClass('hidden');
        } else {
            $('#driverImage').addClass('hidden');
            $('#imageFallback').removeClass('hidden');
        }

        $('#statusBadge').attr('class', `inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold ${statusClass(rawStatus)}`);
        $('#statusText').text(rawStatus === 'on_trip' ? 'On Trip' : rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1).replace('_', ' '));
        renderSpecs(driver);
        renderVehicles(driver);

        $('#loadingState').addClass('hidden');
        $('#detailsContent').removeClass('hidden').addClass('animate-fade-in');
        refreshIcons();
    }

    async function loadDriver() {
        try {
            const response = await jsonRequest(`${apiBase}/${driverId}`);
            renderDriver(response.data || response.driver || response);
        } catch (error) {
            showLoadError(error);
        }
    }

    loadDriver();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initDriverShowPage();
} else {
    window.addEventListener('DOMContentLoaded', initDriverShowPage);
    window.addEventListener('load', initDriverShowPage);
}
