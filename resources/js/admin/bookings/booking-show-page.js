import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function imgSrc(val) {
    if (!val) return '';
    if (val.startsWith('http')) return val;
    if (val.startsWith('storage/')) return '/' + val;
    return '/storage/' + val;
}

function statusBadge(status) {
    const map = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        confirmed: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        active: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        completed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        cancelled: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    };
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${map[status] || map.pending}">${escapeHtml(status)}</span>`;
}

function renderBooking(booking, adminUrl) {
    const user = booking.user || {};
    const items = Array.isArray(booking.items) ? booking.items : [];
    const payments = Array.isArray(booking.payments) ? booking.payments : [];

    function itemRow(item) {
        const bookingStatus = booking.status;
        const isDriverItem = !item.vehicle_id && (item.driver_id || item.has_driver || parseFloat(item.driver_daily_rate) > 0);
        const days = item.start_date && item.end_date
            ? Math.max(1, Math.ceil((new Date(item.end_date) - new Date(item.start_date)) / (1000 * 60 * 60 * 24)) + 1) : 1;
        const rate = isDriverItem ? (parseFloat(item.driver_daily_rate) || 0) : (parseFloat(item.vehicle_daily_rate) || 0);
        const subtotal = rate * days * (parseInt(item.quantity) || 1);

        if (isDriverItem) {
            const d = item.driver;
            const isPending = bookingStatus === 'pending';
            const licenseMatch = item.notes?.match(/License:\s*([^|]+)/i);
            const licenseLabel = licenseMatch ? licenseMatch[1].trim() : '';

            let driverSelectHtml = '';
            if (isPending) {
                const currentDriverId = item.driver_id || '';
                driverSelectHtml = `
                    <div class="mt-2">
                        <label class="text-xs text-slate-500 dark:text-slate-400">Assign Driver ${licenseLabel ? `(License: ${escapeHtml(licenseLabel)})` : ''}</label>
                        <select class="driver-select mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm focus:border-cyan-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white" data-item-id="${item.id}" data-current="${currentDriverId}">
                            <option value="">Loading drivers...</option>
                        </select>
                    </div>`;
            }

            return `<div class="flex items-start gap-3 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                ${d?.image ? `<img src="${imgSrc(d.image)}" class="h-16 w-24 shrink-0 rounded-lg object-cover border border-slate-200">` : `<div class="flex h-16 w-24 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-slate-400 dark:bg-slate-800"><i data-lucide="user" class="h-6 w-6"></i></div>`}
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-900 dark:text-white">${escapeHtml(d?.name || 'Driver')} <span class="text-xs font-normal text-slate-500">(${d?.license_number || ''}${licenseLabel ? ' · License: ' + escapeHtml(licenseLabel) : ''} · ${item.quantity || 1} × ${days} day${days > 1 ? 's' : ''})</span></p>
                    <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                        <span><i data-lucide="calendar" class="inline h-3 w-3"></i> ${escapeHtml(item.start_date?.split(' ')[0] || '')} → ${escapeHtml(item.end_date?.split(' ')[0] || '')}</span>
                        <span><i data-lucide="map-pin" class="inline h-3 w-3"></i> ${escapeHtml(item.pickup_location || '')} → ${escapeHtml(item.dropoff_location || '')}</span>
                        ${d?.phone ? `<span><i data-lucide="phone" class="inline h-3 w-3"></i> ${escapeHtml(d.phone)}</span>` : ''}
                        ${d?.email ? `<span><i data-lucide="mail" class="inline h-3 w-3"></i> ${escapeHtml(d.email)}</span>` : ''}
                    </div>
                    ${driverSelectHtml}
                </div>
                <p class="shrink-0 text-sm font-bold text-slate-900 dark:text-white">${money(subtotal)}</p>
            </div>`;
        }

        const hasDriver = item.has_driver;
        const isPending = bookingStatus === 'pending';

        let driverDisplay;
        if (!hasDriver) {
            driverDisplay = `<span class="text-sm text-slate-400">Not requested</span>`;
        } else if (isPending) {
            const currentDriverId = item.driver_id || '';
            driverDisplay = `<select class="driver-select text-xs rounded-lg border border-slate-300 bg-white px-2 py-1 focus:border-cyan-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white" data-item-id="${item.id}" data-current="${currentDriverId}">
                <option value="">Loading drivers...</option>
            </select>`;
        } else {
            const driverImg = item.driver?.image;
            driverDisplay = `<div class="flex items-center gap-2">
                ${driverImg ? `<img src="${imgSrc(driverImg)}" class="h-7 w-7 rounded-full object-cover border border-slate-300">` : ''}
                <span class="text-sm font-medium text-emerald-600 dark:text-emerald-400">${escapeHtml(item.driver?.name || 'Auto-assigned')}</span>
            </div>`;
        }

        const vehicleImg = item.vehicle?.images?.[0];

        return `<div class="flex items-start gap-3 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
            ${vehicleImg ? `<img src="${imgSrc(vehicleImg)}" class="h-16 w-24 shrink-0 rounded-lg object-cover border border-slate-200">` : ''}
            <div class="min-w-0 flex-1">
                <p class="text-sm font-bold text-slate-900 dark:text-white">${escapeHtml(item.vehicle ? (item.vehicle.brand?.name || '') + ' ' + item.vehicle.model : 'Vehicle')} <span class="text-xs font-normal text-slate-500">(${item.vehicle?.color || ''} · ${item.quantity || 1} × ${days} day${days > 1 ? 's' : ''})</span></p>
                <div class="mt-1.5 flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-slate-500 dark:text-slate-400">
                    <span><i data-lucide="calendar" class="inline h-3 w-3"></i> ${escapeHtml(item.start_date?.split(' ')[0] || '')} → ${escapeHtml(item.end_date?.split(' ')[0] || '')}</span>
                    <span><i data-lucide="map-pin" class="inline h-3 w-3"></i> ${escapeHtml(item.pickup_location || '')} → ${escapeHtml(item.dropoff_location || '')}</span>
                </div>
                <div class="mt-1.5 text-xs flex items-center gap-1">Driver: ${driverDisplay}</div>
            </div>
        </div>`;
    }

    const vehicleItems = items.filter(i => i.vehicle_id);
    const driverOnlyItems = items.filter(i => !i.vehicle_id && (i.driver_id || i.has_driver || parseFloat(i.driver_daily_rate) > 0));

    return `
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Booking #${escapeHtml(booking.booking_number || booking.id)}</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="file-text" class="h-3 w-3"></i>
                        Manage all rental bookings
                    </p>
                </div>
                <a href="${adminUrl}/bookings" class="inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

            <!-- Customer Info -->
            <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="user" class="inline h-4 w-4 mr-1"></i> Customer</h2>
                <dl class="space-y-3">
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Name</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(user.name || 'N/A')}</dd></div>
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Email</dt><dd class="text-sm text-slate-900 dark:text-white">${escapeHtml(user.email || 'N/A')}</dd></div>
                    ${user.phone ? `<div><dt class="text-xs text-slate-500 dark:text-slate-400">Phone</dt><dd class="text-sm text-slate-900 dark:text-white">${escapeHtml(user.phone)}</dd></div>` : ''}
                </dl>
            </div>

            <!-- Booking Info -->
            <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="file-text" class="inline h-4 w-4 mr-1"></i> Booking</h2>
                <dl class="space-y-3">
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Booking No.</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(booking.booking_number || 'N/A')}</dd></div>
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Created</dt><dd class="text-sm text-slate-900 dark:text-white">${escapeHtml(booking.created_at?.split('T')[0] || booking.created_at?.split(' ')[0] || 'N/A')}</dd></div>
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Subtotal</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${money(booking.subtotal_price)}</dd></div>
                    ${booking.discount_amount ? `<div><dt class="text-xs text-slate-500 dark:text-slate-400">Discount</dt><dd class="text-sm font-medium text-emerald-600">-${money(booking.discount_amount)}</dd></div>` : ''}
                    <div class="border-t border-slate-200 pt-2 dark:border-slate-700"><dt class="text-xs text-slate-500 dark:text-slate-400">Total</dt><dd class="text-base font-black text-cyan-600 dark:text-cyan-400">${money(booking.total_price)}</dd></div>
                    <div class="border-t border-slate-200 pt-2 dark:border-slate-700">
                        <dt class="text-xs text-slate-500 dark:text-slate-400 mb-2">Status</dt>
                        <dd><select id="statusSelect" data-current-status="${booking.status}" class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium focus:border-cyan-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="confirmed" ${booking.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                            <option value="active" ${booking.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select></dd>
                    </div>
                </dl>
            </div>

            <!-- Payments Info -->
            <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="credit-card" class="inline h-4 w-4 mr-1"></i> Payment</h2>
                ${payments.length ? payments.map(p => `
                <dl class="space-y-3">
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Transaction Ref</dt><dd class="text-sm font-medium text-slate-900 dark:text-white font-mono">${escapeHtml(p.transaction_ref || 'N/A')}</dd></div>
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Method</dt><dd class="text-sm text-slate-900 dark:text-white">${escapeHtml(p.payment_method || 'N/A')}</dd></div>
                    <div><dt class="text-xs text-slate-500 dark:text-slate-400">Amount</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${money(p.amount)}</dd></div>
                    ${p.image ? `<div><dt class="text-xs text-slate-500 dark:text-slate-400">Slip</dt><dd><a href="${imgSrc(p.image)}" target="_blank"><img src="${imgSrc(p.image)}" class="mt-1 max-h-48 w-full rounded-lg border border-slate-200 object-contain bg-slate-100 dark:border-slate-700 dark:bg-slate-900"></a></dd></div>` : ''}
                </dl>
                `).join('') : '<p class="text-sm text-slate-400">No payment records</p>'}
            </div>

        </div>

        <!-- Rented Vehicles -->
        ${vehicleItems.length ? `
        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="car" class="inline h-4 w-4 mr-1"></i> Rented Vehicles (${vehicleItems.length})</h2>
            <div class="space-y-3">${vehicleItems.map(itemRow).join('')}</div>
        </div>` : ''}

        <!-- Drivers Only -->
        ${driverOnlyItems.length ? `
        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="users" class="inline h-4 w-4 mr-1"></i> Drivers (${driverOnlyItems.length})</h2>
            <div class="space-y-3">${driverOnlyItems.map(itemRow).join('')}</div>
        </div>` : ''}

        ${vehicleItems.length || driverOnlyItems.length ? `
        <div class="mt-6 flex justify-end">
            <button type="button" class="confirm-booking-btn inline-flex items-center gap-2 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-bold text-black shadow transition hover:bg-cyan-500">
                <i data-lucide="check-circle" class="h-4 w-4"></i>
                Confirm Booking
            </button>
        </div>` : ''}`;
}

