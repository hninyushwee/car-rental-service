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
        import('./admin/category-page.js');
        import('./admin/brand-page.js');
        import('./admin/vehicle-page.js');
        import('./admin/vehicle-form-page.js');
        import('./admin/vehicle-show-page.js');
        import('./admin/admin-layout.js');
    });
} else {
    import('./admin/category-page.js');
    import('./admin/brand-page.js');
    import('./admin/vehicle-page.js');
    import('./admin/vehicle-form-page.js');
    import('./admin/vehicle-show-page.js');
    import('./admin/admin-layout.js');
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
