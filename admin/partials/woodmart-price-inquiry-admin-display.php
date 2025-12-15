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
'general' => __( 'Общие настройки', 'woodmart-price-inquiry' ),
'form'    => __( 'Форма', 'woodmart-price-inquiry' ),
'captcha' => __( 'Капча', 'woodmart-price-inquiry' ),
);

?>
<div class="wrap">
    <div class="wpi-admin max-w-5xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-900">
                <?php echo esc_html__( 'Woodmart Price Inquiry', 'woodmart-price-inquiry' ); ?>
            </h1>
            <p class="mt-1 text-sm text-slate-600">
                <?php echo esc_html__( 'Настройте поведение кнопки запроса цены, форму и капчу.', 'woodmart-price-inquiry' ); ?>
            </p>
        </div>

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
            <?php if ( $active_tab === 'general' ) : ?>
                <h2 class="text-lg font-semibold text-slate-900">
                    <?php echo esc_html__( 'Общие настройки', 'woodmart-price-inquiry' ); ?>
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    <?php echo esc_html__( 'Здесь будут настройки показа кнопки и условий "нет цены".', 'woodmart-price-inquiry' ); ?>
                </p>

            <?php elseif ( $active_tab === 'form' ) : ?>
                <h2 class="text-lg font-semibold text-slate-900">
                    <?php echo esc_html__( 'Форма', 'woodmart-price-inquiry' ); ?>
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    <?php echo esc_html__( 'Здесь будет выбор: Contact Form 7 или кастомный конструктор формы.', 'woodmart-price-inquiry' ); ?>
                </p>

            <?php elseif ( $active_tab === 'captcha' ) : ?>
                <h2 class="text-lg font-semibold text-slate-900">
                    <?php echo esc_html__( 'Капча', 'woodmart-price-inquiry' ); ?>
                </h2>
                <p class="mt-2 text-sm text-slate-600">
                    <?php echo esc_html__( 'Здесь будут настройки капчи: CF7 Image Captcha или математическая.', 'woodmart-price-inquiry' ); ?>
                </p>
            <?php endif; ?>
        </section>
    </div>
</div>
