<?php

// AJAX ACTION
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


add_action('wp_ajax_add_new_venue', 'handle_add_new_venue');
function handle_add_new_venue() {
    // Check nonce
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'admin_inline_add_venue_ajax_nonce')) {
        wp_send_json_error('Nonce verification failed.');
    }
    // Check user capability
    if (!current_user_can('edit_posts')) {
        wp_send_json_error('Permission denied.');
    }

    // Sanitize input
    $venue_name       = sanitize_text_field($_POST['venue_name'] ?? '');
    $venue_address    = sanitize_text_field($_POST['venue_address'] ?? '');
    $venue_city       = sanitize_text_field($_POST['venue_city'] ?? '');
    $venue_province   = sanitize_text_field($_POST['venue_province'] ?? '');
    $venue_postalcode = sanitize_text_field($_POST['venue_postal_code'] ?? '');

    // Validate
    if (empty($venue_name)) {
        wp_send_json_error('Venue name is required.');
    }

    $post_data = [
        'post_title'   => $venue_name,
        'post_type'    => 'venue',
        'post_status'  => 'publish',
        'post_content' => '',
    ];

    $original_blog_id = get_current_blog_id();

    if (is_multisite()) {
        switch_to_blog(1); // Switch to site 1
    }

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        if (is_multisite()) {
            restore_current_blog();
        }
        wp_send_json_error('Failed to insert post.');
    }

    // Save custom fields
    update_post_meta($post_id, 'venue_address', $venue_address);
    update_post_meta($post_id, 'venue_city', ucwords($venue_city));
    update_post_meta($post_id, 'venue_province', $venue_province);
    update_post_meta($post_id, 'venue_postal_code', $venue_postalcode);

    if (is_multisite()) {
        restore_current_blog(); // Switch back
    }

    wp_send_json_success(['post_id' => $post_id]);
}


?>