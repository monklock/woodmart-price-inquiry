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

                <form method="post" action="options.php" class="space-y-6">
                    <?php
                    /**
                     * Settings API will be wired later.
                     * For now, this is UI-only markup example.
                     *
                     * @since 1.0.0
                     */
                    ?>

                    <div class="flex items-start justify-between gap-6">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">
                                <?php echo esc_html__( 'Общие настройки', 'woodmart-price-inquiry' ); ?>
                            </h2>
                            <p class="mt-1 text-sm text-slate-600">
                                <?php echo esc_html__( 'Настройте показ кнопки и поведение модального окна для товаров без цены.', 'woodmart-price-inquiry' ); ?>
                            </p>
                        </div>
                    </div>

                    <section class="rounded-xl border border-slate-200 bg-white p-5">
                        <h3 class="text-sm font-semibold text-slate-900">
                            <?php echo esc_html__( 'Показать кнопку запроса цены', 'woodmart-price-inquiry' ); ?>
                        </h3>

                        <div class="mt-4 flex items-center justify-between gap-4">
                            <div>
                                <p class="text-sm text-slate-700">
                                    <?php echo esc_html__( 'Включить', 'woodmart-price-inquiry' ); ?>
                                </p>
                                <p class="mt-1 text-xs text-slate-500">
                                    <?php echo esc_html__( 'Если выключено — кнопка не будет отображаться.', 'woodmart-price-inquiry' ); ?>
                                </p>
                            </div>

                            <label class="relative inline-flex cursor-pointer items-center">
                                <input type="checkbox" class="peer sr-only" checked>
                                <span class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-blue-600"></span>
                                <span class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition peer-checked:translate-x-5"></span>
                            </label>
                        </div>
                    </section>

                    <div id="wpi-general-dependent" class="space-y-6">
                        <section class="rounded-xl border border-slate-200 bg-white p-5">
                            <h3 class="text-sm font-semibold text-slate-900">
                                <?php echo esc_html__( 'Условие', 'woodmart-price-inquiry' ); ?>
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                <?php echo esc_html__( 'Определяет, когда показывать кнопку на странице товара.', 'woodmart-price-inquiry' ); ?>
                            </p>

                            <div class="mt-4 space-y-3">
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                                    <input type="radio" name="wpi_price_missing_rule" class="mt-1" value="empty" checked>
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Цена товара не указана', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Кнопка показывается, если у товара нет значения цены.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                                    <input type="radio" name="wpi_price_missing_rule" class="mt-1" value="empty_or_zero">
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Цена пустая или равна 0', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Подходит, если на сайте используются "нулевые" цены вместо пустых.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>
                            </div>
                        </section>

                        <!-- Section: Button text -->
                        <section class="rounded-xl border border-slate-200 bg-white p-5">
                            <h3 class="text-sm font-semibold text-slate-900">
                                <?php echo esc_html__( 'Текст кнопки', 'woodmart-price-inquiry' ); ?>
                            </h3>

                            <div class="mt-4">
                                <label class="block text-xs font-medium text-slate-600" for="price-inquiry-button">
                                    <?php echo esc_html__( 'Надпись на кнопке', 'woodmart-price-inquiry' ); ?>
                                </label>
                                <input
                                        type="text"
                                        id="price-inquiry-button"
                                        class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        value="<?php echo esc_attr__( 'Запросить цену', 'woodmart-price-inquiry' ); ?>"
                                >
                                <p class="mt-2 text-xs text-slate-500">
                                    <?php echo esc_html__( 'Можно переопределить в шорткоде  [price-inquiry text="button text"].', 'woodmart-price-inquiry' ); ?>
                                </p>
                            </div>
                        </section>

                        <!-- Section: Display mode -->
                        <section class="rounded-xl border border-slate-200 bg-white p-5">
                            <h3 class="text-sm font-semibold text-slate-900">
                                <?php echo esc_html__( 'Где показывать кнопку', 'woodmart-price-inquiry' ); ?>
                            </h3>
                            <p class="mt-1 text-xs text-slate-500">
                                <?php echo esc_html__( 'Выберите режим вывода: только шорткод или автоподстановка на странице товара.', 'woodmart-price-inquiry' ); ?>
                            </p>

                            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                                    <input type="radio" name="wpi_display_mode" class="mt-1" value="shortcode" checked>
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Только шорткод', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Вы сами размещаете кнопку в шаблоне/описании.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                                    <input type="radio" name="wpi_display_mode" class="mt-1" value="auto">
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Автоматически', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Кнопка добавляется на странице товара автоматически.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                                    <input type="radio" name="wpi_display_mode" class="mt-1" value="both">
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'И то, и другое', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Авто + возможность вставить шорткодом.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>
                            </div>

                            <!-- Auto placement (shown/hidden by JS later) -->
                            <div id="wpi-auto-placement" class="mt-5 hidden rounded-lg border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs font-medium text-slate-700">
                                    <?php echo esc_html__( 'Позиция на странице товара', 'woodmart-price-inquiry' ); ?>
                                </p>

                                <div class="mt-3">
                                    <label for="wpi-auto-placement-select">
                                        <select
                                                id="wpi-auto-placement-select"
                                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                            <option value="replace_price"><?php echo esc_html__( 'Вместо цены', 'woodmart-price-inquiry' ); ?></option>
                                            <option value="after_price"><?php echo esc_html__( 'После цены', 'woodmart-price-inquiry' ); ?></option>
                                            <option value="after_cart"><?php echo esc_html__( 'После кнопки "В корзину"', 'woodmart-price-inquiry' ); ?></option>
                                            <option value="after_excerpt"><?php echo esc_html__( 'После краткого описания', 'woodmart-price-inquiry' ); ?></option>
                                        </select>
                                    </label>
                                    <p class="mt-2 text-xs text-slate-500">
                                        <?php echo esc_html__( 'Позже привяжем к конкретным хукам WooCommerce/Woodmart.', 'woodmart-price-inquiry' ); ?>
                                    </p>
                                </div>
                            </div>
                        </section>

                        <!-- Section: Modal behavior -->
                        <section class="rounded-xl border border-slate-200 bg-white p-5">
                            <h3 class="text-sm font-semibold text-slate-900">
                                <?php echo esc_html__( 'Модальное окно', 'woodmart-price-inquiry' ); ?>
                            </h3>

                            <div class="mt-4 space-y-4">
                                <label class="flex cursor-pointer items-start gap-3">
                                    <input type="checkbox" class="mt-1" checked>
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Автозакрытие после успешной отправки', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Актуально для CF7 (по событию успешной отправки).', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>

                                <label class="flex cursor-pointer items-start gap-3">
                                    <input type="checkbox" class="mt-1" checked>
                                    <span>
							<span class="block text-sm font-medium text-slate-900">
								<?php echo esc_html__( 'Разрешить закрытие по клику вне окна и ESC', 'woodmart-price-inquiry' ); ?>
							</span>
							<span class="block text-xs text-slate-500">
								<?php echo esc_html__( 'Рекомендуется для удобства, особенно на мобильных.', 'woodmart-price-inquiry' ); ?>
							</span>
						</span>
                                </label>
                            </div>
                        </section>
                    </div>

                    <!-- Footer actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            <?php echo esc_html__( 'Сбросить', 'woodmart-price-inquiry' ); ?>
                        </button>
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                            <?php echo esc_html__( 'Сохранить', 'woodmart-price-inquiry' ); ?>
                        </button>
                    </div>
                </form>

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
