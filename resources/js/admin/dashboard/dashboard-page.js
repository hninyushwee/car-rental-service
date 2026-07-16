import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

const STATUS_COLORS = {
    active: { bg: 'bg-green-100 dark:bg-green-950', text: 'text-green-700 dark:text-green-300', dot: 'bg-green-600 dark:bg-green-400' },
    confirmed: { bg: 'bg-cyan-100 dark:bg-cyan-950', text: 'text-cyan-700 dark:text-cyan-300', dot: 'bg-cyan-600 dark:bg-cyan-400' },
    pending: { bg: 'bg-yellow-100 dark:bg-yellow-950', text: 'text-yellow-700 dark:text-yellow-300', dot: 'bg-yellow-600 dark:bg-yellow-400' },
    completed: { bg: 'bg-slate-100 dark:bg-slate-700', text: 'text-slate-700 dark:text-slate-300', dot: 'bg-slate-600 dark:bg-slate-400' },
    cancelled: { bg: 'bg-red-100 dark:bg-red-950', text: 'text-red-700 dark:text-red-300', dot: 'bg-red-600 dark:bg-red-400' },
};

function statusBadge(status) {
    const c = STATUS_COLORS[status] || STATUS_COLORS.pending;
    const label = status.charAt(0).toUpperCase() + status.slice(1);
    return `<span class="inline-flex items-center gap-1.5 rounded-full ${c.bg} px-3 py-1 text-xs font-medium ${c.text}">
        <span class="h-2 w-2 rounded-full ${c.dot}"></span>${label}
    </span>`;
}

function formatDate(dateStr) {
    if (!dateStr) return 'N/A';
    const d = new Date(dateStr);
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
}

function formatCurrency(amount) {
    return Number(amount || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function initDashboardPage() {
    const $page = $('[data-page="admin-dashboard"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const apiUrl = $page.data('apiUrl') || '/api/admin/dashboard';
    const loginUrl = $page.data('loginUrl') || '/login';
    const adminUrl = $page.data('adminUrl') || '/admin';

    function handleApiError(error, fallback) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }
        const message = error.payload?.message || error.message || fallback;
        const text = typeof message === 'string' && message.trim().startsWith('<!DOCTYPE')
            ? `${fallback} Server returned HTTP ${error.status || 500}.`
            : (message || fallback);
        notify(text, 'error');
    }

    function updateStats(stats) {
        $('#statVehicles').text(stats.total_vehicles ?? '--');
        $('#statDrivers').text(stats.total_drivers ?? '--');
        $('#statActiveBookings').text(stats.active_bookings ?? '--');
        $('#statRevenue').html('<span class="text-sm font-medium text-slate-500 dark:text-slate-400">MMK </span>' + formatCurrency(stats.monthly_revenue));
    }

    function initRevenueChart(trend) {
        const ctx = document.getElementById('revenueChart');
        if (!ctx) return;
        const labels = trend.map(t => t.month);
        const data = trend.map(t => t.revenue);
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Revenue',
                    data,
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (v) {
                                return 'MMK ' + v.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    function initStatusChart(counts) {
        const ctx = document.getElementById('bookingStatusChart');
        if (!ctx) return;
        const order = ['active', 'confirmed', 'pending', 'completed', 'cancelled'];
        const labels = order.map(s => s.charAt(0).toUpperCase() + s.slice(1));
        const data = order.map(s => counts[s] || 0);
        const colors = {
            active: 'rgb(34, 197, 94)',
            confirmed: 'rgb(6, 182, 212)',
            pending: 'rgb(245, 158, 11)',
            completed: 'rgb(107, 114, 128)',
            cancelled: 'rgb(239, 68, 68)',
        };
        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: order.map(s => colors[s]),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    function initUtilizationChart(utilData) {
        const ctx = document.getElementById('utilizationChart');
        if (!ctx) return;
        const labels = utilData.map(v => v.model);
        const data = utilData.map(v => v.booking_count);
        const colors = [
            'rgba(6, 182, 212, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(168, 85, 247, 0.8)',
            'rgba(34, 197, 94, 0.8)',
            'rgba(245, 158, 11, 0.8)'
        ];
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Bookings',
                    data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        ticks: { beginAtZero: true }
                    }
                }
            }
        });
    }

    function renderLicenseTypeChart(types) {
        const ctx = document.getElementById('licenseTypeChart');
        if (!ctx) return;
        if (!types || !types.length) {
            document.getElementById('licenseTypeContainer')?.querySelector('.chart-container')?.replaceWith?.('<p class="text-sm text-slate-500 dark:text-slate-400">No license types found.</p>');
            return;
        }
        const labels = types.map(t => t.type);
        const data = types.map(t => t.driver_count);
        const colors = [
            'rgb(6, 182, 212)',
            'rgb(59, 130, 246)',
            'rgb(168, 85, 247)',
            'rgb(34, 197, 94)',
            'rgb(245, 158, 11)',
            'rgb(239, 68, 68)',
        ];
        new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels,
                datasets: [{
                    data,
                    backgroundColor: colors.slice(0, labels.length),
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    function renderRecentBookings(bookings) {
        const $tbody = $('#recentBookingsBody');
        if (!bookings || !bookings.length) {
            $tbody.html('<tr><td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No bookings yet.</td></tr>');
            return;
        }
        $tbody.html(bookings.map(b => `
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${b.booking_number || '#' + b.id}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${b.customer || 'N/A'}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${b.vehicle || 'N/A'}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${formatDate(b.start_date)}</td>
                <td class="px-6 py-4 text-sm">${statusBadge(b.status)}</td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${formatCurrency(b.total_price)}</td>
                <td class="px-6 py-4 text-sm">
                    <div class="flex items-center gap-2">
                        <a href="${adminUrl}/bookings/${b.id}" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                            <i data-lucide="eye" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                        </a>
                    </div>
                </td>
            </tr>
        `).join(''));
        window.initLucideIcons?.();
    }

    async function loadDashboard() {
        try {
            const response = await jsonRequest(apiUrl);
            const data = response.data || response;

            updateStats(data.stats);
            initRevenueChart(data.revenue_trend || []);
            initStatusChart(data.status_counts || {});
            initUtilizationChart(data.top_vehicles || []);
            renderLicenseTypeChart(data.driving_license_types || []);
            renderRecentBookings(data.recent_bookings);
        } catch (error) {
            handleApiError(error, 'Failed to load dashboard data.');
        }
    }

    loadDashboard();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initDashboardPage();
} else {
    window.addEventListener('DOMContentLoaded', initDashboardPage);
    window.addEventListener('load', initDashboardPage);
}
