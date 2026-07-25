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

function stockBadge(available, total) {
    if (available <= 0) return 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300';
    if (available <= 2) return 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300';
    return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300';
}

function initVehicleShowPage() {
    const $page = $('[data-page="admin-vehicle-show"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const vehicleId = $page.data('id');
    const apiBase = $page.data('apiBase') || '/api/admin/vehicles';
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
                <p class="font-bold">Failed to load vehicle details.</p>
            </div>
        `);
        notify(error.payload?.message || 'Failed to load vehicle details.', 'error');
        refreshIcons();
    }

    function renderSpecs(vehicle, brandName, modelName) {
        const specs = [
            ['Category', vehicle.category?.name || 'N/A'],
            ['Brand', brandName],
            ['Model', modelName],
            ['Year Manufactured', vehicle.year || 'N/A'],
            ['Body Color', vehicle.color || 'N/A'],
            ['Seating Capacity', vehicle.capacity || 'N/A'],
            ['Available Stock', String(vehicle.available_stock ?? 'N/A')],
            ['Total Stock', String(vehicle.total_stock ?? 'N/A')],
        ];

        $('#specsContainer').html(specs.map(([label, value]) => `
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                <span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(label)}</span>
                <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(value)}</span>
            </div>
        `).join(''));
        $('#specCount').text(specs.length);
    }

    function renderDrivers(vehicle) {
        const drivers = vehicle.drivers;
        if (!drivers || !drivers.length) {
            $('#driversSection').addClass('hidden');
            return;
        }

        const items = drivers.map(d => {
            const name = d.name || 'Unknown';
            const phone = d.phone || '';
            const licenseType = d.driving_license_type?.type || '';
            const licenseNumber = d.license_number || '';
            const isPrimary = d.pivot?.is_primary;
            const assignedAt = d.pivot?.assigned_at ? new Date(d.pivot.assigned_at).toLocaleDateString() : '';

            let subtitle = phone;
            if (licenseType) subtitle += ` · ${licenseType}`;
            if (licenseNumber) subtitle += ` (${licenseNumber})`;

            return `
                <div class="flex items-center justify-between gap-3 rounded-lg border border-slate-100 bg-slate-50/50 p-3 dark:border-slate-700 dark:bg-slate-900/50">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="shrink-0 flex h-9 w-9 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400">
                            <i data-lucide="user" class="h-4 w-4"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white truncate">${escapeHtml(name)}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">${escapeHtml(subtitle)}${assignedAt ? ` · Assigned ${assignedAt}` : ''}</p>
                        </div>
                    </div>
                    ${isPrimary ? '<span class="shrink-0 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Primary</span>' : ''}
                </div>
            `;
        }).join('');

        $('#driversList').html(items);
        $('#driversSection').removeClass('hidden');
    }

    function renderVehicle(vehicle) {
        const brandName = vehicle.brand?.name || 'Unknown';
        const modelName = vehicle.model || 'Unknown Model';
        const fullName = `${brandName} ${modelName}`;
        const avail = Number(vehicle.available_stock) || 0;
        const total = Number(vehicle.total_stock) || 0;

        $('#vehicleTitleName').text(fullName);
        $('#vehicleSubtitleDesc').text(`${fullName} registration data profile details.`);
        $('#mainSectionHeader').text(fullName);
        $('#mainSectionSubtext').text(`${vehicle.category?.name || 'Standard'} Fleet Classification`);
        $('#cardPrice').text(money(vehicle.price_per_day));
        $('#cardStock').text(`${avail} / ${total}`);
        $('#cardCapacity').text(vehicle.capacity ? `${vehicle.capacity} Seats` : '-');
        $('#cardColor').text(vehicle.color || '-');
        $('#editVehicleBtn').attr('href', `${adminUrl}/vehicles/${vehicle.id}/edit`);

        if (vehicle.description?.trim()) {
            $('#vehicleDescription').text(vehicle.description);
        }

        const images = vehicle.images || [];
        const firstImage = images[0];
        if (firstImage?.trim()) {
            const imagePath = firstImage.startsWith('http') ? firstImage : `/storage/${firstImage}`;
            $('#vehicleImage').attr('src', imagePath).removeClass('hidden');
            $('#imageFallback').addClass('hidden');
        } else {
            $('#vehicleImage').addClass('hidden');
            $('#imageFallback').removeClass('hidden');
        }

        $('#statusBadge').attr('class', `inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold ${stockBadge(avail, total)}`);
        const label = avail <= 0 ? 'Out of Stock' : (avail <= 2 ? 'Low Stock' : 'In Stock');
        $('#statusText').text(label);
        renderSpecs(vehicle, brandName, modelName);
        renderDrivers(vehicle);

        $('#loadingState').addClass('hidden');
        $('#detailsContent').removeClass('hidden').addClass('animate-fade-in');
        refreshIcons();
    }

    async function loadVehicle() {
        try {
            const response = await jsonRequest(`${apiBase}/${vehicleId}`);
            renderVehicle(response.data || response.vehicle || response);
        } catch (error) {
            showLoadError(error);
        }
    }

    loadVehicle();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initVehicleShowPage();
} else {
    window.addEventListener('DOMContentLoaded', initVehicleShowPage);
    window.addEventListener('load', initVehicleShowPage);
}
