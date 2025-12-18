(function () {
    'use strict';

    /**
     * General Tab Toggles
     *
     * @returns {void}
     */
    function initGeneralTabToggles() {
        const placement = document.getElementById('wpi-auto-placement');
        if (!placement) return;

        const radios =
            document.querySelectorAll('input[name="wpi_settings[display_mode]"]');

        const fallbackRadios =
            radios.length ? radios : document.querySelectorAll('input[name="wpi_display_mode"]');

        if (!fallbackRadios.length) return;

        const sync = () => {
            let mode = 'shortcode';
            fallbackRadios.forEach((el) => {
                if (el.checked) mode = el.value;
            });

            const shouldShow = mode === 'auto' || mode === 'both';
            placement.classList.toggle('hidden', !shouldShow);
        };

        fallbackRadios.forEach((el) => el.addEventListener('change', sync));
        sync();
    }

    /**
     * Intercept Reset submit and run AJAX reset.
     *
     * @since 1.0.0
     * @returns {void}
     */
    function initResetButton() {

        const form = document.querySelector('form[action="options.php"]');
        if (!form) return;

        form.addEventListener('submit', (e) => {

            const ev = e;

            const submitter = ev.submitter;
            if (!submitter) return;

            const name = submitter.getAttribute('name');
            const value = submitter.getAttribute('value');

            if (name !== 'wpi_action' || value !== 'reset_general') {
                return; // normal save
            }

            ev.preventDefault();

            if (!window.WPI_ADMIN || !window.WPI_ADMIN.ajaxUrl || !window.WPI_ADMIN.nonce) {
                window.alert('Reset is not configured (missing WPI_ADMIN).');
                return;
            }

            const ok = window.confirm('Reset settings to defaults?');
            if (!ok) return;

            const body = new URLSearchParams();
            body.set('action', 'wpi_reset_settings');
            body.set('nonce', window.WPI_ADMIN.nonce);

            fetch(window.WPI_ADMIN.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
                body: body.toString(),
                credentials: 'same-origin',
            })
                .then((r) => r.json())
                .then((data) => {
                    if (!data || !data.success) {
                        window.alert('Reset failed');
                        return;
                    }
                    window.location.reload();
                })
                .catch(() => window.alert('Reset failed'));
        });
    }

    /**
     * Toggle Form tab sections (CF7 vs Custom).
     *
     * @since 1.0.0
     * @returns {void}
     */
    function initFormTabToggles() {
        const cf7Box = document.getElementById('wpi-form-cf7');
        const customBox = document.getElementById('wpi-form-custom');
        if (!cf7Box || !customBox) return;

        const radios =
            document.querySelectorAll('input[name="wpi_settings[form_provider]"]');

        if (!radios.length) return;

        const sync = () => {
            let val = 'cf7';
            radios.forEach((el) => {
                if (el.checked) val = el.value;
            });

            const isCf7 = val === 'cf7';
            cf7Box.classList.toggle('hidden', !isCf7);
            customBox.classList.toggle('hidden', isCf7);
        };

        radios.forEach((el) => el.addEventListener('change', sync));
        sync();
    }

    document.addEventListener('DOMContentLoaded', () => {
        initGeneralTabToggles();
        initResetButton();
        initFormTabToggles();
    });

})();
