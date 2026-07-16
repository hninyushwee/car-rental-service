import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function initDepositFormPage() {
    const $page = $('[data-page="admin-deposit-form"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const settingId = $page.data('setting-id');
    const isEdit = Boolean(settingId);
    const $form = $('#depositSettingForm');
    const $submitBtn = $form.find('button[type="submit"]');

    async function populateForm() {
        if (!isEdit) return;
        try {
            const payload = await jsonRequest(`${apiBase}/${settingId}`);
            const item = payload?.data || payload;
            $form.find('[name="service_key"]').val(item.service_key);
            $form.find('[name="deposit_type"]').val(item.deposit_type);
            $form.find('[name="amount"]').val(item.amount);
            $form.find('[name="is_active"]').prop('checked', item.is_active);
        } catch (err) {
            notify(err.payload?.message || err.message, 'error');
        }
    }

    $form.on('submit', async function (e) {
        e.preventDefault();
        $submitBtn.prop('disabled', true).text('Saving...');

        const payload = {
            service_key: $form.find('[name="service_key"]').val(),
            deposit_type: $form.find('[name="deposit_type"]').val(),
            amount: $form.find('[name="amount"]').val(),
            is_active: $form.find('[name="is_active"]').is(':checked'),
        };

        try {
            const response = isEdit
                ? await jsonRequest(`${apiBase}/${settingId}`, { method: 'PUT', body: payload })
                : await jsonRequest(apiBase, { method: 'POST', body: payload });
            notify(response.message || (isEdit ? 'Deposit setting updated successfully.' : 'Deposit setting created successfully.'), 'success');
            window.setTimeout(() => { window.location.href = '/admin/deposit-settings'; }, 900);
        } catch (err) {
            notify(err.payload?.message || err.message, 'error');
            $submitBtn.prop('disabled', false).text(isEdit ? 'Update Setting' : 'Create Setting');
        }
    });

    $page.data('initialized', true);
    populateForm();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-deposit-form"]')) initDepositFormPage();
});
