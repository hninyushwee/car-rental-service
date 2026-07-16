<?php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
?>

<aside id="adminSidebar" class="h-screen flex-shrink-0 border-r-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 transition-all duration-300 flex flex-col overflow-hidden">
    <!-- Logo Section -->
    <div id="adminSidebarHeader" class="h-16 border-b-2 border-slate-200 dark:border-slate-700 px-4 flex items-center justify-between gap-2 flex-shrink-0">
        <div id="adminSidebarBrand" class="flex items-center gap-3 flex-1 min-w-0 overflow-hidden">
            <img id="adminSidebarLogo" src="<?php echo e(asset('images/logo.png')); ?>" alt="SkyLine" class="h-8 w-auto shrink-0">
            <span id="adminSidebarText" data-sidebar-label class="bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 bg-clip-text text-transparent font-black text-xl tracking-wide truncate">
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
        <a href="<?php echo e($adminUrl); ?>" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="grid-3x3" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Dashboard</span>
        </a>

        <!-- Notifications -->
        <a href="<?php echo e($adminUrl); ?>/notifications" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="bell" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Notifications</span>
        </a>

        <!-- Inquiries -->
        <a href="<?php echo e($adminUrl); ?>/inquiries" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
            <i data-lucide="message-circle" class="h-5 w-5 flex-shrink-0"></i>
            <span data-sidebar-label>Inquiries</span>
        </a>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Fleet
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
                <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Vehicles</a>
                <a href="<?php echo e(route('admin.vehicles.create')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Add Vehicle</a>
                <a href="<?php echo e(route('admin.categories.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Categories</a>
                <a href="<?php echo e(route('admin.brands.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Brands</a>
            </div>
        </div>
        <?php endif; ?>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Bookings
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
                <a href="<?php echo e($adminUrl); ?>/bookings" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Bookings</a>
            </div>
        </div>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Customers
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
                <a href="<?php echo e(route('admin.customers.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Customers</a>
            </div>
        </div>
        <?php endif; ?>
        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Financial
        </div>

        <!-- Deposit Settings -->
        <div>
            <a href="<?php echo e($adminUrl); ?>/deposit-settings" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i data-lucide="banknote" class="h-5 w-5 flex-shrink-0"></i>
                <span data-sidebar-label>Deposit Settings</span>
            </a>
        </div>

        <!-- Payment Management -->
        <div>
            <a href="<?php echo e($adminUrl); ?>/payments" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <i data-lucide="credit-card" class="h-5 w-5 flex-shrink-0"></i>
                <span data-sidebar-label>Payments</span>
            </a>
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
                <a href="<?php echo e($adminUrl); ?>/promotions" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Promotions</a>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
                <a href="<?php echo e(route('admin.promotions.create')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Add Coupon</a>
                <?php endif; ?>
            </div>
        </div>

        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Services
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
                <a href="<?php echo e($adminUrl); ?>/drivers" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Drivers</a>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
                <a href="<?php echo e(route('admin.drivers.create')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Add Driver</a>
                <a href="<?php echo e(route('admin.driving-license-types.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Driving License Types</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Fleet Status (staff) -->
        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'staff')): ?>
        <div>
            <button type="button" data-submenu-toggle class="w-full flex items-center justify-between rounded-xl px-4 py-3 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="flex items-center gap-3">
                    <i data-lucide="car" class="h-5 w-5 flex-shrink-0"></i>
                    <span data-sidebar-label>Fleet</span>
                </div>
                <i data-lucide="chevron-down" class="h-4 w-4 flex-shrink-0 transition-transform"></i>
            </button>
            <div class="submenu hidden space-y-1 px-4 py-2 ml-4 border-l-2 border-slate-200 dark:border-slate-700">
                <a href="<?php echo e($adminUrl); ?>/vehicles" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">All Vehicles</a>
            </div>
        </div>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Reports
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
                <a href="<?php echo e($adminUrl); ?>/analytics/bookings" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Bookings</a>
                <a href="<?php echo e($adminUrl); ?>/analytics/customers" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Customers</a>
            </div>
        </div>
        <?php endif; ?>

        <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
        <div data-sidebar-label class="px-4 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
            Configuration
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
                <a href="<?php echo e($adminUrl); ?>/profile" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">My Profile</a>
                <a href="<?php echo e(url('/admin/settings/roles')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Roles</a>
                <a href="<?php echo e(route('admin.staff.index')); ?>" class="block rounded-lg px-3 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition">Account</a>
            </div>
        </div>
        <?php endif; ?>
    </nav>

    <!-- Footer -->
    <div class="border-t-2 border-slate-200 dark:border-slate-700 p-2 flex-shrink-0">
        <button type="button" id="adminLogoutBtn" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
            <i data-lucide="log-out" class="h-4 w-4 flex-shrink-0"></i>
            <span data-sidebar-label>Logout</span>
        </button>
    </div>
</aside>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/components/admin/sidebar.blade.php ENDPATH**/ ?>