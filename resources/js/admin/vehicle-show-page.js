import $ from 'jquery';
import { jsonRequest } from './http';
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

function statusClass(status) {
    if (status === 'available') {
        return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300';
    }

    if (status === 'rented') {
        return 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300';
    }

    return 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300';
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
            ['License Plate', vehicle.license_plate || 'N/A'],
            ['Body Color', vehicle.color || 'N/A'],
            ['Seating Capacity', vehicle.capacity || 'N/A'],
        ];

        $('#specsContainer').html(specs.map(([label, value]) => `
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                <span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(label)}</span>
                <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(value)}</span>
            </div>
        `).join(''));
    }

    function renderVehicle(vehicle) {
        const brandName = vehicle.brand?.name || 'Unknown';
        const modelName = vehicle.model || 'Unknown Model';
        const fullName = `${brandName} ${modelName}`;
        const rawStatus = (vehicle.status || 'available').toLowerCase();

        $('#vehicleTitleName').text(fullName);
        $('#vehicleSubtitleDesc').text(`${fullName} registration data profile details.`);
        $('#mainSectionHeader').text(fullName);
        $('#mainSectionSubtext').text(`${vehicle.category?.name || 'Standard'} Fleet Classification`);
        $('#cardPrice').text(money(vehicle.price_per_day));
        $('#cardPlate').text(vehicle.license_plate || '-');
        $('#cardCapacity').text(vehicle.capacity ? `${vehicle.capacity} Seats` : '-');
        $('#cardColor').text(vehicle.color || '-');
        $('#editVehicleBtn').attr('href', `/admin/vehicles/${vehicle.id}/edit`);

        if (vehicle.description?.trim()) {
            $('#vehicleDescription').text(vehicle.description);
        }

        if (vehicle.image?.trim()) {
            const imagePath = vehicle.image.startsWith('http') ? vehicle.image : `/storage/${vehicle.image}`;
            $('#vehicleImage').attr('src', imagePath).removeClass('hidden');
            $('#imageFallback').addClass('hidden');
        } else {
            $('#vehicleImage').addClass('hidden');
            $('#imageFallback').removeClass('hidden');
        }

        $('#statusBadge').attr('class', `inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold ${statusClass(rawStatus)}`);
        $('#statusText').text(rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1));
        renderSpecs(vehicle, brandName, modelName);

        $('#loadingState').addClass('hidden');
        $('#detailsContent').removeClass('hidden');
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
