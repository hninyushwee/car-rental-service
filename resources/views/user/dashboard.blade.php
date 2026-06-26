<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1),
                transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }
  .stat-card {
    @apply rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg;
  }
  .booking-card {
    @apply rounded-xl border border-slate-200 bg-white p-4 transition-all duration-300 hover:shadow-md hover:border-cyan-200;
  }
  .copy-code-btn {
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .copy-code-btn.copied {
    background-color: #10b981 !important;
    border-color: #10b981 !important;
    color: white !important;
  }
  .quick-action-btn {
    @apply flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 bg-white transition-all duration-300 hover:border-cyan-400 hover:shadow-md hover:bg-cyan-50;
  }
</style>
@endpush

<div class="pb-16 min-h-screen bg-white">
  <!-- Hero Section -->
  <div class="bg-gradient-to-b from-slate-800 to-slate-700 pt-28 pb-18">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-5xl md:text-6xl font-black tracking-tight text-white">Welcome back, {{ auth()->user()->name ?? 'John Doe' }}!</h1>
          <p class="mt-2 text-cyan-100">Manage your bookings, leases, and discover amazing deals</p>
        </div>
        <a href="/rent_car" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-cyan-600 shadow-lg hover:bg-cyan-50 transition w-fit">
          <i data-lucide="plus" class="h-5 w-5"></i>
          New Booking
        </a>
      </div>
    </div>
  </div>
  <!-- Main Content -->
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-8 pb-8">
    
    <!-- Quick Stats Grid -->
    <div class="mb-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div class="stat-card fade-up">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Bookings</p>
            <p class="text-3xl font-black text-slate-950 mt-2">8</p>
            <p class="text-xs text-emerald-600 font-medium mt-1">↑ 2 this month</p>
          </div>
          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-100">
            <i data-lucide="calendar" class="h-7 w-7"></i>
          </div>
        </div>
      </div>

      <div class="stat-card fade-up" style="animation-delay: 0.1s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Active Rentals</p>
            <p class="text-3xl font-black text-slate-950 mt-2">2</p>
            <p class="text-xs text-emerald-600 font-medium mt-1">✓ All active</p>
          </div>
          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
            <i data-lucide="car" class="h-7 w-7"></i>
          </div>
        </div>
      </div>

      <div class="stat-card fade-up" style="animation-delay: 0.2s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Saved</p>
            <p class="text-3xl font-black text-slate-950 mt-2">$187</p>
            <p class="text-xs text-purple-600 font-medium mt-1">💰 From promotions</p>
          </div>
          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 border border-purple-100">
            <i data-lucide="badge-percent" class="h-7 w-7"></i>
          </div>
        </div>
      </div>

      <div class="stat-card fade-up" style="animation-delay: 0.3s">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Loyalty Points</p>
            <p class="text-3xl font-black text-slate-950 mt-2">1,240</p>
            <p class="text-xs text-amber-600 font-medium mt-1">⭐ 3 more for reward</p>
          </div>
          <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
            <i data-lucide="star" class="h-7 w-7"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-12">
      <h2 class="text-xl font-bold text-slate-900 mb-4">Quick Actions</h2>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="/rent_car" class="quick-action-btn">
          <i data-lucide="car" class="h-6 w-6 text-cyan-600"></i>
          <span class="text-sm font-semibold text-slate-900">Rent a Car</span>
        </a>
        <a href="/rent_driver" class="quick-action-btn">
          <i data-lucide="user-check" class="h-6 w-6 text-emerald-600"></i>
          <span class="text-sm font-semibold text-slate-900">Hire Driver</span>
        </a>
        <a href="/booking_history" class="quick-action-btn">
          <i data-lucide="history" class="h-6 w-6 text-purple-600"></i>
          <span class="text-sm font-semibold text-slate-900">View History</span>
        </a>
        <a href="/profile" class="quick-action-btn">
          <i data-lucide="user" class="h-6 w-6 text-blue-600"></i>
          <span class="text-sm font-semibold text-slate-900">My Profile</span>
        </a>
      </div>
    </div>
      
    <!-- Two Column Layout -->
    <div class="grid gap-8 lg:grid-cols-3 mb-12">
      
      <!-- Active Promotions -->
      <div class="lg:col-span-1">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            🔥 Active Promotions
          </h2>
          <a href="#" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all →</a>
        </div>
        
        <div class="space-y-3">
          @php
            $activePromos = [
              ['code' => 'SKYLINE10', 'title' => 'Summer Special', 'desc' => '10% off rentals', 'discount' => '10%', 'valid_until' => 'Aug 31'],
              ['code' => 'DRIVER20', 'title' => 'Driver Discount', 'desc' => '$20 off 3+ days', 'discount' => '$20', 'valid_until' => 'Sep 15'],
            ];
          @endphp
          @foreach($activePromos as $promo)
          <div class="booking-card">
            <div class="flex items-start justify-between gap-2 mb-2">
              <div>
                <h3 class="text-sm font-bold text-slate-900">{{ $promo['title'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $promo['desc'] }}</p>
              </div>
              <span class="rounded-full bg-cyan-100 px-2.5 py-1 text-xs font-bold text-cyan-700 shrink-0">{{ $promo['discount'] }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
              <span class="text-[10px] text-slate-400">Expires {{ $promo['valid_until'] }}</span>
              <button class="copy-code-btn rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition" data-code="{{ $promo['code'] }}">
                <i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Upcoming Bookings -->
      <div class="lg:col-span-2">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-lg font-bold text-slate-900">📅 Upcoming & Active</h2>
          <a href="/booking_history" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all →</a>
        </div>

        <div class="space-y-3">
          @php
            $upcoming = [
              ['id' => 1003, 'type' => 'Car Rental', 'item' => 'Tesla Model 3', 'date' => 'May 10, 2026', 'status' => 'confirmed', 'price' => '$299', 'days' => '3 days'],
              ['id' => 1024, 'type' => 'Car Lease', 'item' => 'BMW X5', 'date' => 'Active', 'status' => 'active', 'price' => '$2,500/mo', 'progress' => 'Month 3 of 12'],
              ['id' => 1002, 'type' => 'Driver Hire', 'item' => 'Michael Chen', 'date' => 'May 12, 2026', 'status' => 'upcoming', 'price' => '$85', 'days' => '1 day'],
            ];
          @endphp
          @foreach($upcoming as $booking)
          <div class="booking-card">
            <div class="flex items-center justify-between gap-4">
              <div class="flex items-center gap-3 flex-1">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 border border-slate-200">
                  @if($booking['type'] == 'Car Rental')
                    <i data-lucide="car" class="h-5 w-5 text-cyan-600"></i>
                  @elseif($booking['type'] == 'Car Lease')
                    <i data-lucide="key-round" class="h-5 w-5 text-indigo-600"></i>
                  @else
                    <i data-lucide="user" class="h-5 w-5 text-emerald-600"></i>
                  @endif
                </div>
                <div>
                  <p class="font-bold text-sm text-slate-900">{{ $booking['item'] }}</p>
                  <p class="text-xs text-slate-500 mt-0.5">{{ $booking['date'] }}</p>
                </div>
              </div>
              <div class="text-right">
                <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold border
                  {{ $booking['status'] === 'active' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}
                ">{{ ucfirst($booking['status']) }}</span>
                <p class="text-sm font-bold text-slate-900 mt-1">{{ $booking['price'] }}</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Financial History Table -->
    <div class="fade-up">
      <div class="mb-4">
        <h2 class="text-lg font-bold text-slate-900">📊 Recent Transactions</h2>
        <p class="text-xs text-slate-500 mt-1">View your complete financial history</p>
      </div>
      
      <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Transaction</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Service</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Date</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            @php
              $recent = [
                ['id' => 'TXN-9982', 'type' => 'Car Lease', 'item' => 'BMW X5 Deposit', 'date' => 'Jun 01, 2026', 'total' => 1200, 'status' => 'approved'],
                ['id' => 'TXN-9541', 'type' => 'Car Rental', 'item' => 'Tesla Model 3', 'date' => 'May 10, 2026', 'total' => 445, 'status' => 'refund_pending'],
                ['id' => 'TXN-9021', 'type' => 'License Service', 'item' => 'Permit Processing', 'date' => 'Apr 18, 2026', 'total' => 85, 'status' => 'refunded'],
              ];
            @endphp
            @foreach($recent as $txn)
            <tr class="hover:bg-slate-50/60 transition-colors">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-mono font-bold text-slate-900">{{ $txn['id'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $txn['type'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $txn['date'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-slate-900">${{ number_format($txn['total']) }}</td>
              <td class="whitespace-nowrap px-6 py-4">
                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold tracking-wide border
                  {{ $txn['status'] == 'approved' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                  {{ $txn['status'] == 'refund_pending' ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                  {{ $txn['status'] == 'refunded' ? 'bg-slate-50 text-slate-700 border-slate-200' : '' }}
                ">
                  {{ $txn['status'] === 'approved' ? '✓ Success' : ($txn['status'] === 'refund_pending' ? '⏳ Pending' : '↩️ Refunded') }}
                </span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

{{-- Toast container --}}
<div id="copyToast" class="fixed bottom-6 right-6 hidden transform rounded-xl bg-slate-900 px-5 py-3 text-sm font-medium text-white shadow-xl z-50 border border-slate-800 transition-all duration-300"></div>

@push('scripts')
<script>
  // Intersection Observer for fade-up animations
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.05 });
  fadeElements.forEach(el => observer.observe(el));

  // Copy code functionality
  const copyButtons = document.querySelectorAll('.copy-code-btn');
  const toast = document.getElementById('copyToast');

  function showCopyToast(message) {
    toast.innerHTML = `<div class="flex items-center gap-2"><span>✨</span> ${message}</div>`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2500);
  }

  copyButtons.forEach(btn => {
    btn.addEventListener('click', async () => {
      const code = btn.dataset.code;
      try {
        await navigator.clipboard.writeText(code);
        btn.innerHTML = '<i data-lucide="check" class="h-3 w-3 inline mr-1"></i>Copied!';
        btn.classList.add('copied');
        Lucide.createIcons();
        setTimeout(() => {
          btn.innerHTML = '<i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy';
          btn.classList.remove('copied');
          Lucide.createIcons();
        }, 1500);
        showCopyToast(`Code <strong>${code}</strong> copied!`);
      } catch (err) {
        showCopyToast('Failed to copy code.');
      }
    });
  });
</script>
@endpush

</x-user.layout>