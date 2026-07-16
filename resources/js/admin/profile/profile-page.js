import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function initProfilePage() {
    const $page = $('[data-page="admin-profile"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const apiUrl = $page.data('apiUrl') || '/api/admin/profile';
    const indexUrl = $page.data('indexUrl') || '/admin';
    const loginUrl = $page.data('loginUrl') || '/login';

    const form = document.getElementById('profileForm');
    const nameInput = document.getElementById('profileName');
    const emailInput = document.getElementById('profileEmail');
    const phoneInput = document.getElementById('profilePhone');
    const passwordInput = document.getElementById('profilePassword');
    const passwordConfirmationInput = document.getElementById('profilePasswordConfirmation');

    if (!form || !nameInput || !emailInput) {
        return;
    }

    const $alert = $('#formAlert');
    const $alertMsg = $('#formAlertMsg');

    function showAlert(message, type) {
        const icons = { info: 'info', error: 'alert-triangle', success: 'check-circle' };
        const iconName = icons[type] || 'info';
        const colors = {
            info: 'border-cyan-200 bg-cyan-50 text-cyan-800 dark:border-cyan-800 dark:bg-cyan-950/50 dark:text-cyan-300',
            error: 'border-red-200 bg-red-50 text-red-800 dark:border-red-800 dark:bg-red-950/50 dark:text-red-300',
            success: 'border-green-200 bg-green-50 text-green-800 dark:border-green-800 dark:bg-green-950/50 dark:text-green-300',
        };
        $alert.attr('class', `flex items-center gap-3 rounded-xl border px-4 py-3 text-sm ${colors[type] || colors.info}`);
        $alertMsg.text(message);
        $alert.find('i[data-lucide]').attr('data-lucide', iconName);
        $alert.removeClass('hidden');
        window.initLucideIcons?.();
    }

    function hideAlert() {
        $alert.addClass('hidden');
    }

    function handleApiError(error, fallback) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }
        const message = error.payload?.message || error.message || fallback;
        const text = typeof message === 'string' && message.trim().startsWith('<!DOCTYPE')
            ? `${fallback} Server returned HTTP ${error.status || 500}.`
            : (message || fallback);
        notify(text, 'error');
    }

    function clearValidation() {
        $('.input-error-msg').remove();
        $('.border-red-500').removeClass('border-red-500');
    }

    function showFieldError(field, message) {
        const $field = $(`[name="${field}"]`);
        if (!$field.length) return;
        $field.addClass('border-red-500');
        $field.after(`<p class="input-error-msg mt-1 text-xs font-medium text-red-600 dark:text-red-400">${message}</p>`);
    }

    function showValidationErrors(errors = {}) {
        Object.entries(errors).forEach(([field, messages]) => {
            showFieldError(field, messages[0]);
        });
        const entries = Object.entries(errors);
        if (entries.length) {
            notify(entries[0][1][0], 'error');
        }
    }

    function fillProfile(user) {
        nameInput.value = user.name || '';
        emailInput.value = user.email || '';
        if (phoneInput) phoneInput.value = user.phone || '';
    }

    async function loadProfile() {
        try {
            const response = await jsonRequest(apiUrl);
            fillProfile(response.data || response.user || response);
        } catch (error) {
            handleApiError(error, 'Failed to load profile.');
        }
    }

    function resetForm() {
        clearValidation();
        hideAlert();
        loadProfile();
        passwordInput.value = '';
        passwordConfirmationInput.value = '';
        notify('Form has been reset.', 'info');
    }

    async function submitForm(event) {
        event.preventDefault();
        clearValidation();
        hideAlert();

        const $button = $('#submitFormBtn');
        const defaultText = 'Save Changes';
        const data = new FormData(form);
        data.append('_method', 'PUT');

        $button.prop('disabled', true).addClass('opacity-75 cursor-not-allowed').text('Processing...');

        try {
            const response = await jsonRequest(apiUrl, {
                method: 'POST',
                body: data,
            });

            const message = response.message || 'Profile updated successfully.';
            notify(message, 'success');
            showAlert(message, 'success');
        } catch (error) {
            if (error.status === 422) {
                showValidationErrors(error.payload?.errors);
            } else {
                handleApiError(error, 'Profile could not be saved.');
            }
        } finally {
            $button.prop('disabled', false).removeClass('opacity-75 cursor-not-allowed').text(defaultText);
        }
    }

    $('#profileForm').on('submit', submitForm);
    $('#resetFormBtn').on('click', resetForm);
    $('.close-alert').on('click', function () {
        $(this).closest('.rounded-xl').addClass('hidden');
    });

    loadProfile();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initProfilePage();
} else {
    window.addEventListener('DOMContentLoaded', initProfilePage);
    window.addEventListener('load', initProfilePage);
}
