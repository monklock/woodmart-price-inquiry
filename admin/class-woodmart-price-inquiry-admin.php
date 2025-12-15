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
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * Option name for all plugin settings.
     *
     * @since 1.0.0
     * @var string
     */
    public const OPTION_NAME = 'wpi_settings';

    /**
     * Settings group for Settings API.
     *
     * @since 1.0.0
     * @var string
     */
    public const SETTINGS_GROUP = 'wpi_settings_group';

    /**
     * Settings page slug.
     *
     * @since 1.0.0
     * @var string
     */
    public const PAGE_SLUG = 'woodmart-price-inquiry';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

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


}
