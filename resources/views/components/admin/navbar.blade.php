<header id="adminNavbar" class="fixed top-0 right-0 z-30 h-16 border-b-2 border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md">
    <nav class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 md:px-8 w-full">
        <!-- Left: Mobile sidebar drawer -->
        <div class="flex lg:hidden">
            <button id="adminSidebarToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Open menu">
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>

        <!-- Center: Search (Hidden on Mobile) -->
        <div class="hidden md:flex flex-1 max-w-md">
            <div class="relative w-full">
                <input type="search" placeholder="Search..." class="w-full rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-4 py-2 pl-10 text-sm text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 hover:border-slate-300 dark:hover:border-slate-600 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                <i data-lucide="search" class="absolute left-3 top-2.5 h-4 w-4 text-slate-400 dark:text-slate-500"></i>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <!-- Notifications -->
            <div class="relative">
                <button id="adminNotificationBtn" type="button" class="relative flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                    <span class="absolute top-2 right-2 h-2.5 w-2.5 rounded-full bg-red-500 animate-pulse"></span>
                </button>

                <div id="adminNotificationDropdown" class="absolute right-0 mt-2 hidden w-96 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Notifications</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Latest alerts</p>
                    </div>
                    <div class="max-h-96 divide-y divide-slate-200 dark:divide-slate-700 overflow-auto">
                        <article class="border-l-4 border-cyan-500 bg-cyan-50 dark:bg-cyan-950 px-6 py-3 hover:bg-cyan-100 dark:hover:bg-cyan-900 cursor-pointer transition">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">New Booking</p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Lexus RX awaiting approval</p>
                        </article>
                        <article class="border-l-4 border-emerald-500 bg-emerald-50 dark:bg-emerald-950 px-6 py-3 hover:bg-emerald-100 dark:hover:bg-emerald-900 cursor-pointer transition">
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Payment Received</p>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">Invoice #SL-2048</p>
                        </article>
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
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="Admin" class="h-8 w-8 rounded object-cover">
                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                </button>

                <div id="adminProfileDropdown" class="absolute right-0 mt-2 hidden w-72 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" alt="Admin" class="h-12 w-12 rounded object-cover">
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Sarah Johnson</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">admin@skyline.com</p>
                        </div>
                    </div>
                    <div class="p-2">
                        <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="user" class="h-4 w-4"></i>My Profile
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="settings" class="h-4 w-4"></i>Settings
                        </a>
                        <button type="button" class="flex w-full items-center gap-3 rounded-lg px-4 py-2 text-left text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                            <i data-lucide="log-out" class="h-4 w-4"></i>Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
