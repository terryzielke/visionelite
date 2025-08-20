<?php
// ABORT, If this file is called directly
if ( ! defined( 'WPINC' ) ) { die; }


// include Mulitisite functions file located in the same theme directory
include_once( get_template_directory() . '/admin/pages/site/multisite-functions.php' );
// include singlesite functions file located in the same theme directory
//include_once( get_template_directory() . '/admin/pages/site/singlesite-functions.php' );


// if current user is not admin or is multisite and not the main site, remove dashboard menu items
function remove_dashboard_menu_items() {
    if ( ! current_user_can( 'administrator' ) ) {
        remove_menu_page( 'options-general.php' ); // Settings
        remove_menu_page( 'index.php' ); // Dashboard
        remove_menu_page( 'edit.php' ); // Posts
        remove_menu_page( 'upload.php' ); // Media
        remove_menu_page( 'edit.php?post_type=page' ); // Pages
        remove_menu_page( 'edit-comments.php' ); // Comments
        remove_menu_page( 'themes.php' ); // Appearance
        remove_menu_page( 'plugins.php' ); // Plugins
        remove_menu_page( 'users.php' ); // Users
        remove_menu_page( 'tools.php' ); // Tools
        //remove_menu_page( 'profile.php' ); // Profile
        // Remove main Yoast SEO menu
        remove_menu_page('wpseo_dashboard');
        remove_menu_page('wpseo_workouts');
        remove_menu_page('toplevel_page_wpseo_workouts');
        // Remove submenu items individually (just in case)
        remove_submenu_page('wpseo_dashboard', 'wpseo_dashboard');
        remove_submenu_page('wpseo_dashboard', 'wpseo_titles');
        remove_submenu_page('wpseo_dashboard', 'wpseo_social');
        remove_submenu_page('wpseo_dashboard', 'wpseo_search_appearance');
        remove_submenu_page('wpseo_dashboard', 'wpseo_tools');
        remove_submenu_page('wpseo_dashboard', 'wpseo_redirects'); // if premium
        remove_submenu_page('wpseo_dashboard', 'wpseo_licenses'); // if premium

        if(is_multisite() && ! is_main_site()){
            // move items here to make them visible on the main site
        }
    }
}
add_action( 'admin_menu', 'remove_dashboard_menu_items' );


// remove elements from frontend wordpress admin bar
function remove_admin_bar_elements() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu( 'wp-logo' ); // WordPress logo
        $wp_admin_bar->remove_menu( 'updates' ); // Updates
        $wp_admin_bar->remove_menu( 'comments' ); // Comments
        $wp_admin_bar->remove_menu( 'new-content' ); // New content
        $wp_admin_bar->remove_menu( 'my-account' ); // My account
        $wp_admin_bar->remove_menu( 'customize' ); // Customize
        $wp_admin_bar->remove_menu( 'search' ); // Search
        $wp_admin_bar->remove_node('wpseo-menu'); // Yoast SEO menu
        if ( ! current_user_can( 'administrator' ) && is_multisite() ) {
            // remove My Sites menu for non-admin users in multisite
            //$wp_admin_bar->remove_menu( 'my-sites' ); // My Sites
        }
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_elements' );


// remove screen options and help tabs from admin pages
function remove_screen_options_and_help() {
    // Remove screen options tab
    if ( is_admin() ) {
        echo '<style type="text/css">#screen-options-link-wrap, .help-tab { display: none !important; } #wp-admin-bar-user-logout { float: right !important; } </style>';
    }
}
add_action( 'admin_head', 'remove_screen_options_and_help' );


// remove dashboard widgets for non-admin users
function remove_dashboard_widgets() {
    if ( ! current_user_can( 'administrator' ) ) {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // Activity
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // At a Glance
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); // WordPress News
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // Quick Draft
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' ); // Recent Comments
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' ); // Plugins
        remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // Yoast SEO Dashboard
    }
}
add_action( 'wp_dashboard_setup', 'remove_dashboard_widgets' );


// add custom logout link to admin bar
function add_custom_logout_link() {
    global $wp_admin_bar;
    if ( is_user_logged_in() ) {
        $wp_admin_bar->add_menu( array(
            'id'    => 'user-logout',
            'title' => 'Logout',
            'href'  => wp_logout_url(),
            'meta'  => array( 'class' => 'user-logout-link' )
        ) );
    }
}
add_action( 'admin_bar_menu', 'add_custom_logout_link', 100 );


// Disable application passwords for all users
add_filter( 'wp_is_application_passwords_available', '__return_false' );
function custom_hide_profile_sections() {
    $screen = get_current_screen();
    if ( $screen->base === 'profile' || $screen->base === 'user-edit' ) {
        ?>
        <style>
            #your-profile h2:contains("Personal Options"),
            #your-profile h2:contains("About Yourself"),
            #application-passwords-section{
                display: none !important;
            }

            #your-profile h2:contains("Personal Options") ~ *:nth-of-type(-n+4),
            #your-profile h2:contains("About Yourself") ~ *:nth-of-type(-n+3) {
                display: none !important;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                // Hide "Personal Options" section
                $('#your-profile h2:contains("Personal Options")').nextUntil('h2').hide().prev().hide();

                // Hide "About Yourself"
                $('#your-profile h2:contains("About Yourself")').nextUntil('h2').hide().prev().hide();

                // Hide "Application Passwords"
                $('#application-passwords-section').hide();
            });
        </script>
        <?php
    }
}
add_action('admin_head', 'custom_hide_profile_sections');
