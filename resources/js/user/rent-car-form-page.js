import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function initRentCarFormPage() {
    const $page = $('[data-page="rent-car-form"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const vehicleId = $page.data('vehicle-id');
    if (!vehicleId) return;

    let vehicleData = null;
    let depositData = null;

    const $startDate = $('#start_date');
    const $endDate = $('#end_date');
    const $pickupLocation = $('#pickup_location');
    const $dropoffLocation = $('#dropoff_location');
    const $notes = $('#booking_notes');
    const $startDateError = $('#startDateError');
    const $endDateError = $('#endDateError');
    const $pickupError = $('#pickupLocationError');
    const $dropoffError = $('#dropoffLocationError');
    const $quantityError = $('#quantityError');
    const $driverError = $('#driverError');

    function clearErrors() {
        $startDateError.addClass('hidden').text('');
        $endDateError.addClass('hidden').text('');
        $pickupError.addClass('hidden').text('');
        $dropoffError.addClass('hidden').text('');
        $quantityError.addClass('hidden').text('');
        $driverError.addClass('hidden').text('');
        $startDate.removeClass('border-rose-400');
        $endDate.removeClass('border-rose-400');
        $pickupLocation.removeClass('border-rose-400');
        $dropoffLocation.removeClass('border-rose-400');
        $('#vehicleQuantity').removeClass('border-rose-400');
        $('#includeDriver').closest('label').removeClass('border-rose-400');
    }

    let $firstError = null;

    function showFieldError($el, $errorEl, msg) {
        $el.addClass('border-rose-400');
        $errorEl.text(msg).removeClass('hidden');
        if (!$firstError) $firstError = $el;
    }
    const $confirmBtn = $('#confirmBookingBtn');

    const $displayPickupDate = $('#displayPickupDate');
    const $displayReturnDate = $('#displayReturnDate');
    const $displayPickupLocation = $('#displayPickupLocation');
    const $displayDropoffLocation = $('#displayDropoffLocation');
    const $displayDaysText = $('#displayDaysText');
    const $displaySubtotal = $('#displaySubtotal');
    const $displayDriverRate = $('#displayDriverRate');
    const $displayDeposit = $('#displayDeposit');
    const $displayTotal = $('#displayTotal');
    const $depositRow = $('#depositRow');
    const $driverRateRow = $('#driverRateRow');

    const $vehicleSummary = $('#vehicleSummary');
    const $toast = $('#demoToast');
    const $includeDriver = $('#includeDriver');
    const $qtyDecrease = $('#qtyDecrease');
    const $qtyIncrease = $('#qtyIncrease');

    function showToast(message, isError) {
        $toast.text(message)
            .attr('class', `fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ${isError ? 'bg-rose-600' : 'bg-gradient-to-r from-green-500 to-green-600'}`)
            .removeClass('hidden');
        setTimeout(() => $toast.addClass('hidden'), 3500);
    }

    async function loadData() {
        try {
            const [vPayload, dPayload] = await Promise.all([
                jsonRequest(`${apiBase}/api/user/rent-car/${vehicleId}`),
                jsonRequest(`${apiBase}/api/user/rent-car-deposit`),
            ]);

            vehicleData = vPayload?.data || vPayload;
            depositData = dPayload?.data || dPayload;

            renderVehicleSummary();
            calculateTotal();
        } catch {
            showToast('Failed to load vehicle data.', true);
        }
    }

    function renderVehicleSummary() {
        const v = vehicleData;
        if (!v) return;

        const images = v.images || [];
        const imgUrl = images[0]
            ? (images[0].startsWith('http') ? images[0] : '/storage/' + images[0])
            : 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80';
        const name = (v.brand?.name || '') + ' ' + v.model;
        const category = v.category?.name || 'Standard';
        const specs = [];
        if (v.year) specs.push(v.year);
        if (v.capacity) specs.push(v.capacity + ' seats');
        if (v.color) specs.push(v.color);

        let galleryHtml = '';
        if (images.length > 1) {
            galleryHtml = `<div class="flex gap-2 mt-2">${images.slice(0, 4).map((img, i) => {
                const src = img.startsWith('http') ? img : '/storage/' + img;
                return `<img src="${src}" class="h-14 w-20 rounded object-cover cursor-pointer border-2 border-transparent hover:border-cyan-400 transition" onclick="document.getElementById('mainVehicleImage').src='${src}'" alt="Photo ${i+1}">`;
            }).join('')}</div>`;
        }

        $vehicleSummary.html(`
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="shrink-0">
                    <img id="mainVehicleImage" src="${imgUrl}" class="h-24 w-full sm:w-32 rounded-lg object-cover" alt="${name}">
                    ${galleryHtml}
                </div>
                <div>
                    <span class="inline-block rounded-md bg-cyan-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-cyan-700 mb-1">${category}</span>
                    <h3 class="text-xl font-bold text-slate-900">${name}</h3>
                    <p class="text-sm text-slate-500">${specs.join(' · ')}</p>
                    <div class="mt-1.5 flex items-center gap-3 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            ${v.location || 'Yangon'}
                        </span>
                    </div>
                    <p class="mt-2 text-lg font-black text-cyan-600">${money(v.price_per_day)} / day</p>
                </div>
            </div>
        `);
    }

    let vehicleAvailabilityTimer = null;
    let driverAvailabilityTimer = null;

    async function checkVehicleAvailability() {
        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const quantity = parseInt($('#vehicleQuantity').val()) || 1;

        if (!startDate || !endDate || !vehicleData) {
            $('#vehicleQuantity').removeClass('border-rose-400');
            $quantityError.addClass('hidden').text('');
            return;
        }

        try {
            const payload = await jsonRequest(`${apiBase}/api/user/rent-car/${vehicleData.id}/check-availability`, {
                method: 'POST',
                body: { start_date: startDate, end_date: endDate },
            });
            const result = payload?.data || payload;

            if (quantity > result.available_quantity) {
                $('#vehicleQuantity').addClass('border-rose-400');
                $quantityError.text(`Only ${result.available_quantity} unit${result.available_quantity !== 1 ? 's' : ''} available for these dates.`).removeClass('hidden');
            } else {
                $('#vehicleQuantity').removeClass('border-rose-400');
                $quantityError.addClass('hidden').text('');
            }
        } catch {}
    }

    async function checkDriverAvailability() {
        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const quantity = parseInt($('#vehicleQuantity').val()) || 1;
        const hasDriver = $includeDriver.is(':checked');

        if (!hasDriver || !startDate || !endDate || !vehicleData) {
            $driverError.addClass('hidden').text('');
            $('#includeDriver').closest('label').removeClass('border-rose-400');
            return;
        }

        try {
            const payload = await jsonRequest(`${apiBase}/api/user/rent-car/${vehicleData.id}/check-driver-availability`, {
                method: 'POST',
                body: { start_date: startDate, end_date: endDate, quantity },
            });
            const result = payload?.data || payload;
            if (!result?.available) {
                $driverError.text(`Only ${result?.available_count || 0} qualified driver${result?.available_count !== 1 ? 's' : ''} available for these dates.`).removeClass('hidden');
                $('#includeDriver').closest('label').addClass('border-rose-400');
            } else {
                $driverError.addClass('hidden').text('');
                $('#includeDriver').closest('label').removeClass('border-rose-400');
            }
        } catch {
            $driverError.text('Could not verify driver availability.').removeClass('hidden');
        }
    }

    function calculateTotal() {
        if (!vehicleData) return;

        const pricePerDay = parseFloat(vehicleData.price_per_day);
        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const quantity = parseInt($('#vehicleQuantity').val()) || 1;
        const hasDriver = $includeDriver.is(':checked');

        clearTimeout(vehicleAvailabilityTimer);
        clearTimeout(driverAvailabilityTimer);

        if (startDate && endDate) {
            vehicleAvailabilityTimer = setTimeout(checkVehicleAvailability, 400);
        } else {
            $('#vehicleQuantity').removeClass('border-rose-400');
            $quantityError.addClass('hidden').text('');
        }
        if (hasDriver && startDate && endDate) {
            driverAvailabilityTimer = setTimeout(checkDriverAvailability, 400);
        } else {
            $driverError.addClass('hidden').text('');
            $('#includeDriver').closest('label').removeClass('border-rose-400');
        }

        const pickupLocation = $pickupLocation.val();
        const dropoffLocation = $dropoffLocation.val();

        $displayPickupDate.text(startDate ? new Date(startDate).toLocaleDateString() : '-');
        $displayReturnDate.text(endDate ? new Date(endDate).toLocaleDateString() : '-');
        $displayPickupLocation.text(pickupLocation || '-');
        $displayDropoffLocation.text(dropoffLocation || '-');
        $('#displayQuantity').text(quantity);

        if (!startDate || !endDate) {
            $displaySubtotal.text('MMK 0.00');
            $displayTotal.text('MMK 0.00');
            $displayDaysText.text('0 days');
            $driverRateRow.addClass('hidden');
            $depositRow.addClass('hidden');
            return;
        }

        const days = Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)) + 1);
        $displayDaysText.text(`${days} ${days === 1 ? 'day' : 'days'}`);

        const vehicleSubtotal = pricePerDay * days * quantity;
        const driverPricePerDay = hasDriver ? (parseFloat(vehicleData.driver_license_type_price) || 0) : 0;
        const driverSubtotal = driverPricePerDay * days * quantity;
        const dep = depositData?.deposit;
        const totalDeposit = (dep?.is_active && dep?.amount)
            ? (dep.deposit_type === 'percentage' ? vehicleSubtotal * parseFloat(dep.amount) / 100 : parseFloat(dep.amount) * quantity)
            : 0;
        const grandTotal = vehicleSubtotal + driverSubtotal;

        $displaySubtotal.text(money(vehicleSubtotal));

        if (hasDriver) {
            $driverRateRow.removeClass('hidden');
            $displayDriverRate.text(money(driverSubtotal));
        } else {
            $driverRateRow.addClass('hidden');
        }

        if (totalDeposit > 0) {
            $depositRow.removeClass('hidden');
            $displayDeposit.text(money(totalDeposit));
        } else {
            $depositRow.addClass('hidden');
        }

        $displayTotal.text(money(grandTotal));
    }
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    const maxStart = new Date(today);
    maxStart.setDate(maxStart.getDate() + 30);
    $startDate.val('').attr('min', todayStr).attr('max', maxStart.toISOString().split('T')[0]);

    const maxDate = new Date(today);
    maxDate.setDate(maxDate.getDate() + 364);
    $endDate.val('').attr('max', maxDate.toISOString().split('T')[0]);

    $startDate.on('change', function () {
        clearErrors();
        const startVal = $(this).val();
        if (startVal) {
            const maxEnd = new Date(startVal);
            maxEnd.setDate(maxEnd.getDate() + 364);
            $endDate.attr('min', startVal).attr('max', maxEnd.toISOString().split('T')[0]);
        }
        calculateTotal();
    });
    $endDate.on('change', function () { clearErrors(); calculateTotal(); });
    $pickupLocation.on('change', function () { clearErrors(); calculateTotal(); });
    $dropoffLocation.on('change', function () { clearErrors(); calculateTotal(); });
    $pickupLocation.on('input', function () { clearErrors(); });
    $dropoffLocation.on('input', function () { clearErrors(); });
    $qtyDecrease.on('click', function () {
        const val = parseInt($('#vehicleQuantity').val()) || 1;
        if (val > 1) $('#vehicleQuantity').val(val - 1);
        calculateTotal();
    });
    $qtyIncrease.on('click', function () {
        const val = parseInt($('#vehicleQuantity').val()) || 1;
        if (val < 99) $('#vehicleQuantity').val(val + 1);
        calculateTotal();
    });
    $includeDriver.on('change', calculateTotal);

    $confirmBtn.on('click', async () => {
        if (!vehicleData) return;
        clearErrors();

        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const pickupLocation = $pickupLocation.val();
        const dropoffLocation = $dropoffLocation.val();
        $firstError = null;
        let hasError = false;

        if (!startDate) { showFieldError($startDate, $startDateError, 'Please select a pickup date.'); hasError = true; }
        if (!endDate) { showFieldError($endDate, $endDateError, 'Please select a return date.'); hasError = true; }
        if (!pickupLocation) { showFieldError($pickupLocation, $pickupError, 'Please enter a pickup location.'); hasError = true; }
        if (!dropoffLocation) { showFieldError($dropoffLocation, $dropoffError, 'Please enter a dropoff location.'); hasError = true; }
        const qty = parseInt($('#vehicleQuantity').val()) || 1;
        const hasDriver = $includeDriver.is(':checked');
        if (hasDriver) {
            try {
                const dp = await jsonRequest(`${apiBase}/api/user/rent-car/${vehicleData.id}/check-driver-availability`, {
                    method: 'POST',
                    body: { start_date: startDate, end_date: endDate, quantity: qty },
                });
                const dr = dp?.data || dp;
                if (!dr?.available) {
                    $driverError.text(`Only ${dr?.available_count || 0} qualified driver${dr?.available_count !== 1 ? 's' : ''} available for these dates.`).removeClass('hidden');
                    $('#includeDriver').closest('label').addClass('border-rose-400');
                    hasError = true;
                }
            } catch {
                $driverError.text('Could not verify driver availability.').removeClass('hidden');
                hasError = true;
            }
        }
        if (hasError) { if ($firstError) $('html, body').animate({ scrollTop: $firstError.offset().top - 120 }, 400); return; }

        try {
            const check = await jsonRequest(apiBase + '/api/user/rent-car/' + vehicleData.id + '/check-availability', {
                method: 'POST',
                body: { start_date: startDate, end_date: endDate },
            });
            const result = check?.data || check;
            if (qty > result.available_quantity) {
                $('#vehicleQuantity').addClass('border-rose-400');
                $quantityError.text(`Only ${result.available_quantity} unit${result.available_quantity !== 1 ? 's' : ''} available for these dates.`).removeClass('hidden');
                hasError = true;
            }
            if (hasError) { if ($firstError) $('html, body').animate({ scrollTop: $firstError.offset().top - 120 }, 400); return; }
        } catch {
            showToast('Failed to verify availability. Please try again.', true);
            return;
        }

        const days = Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)) + 1);
        const quantity = parseInt($('#vehicleQuantity').val()) || 1;
        const pricePerDay = parseFloat(vehicleData.price_per_day);
        const vehicleSubtotal = pricePerDay * days * quantity;
        const dep = depositData?.deposit;
        const depositAmount = (dep?.is_active && dep?.amount)
            ? (dep.deposit_type === 'percentage' ? vehicleSubtotal * parseFloat(dep.amount) / 100 : parseFloat(dep.amount) * quantity)
            : 0;
        const images = vehicleData.images || [];
        const imgUrl = images[0]
            ? (images[0].startsWith('http') ? images[0] : '/storage/' + images[0])
            : 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?auto=format&fit=crop&w=600&q=80';
        const item = {
            id: vehicleData.id,
            name: (vehicleData.brand?.name || '') + ' ' + vehicleData.model,
            category: vehicleData.category?.name || 'Standard',
            image: imgUrl,
            specs: [vehicleData.capacity ? vehicleData.capacity + ' seats' : null, vehicleData.color].filter(Boolean).join(' · '),
            vehicle_id: vehicleData.id,
            location: vehicleData.location || null,
            price_per_day: parseFloat(vehicleData.price_per_day) || 0,
            has_driver: hasDriver,
            driver_price_per_day: hasDriver ? (parseFloat(vehicleData.driver_license_type_price) || 0) : 0,
            start_date: startDate,
            end_date: endDate,
            days: days,
            quantity: quantity,
            rental_type: days >= 30 ? 'monthly' : (days >= 7 ? 'weekly' : 'daily'),
            pickup_location: $pickupLocation.val(),
            dropoff_location: $dropoffLocation.val(),
            notes: $notes.val(),
            deposit_amount: depositAmount,
        };
        const cart = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const existing = cart.findIndex(i => i.id === item.id);
        if (existing > -1) {
            showToast('This car is already in your cart.', true);
            return;
        }
        cart.push(item);
        localStorage.setItem('cartItems', JSON.stringify(cart));
        document.dispatchEvent(new Event('cart-updated'));
        showToast(`Added to cart. Total items: ${cart.length}`);
    });

    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('visible');
        });
    }, { threshold: 0.1 });
    fadeElements.forEach(el => observer.observe(el));

    $page.data('initialized', true);
    loadData();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="rent-car-form"]')) initRentCarFormPage();
});
