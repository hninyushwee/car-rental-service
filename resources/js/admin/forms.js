import { refreshIcons } from './icons';

export function setButtonLoading(button, isLoading, loadingText = 'Saving...', defaultText = 'Save') {
    if (!button) return;

    button.disabled = isLoading;
    button.classList.toggle('opacity-70', isLoading);
    button.classList.toggle('cursor-not-allowed', isLoading);
    button.innerHTML = isLoading
        ? `<i data-lucide="loader-circle" class="h-4 w-4 animate-spin"></i>${loadingText}`
        : defaultText;

    refreshIcons();
}

export function resetFormState(form) {
    form?.reset();
}
