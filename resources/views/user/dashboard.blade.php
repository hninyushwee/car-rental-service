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
  .hero-gradient {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f1f5f9 100%);
  }
  .dark .hero-gradient {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e293b 100%);
  }
  .shadow-glow {
    box-shadow: 0 2px 15px rgba(6, 182, 212, 0.12), 0 4px 25px rgba(6, 182, 212, 0.05);
  }
  .dark .shadow-glow {
    box-shadow: 0 2px 15px rgba(6, 182, 212, 0.2), 0 4px 25px rgba(6, 182, 212, 0.08);
  }
  .quick-action-btn {
    @apply flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 bg-white transition-all duration-300 hover:border-cyan-400 hover:shadow-md hover:bg-cyan-50;
  }
</style>
@endpush

<div data-page="user-dashboard" class="min-h-screen">

  <!-- Hero Section -->
  <div class="hero-gradient py-12 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
    <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
            Welcome back, {{ auth()->user()->name ?? 'John Doe' }}!
          </h1>
          <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">Manage your bookings, track rentals, and discover deals</p>
        </div>
        <a href="/rent-car" class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-400 px-6 py-3 text-sm font-bold text-black shadow-lg hover:bg-cyan-500 transition w-fit">
          <i data-lucide="plus" class="h-5 w-5"></i>
          New Booking
        </a>
      </div>
      <div class="mt-4 flex justify-start">
        <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 -mt-6 pb-8">

    <!-- Stats Grid -->
    @php $s = $dashboardData->stats ?? null; @endphp
    <div class="mb-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div class="stat-card fade-up visible">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Bookings</p>
            <p class="text-2xl font-bold text-slate-950 mt-1">{{ $s->total ?? 0 }}</p>
            <p class="text-xs text-emerald-600 font-medium mt-1">{{ $s->active ?? 0 }} active now</p>
          </div>
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 border border-cyan-100">
            <i data-lucide="calendar" class="h-5 w-5"></i>
          </div>
        </div>
      </div>
      <div class="stat-card fade-up visible">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Completed</p>
            <p class="text-2xl font-bold text-slate-950 mt-1">{{ $s->completed ?? 0 }}</p>
            <p class="text-xs text-slate-500 font-medium mt-1">{{ $s->cancelled ?? 0 }} cancelled</p>
          </div>
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
            <i data-lucide="check-circle" class="h-5 w-5"></i>
          </div>
        </div>
      </div>
      <div class="stat-card fade-up visible">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Total Spent</p>
            <p class="text-2xl font-bold text-slate-950 mt-1"><span class="text-base font-semibold text-slate-500">MMK</span> {{ number_format($dashboardData->total_spent ?? 0) }}</p>
            <p class="text-xs text-purple-600 font-medium mt-1">All time</p>
          </div>
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple-50 text-purple-600 border border-purple-100">
            <i data-lucide="wallet" class="h-5 w-5"></i>
          </div>
        </div>
      </div>
      <div class="stat-card fade-up visible">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold tracking-wide uppercase text-slate-400">Notifications</p>
            <p class="text-2xl font-bold text-slate-950 mt-1">{{ $dashboardData->unread_notifications ?? 0 }}</p>
            <p class="text-xs text-amber-600 font-medium mt-1">Unread</p>
          </div>
          <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
            <i data-lucide="bell" class="h-5 w-5"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-12 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
      <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Quick Actions</h2>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <a href="/rent-car" class="quick-action-btn">
          <i data-lucide="car" class="h-6 w-6 text-cyan-600"></i>
          <span class="text-sm font-semibold text-slate-900 dark:text-white">Rent a Car</span>
        </a>
        <a href="/rent_driver" class="quick-action-btn">
          <i data-lucide="user-check" class="h-6 w-6 text-emerald-600"></i>
          <span class="text-sm font-semibold text-slate-900 dark:text-white">Hire Driver</span>
        </a>
        <a href="{{ url('/booking-history') }}" class="quick-action-btn">
          <i data-lucide="history" class="h-6 w-6 text-purple-600"></i>
          <span class="text-sm font-semibold text-slate-900 dark:text-white">View History</span>
        </a>
        <a href="/profile" class="quick-action-btn">
          <i data-lucide="user" class="h-6 w-6 text-blue-600"></i>
          <span class="text-sm font-semibold text-slate-900 dark:text-white">My Profile</span>
        </a>
      </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid gap-8 lg:grid-cols-3 mb-12">

      <!-- Active Promotions -->
      <div class="lg:col-span-1">
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <i data-lucide="badge-percent" class="h-5 w-5 text-cyan-500"></i> Active Promotions
            </h2>
          </div>
          <div class="space-y-3">
            @forelse($dashboardData->active_promotions ?? [] as $promo)
              <div class="booking-card">
                <div class="flex items-start justify-between gap-2 mb-2">
                  <div>
                    <h3 class="text-sm font-bold text-slate-900">{{ $promo->code }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $promo->description ?? '' }}</p>
                  </div>
                  <span class="rounded-full bg-cyan-100 px-2.5 py-1 text-xs font-bold text-cyan-700 shrink-0">
                    {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : 'MMK ' . number_format($promo->discount_value) }}
                  </span>
                </div>
                <div class="flex items-center justify-between gap-2">
                  <span class="text-[10px] text-slate-400">Expires {{ $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('M d, Y') : 'N/A' }}</span>
                  <button class="copy-code-btn rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-medium text-slate-700 shadow-sm hover:bg-slate-50 transition" data-code="{{ $promo->code }}">
                    <i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy
                  </button>
                </div>
              </div>
            @empty
              <div class="booking-card text-center py-6"><p class="text-sm text-slate-400">No active promotions right now.</p></div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Upcoming & Active Bookings -->
      <div class="lg:col-span-2">
        <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm">
          <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <i data-lucide="calendar-check" class="h-5 w-5 text-cyan-500"></i> Upcoming & Active
            </h2>
            <a href="{{ url('/booking-history') }}" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all →</a>
          </div>
          @php $upcoming = $dashboardData->upcoming_bookings ?? []; @endphp
          @if(count($upcoming))
            <div class="space-y-3">
              @foreach($upcoming as $b)
                @php
                  $item = $b->items[0] ?? null;
                  $isVehicle = $item && $item->vehicle;
                  $name = $isVehicle ? ($item->vehicle->brand->name ?? '') . ' ' . ($item->vehicle->model ?? '') : ($item->driver->name ?? 'Service');
                  $icon = $isVehicle ? 'car' : 'user-check';
                  $iconColor = $isVehicle ? 'text-cyan-600' : 'text-emerald-600';
                  $dateLabel = $item && $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d, Y') : 'N/A';
                  $price = $b->total_price ? 'MMK ' . number_format($b->total_price) : '';
                @endphp
                <div class="booking-card">
                  <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 flex-1">
                      <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-100 border border-slate-200">
                        <i data-lucide="{{ $icon }}" class="h-5 w-5 {{ $iconColor }}"></i>
                      </div>
                      <div>
                        <p class="font-bold text-sm text-slate-900">{{ $name }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $dateLabel }}</p>
                      </div>
                    </div>
                    <div class="text-right">
                      <span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold border
                        {{ $b->status === 'active' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-emerald-50 text-emerald-700 border-emerald-200' }}
                      ">{{ ucfirst($b->status) }}</span>
                      @if($price)
                        <p class="text-sm font-bold text-slate-900 mt-1">{{ $price }}</p>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="booking-card text-center py-6">
              <i data-lucide="calendar" class="mx-auto h-8 w-8 text-slate-300 mb-2"></i>
              <p class="text-sm text-slate-400">No upcoming bookings.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="fade-up visible">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
            <i data-lucide="receipt" class="h-5 w-5 text-cyan-500"></i> Recent Transactions
          </h2>
          <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Total spent: <span id="totalSpent" class="font-bold text-slate-900 dark:text-white">MMK {{ number_format($dashboardData->total_spent ?? 0) }}</span></p>
        </div>
        <a href="{{ url('/booking-history') }}" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700">View all →</a>
      </div>
      @php $txns = $dashboardData->recent_transactions ?? []; @endphp
      <div class="overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
          <thead class="bg-slate-50 dark:bg-slate-800/50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Transaction</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Method</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
            @forelse($txns as $t)
              @php
                $statusLabels = ['confirmed' => 'Success', 'pending' => 'Pending', 'failed' => 'Failed', 'refunded' => 'Refunded'];
                $statusColors = [
                  'confirmed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                  'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                  'failed' => 'bg-red-50 text-red-700 border-red-200',
                  'refunded' => 'bg-slate-50 text-slate-700 border-slate-200',
                ];
                $label = $statusLabels[$t->status] ?? $t->status;
                $color = $statusColors[$t->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
              @endphp
              <tr class="hover:bg-slate-50/60 transition-colors">
                <td class="whitespace-nowrap px-6 py-4 text-sm font-mono font-bold text-slate-900">{{ $t->transaction_ref ?? 'N/A' }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600 capitalize">{{ $t->payment_method ?? 'N/A' }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-500">{{ $t->payment_date ? \Carbon\Carbon::parse($t->payment_date)->format('M d, Y') : ($t->created_at ? \Carbon\Carbon::parse($t->created_at)->format('M d, Y') : 'N/A') }}</td>
                <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-slate-900">MMK {{ number_format($t->amount) }}</td>
                <td class="whitespace-nowrap px-6 py-4"><span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold tracking-wide border {{ $color }}">{{ $label }}</span></td>
              </tr>
            @empty
              <tr><td colspan="5" class="px-6 py-12 text-center text-sm text-slate-400">No transactions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<div id="copyToast" class="fixed bottom-6 right-6 hidden transform rounded-xl bg-gradient-to-r from-green-500 to-green-600 px-5 py-3 text-sm font-medium text-white shadow-xl z-50 transition-all duration-300"></div>

@push('scripts')
<script>
  document.querySelectorAll('.fade-up').forEach(el => el.classList.add('visible'));

  document.querySelectorAll('.copy-code-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
      const code = btn.dataset.code;
      const toast = document.getElementById('copyToast');
      try {
        await navigator.clipboard.writeText(code);
        btn.innerHTML = '<i data-lucide="check" class="h-3 w-3 inline mr-1"></i>Copied!';
        btn.classList.add('copied');
        if (window.lucide) lucide.createIcons();
        setTimeout(() => {
          btn.innerHTML = '<i data-lucide="copy" class="h-3 w-3 inline mr-1"></i>Copy';
          btn.classList.remove('copied');
          if (window.lucide) lucide.createIcons();
        }, 1500);
        toast.innerHTML = `<div class="flex items-center gap-2"><span>✨</span> Code <strong>${code}</strong> copied!</div>`;
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2500);
      } catch {
        toast.innerHTML = 'Failed to copy code.';
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2500);
      }
    });
  });
</script>
@endpush

</x-user.layout>
