import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function initStaffFormPage() {
    const $page = $('[data-page="admin-staff-form"]');

    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const apiBase = $page.data('apiBase') || '/api/admin/staff';
    const permissionsUrl = $page.data('permissionsUrl') || '/api/admin/permissions';
    const rolesUrl = $page.data('rolesUrl') || '/api/admin/roles';
    const staffId = $page.data('staff-id');
    const isEdit = $page.data('is-edit') === true;
    const indexUrl = $page.data('index-url') || '/admin/staff';
    const loginUrl = $page.data('login-url') || '/login';

    const $form = $('#staffForm');
    const $name = $('#staffName');
    const $email = $('#staffEmail');
    const $phone = $('#staffPhone');
    const $password = $('#staffPassword');
    const $role = $('#staffRole');
    const $permissionsContainer = $('#permissionsContainer');
    const $submitBtn = $('#submitFormBtn');

    let userRole = '';
    let userPermissions = [];

    function hideErrors() {
        $form.find('.input-error-msg').addClass('hidden').text('');
    }

    function showFieldError($input, message) {
        const $error = $input.closest('div').find('.input-error-msg');
        $error.text(message).removeClass('hidden');
    }

    function handleError(error) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }
        if (error.payload?.errors) {
            const errs = error.payload.errors;
            if (errs.name) showFieldError($name, errs.name[0]);
            if (errs.email) showFieldError($email, errs.email[0]);
            if (errs.phone) showFieldError($phone, errs.phone[0]);
            if (errs.password) showFieldError($password, errs.password[0]);
            if (errs.role) showFieldError($role, errs.role[0]);
            if (errs.permissions) showFieldError($permissionsContainer, errs.permissions[0]);
        }
        notify(error.payload?.message || 'An error occurred', 'error');
    }

    async function fetchRoles() {
        try {
            const result = await jsonRequest(rolesUrl);
            const roles = result?.data?.data ?? result?.data ?? [];
            const $select = $role.empty().append('<option value="">Select a role</option>');
            roles.forEach(function (r) {
                const selected = r.name === userRole ? ' selected' : '';
                $select.append(`<option value="${r.name}"${selected}>${r.display_name || r.name}</option>`);
            });
        } catch (error) {
            notify('Failed to load roles', 'error');
        }
    }

    async function fetchPermissions() {
        try {
            const result = await jsonRequest(permissionsUrl);
            const perms = result?.data ?? [];
            $permissionsContainer.empty();

            if (!perms.length) {
                $permissionsContainer.html('<p class="text-sm text-slate-500 dark:text-slate-400">No permissions available</p>');
                return;
            }

            perms.forEach(function (p) {
                const checked = userPermissions.includes(p.name) ? ' checked' : '';
                const label = p.name.replace(/-/g, ' ').replace(/\b\w/g, function (c) { return c.toUpperCase(); });
                $permissionsContainer.append(`
                    <label class="flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm transition hover:border-slate-300 dark:border-slate-600 dark:hover:border-slate-500">
                        <input type="checkbox" name="permissions[]" value="${p.name}"${checked} class="h-4 w-4 rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                        <span class="text-slate-700 dark:text-slate-300">${label}</span>
                    </label>
                `);
            });
        } catch (error) {
            notify('Failed to load permissions', 'error');
        }
    }

    async function loadStaff() {
        try {
            const result = await jsonRequest(`${apiBase}/${staffId}`);
            const user = result?.data ?? {};
            $name.val(user.name || '');
            $email.val(user.email || '');
            $phone.val(user.phone || '');
            $password.val('').prop('placeholder', 'Leave blank to keep current');

            userRole = user.roles?.[0]?.name || '';
            userPermissions = user.permissions?.map(function (p) { return p.name || p; }) || [];

            await fetchRoles();
            await fetchPermissions();
        } catch (error) {
            handleError(error);
        }
    }

    function getSelectedPermissions() {
        const checked = [];
        $permissionsContainer.find('input[name="permissions[]"]:checked').each(function () {
            checked.push($(this).val());
        });
        return checked;
    }

    $form.on('submit', async function (e) {
        e.preventDefault();
        hideErrors();

        const data = {
            name: $name.val().trim(),
            email: $email.val().trim(),
            phone: $phone.val().trim(),
            role: $role.val(),
        };
        const password = $password.val();
        if (password) data.password = password;

        const permissions = getSelectedPermissions();
        if (permissions.length) data.permissions = permissions;

        const method = isEdit ? 'PUT' : 'POST';
        const url = isEdit ? `${apiBase}/${staffId}` : apiBase;

        $submitBtn.prop('disabled', true).text('Saving...');

        try {
            const result = await jsonRequest(url, { method, body: data });
            notify(result.message || (isEdit ? 'Staff updated successfully.' : 'Staff created successfully.'), 'success');
            setTimeout(() => { window.location.href = indexUrl; }, 1000);
        } catch (error) {
            handleError(error);
            $submitBtn.prop('disabled', false).text(isEdit ? 'Update Staff' : 'Create Staff');
        }
    });

    (async function init() {
        if (isEdit && staffId) {
            await loadStaff();
        } else {
            userRole = 'staff';
            await fetchRoles();
            await fetchPermissions();
        }
    })();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initStaffFormPage();
} else {
    window.addEventListener('DOMContentLoaded', initStaffFormPage);
    window.addEventListener('load', initStaffFormPage);
}
