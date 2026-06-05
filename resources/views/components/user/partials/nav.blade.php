{{-- resources/views/user/partials/nav.blade.php --}}
<header id="siteHeader" class="fixed inset-x-0 top-0 z-50 transition-all duration-300">
  <nav class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-3 py-3 sm:gap-3 sm:px-4 md:px-5 md:gap-4 lg:px-6">
    <!-- LEFT SECTION: Logo + SkyLine text -->
    <div id="logo" class="flex shrink-0 items-center gap-1 sm:gap-2 md:gap-3">
      <a href="#home" class="flex shrink-0 items-center gap-1 sm:gap-2" aria-label="SKY Line home">
        <img class="h-8 w-auto object-contain sm:h-10 md:h-12" src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />
        <!-- SkyLine text – brighter gradient, visible on both dark and white backgrounds -->
        <p class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 bg-clip-text text-transparent font-black text-xl sm:text-2xl md:text-3xl tracking-wide drop-shadow-md">
          SkyLine
        </p>
      </a>
    </div>

    <!-- SIDEBAR TOGGLE (unchanged) -->
    <div data-auth-ui id="sidebarToggle" class="hidden transition-all duration-300 py-1">
      <button type="button" data-sidebar-toggle class="flex h-8 w-8 shrink-0 items-center justify-center rounded border border-slate-300 bg-white/80 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100 hover:text-slate-900 sm:h-9 sm:w-9 md:h-10 md:w-10">
        <i data-lucide="panel-left" class="h-4 w-4 sm:h-5 sm:w-5"></i>
      </button>
    </div>

    <!-- CENTER NAVIGATION (unchanged) -->
    <div class="hidden items-center gap-4 md:flex lg:gap-8">
      <a href="#home" class="text-sm font-semibold transition hover:text-cyan-600" data-nav-contrast>Home</a>
      <a href="#about" class="text-sm font-semibold transition hover:text-cyan-600" data-nav-contrast>About Us</a>
      <a href="#contact" class="text-sm font-semibold transition hover:text-cyan-600" data-nav-contrast>Contact Us</a>
    </div>

    <!-- RIGHT SECTION -->
    <div class="hidden md:block">
      <!-- Guest UI – rely on data-nav-contrast-button for scroll‑adaptive colors -->
      <div data-guest-ui class="flex items-center gap-2 sm:gap-3">
        <button type="button" class="rounded border px-3 py-1.5 text-xs font-semibold transition sm:px-4 sm:py-2 sm:text-sm" data-nav-contrast-button>Sign In</button>
        <button type="button" class="rounded bg-cyan-600 px-3 py-1.5 text-xs font-bold text-white shadow-md transition hover:bg-cyan-700 sm:px-4 sm:py-2 sm:text-sm">Register</button>
      </div>

      <!-- Authenticated UI (buttons visible on both backgrounds) -->
      <div data-auth-ui class="hidden flex flex-row flex-nowrap items-center gap-2 sm:gap-3">
        <!-- Notifications -->
        <div class="relative shrink-0">
          <button id="notificationButton" type="button" class="relative flex h-8 w-8 shrink-0 items-center justify-center rounded border border-slate-300 bg-white/80 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100 hover:text-slate-900 sm:h-9 sm:w-9 md:h-10 md:w-10">
            <i data-lucide="bell" class="h-4 w-4 sm:h-5 sm:w-5"></i>
            <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full border border-white bg-cyan-600 sm:right-2 sm:top-2 sm:h-2.5 sm:w-2.5"></span>
          </button>
          <div id="notificationDropdown" class="absolute right-0 mt-3 hidden w-72 sm:w-80 overflow-hidden rounded border border-slate-200 bg-white shadow-2xl">
            <!-- dropdown content unchanged -->
            <div class="border-b border-slate-100 px-3 py-2 sm:px-4 sm:py-3">
              <p class="text-xs sm:text-sm font-bold text-slate-950">Notifications</p>
              <p class="text-xs text-slate-500">Latest portal activity</p>
            </div>
            <div class="max-h-96 divide-y divide-slate-100 overflow-auto">
              <article class="border-l-4 border-cyan-600 bg-cyan-50 px-3 py-2 sm:px-4 sm:py-3">
                <p class="text-xs sm:text-sm font-semibold text-slate-950">New Booking</p>
                <p class="mt-1 text-xs text-slate-600">A Lexus RX booking request is waiting for review.</p>
              </article>
              <article class="border-l-4 border-cyan-600 bg-cyan-50 px-3 py-2 sm:px-4 sm:py-3">
                <p class="text-xs sm:text-sm font-semibold text-slate-950">Payment Received</p>
                <p class="mt-1 text-xs text-slate-600">Invoice #SL-2048 was paid successfully.</p>
              </article>
              <article class="px-3 py-2 sm:px-4 sm:py-3">
                <p class="text-xs sm:text-sm font-semibold text-slate-950">Driver Assigned</p>
                <p class="mt-1 text-xs text-slate-600">Marcus Lee has been assigned to tomorrow's airport transfer.</p>
              </article>
            </div>
          </div>
        </div>

        <!-- Profile -->
        <div class="relative shrink-0">
          <button id="profileButton" type="button" class="flex items-center gap-1 rounded border border-slate-300 bg-white/80 p-1 pr-2 text-slate-700 transition hover:border-slate-500 hover:bg-slate-100 hover:text-slate-900 sm:gap-2 sm:pr-3">
            <img class="h-6 w-6 rounded object-cover sm:h-7 sm:w-7 md:h-8 md:w-8" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80" alt="User avatar" />
            <i data-lucide="chevron-down" class="h-3 w-3 sm:h-4 sm:w-4"></i>
          </button>
          <div id="profileDropdown" class="absolute right-0 mt-3 hidden w-64 sm:w-72 overflow-hidden rounded border border-slate-200 bg-white shadow-2xl">
            <!-- dropdown content unchanged -->
            <div class="flex items-center gap-2 border-b border-slate-100 px-3 py-3 sm:gap-3 sm:px-4 sm:py-4">
              <img class="h-8 w-8 rounded object-cover sm:h-10 sm:w-10 md:h-12 md:w-12" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=160&q=80" alt="Ava Thompson profile" />
              <div>
                <p class="text-xs sm:text-sm font-bold text-slate-950">Ava Thompson</p>
                <p class="text-xs text-slate-500">ava@skyline.demo</p>
              </div>
            </div>
            <div class="p-1 sm:p-2">
              <a href="#" class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2"><i data-lucide="user" class="h-3 w-3 sm:h-4 sm:w-4"></i>My Profile</a>
              <a href="#" class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2"><i data-lucide="settings" class="h-3 w-3 sm:h-4 sm:w-4"></i>Account Settings</a>
              <a href="#" class="flex items-center gap-2 rounded px-2 py-1.5 text-xs sm:text-sm font-medium text-slate-700 hover:bg-slate-100 sm:gap-3 sm:px-3 sm:py-2"><i data-lucide="calendar-check" class="h-3 w-3 sm:h-4 sm:w-4"></i>Booking History</a>
              <button type="button" class="flex w-full items-center gap-2 rounded px-2 py-1.5 text-left text-xs sm:text-sm font-medium text-rose-600 hover:bg-rose-50 sm:gap-3 sm:px-3 sm:py-2"><i data-lucide="log-out" class="h-3 w-3 sm:h-4 sm:w-4"></i>Logout</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile menu button (unchanged) -->
    <button id="mobileMenuButton" type="button" class="grid h-8 w-8 place-items-center rounded border border-slate-300 text-slate-700 sm:h-9 sm:w-9 md:hidden" data-nav-contrast-button>
      <i data-lucide="menu" class="h-4 w-4 sm:h-5 sm:w-5"></i>
    </button>
  </nav>

  <!-- Mobile menu (unchanged) -->
  <div id="mobileMenu" class="mx-3 mb-4 hidden rounded border border-slate-200 bg-white/95 p-3 shadow-2xl backdrop-blur sm:mx-4 sm:p-4 md:hidden">
    <div class="grid gap-2">
      <a href="#home" class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100">Home</a>
      <a href="#about" class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100">About Us</a>
      <a href="#contact" class="rounded px-3 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100">Contact Us</a>
    </div>
    <div class="mt-3 border-t border-slate-200 pt-3 sm:mt-4 sm:pt-4">
      <div data-guest-ui class="grid grid-cols-2 gap-2 sm:gap-3">
        <button type="button" class="rounded border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 sm:px-4 sm:py-2 sm:text-sm">Sign In</button>
        <button type="button" class="rounded bg-cyan-600 px-3 py-1.5 text-xs font-bold text-white sm:px-4 sm:py-2 sm:text-sm">Register</button>
      </div>
      <div data-auth-ui class="hidden grid-cols-3 gap-2 sm:gap-3">
        <button type="button" data-sidebar-toggle class="rounded border border-slate-300 px-2 py-1.5 text-xs font-semibold text-slate-700 sm:px-3 sm:py-2 sm:text-sm">Sidebar</button>
        <button type="button" class="rounded border border-slate-300 px-2 py-1.5 text-xs font-semibold text-slate-700 sm:px-3 sm:py-2 sm:text-sm">Alerts</button>
        <button type="button" class="rounded bg-white px-2 py-1.5 text-xs font-bold text-slate-800 shadow sm:px-3 sm:py-2 sm:text-sm">Profile</button>
      </div>
    </div>
  </div>
</header>