<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <title>SkyLine Automotive | Landing & Portal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* Ensure auth UI never wraps on any screen */
        [data-auth-ui] {
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
        }

        /* Prevent entire navigation flex parent from dropping down items */
        #siteHeader nav {
            flex-wrap: nowrap !important;
        }

        /* For very small screens, reduce gap */
        @media (max-width: 640px) {
            [data-auth-ui] {
                gap: 0.35rem !important;
            }

            #siteHeader nav {
                gap: 0.35rem !important;
                padding-left: 0.5rem !important;
                padding-right: 0.5rem !important;
            }
        }

        /* Smooth transitions for sidebar and main content */
        #dashboardSidebar,
        #mainContent {
            transition-property: width, padding-left;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Smooth navbar transitions */
        #siteHeader {
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #siteHeader [data-nav-contrast],
        #siteHeader [data-nav-contrast-button] {
            transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Prevent horizontal overflow on mobile */
        body {
            overflow-x: hidden;
        }

        /* For very small screens, reduce gap */
        @media (max-width: 640px) {
            [data-auth-ui] {
                gap: 0.5rem !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">
    <div id="app" class="min-h-screen">

        {{-- header --}}
        <x-user.partials.nav />
        {{-- sidebar --}}
        <x-user.partials.sidebar />
        {{-- content --}}
        {{-- Add top padding only for guest (fixed navbar) --}}
        <main id="mainContent" class="transition-all duration-300">
            {{ $slot }}
        </main>
        <!-- Footer -->
        {{-- Footer --}}
        @if (!isset($hideFooter) || !$hideFooter)
            <x-user.partials.footer />
        @endif

        <!-- Demo toggle -->
        <button id="authToggle" type="button"
            class="fixed bottom-4 right-4 z-50 max-w-[calc(100vw-2rem)] rounded bg-cyan-400 px-4 py-3 text-xs font-black text-slate-950 shadow-2xl shadow-cyan-950/30 transition hover:bg-cyan-300">
            Switch Auth State: Guest
        </button>
    </div>

    <script>
        (function() {
            // 1. Application State
            const state = {
                authenticated: false,
                sidebarCollapsed: false,
                testimonialIndex: 0
            };

            const testimonials = [ /* your testimonials array, unchanged */ ];
            let lastScrollY = window.scrollY;

            // 2. Core Functional Handlers
            function getElements() {
                return {
                    header: document.getElementById("siteHeader"),
                    mobileMenu: document.getElementById("mobileMenu"),
                    mobileMenuButton: document.getElementById("mobileMenuButton"),
                    authToggle: document.getElementById("authToggle"),
                    sidebar: document.getElementById("dashboardSidebar"),
                    mainContent: document.getElementById("mainContent"),
                    notificationButton: document.getElementById("notificationButton"),
                    notificationDropdown: document.getElementById("notificationDropdown"),
                    profileButton: document.getElementById("profileButton"),
                    profileDropdown: document.getElementById("profileDropdown"),
                    logo: document.getElementById("logo"),
                    logoText: document.getElementById("logoText"),
                    sidebarToggleButtons: document.querySelectorAll("[data-sidebar-toggle]"),
                    navcontent: document.querySelectorAll("[data-nav-contrast]"),
                    authNavUI: document.querySelectorAll("[data-auth-ui]"),
                    mobileNavLinks: document.querySelectorAll('[data-mobile-nav]')
                };
            }

            function safeCreateIcons() {
                if (typeof lucide !== "undefined" && typeof lucide.createIcons === "function") {
                    lucide.createIcons();
                }
            }

            function closeDropdowns() {
                const el = getElements();
                el.notificationDropdown?.classList.add("hidden");
                el.profileDropdown?.classList.add("hidden");
                el.notificationButton?.setAttribute("aria-expanded", "false");
                el.profileButton?.setAttribute("aria-expanded", "false");
            }

            function closeMobileMenu() {
                const el = getElements();
                el.mobileMenu?.classList.add("hidden");
                el.mobileMenuButton?.setAttribute("aria-expanded", "false");
            }

            function setSidebarPosition(authenticated) {
                const el = getElements();
                if (!el.sidebar || !el.header) return;

                if (authenticated) {
                    el.sidebar.classList.remove("top-20");
                    el.sidebar.classList.add("top-0", "z-50");
                    el.header.classList.remove("z-50");
                    el.header.classList.add("z-40");
                } else {
                    el.sidebar.classList.add("top-20");
                    el.sidebar.classList.remove("top-0", "z-50");
                    el.header.classList.remove("z-40");
                    el.header.classList.add("z-50");
                }
            }

            function setSidebarCollapsed(collapsed) {
                const el = getElements();
                if (!el.sidebar) return;
                state.sidebarCollapsed = collapsed;

                if (collapsed) {
                    el.sidebar.classList.remove("w-60", "md:w-68");
                    el.sidebar.classList.add("w-16", "md:w-20");
                } else {
                    el.sidebar.classList.remove("w-16", "md:w-20");
                    el.sidebar.classList.add("w-60", "md:w-68");
                }

                el.logoText?.classList.toggle("hidden", collapsed);
                document.querySelectorAll("[data-sidebar-label]").forEach(item => item.classList.toggle("hidden",
                    collapsed));
                
                // Hide sidebar logo image when collapsed
                const sidebarLogo = el.sidebar?.querySelector("img");
                if (sidebarLogo) {
                    sidebarLogo.classList.toggle("hidden", collapsed);
                }

                if (el.mainContent) {
                    if (collapsed) {
                        el.mainContent.classList.remove("lg:pl-68", "pl-64");
                        el.mainContent.classList.add("lg:pl-20", "pl-16");
                    } else {
                        el.mainContent.classList.remove("lg:pl-20", "pl-16");
                        el.mainContent.classList.add("lg:pl-68", "pl-64");
                    }
                }

                el.sidebarToggleButtons.forEach(btn => {
                    const icon = btn.querySelector("i");
                    if (icon) {
                        icon.setAttribute("data-lucide", collapsed ? "panel-right" : "panel-left");
                    }
                    btn.setAttribute("aria-expanded", String(!collapsed));
                });
                safeCreateIcons();
            }

            function toggleSidebarCollapse() {
                if (!state.authenticated) return;
                setSidebarCollapsed(!state.sidebarCollapsed);
            }

            // CORRECTED setHeaderStyle function
            function setHeaderStyle() {
                const el = getElements();
                if (!el.header) return;

                // AUTHENTICATED: always transparent, no white background
                if (state.authenticated) {
                    el.header.classList.remove("fixed", "inset-x-0", "top-0", "bg-transparent");
                    el.header.classList.remove("bg-white/95", "shadow-md", "shadow-lg", "backdrop-blur-sm");
                    el.header.classList.add("bg-transparent");
                    // Dark text for authenticated
                    el.navcontent.forEach(item => {
                        item.classList.remove("text-white/90", "text-white");
                        item.classList.add("text-slate-950");
                    });
                    document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                        item.classList.remove("text-white", "border-white/30");
                        item.classList.add("text-slate-800", "border-slate-300");
                    });
                    return;
                }

                // GUEST: scroll-dependent behavior
                const isSolid = window.scrollY > 75;

                // 1. Background & shadow
                if (isSolid) {
                    el.header.classList.add("bg-white/95", "shadow-md");
                    el.header.classList.remove("bg-transparent", "backdrop-blur-sm");
                } else {
                    el.header.classList.add("bg-transparent");
                    el.header.classList.remove("bg-white/95", "shadow-md", "backdrop-blur-sm");
                }

                // 2. Navigation link colors
                el.navcontent.forEach(item => {
                    if (isSolid) {
                        item.classList.remove("text-white/90", "text-white");
                        item.classList.add("text-slate-950");
                    } else {
                        item.classList.remove("text-slate-950");
                        item.classList.add("text-white/90", "text-white");
                    }
                });

                // 3. Button colors (Sign In / Register)
                document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                    if (isSolid) {
                        item.classList.remove("text-white", "border-white/30");
                        item.classList.add("text-slate-800", "border-slate-300");
                    } else {
                        item.classList.remove("text-slate-800", "border-slate-300");
                        item.classList.add("text-white", "border-white/30");
                    }
                });
            }

            function setAuthState(authenticated) {
                const el = getElements();
                state.authenticated = authenticated;
                el.header?.classList.remove("-translate-y-full");

                // Update navbar positioning and state attribute
                if (el.header) {
                    el.header.setAttribute("data-navbar-state", authenticated ? "auth" : "guest");
                    
                    if (authenticated) {
                        // AUTHENTICATED: Static position, always transparent
                        el.header.classList.remove("fixed");
                        el.header.classList.add("absolute", "right-0", "top-0");
                        el.header.classList.add("bg-transparent");
                        el.header.classList.remove("bg-white/95", "shadow-md", "shadow-lg", "backdrop-blur-sm");
                    } else {
                        // GUEST: Fixed position, transparent initially
                        el.header.classList.remove("absolute", "right-0", "top-0");
                        el.header.classList.add("fixed", "inset-x-0", "top-0", "bg-transparent");
                    }
                }

                // Handle main content padding for fixed navbar (guest state)
                // if (el.mainContent) {
                //     if (authenticated) {
                //         el.mainContent.classList.remove("pt-20");
                //     } else {
                //         el.mainContent.classList.add("pt-20");
                //     }
                // }

                document.querySelectorAll("[data-guest-ui]").forEach(item => item.classList.toggle("hidden",
                    authenticated));
                el.authNavUI.forEach(item => {
                    if (authenticated) {
                        item.classList.remove("hidden");
                    } else {
                        item.classList.add("hidden");
                    }
                });

                if (authenticated) {
                    el.sidebar?.classList.remove("hidden");
                    el.logo?.classList.add("hidden");
                    el.navcontent.forEach(item => item.classList.add("hidden"));
                    el.mobileNavLinks.forEach(link => link.classList.add('hidden'));
                    setSidebarCollapsed(window.innerWidth < 768);
                    setSidebarPosition(true);
                } else {
                    el.mobileNavLinks.forEach(link => link.classList.remove('hidden'));
                    el.sidebar?.classList.add("hidden");
                    el.logo?.classList.remove("hidden");
                    el.navcontent.forEach(item => item.classList.remove("hidden"));
                    el.mainContent?.classList.remove("lg:pl-68", "lg:pl-20", "pl-64", "pl-16");
                    setSidebarPosition(false);
                }

                if (el.authToggle) {
                    el.authToggle.textContent = `Switch Auth State: ${authenticated ? "Logged In" : "Guest"}`;
                }
                closeDropdowns();
                setHeaderStyle(); // Apply correct style after auth change
            }

            function renderTestimonial() {
                const current = testimonials[state.testimonialIndex];
                if (!current) return;

                const photo = document.getElementById("testimonialPhoto");
                const nameEl = document.getElementById("testimonialName");
                const reviewEl = document.getElementById("testimonialReview");
                const ratingEl = document.getElementById("testimonialRating");

                if (photo) photo.src = current.photo;
                if (nameEl) nameEl.textContent = current.name;
                if (reviewEl) reviewEl.textContent = current.review;

                if (ratingEl) {
                    ratingEl.innerHTML = Array.from({
                            length: 5
                        }, (_, i) =>
                        `<i data-lucide="star" class="h-5 w-5 ${i < current.rating ? "fill-current" : "opacity-30"}"></i>`
                    ).join("");
                }
                safeCreateIcons();
            }

            // 3. Event Initializer Routine
            function setupApp() {
                const el = getElements();

                // Scroll Handler: Only applies to GUEST STATE
                window.addEventListener("scroll", () => {
                    setHeaderStyle();
                }, {
                    passive: true
                });

                // Click Bindings for Notifications & Profiles
                el.notificationButton?.addEventListener("click", (e) => {
                    e.stopPropagation();
                    el.profileDropdown?.classList.add("hidden");
                    el.profileButton?.setAttribute("aria-expanded", "false");

                    const isHidden = el.notificationDropdown?.classList.toggle("hidden");
                    el.notificationButton.setAttribute("aria-expanded", String(!isHidden));
                });

                el.profileButton?.addEventListener("click", (e) => {
                    e.stopPropagation();
                    el.notificationDropdown?.classList.add("hidden");
                    el.notificationButton?.setAttribute("aria-expanded", "false");

                    const isHidden = el.profileDropdown?.classList.toggle("hidden");
                    el.profileButton.setAttribute("aria-expanded", String(!isHidden));
                });

                // Dismiss click interceptors
                document.addEventListener("click", closeDropdowns);
                [el.notificationDropdown, el.profileDropdown].forEach(drop => {
                    drop?.addEventListener("click", (e) => e.stopPropagation());
                });

                // Mobile Navigation Layout Intercepts
                el.mobileMenuButton?.addEventListener("click", () => {
                    const isClosed = el.mobileMenu?.classList.contains("hidden");
                    el.mobileMenu?.classList.toggle("hidden", !isClosed);
                    el.mobileMenuButton.setAttribute("aria-expanded", String(isClosed));
                });

                document.querySelectorAll("#mobileMenu a").forEach(link => {
                    link.addEventListener("click", closeMobileMenu);
                });

                el.sidebarToggleButtons.forEach(btn => {
                    btn.addEventListener("click", toggleSidebarCollapse);
                });

                // Simulator triggers
                el.authToggle?.addEventListener("click", () => setAuthState(!state.authenticated));

                document.getElementById('mobileNotificationBtn')?.addEventListener('click', () => {
                    closeMobileMenu();
                    el.notificationButton?.click();
                });

                document.getElementById('mobileLogoutBtn')?.addEventListener('click', () => {
                    setAuthState(false);
                    closeMobileMenu();
                });

                // Viewport Resizing
                window.addEventListener("resize", () => {
                    if (state.authenticated && window.innerWidth < 768 && !state.sidebarCollapsed) {
                        setSidebarCollapsed(true);
                    }
                });

                // Initialize View Contexts
                renderTestimonial();
                setAuthState(false); // Start as guest
                setHeaderStyle();    // Ensure initial style is applied
                safeCreateIcons();
            }

            // 4. Secure Dom Ready Bootstrap
            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", setupApp);
            } else {
                setupApp();
            }
        })();
    </script>
    @stack('scripts')
</body>

</html>
