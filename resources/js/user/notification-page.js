import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function timeAgo(dateStr) {
    const now = new Date();
    const date = new Date(dateStr);
    const diff = Math.floor((now - date) / 1000);
    if (diff < 60) return 'just now';
    if (diff < 3600) return `${Math.floor(diff / 60)}m ago`;
    if (diff < 86400) return `${Math.floor(diff / 3600)}h ago`;
    return date.toLocaleDateString();
}

function initNotificationPage() {
    const $page = $('[data-page="user-notifications"]');
    if (!$page.length || $page.data('initialized')) return;

    const $list = $('#notificationsList');
    const $count = $('#notificationCount');
    const $unreadCount = $('#unreadCount');

    async function load() {
        try {
            const payload = await jsonRequest('/api/user/notifications');
            const data = payload?.data?.data || payload?.data || [];
            const total = payload?.data?.total || data.length;
            $count.text(total);
            $unreadCount.text(data.filter(n => !n.is_read).length);

            if (!Array.isArray(data) || !data.length) {
                $list.html('<div class="col-span-full py-16 text-center"><i data-lucide="bell-off" class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-600"></i><p class="mt-4 text-sm text-slate-400">No notifications yet.</p></div>');
                window.initLucideIcons?.();
                return;
            }

            $list.html(data.map(n => {
                const isUnread = !n.is_read;
                const typeIcons = {
                    booking: 'calendar',
                    payment: 'credit-card',
                    inquiry: 'message-circle',
                    promotion: 'tag',
                    system: 'bell',
                };
                const icon = typeIcons[n.type] || 'bell';
                return `<div class="rounded-xl border ${isUnread ? 'border-cyan-200 bg-cyan-50 dark:border-cyan-800 dark:bg-cyan-950/30' : 'border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800'} p-4 shadow-sm transition hover:shadow-md ${isUnread ? 'cursor-pointer' : ''}" data-id="${n.id}" data-read="${n.is_read ? '1' : '0'}">
                    <div class="flex items-start gap-3">
                        <div class="rounded-lg ${isUnread ? 'bg-cyan-500/10 text-cyan-600' : 'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400'} p-2">
                            <i data-lucide="${icon}" class="h-5 w-5"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-sm font-semibold ${isUnread ? 'text-slate-900 dark:text-white' : 'text-slate-700 dark:text-slate-300'}">${n.title}</p>
                                <span class="shrink-0 text-xs text-slate-400">${timeAgo(n.created_at)}</span>
                            </div>
                            <p class="mt-0.5 text-sm text-slate-500 dark:text-slate-400">${n.message}</p>
                        </div>
                        ${isUnread ? '<span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-cyan-500"></span>' : ''}
                    </div>
                </div>`;
            }).join(''));
            window.initLucideIcons?.();

            $list.on('click', '.cursor-pointer', async function () {
                const id = $(this).data('id');
                if ($(this).data('read')) return;
                try {
                    await jsonRequest(`/api/user/notifications/${id}/read`, { method: 'PUT' });
                    $(this).removeClass('border-cyan-200 bg-cyan-50 dark:border-cyan-800 dark:bg-cyan-950/30 cursor-pointer')
                        .addClass('border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800');
                    const $dot = $(this).find('.h-2\\.w-2');
                    if ($dot.length) $dot.remove();
                    const $iconBox = $(this).find('.rounded-lg:first');
                    $iconBox.removeClass('bg-cyan-500/10 text-cyan-600').addClass('bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400');
                    $(this).find('p:first').removeClass('text-slate-900 dark:text-white').addClass('text-slate-700 dark:text-slate-300');
                    $unreadCount.text(parseInt($unreadCount.text() || '0') - 1);
                    if (window.fetchUnreadCount) window.fetchUnreadCount();
                } catch {}
            });
        } catch {
            $list.html('<div class="col-span-full py-16 text-center text-red-400"><p>Failed to load notifications.</p></div>');
        }
    }

    $page.data('initialized', true);
    load();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="user-notifications"]')) initNotificationPage();
});
