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
$cf7_form_id   = isset( $settings['cf7_form_id'] ) ? absint( $settings['cf7_form_id'] ) : 0;
$base          = isset( $settings['custom_base_fields'] ) && is_array( $settings['custom_base_fields'] ) ? $settings['custom_base_fields'] : array();
$custom_fields = isset( $settings['custom_fields'] ) && is_array( $settings['custom_fields'] ) ? $settings['custom_fields'] : array();


/**
 * @param string $base_key
 * @param string $sub_key
 * @param mixed  $default
 * @return mixed
 */
$base_get = static function ( string $base_key, string $sub_key, $default = '' ) use ( $base ) {
    return isset( $base[ $base_key ][ $sub_key ] ) ? $base[ $base_key ][ $sub_key ] : $default;
};

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
                <?php echo esc_html__( 'Form setting', 'woodmart-price-inquiry' ); ?>
            </h2>
            <p class="mt-1 text-sm text-slate-600">
                <?php echo esc_html__( 'Select the form source for the modal window: Contact Form 7 or the built-in designer.', 'woodmart-price-inquiry' ); ?>
            </p>
        </div>
    </div>

    <section class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'Source of form', 'woodmart-price-inquiry' ); ?>
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
					<span class="block text-xs text-slate-500"><?php echo esc_html__( 'We use the CF7 form shortcode inside the modal window.', 'woodmart-price-inquiry' ); ?></span>
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
					<span class="block text-sm font-medium text-slate-900"><?php echo esc_html__( 'Built-in form', 'woodmart-price-inquiry' ); ?></span>
					<span class="block text-xs text-slate-500"><?php echo esc_html__( 'Custom field constructor (we save and validate them ourselves).', 'woodmart-price-inquiry' ); ?></span>
				</span>
            </label>
        </div>
    </section>

    <!-- CF7 settings -->
    <section id="wpi-form-cf7" class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900">
            <?php echo esc_html__( 'CF7 Settings', 'woodmart-price-inquiry' ); ?>
        </h3>

        <?php if ( empty( $cf7_forms ) ) : ?>
            <p class="mt-3 text-sm text-slate-600">
                <?php echo esc_html__( 'No CF7 forms found. Please ensure Contact Form 7 is installed and that at least one form exists..', 'woodmart-price-inquiry' ); ?>
            </p>
        <?php else : ?>
            <div class="mt-4">
                <label class="block text-xs font-medium text-slate-600" for="wpi_cf7_form_id">
                    <?php echo esc_html__( 'Select a form', 'woodmart-price-inquiry' ); ?>
                </label>

                <select
                        id="wpi_cf7_form_id"
                        name="<?php echo esc_attr( $field_name( 'cf7_form_id' ) ); ?>"
                        class="mt-2 w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                >
                    <option value="0"><?php echo esc_html__( '— Not selected —', 'woodmart-price-inquiry' ); ?></option>
                    <?php foreach ( $cf7_forms as $id => $title ) : ?>
                        <option value="<?php echo esc_attr( (string) $id ); ?>" <?php selected( $cf7_form_id, (int) $id ); ?>>
                            <?php echo esc_html( $title ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <p class="mt-2 text-xs text-slate-500">
                    <?php echo esc_html__( 'In development', 'woodmart-price-inquiry' ); ?>
                </p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Custom settings (stub) -->
    <section id="wpi-form-custom" class="rounded-xl border border-slate-200 bg-white p-5">
        <h3 class="text-sm font-semibold text-slate-900"><?php echo esc_html__( 'Встроенная форма', 'woodmart-price-inquiry' ); ?></h3>
        <p class="mt-1 text-xs text-slate-500"><?php echo esc_html__( 'Настройте базовые поля и добавьте дополнительные input-поля.', 'woodmart-price-inquiry' ); ?></p>

        <!-- Base fields -->
        <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-4">
            <p class="text-xs font-semibold text-slate-700"><?php echo esc_html__( 'Базовые поля', 'woodmart-price-inquiry' ); ?></p>

            <div class="mt-3 space-y-3">
                <?php
                $base_list = array(
                        'name'    => __( 'Имя', 'woodmart-price-inquiry' ),
                        'phone'   => __( 'Телефон', 'woodmart-price-inquiry' ),
                        'email'   => __( 'Email', 'woodmart-price-inquiry' ),
                        'message' => __( 'Сообщение', 'woodmart-price-inquiry' ),
                );

                foreach ( $base_list as $key => $default_label ) :
                    $enabled  = (int) $base_get( $key, 'enabled', 1 );
                    $required = (int) $base_get( $key, 'required', 0 );
                    $label    = (string) $base_get( $key, 'label', $default_label );
                    ?>
                    <div class="grid gap-3 sm:grid-cols-12 sm:items-center rounded-lg border border-slate-200 bg-white p-3">
                        <div class="sm:col-span-3">
                            <p class="text-sm font-medium text-slate-900"><?php echo esc_html( $default_label ); ?></p>
                            <p class="text-xs text-slate-500"><?php echo esc_html( $key ); ?></p>
                        </div>

                        <label class="sm:col-span-2 inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="<?php echo esc_attr( $field_name( 'custom_base_fields' ) . '[' . $key . '][enabled]' ); ?>" value="1" <?php checked( $enabled, 1 ); ?>>
                            <?php echo esc_html__( 'Включено', 'woodmart-price-inquiry' ); ?>
                        </label>

                        <label class="sm:col-span-2 inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="<?php echo esc_attr( $field_name( 'custom_base_fields' ) . '[' . $key . '][required]' ); ?>" value="1" <?php checked( $required, 1 ); ?>>
                            <?php echo esc_html__( 'Обязательное', 'woodmart-price-inquiry' ); ?>
                        </label>

                        <div class="sm:col-span-5">
                            <input
                                    type="text"
                                    name="<?php echo esc_attr( $field_name( 'custom_base_fields' ) . '[' . $key . '][label]' ); ?>"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm text-slate-900 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                                    value="<?php echo esc_attr( $label ); ?>"
                            >
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Custom fields repeater -->
        <div class="mt-5">
            <div class="flex items-center justify-between gap-3">
                <p class="text-xs font-semibold text-slate-700"><?php echo esc_html__( 'Дополнительные поля', 'woodmart-price-inquiry' ); ?></p>
                <button type="button" id="wpi-add-field" class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                    <?php echo esc_html__( 'Добавить поле', 'woodmart-price-inquiry' ); ?>
                </button>
            </div>

            <div id="wpi-fields-list" class="mt-3 space-y-3">
                <?php foreach ( $custom_fields as $i => $row ) : ?>
                    <?php
                    $key         = isset( $row['key'] ) ? (string) $row['key'] : '';
                    $label       = isset( $row['label'] ) ? (string) $row['label'] : '';
                    $required    = ! empty( $row['required'] ) ? 1 : 0;
                    $placeholder = isset( $row['placeholder'] ) ? (string) $row['placeholder'] : '';
                    ?>
                    <div class="wpi-field-row grid gap-3 rounded-lg border border-slate-200 bg-white p-4 sm:grid-cols-12 sm:items-center" data-index="<?php echo esc_attr( (string) $i ); ?>">
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Label', 'woodmart-price-inquiry' ); ?></label>
                            <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                                   name="<?php echo esc_attr( $field_name( 'custom_fields' ) . '[' . $i . '][label]' ); ?>"
                                   value="<?php echo esc_attr( $label ); ?>">
                        </div>

                        <div class="sm:col-span-3">
                            <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Key', 'woodmart-price-inquiry' ); ?></label>
                            <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                                   name="<?php echo esc_attr( $field_name( 'custom_fields' ) . '[' . $i . '][key]' ); ?>"
                                   value="<?php echo esc_attr( $key ); ?>">
                            <p class="mt-1 text-[11px] text-slate-500"><?php echo esc_html__( 'Только латиница/цифры/_. Например: vin', 'woodmart-price-inquiry' ); ?></p>
                        </div>

                        <div class="sm:col-span-4">
                            <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Placeholder', 'woodmart-price-inquiry' ); ?></label>
                            <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                                   name="<?php echo esc_attr( $field_name( 'custom_fields' ) . '[' . $i . '][placeholder]' ); ?>"
                                   value="<?php echo esc_attr( $placeholder ); ?>">
                        </div>

                        <div class="sm:col-span-1">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                                <input type="checkbox"
                                       name="<?php echo esc_attr( $field_name( 'custom_fields' ) . '[' . $i . '][required]' ); ?>"
                                       value="1" <?php checked( $required, 1 ); ?>>
                                <span class="text-xs"><?php echo esc_html__( 'Req', 'woodmart-price-inquiry' ); ?></span>
                            </label>
                            <input type="hidden" name="<?php echo esc_attr( $field_name( 'custom_fields' ) . '[' . $i . '][type]' ); ?>" value="text">
                        </div>

                        <div class="sm:col-span-1 flex justify-end">
                            <button type="button" class="wpi-remove-field rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                <?php echo esc_html__( 'Удалить', 'woodmart-price-inquiry' ); ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <template id="wpi-field-template">
                <div class="wpi-field-row grid gap-3 rounded-lg border border-slate-200 bg-white p-4 sm:grid-cols-12 sm:items-center" data-index="__INDEX__">
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Label', 'woodmart-price-inquiry' ); ?></label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                               name="<?php echo esc_attr( $field_name( 'custom_fields' ) ); ?>[__INDEX__][label]" value="">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Key', 'woodmart-price-inquiry' ); ?></label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                               name="<?php echo esc_attr( $field_name( 'custom_fields' ) ); ?>[__INDEX__][key]" value="">
                        <p class="mt-1 text-[11px] text-slate-500"><?php echo esc_html__( 'Только латиница/цифры/_. Например: vin', 'woodmart-price-inquiry' ); ?></p>
                    </div>

                    <div class="sm:col-span-4">
                        <label class="block text-xs font-medium text-slate-600"><?php echo esc_html__( 'Placeholder', 'woodmart-price-inquiry' ); ?></label>
                        <input type="text" class="mt-2 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm"
                               name="<?php echo esc_attr( $field_name( 'custom_fields' ) ); ?>[__INDEX__][placeholder]" value="">
                    </div>

                    <div class="sm:col-span-1">
                        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
                            <input type="checkbox" name="<?php echo esc_attr( $field_name( 'custom_fields' ) ); ?>[__INDEX__][required]" value="1">
                            <span class="text-xs"><?php echo esc_html__( 'Req', 'woodmart-price-inquiry' ); ?></span>
                        </label>
                        <input type="hidden" name="<?php echo esc_attr( $field_name( 'custom_fields' ) ); ?>[__INDEX__][type]" value="text">
                    </div>

                    <div class="sm:col-span-1 flex justify-end">
                        <button type="button" class="wpi-remove-field rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            <?php echo esc_html__( 'Удалить', 'woodmart-price-inquiry' ); ?>
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </section>

    <div class="flex items-center justify-end gap-3 pt-2">
        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">
            <?php echo esc_html__( 'Save', 'woodmart-price-inquiry' ); ?>
        </button>
    </div>
</form>
