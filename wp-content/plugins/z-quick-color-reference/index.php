<?php
/*
Plugin Name: Quick Colors Reference
Plugin URI: http://zielke.design/
Description: Adds a dropdown to the admin top bar where you can quickly click to copy your brand colors.
Version: 1.0.1
Author: Terry Zielke
Author URI: https://zielke.design
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zqcr
*/

/*
	ABORT
	
	If this file is called directly, abort.
*/
if ( ! defined( 'WPINC' ) ) { die; }

/*
	ACTIVATION
	
	Runs when plugin is activated.
*/
function zqcr_activate_plugin() {
	// Do Nothing
}
register_activation_hook(__FILE__,'zqcr_activate_plugin'); 

/*
	DEACTIVATE
	
	Runs when plugin is deactivated.
*/
function zqcr_deactivate_plugin() {
	// Do Nothing
}
register_deactivation_hook( __FILE__, 'zqcr_deactivate_plugin' );

function zqcr_uninstall_plugin(){
	// Do Nothing
}
register_uninstall_hook(__FILE__, 'zqcr_uninstall_plugin');


/*
	DASHBOARD PAGES
*/
function zqcr_register_dashboard_pages(){
  add_submenu_page(
    'options-general.php', // parent slug
    'Quick Colors', // page title
    'Quick Colors', // menu title
    'edit_posts', // required capabilities
    'zqcr', // page slug
    'display_zqcr_main_page' // callback function to display page content
  );
}
add_action( 'admin_menu', 'zqcr_register_dashboard_pages' );

function display_zqcr_main_page(){
    include('admin/pages/main.php'); 
}


/*
	SETTINGS
*/
function zqcr_color_settings() {
	register_setting( 'zqcr_settings', 'zqcr_color_name_one' );
	register_setting( 'zqcr_settings', 'zqcr_color_code_one' );
	register_setting( 'zqcr_settings', 'zqcr_color_name_two' );
	register_setting( 'zqcr_settings', 'zqcr_color_code_two' );
	register_setting( 'zqcr_settings', 'zqcr_color_name_three' );
	register_setting( 'zqcr_settings', 'zqcr_color_code_three' );
	register_setting( 'zqcr_settings', 'zqcr_color_name_four' );
	register_setting( 'zqcr_settings', 'zqcr_color_code_four' );
	register_setting( 'zqcr_settings', 'zqcr_color_name_five' );
	register_setting( 'zqcr_settings', 'zqcr_color_code_five' );
}
add_action( 'admin_init', 'zqcr_color_settings' );


/*
	ADMINI BAR MENU
*/
function add_xn_admin_bar() {
	
	// get colors
	$zqcr_color_name_one = esc_attr( get_option('zqcr_color_name_one'));
	$zqcr_color_code_one = esc_attr( get_option('zqcr_color_code_one'));
	$zqcr_color_name_two = esc_attr( get_option('zqcr_color_name_two'));
	$zqcr_color_code_two = esc_attr( get_option('zqcr_color_code_two'));
	$zqcr_color_name_three = esc_attr( get_option('zqcr_color_name_three'));
	$zqcr_color_code_three = esc_attr( get_option('zqcr_color_code_three'));
	$zqcr_color_name_four = esc_attr( get_option('zqcr_color_name_four'));
	$zqcr_color_code_four = esc_attr( get_option('zqcr_color_code_four'));
	$zqcr_color_name_five = esc_attr( get_option('zqcr_color_name_five'));
	$zqcr_color_code_five = esc_attr( get_option('zqcr_color_code_five'));

	global $wp_admin_bar;
	
	$wp_admin_bar->add_menu( array(
		'id' => 'zqcr_dropdown',
		'title' => __( 'Quick Colors')
	) );

	$wp_admin_bar->add_menu( array(
		'parent' => 'zqcr_dropdown',
		'id' => 'zqcr_one',
		'title' => $zqcr_color_name_one,
		'href' => $zqcr_color_code_one,
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'zqcr_dropdown',
		'id' => 'zqcr_two',
		'title' => $zqcr_color_name_two,
		'href' => $zqcr_color_code_two,
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'zqcr_dropdown',
		'id' => 'zqcr_three',
		'title' => $zqcr_color_name_three,
		'href' => $zqcr_color_code_three,
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'zqcr_dropdown',
		'id' => 'zqcr_four',
		'title' => $zqcr_color_name_four,
		'href' => $zqcr_color_code_four,
	));
	$wp_admin_bar->add_menu( array(
		'parent' => 'zqcr_dropdown',
		'id' => 'zqcr_five',
		'title' => $zqcr_color_name_five,
		'href' => $zqcr_color_code_five,
	));

}
add_action('admin_bar_menu', 'add_xn_admin_bar',100);


/*
	ENGUEUE SCRIPTS
*/
function zqcr_frontend_scripts() {
	// CSS
	wp_enqueue_style( 'zqcr_styles',	plugin_dir_url( __FILE__ ) . 'css/zqcr_admin.css');
	// JS
	wp_enqueue_script( 'zqcr_scripts', plugin_dir_url( __FILE__ ) . 'js/zqcr_scripts.js', array('jquery'), 'all' );
}
add_action( 'wp_enqueue_scripts', 'zqcr_frontend_scripts' );

function zqcr_backend_scripts() {
	// CSS
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'zqcr_admin_css',	plugin_dir_url( __FILE__ ) . 'css/zqcr_admin.css');
	// JS
	wp_enqueue_script( 'zqcr_admin_js', plugin_dir_url( __FILE__ ) . 'js/zqcr_admin.js', array('jquery', 'wp-color-picker' ), 'all' );
}
add_action( 'admin_enqueue_scripts', 'zqcr_backend_scripts' );