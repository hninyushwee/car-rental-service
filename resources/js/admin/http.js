import $ from 'jquery';

function csrfToken() {
    return $('meta[name="csrf-token"]').attr('content') || '';
}

export function ajaxHeaders(headers = {}) {
    return {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(csrfToken() ? { 'X-CSRF-TOKEN': csrfToken() } : {}),
        ...headers,
    };
}

export function normalizeRecords(payload) {
    if (Array.isArray(payload?.data?.data)) return payload.data.data;
    if (Array.isArray(payload?.data)) return payload.data;
    if (Array.isArray(payload?.vehicles)) return payload.vehicles;
    return [];
}

export function jsonRequest(url, options = {}) {
    const method = options.method || 'GET';
    const isFormData = options.body instanceof FormData;

    return new Promise((resolve, reject) => {
        $.ajax({
            url,
            method,
            dataType: 'json',
            contentType: isFormData ? false : 'application/json',
            processData: !isFormData,
            headers: ajaxHeaders(options.headers),
            data: isFormData ? options.body : (options.body ? JSON.stringify(options.body) : undefined),
            success(payload) {
                if (payload?.success === false) {
                    const error = new Error(payload.message || 'Request failed.');
                    error.status = 422;
                    error.payload = payload;
                    reject(error);
                    return;
                }

                resolve(payload);
            },
            error(xhr) {
                const payload = xhr.responseJSON || {
                    success: false,
                    message: xhr.responseText || xhr.statusText || 'Invalid server response.',
                };
                const error = new Error(payload.message || 'Request failed.');
                error.status = xhr.status;
                error.payload = payload;
                reject(error);
            },
        });
    });
}
