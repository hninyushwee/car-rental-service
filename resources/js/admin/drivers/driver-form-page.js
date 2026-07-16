import $ from 'jquery';
import { jsonRequest, normalizeRecords } from '../common/http';
import { notify } from '../common/notify';

function refreshIcons() {
    window.initLucideIcons?.();
}

function formatFileSize(size) {
    if (size < 1024) return `${size} B`;
    if (size < 1024 * 1024) return `${(size / 1024).toFixed(1)} KB`;
    return `${(size / (1024 * 1024)).toFixed(1)} MB`;
}

function readableError(error, fallback) {
    const message = error.payload?.message || error.message || fallback;

    if (typeof message === 'string' && message.trim().startsWith('<!DOCTYPE')) {
        return `${fallback} Server returned HTTP ${error.status || 500}.`;
    }

    return message || fallback;
}

function clearDatepicker(instance, input) {
    if (input) {
        input.value = '';
    }

    if (instance && typeof instance.hide === 'function') {
        instance.hide();
    }
}

let allVehicles = [];

function vehicleLabel(v) {
    const brand = v.brand?.name || '';
    const cat = v.category?.name || '';
    const parts = [brand, v.model].filter(Boolean);
    if (cat) parts.push(`(${cat})`);
    return parts.join(' ');
}

function renderUnassigned(searchTerm) {
    const $list = $('#unassignedList');
    const assignedIds = getAssignedIds();
    const term = (searchTerm || '').toLowerCase();
    const filtered = allVehicles.filter(v =>
        !assignedIds.includes(v.id) &&
        (!term || vehicleLabel(v).toLowerCase().includes(term))
    );
    if (!filtered.length) {
        $list.html('<li class="px-3 py-4 text-center text-xs text-slate-400">No vehicles found.</li>');
        return;
    }
    $list.html(filtered.map(v =>
        `<li class="px-3 py-2 text-xs text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-cyan-50 dark:hover:bg-cyan-950/30 transition" data-id="${v.id}">${vehicleLabel(v)}</li>`
    ).join(''));
    $list.find('li').on('click', function () {
        $list.find('li').removeClass('bg-cyan-100 dark:bg-cyan-900/40');
        $(this).addClass('bg-cyan-100 dark:bg-cyan-900/40');
        $('#assignBtn').prop('disabled', false);
    });
}

function renderAssigned() {
    const $list = $('#assignedList');
    const ids = getAssignedIds();
    const primaryId = getPrimaryId();
    if (!ids.length) {
        $list.html('<li class="px-3 py-4 text-center text-xs text-slate-400">No vehicles assigned.</li>');
        $('#assignedCount').text('0');
        return;
    }
    $('#assignedCount').text(ids.length);
    $list.html(ids.map(id => {
        const v = allVehicles.find(x => x.id === id);
        if (!v) return '';
        const isPrimary = primaryId === id;
        return `<li class="px-3 py-2 text-xs text-slate-700 dark:text-slate-300 ${isPrimary ? 'bg-amber-50 dark:bg-amber-900/20' : ''}" data-id="${id}">
            <div class="flex items-center justify-between gap-2">
                <span class="truncate">${vehicleLabel(v)}</span>
                <div class="flex items-center gap-1 shrink-0">
                    <button type="button" class="primary-btn text-[10px] font-semibold rounded px-1.5 py-0.5 transition ${isPrimary ? 'bg-amber-400 text-black' : 'bg-slate-200 text-slate-500 hover:bg-amber-100 dark:bg-slate-600 dark:text-slate-300'}" data-id="${id}">${isPrimary ? 'Primary' : 'Set as Primary'}</button>
                </div>
            </div>
        </li>`;
    }).join(''));
    $list.find('.primary-btn').on('click', function () {
        const id = parseInt($(this).data('id'));
        $('#primaryVehicleIdInput').val(id);
        renderAssigned();
        updateHiddenInputs();
    });
    $list.find('li').on('click', function (e) {
        if ($(e.target).is('button')) return;
        $list.find('li').removeClass('bg-cyan-100 dark:bg-cyan-900/40');
        $(this).addClass('bg-cyan-100 dark:bg-cyan-900/40');
        $('#unassignBtn').prop('disabled', false);
    });
}

function getAssignedIds() {
    const val = $('#vehicleIdsInput').val();
    return val ? val.split(',').map(Number).filter(Boolean) : [];
}

function getPrimaryId() {
    const val = $('#primaryVehicleIdInput').val();
    return val ? parseInt(val) : null;
}

