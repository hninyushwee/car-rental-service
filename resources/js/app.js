import './jquery-global.js';

import 'owl.carousel';
import 'owl.carousel/dist/assets/owl.carousel.css';
import 'owl.carousel/dist/assets/owl.theme.default.css';

import Chart from 'chart.js/auto';
import Toastify from 'toastify-js';
import 'toastify-js/src/toastify.css';
import { createIcons, icons } from 'lucide';
import { Datepicker } from 'vanillajs-datepicker';
import 'vanillajs-datepicker/css/datepicker.css';
import './auth/login.js';
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        import('./admin/categories/category-page.js');
        import('./admin/brands/brand-page.js');
        import('./admin/vehicles/vehicle-page.js');
        import('./admin/vehicles/vehicle-form-page.js');
        import('./admin/vehicles/vehicle-show-page.js');
        import('./admin/drivers/driver-page.js');
        import('./admin/drivers/driver-form-page.js');
        import('./admin/drivers/driver-show-page.js');
        import('./admin/bookings/booking-page.js');
        import('./admin/bookings/booking-form-page.js');
        import('./admin/bookings/booking-show-page.js');
        import('./admin/payments/payment-page.js');
        import('./admin/payments/payment-show-page.js');
        import('./admin/promotions/promotion-page.js');
        import('./admin/promotions/promotion-form-page.js');
        import('./admin/promotions/promotion-show-page.js');
        import('./admin/inquiries/inquiry-page.js');
        import('./admin/inquiries/inquiry-show-page.js');
        import('./admin/roles/role-page.js');
        import('./admin/roles/role-form-page.js');
        import('./admin/driving-license-types/driving-license-type-page.js');
        import('./admin/staff/staff-page.js');
        import('./admin/staff/staff-form-page.js');
        import('./admin/customers/customer-page.js');
        import('./admin/customers/customer-show-page.js');
        import('./admin/deposits/deposit-page.js');
        import('./admin/deposits/deposit-form-page.js');
        import('./admin/notifications/notification-page.js');
        import('./admin/notifications/notification-show-page.js');
        import('./admin/admin-layout.js');
        import('./admin/analytics/analytics-bookings-page.js');
        import('./admin/analytics/analytics-customers-page.js');
        import('./admin/dashboard/dashboard-page.js');
        import('./admin/profile/profile-page.js');
        import('./user/booking-history-page.js');
        import('./user/inquiry-page.js');
        import('./user/notification-page.js');
        import('./user/rent-car-page.js');
        import('./user/rent-car-form-page.js');
        import('./user/rent-driver-page.js');
        import('./user/rent-driver-form-page.js');
    });
} else {
    import('./admin/categories/category-page.js');
    import('./admin/brands/brand-page.js');
    import('./admin/vehicles/vehicle-page.js');
    import('./admin/vehicles/vehicle-form-page.js');
    import('./admin/vehicles/vehicle-show-page.js');
    import('./admin/drivers/driver-page.js');
    import('./admin/drivers/driver-form-page.js');
    import('./admin/drivers/driver-show-page.js');
    import('./admin/bookings/booking-page.js');
    import('./admin/bookings/booking-form-page.js');
    import('./admin/bookings/booking-show-page.js');
    import('./admin/payments/payment-page.js');
    import('./admin/payments/payment-show-page.js');
    import('./admin/promotions/promotion-page.js');
    import('./admin/promotions/promotion-form-page.js');
    import('./admin/promotions/promotion-show-page.js');
    import('./admin/inquiries/inquiry-page.js');
    import('./admin/inquiries/inquiry-show-page.js');
    import('./admin/roles/role-page.js');
    import('./admin/roles/role-form-page.js');
    import('./admin/driving-license-types/driving-license-type-page.js');
    import('./admin/staff/staff-page.js');
    import('./admin/staff/staff-form-page.js');
    import('./admin/customers/customer-page.js');
    import('./admin/customers/customer-show-page.js');
    import('./admin/deposits/deposit-page.js');
    import('./admin/deposits/deposit-form-page.js');
    import('./admin/notifications/notification-page.js');
    import('./admin/notifications/notification-show-page.js');
    import('./admin/admin-layout.js');
    import('./admin/analytics/analytics-bookings-page.js');
    import('./admin/analytics/analytics-customers-page.js');
    import('./admin/dashboard/dashboard-page.js');
    import('./admin/profile/profile-page.js');
        import('./user/booking-history-page.js');
        import('./user/inquiry-page.js');
        import('./user/notification-page.js');
        import('./user/rent-car-page.js');
        import('./user/rent-car-form-page.js');
        import('./user/rent-driver-page.js');
        import('./user/rent-driver-form-page.js');
        import('./user/cart-page.js');
    }

window.Datepicker = Datepicker;
window.Chart = Chart;
window.Toastify = Toastify;

let iconObserver;
let iconRefreshQueued = false;

function initLucideIcons() {
    if (typeof createIcons === 'function') {
        iconObserver?.disconnect();
        createIcons({ icons });
        observeIconChanges();
    }
}
window.initLucideIcons = initLucideIcons;
window.lucide = {
    createIcons: initLucideIcons,
};

function queueIconRefresh() {
    if (iconRefreshQueued) return;

    iconRefreshQueued = true;
    window.requestAnimationFrame(() => {
        iconRefreshQueued = false;
        initLucideIcons();
    });
}

function observeIconChanges() {
    if (!document.body) return;

    iconObserver ??= new MutationObserver((mutations) => {
        const hasNewLucideIcon = mutations.some((mutation) => {
            return Array.from(mutation.addedNodes).some((node) => {
                if (!(node instanceof Element)) return false;

                return node.matches?.('[data-lucide]') || Boolean(node.querySelector?.('[data-lucide]'));
            });
        });

        if (hasNewLucideIcon) {
            queueIconRefresh();
        }
    });

    iconObserver.observe(document.body, { childList: true, subtree: true });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        initLucideIcons();
        observeIconChanges();
        window.dispatchEvent(new CustomEvent('jquery-ready'));
    });
} else {
    initLucideIcons();
    observeIconChanges();
    window.setTimeout(() => window.dispatchEvent(new CustomEvent('jquery-ready')), 0);
}
