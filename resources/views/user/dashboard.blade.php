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
    @apply rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md;
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
</style>
@endpush

<div class="pt-24 pb-16 bg-slate-50/50 min-h-screen fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    
    {{-- Welcome header --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black tracking-tight text-slate-950">Welcome back, {{ auth()->user()->name ?? 'Demo User' }}!</h1>
        <p class="mt-1 text-slate-500">Monitor your active leases, daily rentals, and available promotional credits.</p>
      </div>
      <div>
        <a href="#" class="inline-flex items-center justify-center rounded-xl bg-cyan-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-cyan-700 transition">
          New Booking / Lease
        </a>
      </div>
    </div>

    {{-- Stats Grid --}}
    <div class="mb-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
      <div class="stat-card">
        <div class="flex items-center gap-4">
          <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-100">
            <i data-lucide="calendar" class="h-6 w-6"></i>
          </div>
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Bookings</p>
            <p class="text-3xl font-black text-slate-950 mt-0.5">8</p>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="flex items-center gap-4">
          <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
            <i data-lucide="car" class="h-6 w-6"></i>
          </div>
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Active Rentals & Leases</p>
            <p class="text-3xl font-black text-slate-950 mt-0.5">2</p>
          </div>
        </div>
      </div>
      <div class="stat-card">
        <div class="flex items-center gap-4">
          <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 border border-purple-100">
            <i data-lucide="badge-percent" class="h-6 w-6"></i>
          </div>
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Saved</p>
            <p class="text-3xl font-black text-slate-950 mt-0.5">$187</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Two-column layout --}}
    <div class="mb-8 grid gap-8 lg:grid-cols-12">
      
      {{-- Active Promotions Column (Left 5-cols) --}}
      <div class="lg:col-span-5">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <span>🔥 Active Promotions</span>
          </h2>
          <a href="#" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all →</a>
        </div>
        
        <div class="space-y-4">
          @php
            $activePromos = [
              ['code' => 'SKYLINE10', 'title' => 'Summer Special', 'desc' => '10% off all car rentals (min $100)', 'discount' => '10% OFF', 'valid_until' => 'Aug 31'],
              ['code' => 'DRIVER20', 'title' => 'Chauffeur Discount', 'desc' => '$20 off driver hire of 3+ days', 'discount' => '$20 OFF', 'valid_until' => 'Sep 15'],
            ];
          @endphp
          @foreach($activePromos as $promo)
          <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between gap-3">
              <div class="flex-1">
                <div class="flex items-center flex-wrap gap-2">
                  <span class="rounded-md bg-cyan-50 border border-cyan-200 px-2 py-0.5 text-xs font-bold text-cyan-700">{{ $promo['discount'] }}</span>
                  <span class="text-xs text-slate-400">Expires {{ $promo['valid_until'] }}</span>
                </div>
                <h3 class="mt-2 text-sm font-bold text-slate-900">{{ $promo['title'] }}</h3>
                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $promo['desc'] }}</p>
              </div>
              <div class="flex flex-col items-end gap-2 shrink-0">
                <code class="rounded bg-slate-100 px-2 py-1 text-xs font-mono font-bold text-slate-700 tracking-wider border border-slate-200/60">{{ $promo['code'] }}</code>
                <button class="copy-code-btn rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50" data-code="{{ $promo['code'] }}">Copy</button>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Upcoming Bookings & Leases Column (Right 7-cols) --}}
      <div class="lg:col-span-7">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-lg font-bold text-slate-900">📅 Upcoming & Ongoing Contracts</h2>
          <a href="#" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">Manage all →</a>
        </div>

        <div class="space-y-3">
          @php
            $upcoming = [
              ['id' => 1003, 'type' => 'Car Rental', 'item' => 'Tesla Model 3', 'date' => 'May 10, 2026', 'status' => 'confirmed', 'can_cancel' => true, 'cancel_hours_left' => 14],
              ['id' => 1024, 'type' => 'Car Lease', 'item' => 'BMW X5 (Long-term)', 'date' => 'Monthly Autopay', 'status' => 'active', 'can_cancel' => false, 'lease_progress' => 'Month 3 of 12'],
              ['id' => 1002, 'type' => 'Driver Hire', 'item' => 'Michael Chen', 'date' => 'May 12, 2026', 'status' => 'upcoming', 'can_cancel' => true, 'cancel_hours_left' => 22],
            ];
          @endphp
          @foreach($upcoming as $booking)
          <div class="rounded-xl border border-slate-200 bg-white p-4 transition hover:shadow-sm">
            <div class="flex items-center justify-between gap-4">
              <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-100 border border-slate-200/50">
                  @if($booking['type'] == 'Car Rental')
                    <i data-lucide="car" class="h-5 w-5 text-slate-600"></i>
                  @elseif($booking['type'] == 'Car Lease')
                    <i data-lucide="key-round" class="h-5 w-5 text-indigo-600"></i>
                  @else
                    <i data-lucide="user" class="h-5 w-5 text-slate-600"></i>
                  @endif
                </div>
                <div>
                  <div class="flex items-center gap-2">
                    <p class="font-bold text-sm text-slate-900">{{ $booking['item'] }}</p>
                    <span class="text-[10px] px-1.5 py-0.2 rounded font-medium bg-slate-100 text-slate-600 border border-slate-200">{{ $booking['type'] }}</span>
                  </div>
                  <p class="text-xs text-slate-500 mt-0.5">
                    {{ $booking['date'] }} @if(isset($booking['lease_progress'])) • <span class="text-indigo-600 font-semibold">{{ $booking['lease_progress'] }}</span> @endif
                  </p>
                </div>
              </div>
              
              <div class="flex flex-col items-end gap-1.5">
                <span class="rounded-full px-2 py-0.5 text-xs font-semibold border
                  {{ $booking['status'] === 'active' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : '' }}
                  {{ $booking['status'] === 'confirmed' || $booking['status'] === 'upcoming' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                ">
                  {{ ucfirst($booking['status']) }}
                </span>
                
                {{-- Quick Refund Window Action --}}
                @if($booking['can_cancel'])
                  <div class="flex items-center gap-2">
                    <span class="text-[10px] text-amber-600 font-medium bg-amber-50 px-1.5 py-0.5 rounded border border-amber-200">⏱️ Free refund ends in {{ $booking['cancel_hours_left'] }}h</span>
                    <button onclick="confirmCancellation({{ $booking['id'] }})" class="text-xs font-semibold text-rose-600 hover:text-rose-800 hover:underline">Cancel</button>
                  </div>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    {{-- Comprehensive Financial Ledger / History Table --}}
    <div class="mt-10">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h2 class="text-xl font-bold text-slate-900">Financial History</h2>
          <p class="text-xs text-slate-500 mt-0.5">Unified status updates covering rentals, leasing deposits, and processing fees.</p>
        </div>
        <a href="#" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View complete ledger →</a>
      </div>
      
      <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
          <thead class="bg-slate-50/70">
            <tr>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Transaction ID</th>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Service Area</th>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Details</th>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Date Logged</th>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Total Net</th>
              <th class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Payment Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 bg-white">
            @php
              $recent = [
                ['id' => 'TXN-9982', 'type' => 'Car Lease', 'item' => 'BMW X5 (Security Deposit)', 'date' => 'Jun 01, 2026', 'total' => 1200, 'status' => 'approved'],
                ['id' => 'TXN-9541', 'type' => 'Car Rental', 'item' => 'Tesla Model 3', 'date' => 'May 10, 2026', 'total' => 445, 'status' => 'refund_pending'],
                ['id' => 'TXN-9021', 'type' => 'License Assistance', 'item' => 'International Permit Processing', 'date' => 'Apr 18, 2026', 'total' => 85, 'status' => 'refunded'],
              ];
            @endphp
            @foreach($recent as $booking)
            <tr class="hover:bg-slate-50/60 transition-colors">
              <td class="whitespace-nowrap px-6 py-4 text-sm font-mono font-bold text-slate-900">{{ $booking['id'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                <span class="inline-flex items-center gap-1.5">
                  <span class="h-1.5 w-1.5 rounded-full {{ $booking['type'] === 'Car Lease' ? 'bg-indigo-500' : 'bg-slate-400' }}"></span>
                  {{ $booking['type'] }}
                </span>
              </td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">{{ $booking['item'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $booking['date'] }}</td>
              <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-slate-900">${{ number_format($booking['total']) }}</td>
              <td class="whitespace-nowrap px-6 py-4">
                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold tracking-wide border
                  {{ $booking['status'] == 'approved' ? 'bg-emerald-50 text-emerald-800 border-emerald-200' : '' }}
                  {{ $booking['status'] == 'refund_pending' ? 'bg-amber-50 text-amber-800 border-amber-200' : '' }}
                  {{ $booking['status'] == 'refunded' ? 'bg-rose-50 text-rose-800 border-rose-200' : '' }}
                ">
                  {{ $booking['status'] === 'approved' ? 'Success' : ($booking['status'] === 'refund_pending' ? 'Refund Pending' : 'Refunded') }}
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
  // Dynamic Confirmation Action for 24-hr cancellations
  function confirmCancellation(bookingId) {
    if (confirm(`Are you sure you want to cancel booking #${bookingId}? You are within the 24-hour window and are eligible for a full refund.`)) {
      // Direct user to a secure programmatic POST handler route
      window.location.href = `/bookings/${bookingId}/cancel-refund`;
    }
  }

  // Copy code implementation matches optimized layout rules
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
        const originalText = btn.innerText;
        btn.innerText = 'Copied!';
        btn.classList.add('copied');
        setTimeout(() => {
          btn.innerText = originalText;
          btn.classList.remove('copied');
        }, 1500);
        showCopyToast(`Code <strong>${code}</strong> is ready to paste!`);
      } catch (err) {
        showCopyToast('Failed to copy code block.');
      }
    });
  });

  // Intersection Observer config
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