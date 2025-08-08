<?php
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Post Types
 */
function volleyball_program_post_type_int() {
	
	$program_labels = array(
		'name'                  => _x( 'Program Types', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Program Type', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Program Types', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Program Type', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Program Type', 'zielkeDesign' ),
		'new_item'              => __( 'New Program Type', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Program Type', 'zielkeDesign' ),
		'view_item'             => __( 'View Program Type', 'zielkeDesign' ),
		'all_items'             => __( 'All Program Types', 'zielkeDesign' ),
		'search_items'          => __( 'Search Program Types', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Program Types:', 'zielkeDesign' ),
		'not_found'             => __( 'No Program Types found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Program Types found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Program Type Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Program Types archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Program Type', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Program Type', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Program Types list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Program Types list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Program Types list', 'zielkeDesign' ),
	);
	$program_args = array(
		'labels'             => $program_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'program',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-networking',
		'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'program', $program_args );
	
}
add_action( 'init', 'volleyball_program_post_type_int' );

/**
 * Hide menu from non-admins
 */
function hide_program_menu() {
    if (!current_user_can('administrator') || (is_multisite() && !is_main_site())) {
        remove_menu_page('edit.php?post_type=program');
    }
}
add_action('admin_menu', 'hide_program_menu');


/**
 * Meta Boxes
 */
function volleyball_admin_program_add_meta_boxes() {
	add_meta_box(
		'program-details',
		'Details',
		'program_details',
		'program',
		'normal'
	);
	add_meta_box(
		'program-header',
		'Header',
		'program_header',
		'program',
		'advanced',
		'high'
	);
	add_meta_box(
		'program-description',
		'Description',
		'program_description',
		'program',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'volleyball_admin_program_add_meta_boxes' );

function program_details( $post ) {
	include( 'views/program_details.php' );
}
function program_header( $post ) {
	include( 'views/program_header.php' );
}
function program_description( $post ) {
	include( 'views/program_description.php' );
}

/**
 * Move advanced meta boxes above the default editor
 */
function volleyball_admin_program_move_meta_boxes() {
	remove_meta_box( 'program-header', 'program', 'advanced' );
	add_meta_box( 'program-header', 'Header', 'program_header', 'program', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'volleyball_admin_program_move_meta_boxes', 999 );


/**
 * Save Meta Boxes
 */
function volleyball_admin_program_save_meta_boxes( $post_id ) {
    // Check if our nonce is set.
    if (!isset($_POST['volleyball_network_admin_program_nonce'])) {
        return;
    }

    // Verify that the nonce is valid.
    if (!wp_verify_nonce($_POST['volleyball_network_admin_program_nonce'], 'volleyball_network_admin_program_nonce')) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check the user's permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

	// Save meta data
	if ( isset( $_REQUEST['program_sub_header'] ) ) {
		update_post_meta( $post_id, 'program_sub_header', sanitize_text_field(htmlentities($_REQUEST['program_sub_header'])));
	}

	if ( isset( $_REQUEST['program_ages'] ) ) {
		update_post_meta( $post_id, 'program_ages', sanitize_text_field(htmlentities($_REQUEST['program_ages'])));
	}

    if (isset($_POST['program_excerpt'])) {
		update_post_meta($post_id, 'program_excerpt', wp_kses_post($_POST['program_excerpt']));
    }

    if (isset($_POST['program_program_info'])) {
        update_post_meta($post_id, 'program_program_info', wp_kses_post($_POST['program_program_info']));
    }

    if (isset($_POST['program_format_info'])) {
        update_post_meta($post_id, 'program_format_info', wp_kses_post($_POST['program_format_info']));
    }

    if (isset($_POST['program_expectation_info'])) {
        update_post_meta($post_id, 'program_expectation_info', wp_kses_post($_POST['program_expectation_info']));
    }

    if (isset($_POST['program_description'])) {
        update_post_meta($post_id, 'program_description', wp_kses_post($_POST['program_description']));
    }
}
add_action( 'save_post', 'volleyball_admin_program_save_meta_boxes' );