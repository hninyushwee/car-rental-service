<!DOCTYPE html>
@php
    $isUserDashboardRoute = request()->routeIs(
        'dashboard',
        'rent_car',
        'car_form',
        'rent_driver',
        'driver_form',
        'license',
        'history',
        'inquiry',
        'profile',
        'noti'
    );
@endphp
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <title>SkyLine Automotive | Landing & Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @if (!$isUserDashboardRoute)
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    @endif
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { overflow-x: hidden; }

        @if ($isUserDashboardRoute)
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        #userApp { display: flex; height: 100vh; width: 100%; overflow: hidden; }
        #userSidebar { transition: width 300ms cubic-bezier(0.4, 0, 0.2, 1), transform 300ms cubic-bezier(0.4, 0, 0.2, 1); }
        #userNavbar { left: 0; transition: left 300ms cubic-bezier(0.4, 0, 0.2, 1); }
        #userMainWrapper { display: flex; flex-direction: column; flex: 1; width: 100%; overflow: hidden; min-height: 0; }
        #mainContent { flex: 1; overflow-y: auto; overflow-x: hidden; width: 100%; min-height: 0; }

        @media (min-width: 1024px) {
            #userSidebar { width: 18rem; }
            #userNavbar { left: 18rem; }
            #userApp.sidebar-collapsed #userSidebar { width: 5rem; }
            #userApp.sidebar-collapsed #userNavbar { left: 5rem; }
            #userApp.sidebar-collapsed [data-sidebar-label] { display: none; }
            #userApp.sidebar-collapsed #userSidebarBrand {
                display: none;
            }

            #userApp.sidebar-collapsed #userSidebarHeader {
                justify-content: center;
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            #userSidebarCollapseToggle { display: flex; }
        }

        @media (max-width: 1023px) {
            #userSidebarCollapseToggle { display: none; }
        }

        @media (max-width: 1023px) {
            #userSidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                height: 100vh;
                width: 18rem !important;
                transform: translateX(-100%);
                z-index: 50;
            }
            #userSidebarOverlay {
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                display: none;
            }
            #userSidebarOverlay.visible { display: block; }
            #userSidebar.visible { transform: translateX(0); }
        }
        @media (min-width: 1024px) {
            #userSidebarOverlay { display: none !important; }
            #userSidebar { transform: none !important; }
        }
        @else
        #siteHeader {
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        backdrop-filter 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #siteHeader [data-nav-contrast],
        #siteHeader [data-nav-contrast-button] {
            transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @endif
    </style>
    @stack('styles')
</head>

<body class="{{ $isUserDashboardRoute ? 'bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 h-full overflow-hidden' : 'bg-slate-50 overflow-x-hidden' }} text-slate-900 dark:text-slate-100 antialiased">

@if ($isUserDashboardRoute)
    {{-- Authenticated: admin-style layout with sidebar + navbar --}}
    <div id="userApp" class="flex w-full h-screen overflow-hidden">
        <div id="userSidebarOverlay"></div>
        <x-user.sidebar />
        <div id="userMainWrapper" class="flex flex-col flex-1 w-full pt-16 transition-all duration-300">
            <x-user.auth-navbar />
            <main id="mainContent" class="flex-1 overflow-y-auto overflow-x-hidden w-full">
                {{ $slot }}
            </main>
        </div>
    </div>
@else
    {{-- Guest: landing navbar only, no sidebar --}}
    <div id="app" class="min-h-screen">
        <x-user.nav />
        <main id="mainContent">
            {{ $slot }}
        </main>
        @if (!isset($hideFooter) || !$hideFooter)
            <x-user.footer />
        @endif
    </div>
@endif

{{-- Demo auth toggle --}}
<button id="authToggle" type="button"
    class="fixed bottom-4 right-4 z-50 max-w-[calc(100vw-2rem)] rounded bg-cyan-400 px-4 py-3 text-xs font-black text-slate-950 shadow-2xl shadow-cyan-950/30 transition hover:bg-cyan-300">
    Switch Auth State: {{ $isUserDashboardRoute ? 'Logged In' : 'Guest' }}
</button>

