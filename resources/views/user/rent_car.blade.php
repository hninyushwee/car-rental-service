<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-out;
  }
  .fade-up.visible { opacity: 1; transform: translateY(0); }
  
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
</style>
@endpush

<div data-page="rent-car" data-api-base="{{ url('/') }}" class="min-h-screen">

<!-- Hero Section with Lighter Gradient -->
<div class="hero-gradient py-12 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
  <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
  </div>
  
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
    <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
      Find Your Perfect Ride
    </h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">Premium vehicles, competitive prices, and exceptional service</p>
    
    <div class="mt-4 flex justify-center">
      <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
    </div>
  </div>
</div>

<!-- Category Filters -->
<div class="bg-white dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <div id="categoryFilters" class="flex flex-wrap gap-2">
    </div>
  </div>
</div>

<!-- Filters: Location, Date, Sort -->
<div class="bg-white dark:bg-slate-900 border-y border-slate-100 dark:border-slate-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-5">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5 items-end">
      <div class="lg:col-span-2">
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
          <i data-lucide="search" class="inline h-3.5 w-3.5"></i> Search
        </label>
        <input type="text" id="searchFilter" placeholder="Search by model, brand, color..." class="w-full rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
      </div>
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
          <i data-lucide="map-pin" class="inline h-3.5 w-3.5"></i> Location
        </label>
        <select id="locationFilter" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
          <option value="">All location</option>
          <option value="Yangon">Yangon</option>
          <option value="Mandalay">Mandalay</option>
          <option value="Nay Pyi Taw">Nay Pyi Taw</option>
        </select>
      </div>
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
          <i data-lucide="calendar" class="inline h-3.5 w-3.5"></i> From
        </label>
        <input type="date" id="fromDateFilter" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:[color-scheme:dark]">
      </div>
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
          <i data-lucide="calendar" class="inline h-3.5 w-3.5"></i> To
        </label>
        <input type="date" id="toDateFilter" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:[color-scheme:dark]">
      </div>
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
          <i data-lucide="arrow-up-down" class="inline h-3.5 w-3.5"></i> Sort By
        </label>
        <select id="sortFilter" class="w-full rounded-lg border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/20">
          <option value="popular">Popular</option>
          <option value="price_asc">Price: Low to High</option>
          <option value="price_desc">Price: High to Low</option>
          <option value="newest">Newest</option>
        </select>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="bg-white dark:bg-slate-950 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Loading State -->
    <div id="loadingState" class="py-16 text-center hidden">
      <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-slate-300 border-t-cyan-500"></div>
      <p class="mt-3 text-sm text-slate-500">Loading vehicles...</p>
    </div>

    <!-- Cars Grid -->
    <div id="vehicleGrid" class="py-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="col-span-full py-16 text-center hidden">
      <i data-lucide="car" class="mx-auto h-14 w-14 text-slate-300 dark:text-slate-600"></i>
      <h3 class="mt-3 text-lg font-bold text-slate-600 dark:text-slate-400">No vehicles available</h3>
      <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">Check back later for new listings.</p>
    </div>

    <!-- Pagination -->
    <div id="pagination" class="mt-6">
    </div>
  </div>
</div>

</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-up').forEach(el => el.classList.add('visible'));
  });
</script>
@endpush

</x-user.layout>
