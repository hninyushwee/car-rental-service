<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="SkyLine Car Rental - Admin Dashboard" />
    <title>Admin Dashboard | SkyLine Car Rental</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }

        #adminApp {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        #adminSidebar {
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        #adminMainWrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            width: 100%;
            overflow: hidden;
        }

        #adminNavbar {
            transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        #adminMainContent {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            width: 100%;
        }

        /* Mobile sidebar drawer */
        @media (max-width: 1023px) {
            #adminSidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                transform: translateX(-100%);
                z-index: 50;
            }

            #adminSidebarOverlay {
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40;
                display: none;
            }

            #adminSidebarOverlay.visible {
                display: block;
            }

            #adminSidebar.visible {
                transform: translateX(0);
            }
        }

        @media (min-width: 1024px) {
            #adminSidebarOverlay {
                display: none !important;
            }

            #adminSidebar {
                position: relative !important;
                transform: none !important;
            }
        }

        /* Chart container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Smooth animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 600ms cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 text-slate-900 dark:text-slate-100 antialiased">
    <div id="adminApp" class="flex w-full min-h-screen">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="adminSidebarOverlay"></div>

        <!-- Sidebar -->
        <x-admin.sidebar />

        <!-- Main Wrapper: Navbar + Content -->
        <div id="adminMainWrapper" class="flex flex-col flex-1 w-full">
            <!-- Navbar -->
            <x-admin.navbar />

            <!-- Main Content -->
            <main id="adminMainContent" class="flex-1 overflow-y-auto overflow-x-hidden w-full">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        (function() {
            // State management
            const state = {
                sidebarOpen: window.innerWidth >= 1024,
                sidebarCollapsed: localStorage.getItem('adminSidebarCollapsed') === 'true',
                theme: localStorage.getItem('adminTheme') || 'light'
            };

            // Get all elements
            function getElements() {
                return {
                    app: document.getElementById('adminApp'),
                    sidebar: document.getElementById('adminSidebar'),
                    overlay: document.getElementById('adminSidebarOverlay'),
                    navbar: document.getElementById('adminNavbar'),
                    mainWrapper: document.getElementById('adminMainWrapper'),
                    mainContent: document.getElementById('adminMainContent'),
                    sidebarToggle: document.getElementById('adminSidebarToggle'),
                    themeToggle: document.getElementById('adminThemeToggle'),
                    notificationBtn: document.getElementById('adminNotificationBtn'),
                    notificationDropdown: document.getElementById('adminNotificationDropdown'),
                    profileBtn: document.getElementById('adminProfileBtn'),
                    profileDropdown: document.getElementById('adminProfileDropdown'),
                    submenuToggles: document.querySelectorAll('[data-submenu-toggle]')
                };
            }

            function updateIconsIfAvailable() {
                if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                    try {
                        lucide.createIcons();
                    } catch (e) {
                        console.log('Icons update skipped');
                    }
                }
            }

            // Initialize theme
            function initTheme() {
                const html = document.documentElement;
                if (state.theme === 'dark') {
                    html.classList.add('dark');
                    updateThemeIcon('sun');
                } else {
                    html.classList.remove('dark');
                    updateThemeIcon('moon');
                }
            }

            function updateThemeIcon(icon) {
                const el = getElements();
                const themeIcon = el.themeToggle?.querySelector('i');
                if (themeIcon) {
                    themeIcon.setAttribute('data-lucide', icon);
                    updateIconsIfAvailable();
                }
            }

            function toggleTheme() {
                state.theme = state.theme === 'light' ? 'dark' : 'light';
                localStorage.setItem('adminTheme', state.theme);
                initTheme();
            }

            // Sidebar management
            function toggleSidebarMobile() {
                const el = getElements();
                state.sidebarOpen = !state.sidebarOpen;

                if (state.sidebarOpen) {
                    el.sidebar?.classList.add('visible');
                    el.overlay?.classList.add('visible');
                } else {
                    el.sidebar?.classList.remove('visible');
                    el.overlay?.classList.remove('visible');
                }
            }

            function closeSidebarMobile() {
                const el = getElements();
                if (window.innerWidth < 1024) {
                    state.sidebarOpen = false;
                    el.sidebar?.classList.remove('visible');
                    el.overlay?.classList.remove('visible');
                }
            }

            // Dropdown management
            function closeAllDropdowns() {
                const el = getElements();
                el.notificationDropdown?.classList.add('hidden');
                el.profileDropdown?.classList.add('hidden');
            }

            // Submenu toggle
            function setupSubmenus() {
                const el = getElements();
                el.submenuToggles.forEach(toggle => {
                    toggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        const submenu = toggle.nextElementSibling;
                        if (submenu && submenu.classList.contains('submenu')) {
                            const isHidden = submenu.classList.contains('hidden');
                            submenu.classList.toggle('hidden', !isHidden);

                            const chevron = toggle.querySelector('i[data-lucide="chevron-down"]');
                            if (chevron) {
                                chevron.classList.toggle('rotate-180', !isHidden);
                            }
                        }
                    });
                });
            }

            // Initialize app
            function init() {
                const el = getElements();

                // Set initial theme
                initTheme();

                // Sidebar toggle
                el.sidebarToggle?.addEventListener('click', (e) => {
                    e.preventDefault();
                    toggleSidebarMobile();
                });

                // Theme toggle
                el.themeToggle?.addEventListener('click', (e) => {
                    e.preventDefault();
                    toggleTheme();
                });

                // Sidebar overlay click
                el.overlay?.addEventListener('click', closeSidebarMobile);

                // Close sidebar on link click (mobile)
                document.querySelectorAll('#adminSidebar a').forEach(link => {
                    link.addEventListener('click', closeSidebarMobile);
                });

                // Notification dropdown
                el.notificationBtn?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    closeAllDropdowns();
                    el.notificationDropdown?.classList.toggle('hidden');
                });

                // Profile dropdown
                el.profileBtn?.addEventListener('click', (e) => {
                    e.stopPropagation();
                    closeAllDropdowns();
                    el.profileDropdown?.classList.toggle('hidden');
                });

                // Close dropdowns on outside click
                document.addEventListener('click', closeAllDropdowns);
                el.notificationDropdown?.addEventListener('click', (e) => e.stopPropagation());
                el.profileDropdown?.addEventListener('click', (e) => e.stopPropagation());

                // Setup submenus
                setupSubmenus();

                // Handle window resize
                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        state.sidebarOpen = true;
                        el.sidebar?.classList.remove('visible');
                        el.overlay?.classList.remove('visible');
                    }
                });

                // Update icons
                updateIconsIfAvailable();
            }

            // Start when DOM is ready
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
