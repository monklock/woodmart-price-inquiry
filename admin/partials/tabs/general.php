<?php
/**
 * General tab.
 *
 * @since 1.0.0
 *
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/admin/partials/tabs
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/** @var Woodmart_Price_Inquiry_Admin $this */
$settings = $this->get_settings();

$field_name = static function ( string $key ): string {
    return Woodmart_Price_Inquiry_Admin::OPTION_NAME . '[' . $key . ']';
};

?>
<form method="post" action="options.php" class="space-y-6">
    <?php settings_fields( Woodmart_Price_Inquiry_Admin::SETTINGS_GROUP ); ?>

    <div class="flex items-start justify-between gap-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                <?php echo esc_html__( 'General settings', 'woodmart-price-inquiry' ); ?>
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                <?php echo esc_html__( 'Configure the button display and modal window behavior for products without a price.', 'woodmart-price-inquiry' ); ?>
            </p>
        </div>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'Show price request button', 'woodmart-price-inquiry' ); ?>
        </h3>

        <div class="mt-4 flex items-center justify-between gap-4">
            <div>
                <p class="text-sm text-slate-700">
                    <?php echo esc_html__( 'Включить', 'woodmart-price-inquiry' ); ?>
                </p>
                <p class="mt-1 text-xs text-slate-500">
                    <?php echo esc_html__( 'If disabled, the button will not be displayed.', 'woodmart-price-inquiry' ); ?>
                </p>
            </div>

            <label class="relative inline-flex cursor-pointer items-center">
                <input
                        type="checkbox"
                        class="peer sr-only"
                        name="<?php echo esc_attr( $field_name( 'enabled' ) ); ?>"
                        value="1"
                        <?php checked( ! empty( $settings['enabled'] ) ); ?>
                >
                <span class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600"></span>
                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></span>
            </label>
        </div>
    </section>

    <div id="wpi-general-dependent" class="space-y-6">
        <section class="rounded-xl border border-slate-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-slate-900">
                <?php echo esc_html__( 'Condition', 'woodmart-price-inquiry' ); ?>
            </h3>
            <p class="mt-1 text-xs text-slate-500">
                <?php echo esc_html__( 'Determines when to show the button on the product page.', 'woodmart-price-inquiry' ); ?>
            </p>

            <?php $rule = isset( $settings['price_missing_rule'] ) ? (string) $settings['price_missing_rule'] : 'empty'; ?>

            <div class="mt-4 space-y-3">
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input
                            type="radio"
                            name="<?php echo esc_attr( $field_name( 'price_missing_rule' ) ); ?>"
                            class="mt-1"
                            value="empty"
                            <?php checked( $rule, 'empty' ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900">
							<?php echo esc_html__( 'The price of the product is not specified', 'woodmart-price-inquiry' ); ?>
						</span>
						<span class="block text-xs text-slate-500">
							<?php echo esc_html__( 'The button is shown if the product does not have a price value.', 'woodmart-price-inquiry' ); ?>
						</span>
					</span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input
                            type="radio"
                            name="<?php echo esc_attr( $field_name( 'price_missing_rule' ) ); ?>"
                            class="mt-1"
                            value="empty_or_zero"
                            <?php checked( $rule, 'empty_or_zero' ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900">
							<?php echo esc_html__( 'The price is empty or equal to 0', 'woodmart-price-inquiry' ); ?>
						</span>
						<span class="block text-xs text-slate-500">
							<?php echo esc_html__( 'Suitable if the site uses "zero" prices instead of empty ones.', 'woodmart-price-inquiry' ); ?>
						</span>
					</span>
                </label>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-slate-900">
                <?php echo esc_html__( 'Button text', 'woodmart-price-inquiry' ); ?>
            </h3>

            <div class="mt-4">
                <label class="block text-xs font-medium text-slate-600" for="price-inquiry-button">
                    <?php echo esc_html__( 'Inscription on the button', 'woodmart-price-inquiry' ); ?>
                </label>
                <input
                        type="text"
                        id="price-inquiry-button"
                        name="<?php echo esc_attr( $field_name( 'button_text' ) ); ?>"
                        class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        value="<?php echo esc_attr( isset( $settings['button_text'] ) ? (string) $settings['button_text'] : __( 'Request a price', 'woodmart-price-inquiry' ) ); ?>"
                >
                <p class="mt-2 text-xs text-slate-500">
                    <?php echo esc_html__( 'Can be overridden in shortcode  [price-inquiry text="button text"].', 'woodmart-price-inquiry' ); ?>
                </p>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-slate-900">
                <?php echo esc_html__( 'Where to show the button', 'woodmart-price-inquiry' ); ?>
            </h3>
            <p class="mt-1 text-xs text-slate-500">
                <?php echo esc_html__( 'Select the output mode: shortcode only or auto-substitution on the product page.', 'woodmart-price-inquiry' ); ?>
            </p>

            <?php $mode = isset( $settings['display_mode'] ) ? (string) $settings['display_mode'] : 'shortcode'; ?>

            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input
                            type="radio"
                            name="<?php echo esc_attr( $field_name( 'display_mode' ) ); ?>"
                            class="mt-1"
                            value="shortcode"
                            <?php checked( $mode, 'shortcode' ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900">
							<?php echo esc_html__( 'Shortcode only', 'woodmart-price-inquiry' ); ?>
						</span>
						<span class="block text-xs text-slate-500">
							<?php echo esc_html__( 'You place the button in the template/description yourself.', 'woodmart-price-inquiry' ); ?>
						</span>
					</span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input
                            type="radio"
                            name="<?php echo esc_attr( $field_name( 'display_mode' ) ); ?>"
                            class="mt-1"
                            value="auto"
                            <?php checked( $mode, 'auto' ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900">
							<?php echo esc_html__( 'Automatically', 'woodmart-price-inquiry' ); ?>
						</span>
						<span class="block text-xs text-slate-500">
							<?php echo esc_html__( 'The button is added to the product page automatically.', 'woodmart-price-inquiry' ); ?>
						</span>
					</span>
                </label>

                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                    <input
                            type="radio"
                            name="<?php echo esc_attr( $field_name( 'display_mode' ) ); ?>"
                            class="mt-1"
                            value="both"
                            <?php checked( $mode, 'both' ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900">
							<?php echo esc_html__( 'Both', 'woodmart-price-inquiry' ); ?>
						</span>
						<span class="block text-xs text-slate-500">
							<?php echo esc_html__( 'Auto + ability to insert using shortcode.', 'woodmart-price-inquiry' ); ?>
						</span>
					</span>
                </label>
            </div>

            <?php $pos = isset( $settings['auto_position'] ) ? (string) $settings['auto_position'] : 'replace_price'; ?>

            <div id="wpi-auto-placement" class="mt-5 hidden rounded-lg border border-slate-200 bg-slate-50 p-4">
                <p class="text-xs font-medium text-slate-700">
                    <?php echo esc_html__( 'Position on the product page', 'woodmart-price-inquiry' ); ?>
                </p>

                <div class="mt-3">
                    <label for="wpi-auto-placement-select">
                        <select
                                id="wpi-auto-placement-select"
                                name="<?php echo esc_attr( $field_name( 'auto_position' ) ); ?>"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                            <option value="replace_price" <?php selected( $pos, 'replace_price' ); ?>><?php echo esc_html__( 'Instead of price', 'woodmart-price-inquiry' ); ?></option>
                            <option value="after_price" <?php selected( $pos, 'after_price' ); ?>><?php echo esc_html__( 'After the price', 'woodmart-price-inquiry' ); ?></option>
                            <option value="after_cart" <?php selected( $pos, 'after_cart' ); ?>><?php echo esc_html__( 'After the "Add to cart" button', 'woodmart-price-inquiry' ); ?></option>
                            <option value="after_excerpt" <?php selected( $pos, 'after_excerpt' ); ?>><?php echo esc_html__( 'After a brief description', 'woodmart-price-inquiry' ); ?></option>
                        </select>
                    </label>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5">
            <h3 class="text-sm font-semibold text-slate-900">
                <?php echo esc_html__( 'Modal window', 'woodmart-price-inquiry' ); ?>
            </h3>

            <div class="mt-4 space-y-4">
                <label class="flex cursor-pointer items-start gap-3">
                    <input
                            type="checkbox"
                            class="mt-1"
                            name="<?php echo esc_attr( $field_name( 'modal_autoclose' ) ); ?>"
                            value="1"
                            <?php checked( ! empty( $settings['modal_autoclose'] ) ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900"><?php echo esc_html__( 'Auto-close after successful submission', 'woodmart-price-inquiry' ); ?></span>
						<span class="block text-xs text-slate-500"><?php echo esc_html__( 'Valid for CF7 (upon successful dispatch).', 'woodmart-price-inquiry' ); ?></span>
					</span>
                </label>

                <label class="flex cursor-pointer items-start gap-3">
                    <input
                            type="checkbox"
                            class="mt-1"
                            name="<?php echo esc_attr( $field_name( 'modal_allow_close' ) ); ?>"
                            value="1"
                            <?php checked( ! empty( $settings['modal_allow_close'] ) ); ?>
                    >
                    <span>
						<span class="block text-sm font-medium text-slate-900"><?php echo esc_html__( 'Allow closing by clicking outside the window and ESC', 'woodmart-price-inquiry' ); ?></span>
						<span class="block text-xs text-slate-500"><?php echo esc_html__( 'Recommended for convenience, especially on mobile devices.', 'woodmart-price-inquiry' ); ?></span>
					</span>
                </label>
            </div>
        </section>
    </div>

    <div class="flex items-center justify-end gap-3 pt-2">
        <button
                type="submit"
                name="wpi_action"
                value="reset_general"
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
        >
            <?php echo esc_html__( 'Reset', 'woodmart-price-inquiry' ); ?>
        </button>

        <button
                type="submit"
                name="wpi_action"
                value="save"
                class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700"
        >
            <?php echo esc_html__( 'Save', 'woodmart-price-inquiry' ); ?>
        </button>
    </div>
</form>
