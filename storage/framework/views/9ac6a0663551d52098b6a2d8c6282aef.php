<!DOCTYPE html>
<?php
    $isUserDashboardRoute = request()->routeIs(
        'dashboard',
        'rent_car',
        'car_form',
        'rent_driver',
        'driver_form',
        'history',
        'inquiry',
        'profile',
        'noti',
        'cart.view',
    );
?>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="SkyLine Automotive landing page and customer portal skeleton." />
    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <title>SkyLine Rental Service</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body {
            overflow-x: hidden;
        }

        <?php if($isUserDashboardRoute): ?>
            html,
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            #userApp {
                display: flex;
                height: 100vh;
                width: 100%;
                overflow: hidden;
            }

            #userSidebar {
                transition: width 300ms cubic-bezier(0.4, 0, 0.2, 1), transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            #userNavbar {
                left: 0;
                transition: left 300ms cubic-bezier(0.4, 0, 0.2, 1);
            }

            #userMainWrapper {
                display: flex;
                flex-direction: column;
                flex: 1;
                width: 100%;
                overflow: hidden;
                min-height: 0;
            }

            #mainContent {
                flex: 1;
                overflow-y: auto;
                overflow-x: hidden;
                width: 100%;
                min-height: 0;
            }

            @media (min-width: 1024px) {
                #userSidebar {
                    width: 16rem;
                }

                #userNavbar {
                    left: 16rem;
                }

                #userApp.sidebar-collapsed #userSidebar {
                    width: 5rem;
                }

                #userApp.sidebar-collapsed #userNavbar {
                    left: 5rem;
                }

                #userApp.sidebar-collapsed [data-sidebar-label] {
                    display: none;
                }

                #userApp.sidebar-collapsed #userSidebarBrand {
                    display: none;
                }

                #userApp.sidebar-collapsed #userSidebarHeader {
                    justify-content: center;
                    padding-left: 0.75rem;
                    padding-right: 0.75rem;
                }

                #userSidebarCollapseToggle {
                    display: flex;
                }
            }

            @media (max-width: 1023px) {
                #userSidebarCollapseToggle {
                    display: none;
                }
            }

            @media (max-width: 1023px) {
                #userSidebar {
                    position: fixed;
                    left: 0;
                    top: 0;
                    bottom: 0;
                    height: 100vh;
                    width: 16rem !important;
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

                #userSidebarOverlay.visible {
                    display: block;
                }

                #userSidebar.visible {
                    transform: translateX(0);
                }
            }

            @media (min-width: 1024px) {
                #userSidebarOverlay {
                    display: none !important;
                }

                #userSidebar {
                    transform: none !important;
                }
            }
        <?php else: ?>
            /* Fixed Blade syntax loop here */
            #siteHeader {
                transition: background-color 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    backdrop-filter 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }

            #siteHeader [data-nav-contrast],
            #siteHeader [data-nav-contrast-button] {
                transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
        <?php endif; ?>
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body
    class="<?php echo e($isUserDashboardRoute ? 'bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 h-full overflow-hidden' : 'bg-slate-50 overflow-x-hidden'); ?> text-slate-900 dark:text-slate-100 antialiased">

    <?php if($isUserDashboardRoute): ?>
        
        <div id="userApp" class="flex w-full h-screen overflow-hidden">
            <div id="userSidebarOverlay"></div>
            <?php if (isset($component)) { $__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0)): ?>
<?php $attributes = $__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0; ?>
<?php unset($__attributesOriginal42505c54f83dcbb6aeebf7efa5510ee0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0)): ?>
<?php $component = $__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0; ?>
<?php unset($__componentOriginal42505c54f83dcbb6aeebf7efa5510ee0); ?>
<?php endif; ?>
            <div id="userMainWrapper" class="flex flex-col flex-1 w-full pt-16 transition-all duration-300">
                <?php if (isset($component)) { $__componentOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user.auth-navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.auth-navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2)): ?>
<?php $attributes = $__attributesOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2; ?>
<?php unset($__attributesOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2)): ?>
<?php $component = $__componentOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2; ?>
<?php unset($__componentOriginal5e7a0be6e79b0fcdfc9c7c73c7c678c2); ?>
<?php endif; ?>
                <main id="mainContent" class="flex-1 overflow-y-auto overflow-x-hidden w-full">
                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>
    <?php else: ?>
        
        <div id="app" class="min-h-screen">
            <?php if (isset($component)) { $__componentOriginaled97b5f1170375a7714f46c78470d25a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled97b5f1170375a7714f46c78470d25a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user.nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled97b5f1170375a7714f46c78470d25a)): ?>
<?php $attributes = $__attributesOriginaled97b5f1170375a7714f46c78470d25a; ?>
<?php unset($__attributesOriginaled97b5f1170375a7714f46c78470d25a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled97b5f1170375a7714f46c78470d25a)): ?>
<?php $component = $__componentOriginaled97b5f1170375a7714f46c78470d25a; ?>
<?php unset($__componentOriginaled97b5f1170375a7714f46c78470d25a); ?>
<?php endif; ?>
            <main id="mainContent">
                <?php echo e($slot); ?>

            </main>
            <?php if (isset($component)) { $__componentOriginal4facf547bac205c07c49be298111d05d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4facf547bac205c07c49be298111d05d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4facf547bac205c07c49be298111d05d)): ?>
