<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       MYWPDev.com
 * @since      1.0.0
 *
 * @package    Simple_Dashboard_Theme
 * @subpackage Simple_Dashboard_Theme/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Simple_Dashboard_Theme
 * @subpackage Simple_Dashboard_Theme/admin
 * @author     MYWPDev <info@MYWPDev.com>
 */
class Simple_Dashboard_Theme_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Dashboard_Theme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Dashboard_Theme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/min/style.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simple_Dashboard_Theme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simple_Dashboard_Theme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/min/scripts.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Remove admin bar icons.
	 *
	 * @since    1.0.0
	 */
	public function remove_wp_admin_bar_icons( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );      // remove the logo
		$wp_admin_bar->remove_node( 'comments' );     // remove the comments
		$wp_admin_bar->remove_node( 'new-content' );  // remove add new content
	}

	/**
	 * Remove footer information.
	 *
	 * @since    1.0.0
	 */
	public function remove_footer_notifications() {
		add_filter( 'admin_footer_text', '__return_false', 11 );
	}

	/**
	 * Remove the help tabs.
	 *
	 * @since    1.0.0
	 */
	public function remove_help_tab( $old_help, $screen_id, $screen ) {
		$screen->remove_help_tabs();

		return $old_help;
	}

	/**
	 * Custom login page styling.
	 *
	 * @since    1.0.0
	 */
	public function login_styling() {
		?>
		<style type="text/css">
			body.login div#login h1 a {
				display: none !important;
			}
			.wp-core-ui .button-primary,
			.wp-core-ui .button-primary.focus, 
			.wp-core-ui .button-primary.hover, 
			.wp-core-ui .button-primary:focus, 
			.wp-core-ui .button-primary:hover {
				background: #010101 !important;
				border-color: #010101 !important;
			}
			.login #login_error, .login .message, .login .success {
				border-left: 4px solid #010101 !important;
			}
		</style>
		<?php
	}

	/**
	 * Remove default dashboard widgets.
	 *
	 * @since    1.0.0
	 */
	public function remove_dashboard_widgets() {
		global $wp_meta_boxes;

		/*
		//TODO allow disabling of these through options page
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['wpseo-dashboard-overview'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );

		// also remove the welcome panel
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

		//Remove the Yoast SEO widget
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );*/
	}

	/**
	 * Add extra links to plugins page
	 * @since 1.0.4
	 *
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	*/
	public function add_extra_links( $actions, $plugin_file ) {
		if ( 'null' !== SIMPLE_DASHBOARD_THEME_PLUGIN_NAME ) {
			if ( SIMPLE_DASHBOARD_THEME_PLUGIN_NAME == $plugin_file ) {
				// set a link to the settings page
				$settings = array( 'settings' => '<a href="https://help.mywpdev.com/" target="_blank">' . __( 'Help Centre', '' ) . '</a>' );
				$actions  = array_merge( $settings, $actions );

			}
		}

		return $actions;
	}

}
