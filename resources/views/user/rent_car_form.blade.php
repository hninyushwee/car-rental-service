<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1),
                transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>
@endpush

<div class="pt-24 pb-16 bg-slate-50/50 min-h-screen fade-up">
  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-black text-slate-950 tracking-tight">Complete your booking</h1>
    <p class="mt-2 text-slate-500">Review your parameters and confirm your fleet allocation.</p>

    <div class="mt-8 grid gap-8 lg:grid-cols-3">
      {{-- Booking Form --}}
      <div class="lg:col-span-2">
        <form id="bookingForm" class="space-y-6">
          <input type="hidden" name="_token" value="demo">

          {{-- Vehicle summary --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col sm:flex-row gap-4">
              <img src="https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=200&q=80" class="h-24 w-full sm:w-32 rounded-lg object-cover" alt="Tesla Model 3">
              <div>
                <span class="inline-block rounded-md bg-cyan-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-cyan-700 mb-1">Electric Fleet</span>
                <h3 class="text-xl font-bold text-slate-900">Tesla Model 3</h3>
                <p class="text-sm text-slate-500">2023 · Long Range · Automatic Upgrade</p>
                <p class="mt-1 text-lg font-black text-cyan-600">$89 / day</p>
              </div>
            </div>
          </div>

          {{-- Dates & Location --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
              <span class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-100 text-xs text-slate-700">1</span>
              Pickup & Return Schedule
            </h3>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Start date</label>
                <input type="date" id="start_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">End date</label>
                <input type="date" id="end_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Pickup location</label>
                <input type="text" placeholder="City or airport hub" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Dropoff location</label>
                <input type="text" placeholder="Same as pickup (optional)" class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
              </div>
            </div>
          </div>

          {{-- Driver & Rental Type --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
              <span class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-100 text-xs text-slate-700">2</span>
              Driver Preferences & Structural Terms
            </h3>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Chauffeur Service</label>
                <select id="driver_id" class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
                  <option value="">Self-Drive (No Chauffeur)</option>
                  <option value="1">Michael Chen (Premium) - $30/day</option>
                  <option value="2">Sophia Rodriguez (Executive) - $45/day</option>
                  <option value="3">David Kim (Standard) - $25/day</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Rental tier contract</label>
                <select id="rental_type" class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
                  <option value="daily" data-multiplier="1">Daily Plan (Standard)</option>
                  <option value="weekly" data-multiplier="0.9">Weekly Account (10% Discount)</option>
                  <option value="monthly" data-multiplier="0.8">Monthly Account (20% Discount)</option>
                </select>
              </div>
            </div>
          </div>

          {{-- Promo Code --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
              <span class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-100 text-xs text-slate-700">3</span>
              Redeem Promotion Code
            </h3>
            <div class="mt-4 flex gap-3">
              <input type="text" id="promo_code" placeholder="Enter coupon profile" class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 focus:bg-white">
              <button type="button" id="applyPromoBtn" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">Apply</button>
            </div>
            <p class="mt-2 text-xs text-slate-400">Available: <span class="font-semibold text-slate-500">SKYLINE10</span> (10% off fleet value) or <span class="font-semibold text-slate-500">WELCOME20</span> ($20 item deduction).</p>
          </div>

          <button type="button" id="confirmBookingBtn" class="w-full rounded-xl bg-cyan-500 py-3.5 text-md font-bold text-white shadow-xs transition hover:bg-cyan-600 hover:scale-[1.01] active:scale-[0.99]">
            Confirm Fleet Booking
          </button>
        </form>
      </div>

      {{-- Price Summary Sidebar --}}
      <div class="lg:col-span-1">
        <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <h3 class="text-lg font-bold text-slate-900">Price summary</h3>
          
          <div class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-500">Vehicle rental (<span id="displayDaysText">0 days</span>)</span>
              <span id="displaySubtotal" class="font-semibold text-slate-800">$0.00</span>
            </div>
            <div class="flex justify-between">
              <span class="text-slate-500">Driver provisions</span>
              <span id="displayDriverFee" class="font-semibold text-slate-800">$0.00</span>
            </div>
            <div class="flex justify-between text-emerald-600 font-medium">
              <span>Combined Discounts</span>
              <span id="displayDiscount">-$0.00</span>
            </div>
            
            <div class="border-t border-slate-100 pt-3 flex justify-between text-lg font-black text-slate-950">
              <span>Total cost</span>
              <span id="displayTotal">$0.00</span>
            </div>
            <div class="rounded-xl bg-slate-50 p-3 text-[11px] text-slate-400 leading-relaxed border border-slate-100 mt-2">
              Includes full programmatic verification and operational tax metrics. Cancellation terms protect adjustments up to 24 hours prior.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Toast Component --}}
<div id="demoToast" class="fixed bottom-5 right-5 z-50 hidden translate-y-0 transform rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300"></div>

@push('scripts')
<script>
  const vehiclePricePerDay = 89;
  let appliedPromo = null;

  const driverPrices = {
    '1': 30,
    '2': 45,
    '3': 25
  };

  function calculateTotal() {
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const rentalTypeSelect = document.getElementById('rental_type');
    const multiplier = parseFloat(rentalTypeSelect.options[rentalTypeSelect.selectedIndex]?.dataset?.multiplier || 1);
    const driverId = document.getElementById('driver_id').value;

    if (!startDate || !endDate) {
      document.getElementById('displaySubtotal').innerText = '$0.00';
      document.getElementById('displayDriverFee').innerText = '$0.00';
      document.getElementById('displayDiscount').innerText = '-$0.00';
      document.getElementById('displayTotal').innerText = '$0.00';
      document.getElementById('displayDaysText').innerText = '0 days';
      return;
    }

    // Days structural engine logic calculation
    const days = Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24)));
    document.getElementById('displayDaysText').innerText = `${days} ${days === 1 ? 'day' : 'days'}`;

    // Fix 1: Calculate cumulative driver cost scaled directly by rental days
    const dailyDriverRate = driverId && driverPrices[driverId] ? driverPrices[driverId] : 0;
    const totalDriverFee = dailyDriverRate * days;

    // Fix 2: Calculate clean baseline subtotal vs systemic modifiers
    const rawVehicleSubtotal = vehiclePricePerDay * days;
    const tierDiscountValue = rawVehicleSubtotal * (1 - multiplier);
    const modifiedVehicleCost = rawVehicleSubtotal - tierDiscountValue;

    let promoDiscountValue = 0;
    if (appliedPromo) {
      if (appliedPromo.type === 'percentage') {
        promoDiscountValue = modifiedVehicleCost * (appliedPromo.value / 100);
      } else if (appliedPromo.type === 'fixed') {
        promoDiscountValue = appliedPromo.value;
      }
      // Check for structural min spend constraints
      if (appliedPromo.minSpend && modifiedVehicleCost < appliedPromo.minSpend) {
        promoDiscountValue = 0;
      }
    }

    // Accumulate structural modifiers into UI displays cleanly
    const totalDiscountsCumulative = tierDiscountValue + promoDiscountValue;
    const totalCostSummary = modifiedVehicleCost + totalDriverFee - promoDiscountValue;

    document.getElementById('displaySubtotal').innerText = '$' + rawVehicleSubtotal.toFixed(2);
    document.getElementById('displayDriverFee').innerText = '$' + totalDriverFee.toFixed(2);
    document.getElementById('displayDiscount').innerText = '-$' + totalDiscountsCumulative.toFixed(2);
    document.getElementById('displayTotal').innerText = '$' + Math.max(0, totalCostSummary).toFixed(2);
  }

  function applyPromo() {
    const code = document.getElementById('promo_code').value.trim().toUpperCase();
    if (code === 'SKYLINE10') {
      appliedPromo = { type: 'percentage', value: 10, minSpend: 0 };
      showToast('Promo validated: 10% Vehicle Deduction applied.');
    } else if (code === 'WELCOME20') {
      appliedPromo = { type: 'fixed', value: 20, minSpend: 100 };
      showToast('Promo validated: $20.00 credit added to tracking matrix.');
    } else if (code === '') {
      appliedPromo = null;
      showToast('Promotion cleared.');
    } else {
      appliedPromo = null;
      showToast('Specified promotion token is invalid or expired.', true);
    }
    calculateTotal();
  }

  function showToast(message, isError = false) {
    const toast = document.getElementById('demoToast');
    toast.textContent = message;
    toast.className = `fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ${isError ? 'bg-rose-600' : 'bg-slate-900'}`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3500);
  }

  // Handle initialization timing
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  const end = new Date(today);
  end.setDate(end.getDate() + 4);
  
  document.getElementById('start_date').value = tomorrow.toISOString().split('T')[0];
  document.getElementById('end_date').value = end.toISOString().split('T')[0];

  document.getElementById('start_date').addEventListener('change', calculateTotal);
  document.getElementById('end_date').addEventListener('change', calculateTotal);
  document.getElementById('rental_type').addEventListener('change', calculateTotal);
  document.getElementById('driver_id').addEventListener('change', calculateTotal);
  document.getElementById('applyPromoBtn').addEventListener('click', applyPromo);
  
  document.getElementById('confirmBookingBtn').addEventListener('click', () => {
    const total = document.getElementById('displayTotal').innerText;
    showToast(`Success: Allocation complete. Final tracking index at ${total}.`, false);
  });

  calculateTotal();

  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));
</script>
@endpush

</x-user.layout>