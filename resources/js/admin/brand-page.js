import $ from 'jquery';
import { createCrudTable } from './crud-table';

function initBrandPage() {
    const $page = $('[data-page="admin-brands"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const required = [
        '#brandsTableBody',
        '#brandForm',
        '#brand_id',
        '#brand_name',
        '#saveBtn',
        '#cancelBtn',
        '#formTitle',
        '#formSubtitle',
        '#tableSearchInput',
    ];

    if (required.some((selector) => !$(selector).length)) {
        return;
    }

    const apiBase = $page.data('apiBase') || '/api/admin/brands';

    createCrudTable({
        tableBody: $('#brandsTableBody')[0],
        form: $('#brandForm')[0],
        idInput: $('#brand_id')[0],
        nameInput: $('#brand_name')[0],
        saveButton: $('#saveBtn')[0],
        cancelButton: $('#cancelBtn')[0],
        formTitle: $('#formTitle')[0],
        formSubtitle: $('#formSubtitle')[0],
        searchInput: $('#tableSearchInput')[0],
        successBox: $('#successBox')[0],
        successText: $('#successText')[0],
        errorBox: $('#errorBox')[0],
        errorText: $('#errorText')[0],
        deleteModal: $('#deleteConfirmationModal')[0],
        confirmDeleteButton: $('#confirmDeleteBtn')[0],
        closeDeleteButton: $('#closeDeleteModalBtn')[0],
        alertCloseButtons: $('.close-alert').toArray(),
        loginUrl: $page.data('loginUrl') || '/login',
        endpoints: {
            index: apiBase,
            store: apiBase,
            update: (id) => `${apiBase}/${id}`,
            destroy: (id) => `${apiBase}/${id}`,
        },
        labels: {
            createTitle: 'New Brand',
            createSubtitle: 'Add a unique classification label.',
            editTitle: 'Edit Brand',
            save: 'Save Record',
            update: 'Update Changes',
        },
        messages: {
            empty: 'No active brands found.',
            created: 'Brand created successfully.',
            updated: 'Brand updated successfully.',
            deleted: 'Brand deleted successfully.',
            loadError: 'Failed to fetch brands.',
            saveError: 'Validation or processing error.',
            deleteError: 'Could not execute target delete.',
        },
        renderRow(brand, index, escapeHtml) {
            const id = escapeHtml(brand.id);
            const name = escapeHtml(brand.name);

            return `
                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                    <td class="py-3 px-4 font-semibold text-slate-400 dark:text-slate-500">${index + 1}</td>
                    <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${name}</td>
                    <td class="py-3 px-4 text-right space-x-1">
                        <button type="button" data-action="edit" data-id="${id}" data-name="${name}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-cyan-600 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900">
                            <i class="h-4 w-4" data-lucide="pencil"></i>
                        </button>
                        <button type="button" data-action="delete" data-id="${id}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900">
                            <i class="h-4 w-4" data-lucide="trash-2"></i>
                        </button>
                    </td>
                </tr>
            `;
        },
    }).init();
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initBrandPage();
} else {
    window.addEventListener('DOMContentLoaded', initBrandPage);
    window.addEventListener('load', initBrandPage);
}
