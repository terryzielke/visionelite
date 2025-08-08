<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              MYWPDev.com
 * @since             1.0.0
 * @package           Simple_Dashboard_Theme
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Dashboard Theme
 * Plugin URI:        https://mywpdev.com/project/simple-dashboard-theme
 * Description:       A beautiful, simple and modern dashboard theme for WordPress.
 * Version:           1.0.6
 * Author:            MYWPDev
 * Author URI:        MYWPDev.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-dashboard-theme
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'SIMPLE_DASHBOARD_THEME_VERSION', '1.0.6' );
define( 'SIMPLE_DASHBOARD_THEME_PLUGIN_NAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-dashboard-theme-activator.php
 */
function activate_simple_dashboard_theme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-dashboard-theme-activator.php';
	Simple_Dashboard_Theme_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-dashboard-theme-deactivator.php
 */
function deactivate_simple_dashboard_theme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-dashboard-theme-deactivator.php';
	Simple_Dashboard_Theme_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_dashboard_theme' );
register_deactivation_hook( __FILE__, 'deactivate_simple_dashboard_theme' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-dashboard-theme.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_dashboard_theme() {

	$plugin = new Simple_Dashboard_Theme();
	$plugin->run();

}
run_simple_dashboard_theme();