function updateHiddenInputs() {
    const ids = getAssignedIds();
    const primary = getPrimaryId();
    $('#vehicleIdsInput').val(ids.join(','));
    if (primary && !ids.includes(primary)) {
        $('#primaryVehicleIdInput').val('');
    }
}

function assignVehicle() {
    const $selected = $('#unassignedList li.bg-cyan-100');
    if (!$selected.length) return;
    const id = parseInt($selected.data('id'));
    const ids = getAssignedIds();
    if (!ids.includes(id)) {
        ids.push(id);
        $('#vehicleIdsInput').val(ids.join(','));
        if (!getPrimaryId()) {
            $('#primaryVehicleIdInput').val(id);
        }
    }
    $('#unassignedSearch').val('');
    renderUnassigned('');
    renderAssigned();
    updateHiddenInputs();
    $('#assignBtn').prop('disabled', true);
    $('#unassignBtn').prop('disabled', true);
}

function unassignVehicle() {
    const $selected = $('#assignedList li.bg-cyan-100');
    if (!$selected.length) return;
    const id = parseInt($selected.data('id'));
    let ids = getAssignedIds();
    ids = ids.filter(x => x !== id);
    $('#vehicleIdsInput').val(ids.join(','));
    if (getPrimaryId() === id) {
        $('#primaryVehicleIdInput').val(ids.length ? ids[0] : '');
    }
    renderUnassigned('');
    renderAssigned();
    updateHiddenInputs();
    $('#assignBtn').prop('disabled', true);
    $('#unassignBtn').prop('disabled', true);
}

