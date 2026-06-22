<aside id="adminSidebar" class="h-screen flex-shrink-0 border-r-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 transition-all duration-300 flex flex-col overflow-hidden">
    <!-- Logo Section -->
    <div id="adminSidebarHeader" class="h-16 border-b-2 border-slate-200 dark:border-slate-700 px-4 flex items-center justify-between gap-2 flex-shrink-0">
        <div id="adminSidebarBrand" class="flex items-center gap-3 flex-1 min-w-0 overflow-hidden">
            <img id="adminSidebarLogo" src="{{ asset('images/logo.png') }}" alt="SkyLine" class="h-8 w-auto shrink-0">
            <span id="adminSidebarText" data-sidebar-label class="bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 bg-clip-text text-transparent font-black text-sm tracking-wide truncate">
                SkyLine Admin
            </span>
        </div>
        <button id="adminSidebarCollapseToggle" type="button" data-sidebar-collapse-toggle
            class="hidden h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:bg-slate-700"
            title="Collapse sidebar" aria-expanded="true">
            <i data-lucide="panel-left" class="h-4 w-4"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 min-h-0 space-y-1 p-4 overflow-y-auto">
        <div data-sidebar-label class="px-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Overview
        </div>
        <!-- Dashboard -->
        <a href="/admin" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="grid-3x3" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Dashboard</span>
        </a>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Fleet Management
        </div>

        <!-- Vehicle Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="car" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Vehicles</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/vehicles" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Vehicles</a>
                <a href="/admin/vehicles/add" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Add Vehicle</a>
                <a href="{{ route('admin.categories.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Categories</a>
                <a href="{{ route('admin.brands.index') }}" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Brands</a>
            </div>
        </div>

        <!-- Driver Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="users" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Drivers</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/drivers" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Drivers</a>
                <a href="/admin/drivers/add" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Add Driver</a>
                <a href="/admin/drivers/documents" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Documents</a>
            </div>
        </div>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Operations
        </div>

        <!-- Booking Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="calendar" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Bookings</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/bookings" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Bookings</a>
                <a href="/admin/bookings/pending" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Pending</a>
                <a href="/admin/bookings/active" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Active</a>
                <a href="/admin/bookings/completed" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Completed</a>
                <a href="/admin/bookings/cancelled" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Cancelled</a>
            </div>
        </div>

        <!-- Customer Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="users-round" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Customers</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/customers" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Customers</a>
                <a href="/admin/customers/reviews" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Reviews</a>
            </div>
        </div>

        <!-- Payment Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="credit-card" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Payments</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/payments/transactions" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Transactions</a>
                <a href="/admin/payments/invoices" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Invoices</a>
                <a href="/admin/payments/refunds" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Refunds</a>
            </div>
        </div>

        <!-- Promotion Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="tag" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Promotions</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/promotions/coupons" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Coupons</a>
                <a href="/admin/promotions" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Active</a>
            </div>
        </div>

        <!-- License Services -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="file-text" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Licenses</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/licenses/applications" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Applications</a>
                <a href="/admin/licenses/schedule" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Schedule</a>
                <a href="/admin/licenses/packages" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Packages</a>
            </div>
        </div>

        <!-- Content Management -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="layers" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Content</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/content/banners" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Banners</a>
                <a href="/admin/content/testimonials" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Testimonials</a>
                <a href="/admin/content/faq" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">FAQ</a>
                <a href="/admin/content/blog" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Blog</a>
            </div>
        </div>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Analytics
        </div>

        <!-- Analytics -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="bar-chart-3" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Analytics</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/reports/revenue" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Revenue</a>
                <a href="/admin/reports/bookings" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Bookings</a>
                <a href="/admin/reports/customers" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Customers</a>
            </div>
        </div>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            System Config
        </div>

        <!-- Settings -->
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="settings" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Settings</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="/admin/settings/general" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">General</a>
                <a href="/admin/settings/email" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Email</a>
                <a href="/admin/settings/roles" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Roles</a>
            </div>
        </div>
    </nav>

    <!-- Footer -->
    <div class="border-t-2 border-slate-200 dark:border-slate-700 p-2 flex-shrink-0">
        <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="help-circle" class="h-4 w-4 flex-shrink-0"></i>
            <span data-sidebar-label>Help</span>
        </button>
    </div>
</aside>
