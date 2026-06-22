<x-auth.layout>
     @section('header')
         Sign in to SkyLine
     @endsection
     <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-8 border border-white/20 animate-fade-in"
         style="animation-delay: 0.1s;">
         
         <div id="globalAuthAlert"
             class="hidden mb-4 rounded-xl border p-4 text-sm flex items-start gap-3 bg-red-500/20 text-red-200 border-red-500/30">
             <i data-lucide="x-circle" class="w-5 h-5 flex-shrink-0 text-red-400"></i>
             <span id="globalAlertMessage" class="font-medium"></span>
         </div>
         <form id="loginForm" class="space-y-4">
             @csrf
             <div class="group">
                 <label for="email" class="block text-sm font-semibold text-white mb-2">
                     <span class="inline-flex items-center gap-2">
                         <i data-lucide="mail" class="w-5 h-5 text-cyan-400"></i>
                         Email Address
                     </span>
                 </label>
                 <input type="email" id="email" name="email" required
                     class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border-2 border-white/20">
                 <span id="emailError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
             </div>
             <div class="group">
                 <label for="password" class="block text-sm font-semibold text-white mb-2">
                     <span class="inline-flex items-center gap-2">
                         <i data-lucide="key" class="w-5 h-5 text-cyan-400"></i>
                         Password
                     </span>
                 </label>
                 <input type="password" id="password" name="password" required
                     class="w-full px-4 py-2 rounded-lg bg-white/10 text-white border-2 border-white/20">
                 <span id="passwordError" class="text-xs text-red-400 font-medium mt-1 hidden block"></span>
             </div>
             <button type="submit" id="loginSubmitBtn"
                 class="w-full py-2 px-6 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold shadow-lg hover:shadow-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2 group">
                 <i data-lucide="log-in" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                 <span id="loginBtnText">Sign In</span>
             </button>
         </form>
         <div class="flex items-center gap-3 my-6">
             <div class="flex-1 h-px bg-white/20"></div>
             <span class="text-xs font-medium text-white/50">OR</span>
             <div class="flex-1 h-px bg-white/20"></div>
         </div>
         <div class="grid grid-cols-2 gap-3 mb-6">
             <button type="button"
                 class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                 <span class="text-sm">Google</span>
             </button>
             <button type="button"
                 class="px-4 py-2 rounded-lg bg-white/10 border-2 border-white/20 hover:border-white/40 text-white font-semibold transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                 <span class="text-sm">GitHub</span>
             </button>
         </div>
         <p class="text-center text-white/70">
             Don't have an account?
             <a href="{{ url('/register') }}"
                 class="font-bold text-cyan-400 hover:text-cyan-300 transition-colors">Create
                 one now</a>
         </p>
     </div>
     @push('scripts')
         <script>
             document.addEventListener('DOMContentLoaded', function() {
                 // Fetching key DOM layout nodes via jQuery selectors
                 const $form = $('#loginForm');
                 const $btn = $('#loginSubmitBtn');
                 const $btnText = $('#loginBtnText');
                 const $alert = $('#globalAuthAlert');
                 const $alertMsg = $('#globalAlertMessage');
                 // Global Ajax configuration to automatically append CSRF parameters
                 $.ajaxSetup({
                     headers: {
                         'X-CSRF-TOKEN': $("input[name='_token']").val()
                     }
                 });
                 // Trap form submit interaction
                 $form.on('submit', function(e) {
                     e.preventDefault();
                     
                     // Resetting previous runtime error indicators from user view
                     $('.text-xs').addClass('hidden').text('');
                     $alert.addClass('hidden');
                     // Activating visual loading feedback on submit trigger button
                     $btn.attr('disabled', true).addClass('opacity-75');
                     $btnText.text('Verifying...');
                     // Packaging input state details for request payload transfer
                     const payload = {
                         'email': $('#email').val().trim(),
                         'password': $('#password').val()
                     };
                     // Despatching async API verification request through jQuery AJAX
                     $.ajax({
                         url: "{{ route('api.login') }}",
                         method: 'POST',
                         contentType: 'application/json',
                         dataType: 'json',
                         data: JSON.stringify(payload),
                         success: function(response) {
                             if (response.success) {
                                 // Update interface context states upon valid match verification
                                 $btnText.text('Authenticated! Redirecting...');
                                 // Sanctum Architecture Integration: Saving the validated access token inside local browser memory storage
                                 localStorage.setItem('access_token', response.access_token);
                                 // Micro-delay navigation sequence to route target safely to administration desk
                                 setTimeout(() => {
                                     window.location.href = "{{ url('/admin/categories') }}";
                                     window.location.href = "{{ url('/admin') }}";
                                 }, 800);
                             }
                         },
                         error: function(xhr) {
                             // Restore button interactivity properties upon failure occurrence 
                             $btn.attr('disabled', false).removeClass('opacity-75');
                             $btnText.text('Sign In');
                             if (xhr.status === 422) {
                                 // Inject validation specific warning alerts under exact input nodes
                                 const validationErrors = xhr.responseJSON?.errors || {};
                                 if (validationErrors.email) {
                                     $('#emailError').removeClass('hidden').text(validationErrors.email[0]);
                                 }
                                 if (validationErrors.password) {
                                     $('#passwordError').removeClass('hidden').text(validationErrors.password[0]);
                                 }
                             } else {
                                 // Display structural access authentication blockages on the upper card warning alert
                                 const errorMessage = xhr.responseJSON?.message || 'Invalid email or password credentials.';
                                 $alertMsg.text(errorMessage);
                                 $alert.removeClass('hidden');
                             }
                         }
                     })
                 })
             })
         </script>
     @endpush
