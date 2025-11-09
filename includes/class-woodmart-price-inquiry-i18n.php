<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://delay-delo.com
 * @since      1.0.0
 *
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woodmart_Price_Inquiry
 * @subpackage Woodmart_Price_Inquiry/includes
 * @author     Alexey <alex.rtischew@yandex.com>
 */
class Woodmart_Price_Inquiry_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woodmart-price-inquiry',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
