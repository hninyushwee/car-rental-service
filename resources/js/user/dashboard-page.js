import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function initUserDashboard() {
    const $page = $('[data-page="user-dashboard"]');
    if (!$page.length || $page.data('initialized')) return;

    const $statsGrid = $('#statsGrid');
    const $promoContainer = $('#promoContainer');
    const $upcomingContainer = $('#upcomingContainer');
    const $upcomingEmpty = $('#upcomingEmpty');
    const $txnBody = $('#txnBody');
    const $toast = $('#copyToast');
    const $totalSpent = $('#totalSpent');

    function showCopyToast(message) {
        $toast.html(`<div class="flex items-center gap-2"><span>✨</span> ${message}</div>`);
        $toast.removeClass('hidden');
        setTimeout(() => $toast.addClass('hidden'), 2500);
    }

    function formatDate(d) {
        if (!d) return 'N/A';
        return d.split('T')[0].split(' ')[0] || 'N/A';
    }

    const STATUS_COLORS = {
        pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        confirmed: 'bg-green-100 text-green-800 border-green-200',
        active: 'bg-blue-100 text-blue-800 border-blue-200',
        completed: 'bg-slate-100 text-slate-800 border-slate-200',
        cancelled: 'bg-red-100 text-red-800 border-red-200',
    };

    async function loadDashboard() {
        try {
            const payload = await jsonRequest('/api/user/dashboard');
            const d = payload?.data || payload;
            if (!d) return;

            const stats = d.stats || {};
            const bookings = d.recent_bookings || [];
            const upcoming = d.upcoming_bookings || [];
            const promotions = d.active_promotions || [];
            const transactions = d.recent_transactions || [];
            const unreadNotifs = d.unread_notifications || 0;
            const totalSpent = d.total_spent || 0;

            $totalSpent.text(money(totalSpent));

            // Stats
            $statsGrid.html(`
                <div class="stat-card fade-up visible">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Bookings</p>
                            <p class="text-3xl font-black text-slate-950 mt-2">${stats.total || 0}</p>
                            <p class="text-xs text-emerald-600 font-medium mt-1">${stats.active || 0} active now</p>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-100">
                            <i data-lucide="calendar" class="h-7 w-7"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card fade-up visible">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Completed</p>
                            <p class="text-3xl font-black text-slate-950 mt-2">${stats.completed || 0}</p>
                            <p class="text-xs text-slate-500 font-medium mt-1">${stats.cancelled || 0} cancelled</p>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                            <i data-lucide="check-circle" class="h-7 w-7"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card fade-up visible">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Spent</p>
                            <p class="text-3xl font-black text-slate-950 mt-2">${money(totalSpent)}</p>
                            <p class="text-xs text-purple-600 font-medium mt-1">All time</p>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 border border-purple-100">
                            <i data-lucide="wallet" class="h-7 w-7"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card fade-up visible">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Notifications</p>
                            <p class="text-3xl font-black text-slate-950 mt-2">${unreadNotifs}</p>
                            <p class="text-xs text-amber-600 font-medium mt-1">Unread</p>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
                            <i data-lucide="bell" class="h-7 w-7"></i>
                        </div>
                    </div>
                </div>
            `);

            // Promotions
            if (promotions.length) {
                $promoContainer.html(promotions.map(p => {
                    const discountLabel = p.discount_type === 'percentage' ? `${p.discount_value}%` : money(p.discount_value);
                    return `<div class="booking-card">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">${p.code}</h3>
                                <p class="text-xs text-slate-500 mt-0.5">${p.description || ''}</p>
                            </div>
                            <span class="rounded-full bg-cyan-100 px-2.5 py-1 text-xs font-bold text-cyan-700 shrink-0">${discountLabel}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[10px] text-slate-400">Expires ${formatDate(p.end_date)}</span>
                            <button class="copy-code-btn rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition" data-code="${p.code}">
                                <i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy
                            </button>
                        </div>
                    </div>`;
                }).join(''));
            } else {
                $promoContainer.html(`<div class="booking-card text-center py-6"><p class="text-sm text-slate-400">No active promotions right now.</p></div>`);
            }

            // Upcoming bookings
            if (upcoming.length) {
                $upcomingEmpty.addClass('hidden');
                $upcomingContainer.html(upcoming.slice(0, 3).map(b => {
                    const item = b.items?.[0] || {};
                    const isVehicle = !!item.vehicle;
                    const name = isVehicle
                        ? [item.vehicle?.brand?.name, item.vehicle?.model].filter(Boolean).join(' ')
                        : (item.driver?.name || 'Service');
                    const icon = isVehicle ? 'car' : 'user-check';
                    const iconColor = isVehicle ? 'text-cyan-600' : 'text-emerald-600';
                    const dateLabel = b.start_date ? formatDate(b.start_date) : 'N/A';
                    const price = b.total_price ? money(b.total_price) : '';
                    return `<div class="booking-card">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 border border-slate-200">
                                    <i data-lucide="${icon}" class="h-5 w-5 ${iconColor}"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-sm text-slate-900">${name}</p>
                                    <p class="text-xs text-slate-500 mt-0.5">${dateLabel}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold border ${STATUS_COLORS[b.status] || 'bg-slate-50 text-slate-700 border-slate-200'}">${b.status}</span>
                                ${price ? `<p class="text-sm font-bold text-slate-900 mt-1">${price}</p>` : ''}
                            </div>
                        </div>
                    </div>`;
                }).join(''));
            } else {
                $upcomingEmpty.removeClass('hidden');
            }

            // Transactions
            if (transactions.length) {
                $txnBody.html(transactions.map(t => {
                    const statusLabels = { confirmed: 'Success', pending: 'Pending', failed: 'Failed', refunded: 'Refunded' };
                    const statusColors = {
                        confirmed: 'bg-emerald-50 text-emerald-700 border-emerald-200',
                        pending: 'bg-amber-50 text-amber-700 border-amber-200',
                        failed: 'bg-red-50 text-red-700 border-red-200',
                        refunded: 'bg-slate-50 text-slate-700 border-slate-200',
                    };
                    const label = statusLabels[t.status] || t.status;
                    const color = statusColors[t.status] || 'bg-slate-50 text-slate-700 border-slate-200';
                    return `<tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-mono font-bold text-slate-900">#${t.id}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 capitalize">${t.payment_method || 'N/A'}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">${formatDate(t.payment_date || t.created_at)}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-slate-900">${money(t.amount)}</td>
                        <td class="whitespace-nowrap px-6 py-4"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold tracking-wide border ${color}">${label}</span></td>
                    </tr>`;
                }).join(''));
            } else {
                $txnBody.html(`<tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">No transactions yet.</td></tr>`);
            }

            if (window.lucide) lucide.createIcons();
            initCopyButtons();
        } catch (e) {
            console.error('Dashboard API error:', e);
            $statsGrid.html(`<div class="col-span-full text-center py-12 text-sm text-red-400">${e.message || 'Failed to load dashboard data.'}</div>`);
        }
    }

    function initCopyButtons() {
        document.querySelectorAll('.copy-code-btn').forEach(btn => {
            btn.addEventListener('click', async () => {
                const code = btn.dataset.code;
                try {
                    await navigator.clipboard.writeText(code);
                    btn.innerHTML = '<i data-lucide="check" class="h-3 w-3 inline mr-1"></i>Copied!';
                    btn.classList.add('copied');
                    if (window.lucide) lucide.createIcons();
                    setTimeout(() => {
                        btn.innerHTML = '<i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy';
                        btn.classList.remove('copied');
                        if (window.lucide) lucide.createIcons();
                    }, 1500);
                    showCopyToast(`Code <strong>${code}</strong> copied!`);
                } catch {
                    showCopyToast('Failed to copy code.');
                }
            });
        });
    }

    loadDashboard();
    $page.data('initialized', true);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="user-dashboard"]')) initUserDashboard();
});
