<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-password-toggle]').forEach(function (toggle) {
            const field = toggle.closest('.password-field');
            const password = field ? field.querySelector('input') : null;
            const eye = toggle.querySelector('[data-password-eye]');

            if (!password || !eye) {
                return;
            }

            toggle.addEventListener('click', function () {
                const isHidden = password.type === 'password';
                password.type = isHidden ? 'text' : 'password';
                eye.classList.toggle('is-visible', isHidden);
                toggle.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
            });
        });
    });
</script>
