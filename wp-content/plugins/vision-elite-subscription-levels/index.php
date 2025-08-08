<?php
/*
Plugin Name: Vision Elite Subscription Levels
Plugin URI: http://zielke.design/
Description: Manage a chart of subscription levels and their features.
Version: 1.0.0
Author: Terry Zielke
Author URI: https://zielke.design
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zielke
*/

// Abort if this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }


// Enqueue frontend scripts and styles.
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 've--subscription-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css', [], '1.0.0' );
    wp_enqueue_script( 've-subscription-scripts-js', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [ 'jquery' ], '1.0.0', true );
} );


// Add Subcscription Leven post Type
add_action( 'init', function() {
    $labels = [
        'name'               => _x( 'Subscription Levels', 'post type general name', 'zielke' ),
        'singular_name'      => _x( 'Subscription Level', 'post type singular name', 'zielke' ),
        'menu_name'          => _x( 'Subscription Levels', 'admin menu', 'zielke' ),
        'name_admin_bar'       => _x( 'Subscription Level', 'add new on admin bar', 'zielke' ),
        'add_new'            => _x( 'Add New', 'subscription level', 'zielke' ),
        'add_new_item'       => __( 'Add New Subscription Level', 'zielke' ),
        'new_item'           => __( 'New Subscription Level', 'zielke' ),
        'edit_item'          => __( 'Edit Subscription Level', 'zielke' ),
        'view_item'          => __( 'View Subscription Level', 'zielke' ),
        'all_items'          => __( 'All Subscription Levels', 'zielke' ),
        'search_items'       => __( 'Search Subscription Levels', 'zielke' ),
        'parent_item_colon'  => __( 'Parent Subscription Levels:', 'zielke' ),
        'not_found'          => __( 'No subscription levels found.', 'zielke' ),
        'not_found_in_trash' => __( 'No subscription levels found in Trash.', 'zielke' ),
    ];
    $args = [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'subscription-levels' ],
        'capability_type'    => 'page',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 50,
		'menu_icon'          => 'dashicons-chart-line',
        'supports'           => [ 'title', 'editor', 'page-attributes' ],
    ];
    register_post_type( 'subscription_levels', $args );
} );


// Add meta boxes for Subscription Levels
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'subscription_levels_features',
        __( 'Subscription Level Features', 'zielke' ),
        'display_subscription_levels_features_meta_box',
        'subscription_levels',
        'normal',
        'high'
    );
} );
function display_subscription_levels_features_meta_box( $post ) {
    include(plugin_dir_path(__FILE__) . 'views/features.php');
}


// Save Subscription Level features
add_action( 'save_post', function( $post_id ) {
    // Check nonce
    if ( ! isset( $_POST['ve_subscription_levels_meta_nonce'] ) || ! wp_verify_nonce( $_POST['ve_subscription_levels_meta_nonce'], 've_subscription_levels_meta_nonce' ) ) {
        return;
    }
    // Check if this is an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Check user permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    // Save features
    $features = [
        'online_recruit_profile' => isset( $_POST['online_recruit_profile'] ) ? '1' : '0',
        'highlight_film' => sanitize_text_field( $_POST['highlight_film'] ),
        'group_practice_sessions_per_week' => intval( $_POST['group_practice_sessions_per_week'] ),
        'recoreded_sessions_per_month' => intval( $_POST['recoreded_sessions_per_month'] ),
        's_and_c_programming' => isset( $_POST['s_and_c_programming'] ) ? '1' : '0',
        'monthly_group_meetings' => isset( $_POST['monthly_group_meetings'] ) ? '1' : '0',
        'monthly_team_sessions' => isset( $_POST['monthly_team_sessions'] ) ? '1' : '0',
        'monthly_s_and_c_sessions' => isset( $_POST['monthly_s_and_c_sessions'] ) ? '1' : '0',
        'bi_weekly_position_small_group_film_sessions' => isset( $_POST['bi_weekly_position_small_group_film_sessions'] ) ? '1' : '0',
        'monthly_position_group_film_sessions' => isset( $_POST['monthly_position_group_film_sessions'] ) ? '1' : '0',
        'one_and_one_sport_psychologist_meeting' => isset( $_POST['one_and_one_sport_psychologist_meeting'] ) ? '1' : '0',
        'professional_one_hour_video_film_sessions' => isset( $_POST['professional_one_hour_video_film_sessions'] ) ? '1' : '0',
        'one_hour_consultation_with_recruiting_coach' => isset( $_POST['one_hour_consultation_with_recruiting_coach'] ) ? '1' : '0',
    ];
    foreach ( $features as $key => $value ) {
        update_post_meta( $post_id, $key, $value );
    }
} );


// Add a shortcode to display subscription levels
include(plugin_dir_path(__FILE__) . 'shortcodes/subscription_levels_shortcode.php');