import { jsonRequest } from './http';
import { setButtonLoading } from './forms';
import { refreshIcons } from './icons';

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

export function createCrudTable(config) {
    const state = {
        editingId: null,
    };

    async function load() {
        config.tableBody.innerHTML = `
            <tr>
                <td colspan="${config.colspan || 3}" class="py-6 text-center text-slate-400">Loading records...</td>
            </tr>
        `;

        try {
            const result = await jsonRequest(config.endpoints.index);
            const rows = result.data || [];

            if (rows.length === 0) {
                config.tableBody.innerHTML = `
                    <tr>
                        <td colspan="${config.colspan || 3}" class="py-6 text-center text-slate-400">${config.emptyMessage || 'No records found.'}</td>
                    </tr>
                `;
                return;
            }

            config.tableBody.innerHTML = rows.map((record, index) => config.renderRow(record, index, escapeHtml)).join('');
            config.searchInput.value = '';
            refreshIcons();
        } catch (error) {
            config.alerts.error(error.payload?.message || config.messages.loadError || 'Failed to load records.');
        }
    }

    function resetForm() {
        state.editingId = null;
        config.form.reset();
        config.idInput.value = '';
        config.nameInput.focus();
        config.cancelButton.classList.add('hidden');
        config.saveButton.classList.remove('w-2/3');
        config.saveButton.classList.add('w-full');
        config.formTitle.textContent = config.labels.createTitle;
        config.formSubtitle.textContent = config.labels.createSubtitle;
        config.saveButton.textContent = config.labels.save;
    }

    async function submit(event) {
        event.preventDefault();

        const name = config.nameInput.value.trim();
        const id = config.idInput.value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? config.endpoints.update(id) : config.endpoints.store;
        const defaultButton = id ? config.labels.update : config.labels.save;

        setButtonLoading(config.saveButton, true, 'Saving...', `<span>${defaultButton}</span>`);

        try {
            const response = await jsonRequest(url, {
                method,
                body: { name },
            });

            resetForm();
            await load();
            config.alerts.success(response.message || (id ? config.messages.updated : config.messages.created));
        } catch (error) {
            const validationMessage = error.payload?.errors?.name?.[0];
            config.alerts.error(validationMessage || error.payload?.message || config.messages.saveError, 0);
        } finally {
            setButtonLoading(config.saveButton, false, 'Saving...', `<span>${defaultButton}</span>`);
        }
    }

    function edit(record) {
        state.editingId = record.id;
        config.idInput.value = record.id;
        config.nameInput.value = record.name;
        config.formTitle.textContent = config.labels.editTitle;
        config.formSubtitle.textContent = `Modifying entry identity #${record.id}`;
        config.saveButton.textContent = config.labels.update;
        config.cancelButton.classList.remove('hidden');
        config.saveButton.classList.remove('w-full');
        config.saveButton.classList.add('w-2/3');
        config.nameInput.focus();
    }

    async function destroy(id) {
        try {
            const response = await jsonRequest(config.endpoints.destroy(id), { method: 'DELETE' });
            config.modal.close();
            await load();
            config.alerts.success(response.message || config.messages.deleted);
        } catch (error) {
            config.modal.close();
            config.alerts.error(error.payload?.message || config.messages.deleteError);
        }
    }

    function bindRowActions() {
        config.tableBody.addEventListener('click', (event) => {
            const editButton = event.target.closest('[data-action="edit"]');
            const deleteButton = event.target.closest('[data-action="delete"]');

            if (editButton) {
                edit({
                    id: editButton.dataset.id,
                    name: editButton.dataset.name,
                });
            }

            if (deleteButton) {
                config.modal.open(deleteButton.dataset.id);
            }
        });
    }

    function init() {
        config.form.addEventListener('submit', submit);
        config.cancelButton.addEventListener('click', resetForm);
        config.modal.onConfirm(destroy);
        bindRowActions();
        load();
    }

    return { init, load, resetForm };
}
