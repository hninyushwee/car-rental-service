import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function formatCurrency(amount) {
    return 'MMK ' + Number(amount || 0).toFixed(2);
}

function statusClass(status) {
    if (status === 'active') {
        return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
    }
    return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
}

function initPromotionShowPage() {
    const $page = $('[data-page="admin-promotion-show"]');
    if (!$page.length || $page.data('initialized')) return;

    $page.data('initialized', true);

    const promotionId = $page.data('id');
    const apiBase = $page.data('apiBase') || '/api/admin/promotions';
    const loginUrl = $page.data('loginUrl') || '/login';

    function showLoadError(error) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }

        $('#loadingState').html(`
            <div class="p-6 text-center text-red-500">
                <i data-lucide="alert-circle" class="mx-auto mb-2 h-10 w-10"></i>
                <p class="font-bold">Failed to load promotion details.</p>
            </div>
        `);
        notify(error.payload?.message || 'Failed to load promotion details.', 'error');
        refreshIcons();
    }

    function renderPromotion(promo) {
        const isPercent = promo.discount_type === 'percentage';
        const valueDisplay = isPercent ? promo.discount_value + '%' : formatCurrency(promo.discount_value);
        const maxDisplay = promo.max_discount ? formatCurrency(promo.max_discount) : '∞';
        const rawStatus = (promo.status || 'inactive').toLowerCase();

        $('#promoTitleCode').text(promo.code);
        $('#promoSubtitleDesc').text(`Promotion details for ${promo.code}.`);
        $('#promoCode').text(promo.code);
        $('#promoDiscountType').text(isPercent ? 'Percentage' : 'Fixed Amount');
        $('#promoDiscountValue').text(valueDisplay);
        $('#promoMinSpend').text(formatCurrency(promo.min_spend));
        $('#promoMaxDiscount').text(maxDisplay);
        $('#promoStartDate').text(promo.start_date?.split(' ')[0] || promo.start_date?.split('T')[0] || 'N/A');
        $('#promoEndDate').text(promo.end_date?.split(' ')[0] || promo.end_date?.split('T')[0] || 'N/A');
        $('#editPromoBtn').attr('href', `/admin/promotions/${promo.id}/edit`);

        if (promo.description?.trim()) {
            $('#promoDescription').text(promo.description);
        }

        const isActive = rawStatus === 'active';
        const statusLabel = isActive ? 'Active' : 'Inactive';
        $('#statusBadge').html(`<span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold ${statusClass(rawStatus)}"><span class="mr-1.5 h-2 w-2 rounded-full bg-current"></span>${statusLabel}</span>`);

        $('#loadingState').addClass('hidden');
        $('#detailsContent').removeClass('hidden').addClass('animate-fade-in');
        refreshIcons();
    }

    async function loadPromotion() {
        try {
            const response = await jsonRequest(`${apiBase}/${promotionId}`);
            const promo = response.data || response.promotion || response;
            renderPromotion(promo);
        } catch (error) {
            showLoadError(error);
        }
    }

    loadPromotion();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initPromotionShowPage();
} else {
    window.addEventListener('DOMContentLoaded', initPromotionShowPage);
    window.addEventListener('load', initPromotionShowPage);
}
