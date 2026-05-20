/* Multitechwave admin custom scripts extracted from Blade templates. */

const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarClose = document.getElementById('sidebar-close');
        const mobileBreakpoint = window.matchMedia('(max-width: 991px)');

        const closeSidebar = () => {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
        };

        const toggleSidebar = () => {
            const isOpen = sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active', isOpen);
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        menuToggle?.addEventListener('click', toggleSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);
        sidebarClose?.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            if (!mobileBreakpoint.matches) {
                closeSidebar();
            }
        });



// Extracted from resources/views/dashboard/profile/edit.blade.php
document.addEventListener('DOMContentLoaded', function () {
    const profileMenu = document.querySelector('.admin-profile-menu');
    const profileTrigger = document.getElementById('admin-profile-trigger');

    profileTrigger?.addEventListener('click', function () {
        const isOpen = profileMenu.classList.toggle('is-open');
        profileTrigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function (event) {
        if (!profileMenu || profileMenu.contains(event.target)) {
            return;
        }

        profileMenu.classList.remove('is-open');
        profileTrigger?.setAttribute('aria-expanded', 'false');
    });

            document.querySelectorAll('.password-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.target);

                    if (!input) {
                        return;
                    }

                    const isPassword = input.type === 'password';
                    input.type = isPassword ? 'text' : 'password';
                    button.innerHTML = isPassword
                        ? '<i class="fas fa-eye-slash"></i>'
                        : '<i class="fas fa-eye"></i>';
                });
            });
        });

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-rich-action][data-rich-target]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.richTarget);

            if (!input) {
                return;
            }

            const start = input.selectionStart;
            const end = input.selectionEnd;
            const selected = input.value.slice(start, end);
            const action = button.dataset.richAction;
            let replacement = selected;

            if (action === 'bold') {
                replacement = `<strong>${selected || 'Bold text'}</strong>`;
            }

            if (action === 'underline') {
                replacement = `<u>${selected || 'Underlined text'}</u>`;
            }

            if (action === 'bullet') {
                const lines = (selected || 'List item')
                    .split(/\r?\n/)
                    .map(function (line) {
                        return line.trim();
                    })
                    .filter(Boolean);

                replacement = `<ul>\n${lines.map(function (line) {
                    return `  <li>${line}</li>`;
                }).join('\n')}\n</ul>`;
            }

            input.setRangeText(replacement, start, end, 'end');
            input.focus();
        });
    });
});

