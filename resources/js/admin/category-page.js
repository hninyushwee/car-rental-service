import $ from 'jquery';
import { createCrudTable } from './crud-table';

function initCategoryPage() {
    const $page = $('[data-page="admin-categories"]');
    
    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const required = [
        '#categoriesTableBody',
        '#categoryForm',
        '#category_id',
        '#category_name',
        '#saveBtn',
        '#cancelBtn',
        '#formTitle',
        '#formSubtitle',
        '#tableSearchInput',
    ];

    if (required.some((selector) => !$(selector).length)) {
        return;
    }

    const apiBase = $page.data('apiBase') || '/api/admin/categories';

    createCrudTable({
        tableBody: $('#categoriesTableBody')[0],
        form: $('#categoryForm')[0],
        idInput: $('#category_id')[0],
        nameInput: $('#category_name')[0],
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
            createTitle: 'New Category',
            createSubtitle: 'Add a unique classification label.',
            editTitle: 'Edit Category',
            save: 'Save Record',
            update: 'Update Changes',
        },
        messages: {
            empty: 'No active categories found.',
            created: 'Category created successfully.',
            updated: 'Category updated successfully.',
            deleted: 'Category deleted successfully.',
            loadError: 'Failed to fetch categories.',
            saveError: 'Validation or processing error.',
            deleteError: 'Could not execute target delete.',
        },
        renderRow(category, index, escapeHtml) {
            const id = escapeHtml(category.id);
            const name = escapeHtml(category.name);

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
    initCategoryPage();
} else {
    window.addEventListener('DOMContentLoaded', initCategoryPage);
    window.addEventListener('load', initCategoryPage);
}
