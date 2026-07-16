<header id="userNavbar" class="fixed top-0 right-0 z-30 h-16 border-b-2 border-slate-200 dark:border-slate-700 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md">
    <nav class="flex items-center justify-between gap-4 px-4 py-3 sm:px-6 md:px-8 w-full">
        <!-- Left: Mobile sidebar drawer -->
        <div class="flex lg:hidden">
            <button id="userSidebarToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition" title="Open menu">
                <i data-lucide="menu" class="h-5 w-5"></i>
            </button>
        </div>



        <!-- Right: Actions -->
        <div class="flex items-center gap-2 sm:gap-3 ml-auto">
            <!-- Cart -->
            <a href="{{ route('cart.view') }}" class="relative flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                <i data-lucide="shopping-cart" class="h-5 w-5"></i>
                <span id="cartBadge" class="absolute -top-1 -right-1 hidden inline-flex h-3.5 w-3.5 items-center justify-center rounded-full bg-red-500 text-[9px] font-bold text-white leading-none">0</span>
            </a>

            <!-- Notifications -->
            <div class="relative">
                <button id="userNotificationBtn" type="button" class="relative flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <i data-lucide="bell" class="h-5 w-5"></i>
                    <span id="notifBadge" class="absolute -top-0.5 -right-0.5 hidden h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white leading-none"></span>
                </button>

                <div id="userNotificationDropdown" class="absolute right-0 mt-2 hidden w-96 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Notifications</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Latest portal activity</p>
                        </div>
                        <a href="{{ route('noti') }}" class="text-xs font-medium text-cyan-600 hover:text-cyan-500 dark:text-cyan-400">View all</a>
                    </div>
                    <div id="notifDropdownList" class="max-h-96 divide-y divide-slate-200 dark:divide-slate-700 overflow-auto">
                        <div class="px-6 py-8 text-center text-sm text-slate-400">Loading...</div>
                    </div>
                </div>
            </div>

            <!-- Theme Toggle -->
            <button id="userThemeToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                <i data-lucide="moon" class="h-5 w-5"></i>
            </button>

            <!-- Profile -->
            <div class="relative">
                <button id="userProfileBtn" type="button" class="flex items-center gap-2 rounded-lg border-2 border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 p-1 pr-3 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=64&background=06b6d4&color=fff" alt="User" class="h-8 w-8 rounded object-cover">
                    <i data-lucide="chevron-down" class="h-4 w-4"></i>
                </button>

                <div id="userProfileDropdown" class="absolute right-0 mt-2 hidden w-72 overflow-hidden rounded-2xl border-2 border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-2xl">
                    <div class="flex items-center gap-3 border-b border-slate-200 dark:border-slate-700 px-6 py-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=96&background=06b6d4&color=fff" alt="User" class="h-12 w-12 rounded object-cover">
                        <div>
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="user" class="h-4 w-4"></i>My Profile
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="settings" class="h-4 w-4"></i>Account Settings
                        </a>
                        <a href="{{ route('history') }}" class="flex items-center gap-3 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition">
                            <i data-lucide="calendar-check" class="h-4 w-4"></i>Booking History
                        </a>
                        <button type="button" id="userLogoutBtn" class="flex w-full items-center gap-3 rounded-lg px-4 py-2 text-left text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                            <i data-lucide="log-out" class="h-4 w-4"></i>Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
