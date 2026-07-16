import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function initPromotionFormPage() {
    const $page = $('[data-page="admin-promotion-form"]');
    if (!$page.length || $page.data('initialized')) return;

    $page.data('initialized', true);

    const apiBase = $page.data('api-base');
    const promotionId = $page.data('promotion-id');
    const isEdit = $page.data('is-edit');
    const $form = $('#promotionForm');
    const $error = $('#formError');

    async function loadForm() {
        if (isEdit && promotionId) {
            try {
                const payload = await jsonRequest(`${apiBase}/${promotionId}`);
                const promo = payload.data || payload;
                $('#promoCode').val(promo.code || '');
                $('#promoType').val(promo.discount_type === 'fixed_amount' ? 'fixed' : (promo.type || promo.discount_type || 'percentage'));
                $('#promoValue').val(promo.discount_value ?? promo.value ?? '');
                $('#promoMinAmount').val(promo.min_spend ?? promo.min_amount ?? '');
                $('#promoMaxUses').val(promo.max_discount ?? promo.max_uses ?? '');
                $('#promoStartDate').val(promo.start_date ? promo.start_date.substring(0, 16) : (promo.starts_at ? promo.starts_at.substring(0, 16) : ''));
                $('#promoExpiresAt').val(promo.end_date ? promo.end_date.substring(0, 16) : (promo.expires_at ? promo.expires_at.substring(0, 16) : ''));
                $('#promoDescription').val(promo.description || '');
                $('#promoIsActive').prop('checked', promo.status ? promo.status === 'active' : (promo.is_active ?? true));
            } catch {
                $error.text('Failed to load promotion data.').removeClass('hidden');
            }
        }
    }

    $form.on('submit', async function (e) {
        e.preventDefault();
        $error.addClass('hidden');

        const data = Object.fromEntries(new FormData(this).entries());
        data.is_active = data.is_active === '1';
        if (!data.starts_at) delete data.starts_at;
        if (!data.expires_at) delete data.expires_at;

        try {
            let response;
            if (isEdit) {
                response = await jsonRequest(`${apiBase}/${promotionId}`, { method: 'PUT', body: data });
            } else {
                response = await jsonRequest(apiBase, { method: 'POST', body: data });
            }
            notify(response.message || (isEdit ? 'Promotion updated successfully.' : 'Promotion created successfully.'), 'success');
            window.setTimeout(() => { window.location.href = '/admin/promotions'; }, 800);
        } catch (err) {
            const message = err.payload?.message || err.message || 'An error occurred.';
            $error.text(message).removeClass('hidden');
            notify(message, 'error');
        }
    });

    loadForm();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-promotion-form"]')) initPromotionFormPage();
});
