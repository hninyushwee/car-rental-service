@php
    $desktopNavLink = 'relative rounded-full px-3 py-2 text-sm font-semibold transition hover:text-cyan-600 dark:hover:text-cyan-400 whitespace-nowrap text-white/90 after:absolute after:bottom-1 after:left-3 after:right-3 after:h-0.5 after:origin-left after:scale-x-0 after:rounded-full after:bg-cyan-400 after:transition-transform hover:after:scale-x-100';
    $desktopNavActive = 'text-cyan-300 after:scale-x-100';
    $mobileNavLink = 'rounded-lg px-3 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 transition hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-cyan-700 dark:hover:text-cyan-400';
    $mobileNavActive = 'bg-cyan-50 text-cyan-700 dark:bg-cyan-950/40 dark:text-cyan-400 ring-1 ring-cyan-100 dark:ring-cyan-900';
@endphp

<header id="siteHeader" class="fixed inset-x-0 top-0 z-50 bg-transparent transition-all duration-400 ease-in-out">
    <nav class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 md:px-8 flex-nowrap overflow-visible py-3">
        <!-- Logo -->
        <div class="flex shrink-0 items-center gap-1 sm:gap-2 md:gap-3">
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-1 sm:gap-2 flex-nowrap" aria-label="SKY Line home">
                <img class="h-8 w-auto object-contain sm:h-10 md:h-12" src="{{ asset('images/logo.png') }}" alt="SkyLine Automotive logo" />
                <p class="bg-gradient-to-r from-cyan-300 via-cyan-400 to-cyan-500 bg-clip-text text-transparent font-black text-xl sm:text-2xl md:text-3xl tracking-wide drop-shadow-md whitespace-nowrap">
                    SkyLine
                </p>
            </a>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="max-md:hidden flex items-center gap-2 lg:gap-4 shrink-0 flex-nowrap">
            <a href="{{ url('/') }}" class="{{ $desktopNavLink }} {{ request()->is('/') ? $desktopNavActive : '' }}" data-nav-contrast>Home</a>
            <a href="{{ url('/about') }}" class="{{ $desktopNavLink }} {{ request()->is('about') ? $desktopNavActive : '' }}" data-nav-contrast>About Us</a>
            <a href="{{ url('/contact') }}" class="{{ $desktopNavLink }} {{ request()->is('contact') ? $desktopNavActive : '' }}" data-nav-contrast>Contact Us</a>
        </div>

        <!-- Desktop Auth Buttons -->
        <div class="max-md:hidden flex items-center gap-2 sm:gap-3 shrink-0 flex-nowrap">
            <a href="{{ route('login') }}"
                class="rounded border border-white/30 px-3 py-1.5 text-xs font-semibold transition sm:px-4 sm:py-2 sm:text-sm whitespace-nowrap text-white"
                data-nav-contrast-button>Sign In</a>
            <a href="{{ route('register') }}"
                class="btn-primary rounded-xl px-4 py-2 text-xs sm:text-sm whitespace-nowrap">Register</a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" type="button"
            class="md:hidden grid h-10 w-10 place-items-center rounded-lg border border-white/30 text-white shrink-0"
            data-nav-contrast-button aria-expanded="false">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobileMenu"
        class="absolute right-3 mt-2 hidden w-64 rounded-2xl border border-slate-200 bg-white/95 p-3 shadow-2xl backdrop-blur dark:border-slate-800 dark:bg-slate-900/95 md:hidden"
        style="z-index: 60; top: 60px;">
        <div class="grid gap-2">
            <a href="{{ url('/') }}" class="{{ $mobileNavLink }} {{ request()->is('/') ? $mobileNavActive : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="{{ $mobileNavLink }} {{ request()->is('about') ? $mobileNavActive : '' }}">About Us</a>
            <a href="{{ url('/contact') }}" class="{{ $mobileNavLink }} {{ request()->is('contact') ? $mobileNavActive : '' }}">Contact Us</a>
        </div>
        <div class="mt-3 border-t border-slate-200 dark:border-slate-800 pt-3">
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('login') }}"
                    class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-xs font-semibold text-slate-700 dark:text-slate-200 bg-transparent text-center">Sign In</a>
                <a href="{{ route('register') }}"
                    class="rounded-lg bg-cyan-400 px-3 py-1.5 text-xs font-bold text-slate-950 text-center">Register</a>
            </div>
        </div>
    </div>
</header>
