import $ from 'jquery';

function initAdminSearch() {
    const $wrapper = $('#adminSearchWrapper');
    const $input = $('#adminSearchInput');
    const $results = $('#adminSearchResults');

    if (!$wrapper.length || !$input.length) return;

    const pages = $wrapper.data('pages') || [];

    function renderResults(query) {
        if (!query || query.length < 2) {
            $results.addClass('hidden').empty();
            return;
        }

        const q = query.toLowerCase();
        const matches = pages.filter(p =>
            p.label.toLowerCase().includes(q)
        );

        if (!matches.length) {
            $results.html(`
                <div class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                    No results found for "<strong>${query}</strong>"
                </div>
            `).removeClass('hidden');
            return;
        }

        $results.html(`
            <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700">
                ${matches.map(p => `
                    <a href="${p.url}" class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                        <i data-lucide="${p.icon}" class="h-4 w-4 flex-shrink-0 text-slate-400 dark:text-slate-500"></i>
                        <span>${highlightMatch(p.label, query)}</span>
                    </a>
                `).join('')}
            </div>
        `).removeClass('hidden');

        if (window.initLucideIcons) window.initLucideIcons();

        $results.find('a').on('click', function () {
            $input.val('');
            $results.addClass('hidden').empty();
        });
    }

    function highlightMatch(text, query) {
        const idx = text.toLowerCase().indexOf(query.toLowerCase());
        if (idx === -1) return text;
        return text.slice(0, idx) + '<strong class="text-cyan-600 dark:text-cyan-400">' + text.slice(idx, idx + query.length) + '</strong>' + text.slice(idx + query.length);
    }

    $input.on('input', function () {
        renderResults($(this).val());
    });

    $input.on('keydown', function (e) {
        if (e.key === 'Escape') {
            $results.addClass('hidden').empty();
            $input.blur();
        }
        if (e.key === 'Enter') {
            const $first = $results.find('a').first();
            if ($first.length) {
                window.location.href = $first.attr('href');
            }
        }
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            $results.find('a').first().focus();
        }
    });

    $results.on('keydown', 'a', function (e) {
        const $links = $results.find('a');
        const idx = $links.index(this);
        if (e.key === 'ArrowDown' && idx < $links.length - 1) {
            e.preventDefault();
            $links.eq(idx + 1).focus();
        }
        if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (idx > 0) {
                $links.eq(idx - 1).focus();
            } else {
                $input.focus();
            }
        }
        if (e.key === 'Escape') {
            $results.addClass('hidden').empty();
            $input.focus();
        }
    });

    $(document).on('click', function (e) {
        if (!$wrapper[0].contains(e.target)) {
            $results.addClass('hidden').empty();
        }
    });
}

function initAdminNotifications() {
    const $btn = $('#adminNotificationBtn');
    const $dropdown = $('#adminNotificationDropdown');
    const $list = $('#adminNotificationList');
    const $count = $('#adminNotificationCount');
    const $badge = $('#adminNotificationBadge');

    if (!$btn.length) return;

    const API_BASE = '/api/admin/notifications';

    function updateBadge(count) {
        if (count > 0) {
            $count.text(count > 99 ? '99+' : count).removeClass('hidden').addClass('flex');
            $badge.text(count).removeClass('hidden');
        } else {
            $count.addClass('hidden').removeClass('flex');
            $badge.addClass('hidden');
        }
    }

    function fetchUnreadCount() {
        $.ajax({
            url: `${API_BASE}/unread-count`,
            method: 'GET',
            dataType: 'json',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success(payload) {
                updateBadge(payload?.data?.count ?? 0);
            },
        });
    }

    window.fetchUnreadCount = fetchUnreadCount;

    function fetchLatest() {
        $.ajax({
            url: `${API_BASE}/latest`,
            method: 'GET',
            dataType: 'json',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            success(payload) {
                const notifications = payload?.data ?? [];
                renderNotifications(notifications);
                fetchUnreadCount();
            },
            error() {
                $list.html(`<div class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Failed to load notifications</div>`);
            },
        });
    }

    function renderNotifications(notifications) {
        if (!notifications.length) {
            $list.html(`<div class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No notifications</div>`);
            return;
        }

        const colors = {
            booking: 'border-cyan-500 bg-cyan-50 dark:bg-cyan-950',
            payment: 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950',
            inquiry: 'border-violet-500 bg-violet-50 dark:bg-violet-950',
            promotion: 'border-amber-500 bg-amber-50 dark:bg-amber-950',
            system: 'border-rose-500 bg-rose-50 dark:bg-rose-950',
        };

        $list.html(notifications.map((n, i) => {
            const c = colors[n.type] || 'border-slate-400 bg-slate-50 dark:bg-slate-800';
            return `
                <article class="border-l-4 ${c} px-6 py-3 hover:bg-opacity-80 cursor-pointer transition ${n.is_read ? 'opacity-60' : ''}" data-id="${n.id}" data-read="${n.is_read ? '1' : '0'}">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">${escapeHtml(n.title || 'Notification')}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${escapeHtml(n.message || '')}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">from ${escapeHtml(n.from || 'System')}</p>
                </article>
            `;
        }).join(''));

        $list.find('article').each(function () {
            $(this).on('click', function () {
                window.location.href = $btn.data('notificationsUrl') || '/admin/notifications';
            });
        });
    }

    function timeAgo(dateStr) {
        const now = new Date();
        const date = new Date(dateStr);
        const seconds = Math.floor((now - date) / 1000);
        if (seconds < 60) return 'Just now';
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes}m ago`;
        const hours = Math.floor(minutes / 60);
        if (hours < 24) return `${hours}h ago`;
        const days = Math.floor(hours / 24);
        if (days < 30) return `${days}d ago`;
        return date.toLocaleDateString();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    $btn.on('click', function () {
        $list.html(`<div class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Loading...</div>`);
        fetchLatest();
    });

    $(document).on('click', function (e) {
        if (!$btn[0].contains(e.target) && !$dropdown[0].contains(e.target)) {
            $dropdown.addClass('hidden');
        }
    });

    fetchUnreadCount();
    setInterval(fetchUnreadCount, 30000);
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initAdminSearch();
    initAdminNotifications();
} else {
    window.addEventListener('DOMContentLoaded', () => {
        initAdminSearch();
        initAdminNotifications();
    });
    window.addEventListener('load', () => {
        initAdminSearch();
        initAdminNotifications();
    });
}
