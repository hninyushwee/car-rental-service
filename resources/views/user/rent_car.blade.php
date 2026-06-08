{{-- Only for authenticated users – no hero, no footer, no CTA --}}
<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }
  /* Slide-out Panel Effects */
  .slide-panel {
    transform: translateX(100%);
    transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .slide-panel.open {
    transform: translateX(0);
  }
  /* Custom Scrollbar for Luxury Panel */
  .custom-scroll::-webkit-scrollbar {
    width: 6px;
  }
  .custom-scroll::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 3px;
  }
</style>
@endpush

<div class="relative min-h-screen bg-slate-50/50 pt-24 pb-16 fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    
    {{-- Header Content --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-4">
      <div>
        <h1 class="text-4xl font-black tracking-tight text-slate-900">Premium Fleet</h1>
        <p class="mt-2 text-sm text-slate-500">Book standalone vehicles or verified professional driver services instantly.</p>
      </div>
      <div class="text-sm font-semibold text-slate-500 bg-slate-100 px-4 py-2 rounded-full border border-slate-200">
        ⚡ 12 Premium Vehicles Available
      </div>
    </div>

    {{-- Modern Airbnb-Style Search Bar --}}
    <div class="mb-10 rounded-2xl bg-white p-4 shadow-xl shadow-slate-100 border border-slate-200/60">
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="border-r border-slate-100 pr-2">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">📍 Pickup Location</label>
          <div class="relative">
            <i data-lucide="map-pin" class="absolute left-0 top-1/2 h-4 w-4 -translate-y-1/2 text-cyan-500"></i>
            <input type="text" id="search-location" value="Yangon, Downtown" class="w-full bg-transparent py-1 pl-6 text-sm font-bold text-slate-800 focus:outline-none">
          </div>
        </div>
        <div class="border-r border-slate-100 pr-2">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">📅 Pickup Date</label>
          <div class="relative">
            <i data-lucide="calendar-range" class="absolute left-0 top-1/2 h-4 w-4 -translate-y-1/2 text-cyan-500"></i>
            <input type="date" id="search-start-date" class="w-full bg-transparent py-1 pl-6 text-sm font-bold text-slate-800 focus:outline-none">
          </div>
        </div>
        <div class="border-r border-slate-100 pr-2">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">📅 Return Date</label>
          <div class="relative">
            <i data-lucide="calendar-days" class="absolute left-0 top-1/2 h-4 w-4 -translate-y-1/2 text-cyan-500"></i>
            <input type="date" id="search-end-date" class="w-full bg-transparent py-1 pl-6 text-sm font-bold text-slate-800 focus:outline-none">
          </div>
        </div>
        <div class="flex items-center">
          <button class="w-full rounded-xl bg-slate-950 py-3 text-sm font-bold text-white shadow-lg shadow-slate-950/20 transition-all hover:bg-slate-800 active:scale-98">
            Update Search
          </button>
        </div>
      </div>
    </div>

    {{-- Filter Categories Row --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-5">
      <div class="flex flex-wrap gap-2">
        <button class="rounded-xl bg-slate-950 px-4 py-2 text-xs font-bold text-white shadow-md shadow-slate-950/10">All Fleet</button>
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:border-cyan-400 hover:bg-cyan-50/30 transition-colors">SUV</button>
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:border-cyan-400 hover:bg-cyan-50/30 transition-colors">Luxury Sedan</button>
        <button class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-bold text-slate-600 hover:border-cyan-400 hover:bg-cyan-50/30 transition-colors">Electric (EV)</button>
      </div>
      <div class="flex items-center gap-2">
        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Sort by</span>
        <select class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-bold text-slate-700 focus:border-cyan-400 focus:outline-none">
          <option>Price: Low to High</option>
          <option>Price: High to Low</option>
          <option>Top Rated ⭐</option>
        </select>
      </div>
    </div>

    {{-- Fleet Grid --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
      @php
        $cars = [
          ['id' => 1, 'name' => 'Tesla Model 3', 'type' => 'Electric', 'price' => 89, 'rating' => 4.9, 'img' => 'https://images.unsplash.com/photo-1606664515524-ed2f786a0bd6?auto=format&fit=crop&w=600&q=80', 'transmission' => 'Auto', 'seats' => 5, 'fuel' => 'EV'],
          ['id' => 2, 'name' => 'BMW X5 M-Sport', 'type' => 'SUV', 'price' => 142, 'rating' => 4.8, 'img' => 'https://images.unsplash.com/photo-1617814076668-7772a3f5036a?auto=format&fit=crop&w=600&q=80', 'transmission' => 'Auto', 'seats' => 7, 'fuel' => 'Diesel'],
          ['id' => 3, 'name' => 'Mercedes C-Class', 'type' => 'Luxury', 'price' => 118, 'rating' => 4.7, 'img' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=600&q=80', 'transmission' => 'Auto', 'seats' => 5, 'fuel' => 'Petrol'],
        ];
      @endphp

      @foreach($cars as $car)
      <div class="group rounded-2xl border border-slate-200/70 bg-white shadow-sm transition-all duration-300 hover:shadow-xl hover:border-cyan-200">
        <div class="relative overflow-hidden rounded-t-2xl bg-slate-100">
          <img class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $car['img'] }}" alt="{{ $car['name'] }}" />
          <div class="absolute left-3 top-3 rounded-xl bg-white/90 px-2.5 py-1 text-xs font-bold text-slate-800 shadow-sm backdrop-blur-sm flex items-center gap-1">
            ⭐ <span>{{ $car['rating'] }}</span>
          </div>
        </div>
        <div class="p-5">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-bold uppercase tracking-widest text-cyan-600">{{ $car['type'] }}</span>
            <p class="text-xl font-black text-slate-900">${{ $car['price'] }}<span class="text-xs font-medium text-slate-400">/day</span></p>
          </div>
          <h3 class="text-lg font-bold text-slate-900 mb-4">{{ $car['name'] }}</h3>
          
          <div class="grid grid-cols-3 gap-2 border-t border-b border-slate-100 py-3 text-xs text-slate-500 font-medium">
            <div class="flex items-center gap-1"><i data-lucide="gauge" class="h-3.5 w-3.5 text-slate-400"></i>{{ $car['transmission'] }}</div>
            <div class="flex items-center gap-1"><i data-lucide="users" class="h-3.5 w-3.5 text-slate-400"></i>{{ $car['seats'] }} Seats</div>
            <div class="flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5 text-slate-400"></i>{{ $car['fuel'] }}</div>
          </div>

          <div class="mt-4">
            <button onclick="openBookingPanel({{ json_encode($car) }})" class="w-full rounded-xl bg-cyan-400 py-3 text-xs font-black uppercase tracking-wider text-slate-950 shadow-md shadow-cyan-400/10 transition-all hover:bg-cyan-300 hover:shadow-lg active:scale-98">
              Rent Now
            </button>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

{{-- ========================================== --}}
  {{-- CENTER FLOATING CARD PANEL (SLIDE FROM RIGHT TO CENTER, AUTO-HEIGHT) --}}
  {{-- ========================================== --}}
  <div id="booking-drawer-overlay" class="fixed inset-0 z-40 hidden bg-slate-950/40 backdrop-blur-sm transition-opacity duration-300"></div>

  <div id="booking-drawer" class="slide-panel fixed top-1/2 z-50 w-full max-w-sm h-auto rounded bg-white shadow-2xl border border-slate-200/80 flex flex-col overflow-hidden transition-all duration-300 ease-out"
       style="right: -100%; transform: translateY(-50%);">
    
    {{-- Panel Header --}}
    <div class="px-5 py-3.5 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white flex-shrink-0">
      <div>
        <h2 id="drawer-car-name" class="text-base font-black">Car Details</h2>
        <p id="drawer-car-type" class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider"></p>
      </div>
      <button onclick="closeBookingPanel()" class="rounded-lg p-1 hover:bg-white/10 transition-colors">
        <i data-lucide="x" class="h-4 w-4"></i>
      </button>
    </div>

    {{-- Main Content Container (Auto-Height Gaps) --}}
    <div class="p-4 bg-slate-50/40 space-y-3">
      
      {{-- Car Preview Image --}}
      <img id="drawer-car-img" class="h-28 w-full object-cover rounded-2xl shadow-inner bg-slate-100" src="" alt="Selected Car">
      
      {{-- Form Section: Location + Driver --}}
      <div class="space-y-2">
        <div>
          <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">📍 Delivery Location</label>
          <input type="text" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-800 focus:outline-none focus:border-cyan-400 shadow-sm" value="Yangon, Downtown">
        </div>
        
        {{-- Professional Driver Switch --}}
        <div class="rounded-xl border border-slate-200 bg-white p-2 flex items-center justify-between shadow-sm">
          <div class="flex items-center gap-2">
            <div class="p-1.5 bg-cyan-100 rounded-lg text-cyan-700"><i data-lucide="user-check" class="h-3.5 w-3.5"></i></div>
            <div>
              <p class="text-xs font-bold text-slate-800">Add Professional Driver</p>
              <p class="text-[9px] text-slate-400">Verified Chauffeur (+ $25/day)</p>
            </div>
          </div>
          <input type="checkbox" id="driver-toggle" onchange="calculateLiveBill()" class="w-4 h-4 text-cyan-500 rounded border-slate-300 focus:ring-cyan-400">
        </div>
      </div>

      {{-- INTEGRATED BILLING & PROMO CARD --}}
      <div class="rounded-2xl border border-cyan-100 bg-white p-3.5 space-y-3.5 shadow-sm">
        
        {{-- Top Part: Vehicle Subtotal & Coupon Input --}}
        <div class="space-y-2.5">
          {{-- Price Line Items --}}
          <div class="space-y-1 text-xs font-medium text-slate-500 pb-2 border-b border-slate-100">
            <div class="flex justify-between">
              <span>Vehicle Subtotal (3 Days)</span>
              <span id="bill-car-subtotal" class="text-slate-800 font-bold">$0.00</span>
            </div>
            <div class="flex justify-between">
              <span>Chauffeur Service</span>
              <span id="bill-driver-subtotal" class="text-slate-800 font-bold">$0.00</span>
            </div>
            <div id="bill-discount-row" class="justify-between text-emerald-600 font-bold hidden">
              <span>Promo Discount</span>
              <span id="bill-discount-amount">-$0.00</span>
            </div>
          </div>

          {{-- Coupon Input Box --}}
          <div>
            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">🎟️ Promo Code</label>
            <div class="flex gap-1.5">
              <input type="text" id="promo-input" placeholder="Coupon code" class="flex-1 rounded-xl border border-slate-200 bg-slate-50 px-3 py-1 text-xs font-semibold uppercase tracking-wider focus:outline-none focus:border-cyan-400">
              <button onclick="applyPromoCode()" class="rounded-xl bg-slate-950 px-3 py-1 text-xs font-bold text-white hover:bg-slate-800 transition-colors shadow-sm">Apply</button>
            </div>
            <p id="promo-msg" class="text-[10px] mt-0.5 font-semibold hidden"></p>
          </div>
        </div>

        {{-- Bottom Part: Grand Total & Checkout Action Button Locked Together --}}
        <div class="pt-2.5 border-t border-slate-100 space-y-2">
          <div class="flex items-end justify-between">
            <div>
              <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Amount</p>
              <p id="bill-total-price" class="text-xl font-black text-cyan-600 tracking-tight">$0.00</p>
            </div>
            <div class="text-[9px] font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
              Net Price
            </div>
          </div>

          {{-- Action Confirm Button (Always Visible) --}}
          <button onclick="openPaymentModal()" class="w-full rounded-xl bg-cyan-400 py-2.5 text-xs font-black uppercase tracking-widest text-slate-950 shadow-md shadow-cyan-400/10 transition-all hover:bg-cyan-300 active:scale-98">
            Confirm & Checkout →
          </button>
        </div>

      </div>
    </div>
  </div>

{{-- ========================================== --}}
  {{-- DYNAMIC QR CODE & GATEWAY POP-UP MODAL (COMPACT) --}}
  {{-- ========================================== --}}
  <div id="payment-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4 backdrop-blur-sm">
    <div class="w-full max-w-xs rounded-2xl bg-white p-5 shadow-2xl border border-slate-100 text-center relative">
      <button onclick="closePaymentModal()" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
        <i data-lucide="x" class="h-4 w-4"></i>
      </button>
      
      <h3 class="text-lg font-black text-slate-900 mt-2">Scan & Pay Securely</h3>
      <p class="text-[11px] text-slate-400 mt-0.5">Authorize payment within <span id="timer" class="font-bold text-red-500">05:00</span> mins</p>

      {{-- Compact QR Box --}}
      <div class="my-4 inline-block rounded-xl bg-slate-50 p-3 border border-slate-200 shadow-inner relative">
        <img class="h-36 w-36 mix-blend-multiply" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=KBZPay-Mock-Transaction" alt="Payment QR Code">
        <div class="absolute bottom-0.5 left-1/2 -translate-x-1/2 bg-white px-1.5 py-0.2 rounded text-[8px] font-black tracking-widest text-slate-800 border shadow-xs">K PAY</div>
      </div>

      {{-- Compact Price Summary --}}
      <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100 mb-4 flex justify-between items-center px-3">
        <div class="text-left">
          <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">Total Pay</p>
          <p id="modal-pay-amount" class="text-base font-black text-slate-900">$0.00</p>
        </div>
        <span class="text-[10px] bg-cyan-100 text-cyan-700 px-2 py-0.5 rounded-md font-bold">BK-2026</span>
      </div>

      <button onclick="executeFinalBooking()" class="w-full rounded-xl bg-cyan-400 py-2.5 text-xs font-black uppercase tracking-wider text-slate-950 transition-all hover:bg-cyan-300 shadow-md shadow-cyan-400/15">
        Confirm Payment
      </button>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let selectedCar = null;
  let activeDiscount = 0;
  let countdownTimer = null;

  document.addEventListener('DOMContentLoaded', function() {
    // Reveal Fade Effect
    const fadeElements = document.querySelectorAll('.fade-up');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) entry.target.classList.add('visible');
      });
    }, { threshold: 0.1 });
    fadeElements.forEach(el => observer.observe(el));
    
    // Set Mock search dates
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('search-start-date').value = today;
  });

 function openBookingPanel(carData) {
    const drawer = document.getElementById("booking-drawer");
    const overlay = document.getElementById("booking-drawer-overlay");
    if (!drawer) return;

    // 1. နောက်ခံကို မှောင်ချပေးခြင်း
    overlay.classList.remove("hidden");
    
    // 2. ညာဘက်အပြင်ကနေ စခရင်ရဲ့ အလယ်ဗဟို (Center) ဆီသို့ Slide ထိုးဝင်လာစေခြင်း
    // inline style ကို သုံးပြီး နေရာချထားမှုကို ပေါင်းစပ်ထိန်းချုပ်ပါမည်။
    drawer.style.right = "50%";
    drawer.style.transform = "translate(50%, -50%)";
}

