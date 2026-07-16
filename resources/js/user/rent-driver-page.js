import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function initRentDriverPage() {
    const $page = $('[data-page="rent-driver"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const $grid = $('#licenseTypeGrid');
    const $empty = $('#emptyState');
    const $loading = $('#loadingState');

    const descriptions = {
        'Kha (ခ)': 'Private cars (up to 3 tons)',
        'Ga (ဂ)': 'Tractors & heavy machinery',
        'Gha (ဃ)': 'Taxis & commercial vans',
        'Nga (င)': 'Large buses & cargo trucks',
    };

    const typeColors = {
        'Kha (ခ)': { bg: 'from-yellow-400 to-yellow-500', border: 'border-yellow-200 dark:border-yellow-800', badge: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' },
        'Ga (ဂ)': { bg: 'from-blue-500 to-blue-600', border: 'border-blue-200 dark:border-blue-800', badge: 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' },
        'Gha (ဃ)': { bg: 'from-orange-500 to-orange-600', border: 'border-orange-200 dark:border-orange-800', badge: 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300' },
        'Nga (င)': { bg: 'from-pink-500 to-pink-600', border: 'border-pink-200 dark:border-pink-800', badge: 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-300' },
    };

    function cardHtml(lt) {
        const colors = typeColors[lt.type] || typeColors['Kha (ခ)'];
        const desc = descriptions[lt.type] || '';
        const imgUrl = lt.image
            ? (lt.image.startsWith('http') ? lt.image : '/storage/' + lt.image)
            : '';

        return `<div class="group rounded-2xl border-2 ${colors.border} bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col">
            <div class="bg-gradient-to-r ${colors.bg} px-4 py-4 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute -top-6 -right-6 w-20 h-20 bg-white rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-6 -left-6 w-16 h-16 bg-white rounded-full blur-2xl"></div>
                </div>
                <div class="relative z-10">
                    <h3 class="text-lg font-bold">${lt.type}</h3>
                    ${desc ? `<p class="mt-0.5 text-xs text-white/80 font-medium">${desc}</p>` : ''}
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col">
                ${imgUrl ? `<div class="mb-3 -mx-4 -mt-4 h-32 overflow-hidden">
                    <img src="${imgUrl}" alt="${lt.type}" class="h-full w-full object-cover" loading="lazy">
                </div>` : ''}
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold ${colors.badge}">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        ${lt.drivers_count || 0} driver${lt.drivers_count !== 1 ? 's' : ''} available
                    </span>
                </div>
                <div class="mt-auto flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
                    <div>
                        <p class="font-black text-slate-950 dark:text-white text-sm">${money(lt.price || 0)}</p>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">per day</p>
                    </div>
                    <a href="/rent-driver/create?license_type_id=${lt.id}" class="inline-block rounded-lg bg-cyan-400 dark:bg-cyan-500 px-3 py-1.5 text-xs font-bold text-black shadow-sm hover:bg-cyan-500 dark:hover:bg-cyan-400 active:scale-95 transition-all">Hire Now</a>
                </div>
            </div>
        </div>`;
    }

    async function loadLicenseTypes() {
        $loading.removeClass('hidden');
        $grid.addClass('hidden');
        $empty.addClass('hidden');

        try {
            const payload = await jsonRequest(apiBase + '/api/user/driving-license-types');
            const types = payload?.data || [];

            if (!types.length) {
                $empty.removeClass('hidden');
            } else {
                $grid.html(types.map(cardHtml).join('')).removeClass('hidden');
            }
        } catch {
            $grid.html('<div class="col-span-full py-16 text-center text-red-400">Failed to load license types. Please try again.</div>').removeClass('hidden');
        } finally {
            $loading.addClass('hidden');
        }
    }

    loadLicenseTypes();

    $page.data('initialized', true);
}

$(document).ready(function () {
    if (document.querySelector('[data-page="rent-driver"]')) initRentDriverPage();
});
