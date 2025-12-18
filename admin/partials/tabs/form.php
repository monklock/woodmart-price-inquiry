<?php
/**
 * Form tab.
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

$form_provider = isset( $settings['form_provider'] ) ? (string) $settings['form_provider'] : 'cf7';
$cf7_form_id   = isset( $settings['cf7_form_id'] ) ? (int) $settings['cf7_form_id'] : 0;

/**
 * Load CF7 forms list (if plugin exists).
 *
 * @return array<int, string>
 */
$get_cf7_forms = static function (): array {
    if ( ! post_type_exists( 'wpcf7_contact_form' ) ) {
        return array();
    }

    $posts = get_posts(
            array(
                    'post_type'      => 'wpcf7_contact_form',
                    'post_status'    => 'publish',
                    'posts_per_page' => 200,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                    'fields'         => 'ids',
            )
    );

    $result = array();
    foreach ( $posts as $post_id ) {
        $title = get_the_title( $post_id );
        $result[ (int) $post_id ] = $title ? $title : '#' . (string) $post_id;
    }

    return $result;
};

$cf7_forms = $get_cf7_forms();

?>
<form method="post" action="options.php" class="space-y-6">
    <?php settings_fields( Woodmart_Price_Inquiry_Admin::SETTINGS_GROUP ); ?>

    <div class="flex items-start justify-between gap-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">
                <?php echo esc_html__( 'Форма', 'woodmart-price-inquiry' ); ?>
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                <?php echo esc_html__( 'Выберите источник формы для модального окна: Contact Form 7 или встроенный конструктор.', 'woodmart-price-inquiry' ); ?>
            </p>
        </div>
    </div>

    <!-- Provider -->
    <section class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'Источник формы', 'woodmart-price-inquiry' ); ?>
        </h3>

        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                <input
                        type="radio"
                        name="<?php echo esc_attr( $field_name( 'form_provider' ) ); ?>"
                        class="mt-1"
                        value="cf7"
                        <?php checked( $form_provider, 'cf7' ); ?>
                >
                <span>
					<span class="block text-sm font-medium text-slate-900"><?php echo esc_html__( 'Contact Form 7', 'woodmart-price-inquiry' ); ?></span>
					<span class="block text-xs text-slate-500"><?php echo esc_html__( 'Используем шорткод формы CF7 внутри модального окна.', 'woodmart-price-inquiry' ); ?></span>
				</span>
            </label>

            <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 p-3 hover:bg-slate-50">
                <input
                        type="radio"
                        name="<?php echo esc_attr( $field_name( 'form_provider' ) ); ?>"
                        class="mt-1"
                        value="custom"
                        <?php checked( $form_provider, 'custom' ); ?>
                >
                <span>
					<span class="block text-sm font-medium text-slate-900"><?php echo esc_html__( 'Встроенная форма', 'woodmart-price-inquiry' ); ?></span>
					<span class="block text-xs text-slate-500"><?php echo esc_html__( 'Свой конструктор полей (сохраняем и валидируем сами).', 'woodmart-price-inquiry' ); ?></span>
				</span>
            </label>
        </div>
    </section>

    <!-- CF7 settings -->
    <section id="wpi-form-cf7" class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'Настройки CF7', 'woodmart-price-inquiry' ); ?>
        </h3>

        <?php if ( empty( $cf7_forms ) ) : ?>
            <p class="mt-3 text-sm text-slate-600">
                <?php echo esc_html__( 'Формы CF7 не найдены. Убедитесь, что Contact Form 7 установлен и что есть хотя бы одна форма.', 'woodmart-price-inquiry' ); ?>
            </p>
        <?php else : ?>
            <div class="mt-4">
                <label class="block text-xs font-medium text-slate-600" for="wpi_cf7_form_id">
                    <?php echo esc_html__( 'Выберите форму', 'woodmart-price-inquiry' ); ?>
                </label>

                <select
                        id="wpi_cf7_form_id"
                        name="<?php echo esc_attr( $field_name( 'cf7_form_id' ) ); ?>"
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >
                    <option value="0"><?php echo esc_html__( '— Не выбрано —', 'woodmart-price-inquiry' ); ?></option>
                    <?php foreach ( $cf7_forms as $id => $title ) : ?>
                        <option value="<?php echo esc_attr( (string) $id ); ?>" <?php selected( $cf7_form_id, (int) $id ); ?>>
                            <?php echo esc_html( $title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <p class="mt-2 text-xs text-slate-500">
                    <?php echo esc_html__( 'Дальше мы подключим шорткод формы в модальное окно и добавим обработку успешной отправки.', 'woodmart-price-inquiry' ); ?>
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Custom settings (stub) -->
    <section id="wpi-form-custom" class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'Встроенная форма', 'woodmart-price-inquiry' ); ?>
        </h3>

        <p class="mt-3 text-sm text-slate-600">
            <?php echo esc_html__( 'Заглушка: здесь появится конструктор полей (имя/телефон/email/сообщение), правила обязательности и тексты ошибок.', 'woodmart-price-inquiry' ); ?>
        </p>

        <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-medium text-slate-700"><?php echo esc_html__( 'План для этой вкладки', 'woodmart-price-inquiry' ); ?></p>
            <ul class="mt-2 list-disc pl-5 text-xs text-slate-600 space-y-1">
                <li><?php echo esc_html__( 'Список полей + порядок + required', 'woodmart-price-inquiry' ); ?></li>
                <li><?php echo esc_html__( 'Тексты ошибок и success-сообщение', 'woodmart-price-inquiry' ); ?></li>
                <li><?php echo esc_html__( 'Отправка AJAX и выбор транспорта (wp_mail / SMTP)', 'woodmart-price-inquiry' ); ?></li>
            </ul>
        </div>
    </section>

    <div class="flex items-center justify-end gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            <?php echo esc_html__( 'Save', 'woodmart-price-inquiry' ); ?>
        </button>
    </div>
</form>