<?php $attributes = $__attributesOriginal4facf547bac205c07c49be298111d05d; ?>
<?php unset($__attributesOriginal4facf547bac205c07c49be298111d05d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4facf547bac205c07c49be298111d05d)): ?>
<?php $component = $__componentOriginal4facf547bac205c07c49be298111d05d; ?>
<?php unset($__componentOriginal4facf547bac205c07c49be298111d05d); ?>
<?php endif; ?>

        </div>
    <?php endif; ?>

    <script>
        (function() {
            const isDashboardRoute = <?php echo json_encode($isUserDashboardRoute, 15, 512) ?>;

            function createIcons() {
                if (typeof lucide !== 'undefined' && typeof lucide.createIcons === 'function') {
                    lucide.createIcons();
                }
            }

            <?php if($isUserDashboardRoute): ?>
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

                window.updateCartBadge = function() {
                    var badge = document.getElementById('cartBadge');
                    if (!badge) return;
                    var items = JSON.parse(localStorage.getItem('cartItems') || '[]');
                    if (items.length > 0) {
                        badge.textContent = items.length;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                };

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

                    async function handleLogout() {
                        try {
                            await fetch('/api/logout', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content || '',
                                    'Accept': 'application/json',
                                },
                            });
                        } catch (e) {}
                        window.location.href = '/login';
                    }

                    el.logoutBtn?.addEventListener('click', handleLogout);
                    document.getElementById('userLogoutSidebarBtn')?.addEventListener('click', handleLogout);

                    window.addEventListener('resize', () => {
                        if (window.innerWidth >= 1024) {
                            state.sidebarOpen = true;
                            el.sidebar?.classList.remove('visible');
                            el.overlay?.classList.remove('visible');
                        }
                    });

                    async function fetchUnreadCount() {
                        try {
                            const res = await fetch('/api/user/notifications/unread-count', {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content || ''
                                },
                            });
                            const json = await res.json();
                            const count = json?.data?.count ?? json?.count ?? 0;
                            const badge = document.getElementById('notifBadge');
                            if (badge) {
                                if (count > 0) {
                                    badge.textContent = count > 99 ? '99+' : count;
                                    badge.classList.remove('hidden');
                                    badge.classList.add('flex');
                                } else {
                                    badge.classList.add('hidden');
                                    badge.classList.remove('flex');
                                }
                            }
                        } catch (_) {}
                    }
                    window.fetchUnreadCount = fetchUnreadCount;

                    async function fetchNotifications() {
                        try {
                            const res = await fetch('/api/user/notifications?per_page=5', {
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        ?.content || ''
                                },
                            });
                            const json = await res.json();
                            const items = json?.data?.data ?? json?.data ?? [];
                            const list = document.getElementById('notifDropdownList');
                            if (!list) return;
                            if (!Array.isArray(items) || !items.length) {
                                list.innerHTML =
                                    '<div class="px-6 py-8 text-center text-sm text-slate-400">No notifications yet.</div>';
                                return;
                            }
                            const colors = {
                                booking: 'border-cyan-500 bg-cyan-50 dark:bg-cyan-950',
                                payment: 'border-emerald-500 bg-emerald-50 dark:bg-emerald-950',
                                inquiry: 'border-violet-500 bg-violet-50 dark:bg-violet-950',
                                system: 'border-purple-500 bg-purple-50 dark:bg-purple-950'
                            };
                            list.innerHTML = items.map(n => {
                                const c = colors[n.type] ||
                                'border-slate-400 bg-slate-50 dark:bg-slate-800';
                                return `<article class="border-l-4 ${c} px-6 py-3 hover:bg-opacity-80 cursor-pointer transition ${n.is_read ? 'opacity-60' : ''}" data-id="${n.id}" data-read="${n.is_read ? '1' : '0'}">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white">${n.title || ''}</p>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">${n.message || ''}</p>
                    </article>`;
                            }).join('');

                            list.querySelectorAll('article').forEach(el => {
                                el.addEventListener('click', function() {
                                    window.location.href = '/notifications';
                                });
                            });
                        } catch (_) {
                            const list = document.getElementById('notifDropdownList');
                            if (list) list.innerHTML =
                                '<div class="px-6 py-8 text-center text-sm text-red-400">Failed to load.</div>';
                        }
                    }

                    fetchUnreadCount();
                    setInterval(fetchUnreadCount, 30000);

                    el.notificationBtn?.addEventListener('click', () => {
                        fetchNotifications();
                    });

                    window.updateCartBadge();

                    document.addEventListener('cart-updated', window.updateCartBadge);
                    window.addEventListener('pageshow', window.updateCartBadge);

                    createIcons();
                }
            <?php else: ?>
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

                    window.addEventListener('scroll', setHeaderStyle, {
                        passive: true
                    });
                    window.addEventListener('resize', setHeaderStyle, {
                        passive: true
                    });

                    mobileMenuButton?.addEventListener('click', () => {
                        const isClosed = mobileMenu?.classList.contains('hidden');
                        mobileMenu?.classList.toggle('hidden', !isClosed);
                        mobileMenuButton.setAttribute('aria-expanded', String(isClosed));
                    });

                    mobileMenu?.querySelectorAll('a').forEach(link => {
                        link.addEventListener('click', () => mobileMenu?.classList.add('hidden'));
                    });

                    authToggle?.addEventListener('click', () => {
                        window.location.href = '/home';
                    });

                    setHeaderStyle();
                    createIcons();
                }
            <?php endif; ?>

            function init() {
                <?php if($isUserDashboardRoute): ?>
                    initAuthLayout();
                <?php else: ?>
                    initGuestLayout();
                <?php endif; ?>
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', init);
            } else {
                init();
            }
        })();
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/components/user/layout.blade.php ENDPATH**/ ?>