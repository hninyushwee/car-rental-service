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

function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function statusBadge(status) {
    const map = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        confirmed: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        active: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        completed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        cancelled: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    };
    return `<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ${map[status] || map.pending}">${escapeHtml(status)}</span>`;
}

function initCustomerShowPage() {
    const $page = $('[data-page="admin-customer-show"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const customerId = $page.data('id');
    const apiBase = $page.data('apiBase') || '/api/admin/users';
    const loginUrl = $page.data('loginUrl') || '/login';

    function showLoadError(error) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }

        $('#loadingState').html(`
            <div class="p-6 text-center text-red-500">
                <i data-lucide="alert-circle" class="mx-auto mb-2 h-10 w-10"></i>
                <p class="font-bold">Failed to load customer details.</p>
            </div>
        `);
        notify(error.payload?.message || 'Failed to load customer details.', 'error');
        refreshIcons();
    }

    function renderCustomer(user) {
        $('#customerName').text(escapeHtml(user.name));
        $('#customerEmail').text(escapeHtml(user.email));

        const infoRows = [
            ['Name', user.name],
            ['Email', user.email],
            ['Phone', user.phone || 'N/A'],
            ['Joined', formatDate(user.created_at)],
        ];

        $('#infoContainer').html(infoRows.map(([label, value]) => `
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                <span class="text-sm text-slate-500 dark:text-slate-400">${escapeHtml(label)}</span>
                <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(String(value))}</span>
            </div>
        `).join(''));

        $('#activityBookings').text(user.bookings_count ?? 0);
        $('#activityPayments').text(user.payments_count ?? 0);
        $('#activityInquiries').text(user.inquiries_count ?? 0);

        // Recent bookings
        const bookings = user.bookings || [];
        if (bookings.length) {
            const html = bookings.map(b => {
                const firstItem = b.items?.[0];
                const vehicle = firstItem?.vehicle;
                const vehicleName = vehicle ? `${vehicle.brand?.name || ''} ${vehicle.model}`.trim() : 'N/A';
                return `<div class="rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(b.booking_number || '#' + b.id)}</span>
                        ${statusBadge(b.status)}
                    </div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        ${escapeHtml(vehicleName)} · ${formatDate(firstItem?.start_date)}
                    </div>
                </div>`;
            }).join('');
            $('.xl\\:col-span-2').append(`
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Recent Bookings</h3>
                    <div class="space-y-3">${html}</div>
                </div>
            `);
        }

        $('#loadingState').addClass('hidden');
        $('#detailsContent').removeClass('hidden');
        refreshIcons();
    }

    async function loadCustomer() {
        try {
            const response = await jsonRequest(`${apiBase}/${customerId}`);
            renderCustomer(response.data || response.user || response);
        } catch (error) {
            showLoadError(error);
        }
    }

    loadCustomer();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initCustomerShowPage();
} else {
    window.addEventListener('DOMContentLoaded', initCustomerShowPage);
    window.addEventListener('load', initCustomerShowPage);
}