function initBookingShowPage() {
    const $page = $('[data-page="admin-booking-show"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const adminUrl = $page.data('admin-url') || '/admin';
    const bookingId = window.location.pathname.split('/').pop();
    const $loading = $('#loadingState');
    const $content = $('#bookingContent');
    const $error = $('#errorState');
    const $errorMsg = $('#errorMessage');

    $content.on('click', '.confirm-booking-btn', async function () {
        const $btn = $(this);
        const newStatus = $('#statusSelect').val();
        if (newStatus === 'pending') {
            notify('Please change the status before confirming.', 'error');
            return;
        }
        $btn.prop('disabled', true).html('<span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-black border-t-transparent"></span> Processing...');
        try {
            await jsonRequest(`${apiBase}/${bookingId}`, {
                method: 'PUT',
                body: { status: newStatus },
            });
            notify('Booking confirmed with status: ' + newStatus);
            await load();
        } catch (err) {
            notify(err.message || 'Operation failed.', 'error');
            $btn.prop('disabled', false).html('<i data-lucide="check-circle" class="h-4 w-4"></i> Confirm Booking');
            refreshIcons();
        }
    });

    function toggleConfirmBtn() {
        const disabled = $('#statusSelect').val() === 'pending';
        $content.find('.confirm-booking-btn').prop('disabled', disabled).toggleClass('opacity-50 cursor-not-allowed', disabled);
    }

    $content.on('change', '#statusSelect', toggleConfirmBtn);

    async function loadDriverSelects() {
        const $selects = $content.find('.driver-select');
        if (!$selects.length) return;

        const fetches = $selects.map(function () {
            const $sel = $(this);
            const itemId = $sel.data('item-id');
            const currentDriverId = $sel.data('current');
            return jsonRequest(`${apiBase}/${bookingId}/items/${itemId}/available-drivers`)
                .then(payload => {
                    const drivers = payload?.data || [];
                    if (!drivers.length) {
                        $sel.html('<option value="">No drivers available</option>');
                        return;
                    }
                    let opts = '<option value="">Select a driver</option>';
                    drivers.forEach(d => {
                        const selected = String(d.id) === String(currentDriverId) ? ' selected' : '';
                        opts += `<option value="${d.id}"${selected}>${escapeHtml(d.name)}${d.license_number ? ' (' + escapeHtml(d.license_number) + ')' : ''}</option>`;
                    });
                    $sel.html(opts);
                })
                .catch(() => $sel.html('<option value="">Failed to load drivers</option>'));
        }).get();
        await Promise.all(fetches);
    }

    $content.on('change', '.driver-select', async function () {
        const $sel = $(this);
        const driverId = parseInt($sel.val());
        const itemId = $sel.data('item-id');
        if (!driverId || !itemId) return;

        $sel.prop('disabled', true);
        try {
            await jsonRequest(`${apiBase}/${bookingId}/items/${itemId}/assign-driver`, {
                method: 'PUT',
                body: { driver_id: driverId },
            });
            $sel.data('current', driverId);
            await loadDriverSelects();
            $content.find(`.driver-select[data-item-id="${itemId}"]`).prop('disabled', false);
        } catch (err) {
            notify(err.message || 'Failed to assign driver.', 'error');
            $sel.prop('disabled', false);
        }
    });

    async function load() {
        try {
            const payload = await jsonRequest(`${apiBase}/${bookingId}`);
            const booking = payload?.data || payload;
            if (!booking || !booking.id) throw new Error('Booking not found');

            $loading.addClass('hidden');
            $content.html(renderBooking(booking, adminUrl)).removeClass('hidden').addClass('animate-fade-in');
            refreshIcons();
            loadDriverSelects();
            toggleConfirmBtn();
        } catch (err) {
            $loading.addClass('hidden');
            $errorMsg.text(err.message);
            $error.removeClass('hidden');
        }
    }

    $page.data('initialized', true);
    load();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-booking-show"]')) initBookingShowPage();
});
