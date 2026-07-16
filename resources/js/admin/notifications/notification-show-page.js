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
    return d.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function renderNotification(notif) {
    const isUnread = notif.is_read === false || notif.is_read === 0;

    let linkedSection = '';
    if (notif.notifiable_type === 'App\Models\Inquiry' && notif.inquiry) {
        const inq = notif.inquiry;
        linkedSection = `
            <div class="rounded-xl border border-blue-500/20 bg-blue-500/5 p-4">
                <h3 class="mb-3 text-sm font-semibold text-slate-800 dark:text-slate-200">
                    <i data-lucide="message-circle" class="mr-1 inline-block h-4 w-4"></i> Related Inquiry
                </h3>
                <div class="mb-3 grid gap-2 text-sm sm:grid-cols-2">
                    <div><span class="text-slate-500 dark:text-slate-400">Subject:</span> <span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(inq.subject)}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Status:</span> ${statusBadge(inq.status)}</div>
                    <div><span class="text-slate-500 dark:text-slate-400">From:</span> <span class="text-slate-800 dark:text-slate-200">${escapeHtml(inq.user?.name || 'Unknown')}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Date:</span> <span class="text-slate-800 dark:text-slate-200">${formatDate(inq.created_at)}</span></div>
                </div>
                <div class="mb-3">
                    <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Message:</span>
                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">${escapeHtml(inq.message)}</p>
                </div>
                ${inq.admin_response ? `
                <div class="mb-3 rounded-lg border border-emerald-500/20 bg-emerald-500/5 p-3">
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">Admin Response:</span>
                    <p class="mt-1 text-sm text-slate-700 dark:text-slate-300">${escapeHtml(inq.admin_response)}</p>
                </div>` : ''}
                ${inq.status !== 'resolved' ? `
                <div class="mt-4 border-t border-slate-200 pt-4 dark:border-slate-700">
                    <label class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Reply to Inquiry</label>
                    <textarea id="inquiryReplyInput" rows="3" class="mb-2 w-full rounded-lg border border-slate-300 bg-white p-2.5 text-sm transition-all focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500" placeholder="Write your reply..."></textarea>
                    <div class="flex items-center gap-2">
                        <button type="button" id="sendReplyBtn" data-inquiry-id="${inq.id}" class="rounded-lg bg-cyan-400 px-4 py-2 text-xs font-medium text-black hover:bg-cyan-500">Send Reply</button>
                        <span id="replySending" class="hidden text-xs text-slate-400">Sending...</span>
                    </div>
                </div>` : ''}
            </div>`;
    }

    const typeColors = {
        booking: 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
        payment: 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
        promotion: 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
        system: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
        inquiry: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    };

    return `
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">${escapeHtml(notif.title)}</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="bell" class="h-3 w-3"></i>
                        <span>${formatDate(notif.created_at)}</span>
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-xs font-medium ${typeColors[notif.type] || typeColors.system}">
                        ${escapeHtml(notif.type)}
                    </span>
                    <a href="${$('[data-page="admin-notification-show"]').data('notificationsUrl') || '/admin/notifications'}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        <i data-lucide="arrow-left" class="h-3 w-3"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>
        <div class="grid gap-5 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="rounded-xl border border-slate-200/60 bg-white/90 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                    <h2 class="mb-3 text-sm font-semibold text-slate-800 dark:text-slate-200"><i data-lucide="info" class="mr-1 inline-block h-4 w-4"></i> Details</h2>
                    <div class="grid gap-3 text-sm sm:grid-cols-2">
                        <div><span class="text-slate-500 dark:text-slate-400">Type:</span> <span class="font-medium text-slate-800 dark:text-slate-200">${escapeHtml(notif.type)}</span></div>
                        <div><span class="text-slate-500 dark:text-slate-400">Status:</span>
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-0.5 text-xs font-medium ${isUnread ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'}">
                                <span class="inline-block h-1.5 w-1.5 rounded-full ${isUnread ? 'bg-amber-500' : 'bg-emerald-500'}"></span>
                                ${isUnread ? 'Unread' : 'Read'}
                            </span>
                        </div>
                    </div>
                </div>
                ${linkedSection}
            </div>
        </div>`;
}

function statusBadge(status) {
    const map = {
        open: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        resolved: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        closed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
    };
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${map[status] || map.open}">${escapeHtml(status)}</span>`;
}

function initNotificationShowPage() {
    const $page = $('[data-page="admin-notification-show"]');
    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const apiBase = $page.data('apiBase');
    const notificationId = $page.data('notification-id');
    const $content = $('#notificationContent');
    const $loading = $('#loadingState');
    const $error = $('#errorState');
    const $errorMsg = $('#errorMessage');

    async function loadNotification() {
        $loading.show();
        $content.hide();
        $error.hide();

        try {
            const result = await jsonRequest(`${apiBase}/${notificationId}`);
            $content.html(renderNotification(result.data));
            $loading.hide();
            $content.show();
            refreshIcons();
            attachEvents();
        } catch (err) {
            $loading.hide();
            $error.show();
            $errorMsg.text(err.payload?.message || 'Failed to load notification.');
        }
    }

    function attachEvents() {
        const $sendBtn = $('#sendReplyBtn');
        if (!$sendBtn.length) return;

        $sendBtn.on('click', async function () {
            const inquiryId = $(this).data('inquiry-id');
            const $input = $('#inquiryReplyInput');
            const reply = $input.val().trim();
            if (!reply) { notify('Please write a reply.', 'error'); return; }

            const $sending = $('#replySending').removeClass('hidden');
            $(this).prop('disabled', true);

            try {
                await jsonRequest(`/api/admin/inquiries/${inquiryId}`, {
                    method: 'PUT',
                    body: {
                        admin_response: reply,
                        status: 'open',
                    },
                });
                notify('Reply sent successfully.', 'success');
                $input.val('');
                loadNotification();
            } catch (err) {
                notify(err.payload?.message || 'Failed to send reply.', 'error');
            } finally {
                $sending.addClass('hidden');
                $sendBtn.prop('disabled', false);
            }
        });
    }

    loadNotification();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initNotificationShowPage();
} else {
    window.addEventListener('DOMContentLoaded', initNotificationShowPage);
    window.addEventListener('load', initNotificationShowPage);
}