function closeBookingPanel() {
    const drawer = document.getElementById("booking-drawer");
    const overlay = document.getElementById("booking-drawer-overlay");
    if (!drawer) return;

    // 1. ကတ်ပြားကို ညာဘက်အပြင်ဘက်သို့ ပြန်လည်တွန်းထုတ်ခြင်း
    drawer.style.right = "-100%";
    drawer.style.transform = "translate(0%, -50%)";

    // 2. နောက်ခံအမှောင်ကို ပြန်ဖျောက်ခြင်း
    setTimeout(() => {
        overlay.classList.add("hidden");
    }, 200); // 0.2s transition အပြီးမှ hidden လုပ်မည်
}

  function calculateLiveBill() {
    if (!selectedCar) return;
    
    const days = 3; // Mocking 3 days trip
    const carSubtotal = selectedCar.price * days;
    const isDriverAdded = document.getElementById('driver-toggle').checked;
    const driverSubtotal = isDriverAdded ? (25 * days) : 0;
    const totalBeforePromo = carSubtotal + driverSubtotal;
    const grandTotal = totalBeforePromo - activeDiscount;

    // Update Text UI
    document.getElementById('bill-car-subtotal').innerText = `$${carSubtotal.toFixed(2)}`;
    document.getElementById('bill-driver-subtotal').innerText = `$${driverSubtotal.toFixed(2)}`;
    document.getElementById('bill-total-price').innerText = `$${grandTotal.toFixed(2)}`;
  }

  function applyPromoCode() {
    const code = document.getElementById('promo-input').value.trim().toUpperCase();
    const msgEl = document.getElementById('promo-msg');
    
    if (code === 'PROMO2026') {
      activeDiscount = 20; // $20 Flat discount
      msgEl.className = "text-xs mt-1 text-emerald-600 font-bold";
      msgEl.innerText = "🎉 Promo Code Applied Successfully! ($20 Off)";
      
      document.getElementById('bill-discount-amount').innerText = `-$${activeDiscount.toFixed(2)}`;
      document.getElementById('bill-discount-row').classList.remove('hidden');
    } else {
      activeDiscount = 0;
      msgEl.className = "text-xs mt-1 text-red-500 font-bold";
      msgEl.innerText = "❌ Invalid or Expired coupon code.";
      document.getElementById('bill-discount-row').classList.add('hidden');
    }
    msgEl.classList.remove('hidden');
    calculateLiveBill();
  }

  function openPaymentModal() {
    const totalBill = document.getElementById('bill-total-price').innerText;
    document.getElementById('modal-pay-amount').innerText = totalBill;
    
    const modal = document.getElementById('payment-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    startTimer(300); // 5 mins
  }

  function closePaymentModal() {
    const modal = document.getElementById('payment-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    clearInterval(countdownTimer);
  }

  function startTimer(duration) {
    let timer = duration, minutes, seconds;
    const display = document.getElementById('timer');
    clearInterval(countdownTimer);
    
    countdownTimer = setInterval(function () {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.textContent = minutes + ":" + seconds;

      if (--timer < 0) {
        clearInterval(countdownTimer);
        alert('Payment Window Expired! Please Try Again.');
        closePaymentModal();
      }
    }, 1000);
  }

  function executeFinalBooking() {
    clearInterval(countdownTimer);
    alert('🚀 Booking Successful! Your car and driver are locked for the trip.');
    window.location.reload();
  }
</script>
@endpush

</x-user.layout>