</x-auth.layout>
@php
    $isUserDashboardRoute = request()->routeIs(
        'dashboard',
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <title>SkyLine Automotive | Landing & Portal</title>
    <script>
        (function() {
            const theme = localStorage.getItem('theme') || localStorage.getItem('adminTheme') || 'light';
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        #dashboardSidebar {
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        /* Smooth navbar transitions */
        #siteHeader {
            transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        #mainWrapper {
            display: flex;
            flex-direction: column;
            flex: 1;
            width: 100%;
            min-width: 0;
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
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
        /* Mobile sidebar drawer */
        @media (max-width: 1023px) {
            #dashboardSidebar {
                position: fixed;
                left: 0;
                top: 0;
                bottom: 0;
                height: 100vh;
                overflow-y: auto;
                transform: translateX(-100%);
                z-index: 50;
            }
            #dashboardSidebarOverlay {
                position: fixed;
                inset: 0;
                background-color: rgba(15, 23, 42, 0.6);
                backdrop-filter: blur(4px);
                z-index: 40;
                display: none;
            }
            #dashboardSidebarOverlay.visible {
                display: block;
            }
            #dashboardSidebar.visible {
                transform: translateX(0);
            }
        }
        @media (min-width: 1024px) {
            #dashboardSidebarOverlay {
                display: none !important;
            }
            #dashboardSidebar {
                position: relative !important;
                height: auto;
                overflow: visible;
                transform: none !important;
            }
        }
        /* Active sidebar links styling to match admin panel */
        #dashboardSidebar a.is-active {
            background-color: rgba(6, 182, 212, 0.1);
            color: #0891b2;
        }
        .dark #dashboardSidebar a.is-active {
            background-color: rgba(6, 182, 212, 0.14);
            color: #22d3ee;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden">
    <div id="app" class="min-h-screen">
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased">
    <div id="app" class="flex min-h-screen w-full flex-row">
        <!-- Sidebar Overlay (Mobile) -->
        <div id="dashboardSidebarOverlay"></div>
        {{-- header --}}
        <x-user.nav />
        {{-- sidebar --}}
        <!-- Sidebar -->
        <x-user.sidebar />
        {{-- content --}}
        {{-- Add top padding only for guest (fixed navbar) --}}
        <main id="mainContent" class="transition-all duration-300">
            {{ $slot }}
        </main>
        <!-- Footer -->
        {{-- Footer --}}
        @if (!isset($hideFooter) || !$hideFooter)
            <x-user.footer />
        @endif
        <!-- Main Wrapper (Navbar + Main Content) -->
        <div id="mainWrapper" class="flex min-w-0 flex-1 flex-col">
            <!-- Navbar -->
            <x-user.nav />
            <!-- Main Content -->
            <main id="mainContent" class="w-full flex-1 overflow-x-hidden transition-all duration-300">
                {{ $slot }}
            </main>
            <!-- Footer -->
            @if (!isset($hideFooter) || !$hideFooter)
                <x-user.footer />
            @endif
        </div>
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
                authenticated: @json($isUserDashboardRoute),
                sidebarCollapsed: false,
                testimonialIndex: 0
                sidebarCollapsed: localStorage.getItem('userSidebarCollapsed') === 'true',
                theme: localStorage.getItem('theme') || localStorage.getItem('adminTheme') || 'light'
            };
            const testimonials = [ /* your testimonials array, unchanged */ ];
            let lastScrollY = window.scrollY;
            // 2. Core Functional Handlers
            function getElements() {
                return {
                    app: document.getElementById("app"),
                    sidebar: document.getElementById("dashboardSidebar"),
                    overlay: document.getElementById("dashboardSidebarOverlay"),
                    header: document.getElementById("siteHeader"),
                    mainWrapper: document.getElementById("mainWrapper"),
                    mainContent: document.getElementById("mainContent"),
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
                    mobileNavLinks: document.querySelectorAll('[data-mobile-nav]'),
                    themeToggle: document.getElementById('themeToggle')
                };
            }
            function safeCreateIcons() {
                if (typeof lucide !== "undefined" && typeof lucide.createIcons === "function") {
                    lucide.createIcons();
                    try {
                        lucide.createIcons();
                    } catch (e) {
                        console.log('Icons update skipped');
                    }
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
            // Theme Management
            function initTheme() {
                const html = document.documentElement;
                if (state.theme === 'dark') {
                    html.classList.add('dark');
                    updateThemeIcon('sun');
                } else {
                    el.sidebar.classList.add("top-20");
                    el.sidebar.classList.remove("top-0", "z-50");
                    el.header.classList.remove("z-40");
                    el.header.classList.add("z-50");
                    html.classList.remove('dark');
                    updateThemeIcon('moon');
                }
            }
            function updateThemeIcon(icon) {
                const el = getElements();
                const themeIcon = el.themeToggle?.querySelector('i');
                if (themeIcon) {
                    themeIcon.setAttribute('data-lucide', icon);
                    safeCreateIcons();
                }
            }
            function toggleTheme() {
                const html = document.documentElement;
                html.classList.toggle('dark');
                state.theme = html.classList.contains('dark') ? 'dark' : 'light';
                localStorage.setItem('theme', state.theme);
                localStorage.setItem('adminTheme', state.theme);
                updateThemeIcon(state.theme === 'dark' ? 'sun' : 'moon');
            }
            function setSidebarCollapsed(collapsed) {
                const el = getElements();
                if (!el.sidebar) return;
                state.sidebarCollapsed = collapsed;
                localStorage.setItem('userSidebarCollapsed', collapsed);
                if (collapsed) {
                    el.sidebar.classList.remove("w-60", "md:w-68");
                    el.sidebar.classList.add("w-16", "md:w-20");
                    el.sidebar.classList.remove("w-72");
                    el.sidebar.classList.add("w-20");
                } else {
                    el.sidebar.classList.remove("w-16", "md:w-20");
                    el.sidebar.classList.add("w-60", "md:w-68");
                    el.sidebar.classList.remove("w-20");
                    el.sidebar.classList.add("w-72");
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
            function toggleSidebarMobile() {
                const el = getElements();
                if (window.innerWidth < 1024) {
                    const isOpen = el.sidebar?.classList.contains('visible');
                    if (isOpen) {
                        el.sidebar?.classList.remove('visible');
                        el.overlay?.classList.remove('visible');
                    } else {
                        el.sidebar?.classList.add('visible');
                        el.overlay?.classList.add('visible');
                    }
                } else {
                    setSidebarCollapsed(!state.sidebarCollapsed);
                }
            }
            // CORRECTED setHeaderStyle function
            function closeSidebarMobile() {
                const el = getElements();
                if (window.innerWidth < 1024) {
                    el.sidebar?.classList.remove('visible');
                    el.overlay?.classList.remove('visible');
                }
            }
            function setHeaderStyle() {
                const el = getElements();
                if (!el.header) return;
                // AUTHENTICATED: always transparent, no white background
                // AUTHENTICATED: always solid navbar, aligned with admin layout
                if (state.authenticated) {
                    el.header.classList.remove("fixed", "inset-x-0", "top-0", "bg-transparent");
                    el.header.classList.remove("bg-white/95", "shadow-md", "shadow-lg", "backdrop-blur-sm");
                    el.header.classList.add("bg-transparent");
                    // Dark text for authenticated
                    el.header.className = "sticky top-0 z-40 w-full border-b border-slate-200 bg-white/90 shadow-sm backdrop-blur-md dark:border-slate-700 dark:bg-slate-900/90 dark:shadow-none";
                    el.navcontent.forEach(item => {
                        item.classList.remove("text-white/90", "text-white", "text-cyan-300");
                        item.classList.add(item.dataset.navActive === "true" ? "text-cyan-600" : "text-slate-950");
                        item.classList.add(item.dataset.navActive === "true" ? "text-cyan-600 dark:text-cyan-400" : "text-slate-900 dark:text-white");
                    });
                    document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                        item.classList.remove("text-white", "border-white/30");
                        item.classList.add("text-slate-800", "border-slate-300");
                        item.classList.add("text-slate-800", "border-slate-300", "dark:text-white", "dark:border-slate-700");
                    });
                    return;
                }
                // GUEST: scroll-dependent behavior
                const isSolid = window.scrollY > 75;
                // 1. Background & shadow
                if (isSolid) {
                    el.header.classList.add("bg-white/95", "shadow-md");
                    el.header.classList.remove("bg-transparent", "backdrop-blur-sm");
                    el.header.className = "fixed inset-x-0 top-0 z-50 bg-white/95 shadow-md border-b border-slate-200 dark:bg-slate-950/95 dark:border-slate-800 transition-all duration-400";
                    el.navcontent.forEach(item => {
                        item.classList.remove("text-white/90", "text-white", "text-cyan-300");
                        item.classList.add(item.dataset.navActive === "true" ? "text-cyan-600 dark:text-cyan-400" : "text-slate-900 dark:text-slate-100");
                    });
                    document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                        item.classList.remove("text-white", "border-white/30");
                        item.classList.add("text-slate-800", "border-slate-300", "dark:text-white", "dark:border-slate-700");
                    });
                } else {
                    el.header.classList.add("bg-transparent");
                    el.header.classList.remove("bg-white/95", "shadow-md", "backdrop-blur-sm");
                }
                // 2. Navigation link colors
                el.navcontent.forEach(item => {
                    if (isSolid) {
                        item.classList.remove("text-white/90", "text-white", "text-cyan-300");
                        item.classList.add(item.dataset.navActive === "true" ? "text-cyan-600" : "text-slate-950");
                    } else {
                        item.classList.remove("text-slate-950", "text-cyan-600");
                    el.header.className = "fixed inset-x-0 top-0 z-50 bg-transparent transition-all duration-400";
                    el.navcontent.forEach(item => {
                        item.classList.remove("text-slate-900", "text-cyan-600", "dark:text-slate-100", "dark:text-cyan-400");
                        item.classList.add(item.dataset.navActive === "true" ? "text-cyan-300" : "text-white/90");
                    }
                });
                // 3. Button colors (Sign In / Register)
                document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                    if (isSolid) {
                        item.classList.remove("text-white", "border-white/30");
                        item.classList.add("text-slate-800", "border-slate-300");
                    } else {
                        item.classList.remove("text-slate-800", "border-slate-300");
                    });
                    document.querySelectorAll("[data-nav-contrast-button]").forEach(item => {
                        item.classList.remove("text-slate-800", "border-slate-300", "dark:text-white", "dark:border-slate-700");
                        item.classList.add("text-white", "border-white/30");
                    }
                });
                    });
                }
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
                    
                    document.querySelectorAll("[data-guest-ui]").forEach(item => item.classList.add("hidden"));
                    el.authNavUI.forEach(item => item.classList.remove("hidden"));
                    
                    setSidebarCollapsed(localStorage.getItem('userSidebarCollapsed') === 'true' || window.innerWidth < 1024);
                } else {
                    el.mobileNavLinks.forEach(link => link.classList.remove('hidden'));
                    el.sidebar?.classList.add("hidden");
                    el.logo?.classList.remove("hidden");
                    el.navcontent.forEach(item => item.classList.remove("hidden"));
                    el.mainContent?.classList.remove("lg:pl-68", "lg:pl-20", "pl-64", "pl-16");
                    setSidebarPosition(false);
                    el.mobileNavLinks.forEach(link => link.classList.remove('hidden'));
                    
                    document.querySelectorAll("[data-guest-ui]").forEach(item => item.classList.remove("hidden"));
                    el.authNavUI.forEach(item => item.classList.add("hidden"));
                }
                if (el.authToggle) {
                    el.authToggle.textContent = `Switch Auth State: ${authenticated ? "Logged In" : "Guest"}`;
                }
                closeDropdowns();
                setHeaderStyle(); // Apply correct style after auth change
                setHeaderStyle();
                setActiveSidebarLinks();
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
            function setActiveSidebarLinks() {
                const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
                document.querySelectorAll('#dashboardSidebar a[href]').forEach(link => {
                    const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '') || '/';
                    const isActive = linkPath === currentPath;
                    link.classList.toggle('is-active', isActive);
                });
            }
            // 3. Event Initializer Routine
            function setupApp() {
                const el = getElements();
                // Initialize theme
                initTheme();
                // Scroll Handler: Only applies to GUEST STATE
                window.addEventListener("scroll", () => {
                    setHeaderStyle();
                    el.profileButton.setAttribute("aria-expanded", String(!isHidden));
                });
                // Theme Toggle handler
                el.themeToggle?.addEventListener("click", (e) => {
                    e.preventDefault();
                    toggleTheme();
                });
                // Dismiss click interceptors
                document.addEventListener("click", closeDropdowns);
                [el.notificationDropdown, el.profileDropdown].forEach(drop => {
                });
                el.sidebarToggleButtons.forEach(btn => {
                    btn.addEventListener("click", toggleSidebarCollapse);
                    btn.addEventListener("click", toggleSidebarMobile);
                });
                // Overlay Click triggers (Mobile)
                el.overlay?.addEventListener('click', closeSidebarMobile);
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
                    if (state.authenticated && window.innerWidth < 1024 && !state.sidebarCollapsed) {
                        setSidebarCollapsed(true);
                    }
                });
                // Initialize View Contexts
                renderTestimonial();
                setAuthState(state.authenticated);
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
