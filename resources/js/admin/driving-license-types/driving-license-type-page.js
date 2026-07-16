import $ from 'jquery';
import { jsonRequest, normalizeRecords } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() {
    window.initLucideIcons?.();
}

function money(value) {
    return 'MMK ' + Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function imgSrc(val) {
    if (!val) return '';
    if (val.startsWith('http')) return val;
    if (val.startsWith('storage/')) return '/' + val;
    return '/storage/' + val;
}

let pendingDeleteId = null;
let currentImageFile = null;

function initLicenseTypePage() {
    const $page = $('[data-page="admin-driving-license-types"]');
    if (!$page.length || $page.data('initialized')) return;
    $page.data('initialized', true);

    const apiBase = $page.data('apiBase');

    const $tableBody = $('#tableBody');
    const $form = $('#licenseTypeForm');
    const $idInput = $('#recordId');
    const $typeInput = $('#typeInput');
    const $priceInput = $('#priceInput');
    const $imageInput = $('#imageInput');
    const $uploadPlaceholder = $('#uploadPlaceholder');
    const $fileInfo = $('#fileInfo');
    const $fileName = $('#fileName');
    const $removeImageBtn = $('#removeImageBtn');
    const $imageError = $('#imageError');
    const $saveBtn = $('#saveBtn');
    const $cancelBtn = $('#cancelBtn');
    const $formTitle = $('#formTitle');
    const $formSubtitle = $('#formSubtitle');
    const $searchInput = $('#tableSearchInput');
    const $deleteModal = $('#deleteConfirmationModal');
    const $confirmDeleteBtn = $('#confirmDeleteBtn');
    const $closeDeleteModalBtn = $('#closeDeleteModalBtn');

    function resetForm() {
        $form[0].reset();
        $idInput.val('');
        $formTitle.text('New License Type');
        $formSubtitle.text('Add a new driving license classification.');
        $saveBtn.text('Create License Type');
        $cancelBtn.addClass('hidden');
        currentImageFile = null;
        $uploadPlaceholder.removeClass('hidden');
        $fileInfo.addClass('hidden');
        $imageError.addClass('hidden');
        document.getElementById('formIcon').setAttribute('data-lucide', 'file-plus');
        refreshIcons();
    }

    function setSaving(isSaving) {
        $saveBtn.prop('disabled', isSaving).toggleClass('opacity-70 cursor-not-allowed', isSaving)
            .text(isSaving ? 'Saving...' : ($idInput.val() ? 'Update License Type' : 'Create License Type'));
    }

    async function load() {
        $tableBody.html('<tr><td colspan="5" class="py-6 text-center text-slate-400">Loading license types...</td></tr>');
        try {
            const result = await jsonRequest(apiBase);
            const records = normalizeRecords(result);
            if (!records || !records.length) {
                $tableBody.html('<tr><td colspan="5" class="py-6 text-center text-slate-400">No license types found.</td></tr>');
                return;
            }
            const sorted = [...records].sort((a, b) => b.id - a.id);
            $tableBody.html(sorted.map((r, i) => {
                const imgHtml = r.image ? `<img src="${imgSrc(r.image)}" class="h-8 w-12 rounded object-cover border border-slate-200">` : '<span class="text-slate-400">—</span>';
                return `<tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                    <td class="py-3 px-4 font-semibold text-slate-400 dark:text-slate-500">${i + 1}</td>
                    <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${escapeHtml(r.type)}</td>
                    <td class="py-3 px-4">${imgHtml}</td>
                    <td class="py-3 px-4 font-mono text-sm text-slate-800 dark:text-slate-200">${money(r.price)}</td>
                    <td class="py-3 px-4 text-right space-x-1">
                        <button type="button" data-action="edit" data-id="${r.id}" data-type="${escapeHtml(r.type)}" data-price="${r.price}" data-image="${escapeHtml(r.image || '')}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-slate-500 hover:border-green-500 hover:bg-green-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-400 dark:hover:border-green-400 dark:hover:bg-green-950/30">
                            <i class="h-4 w-4 text-green-600 dark:text-green-400" data-lucide="edit"></i>
                        </button>
                        <button type="button" data-action="delete" data-id="${r.id}" class="inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-red-400 dark:hover:bg-red-950/30">
                            <i class="h-4 w-4" data-lucide="trash-2"></i>
                        </button>
                    </td>
                </tr>`;
            }).join(''));
            refreshIcons();
        } catch (err) {
            $tableBody.html(`<tr><td colspan="5" class="py-6 text-center text-red-400">${err.message || 'Failed to load license types.'}</td></tr>`);
        }
    }

    async function save(e) {
        e.preventDefault();
        const id = $idInput.val();
        const type = $typeInput.val().trim();
        const price = $priceInput.val();
        if (!type || price === '') return;

        const formData = new FormData();
        formData.append('type', type);
        formData.append('price', price);
        if (currentImageFile) {
            formData.append('image', currentImageFile);
        }

        const url = id ? `${apiBase}/${id}` : apiBase;
        const method = id ? 'POST' : 'POST';

        setSaving(true);
        try {
            if (id) {
                formData.append('_method', 'PUT');
            }
            const response = await jsonRequest(url, { method, body: formData });
            resetForm();
            await load();
            notify(response.message || (id ? 'License type updated.' : 'License type created.'));
        } catch (err) {
            const msg = err.payload?.errors?.type?.[0] || err.payload?.errors?.price?.[0] || err.payload?.message || err.message || 'Save failed.';
            notify(msg, 'error');
        } finally {
            setSaving(false);
        }
    }

    function startEdit($btn) {
        $idInput.val($btn.data('id'));
        $typeInput.val($btn.data('type'));
        $priceInput.val($btn.data('price'));
        $formTitle.text('Edit License Type');
        $formSubtitle.text(`Modifying "${$btn.data('type')}"`);
        $saveBtn.text('Update License Type');
        $cancelBtn.removeClass('hidden');
        currentImageFile = null;
        $uploadPlaceholder.removeClass('hidden');
        $fileInfo.addClass('hidden');
        if ($btn.data('image')) {
            $fileName.text('Current: ' + $btn.data('image').split('/').pop());
            $uploadPlaceholder.addClass('hidden');
            $fileInfo.removeClass('hidden');
        }
        document.getElementById('formIcon').setAttribute('data-lucide', 'edit');
        refreshIcons();
        $typeInput.trigger('focus');
    }

    $form.on('submit', save);
    $cancelBtn.on('click', resetForm);

    $tableBody.on('click', '[data-action="edit"]', function () { startEdit($(this)); });
    $tableBody.on('click', '[data-action="delete"]', function () {
        pendingDeleteId = $(this).data('id');
        $deleteModal.removeClass('hidden').addClass('flex');
    });

    $closeDeleteModalBtn.on('click', () => { pendingDeleteId = null; $deleteModal.addClass('hidden').removeClass('flex'); });
    $confirmDeleteBtn.on('click', async () => {
        if (!pendingDeleteId) return;
        try {
            await jsonRequest(`${apiBase}/${pendingDeleteId}`, { method: 'DELETE' });
            $deleteModal.addClass('hidden').removeClass('flex');
            pendingDeleteId = null;
            await load();
            notify('License type deleted.');
        } catch (err) {
            notify(err.message || 'Delete failed.', 'error');
        }
    });

    $uploadPlaceholder.on('click', () => $imageInput.trigger('click'));
    $imageInput.on('change', function () {
        const file = this.files[0];
        if (!file) return;
        $imageError.addClass('hidden');
        if (file.size > 2 * 1024 * 1024) {
            $imageError.text('Image must be less than 2MB.').removeClass('hidden');
            this.value = '';
            return;
        }
        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            $imageError.text('Only JPG/PNG images are allowed.').removeClass('hidden');
            this.value = '';
            return;
        }
        currentImageFile = file;
        $fileName.text(file.name);
        $uploadPlaceholder.addClass('hidden');
        $fileInfo.removeClass('hidden');
    });
    $removeImageBtn.on('click', function () {
        $imageInput.val('');
        currentImageFile = null;
        $uploadPlaceholder.removeClass('hidden');
        $fileInfo.addClass('hidden');
    });

    $searchInput.on('input', function () {
        const q = $(this).val().toLowerCase().trim();
        let visible = 0;
        $tableBody.find('tr').each(function () {
            if ($(this).find('td[colspan]').length) return;
            const txt = $(this).find('td').eq(1).text().toLowerCase();
            const match = txt.includes(q);
            $(this).toggleClass('hidden', !match);
            if (match) visible++;
        });
        $('#noSearchRow').remove();
        if (!visible && q) {
            $tableBody.append(`<tr id="noSearchRow"><td colspan="5" class="py-8 text-center text-slate-400">No results match "${escapeHtml(q)}"</td></tr>`);
        }
    });

    $('.close-alert').on('click', function () { $(this).closest('#successBox, #errorBox').addClass('hidden'); });

    load();
}

$(function () {
    if (document.querySelector('[data-page="admin-driving-license-types"]')) initLicenseTypePage();
});
