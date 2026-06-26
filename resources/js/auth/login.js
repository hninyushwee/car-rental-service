import { jsonRequest } from '../admin/http';

function setText(element, value) {
    if (element) element.textContent = value;
}

function setHidden(element, hidden) {
    element?.classList.toggle('hidden', hidden);
}

function initLoginForm() {
    const form = document.querySelector('[data-auth-login-form]');
    if (!form) return;

    const submitButton = document.getElementById('loginSubmitBtn');
    const buttonText = document.getElementById('loginBtnText');
    const alertBox = document.getElementById('globalAuthAlert');
    const alertMessage = document.getElementById('globalAlertMessage');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function resetErrors() {
        setHidden(alertBox, true);
        setText(alertMessage, '');
        setHidden(emailError, true);
        setText(emailError, '');
        setHidden(passwordError, true);
        setText(passwordError, '');
    }

    function setLoading(isLoading) {
        submitButton.disabled = isLoading;
        submitButton.classList.toggle('opacity-75', isLoading);
        submitButton.classList.toggle('cursor-not-allowed', isLoading);
        setText(buttonText, isLoading ? 'Verifying...' : 'Sign In');
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        resetErrors();
        setLoading(true);

        try {
            await jsonRequest(form.action, {
                method: 'POST',
                body: {
                    email: form.email.value.trim(),
                    password: form.password.value,
                },
            });

            setText(buttonText, 'Authenticated! Redirecting...');
            window.location.assign(form.dataset.redirect || '/admin');
        } catch (error) {
            const errors = error.payload?.errors || {};

            if (errors.email?.[0]) {
                setText(emailError, errors.email[0]);
                setHidden(emailError, false);
            }

            if (errors.password?.[0]) {
                setText(passwordError, errors.password[0]);
                setHidden(passwordError, false);
            }

            if (!errors.email && !errors.password) {
                setText(alertMessage, error.payload?.message || 'Invalid email or password credentials.');
                setHidden(alertBox, false);
            }

            setLoading(false);
        }
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLoginForm);
} else {
    initLoginForm();
}
