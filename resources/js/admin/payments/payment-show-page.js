import $ from 'jquery';
import { jsonRequest } from '../common/http';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function statusBadge(status) {
    const map = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        paid: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        failed: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
        refunded: 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
    };
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${map[status] || map.pending}">${escapeHtml(status)}</span>`;
}

function renderPayment(payment, adminUrl) {
    const p = payment;
    const booking = p.payable?.id ? p.payable : null;
    const bookingItems = booking?.items || [];

    return `
        <div class="mb-4">
            <a href="${adminUrl}/payments" class="inline-flex items-center gap-1 text-sm text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Payments
            </a>
        </div>
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 dark:border-cyan-500/10 sm:px-5 sm:py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-lg font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-xl">Payment #${p.id}</h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(p.user?.name || 'Unknown')} | ${escapeHtml(p.payment_date?.split('T')[0] || p.created_at?.split('T')[0] || '')}</p>
                </div>
                <div>${statusBadge(p.status)}</div>
            </div>
        </div>
        <!-- Row 1: Payment Details | Receipt -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Payment Details</h2>
                <dl class="space-y-3">
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Amount</dt><dd class="text-sm font-bold text-cyan-600 dark:text-cyan-400">${money(p.amount)}</dd></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Method</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.payment_method || 'N/A')}</dd></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Transaction Ref</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.transaction_ref || 'N/A')}</dd></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Payment Date</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.payment_date?.split('T')[0] || p.created_at?.split('T')[0] || 'N/A')}</dd></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Created At</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.created_at?.split('T')[0] || 'N/A')}</dd></div>
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-2"></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Customer</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.user?.name || 'N/A')}</dd></div>
                    <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Email</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.user?.email || 'N/A')}</dd></div>
                    ${p.user?.phone ? `<div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Phone</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(p.user.phone)}</dd></div>` : ''}
                </dl>
            </div>
            ${p.image ? `
            <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90 flex flex-col">
                <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Payment Receipt</h2>
                <a href="${p.image.startsWith('http') ? p.image : '/storage/' + p.image}" target="_blank" class="flex flex-1 items-center">
                    <img src="${p.image.startsWith('http') ? p.image : '/storage/' + p.image}" alt="Receipt" class="max-h-72 w-full rounded-lg object-contain border border-slate-200 dark:border-slate-700">
                </a>
            </div>` : ''}
        </div>
        ${booking ? `
        <!-- Row 2: Balance Summary -->
        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400"><i data-lucide="wallet" class="inline h-4 w-4 mr-1"></i> Balance Summary</h2>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Subtotal Price</span>
                    <span class="font-semibold text-slate-900 dark:text-white">${money(booking.subtotal_price || 0)}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Promotion</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">- ${money(booking.discount_amount || 0)}</span>
                </div>
                <div class="flex justify-between border-t border-slate-200 dark:border-slate-700 pt-2 mt-2">
                    <span class="font-medium text-slate-700 dark:text-slate-300">Total Booking Price</span>
                    <span class="font-bold text-slate-900 dark:text-white">${money(booking.total_price || 0)}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500 dark:text-slate-400">Total Paid</span>
                    <span class="font-semibold text-emerald-600 dark:text-emerald-400">${money((booking.payments || []).reduce((s, p) => s + Number(p.amount || 0), 0))}</span>
                </div>
                <div class="flex justify-between border-t border-slate-200 dark:border-slate-700 pt-2 mt-2">
                    <span class="font-medium text-slate-700 dark:text-slate-300">Remaining Balance</span>
                    <span class="font-bold text-lg ${(booking.total_price || 0) - (booking.payments || []).reduce((s, p) => s + Number(p.amount || 0), 0) > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400'}">${money(Math.max(0, (booking.total_price || 0) - (booking.payments || []).reduce((s, p) => s + Number(p.amount || 0), 0)))}</span>
                </div>
            </div>
        </div>
        <!-- Row 3: Related Booking -->
        <div class="mt-6 rounded-2xl border border-slate-200/60 bg-white/90 p-5 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Related Booking #${booking.id}</h2>
            <div class="mb-3 flex flex-wrap gap-4 text-sm">
                <span class="text-slate-500 dark:text-slate-400">Status: ${statusBadge(booking.status)}</span>
                <span class="text-slate-500 dark:text-slate-400">Items: ${bookingItems.length}</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="px-3 py-2 font-medium text-slate-500 dark:text-slate-400">Vehicle</th>
                            <th class="px-3 py-2 font-medium text-slate-500 dark:text-slate-400">Pickup</th>
                            <th class="px-3 py-2 font-medium text-slate-500 dark:text-slate-400">Dropoff</th>
                            <th class="px-3 py-2 font-medium text-slate-500 dark:text-slate-400">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${bookingItems.map(item => `
                        <tr class="border-b border-slate-100 dark:border-slate-700/50">
                            <td class="px-3 py-2 font-medium text-slate-900 dark:text-white">${escapeHtml(item.vehicle ? (item.vehicle.brand?.name || '') + ' ' + item.vehicle.model : 'N/A')}</td>
                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">${escapeHtml(item.start_date?.split('T')[0] || '')}</td>
                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">${escapeHtml(item.end_date?.split('T')[0] || '')}</td>
                            <td class="px-3 py-2 text-slate-600 dark:text-slate-300">${item.quantity || 1}</td>
                        </tr>`).join('')}
                    </tbody>
                </table>
            </div>
        </div>` : ''}
        `;
}

function initPaymentShowPage() {
    const $page = $('[data-page="admin-payment-show"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const adminUrl = $page.data('admin-url') || '/admin';
    const paymentId = window.location.pathname.split('/').pop();
    const $loading = $('#loadingState');
    const $content = $('#paymentContent');
    const $error = $('#errorState');
    const $errorMsg = $('#errorMessage');

    async function load() {
        try {
            const payload = await jsonRequest(`${apiBase}/${paymentId}`);
            const payment = payload?.data || payload;
            if (!payment || !payment.id) throw new Error('Payment not found');
            $loading.addClass('hidden');
            $content.html(renderPayment(payment, adminUrl)).removeClass('hidden');
            refreshIcons();
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
    if (document.querySelector('[data-page="admin-payment-show"]')) initPaymentShowPage();
});
