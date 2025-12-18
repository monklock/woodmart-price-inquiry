<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://delay-delo.com
 * @since      1.0.0
 *
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/admin/partials
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

/** @var Woodmart_Price_Inquiry_Admin $this */
$active_tab = $this->get_active_tab();

$tabs = array(
        'general' => __( 'General settings', 'woodmart-price-inquiry' ),
        'form'    => __( 'Form', 'woodmart-price-inquiry' ),
        'captcha' => __( 'Captcha', 'woodmart-price-inquiry' ),
);

?>

<div class="wrap">
    <div class="wpi-admin max-w-5xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-900">
                <?php echo esc_html__( 'Woodmart Price Inquiry', 'woodmart-price-inquiry' ); ?>
            </h1>
            <p class="mt-3 text-sm text-slate-600">
                <?php echo esc_html__( 'Customize the behavior of the price request button, form, and captcha.', 'woodmart-price-inquiry' ); ?>
            </p>
        </div>

        <?php if ( isset( $_GET['wpi_reset'] ) && '1' === (string) $_GET['wpi_reset'] ) : ?>
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                <?php echo esc_html__( 'Settings have been reset to default values.', 'woodmart-price-inquiry' ); ?>
            </div>
        <?php endif; ?>

        <nav class="mb-6 border-b border-slate-200">
            <ul class="-mb-px flex gap-3">
                <?php foreach ( $tabs as $tab_key => $tab_label ) : ?>
                    <?php $is_active = ( $active_tab === $tab_key ); ?>
                    <li>
                        <a
                                href="<?php echo esc_url( $this->get_tab_url( $tab_key ) ); ?>"
                                class="<?php echo $is_active ? 'wpi-tab wpi-tab--active' : 'wpi-tab'; ?>"
                        >
                            <?php echo esc_html( $tab_label ); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            <?php
            $tab_file = plugin_dir_path( __FILE__ ) . 'tabs/' . $active_tab . '.php';

            if ( file_exists( $tab_file ) ) {
                require $tab_file;
            } else {
                echo '<p class="text-sm text-slate-600">' . esc_html__( 'Tab not found.', 'woodmart-price-inquiry' ) . '</p>';
            }
            ?>
        </section>
    </div>
</div>
