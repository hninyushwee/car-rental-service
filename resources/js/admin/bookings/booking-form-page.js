import $ from 'jquery';
import { jsonRequest } from '../common/http';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function initBookingFormPage() {
    const $page = $('[data-page="admin-booking-form"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const adminUrl = $page.data('admin-url') || '/admin';
    const bookingId = $page.data('booking-id');
    const isEdit = $page.data('is-edit');
    const $container = $('#formContainer');

    async function loadForm() {
        let booking = {};
        if (isEdit && bookingId) {
            try {
                const payload = await jsonRequest(`${apiBase}/${bookingId}`);
                booking = payload?.data || payload;
            } catch {
                $container.html('<p class="text-center text-red-500">Failed to load booking data.</p>');
                return;
            }
        }

        const firstItem = Array.isArray(booking.items) ? booking.items[0] : null;
        $container.html(`
            <form id="bookingForm" class="space-y-6">
                ${!isEdit ? `
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">User ID</label>
                        <input type="number" name="user_id" value="${booking.user_id || ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                        <select name="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Pending</option>
                            <option value="confirmed" ${booking.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                            <option value="active" ${booking.status === 'active' ? 'selected' : ''}>Active</option>
                            <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Completed</option>
                            <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Pickup Date</label>
                        <input type="datetime-local" name="pickup_date" value="${booking.pickup_date ? booking.pickup_date.substring(0, 16) : ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Return Date</label>
                        <input type="datetime-local" name="return_date" value="${booking.return_date ? booking.return_date.substring(0, 16) : ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Pickup Location</label>
                        <input type="text" name="pickup_location" value="${booking.pickup_location || ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Return Location</label>
                        <input type="text" name="return_location" value="${booking.return_location || ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Total Amount</label>
                        <input type="number" step="0.01" name="total_amount" value="${booking.total_amount || ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Deposit Amount</label>
                        <input type="number" step="0.01" name="deposit_amount" value="${booking.deposit_amount || ''}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>
                ` : `
                <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-5 dark:border-slate-700/60 dark:bg-slate-800/90">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Booking #${escapeHtml(booking.id)}</h2>
                    <dl class="space-y-3">
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Customer</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(booking.user?.name || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Booking No.</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(booking.booking_number || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Pickup</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(firstItem?.start_date?.split(' ')[0] || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Return</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(firstItem?.end_date?.split(' ')[0] || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Pickup Location</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(firstItem?.pickup_location || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Dropoff Location</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${escapeHtml(firstItem?.dropoff_location || 'N/A')}</dd></div>
                        <div class="flex justify-between"><dt class="text-sm text-slate-500 dark:text-slate-400">Total</dt><dd class="text-sm font-medium text-slate-900 dark:text-white">${money(booking.total_price)}</dd></div>
                        <div class="flex justify-between border-t border-slate-200 pt-3 dark:border-slate-700">
                            <dt class="text-sm font-semibold text-slate-900 dark:text-white">Status</dt>
                            <dd>
                                <select name="status" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium focus:border-cyan-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                    <option value="pending" ${booking.status === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="confirmed" ${booking.status === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                    <option value="active" ${booking.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="completed" ${booking.status === 'completed' ? 'selected' : ''}>Completed</option>
                                    <option value="cancelled" ${booking.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                </select>
                            </dd>
                        </div>
                    </dl>
                </div>
                `}
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-cyan-400 px-6 py-2.5 text-sm font-medium text-black transition hover:bg-cyan-500">
                        ${isEdit ? 'Update Status' : 'Create Booking'}
                    </button>
                    <a href="${adminUrl}/bookings" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</a>
                </div>
            </form>
            <div id="formError" class="mt-4 hidden rounded-lg bg-red-500/10 p-3 text-sm text-red-600 dark:text-red-400"></div>
        `);

        $('#bookingForm').on('submit', async function (e) {
            e.preventDefault();
            const $error = $('#formError').addClass('hidden');
            const data = Object.fromEntries(new FormData(this).entries());
            try {
                if (isEdit) {
                    await jsonRequest(`${apiBase}/${bookingId}`, { method: 'PUT', body: { status: data.status } });
                } else {
                    await jsonRequest(apiBase, { method: 'POST', body: data });
                }
                window.location.href = adminUrl + '/bookings';
            } catch (err) {
                $error.text(err.payload?.message || err.message).removeClass('hidden');
            }
        });
    }

    $page.data('initialized', true);
    loadForm();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-booking-form"]')) initBookingFormPage();
});
