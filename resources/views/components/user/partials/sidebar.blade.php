{{-- resources/views/user/partials/sidebar.blade.php --}}
<aside id="dashboardSidebar" class="fixed bottom-0 left-0 top-20 z-40 w-60 border-r border-slate-700 bg-slate-900 shadow-xl transition-all duration-300 md:w-68">
  <!-- Logo + SkyLine text + Toggle button area -->
  <div class="border-b border-slate-700 p-3 flex items-center justify-between">
    <a href="#home" class="flex items-center gap-2 flex-1 min-w-0" aria-label="SKY Line home">
      <!-- Removed brightness-0 invert – logo shows as original -->
      <img class="h-8 w-auto object-contain sm:h-10 md:h-12 shrink-0" src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />
      <p id="logoText" class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 bg-clip-text text-transparent font-black text-xl sm:text-2xl md:text-3xl tracking-wide truncate">
        SkyLine
      </p>
    </a>
    
    <!-- Sidebar Toggle Button (Gemini Style) -->
    <button type="button" data-sidebar-toggle
      class="flex h-8 w-8 shrink-0 items-center justify-center rounded bg-slate-700/50 text-slate-400 transition hover:bg-slate-600 hover:text-white ml-2"
      title="Toggle sidebar">
      <i data-lucide="panel-left" class="h-4 w-4"></i>
    </button>
  </div>

  <!-- Navigation links (unchanged) -->
  <div class="grid gap-1 mt-4 p-2">
    <a href="{{ route('dashboard') }}" data-sidebar-link class="flex items-center gap-3 rounded-l border-l-4 border-cyan-500 bg-transparent px-3 py-3 text-sm font-bold text-cyan-400 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="layout-dashboard" class="h-4 w-4 shrink-0 text-cyan-400"></i>
      <span data-sidebar-label>Dashboard</span>
    </a>
    <a href="{{ route('rent_car') }}" data-sidebar-link class="flex items-center gap-3 rounded px-3 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="car" class="h-4 w-4 shrink-0"></i>
      <span data-sidebar-label>Rent a Car</span>
    </a>
    <a href="{{ route('rent_driver') }}" data-sidebar-link class="flex items-center gap-3 rounded px-3 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="user-check" class="h-4 w-4 shrink-0"></i>
      <span data-sidebar-label>Hire a Driver</span>
    </a>
    <a href="{{ route('license') }}" data-sidebar-link class="flex items-center gap-3 rounded px-3 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="badge-check" class="h-4 w-4 shrink-0"></i>
      <span data-sidebar-label>License Services</span>
    </a>
    <a href="{{ route('history') }}" data-sidebar-link class="flex items-center gap-3 rounded px-3 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="history" class="h-4 w-4 shrink-0"></i>
      <span data-sidebar-label>Booking History</span>
    </a>
    <a href="{{ route('inquiry') }}" data-sidebar-link class="flex items-center gap-3 rounded px-3 py-3 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white">
      <i data-lucide="messages-square" class="h-4 w-4 shrink-0"></i>
      <span data-sidebar-label>General Inquiries</span>
    </a>
  </div>
</aside>