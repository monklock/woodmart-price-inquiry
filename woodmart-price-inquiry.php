<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://delay-delo.com
 * @since             1.0.0
 * @package           Woodmart_Price_Inquiry
 *
 * @wordpress-plugin
 * Plugin Name:       Woodmart Price Inquiry
 * Plugin URI:        https://github.com/monklock/Woodmart-Price-Inquiry
 * Description:       Adds a “Request Pricing” button to Woodmart product pages with a built-in modal form and email delivery — no theme edits required.
 * Version:           1.0.0
 * Author:            Alexey
 * Author URI:        https://delay-delo.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woodmart-price-inquiry
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOODMART_PRICE_INQUIRY_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woodmart-price-inquiry-activator.php
 */
function activate_woodmart_price_inquiry() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woodmart-price-inquiry-activator.php';
	Woodmart_Price_Inquiry_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woodmart-price-inquiry-deactivator.php
 */
function deactivate_woodmart_price_inquiry() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woodmart-price-inquiry-deactivator.php';
	Woodmart_Price_Inquiry_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woodmart_price_inquiry' );
register_deactivation_hook( __FILE__, 'deactivate_woodmart_price_inquiry' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woodmart-price-inquiry.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woodmart_price_inquiry() {

	$plugin = new Woodmart_Price_Inquiry();
	$plugin->run();

}
run_woodmart_price_inquiry();
