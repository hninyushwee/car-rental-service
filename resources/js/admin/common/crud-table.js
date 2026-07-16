import $ from 'jquery';
import { jsonRequest, normalizeRecords } from './http';
import { notify } from './notify';

function escapeHtml(value) {
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function refreshIcons() {
    window.initLucideIcons?.();
}

export function createCrudTable(config) {
    let pendingDeleteId = null;
    const $tableBody = $(config.tableBody);
    const $form = $(config.form);
    const $idInput = $(config.idInput);
    const $nameInput = $(config.nameInput);
    const $saveButton = $(config.saveButton);
    const $cancelButton = $(config.cancelButton);
    const $formTitle = $(config.formTitle);
    const $formSubtitle = $(config.formSubtitle);
    const $searchInput = $(config.searchInput);
    const $deleteModal = $(config.deleteModal);

    function showAlert(type, message) {
        notify(message, type);
        refreshIcons();
    }

    function setSaving(isSaving) {
        $saveButton
            .prop('disabled', isSaving)
            .toggleClass('opacity-70 cursor-not-allowed', isSaving)
            .text(isSaving ? 'Saving...' : ($idInput.val() ? config.labels.update : config.labels.save));
    }

    function resetForm() {
        config.form.reset();
        $idInput.val('');
        $formTitle.text(config.labels.createTitle);
        $formSubtitle.text(config.labels.createSubtitle);
        $saveButton.text(config.labels.save).removeClass('w-2/3').addClass('w-full');
        $cancelButton.addClass('hidden');
    }

    async function load() {
        $tableBody.html(`<tr><td colspan="3" class="py-6 text-center text-slate-400">Loading records...</td></tr>`);

        try {
            const result = await jsonRequest(config.endpoints.index);
            const records = normalizeRecords(result);

            if (!records || !records.length) {
                $tableBody.html(`<tr><td colspan="3" class="py-6 text-center text-slate-400">${config.messages.empty}</td></tr>`);
                return;
            }

            const sortedRecords = [...records].sort((a, b) => b.id - a.id);

            $tableBody.html(sortedRecords.map((record, index) => {
                return config.renderRow(record, index, escapeHtml);
            }).join(''));
            
            if (config.searchInput) {
                $searchInput.val('');
            }
            
            refreshIcons();
        } catch (error) {
            if (error.status === 401 || error.status === 419) {
                window.location.assign(config.loginUrl || '/login');
                return;
            }

            showAlert('error', error.payload?.message || config.messages.loadError);
        }
    }

    async function save(event) {
        event.preventDefault();

        const id = $idInput.val();
        const name = $nameInput.val().trim();
        const url = id ? config.endpoints.update(id) : config.endpoints.store;
        const method = id ? 'PUT' : 'POST';

        setSaving(true);

        try {
            const response = await jsonRequest(url, { method, body: { name } });
            resetForm();
            
            await load(); 
            
            showAlert('success', response.message || (id ? config.messages.updated : config.messages.created));
        } catch (error) {
            if (error.status === 401 || error.status === 419) {
                window.location.assign(config.loginUrl || '/login');
                return;
            }

            const validationMessage = error.payload?.errors?.name?.[0];
            showAlert('error', validationMessage || error.payload?.message || config.messages.saveError);
        } finally {
            setSaving(false);
        }
    }

    function startEdit(button) {
        const $button = $(button);

        $idInput.val($button.data('id') || '');
        $nameInput.val($button.data('name') || '');
        $formTitle.text(config.labels.editTitle);
        $formSubtitle.text(`Modifying entry identity #${$button.data('id')}`);
        $saveButton.text(config.labels.update).removeClass('w-full').addClass('w-2/3');
        $cancelButton.removeClass('hidden');
        $nameInput.trigger('focus');
    }

    function openDeleteModal(id) {
        pendingDeleteId = id;
        $deleteModal.removeClass('hidden').addClass('flex');
    }

    function closeDeleteModal() {
        pendingDeleteId = null;
        $deleteModal.addClass('hidden').removeClass('flex');
    }

    async function destroy() {
        if (!pendingDeleteId) return;

        try {
            const response = await jsonRequest(config.endpoints.destroy(pendingDeleteId), { method: 'DELETE' });
            closeDeleteModal();
            await load();
            showAlert('success', response.message || config.messages.deleted);
        } catch (error) {
            closeDeleteModal();
            showAlert('error', error.payload?.message || config.messages.deleteError);
        }
    }

    function filterRows() {
        const query = $searchInput.val().toLowerCase().trim();
        let visibleCount = 0;
        $('#noSearchResultsRow').remove();

        $tableBody.find('tr').each(function () {
            const $row = $(this);
            if ($row.find('td[colspan]').length) return;

            const name = $row.children().eq(1).text().toLowerCase();
            const visible = name.includes(query);
            $row.toggleClass('hidden', !visible);
            if (visible) visibleCount++;
        });

        if (!visibleCount && query) {
            $tableBody.append(`
                <tr id="noSearchResultsRow">
                    <td colspan="3" class="py-8 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-5 w-5 text-slate-300 dark:text-slate-600"></i>
                            <span>No records match "${escapeHtml($searchInput.val())}"</span>
                        </div>
                    </td>
                </tr>
            `);
            refreshIcons();
        }
    }

    function init() {
        $form.on('submit', save);
        $cancelButton.on('click', resetForm);
        $(config.closeDeleteButton).on('click', closeDeleteModal);
        $(config.confirmDeleteButton).on('click', destroy);
        $searchInput.on('input', filterRows);
        $(config.alertCloseButtons).on('click', function () {
            $(this).closest('.rounded-xl').addClass('hidden');
        });

        $tableBody.on('click', '[data-action="edit"]', function () {
            startEdit(this);
        });

        $tableBody.on('click', '[data-action="delete"]', function () {
            openDeleteModal($(this).data('id'));
        });

        load();
    }

    return { init, load, resetForm };
}
