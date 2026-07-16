import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function initRentCarPage() {
    const $page = $('[data-page="rent-car"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const $grid = $('#vehicleGrid');
    const $empty = $('#emptyState');
    const $pagination = $('#pagination');
    const $categories = $('#categoryFilters');
    const $search = $('#searchFilter');
    const $location = $('#locationFilter');
    const $sort = $('#sortFilter');
    const $loading = $('#loadingState');
    const $fromDate = $('#fromDateFilter');
    const $toDate = $('#toDateFilter');

    let currentParams = new URLSearchParams(window.location.search);

    function vehicleCardHtml(v) {
        const images = v.images || [];
        const imgUrl = images[0]
            ? (images[0].startsWith('http') ? images[0] : '/storage/' + images[0])
            : 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80';
        const name = (v.brand?.name || '') + ' ' + v.model;
        const type = v.category?.name || 'Standard';
        const specs = [];
        if (v.capacity) specs.push(v.capacity + ' seats');
        if (v.color) specs.push(v.color);

        return `<div class="group rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
            <div class="relative overflow-hidden h-44 bg-slate-100 dark:bg-slate-800">
                <img class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" src="${imgUrl}" alt="${name}" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            <div class="p-3">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">${name}</h3>
                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400 font-medium">${type}</p>
                    </div>
                    <div class="flex items-center gap-1 text-xs font-medium text-slate-600 dark:text-slate-400">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        ${v.location || 'Yangon'}
                    </div>
                </div>
                <div class="mb-3 flex flex-wrap gap-2">
                    ${specs.map(s => `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-medium text-slate-700 dark:text-slate-300">
                        <svg class="h-3 w-3 text-cyan-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        ${s}
                    </span>`).join('')}
                </div>
                <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-3">
                    <div>
                        <p class="font-black text-slate-950 dark:text-white">${money(v.price_per_day)}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">per day</p>
                    </div>
                    <a href="/rent-car/create?vehicle_id=${v.id}" class="inline-block rounded-lg bg-cyan-400 dark:bg-cyan-500 px-4 py-2.5 text-sm font-bold text-black shadow-sm hover:bg-cyan-500 dark:hover:bg-cyan-400 active:scale-95 transition-all">Book Now</a>
                </div>
            </div>
        </div>`;
    }

    function categoryChipHtml(categories, activeId) {
        let html = `<a href="?${buildQueryString({ category_id: '' })}" class="filter-chip rounded-full border-2 px-4 py-2 text-sm font-bold transition-all ${!activeId ? 'border-cyan-400 bg-cyan-50 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300' : 'border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:border-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20'}">All Vehicles</a>`;
        categories.forEach(c => {
            const active = String(c.id) === String(activeId);
            html += `<a href="?${buildQueryString({ category_id: c.id })}" class="filter-chip rounded-full border-2 px-4 py-2 text-sm font-bold transition-all ${active ? 'border-cyan-400 bg-cyan-50 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300' : 'border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:border-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20'}">${c.name}</a>`;
        });
        return html;
    }

    function buildQueryString(overrides) {
        const params = new URLSearchParams(currentParams);
        Object.entries(overrides).forEach(([k, v]) => {
            if (v) params.set(k, v);
            else params.delete(k);
        });
        return params.toString();
    }

    function updateUrl(overrides) {
        const qs = buildQueryString(overrides);
        window.history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
        currentParams = new URLSearchParams(qs);
        loadVehicles();
    }

    async function loadVehicles() {
        $loading.removeClass('hidden');
        $grid.addClass('hidden');
        $empty.addClass('hidden');
        $pagination.addClass('hidden');

        try {
            const qs = currentParams.toString();
            const payload = await jsonRequest(apiBase + '/api/user/rent-car' + (qs ? '?' + qs : ''));
            const data = payload?.data || payload;
            const vehicles = data?.vehicles?.data || data?.vehicles || [];
            const categories = data?.categories || [];

            $categories.html(categoryChipHtml(categories, currentParams.get('category_id')));

            if (!vehicles.length) {
                $empty.removeClass('hidden');
            } else {
                $grid.html(vehicles.map(vehicleCardHtml).join('')).removeClass('hidden');
                renderPagination(data?.vehicles);
            }
        } catch {
            $grid.html('<div class="col-span-full py-16 text-center text-red-400">Failed to load vehicles. Please try again.</div>').removeClass('hidden');
        } finally {
            $loading.addClass('hidden');
        }
    }

    function renderPagination(pagination) {
        if (!pagination || pagination.last_page <= 1) {
            $pagination.addClass('hidden');
            return;
        }
        $pagination.removeClass('hidden');
        const current = pagination.current_page;
        const last = pagination.last_page;
        const from = pagination.from || 1;
        const to = pagination.to || 0;
        const total = pagination.total || 0;

        const updateFn = (page) => updateUrl({ page });

        let html = `<div class="flex items-center justify-between"><p class="text-sm text-slate-500">Showing ${from} to ${to} of ${total} vehicles</p><nav class="flex items-center gap-1">`;

        html += `<button data-page="${current - 1}" class="pagination-btn inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all ${current <= 1 ? 'opacity-50 cursor-not-allowed' : ''}" ${current <= 1 ? 'disabled' : ''}>Prev</button>`;

        for (let i = 1; i <= last; i++) {
            html += `<button data-page="${i}" class="pagination-btn inline-flex items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium transition-all ${i === current ? 'border-cyan-500 bg-cyan-50 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300' : 'border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700'}">${i}</button>`;
        }

        html += `<button data-page="${current + 1}" class="pagination-btn inline-flex items-center justify-center rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all ${current >= last ? 'opacity-50 cursor-not-allowed' : ''}" ${current >= last ? 'disabled' : ''}>Next</button>`;

        html += '</nav></div>';
        $pagination.html(html);

        $pagination.off('click', '.pagination-btn').on('click', '.pagination-btn', function () {
            const page = parseInt($(this).data('page'));
            if (!page || $(this).prop('disabled')) return;
            updateFn(page);
        });
    }

    let searchTimeout;
    $search.on('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateUrl({ search: $(this).val(), page: '' });
        }, 400);
    });

    $location.on('change', function () { updateUrl({ location: $(this).val(), page: '' }); });
    $sort.on('change', function () { updateUrl({ sort: $(this).val(), page: '' }); });
    $fromDate.on('change', function () { updateUrl({ from_date: $(this).val(), page: '' }); });
    $toDate.on('change', function () { updateUrl({ to_date: $(this).val(), page: '' }); });

    $(window).on('popstate', () => {
        currentParams = new URLSearchParams(window.location.search);
        loadVehicles();
    });

    const observer = new MutationObserver(() => {
        if ($categories.is(':empty')) return;
        $categories.off('click', 'a.filter-chip').on('click', 'a.filter-chip', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            const qs = href.split('?')[1] || '';
            currentParams = new URLSearchParams(qs);
            window.history.replaceState(null, '', window.location.pathname + (qs ? '?' + qs : ''));
            loadVehicles();
        });
    });
    observer.observe($categories[0], { childList: true });

    if (currentParams.get('search')) $search.val(currentParams.get('search'));
    if (currentParams.get('from_date')) $fromDate.val(currentParams.get('from_date'));
    if (currentParams.get('to_date')) $toDate.val(currentParams.get('to_date'));

    $page.data('initialized', true);
    loadVehicles();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="rent-car"]')) initRentCarPage();
});
