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

function initAnalyticsCustomersPage() {
    const $page = $('[data-page="admin-analytics-customers"]');
    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const apiUrl = $page.data('apiUrl') || '/api/admin/analytics/customers';
    const loginUrl = $page.data('loginUrl') || '/login';

    function handleError(error, fallback) {
        if (error.status === 401 || error.status === 419) { window.location.assign(loginUrl); return; }
        notify(error.payload?.message || error.message || fallback, 'error');
    }

    function initTrendChart(trend) {
        const ctx = document.getElementById('trendChart');
        if (!ctx) return;
        new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: trend.map(t => t.month),
                datasets: [{
                    label: 'New Customers',
                    data: trend.map(t => t.count),
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointRadius: 5,
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

    function renderRecent(customers) {
        const $tbody = $('#recentCustomersBody');
        if (!customers?.length) {
            $tbody.html('<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500">No customers yet.</td></tr>');
            return;
        }
        $tbody.html(customers.map(c => `
            <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(c.name)}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(c.email)}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(c.phone || 'N/A')}</td>
                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">${formatDate(c.joined)}</td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${c.bookings_count ?? 0}</td>
                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">${c.inquiries_count ?? 0}</td>
            </tr>
        `).join(''));
        refreshIcons();
    }

    async function load() {
        try {
            const response = await jsonRequest(apiUrl);
            const data = response.data || response;

            $('#statTotal').text(data.total_customers ?? '--');
            $('#statInquiries').text(data.total_inquiries ?? '--');
            const thisMonth = data.trend?.length ? data.trend[data.trend.length - 1].count : 0;
            $('#statMonth').text(thisMonth);

            initTrendChart(data.trend || []);
            renderRecent(data.recent_customers);
        } catch (err) { handleError(err, 'Failed to load customer analytics.'); }
    }

    load();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initAnalyticsCustomersPage();
} else {
    window.addEventListener('DOMContentLoaded', initAnalyticsCustomersPage);
    window.addEventListener('load', initAnalyticsCustomersPage);
}
