import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function showToast($toast, message, isError) {
    $toast.text(message)
        .attr('class', `fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ${isError ? 'bg-rose-600' : 'bg-gradient-to-r from-green-500 to-green-600'}`)
        .removeClass('hidden');
    setTimeout(() => $toast.addClass('hidden'), 3500);
}

const STATUS_COLORS = {
    pending: 'bg-yellow-100 text-yellow-800',
    confirmed: 'bg-green-100 text-green-800',
    active: 'bg-blue-100 text-blue-800',
    completed: 'bg-slate-100 text-slate-800',
    cancelled: 'bg-red-100 text-red-800',
};

const COLUMN_DEFS = {
    car: [
        { key: 'booking_no', label: 'Booking No' },
        { key: 'vehicle', label: 'Vehicle' },
        { key: 'dates', label: 'Dates' },
        { key: 'total', label: 'Total' },
        { key: 'status', label: 'Status' },
        { key: 'action', label: 'Action' },
    ],
    driver: [
        { key: 'booking_no', label: 'Booking No' },
        { key: 'driver', label: 'Driver' },
        { key: 'dates', label: 'Dates' },
        { key: 'total', label: 'Total' },
        { key: 'status', label: 'Status' },
        { key: 'action', label: 'Action' },
    ],
};

function initBookingHistoryPage() {
    const $page = $('[data-page="user-booking-history"]');
    if (!$page.length || $page.data('initialized')) return;

    const $headerRow = $('#headerRow');
    const $tbody = $('#tableBody');
    const $searchInput = $('#searchInput');
    const $serviceTabs = $('.service-tab');
    const $statusFilter = $('#statusFilter');
    const $pagination = $('#pagination');
    const $modal = $('#detailsModal');
    const $modalContent = $('#modalContent');
    const $toast = $('#demoToast');

    let currentService = 'car';
    let currentSubTab = 'all';
    let currentPage = 1;
    const rowsPerPage = 5;
    let allData = [];
    let filtered = [];

    function getColumns() {
        return COLUMN_DEFS[currentService];
    }

    function renderHeader() {
        const cols = getColumns();
        const colspan = cols.length;
        $headerRow.html(cols.map(c => `<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">${c.label}</th>`).join(''));
        return colspan;
    }

    function getColspan() {
        return getColumns().length;
    }

    async function loadData() {
        try {
            const payload = await jsonRequest('/api/user/bookings');
            const bookings = payload?.data?.data || payload?.data || [];
            allData = bookings;
            filterAndRender();
        } catch {
            $tbody.html(`<tr><td colspan="${getColspan()}" class="px-6 py-12 text-center text-sm text-red-400">Failed to load bookings.</td></tr>`);
        }
    }

    function filterData() {
        const search = $searchInput.val().toLowerCase();
        const isCar = currentService === 'car';
        let base;
        if (currentSubTab === 'all') {
            base = allData;
        } else {
            base = allData.filter(b => b.status === currentSubTab);
        }
        base = base.filter(b => (b.items || []).some(i =>
            isCar ? i.vehicle : (i.has_driver || i.driver || i.driver_daily_rate > 0)
        ));
        if (!search) return base;
        const q = search.toLowerCase();
        return base.filter(b =>
            b.booking_number?.toLowerCase().includes(q) ||
            String(b.id).includes(q) ||
            (b.items || []).some(i => {
                const matchesVehicle = i.vehicle?.model?.toLowerCase().includes(q) || i.vehicle?.brand?.name?.toLowerCase().includes(q);
                const matchesDriver = i.driver?.name?.toLowerCase().includes(q);
                return isCar ? matchesVehicle : matchesDriver;
            })
        );
    }

    function filterAndRender() {
        filtered = filterData();
        renderTable();
        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filtered.length / rowsPerPage) || 1;
        if (totalPages <= 1) {
            $pagination.addClass('hidden');
            return;
        }
        $pagination.removeClass('hidden');

        const from = (currentPage - 1) * rowsPerPage + 1;
        const to = Math.min(currentPage * rowsPerPage, filtered.length);
        let html = `<div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Showing ${from} to ${to} of ${filtered.length} bookings</p>
            <nav class="flex items-center gap-1">`;
        html += `<button data-page="${currentPage - 1}"
            class="pagination-btn inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-all ${currentPage <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
            ${currentPage <= 1 ? 'disabled' : ''}>Prev</button>`;

        for (let i = 1; i <= totalPages; i++) {
            html += `<button data-page="${i}"
                class="pagination-btn inline-flex items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium transition-all ${i === currentPage ? 'border-cyan-500 bg-cyan-50 text-cyan-700' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-50'}">${i}</button>`;
        }

        html += `<button data-page="${currentPage + 1}"
            class="pagination-btn inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-all ${currentPage >= totalPages ? 'opacity-50 cursor-not-allowed' : ''}"
            ${currentPage >= totalPages ? 'disabled' : ''}>Next</button>`;

        html += '</nav></div>';
        $pagination.html(html);
    }

    function formatDate(d) {
        if (!d) return 'N/A';
        return d.split('T')[0].split(' ')[0] || 'N/A';
    }

    function renderCarRow(b) {
        const items = (b.items || []).filter(i => i.vehicle);
        const lineH = 'h-[36px] flex items-center';
        const vehicleCells = items.length
            ? items.map(i => {
                const name = [i.vehicle.brand?.name, i.vehicle.model].filter(Boolean).join(' ');
                return `<div class="${lineH} text-sm text-slate-900 font-medium">${name}</div>`;
              }).join('')
            : `<div class="${lineH} text-sm text-slate-400">N/A</div>`;
        const dateCells = items.length
            ? items.map(i => `<div class="${lineH} text-sm text-slate-500">${formatDate(i.start_date)} - ${formatDate(i.end_date)}</div>`).join('')
            : `<div class="${lineH} text-sm text-slate-400">N/A</div>`;
        return `<tr class="hover:bg-slate-50 transition">
            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900 align-top">${b.booking_number || `#${b.id}`}</td>
            <td class="px-6 py-4 align-top">${vehicleCells}</td>
            <td class="px-6 py-4 align-top">${dateCells}</td>
            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900 align-top">${money(bookingTabTotal(b))}</td>
            <td class="whitespace-nowrap px-6 py-4 align-top"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${STATUS_COLORS[b.status] || ''}">${b.status}</span></td>
            <td class="whitespace-nowrap px-6 py-4 text-right align-top">
                <button class="view-booking-details text-cyan-600 hover:text-cyan-800" data-id="${b.id}" title="Details"><i data-lucide="eye" class="inline h-4 w-4"></i></button>
            </td>
        </tr>`;
    }

    function driverNameFromItem(it) {
        if (it.driver?.name) return it.driver.name;
        if (it.notes) {
            const m = it.notes.match(/Hired driver:\s*(.+)/i);
            if (m) return m[1].trim();
        }
        return null;
    }

    function bookingTabTotal(b) {
        if (b.total_price !== undefined && b.total_price !== null) {
            return Number(b.total_price);
        }
        const msDay = 86400000;
        let sub = 0;
        (b.items || []).forEach(it => {
            const rt = Number(it.vehicle_daily_rate || 0) + Number(it.driver_daily_rate || 0);
            const days = Math.max(1, Math.round((new Date(it.end_date) - new Date(it.start_date)) / msDay) + 1);
            sub += rt * days * (it.quantity || 1);
        });
        return sub - Number(b.discount_amount || 0);
    }

    function renderDriverRow(b) {
        const items = (b.items || []).filter(i => i.has_driver || i.driver || (!i.vehicle && i.driver_daily_rate > 0));
        const lineH = 'h-[36px] flex items-center';
        const lines = items.length
            ? items.map(i => {
                const name = driverNameFromItem(i) || 'Pending Assignment';
                const qty = parseInt(i.quantity) || 1;
                return `<div class="${lineH} text-sm text-slate-900 font-medium">${name}${qty > 1 ? ` <span class="text-xs text-slate-400 font-normal">×${qty}</span>` : ''}</div>`;
              }).join('')
            : `<div class="${lineH} text-sm text-slate-400">N/A</div>`;
        const dateCells = items.length
            ? items.map(i => `<div class="${lineH} text-sm text-slate-500">${formatDate(i.start_date)} - ${formatDate(i.end_date)}</div>`).join('')
            : `<div class="${lineH} text-sm text-slate-400">N/A</div>`;
        return `<tr class="hover:bg-slate-50 transition">
            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900 align-top">${b.booking_number || `#${b.id}`}</td>
            <td class="px-6 py-4 align-top">${lines}</td>
            <td class="px-6 py-4 align-top">${dateCells}</td>
            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900 align-top">${money(bookingTabTotal(b))}</td>
            <td class="whitespace-nowrap px-6 py-4 align-top"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${STATUS_COLORS[b.status] || ''}">${b.status}</span></td>
            <td class="whitespace-nowrap px-6 py-4 text-right align-top">
                <button class="view-booking-details text-cyan-600 hover:text-cyan-800" data-id="${b.id}" title="Details"><i data-lucide="eye" class="inline h-4 w-4"></i></button>
            </td>
        </tr>`;
    }

    function renderTable() {
        const totalPages = Math.ceil(filtered.length / rowsPerPage) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * rowsPerPage;
        const pageData = filtered.slice(start, start + rowsPerPage);

        if (!pageData.length) {
            $tbody.html(`<tr><td colspan="${getColspan()}" class="px-6 py-16 text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">
                    <i data-lucide="calendar-x" class="h-8 w-8 text-slate-400"></i>
                </div>
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">No bookings found</p>
                <p class="mt-1 text-xs text-slate-400 dark:text-slate-500">Try adjusting your search or filters</p>
            </td></tr>`);
        } else if (currentService === 'car') {
            $tbody.html(pageData.map(renderCarRow).join(''));
        } else {
            $tbody.html(pageData.map(renderDriverRow).join(''));
        }
        if (window.lucide) lucide.createIcons();
    }

    const ACTIVE_PILL = 'border-cyan-400 bg-cyan-50 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300';
    const INACTIVE_PILL = 'border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300';

    $serviceTabs.on('click', function () {
        $serviceTabs.removeClass(ACTIVE_PILL).addClass(INACTIVE_PILL);
        $(this).removeClass(INACTIVE_PILL).addClass(ACTIVE_PILL);
        currentService = $(this).data('service');
        currentPage = 1;
        currentSubTab = 'all';
        $statusFilter.val('all');
        renderHeader();
        loadData();
    });

    $statusFilter.on('change', function () {
        currentSubTab = $(this).val();
        currentPage = 1;
        filterAndRender();
    });

    $searchInput.on('input', () => { currentPage = 1; filterAndRender(); });

    $pagination.on('click', '.pagination-btn', function () {
        const page = parseInt($(this).data('page'));
        if (!page || $(this).prop('disabled')) return;
        currentPage = page;
        filterAndRender();
    });

    function vehicleImageUrl(v) {
        const images = v?.images || [];
        const url = images[0];
        if (!url) return null;
        return url.startsWith('http') ? url : '/storage/' + url;
    }

    function driverAvatarInitial(name) {
        return name ? name.charAt(0).toUpperCase() : '?';
    }

    function itemRowHtml(it, b) {
        const itV = it.vehicle;
        const isVehicle = !!itV;
        const name = isVehicle
            ? [itV.brand?.name, itV.model].filter(Boolean).join(' ')
            : (driverNameFromItem(it) || 'Pending Driver');
        const rate = isVehicle ? Number(it.vehicle_daily_rate || 0) : Number(it.driver_daily_rate || 0);
        const imgUrl = isVehicle ? vehicleImageUrl(itV) : null;
        const initial = driverAvatarInitial(name);

        const msDay = 86400000;
        const days = Math.max(1, Math.round((new Date(it.end_date) - new Date(it.start_date)) / msDay) + 1);
        const itemTotal = rate * days * (it.quantity || 1);

        let row = `<div class="rounded-xl border border-slate-200 bg-white p-3 transition mb-3">`;
        if (isVehicle) {
            row += `<div class="flex items-start gap-3">`;
            if (imgUrl) {
                row += `<img src="${imgUrl}" alt="${name}" class="h-14 w-20 rounded-lg object-cover shrink-0 border border-slate-200">`;
            } else {
                row += `<div class="flex h-14 w-20 items-center justify-center rounded-lg bg-slate-100 shrink-0 border border-slate-200"><i data-lucide="car" class="h-5 w-5 text-slate-400"></i></div>`;
            }
            row += `<div class="flex-1 min-w-0">`;
            row += `<div class="flex justify-between items-start">`;
            row += `<div><p class="text-sm font-bold text-slate-900 truncate">${name}</p>`;
            if (itV?.color) row += `<p class="text-xs text-slate-500 mt-0.5">${itV.color}${itV.year ? ` · ${itV.year}` : ''}</p>`;
            row += `</div><span class="text-xs font-bold text-slate-900">${money(itemTotal)}</span>`;
            row += `</div>`;
            row += `<div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600">`;
            if (rate > 0) row += `<span>${money(rate)}/day (${days} days)</span>`;
            row += `</div></div></div>`;

            row += `<div class="mt-3 text-xs bg-slate-50 rounded-lg px-3 py-2.5"><div class="flex justify-between">`;
            row += `<div class="space-y-1.5"><div><span class="text-slate-400">Pickup Date</span><p class="font-medium text-slate-900">${formatDate(it.start_date)}</p></div>${it.pickup_location ? `<div><span class="text-slate-400">Pickup Location</span><p class="font-medium text-slate-900">${it.pickup_location}</p></div>` : ''}</div>`;
            row += `<div class="space-y-1.5 text-right"><div><span class="text-slate-400">Return Date</span><p class="font-medium text-slate-900">${formatDate(it.end_date)}</p></div>${it.dropoff_location ? `<div><span class="text-slate-400">Drop-off Location</span><p class="font-medium text-slate-900">${it.dropoff_location}</p></div>` : ''}</div>`;
            row += `</div></div>`;

            if (it.notes) {
                row += `<div class="mt-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-slate-700 border border-amber-200">${it.notes}</div>`;
            }

            if (it.has_driver || it.driver) {
                row += `<div class="mt-2 flex items-center gap-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-slate-700 border border-amber-200"><i data-lucide="user-check" class="h-3.5 w-3.5 text-amber-500 shrink-0"></i><span class="font-medium">${it.driver?.name || 'Driver requested'}</span>${it.driver_daily_rate > 0 ? `<span class="text-slate-500">${money(it.driver_daily_rate)}/day</span>` : ''}</div>`;
            }
        } else {
            const drvImgUrl = it.driver ? vehicleImageUrl(it.driver) : null;
            row += `<div class="flex items-center gap-3">`;
            if (drvImgUrl) {
                row += `<img src="${drvImgUrl}" alt="${name}" class="h-14 w-14 rounded-full object-cover shrink-0 border border-slate-200 shadow-sm">`;
            } else {
                row += `<div class="flex h-14 w-14 items-center justify-center rounded-full bg-cyan-500 text-white font-bold text-lg shrink-0 shadow-sm">${initial}</div>`;
            }
            row += `<div class="flex-1 min-w-0">`;
            row += `<div class="flex justify-between items-center">`;
            row += `<p class="text-sm font-bold text-slate-900">${name}</p>`;
            row += `<span class="text-xs font-bold text-slate-900">${money(itemTotal)}</span>`;
            row += `</div>`;
            if (rate > 0) row += `<p class="text-xs text-slate-500 mt-0.5">${money(rate)}/day (${days} days)</p>`;
            row += `</div></div>`;

            row += `<div class="mt-3 text-xs bg-slate-50 rounded-lg px-3 py-2.5"><div class="flex justify-between">`;
            row += `<div class="space-y-1.5"><div><span class="text-slate-400">Service Start</span><p class="font-medium text-slate-900">${formatDate(it.start_date)}</p></div>${it.pickup_location ? `<div><span class="text-slate-400">Pickup Location</span><p class="font-medium text-slate-900">${it.pickup_location}</p></div>` : ''}</div>`;
            row += `<div class="space-y-1.5 text-right"><div><span class="text-slate-400">Service End</span><p class="font-medium text-slate-900">${formatDate(it.end_date)}</p></div>${it.dropoff_location ? `<div><span class="text-slate-400">Drop-off Location</span><p class="font-medium text-slate-900">${it.dropoff_location}</p></div>` : ''}</div>`;
            row += `</div></div>`;

            if (it.notes) {
                row += `<div class="mt-2 rounded-lg bg-amber-50 px-3 py-2 text-xs text-slate-700 border border-amber-200">${it.notes}</div>`;
            }
        }

        row += `</div>`;
        return row;
    }

    $tbody.on('click', '.view-booking-details', async function () {
        const id = $(this).data('id');
        try {
            const payload = await jsonRequest(`/api/user/bookings/${id}`);
            const b = payload?.data || payload;
            if (!b || !b.id) throw new Error('Not found');

            const payment = b.payments?.[0];
            const promo = b.promotion_usage?.promotion;

            let html = '';

            html += `<div class="flex items-start justify-between border-b border-slate-200 pb-3 mb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">${b.booking_number || `#${b.id}`}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Submitted ${new Date(b.created_at).toLocaleDateString()}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${STATUS_COLORS[b.status] || ''}">${b.status}</span>
                    <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 transition"><i data-lucide="x" class="h-4 w-4"></i></button>
                </div>
            </div>`;

            const modalItems = (b.items || []).filter(it =>
                currentService === 'car' ? it.vehicle : (it.has_driver || it.driver || (!it.vehicle && it.driver_daily_rate > 0))
            );
            if (modalItems.length) {
                const heading = currentService === 'car' ? 'Booked Vehicles' : 'Hired Drivers';
                html += `<div class="mb-3"><span class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5 block">${heading} (${modalItems.length})</span>`;
                html += modalItems.map(it => itemRowHtml(it, b)).join('');
                html += `</div>`;
            }

            const msDay = 86400000;

            let totalBookingSubtotal = 0;
            let modalItemsHtml = '';

            (b.items || []).forEach(it => {
                const vRate = Number(it.vehicle_daily_rate || 0);
                const dRate = Number(it.driver_daily_rate || 0);
                const days = Math.max(1, Math.round((new Date(it.end_date) - new Date(it.start_date)) / msDay) + 1);
                const qty = it.quantity || 1;
                const vLineCost = vRate * days * qty;
                const dLineCost = dRate * days * qty;
                totalBookingSubtotal += vLineCost + dLineCost;

                const itemName = it.vehicle 
                    ? [it.vehicle?.brand?.name, it.vehicle?.model].filter(Boolean).join(' ')
                    : (it.driver?.name || 'Assigned Driver Service');

                if (vLineCost > 0) {
                    modalItemsHtml += `
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">${itemName} (${days} days × ${qty})</span>
                            <span class="font-medium text-slate-800">${money(vLineCost)}</span>
                        </div>`;
                }
                if (dLineCost > 0) {
                    modalItemsHtml += `
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500 pl-3">Driver Service (${days} days × ${qty})</span>
                            <span class="font-medium text-slate-800">${money(dLineCost)}</span>
                        </div>`;
                }
            });

            html += `<div class="mb-3 rounded-xl border border-slate-200 px-3 py-2.5 text-sm bg-slate-50/50">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Pricing Breakdown</span>
                <div class="mt-1.5 space-y-1.5">
                    ${modalItemsHtml}
                    
                    <div class="flex justify-between text-sm border-t border-slate-100 pt-1.5 mt-1.5">
                        <span class="text-slate-500 font-medium">Subtotal</span>
                        <span class="font-semibold text-slate-900">${money(totalBookingSubtotal)}</span>
                    </div>`;

            if (Number(b.discount_amount) > 0) {
                html += `
                    <div class="flex justify-between text-xs text-emerald-700">
                        <span>Promotion Discount ${promo ? `(${promo.code})` : ''}</span>
                        <span class="font-medium">-${money(b.discount_amount)}</span>
                    </div>`;
            }

            const totalFinalPrice = bookingTabTotal(b);

            html += `
                    <div class="flex justify-between text-sm font-bold border-t border-slate-200 pt-2 mt-2">
                        <span class="text-slate-700">Total Booking Price</span>
                        <span class="text-slate-950 text-base">${money(totalFinalPrice)}</span>
                    </div>
                </div>
            </div>`;

            const allPayments = b.payments || [];

            if (allPayments.length) {
                html += `<div class="mb-3 rounded-xl border border-slate-200 text-sm overflow-hidden">
                    <div class="bg-slate-50/50 px-3 py-2 border-b border-slate-200">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Payment</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-100/80 text-slate-500 font-semibold uppercase tracking-wider">
                                    <th class="px-3 py-2 text-left">Method</th>
                                    <th class="px-3 py-2 text-left">Ref</th>
                                    <th class="px-3 py-2 text-right">Amount</th>
                                    <th class="px-3 py-2 text-left">Date</th>
                                    <th class="px-3 py-2"></th>
                                </tr>
                            </thead>
                            <tbody>`;
                    allPayments.forEach((p) => {
                        html += `
                                <tr class="border-t border-slate-100 hover:bg-slate-50/50">
                                    <td class="px-3 py-2 capitalize font-medium text-slate-900">${p.payment_method}</td>
                                    <td class="px-3 py-2 text-slate-600 font-mono">${p.transaction_ref || 'N/A'}</td>
                                    <td class="px-3 py-2 text-right font-medium text-slate-900">${money(p.amount)}</td>
                                    <td class="px-3 py-2 text-slate-500 whitespace-nowrap">${new Date(p.created_at).toLocaleDateString()}</td>
                                    <td class="px-3 py-2 text-right">${p.image ? `<a href="${p.image.startsWith('http') ? p.image : '/storage/' + p.image}" target="_blank" class="inline-flex items-center gap-1 rounded-md bg-cyan-50 px-2 py-1 text-[10px] font-medium text-cyan-700 hover:bg-cyan-100 transition"><i data-lucide="file-image" class="h-3 w-3"></i> Receipt</a>` : ''}</td>
                                </tr>`;
                    });
                    const totalPaid = allPayments.reduce((s, p) => s + Number(p.amount || 0), 0);
                    const remaining = Math.max(0, totalFinalPrice - totalPaid);
                    html += `</tbody></table></div>
                    <div class="border-t border-slate-200 bg-slate-50/80 px-3 py-2 space-y-1">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-500">Total Paid</span>
                            <span class="font-semibold text-emerald-600">${money(totalPaid)}</span>
                        </div>
                        <div class="flex justify-between text-xs font-bold border-t border-slate-200 pt-1">
                            <span class="text-slate-700">Remaining Balance</span>
                            <span class="${remaining > 0 ? 'text-rose-600' : 'text-emerald-600'}">${money(remaining)}</span>
                        </div>
                    </div>
                </div>`;
            }

            $modalContent.html(html);
            $modal.removeClass('hidden').addClass('flex');
            if (window.lucide) lucide.createIcons();
        } catch {
            showToast($toast, 'Failed to load details', true);
        }
    });

    $modalContent.on('click', '#closeModalBtn', () => $modal.addClass('hidden').removeClass('flex'));

    $(window).on('click', (e) => { if (e.target === $modal[0]) $modal.addClass('hidden').removeClass('flex'); });
    $statusFilter.removeClass('hidden');

    $page.data('initialized', true);
    renderHeader();
    loadData();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="user-booking-history"]')) initBookingHistoryPage();
});