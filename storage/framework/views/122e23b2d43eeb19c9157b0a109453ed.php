<?php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
    $isSuperAdmin = auth()->user()->hasRole('super-admin');

    $searchPages = [
        ["label" => "Dashboard", "url" => $adminUrl, "icon" => "grid-3x3"],
        ["label" => "My Profile", "url" => "$adminUrl/profile", "icon" => "user-circle"],
        ["label" => "All Bookings", "url" => "$adminUrl/bookings", "icon" => "calendar"],
        ["label" => "All Drivers", "url" => "$adminUrl/drivers", "icon" => "users"],
        ["label" => "Add Driver", "url" => "$adminUrl/drivers/add", "icon" => "user-plus"],
        ["label" => "Transactions", "url" => "$adminUrl/payments", "icon" => "credit-card"],
    ];

    if ($isSuperAdmin) {
        $searchPages = array_merge($searchPages, [
            ["label" => "All Vehicles", "url" => "$adminUrl/vehicles", "icon" => "car"],
            ["label" => "Add Vehicle", "url" => "$adminUrl/vehicles/add", "icon" => "car-plus"],
            ["label" => "Categories", "url" => "$adminUrl/categories", "icon" => "layers"],
            ["label" => "Brands", "url" => "$adminUrl/brands", "icon" => "tag"],
            ["label" => "Driver Documents", "url" => "$adminUrl/drivers/documents", "icon" => "file-text"],
            ["label" => "Customers", "url" => "$adminUrl/customers", "icon" => "users-round"],
            ["label" => "Reviews", "url" => "$adminUrl/customers/reviews", "icon" => "star"],
            ["label" => "Deposit Settings", "url" => "$adminUrl/deposit-settings", "icon" => "banknote"],
            ["label" => "All Promotions", "url" => "$adminUrl/promotions", "icon" => "tag"],
            ["label" => "Add Coupon", "url" => "$adminUrl/promotions/add", "icon" => "plus"],
        ]);
    }
?>

<header id="adminNavbar" class="fixed top-0 right-0 z-30 h-16 border-b-2 border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md">
    <nav class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 md:px-8 w-full">
        <!-- Left: Mobile sidebar drawer -->
        <div class="flex lg:hidden">
            <button id="adminSidebarToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Open menu">
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>

        <!-- Center: Search (Hidden on Mobile) -->
        <div class="hidden md:flex flex-1 max-w-md relative" id="adminSearchWrapper"
             data-pages='<?php echo e(json_encode($searchPages)); ?>'>
            <div class="relative w-full">
                <input id="adminSearchInput" type="search" placeholder="Search pages..." autocomplete="off" class="w-full rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-2 pl-10 text-sm text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 hover:border-slate-300 dark:hover:border-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400 dark:text-slate-500"></i>
            </div>
            <div id="adminSearchResults" class="absolute left-0 right-0 top-full mt-1 hidden overflow-hidden rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl"></div>
        </div>

        <!-- Right: Actions -->
        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <!-- Notifications -->
            <div class="relative">
                <button id="adminNotificationBtn" type="button" data-notifications-url="<?php echo e($adminUrl); ?>/notifications" class="relative flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                    <span id="adminNotificationCount" class="absolute -top-1 -right-1 hidden h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white leading-none"></span>
                </button>

                <div id="adminNotificationDropdown" class="absolute right-0 mt-2 hidden w-96 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="border-b border-slate-200 dark:border-slate-700 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Notifications</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Latest alerts</p>
                        </div>
                        <span id="adminNotificationBadge" class="hidden rounded-full bg-red-100 dark:bg-red-900/30 px-2.5 py-0.5 text-xs font-semibold text-red-600 dark:text-red-400"></span>
                    </div>
                    <div id="adminNotificationList" class="max-h-96 divide-y divide-slate-200 dark:divide-slate-700 overflow-auto">
                        <div class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Loading...</div>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle -->
            <button id="adminThemeToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                <i data-lucide="moon" class="h-5 w-5"></i>
            </button>

            <!-- Profile -->
            <div class="relative">
                <button id="adminProfileBtn" type="button" class="flex items-center gap-2 rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 p-1 pr-3 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <div class="flex h-8 w-8 items-center justify-center rounded bg-cyan-600 text-xs font-bold text-white uppercase">
                        <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                    </div>
                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                </button>

                <div id="adminProfileDropdown" class="absolute right-0 mt-2 hidden w-72 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded bg-cyan-600 text-lg font-bold text-white uppercase">
                            <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e(Auth::user()->email); ?></p>
                        </div>
                    </div>
                    <div class="p-2">
                        <a href="<?php echo e($adminUrl); ?>/profile" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="user" class="h-4 w-4"></i>My Profile
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="settings" class="h-4 w-4"></i>Settings
                        </a>
                        <button type="button" id="adminProfileLogoutBtn" class="flex w-full items-center gap-3 rounded-lg px-4 py-2 text-left text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                            <i data-lucide="log-out" class="h-4 w-4"></i>Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/components/admin/navbar.blade.php ENDPATH**/ ?>