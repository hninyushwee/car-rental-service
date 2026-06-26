<aside id="userSidebar" class="h-screen flex-shrink-0 border-r-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 transition-all duration-300 flex flex-col overflow-hidden">
    <!-- Logo Section (fixed at top) -->
    <div id="userSidebarHeader" class="h-16 border-b-2 border-slate-200 dark:border-slate-700 px-4 flex items-center justify-between gap-2 flex-shrink-0">
        <a id="userSidebarBrand" href="{{ route('dashboard') }}" class="flex items-center gap-3 flex-1 min-w-0 overflow-hidden">
            <img id="userSidebarLogo" src="{{ asset('images/logo.png') }}" alt="SkyLine" class="h-8 w-auto shrink-0">
            <span data-sidebar-label class="bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 bg-clip-text text-transparent font-black text-sm tracking-wide truncate">
                SkyLine Portal
            </span>
        </a>
        <button id="userSidebarCollapseToggle" type="button" data-sidebar-collapse-toggle
            class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:bg-slate-700"
            title="Collapse sidebar" aria-expanded="true">
            <i data-lucide="panel-left" class="h-4 w-4"></i>
        </button>
    </div>

    <!-- Navigation (scrolls independently) -->
    <nav class="flex-1 min-h-0 space-y-1 p-4 overflow-y-auto">
        <div data-sidebar-label class="px-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Overview
        </div>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="grid-3x3" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Dashboard</span>
        </a>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Services
        </div>
        <a href="{{ route('rent_car') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="car" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Rent a Car</span>
        </a>
        <a href="{{ route('rent_driver') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="user-check" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Hire a Driver</span>
        </a>
        <a href="{{ route('license') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="badge-check" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>License Services</span>
        </a>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Activity
        </div>
        <a href="{{ route('history') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="history" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Booking History</span>
        </a>
        <a href="{{ route('inquiry') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="messages-square" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>General Inquiries</span>
        </a>
    </nav>

    <!-- Footer (fixed at bottom) -->
    <div class="border-t-2 border-slate-200 dark:border-slate-700 p-2 flex-shrink-0">
        <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="help-circle" class="h-4 w-4 flex-shrink-0"></i>
            <span data-sidebar-label>Help</span>
        </button>
    </div>
</aside>