function initDriverFormPage() {
    const $page = $('[data-page="admin-driver-form"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const isEditMode = $page.data('edit') === true || $page.data('edit') === 'true';
    const driverId = $page.data('id');
    const driversApi = $page.data('driversApi') || '/api/admin/drivers';
    const vehiclesApi = $page.data('vehiclesApi') || '/api/admin/vehicles';
    const indexUrl = $page.data('indexUrl') || '/admin/drivers';
    const loginUrl = $page.data('loginUrl') || '/login';

    const form = document.getElementById('driverForm');
    const nameInput = document.getElementById('driverName');
    const emailInput = document.getElementById('driverEmail');
    const phoneInput = document.getElementById('driverPhone');
    const licenseNumberInput = document.getElementById('driverLicenseNumber');
    const statusSelect = document.getElementById('driverStatus');
    const imageInput = document.getElementById('imageInput');
    const addressInput = document.getElementById('driverAddress');
    const licenseExpiryEl = document.getElementById('driverLicenseExpiry');

    if (!form || !nameInput || !phoneInput || !imageInput) {
        return;
    }

    const datepickerInstance = licenseExpiryEl && window.Datepicker
        ? new window.Datepicker(licenseExpiryEl, {
            format: 'yyyy-mm-dd',
            autohide: true,
        })
        : null;

    function handleApiError(error, fallback) {
        if (error.status === 401 || error.status === 419) {
            window.location.assign(loginUrl);
            return;
        }

        notify(readableError(error, fallback), 'error');
    }

    function updateTitlePreview() {
        const name = nameInput.value || 'Driver Name';
        $('#previewTitle').text(name);
    }

    function updatePhonePreview() {
        const phone = phoneInput.value || 'Not Provided';
        $('#previewPhone').text(phone);
    }

    function updateAddressPreview() {
        const text = addressInput?.value.trim();
        $('#previewAddress').text(text || 'No address provided yet.');
    }

    function updateLicensePreview() {
        const num = licenseNumberInput?.value.trim();
        $('#previewLicense').text(num || 'Not Set');
    }

    function updateStatusPreview() {
        const val = statusSelect?.value;
        const badge = $('#previewStatusBadge');
        if (val === 'available') {
            badge.text('Available').removeClass().addClass('rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400');
        } else if (val === 'on_trip') {
            badge.text('On Trip').removeClass().addClass('rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-400');
        } else if (val === 'off_duty') {
            badge.text('Off Duty').removeClass().addClass('rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-400');
        } else {
            badge.text('Available').removeClass().addClass('rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400');
        }
    }

    function setPreviewImage(src) {
        $('#previewImg').attr('src', src).removeClass('hidden');
        $('#previewIcon').addClass('hidden');
    }

    function resetImagePreview() {
        imageInput.value = '';
        $('#fileInfoContainer').addClass('hidden');
        $('#uploadPlaceholder').removeClass('hidden');
        $('#previewImg').addClass('hidden').attr('src', '');
        $('#previewIcon').removeClass('hidden');
        refreshIcons();
    }

    function setFileInfo(name, size) {
        $('#fileNameDisplay').text(name);
        $('#fileSizeDisplay').text(size);
        $('#uploadPlaceholder').addClass('hidden');
        $('#fileInfoContainer').removeClass('hidden');
        refreshIcons();
    }

    function handleImageFile(file) {
        $('#imageError').text('').addClass('hidden');
        $('#imageUploadArea').removeClass('border-red-500 bg-red-50/50 dark:bg-red-950/20');

        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            imageInput.value = '';
            showFieldError('image', 'Image size must be less than 2MB.');
            notify('Image size must be less than 2MB.', 'error');
            return;
        }

        if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
            imageInput.value = '';
            showFieldError('image', 'Please upload a PNG or JPG image.');
            notify('Please upload a PNG or JPG image.', 'error');
            return;
        }

        setFileInfo(file.name, formatFileSize(file.size));

        const reader = new FileReader();
        reader.onload = (event) => setPreviewImage(event.target.result);
        reader.readAsDataURL(file);
    }

    async function loadLicenseTypes() {
        try {
            const response = await jsonRequest('/api/admin/driving-license-types');
            const records = normalizeRecords(response);
            const $sel = $('#drivingLicenseTypeId');
            $sel.find('option:not(:first)').remove();
            if (records) {
                records.forEach(lt => {
                    $sel.append(`<option value="${lt.id}">${lt.type}${lt.price > 0 ? ' (' + lt.price.toLocaleString() + ' MMK/day)' : ''}</option>`);
                });
            }
        } catch (error) {
            handleApiError(error, 'Failed to load license types.');
        }
    }

    async function loadVehicles() {
        try {
            const response = await jsonRequest(vehiclesApi);
            const records = normalizeRecords(response);
            allVehicles = records;
            renderUnassigned('');
            renderAssigned();
        } catch (error) {
            handleApiError(error, 'Failed to load vehicles list.');
        }
    }

    function fillDriver(driver) {
        $(nameInput).val(driver.name);
        $(emailInput).val(driver.email);
        $(phoneInput).val(driver.phone);
        $(licenseNumberInput).val(driver.license_number);
        $(statusSelect).val(driver.status);
        $(addressInput).val(driver.address);

        if (driver.driving_license_type_id) {
            $('#drivingLicenseTypeId').val(driver.driving_license_type_id);
        }

        if (driver.license_expiry_date) {
            if (datepickerInstance) {
                datepickerInstance.setDate(driver.license_expiry_date);
            } else {
                $(licenseExpiryEl).val(driver.license_expiry_date);
            }
        }

        if (driver.vehicles?.length) {
            const ids = driver.vehicles.map(v => v.id);
            const primary = driver.vehicles.find(v => v.pivot?.is_primary);
            $('#vehicleIdsInput').val(ids.join(','));
            $('#primaryVehicleIdInput').val(primary?.id || ids[0] || '');
            renderUnassigned('');
            renderAssigned();
        }

        updateTitlePreview();
        updatePhonePreview();
        updateAddressPreview();
        updateLicensePreview();
        updateStatusPreview();

        if (driver.image_url || driver.image) {
            setPreviewImage(driver.image_url || `/storage/${driver.image}`);
            setFileInfo('Current_Driver_Photo.jpg', 'Cloud Storage');
        }
    }

    async function loadDriver() {
        if (!isEditMode || !driverId) return;

        try {
            const response = await jsonRequest(`${driversApi}/${driverId}`);
            fillDriver(response.data || response.driver || response);
        } catch (error) {
            handleApiError(error, 'Failed to load driver information.');
        }
    }

    function clearValidation() {
        $('.input-error-msg:not(#imageError)').remove();
        $('.border-red-500').removeClass('border-red-500');
        $('#imageError').text('').addClass('hidden');
        $('#imageUploadArea').removeClass('border-red-500 bg-red-50/50 dark:bg-red-950/20');
    }

    function showFieldError(field, message) {
        if (field === 'image') {
            $('#imageUploadArea').addClass('border-red-500 bg-red-50/50 dark:bg-red-950/20');
            $('#imageError').text(message).removeClass('hidden');
            return;
        }

        const $field = $(`[name="${field}"]`);
        if (!$field.length) return;

        $field.addClass('border-red-500');
        $field.after(`<p class="input-error-msg mt-1 text-xs font-medium text-red-600 dark:text-red-400">${message}</p>`);
    }

    function showValidationErrors(errors = {}) {
        const entries = Object.entries(errors);

        entries.forEach(([field, messages]) => {
            showFieldError(field, messages[0]);
        });

        const [firstField, firstMessages] = entries[0] || [];
        if (firstField) {
            const target = firstField === 'image' ? document.getElementById('imageUploadArea') : document.querySelector(`[name="${firstField}"]`);
            target?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            notify(firstMessages[0], 'error');
        }
    }

    function resetForm() {
        form.reset();
        clearDatepicker(datepickerInstance, licenseExpiryEl);
        $('#previewTitle').text('Driver Name');
        $('#previewPhone').text('Not Provided');
        $('#previewAddress').text('No address provided yet.');
        $('#previewLicense').text('Not Set');
        $('#previewStatusBadge').text('Available').removeClass().addClass('rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400');
        resetImagePreview();
        clearValidation();
        $('#vehicleIdsInput').val('');
        $('#primaryVehicleIdInput').val('');
        renderUnassigned('');
        renderAssigned();
    }

    async function submitForm(event) {
        event.preventDefault();
        clearValidation();

        const $button = $('#submitFormBtn');
        const defaultText = isEditMode ? 'Save Changes' : 'Add Driver';
        const data = new FormData(form);

        const ids = getAssignedIds();
        ids.forEach(id => data.append('vehicle_ids[]', id));
        const primary = getPrimaryId();
        if (primary) data.append('primary_vehicle_id', primary);
        if (!ids.length) {
            data.append('vehicle_ids', '');
        }

        if (isEditMode) {
            data.append('_method', 'PUT');
        }

        $button.prop('disabled', true).addClass('opacity-75 cursor-not-allowed').text('Processing...');

        try {
            const response = await jsonRequest(isEditMode ? `${driversApi}/${driverId}` : driversApi, {
                method: 'POST',
                body: data,
            });

            notify(response.message || 'Driver saved successfully.', 'success');

            if (isEditMode) {
                window.setTimeout(() => window.location.assign(indexUrl), 900);
            } else {
                resetForm();
            }
        } catch (error) {
            if (error.status === 422) {
                showValidationErrors(error.payload?.errors);
            } else {
                handleApiError(error, 'Driver could not be saved.');
            }
        } finally {
            $button.prop('disabled', false).removeClass('opacity-75 cursor-not-allowed').text(defaultText);
        }
    }

    $('#driverName').on('input', updateTitlePreview);
    $('#driverPhone').on('input', updatePhonePreview);
    $('#driverAddress').on('input', updateAddressPreview);
    $('#driverLicenseNumber').on('input', updateLicensePreview);
    $('#driverStatus').on('change', updateStatusPreview);
    $('#imageInput').on('change', function () {
        handleImageFile(this.files[0]);
    });
    $('#removeImageBtn').on('click', function (event) {
        event.stopPropagation();
        resetImagePreview();
    });
    $('#cancelFormBtn').on('click', resetForm);
    $('#driverForm').on('submit', submitForm);
    $('#assignBtn').on('click', assignVehicle);
    $('#unassignBtn').on('click', unassignVehicle);
    $('#unassignedSearch').on('input', function () {
        renderUnassigned($(this).val());
        $('#assignBtn').prop('disabled', true);
    });

    const imageUploadArea = document.getElementById('imageUploadArea');
    if (imageUploadArea) {
        imageUploadArea.addEventListener('dragover', function (event) {
            event.preventDefault();
            this.classList.add('border-cyan-500', 'bg-cyan-50/50');
        });
        imageUploadArea.addEventListener('dragleave', function (event) {
            event.preventDefault();
            this.classList.remove('border-cyan-500', 'bg-cyan-50/50');
        });
        imageUploadArea.addEventListener('drop', function (event) {
            event.preventDefault();
            this.classList.remove('border-cyan-500', 'bg-cyan-50/50');
            const file = event.dataTransfer.files[0];
            if (file?.type.startsWith('image/')) {
                imageInput.files = event.dataTransfer.files;
                handleImageFile(file);
            }
        });
        imageUploadArea.addEventListener('click', function (event) {
            if (!event.target.closest('#removeImageBtn')) imageInput.click();
        });
    }

    $('.close-alert').on('click', function () {
        $(this).closest('.rounded-xl').addClass('hidden');
    });

    loadLicenseTypes().then(() => loadVehicles().then(loadDriver));
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initDriverFormPage();
} else {
    window.addEventListener('DOMContentLoaded', initDriverFormPage);
    window.addEventListener('load', initDriverFormPage);
}