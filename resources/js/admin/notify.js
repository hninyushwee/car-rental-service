const styles = {
    success: {
        light: 'linear-gradient(135deg, #06b6d4 0%, #2563eb 100%)',
        dark: 'linear-gradient(135deg, #0891b2 0%, #1d4ed8 100%)',
    },
    error: {
        light: 'linear-gradient(135deg, #ef4444 0%, #b91c1c 100%)',
        dark: 'linear-gradient(135deg, #991b1b 0%, #7f1d1d 100%)',
    },
};

export function notify(message, type = 'success', options = {}) {
    const safeType = type === 'error' ? 'error' : 'success';
    const isDark = document.documentElement.classList.contains('dark');

    window.Toastify?.({
        text: message,
        duration: options.duration || 3500,
        close: true,
        gravity: 'bottom',
        position: 'right',
        stopOnFocus: true,
        style: {
            background: styles[safeType][isDark ? 'dark' : 'light'],
            borderRadius: '14px',
            padding: '12px 18px',
            color: '#ffffff',
            fontSize: '14px',
            fontWeight: '600',
            boxShadow: '0 18px 35px rgba(15, 23, 42, 0.24)',
        },
    }).showToast();

    window.initLucideIcons?.();
}

export function validationMessage(error, field) {
    const messages = error?.payload?.errors?.[field];
    return Array.isArray(messages) ? messages[0] : null;
}
