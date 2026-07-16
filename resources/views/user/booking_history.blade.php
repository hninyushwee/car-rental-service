<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .hero-gradient {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f1f5f9 100%);
  }
  .dark .hero-gradient {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e293b 100%);
  }
  .shadow-glow {
    box-shadow: 0 0 12px rgba(6, 182, 212, 0.3);
  }
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

<div data-page="user-booking-history">

  <div class="hero-gradient py-12 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
    <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
        Booking History
      </h1>
      <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">View and manage all your past and upcoming reservations.</p>
      <div class="mt-4 flex justify-center">
        <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
      </div>
    </div>
  </div>

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="bg-white dark:bg-slate-950 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-6 border-b border-slate-100 dark:border-slate-800 mb-6">
      <div class="flex flex-wrap gap-2">
        <button class="service-tab rounded-full border-2 px-4 py-2 text-sm font-bold transition-all border-cyan-400 bg-cyan-50 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300" data-service="car">Rent a Car</button>
        <button class="service-tab rounded-full border-2 px-4 py-2 text-sm font-bold transition-all border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:border-cyan-400 hover:bg-cyan-50 dark:hover:bg-cyan-900/20" data-service="driver">Hire a Driver</button>
      </div>
    </div>

    <div class="mb-6 flex flex-wrap items-center gap-4">
      <div class="relative max-w-sm flex-1">
        <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
        <input type="text" id="searchInput" placeholder="Search..." class="w-full rounded-xl border border-slate-200 py-2 pl-9 pr-4 text-sm focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
      </div>
      <select id="statusFilter" class="hidden rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400 bg-white">
        <option value="all">All</option>
        <option value="pending">Pending</option>
        <option value="confirmed">Confirmed</option>
        <option value="cancelled">Cancelled</option>
      </select>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
      <table class="min-w-full divide-y divide-slate-200">
        <thead id="tableHead" class="bg-slate-50">
          <tr id="headerRow"></tr>
        </thead>
        <tbody id="tableBody" class="divide-y divide-slate-200 bg-white">
        </tbody>
      </table>
    </div>

    <div id="pagination" class="mt-6"></div>
  </div>
</div>

<div id="detailsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-300">
  <div class="w-full max-w-2xl rounded-2xl bg-white p-5 shadow-2xl max-h-[85vh] overflow-y-auto">
    <div id="modalContent"></div>
  </div>
</div>

<div id="demoToast" class="fixed bottom-5 right-5 z-50 hidden rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300"></div>

@push('scripts')
<script>
  document.querySelectorAll('.fade-up').forEach(el => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.1 });
    observer.observe(el);
  });
</script>
@endpush

</x-user.layout>
