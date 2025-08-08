<?php
if ( ! defined( 'WPINC' ) ) { die; }

/**
 * Post Types
 */
function volleyball_activity_post_type_int() {
	
	$activity_labels = array(
		'name'                  => _x( 'Sports', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Sport', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Sports', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Sport', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Sport', 'zielkeDesign' ),
		'new_item'              => __( 'New Sport', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Sport', 'zielkeDesign' ),
		'view_item'             => __( 'View Sport', 'zielkeDesign' ),
		'all_items'             => __( 'All Sports', 'zielkeDesign' ),
		'search_items'          => __( 'Search Sports', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Sports:', 'zielkeDesign' ),
		'not_found'             => __( 'No Sports found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Sports found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Sport Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Sports archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Sport', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Sport', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Sports list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Sports list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Sports list', 'zielkeDesign' ),
	);
	$activity_args = array(
		'labels'             => $activity_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'activity',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-universal-access-alt',
		'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'activity', $activity_args );
	
}
add_action( 'init', 'volleyball_activity_post_type_int' );

/**
 * Hide menu from non-admins
 */
function hide_activity_menu() {
    if (!current_user_can('administrator') || (is_multisite() && !is_main_site())) {
        remove_menu_page('edit.php?post_type=activity');
    }
}
add_action('admin_menu', 'hide_activity_menu');