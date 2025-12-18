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


    /**
     * Custom fields builder (add/remove + reindex).
     *
     * @since 1.0.0
     * @returns {void}
     */
    function initCustomFieldsBuilder() {
        const list = document.getElementById('wpi-fields-list');
        const addBtn = document.getElementById('wpi-add-field');
        const tpl = document.getElementById('wpi-field-template');

        if (!list || !addBtn || !tpl) return;

        /**
         * @returns {void}
         */
        const reindex = () => {
            const rows = list.querySelectorAll('.wpi-field-row');
            rows.forEach((row, i) => {
                row.dataset.index = String(i);

                /** @type {NodeListOf<HTMLInputElement|HTMLSelectElement|HTMLTextAreaElement>} */
                const inputs = row.querySelectorAll('input[name], select[name], textarea[name]');
                inputs.forEach((el) => {
                    const name = el.getAttribute('name');
                    if (!name) return;

                    // Replace [<number>] with [i] for wpi_settings[custom_fields]
                    const next = name.replace(/wpi_settings\[custom_fields]\[\d+]/g, `wpi_settings[custom_fields][${i}]`);
                    el.setAttribute('name', next);
                });
            });
        };

        addBtn.addEventListener('click', () => {
            const index = list.querySelectorAll('.wpi-field-row').length;
            const html = tpl.innerHTML.replaceAll('__INDEX__', String(index));

            const wrap = document.createElement('div');
            wrap.innerHTML = html.trim();

            const node = wrap.firstElementChild;
            if (!node) return;

            list.appendChild(node);
            reindex();
        });

        list.addEventListener('click', (e) => {
            /** @type {HTMLElement} */
            const target = e.target;
            const btn = target.closest('.wpi-remove-field');
            if (!btn) return;

            const row = btn.closest('.wpi-field-row');
            if (!row) return;

            row.remove();
            reindex();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initGeneralTabToggles();
        initResetButton();
        initFormTabToggles();
        initCustomFieldsBuilder();
    });

})();
