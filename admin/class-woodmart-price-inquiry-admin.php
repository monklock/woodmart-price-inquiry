<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://delay-delo.com
 * @since      1.0.0
 *
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/admin
 * @author     Alexey <alex.rtischew@yandex.com>
 */
class Woodmart_Price_Inquiry_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private string $version;

    /**
     * Option name for all plugin settings.
     *
     * @since 1.0.0
     * @var string
     */
    public const string OPTION_NAME = 'wpi_settings';

    /**
     * Settings group for Settings API.
     *
     * @since 1.0.0
     * @var string
     */
    public const string SETTINGS_GROUP = 'wpi_settings_group';

    /**
     * Settings page slug.
     *
     * @since 1.0.0
     * @var string
     */
    public const string PAGE_SLUG = 'woodmart-price-inquiry';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name The name of this plugin.
	 * @param string $version    The version of this plugin.
	 *@since    1.0.0
	 */
	public function __construct(string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

        if ( ! $this->is_plugin_settings_page() ) {
            return;
        }

        wp_enqueue_style(
            $this->plugin_name . '-admin',
            plugin_dir_url( __FILE__ ) . 'css/woodmart-price-inquiry-admin.css',
            array(),
            $this->version,
            'all'
        );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

        if ( ! $this->is_plugin_settings_page() ) {
            return;
        }

        /**
         * Tailwind via CDN (admin-only, plugin page only).
         */
        wp_enqueue_script(
            $this->plugin_name . '-tailwind-cdn',
            'https://cdn.tailwindcss.com',
            array(),
            $this->version,
            true
        );

        wp_enqueue_script(
            $this->plugin_name . '-admin',
            plugin_dir_url( __FILE__ ) . 'js/woodmart-price-inquiry-admin.js',
            array(),
            $this->version,
            true
        );

	}

    /**
     * Register the settings page.
     *
     * @since 1.0.0
     * @return void
     */
    public function add_plugin_admin_menu(): void {
        add_options_page(
            __( 'Price Inquiry button', 'woodmart-price-inquiry' ),
            __( 'Price Inquiry  button', 'woodmart-price-inquiry' ),
            'manage_options',
            'woodmart-price-inquiry',
            array( $this, 'display_plugin_setup_page' )
        );
    }

    /**
     * Render the settings page.
     *
     * @since 1.0.0
     * @return void
     */
    public function display_plugin_setup_page(): void {
        require_once plugin_dir_path( __FILE__ ) . 'partials/woodmart-price-inquiry-admin-display.php';
    }

    /**
     * Detect plugin settings page.
     *
     * @since 1.0.0
     * @return bool
     */
    private function is_plugin_settings_page(): bool {
        if ( ! is_admin() ) {
            return false;
        }

        $page = isset( $_GET['page'] ) ? sanitize_key( (string) $_GET['page'] ) : '';
        return $page === 'woodmart-price-inquiry';
    }

    /**
     * Get active tab key.
     *
     * @since 1.0.0
     * @return string
     */
    public function get_active_tab(): string {
        $tab = isset( $_GET['tab'] ) ? sanitize_key( (string) $_GET['tab'] ) : 'general';

        $allowed = array( 'general', 'form', 'captcha' );
        if ( ! in_array( $tab, $allowed, true ) ) {
            return 'general';
        }

        return $tab;
    }

    /**
     * Build settings page URL with tab.
     *
     * @since 1.0.0
     * @param string $tab Tab key.
     * @return string
     */
    public function get_tab_url( string $tab ): string {
        return add_query_arg(
            array(
                'page' => 'woodmart-price-inquiry',
                'tab'  => $tab,
            ),
            admin_url( 'options-general.php' )
        );
    }

    /**
     * Register settings (storage + sanitize only).
     *
     * @since 1.0.0
     * @return void
     */
    public function register_settings(): void {
        register_setting(
            self::SETTINGS_GROUP,
            self::OPTION_NAME,
            array(
                'type'              => 'array',
                'sanitize_callback' => array( $this, 'sanitize_settings' ),
                'default'           => $this->get_default_settings(),
            )
        );
    }

    /**
     * Sanitize saved settings.
     *
     * @since 1.0.0
     * @param array $input Raw input.
     * @return array
     */
    public function sanitize_settings( array $input ): array {
        $defaults = $this->get_default_settings();
        $output   = $defaults;

        $output['enabled'] = ! empty( $input['enabled'] ) ? 1 : 0;

        $rule = isset( $input['price_missing_rule'] ) ? sanitize_key( (string) $input['price_missing_rule'] ) : $defaults['price_missing_rule'];
        $output['price_missing_rule'] = in_array( $rule, array( 'empty', 'empty_or_zero' ), true ) ? $rule : $defaults['price_missing_rule'];

        $output['button_text'] = isset( $input['button_text'] ) ? sanitize_text_field( (string) $input['button_text'] ) : $defaults['button_text'];

        $mode = isset( $input['display_mode'] ) ? sanitize_key( (string) $input['display_mode'] ) : $defaults['display_mode'];
        $output['display_mode'] = in_array( $mode, array( 'shortcode', 'auto', 'both' ), true ) ? $mode : $defaults['display_mode'];

        $pos = isset( $input['auto_position'] ) ? sanitize_key( (string) $input['auto_position'] ) : $defaults['auto_position'];
        $output['auto_position'] = in_array( $pos, array( 'replace_price', 'after_price', 'after_cart', 'after_excerpt' ), true ) ? $pos : $defaults['auto_position'];

        $output['modal_autoclose']   = ! empty( $input['modal_autoclose'] ) ? 1 : 0;
        $output['modal_allow_close'] = ! empty( $input['modal_allow_close'] ) ? 1 : 0;

        return $output;
    }

    /**
     * Get merged settings (saved + defaults).
     *
     * @since 1.0.0
     * @return array
     */
    public function get_settings(): array {
        $defaults = $this->get_default_settings();
        $saved    = get_option( self::OPTION_NAME, array() );

        return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
    }

    /**
     * Default settings.
     *
     * @since 1.0.0
     * @return array
     */
    public function get_default_settings(): array {
        return array(
            'enabled'            => 1,
            'price_missing_rule' => 'empty',
            'button_text'        => __( 'Запросить цену', 'woodmart-price-inquiry' ),
            'display_mode'       => 'shortcode',
            'auto_position'      => 'replace_price',
            'modal_autoclose'    => 1,
            'modal_allow_close'  => 1,
        );
    }

    /**
     * Handle reset action for settings page.
     *
     * @since 1.0.0
     * @return void
     */
    public function maybe_handle_reset(): void {
        if ( ! is_admin() ) {
            return;
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        $page = isset( $_GET['page'] ) ? sanitize_key( (string) $_GET['page'] ) : '';
        if ( $page !== self::PAGE_SLUG ) {
            return;
        }

        $action = isset( $_POST['wpi_action'] ) ? sanitize_key( (string) $_POST['wpi_action'] ) : '';
        if ( $action !== 'reset_general' ) {
            return;
        }

        /**
         * settings_fields() prints nonce for SETTINGS_GROUP
         * and WordPress verifies it on options.php for option save.
         * For our custom reset action we must verify nonce too.
         */
        check_admin_referer( self::SETTINGS_GROUP . '-options' );

        update_option( self::OPTION_NAME, $this->get_default_settings() );

        wp_safe_redirect(
            add_query_arg(
                array(
                    'page'     => self::PAGE_SLUG,
                    'tab'      => 'general',
                    'wpi_reset' => '1',
                ),
                admin_url( 'options-general.php' )
            )
        );
        exit;
    }

}