<script>
(function() {
    const isDashboardRoute = @json($isUserDashboardRoute);

    function createIcons() {
        if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
            lucide.createIcons();
        }
    }

    @if ($isUserDashboardRoute)
    // Auth layout (matches admin behavior)
    const state = {
        sidebarOpen: window.innerWidth >= 1024,
        sidebarCollapsed: localStorage.getItem('userSidebarCollapsed') === 'true',
        theme: localStorage.getItem('userTheme') || 'light'
    };

    function applySidebarCollapsed(collapsed) {
        const el = getAuthElements();
        state.sidebarCollapsed = collapsed;
        document.getElementById('userApp')?.classList.toggle('sidebar-collapsed', collapsed);
        localStorage.setItem('userSidebarCollapsed', collapsed ? 'true' : 'false');

        document.querySelectorAll('[data-sidebar-collapse-toggle]').forEach(btn => {
            const icon = btn.querySelector('i');
            if (icon) {
                icon.setAttribute('data-lucide', collapsed ? 'panel-right' : 'panel-left');
            }
            btn.setAttribute('aria-expanded', String(!collapsed));
        });
        createIcons();
    }

    function toggleSidebarCollapse() {
        applySidebarCollapsed(!state.sidebarCollapsed);
    }

    function getAuthElements() {
        return {
            sidebar: document.getElementById('userSidebar'),
            overlay: document.getElementById('userSidebarOverlay'),
            sidebarToggle: document.getElementById('userSidebarToggle'),
            sidebarCollapseToggle: document.getElementById('userSidebarCollapseToggle'),
            themeToggle: document.getElementById('userThemeToggle'),
            notificationBtn: document.getElementById('userNotificationBtn'),
            notificationDropdown: document.getElementById('userNotificationDropdown'),
            profileBtn: document.getElementById('userProfileBtn'),
            profileDropdown: document.getElementById('userProfileDropdown'),
            authToggle: document.getElementById('authToggle'),
            logoutBtn: document.getElementById('userLogoutBtn')
        };
    }

    function initTheme() {
        const html = document.documentElement;
        const icon = state.theme === 'dark' ? 'sun' : 'moon';
        html.classList.toggle('dark', state.theme === 'dark');
        const themeIcon = getAuthElements().themeToggle?.querySelector('i');
        if (themeIcon) {
            themeIcon.setAttribute('data-lucide', icon);
            createIcons();
        }
    }

    function toggleTheme() {
        state.theme = state.theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('userTheme', state.theme);
        initTheme();
    }

    function toggleSidebarMobile() {
        const el = getAuthElements();
        if (window.innerWidth >= 1024) {
            return;
        }

        state.sidebarOpen = !state.sidebarOpen;
        el.sidebar?.classList.toggle('visible', state.sidebarOpen);
        el.overlay?.classList.toggle('visible', state.sidebarOpen);
    }

    function closeSidebarMobile() {
        const el = getAuthElements();
        if (window.innerWidth < 1024) {
            state.sidebarOpen = false;
            el.sidebar?.classList.remove('visible');
            el.overlay?.classList.remove('visible');
        }
    }

    function closeDropdowns() {
        const el = getAuthElements();
        el.notificationDropdown?.classList.add('hidden');
        el.profileDropdown?.classList.add('hidden');
    }

    function initAuthLayout() {
        const el = getAuthElements();
        initTheme();
        applySidebarCollapsed(state.sidebarCollapsed);

        el.sidebarToggle?.addEventListener('click', (e) => {
            e.preventDefault();
            toggleSidebarMobile();
        });

        document.querySelectorAll('[data-sidebar-collapse-toggle]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                toggleSidebarCollapse();
            });
        });
        el.overlay?.addEventListener('click', closeSidebarMobile);
        el.themeToggle?.addEventListener('click', (e) => {
            e.preventDefault();
            toggleTheme();
        });
        el.notificationBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            closeDropdowns();
            el.notificationDropdown?.classList.toggle('hidden');
        });
        el.profileBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            closeDropdowns();
            el.profileDropdown?.classList.toggle('hidden');
        });
        document.addEventListener('click', closeDropdowns);
        el.notificationDropdown?.addEventListener('click', (e) => e.stopPropagation());
        el.profileDropdown?.addEventListener('click', (e) => e.stopPropagation());

        document.querySelectorAll('#userSidebar a').forEach(link => {
            link.addEventListener('click', closeSidebarMobile);
        });

        el.authToggle?.addEventListener('click', () => { window.location.href = '/'; });
        el.logoutBtn?.addEventListener('click', () => { window.location.href = '/'; });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                state.sidebarOpen = true;
                el.sidebar?.classList.remove('visible');
                el.overlay?.classList.remove('visible');
            }
        });

        createIcons();
    }
    @else
    // Guest layout: transparent over dark hero, solid on scroll
    function getHeroScrollThreshold() {
        const hero = document.querySelector('[data-hero-section]');
        return hero ? Math.max(hero.offsetHeight - 80, 75) : 75;
    }

    function setHeaderStyle() {
        const header = document.getElementById('siteHeader');
        if (!header) return;

        const isSolid = window.scrollY > getHeroScrollThreshold();
        const links = header.querySelectorAll('[data-nav-contrast]');
        const buttons = header.querySelectorAll('[data-nav-contrast-button]');

        header.setAttribute('data-scrolled', isSolid ? 'true' : 'false');

        if (isSolid) {
            header.classList.add('bg-white/95', 'shadow-md', 'backdrop-blur-md');
            header.classList.remove('bg-transparent');
            links.forEach(item => {
                item.classList.remove('text-white/90', 'text-white', 'text-cyan-300');
                item.classList.add('text-slate-950');
            });
            buttons.forEach(item => {
                item.classList.remove('text-white', 'border-white/30');
                item.classList.add('text-slate-800', 'border-slate-300');
            });
        } else {
            header.classList.remove('bg-white/95', 'shadow-md', 'backdrop-blur-md');
            header.classList.add('bg-transparent');
            links.forEach(item => {
                item.classList.remove('text-slate-950');
                item.classList.add('text-white/90');
            });
            buttons.forEach(item => {
                item.classList.remove('text-slate-800', 'border-slate-300');
                item.classList.add('text-white', 'border-white/30');
            });
        }
    }

    function initGuestLayout() {
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const mobileMenu = document.getElementById('mobileMenu');
        const authToggle = document.getElementById('authToggle');

        window.addEventListener('scroll', setHeaderStyle, { passive: true });
        window.addEventListener('resize', setHeaderStyle, { passive: true });

        mobileMenuButton?.addEventListener('click', () => {
            const isClosed = mobileMenu?.classList.contains('hidden');
            mobileMenu?.classList.toggle('hidden', !isClosed);
            mobileMenuButton.setAttribute('aria-expanded', String(isClosed));
        });

        mobileMenu?.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => mobileMenu?.classList.add('hidden'));
        });

        authToggle?.addEventListener('click', () => { window.location.href = '/home'; });

        setHeaderStyle();
        createIcons();
    }
    @endif

    function init() {
        @if ($isUserDashboardRoute)
        initAuthLayout();
        @else
        initGuestLayout();
        @endif
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@stack('scripts')
</body>
</html>
