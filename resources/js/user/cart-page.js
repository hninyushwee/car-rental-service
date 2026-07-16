import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

function initCartPage() {
    const $page = $('[data-page="cart-view"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const $list = $('#cartItemsList');
    const $empty = $('#cartEmpty');
    const $itemCount = $('#cartItemCount');
    const $cartSubtotal = $('#cartSubtotal');
    const $cartSubtotalRaw = $('#cartSubtotalRaw');
    const $cartPromoRow = $('#cartPromoRow');
    const $cartPromo = $('#cartPromo');
    const $cartPromoLabel = $('#cartPromoLabel');
    const $cartTotalPayment = $('#cartTotalPayment');
    const $toast = $('#cartToast');
    const $promoInput = $('#promoCodeInput');
    const $applyPromoBtn = $('#applyPromoBtn');
    const $promoError = $('#promoError');
    const $checkoutSidebar = $('#checkoutSidebar');

    let promotions = [];
    let appliedPromoCode = null;

    function showToast(msg, isError) {
        $toast.text(msg)
            .attr('class', 'fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ' + (isError ? 'bg-rose-600' : 'bg-gradient-to-r from-green-500 to-green-600'))
            .removeClass('hidden');
        setTimeout(() => $toast.addClass('hidden'), 4000);
    }

    function toggleCheckoutBtn() {
        const hasRef = $('#transaction_ref').val().trim().length > 0;
        const hasFile = $('#payment_image').get(0).files.length > 0;
        $('#checkoutBtn').prop('disabled', !(hasRef && hasFile));
    }

    function findPromo(code) {
        return promotions.find(p => p.code.toUpperCase() === code.toUpperCase());
    }

    function applyPromo() {
        const code = $promoInput.val().trim().toUpperCase();
        $promoError.addClass('hidden');

        if (!code) {
            appliedPromoCode = null;
            clearPromoFromItems();
            renderCart();
            return;
        }

        if (appliedPromoCode === code) {
            $promoError.text('This promotion code is already applied.').removeClass('hidden');
            return;
        }

        const promo = findPromo(code);
        if (!promo) {
            $promoError.text('Specified promotion token is invalid or expired.').removeClass('hidden');
            return;
        }

        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        if (!items.length) return;

        // Check minSpend against total cart subtotal
        const minSpend = promo.min_spend ? parseFloat(promo.min_spend) : null;
        if (minSpend) {
            const totalRaw = items.reduce((sum, item) => sum + itemRawSubtotal(item), 0);
            if (totalRaw < minSpend) {
                $promoError.text('Minimum spend of MMK ' + Number(minSpend).toLocaleString('en-US') + ' required to use this code.').removeClass('hidden');
                return;
            }
        }

        (async () => {
            try {
                const usage = await jsonRequest(apiBase + '/api/user/promotions/' + code + '/check-usage', { method: 'POST' });
                const usageData = usage?.data || usage;
                if (usageData?.used) {
                    $promoError.text('This promotion code has already been used by your account.').removeClass('hidden');
                    return;
                }
            } catch {
            }

            applyPromoToAllItems(promo, code);
            renderCart();
        })();
    }

    function itemRawSubtotal(item) {
        const qty = parseInt(item.quantity) || 1;
        const vehicleTotal = parseFloat(item.price_per_day) * parseInt(item.days) * qty;
        const driverTotal = parseFloat(item.driver_price_per_day || 0) * parseInt(item.days) * qty;
        return vehicleTotal + driverTotal;
    }

    function calcPromoOnItems(items, promo, code) {
        const totalRaw = items.reduce((sum, item) => sum + itemRawSubtotal(item), 0);
        if (!totalRaw) return;
        let totalDiscount = 0;
        if (promo.discount_type === 'percentage') {
            totalDiscount = totalRaw * (parseFloat(promo.discount_value) / 100);
            const maxDiscount = promo.max_discount ? parseFloat(promo.max_discount) : null;
            if (maxDiscount && totalDiscount > maxDiscount) totalDiscount = maxDiscount;
        } else {
            totalDiscount = parseFloat(promo.discount_value);
        }
        let allocated = 0;
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const rawSubtotal = itemRawSubtotal(item);
            const share = i === items.length - 1 ? totalDiscount - allocated : Math.round((rawSubtotal / totalRaw) * totalDiscount);
            allocated += share;
            item.promo_code = code;
            item.promo_discount = share;
            item.raw_subtotal = rawSubtotal;
            item.final_total = rawSubtotal - share;
        }
    }

    function applyPromoToAllItems(promo, code) {
        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        if (!items.length) return;
        calcPromoOnItems(items, promo, code);
        appliedPromoCode = code;
        localStorage.setItem('cartItems', JSON.stringify(items));
        document.dispatchEvent(new Event('cart-updated'));
    }

    function clearPromoFromItems() {
        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        for (const item of items) {
            delete item.promo_code;
            delete item.promo_discount;
            delete item.final_total;
            delete item.raw_subtotal;
        }
        localStorage.setItem('cartItems', JSON.stringify(items));
        document.dispatchEvent(new Event('cart-updated'));
    }

    // Register remove handler once
    $(document).on('click', '.remove-item', function () {
        const idx = parseInt($(this).attr('data-cart-index'));
        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
        if (idx >= 0 && idx < items.length) {
            items.splice(idx, 1);
            localStorage.setItem('cartItems', JSON.stringify(items));
            document.dispatchEvent(new Event('cart-updated'));
            renderCart();
        }
    });

    function renderCart() {
        const items = JSON.parse(localStorage.getItem('cartItems') || '[]');

        // Recalculate promo from current items if a promo_code exists on any item
        const activeCode = items.find(item => item.promo_code)?.promo_code || null;
        if (activeCode) {
            const promo = findPromo(activeCode);
            if (promo) {
                const totalRaw = items.reduce((sum, item) => sum + itemRawSubtotal(item), 0);
                const minSpend = promo.min_spend ? parseFloat(promo.min_spend) : null;
                const allValid = !(minSpend && totalRaw < minSpend);
                if (allValid) {
                    calcPromoOnItems(items, promo, activeCode);
                    localStorage.setItem('cartItems', JSON.stringify(items));
                    appliedPromoCode = activeCode;
                } else {
                    for (const item of items) {
                        delete item.promo_code;
                        delete item.promo_discount;
                        delete item.final_total;
                        delete item.raw_subtotal;
                    }
                    localStorage.setItem('cartItems', JSON.stringify(items));
                    appliedPromoCode = null;
                }
            } else {
                for (const item of items) {
                    delete item.promo_code;
                    delete item.promo_discount;
                    delete item.final_total;
                    delete item.raw_subtotal;
                }
                localStorage.setItem('cartItems', JSON.stringify(items));
                appliedPromoCode = null;
            }
        } else {
            // No promo_code on any item — clear stale data if present
            const hasStale = items.some(item => item.promo_discount !== undefined || item.raw_subtotal !== undefined || item.final_total !== undefined);
            if (hasStale) {
                for (const item of items) {
                    delete item.promo_code;
                    delete item.promo_discount;
                    delete item.final_total;
                    delete item.raw_subtotal;
                }
                localStorage.setItem('cartItems', JSON.stringify(items));
            }
            appliedPromoCode = null;
        }

        if (!items.length) {
            $list.empty();
            $empty.removeClass('hidden');
            $checkoutSidebar.addClass('hidden');
            $itemCount.text('0 Items');
            $cartSubtotal.text('MMK 0');
            $cartSubtotalRaw.text('MMK 0');
            $cartPromoRow.addClass('hidden');
            $cartTotalPayment.text('MMK 0');
            document.getElementById('cartBadge')?.classList.add('hidden');
            return;
        }

        $empty.addClass('hidden');
        $checkoutSidebar.removeClass('hidden');
        $itemCount.text(items.length + ' Items');

        let totalDeposit = 0;
        let totalSubtotal = 0;
        let totalPromoDiscount = 0;
        let html = '';

        items.forEach((item, index) => {
            const deposit = parseFloat(item.deposit_amount || 0);
            totalDeposit += deposit;
            totalSubtotal += parseFloat(item.raw_subtotal || itemRawSubtotal(item));
            totalPromoDiscount += parseFloat(item.promo_discount || 0);

            const isDriver = item.type === 'driver';
            const qty = item.quantity || 1;
            const img = item.image || 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80';
            html += `<div class="cart-item-card rounded-2xl bg-white dark:bg-slate-900 overflow-hidden shadow-sm flex flex-col sm:flex-row" data-cart-index="${index}">
                <div class="sm:w-44 h-44 sm:h-auto shrink-0 overflow-hidden bg-slate-100 dark:bg-slate-800">
                    <img src="${img}" alt="${item.name}" class="h-full w-full object-cover" loading="lazy">
                </div>
                <div class="flex-1 p-4 sm:p-5 flex flex-col">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white truncate">${item.name}</h3>
                                ${isDriver
                                    ? `<span class="rounded-md bg-amber-50 dark:bg-amber-950/30 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-amber-700 dark:text-amber-300">${item.license_type || 'Driver'}</span>`
                                    : `<span class="rounded-md bg-cyan-50 dark:bg-cyan-950/30 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-cyan-700 dark:text-cyan-300">${item.category || 'Standard'}</span>`
                                }
                            </div>
                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                <span class="font-mono font-bold text-cyan-600 dark:text-cyan-400">${money(item.price_per_day)}<span class="text-[10px] font-normal text-slate-400 font-sans">/day</span></span>
                                ${!isDriver && item.specs ? `<span class="flex items-center gap-1"><i data-lucide="info" class="h-3 w-3"></i> ${item.specs}</span>` : ''}
                                <span class="flex items-center gap-1"><i data-lucide="package" class="h-3 w-3"></i> ×${qty}</span>
                            </div>
                        </div>
                        <button type="button" class="remove-item shrink-0 p-2 rounded-lg text-rose-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition" data-cart-index="${index}">
                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                        </button>
                    </div>

                    <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs bg-slate-50 dark:bg-slate-800/30 rounded-xl p-3">
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar" class="h-3.5 w-3.5 text-slate-400 shrink-0"></i>
                            <span class="text-slate-600 dark:text-slate-400"><span class="font-medium text-slate-700 dark:text-slate-300">${isDriver ? 'Start' : 'Pickup'}:</span> ${item.start_date ? new Date(item.start_date).toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' }) : '-'}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i data-lucide="calendar-check" class="h-3.5 w-3.5 text-slate-400 shrink-0"></i>
                            <span class="text-slate-600 dark:text-slate-400"><span class="font-medium text-slate-700 dark:text-slate-300">${isDriver ? 'End' : 'Return'}:</span> ${item.end_date ? new Date(item.end_date).toLocaleDateString('en-US', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' }) : '-'}</span>
                        </div>
                        ${isDriver
                            ? `<div class="sm:col-span-2 flex items-center gap-2">
                                <i data-lucide="badge-check" class="h-3.5 w-3.5 text-slate-400 shrink-0"></i>
                                <span class="text-slate-600 dark:text-slate-400"><span class="font-medium text-slate-700 dark:text-slate-300">License:</span> ${item.license_type || '-'}</span>
                            </div>`
                            : `<div class="flex items-center gap-2">
                                <i data-lucide="map-pin" class="h-3.5 w-3.5 text-slate-400 shrink-0"></i>
                                <span class="text-slate-600 dark:text-slate-400"><span class="font-medium text-slate-700 dark:text-slate-300">Pickup:</span> ${item.pickup_location || '-'}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i data-lucide="flag" class="h-3.5 w-3.5 text-slate-400 shrink-0"></i>
                                <span class="text-slate-600 dark:text-slate-400"><span class="font-medium text-slate-700 dark:text-slate-300">Dropoff:</span> ${item.dropoff_location || '-'}</span>
                            </div>`
                        }
                    </div>

                    <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-800">
                        ${isDriver ? `
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">Driver Service (${qty} × ${item.days} day${item.days !== 1 ? 's' : ''})</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white">${money(item.price_per_day * item.days * qty)}</span>
                        </div>` : `
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">Vehicle (${qty} × ${item.days} day${item.days !== 1 ? 's' : ''})</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white">${money(item.price_per_day * item.days * qty)}</span>
                        </div>
                        ${item.has_driver && item.driver_price_per_day > 0 ? `
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Driver Service (${qty} × ${item.days} day${item.days !== 1 ? 's' : ''})</span>
                            <span class="font-mono font-semibold text-slate-700 dark:text-slate-300">${money(item.driver_price_per_day * item.days * qty)}</span>
                        </div>` : ''}`}
                    </div>

                    <div class="mt-2 flex items-center justify-between bg-amber-50 dark:bg-amber-950/30 rounded-lg px-3 py-2 border border-amber-200/50 dark:border-amber-800/30">
                        <span class="text-xs font-bold text-amber-800 dark:text-amber-400 flex items-center gap-1.5"><i data-lucide="shield" class="h-3.5 w-3.5"></i>Initial Payment Required</span>
                        <span class="font-mono font-bold text-amber-700 dark:text-amber-300">${money(deposit)}</span>
                    </div>
                </div>
            </div>`;
        });

        $list.html(html);
        $cartSubtotalRaw.text(money(totalSubtotal));
        $cartSubtotal.text(money(totalDeposit));

        const totalPayment = Math.max(0, (totalSubtotal || 0) - (totalPromoDiscount || 0));

        if (totalPromoDiscount > 0) {
            $cartPromoRow.removeClass('hidden');
            $cartPromo.text('- ' + money(totalPromoDiscount));
            const p = findPromo(appliedPromoCode);
            if (p && p.discount_type === 'percentage') {
                $cartPromoLabel.text('(' + parseFloat(p.discount_value) + '%)');
            } else if (p) {
                $cartPromoLabel.text('(' + money(p.discount_value) + ')');
            }
        } else {
            $cartPromoRow.addClass('hidden');
        }
        $cartTotalPayment.text(money(totalPayment));

        if (window.lucide) lucide.createIcons();
        const badge = document.getElementById('cartBadge');
        if (badge) {
            badge.textContent = items.length;
            badge.classList.toggle('hidden', items.length === 0);
        }
    }

    async function loadPromotions() {
        try {
            const payload = await jsonRequest(apiBase + '/api/user/rent-car-promotions');
            promotions = payload?.data || payload || [];
        } catch {
        }
    }

    (async () => {
        await loadPromotions();
        renderCart();

        $applyPromoBtn.on('click', applyPromo);
        $promoInput.on('keydown', function (e) {
            if (e.key === 'Enter') { e.preventDefault(); applyPromo(); }
        });

        $('#transaction_ref').on('input', toggleCheckoutBtn);
        $('#payment_image').on('change', toggleCheckoutBtn);
        toggleCheckoutBtn();

        $('#paymentForm').on('submit', async function (e) {
            e.preventDefault();
            const items = JSON.parse(localStorage.getItem('cartItems') || '[]');
            if (!items.length) {
                showToast('Your cart is empty.', true);
                return;
            }

            const formData = new FormData(this);
            formData.append('items', JSON.stringify(items));

            const $btn = $('#checkoutBtn');
            const originalText = $btn.html();
            $btn.prop('disabled', true).html('<span class="inline-block h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent"></span> Processing...');

            try {
                const payload = await jsonRequest(apiBase + '/api/user/cart/checkout', {
                    method: 'POST',
                    body: formData,
                });
                localStorage.removeItem('cartItems');
                showToast('Bookings created successfully!');
                setTimeout(() => window.location.reload(), 1200);
            } catch (err) {
                showToast(err.message || 'Checkout failed. Please try again.', true);
                $btn.prop('disabled', false).html(originalText);
            }
        });

        $page.data('initialized', true);
    })();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="cart-view"]')) initCartPage();
});
