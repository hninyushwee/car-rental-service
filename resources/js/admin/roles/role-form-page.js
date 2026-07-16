import $ from 'jquery';
import { jsonRequest } from '../common/http';

function initRoleFormPage() {
    const $page = $('[data-page="admin-role-form"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const roleId = $page.data('role-id');
    const isEdit = $page.data('is-edit');
    const $container = $('#formContainer');

    async function loadForm() {
        let role = {};
        if (isEdit && roleId) {
            try {
                const payload = await jsonRequest(`${apiBase}/${roleId}`);
                role = payload?.data || payload;
            } catch {
                $container.html('<p class="text-center text-red-500">Failed to load role data.</p>');
                return;
            }
        }

        $container.html(`
            <form id="roleForm" class="space-y-6">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Role Name</label>
                    <input type="text" name="name" value="${role.name || ''}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-cyan-400 px-6 py-2.5 text-sm font-medium text-black transition hover:bg-cyan-500">
                        ${isEdit ? 'Update Role' : 'Create Role'}
                    </button>
                    <a href="/admin/settings/roles" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</a>
                </div>
            </form>
            <div id="formError" class="mt-4 hidden rounded-lg bg-red-500/10 p-3 text-sm text-red-600 dark:text-red-400"></div>
        `);

        $('#roleForm').on('submit', async function (e) {
            e.preventDefault();
            const $error = $('#formError').addClass('hidden');
            const data = Object.fromEntries(new FormData(this).entries());
            try {
                if (isEdit) {
                    await jsonRequest(`${apiBase}/${roleId}`, { method: 'PUT', body: data });
                } else {
                    await jsonRequest(apiBase, { method: 'POST', body: data });
                }
                window.location.href = '/admin/settings/roles';
            } catch (err) {
                $error.text(err.payload?.message || err.message).removeClass('hidden');
            }
        });
    }

    $page.data('initialized', true);
    loadForm();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-role-form"]')) initRoleFormPage();
});
