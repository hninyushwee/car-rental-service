import { createAlertManager } from './alerts';
import { createCrudTable } from './crud-table';
import { createConfirmModal } from './modal';
import { bindTableSearch } from './search-filter';
import { refreshIcons } from './icons';

function initCategoryPage() {
    const page = document.querySelector('[data-page="admin-categories"]');
    if (!page) return;

    const tableBody = document.getElementById('categoriesTableBody');
    const searchInput = document.getElementById('tableSearchInput');
    const form = document.getElementById('categoryForm');
    const idInput = document.getElementById('category_id');
    const nameInput = document.getElementById('category_name');
    const saveButton = document.getElementById('saveBtn');
    const cancelButton = document.getElementById('cancelBtn');
    const formTitle = document.getElementById('formTitle');
    const formSubtitle = document.getElementById('formSubtitle');

    if (!tableBody || !searchInput || !form || !idInput || !nameInput || !saveButton || !cancelButton) {
        return;
    }

    const alerts = createAlertManager({
        successBox: document.getElementById('successBox'),
        successText: document.getElementById('successText'),
        errorBox: document.getElementById('errorBox'),
        errorText: document.getElementById('errorText'),
    });

    const modal = createConfirmModal({
        modal: document.getElementById('deleteConfirmationModal'),
        confirmButton: document.getElementById('confirmDeleteBtn'),
        closeButton: document.getElementById('closeDeleteModalBtn'),
    });

    const apiBase = page.dataset.apiBase;

    const categories = createCrudTable({
        tableBody,
        searchInput,
        form,
        idInput,
        nameInput,
        saveButton,
        cancelButton,
        formTitle,
        formSubtitle,
        alerts,
        modal,
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
            created: 'Category created successfully.',
            updated: 'Category updated successfully.',
            deleted: 'Category deleted successfully.',
            loadError: 'Failed to fetch categories.',
            saveError: 'Validation or processing error.',
            deleteError: 'Could not execute target delete.',
        },
        emptyMessage: 'No active categories found.',
        colspan: 3,
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
                </tr>`;
        },
    });

    bindTableSearch({ input: searchInput, tableBody });
    categories.init();
    refreshIcons();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCategoryPage);
} else {
    initCategoryPage();
}
