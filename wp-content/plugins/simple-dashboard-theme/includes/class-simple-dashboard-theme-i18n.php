<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       MYWPDev.com
 * @since      1.0.0
 *
 * @package    Simple_Dashboard_Theme
 * @subpackage Simple_Dashboard_Theme/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Simple_Dashboard_Theme
 * @subpackage Simple_Dashboard_Theme/includes
 * @author     MYWPDev <info@MYWPDev.com>
 */
class Simple_Dashboard_Theme_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'simple-dashboard-theme',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
