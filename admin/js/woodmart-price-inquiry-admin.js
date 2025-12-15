(function() {
	'use strict';
    /**
     * @returns {void}
     */
    function initGeneralTabToggles() {
        const placement = document.getElementById('wpi-auto-placement');
        if (!placement) return;

        /** @type {NodeListOf<HTMLInputElement>} */
        const radios = document.querySelectorAll('input[name="wpi_display_mode"]');

        /**
         * @returns {void}
         */
        const sync = () => {
            let mode = 'shortcode';
            radios.forEach((el) => {
                if (el.checked) mode = el.value;
            });

            const shouldShow = mode === 'auto' || mode === 'both';
            placement.classList.toggle('hidden', !shouldShow);
        };

        radios.forEach((el) => el.addEventListener('change', sync));
        sync();
    }

    document.addEventListener('DOMContentLoaded', initGeneralTabToggles);
})( jQuery );
