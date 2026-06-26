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
    
    {{-- Header Banner Section --}}
    <div class="mb-8">
      <h1 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">Complete Booking</h1>
      <p class="mt-2 text-sm text-slate-500">Provide final schedule operational parameters below to complete your dispatch.</p>
    </div>

    <div class="grid gap-8 lg:grid-cols-3 items-start">
      {{-- Booking Execution Form --}}
      <div class="lg:col-span-2">
        <form id="hireForm" class="space-y-6">
          <input type="hidden" name="_token" value="demo">

          {{-- Selected Active Chauffeur Block --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs">
            <div class="flex items-center gap-5">
              <img id="driverImg" src="" class="h-20 w-20 rounded-xl object-cover border border-slate-100 shadow-xs" alt="Chauffeur profile">
              <div>
                <span class="inline-block rounded-md bg-cyan-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-cyan-700 mb-1">Assigned Unit</span>
                <h3 id="driverName" class="text-xl font-bold tracking-tight text-slate-900">Loading...</h3>
                <p id="driverType" class="text-xs text-slate-500 font-medium"></p>
                <p id="driverPrice" class="mt-1 text-sm font-bold text-slate-900"></p>
              </div>
            </div>
          </div>

          {{-- Operational Windows & Location --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs">
            <h3 class="text-md font-bold text-slate-900 uppercase tracking-wider text-xs text-slate-400 mb-4">Scheduling Metrics</h3>
            <div class="grid gap-4 sm:grid-cols-2">
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Start Date</label>
                <input type="date" id="start_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-50/50 focus:bg-white focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 transition">
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">End Date</label>
                <input type="date" id="end_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-50/50 focus:bg-white focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 transition">
              </div>
              <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Primary Pickup Destination</label>
                <input type="text" placeholder="Specify hotel lobby, airport terminal code, or residence address" required class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-700 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 transition placeholder:text-slate-400">
              </div>
            </div>
          </div>

          {{-- Operations Addendum --}}
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Operational Addendum (Optional)</h3>
            <textarea rows="3" placeholder="Specify custom child seat configurations, complex multi-stop routes, or specialized security requirements..." class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-700 focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 transition placeholder:text-slate-400"></textarea>
          </div>

          <button type="submit" id="confirmHireBtn" class="w-full rounded-xl bg-slate-900 py-3.5 text-sm font-bold text-white shadow-xs transition hover:bg-slate-800">
            Confirm Verification & Request Chauffeur
          </button>
        </form>
      </div>

      {{-- Price Aggregation Sticky Panel --}}
      <div class="lg:col-span-1">
        <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
          <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100">Billing Profile</h3>
          <div class="mt-4 space-y-3 text-sm">
            <div class="flex justify-between items-center">
              <span class="text-slate-500 font-medium">Base Contract Daily Rate</span>
              <span id="dailyRate" class="font-bold text-slate-900">$0.00</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-slate-500 font-medium">Service Window Runtime</span>
              <span id="daysCount" class="font-bold text-slate-900">0 days</span>
            </div>
            
            <div class="border-t border-slate-100 pt-4 mt-2 flex justify-between items-baseline">
              <span class="text-base font-bold text-slate-900">Total Valuation</span>
              <div class="text-right">
                <span id="totalPrice" class="text-2xl font-black text-slate-950">$0.00</span>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">VAT, luxury assessments, & insurance covered.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Notification Toast Layer --}}
<div id="demoToast" class="fixed bottom-5 right-5 hidden z-50 rounded-xl bg-slate-900 text-white p-4 shadow-xl text-xs font-semibold max-w-sm tracking-wide animate-in fade-in slide-in-from-bottom-5 duration-300"></div>

@push('scripts')
<script>
  // Runtime Chauffeur Parameter Store
  const driver = {
    id: 1,
    name: 'Michael Chen',
    type: 'Luxury Sedan Specialist',
    price: 89.00,
    img: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80'
  };

  // Static Elements Assignment
  document.getElementById('driverName').innerText = driver.name;
  document.getElementById('driverType').innerText = driver.type;
  document.getElementById('driverPrice').innerHTML = `$${driver.price.toFixed(2)} <span class="text-xs font-medium text-slate-400">/ day</span>`;
  document.getElementById('driverImg').src = driver.img;
  document.getElementById('dailyRate').innerText = `$${driver.price.toFixed(2)}`;

  const startDateInput = document.getElementById('start_date');
  const endDateInput = document.getElementById('end_date');

  // Baseline Safety Calculations Matrix
  const today = new Date();
  const tomorrow = new Date(today);
  tomorrow.setDate(tomorrow.getDate() + 1);
  const dayAfter = new Date(today);
  dayAfter.setDate(dayAfter.getDate() + 2);

  // Parse strings directly for raw ISO formatting safely
  const tomorrowStr = tomorrow.toISOString().split('T')[0];
  const dayAfterStr = dayAfter.toISOString().split('T')[0];

  // Set structural defaults securely
  startDateInput.value = tomorrowStr;
  startDateInput.min = tomorrowStr;
  endDateInput.value = dayAfterStr;
  endDateInput.min = dayAfterStr;

  function calculateTotal() {
    const startVal = startDateInput.value;
    let endVal = endDateInput.value;

    if (!startVal) return;

    // Safety Optimization: Force end date baseline constraints forward dynamically
    endDateInput.min = startVal;

    // Prevent date inverting values tracking error gracefully
    if (endVal && new Date(endVal) < new Date(startVal)) {
      const adjustedEndDate = new Date(startVal);
      adjustedEndDate.setDate(adjustedEndDate.getDate() + 1);
      endVal = adjustedEndDate.toISOString().split('T')[0];
      endDateInput.value = endVal;
    }

    if (!endVal) {
      document.getElementById('daysCount').innerText = '0 days';
      document.getElementById('totalPrice').innerText = '$0.00';
      return;
    }

    // Precise Millisecond Delta Calculation Engine
    const deltaMs = new Date(endVal).getTime() - new Date(startVal).getTime();
    const days = Math.max(1, Math.ceil(deltaMs / (1000 * 60 * 60 * 24)));
    const total = driver.price * days;

    document.getElementById('daysCount').innerText = `${days} ${days === 1 ? 'day' : 'days'}`;
    document.getElementById('totalPrice').innerText = `$${total.toFixed(2)}`;
  }

  startDateInput.addEventListener('change', calculateTotal);
  endDateInput.addEventListener('change', calculateTotal);
  
  // Prime system execution calculation
  calculateTotal();

  // Notification UI Manager
  const form = document.getElementById('hireForm');
  const toast = document.getElementById('demoToast');

  function showToast(message) {
    toast.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 4000);
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const total = document.getElementById('totalPrice').innerText;
    showToast(`Allocation Complete! Chauffeur dispatch pipeline confirmed. Mock Charge Value: ${total}.`);
  });

  // Animation Entry Observer Layout
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.05 });
  fadeElements.forEach(el => observer.observe(el));
</script>
@endpush

</x-user.layout>