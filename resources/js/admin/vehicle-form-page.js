import $ from 'jquery';
import { jsonRequest, normalizeRecords } from './http';
import { notify } from './notify';

function refreshIcons() {
    window.initLucideIcons?.();
}

function selectedName(select, fallback = '') {
    return select.options[select.selectedIndex]?.dataset.name || fallback;
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

function initVehicleFormPage() {
    const $page = $('[data-page="admin-vehicle-form"]');

    if (!$page.length || $page.data('initialized')) {
        return;
    }

    $page.data('initialized', true);

    const isEditMode = $page.data('edit') === true || $page.data('edit') === 'true';
    const vehicleId = $page.data('id');
    const vehiclesApi = $page.data('vehiclesApi') || '/api/admin/vehicles';
    const brandsApi = $page.data('brandsApi') || '/api/admin/brands';
    const categoriesApi = $page.data('categoriesApi') || '/api/admin/categories';
    const indexUrl = $page.data('indexUrl') || '/admin/vehicles';
    const loginUrl = $page.data('loginUrl') || '/login';

    const form = document.getElementById('vehicleForm');
    const brandInput = document.getElementById('vehicleBrand');
    const modelInput = document.getElementById('vehicleModel');
    const categorySelect = document.getElementById('vehicleCategory');
    const priceInput = document.getElementById('vehiclePrice');
    const imageInput = document.getElementById('imageInput');
    const descriptionInput = document.getElementById('vehicleDescription');
    const yearPickerEl = document.querySelector('.year-picker');

    if (!form || !brandInput || !modelInput || !categorySelect || !priceInput || !imageInput) {
        return;
    }

    const datepickerInstance = yearPickerEl && window.Datepicker
        ? new window.Datepicker(yearPickerEl, {
            pickLevel: 2,
            format: 'yyyy',
            autohide: true,
            startView: 2,
            maxView: 2,
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
        const brand = selectedName(brandInput, 'Vehicle');
        const model = modelInput.value || 'Model';
        $('#previewTitle').text(`${brand} ${model}`);
    }

    function updateCategoryPreview() {
        $('#previewCategory').text(selectedName(categorySelect, 'Not Selected'));
    }

    function updateDescriptionPreview() {
        const text = descriptionInput?.value.trim();
        $('#previewDescription').text(text || 'No description provided yet.');
    }

    function updatePricePreview() {
        const price = Number(priceInput.value || 0);
        $('#previewPrice').text(`$${price.toFixed(2)}`);
        $('#previewDeposit').text(`$${(price * 0.1).toFixed(2)}`);
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

    async function loadDropdown(apiUrl, select, placeholder) {
        try {
            const response = await jsonRequest(apiUrl);
            const records = normalizeRecords(response);

            select.innerHTML = [
                `<option value="">Select ${placeholder}</option>`,
                ...records.map((item) => `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`),
            ].join('');
        } catch (error) {
            select.innerHTML = `<option value="">Error loading ${placeholder}</option>`;
            handleApiError(error, `Failed to load ${placeholder.toLowerCase()} list.`);
        }
    }

    function fillVehicle(vehicle) {
        $(brandInput).val(vehicle.brand_id);
        $(categorySelect).val(vehicle.category_id);
        $('#vehicleStatus').val(vehicle.status);
        $(modelInput).val(vehicle.model);
        $('#vehiclePlate').val(vehicle.license_plate);
        $('#vehicleColor').val(vehicle.color);
        $('#vehicleCapacity').val(vehicle.capacity);
        $(priceInput).val(vehicle.price_per_day);
        $(descriptionInput).val(vehicle.description);

        if (datepickerInstance && vehicle.year) {
            datepickerInstance.setDate(String(vehicle.year));
        } else {
            $('#vehicleYear').val(vehicle.year);
        }

        updateTitlePreview();
        updateCategoryPreview();
        updateDescriptionPreview();
        updatePricePreview();

        if (vehicle.image_url || vehicle.image) {
            setPreviewImage(vehicle.image_url || `/storage/${vehicle.image}`);
            setFileInfo('Current_Vehicle_Image.jpg', 'Cloud Storage');
        }
    }

    async function loadVehicle() {
        if (!isEditMode || !vehicleId) return;

        try {
            const response = await jsonRequest(`${vehiclesApi}/${vehicleId}`);
            fillVehicle(response.data || response.vehicle || response);
        } catch (error) {
            handleApiError(error, 'Failed to load vehicle information.');
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
        clearDatepicker(datepickerInstance, yearPickerEl);
        $('#previewTitle').text('Vehicle Model');
        $('#previewCategory').text('Not Selected');
        $('#previewDescription').text('No description provided yet.');
        $('#previewPrice').text('$0.00');
        $('#previewDeposit').text('$0.00');
        resetImagePreview();
        clearValidation();
    }

    async function submitForm(event) {
        event.preventDefault();
        clearValidation();

        const $button = $('#submitFormBtn');
        const defaultText = isEditMode ? 'Save Changes' : 'Add Vehicle';
        const data = new FormData(form);

        if (isEditMode) {
            data.append('_method', 'PUT');
        }

        $button.prop('disabled', true).addClass('opacity-75 cursor-not-allowed').text('Processing...');

        try {
            const response = await jsonRequest(isEditMode ? `${vehiclesApi}/${vehicleId}` : vehiclesApi, {
                method: isEditMode ? 'POST' : 'POST',
                body: data,
            });

            notify(response.message || 'Vehicle saved successfully.', 'success');

            if (isEditMode) {
                window.setTimeout(() => window.location.assign(indexUrl), 900);
            } else {
                resetForm();
            }
        } catch (error) {
            if (error.status === 422) {
                showValidationErrors(error.payload?.errors);
            } else {
                handleApiError(error, 'Vehicle could not be saved.');
            }
        } finally {
            $button.prop('disabled', false).removeClass('opacity-75 cursor-not-allowed').text(defaultText);
        }
    }

    $('#vehicleBrand').on('change', updateTitlePreview);
    $('#vehicleModel').on('input', updateTitlePreview);
    $('#vehicleCategory').on('change', updateCategoryPreview);
    $('#vehiclePrice').on('input', updatePricePreview);
    $('#vehicleDescription').on('input', updateDescriptionPreview);
    $('#imageInput').on('change', function () {
        handleImageFile(this.files[0]);
    });
    $('#removeImageBtn').on('click', function (event) {
        event.stopPropagation();
        resetImagePreview();
    });
    $('#cancelFormBtn').on('click', resetForm);
    $('#vehicleForm').on('submit', submitForm);

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

    Promise.all([
        loadDropdown(brandsApi, brandInput, 'Brand'),
        loadDropdown(categoriesApi, categorySelect, 'Category'),
    ]).then(loadVehicle);
}

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initVehicleFormPage();
} else {
    window.addEventListener('DOMContentLoaded', initVehicleFormPage);
    window.addEventListener('load', initVehicleFormPage);
}
