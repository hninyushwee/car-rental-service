import { refreshIcons } from './icons';

export function createAlertManager({ successBox, successText, errorBox, errorText, closeSelector = '.close-alert' }) {
    function hideAll() {
        successBox?.classList.add('hidden');
        errorBox?.classList.add('hidden');
    }

    function show(type, message, timeout = 3500) {
        hideAll();

        const box = type === 'success' ? successBox : errorBox;
        const text = type === 'success' ? successText : errorText;

        if (!box || !text) return;

        text.textContent = message;
        box.classList.remove('hidden');
        refreshIcons();

        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (timeout) {
            window.setTimeout(() => box.classList.add('hidden'), timeout);
        }
    }

    document.querySelectorAll(closeSelector).forEach((button) => {
        button.addEventListener('click', () => button.closest('[data-alert-box]')?.classList.add('hidden'));
    });

    return {
        hideAll,
        success: (message, timeout) => show('success', message, timeout),
        error: (message, timeout) => show('error', message, timeout),
    };
}
