import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function initRentDriverFormPage() {
    const $page = $('[data-page="rent-driver-form"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const licenseTypeId = $page.data('license-type-id');
    if (!licenseTypeId) return;

    let licenseTypeData = null;
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
    const $driverError = $('#driverAvailabilityError');
    const $driverQty = $('#driverQty');
    const $qtyDecrease = $('#qtyDecrease');
    const $qtyIncrease = $('#qtyIncrease');
    const $displayQty = $('#displayQty');

    const $licenseTypeImg = $('#licenseTypeImg');
    const $licenseTypeName = $('#licenseTypeName');
    const $licenseTypeDesc = $('#licenseTypeDesc');
    const $licenseTypePrice = $('#licenseTypePrice');

    function clearErrors() {
        $startDateError.addClass('hidden').text('');
        $endDateError.addClass('hidden').text('');
        $pickupError.addClass('hidden').text('');
        $dropoffError.addClass('hidden').text('');
        $driverError.addClass('hidden').text('');
        $startDate.removeClass('border-rose-400');
        $endDate.removeClass('border-rose-400');
        $pickupLocation.removeClass('border-rose-400');
        $dropoffLocation.removeClass('border-rose-400');
    }

    function showFieldError($el, $errorEl, msg) {
        $el.addClass('border-rose-400');
        $errorEl.text(msg).removeClass('hidden');
    }

    const $confirmBtn = $('#confirmHireBtn');
    const $displayStartDate = $('#displayStartDate');
    const $displayEndDate = $('#displayEndDate');
    const $displayPickupLocation = $('#displayPickupLocation');
    const $displayDropoffLocation = $('#displayDropoffLocation');
    const $displayDaysText = $('#displayDaysText');
    const $displaySubtotal = $('#displaySubtotal');
    const $displayDeposit = $('#displayDeposit');
    const $displayTotal = $('#displayTotal');
    const $depositRow = $('#depositRow');
    const $toast = $('#demoToast');

    function showToast(message, isError) {
        $toast.text(message)
            .attr('class', `fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ${isError ? 'bg-rose-600' : 'bg-gradient-to-r from-green-500 to-green-600'}`)
            .removeClass('hidden');
        setTimeout(() => $toast.addClass('hidden'), 3500);
    }

    let availabilityTimer = null;

    async function checkDriverAvailability() {
        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const quantity = parseInt($driverQty.val()) || 1;

        if (!startDate || !endDate || !licenseTypeData) {
            $driverError.addClass('hidden').text('');
            return;
        }

        try {
            const payload = await jsonRequest(`${apiBase}/api/user/driving-license-types/${licenseTypeId}/check-availability`, {
                method: 'POST',
                body: { start_date: startDate, end_date: endDate, quantity: quantity },
            });
            const result = payload?.data || payload;
            const remaining = result?.available_count ?? 0;
            if (remaining < quantity) {
                $driverError.text(`Only ${remaining} of ${result.total_drivers ?? 0} drivers available for these dates.`).removeClass('hidden');
            } else {
                $driverError.addClass('hidden').text('');
            }
        } catch {
            $driverError.addClass('hidden').text('');
        }
    }

    function renderLicenseTypeSummary() {
        const lt = licenseTypeData;
        if (!lt) return;

        const imgUrl = lt.image
            ? (lt.image.startsWith('http') ? lt.image : '/storage/' + lt.image)
            : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80';

        $licenseTypeImg.attr('src', imgUrl);
        $licenseTypeName.text(lt.type || 'License Type');
        $licenseTypeDesc.text('Professional driver service');
        $licenseTypePrice.html(money(lt.price || 0) + ' <span class="text-xs font-medium text-slate-400">/day</span>');
    }

    function renderDeposit() {
        const dep = depositData?.deposit;
        if (dep?.is_active && dep?.amount) {
            $displayDeposit.text(money(dep.amount));
            $depositRow.removeClass('hidden');
        } else {
            $depositRow.addClass('hidden');
        }
    }

    function calculateTotal() {
        const pricePerDay = licenseTypeData ? parseFloat(licenseTypeData.price || 0) : 0;
        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const quantity = parseInt($driverQty.val()) || 1;

        $displayStartDate.text(startDate ? new Date(startDate).toLocaleDateString() : '-');
        $displayEndDate.text(endDate ? new Date(endDate).toLocaleDateString() : '-');
        $displayPickupLocation.text($pickupLocation.val() || '-');
        $displayDropoffLocation.text($dropoffLocation.val() || '-');
        $displayQty.text(quantity);

        clearTimeout(availabilityTimer);
        if (startDate && endDate) {
            availabilityTimer = setTimeout(checkDriverAvailability, 400);
        } else {
            $driverError.addClass('hidden').text('');
        }

        if (!startDate || !endDate) {
            $displaySubtotal.text('MMK 0.00');
            $displayTotal.text('MMK 0.00');
            $displayDaysText.text('0 days');
            return;
        }

        const days = Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)) + 1);
        $displayDaysText.text(`${days} ${days === 1 ? 'day' : 'days'}`);

        const rawSubtotal = pricePerDay * days * quantity;
        $displaySubtotal.text(money(rawSubtotal));
        $displayTotal.text(money(rawSubtotal));
    }

    async function loadLicenseType() {
        try {
            const payload = await jsonRequest(`${apiBase}/api/user/driving-license-types/${licenseTypeId}`);
            licenseTypeData = payload?.data || payload;
            renderLicenseTypeSummary();
        } catch {
            showToast('Failed to load license type data.', true);
        }
    }

    async function loadData() {
        try {
            const depPayload = await jsonRequest(`${apiBase}/api/user/rent-car-deposit?service=driver_service`);
            depositData = depPayload?.data || depPayload;
            renderDeposit();

            await loadLicenseType();
        } catch {
            showToast('Failed to load data.', true);
        }
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
        const val = parseInt($driverQty.val()) || 1;
        if (val > 1) $driverQty.val(val - 1);
        calculateTotal();
    });
    $qtyIncrease.on('click', function () {
        const val = parseInt($driverQty.val()) || 1;
        if (val < 99) $driverQty.val(val + 1);
        calculateTotal();
    });

    $confirmBtn.on('click', async () => {
        clearErrors();

        const startDate = $startDate.val();
        const endDate = $endDate.val();
        const pickupLocation = $pickupLocation.val();
        const dropoffLocation = $dropoffLocation.val();
        const quantity = parseInt($driverQty.val()) || 1;
        let hasError = false;

        if (!startDate) { showFieldError($startDate, $startDateError, 'Please select a start date.'); hasError = true; }
        if (!endDate) { showFieldError($endDate, $endDateError, 'Please select an end date.'); hasError = true; }
        if (!pickupLocation) { showFieldError($pickupLocation, $pickupError, 'Please enter a pickup location.'); hasError = true; }
        if (!dropoffLocation) { showFieldError($dropoffLocation, $dropoffError, 'Please enter a dropoff location.'); hasError = true; }
        if (hasError) return;

        // Re-check driver availability before adding to cart
        try {
            const payload = await jsonRequest(`${apiBase}/api/user/driving-license-types/${licenseTypeId}/check-availability`, {
                method: 'POST',
                body: { start_date: startDate, end_date: endDate, quantity: quantity },
            });
            const result = payload?.data || payload;
            const remaining = result?.available_count ?? 0;
            if (remaining < quantity) {
                $driverError.text(`Only ${remaining} of ${result.total_drivers ?? 0} drivers available for these dates.`).removeClass('hidden');
                return;
            }
        } catch {
            showToast('Failed to verify driver availability. Please try again.', true);
            return;
        }

        const days = Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)) + 1);
        const pricePerDay = licenseTypeData ? parseFloat(licenseTypeData.price || 0) : 0;
        const driverServiceTotal = pricePerDay * days * quantity;
        const dep = depositData?.deposit;
        const depositAmount = (dep?.is_active && dep?.amount)
            ? (dep.deposit_type === 'percentage' ? driverServiceTotal * parseFloat(dep.amount) / 100 : parseFloat(dep.amount))
            : 0;
        const imgUrl = licenseTypeData?.image
            ? (licenseTypeData.image.startsWith('http') ? licenseTypeData.image : '/storage/' + licenseTypeData.image)
            : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80';

        const item = {
            type: 'driver',
            id: 0,
            license_type_id: licenseTypeId,
            name: (licenseTypeData?.type || 'Driver') + ' Service',
            image: imgUrl,
            license_type: licenseTypeData?.type || '',
            price_per_day: pricePerDay,
            quantity: quantity,
            start_date: startDate,
            end_date: endDate,
            days: days,
            pickup_location: pickupLocation,
            dropoff_location: dropoffLocation,
            notes: $notes.val(),
            deposit_amount: depositAmount,
        };

        const cart = JSON.parse(localStorage.getItem('cartItems') || '[]');
        const existing = cart.findIndex(i => i.type === 'driver' && i.license_type_id === licenseTypeId);
        if (existing > -1) {
            showToast('This license type is already in your cart.', true);
            return;
        }
        cart.push(item);
        localStorage.setItem('cartItems', JSON.stringify(cart));
        document.dispatchEvent(new Event('cart-updated'));
        showToast('Driver service added to cart.');
    });

    $page.data('initialized', true);
    loadData();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="rent-driver-form"]')) initRentDriverFormPage();
});
