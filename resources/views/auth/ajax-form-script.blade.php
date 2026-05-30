<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('[data-ajax-auth-form]');

    if (!form) {
        return;
    }

    const button = form.querySelector('button[type="submit"]');
    const originalButtonHtml = button ? button.innerHTML : '';
    let popupTimer = null;

    const resetButton = function () {
        if (!button) {
            return;
        }

        button.disabled = false;
        button.innerHTML = originalButtonHtml;
    };

    const hidePopup = function (popup) {
        popup.classList.remove('is-visible');
        popup.setAttribute('aria-hidden', 'true');
    };

    const showPopup = function (message, type) {
        let popup = document.querySelector('.ajax-feedback-modal');

        if (!popup) {
            popup = document.createElement('div');
            popup.className = 'ajax-feedback-modal';
            popup.setAttribute('aria-hidden', 'true');
            popup.innerHTML = '<div class="ajax-feedback-modal__backdrop" data-popup-close></div><section class="ajax-feedback-modal__card" role="alertdialog" aria-modal="true" aria-labelledby="ajaxFeedbackTitle"><button type="button" class="ajax-feedback-modal__close" data-popup-close aria-label="Close">&times;</button><span class="ajax-feedback-modal__icon" aria-hidden="true">&#10003;</span><p class="ajax-feedback-modal__eyebrow"></p><h2 class="ajax-feedback-modal__title" id="ajaxFeedbackTitle"></h2><p class="ajax-feedback-modal__message"></p><button type="button" class="ajax-feedback-modal__action" data-popup-close>Okay</button></section>';
            document.body.appendChild(popup);
            popup.querySelectorAll('[data-popup-close]').forEach(function (closeButton) {
                closeButton.addEventListener('click', function () {
                    hidePopup(popup);
                });
            });
        }

        const isError = type === 'error';
        const isPassiveSuccess = !isError && form.hasAttribute('data-success-notice-only');
        popup.querySelector('.ajax-feedback-modal__icon').textContent = isError ? '\u00d7' : '\u2713';
        popup.querySelector('.ajax-feedback-modal__eyebrow').textContent = isError ? 'Please try again' : 'Completed';
        popup.querySelector('.ajax-feedback-modal__title').textContent = isError ? 'Unable to complete request' : 'Success!';
        popup.querySelector('.ajax-feedback-modal__message').textContent = message;
        popup.classList.toggle('is-error', isError);
        popup.classList.toggle('is-passive-success', isPassiveSuccess);
        popup.setAttribute('aria-hidden', 'false');
        popup.classList.add('is-visible');
        window.clearTimeout(popupTimer);
        popupTimer = window.setTimeout(function () {
            hidePopup(popup);
        }, isError ? 5200 : 4200);
    };

    const clearErrors = function () {
        form.querySelectorAll('.js-ajax-field-error').forEach(function (error) {
            error.remove();
        });
        form.querySelectorAll('.is-invalid').forEach(function (field) {
            field.classList.remove('is-invalid');
            field.removeAttribute('aria-invalid');
        });

    };

    const setFieldError = function (name, message) {
        const field = form.elements.namedItem(name);

        if (!field || !field.classList) {
            return;
        }

        field.classList.add('is-invalid');
        field.setAttribute('aria-invalid', 'true');

        const error = document.createElement('small');
        error.className = 'field-error js-ajax-field-error';
        error.textContent = message;
        (field.closest('.password-field') || field).insertAdjacentElement('afterend', error);
    };

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors();

        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="ajax-spinner" aria-hidden="true"></span>' + (form.dataset.processingLabel || 'Processing...');
        }

        try {
            const response = await fetch(form.action, {
                method: form.method || 'POST',
                body: new FormData(form),
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });
            const data = await response.json().catch(function () {
                return {};
            });

            if (!response.ok) {
                Object.entries(data.errors || {}).forEach(function ([name, messages]) {
                    setFieldError(name, Array.isArray(messages) ? messages[0] : messages);
                });
                const firstError = Object.values(data.errors || {})[0];
                showPopup(Array.isArray(firstError) ? firstError[0] : (data.message || 'Please check the highlighted fields and try again.'), 'error');

                resetButton();
                return;
            }

            showPopup(data.message || 'Your request was successful.', 'success');

            if (data.redirect) {
                window.setTimeout(function () {
                    window.location.assign(data.redirect);
                }, 1700);
                return;
            }

            resetButton();
        } catch (error) {
            showPopup('Something went wrong while processing your request. Please try again.', 'error');
            resetButton();
        }
    });
});
</script>
