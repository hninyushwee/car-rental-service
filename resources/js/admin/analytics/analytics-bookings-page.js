import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function formatCurrency(amount) {
    return 'MMK ' + Number(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const STATUS_MAP = {
    active: 'bg-green-100 text-green-700 dark:bg-green-950 dark:text-green-400',
    confirmed: 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300',
    pending: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300',
    completed: 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
    cancelled: 'bg-red-100 text-red-700 dark:bg-red-950 dark:text-red-300',
};

function statusBadge(status) {
    const c = STATUS_MAP[status] || STATUS_MAP.pending;
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${c}">${escapeHtml(status)}</span>`;
}

function initAnalyticsBookingsPage() {
    const $page = $('[data-page="admin-analytics-bookings"]');
    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const apiUrl = $page.data('apiUrl') || '/api/admin/analytics/bookings';
    const loginUrl = $page.data('loginUrl') || '/login';

    function handleError(error, fallback) {
        if (error.status === 401 || error.status === 419) { window.location.assign(loginUrl); return; }
        notify(error.payload?.message || error.message || fallback, 'error');
    }

    function initTrendChart(trend) {
        const ctx = document.getElementById('trendChart');
        if (!ctx) return;
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: trend.map(t => t.month),
                datasets: [{
                    label: 'Bookings',
                    data: trend.map(t => t.count),
                    backgroundColor: 'rgba(6, 182, 212, 0.7)',
                    borderColor: 'rgb(6, 182, 212)',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    function initComparisonChart(typeTrend) {
        const ctx = document.getElementById('comparisonChart');
        if (!ctx) return;
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: typeTrend.map(t => t.month),
                datasets: [
                    {
                        label: 'Vehicle Only',
                        data: typeTrend.map(t => t.vehicle),
                        backgroundColor: 'rgba(251, 146, 60, 0.7)',
                        borderColor: 'rgb(251, 146, 60)',
                        borderWidth: 2,
                        borderRadius: 6,
                    },
                    {
                        label: 'Driver Only',
                        data: typeTrend.map(t => t.driver),
                        backgroundColor: 'rgba(168, 85, 247, 0.7)',
                        borderColor: 'rgb(168, 85, 247)',
                        borderWidth: 2,
                        borderRadius: 6,
                    },
                    {
                        label: 'Driver + Vehicle',
                        data: typeTrend.map(t => t.both),
                        backgroundColor: 'rgba(236, 72, 153, 0.7)',
                        borderColor: 'rgb(236, 72, 153)',
                        borderWidth: 2,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    function renderRecent(bookings) {
        const $tbody = $('#recentBookingsBody');
        if (!bookings?.length) {
            $tbody.html('<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">No bookings yet.</td></tr>');
            return;
        }
        $tbody.html(bookings.map(b => `
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(b.booking_number || '#' + b.id)}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(b.customer)}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(b.vehicle)}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${formatDate(b.start_date)}</td>
                <td class="px-6 py-4">${statusBadge(b.status)}</td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${formatCurrency(b.total_price)}</td>
            </tr>
        `).join(''));
        refreshIcons();
    }

    async function load() {
        try {
            const response = await jsonRequest(apiUrl);
            const data = response.data || response;

            $('#statTotalBookings').text(data.total_bookings ?? '--');
            $('#statActive').text(data.status_counts?.active ?? 0);
            $('#statPending').text(data.status_counts?.pending ?? 0);
            $('#statCompleted').text(data.status_counts?.completed ?? 0);
            $('#statVehicle').text(data.vehicle_only ?? 0);
            $('#statDriverOnly').text(data.driver_only ?? 0);
            $('#statDriverVehicle').text(data.driver_vehicle ?? 0);

            initTrendChart(data.trend || []);
            initComparisonChart(data.type_trend || []);
            renderRecent(data.recent_bookings);
        } catch (err) { handleError(err, 'Failed to load booking analytics.'); }
    }

    load();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initAnalyticsBookingsPage();
} else {
    window.addEventListener('DOMContentLoaded', initAnalyticsBookingsPage);
    window.addEventListener('load', initAnalyticsBookingsPage);
}
