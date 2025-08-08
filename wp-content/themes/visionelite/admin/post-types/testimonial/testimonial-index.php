<?php
/*
	Add additional meta fields to the standard WP Page post type
*/
if ( ! defined( 'WPINC' ) ) { die; }


/*
	POST TYPES
*/
function volleyball_testimonial_post_type_int() {
	
	$testimonial_labels = array(
		'name'                  => _x( 'Testimonials', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Testimonial', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Testimonials', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add New Testimonial', 'zielkeDesign' ),
		'new_item'              => __( 'New Testimonial', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Testimonial', 'zielkeDesign' ),
		'view_item'             => __( 'View Testimonial', 'zielkeDesign' ),
		'all_items'             => __( 'All Testimonials', 'zielkeDesign' ),
		'search_items'          => __( 'Search Testimonials', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Testimonials:', 'zielkeDesign' ),
		'not_found'             => __( 'No Testimonials found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Testimonials found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Testimonial Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Testimonials archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Testimonial', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Testimonial', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Testimonials list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Testimonials list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Testimonials list', 'zielkeDesign' ),
	);
	$testimonial_args = array(
		'labels'             => $testimonial_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'testimonial',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-admin-comments',
		'supports'           => array( 'title', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'testimonial', $testimonial_args );
	
}
add_action( 'init', 'volleyball_testimonial_post_type_int' );


/*
	Hide menu from non-admins
*/
function hide_testimonial_menu() {
    if (!current_user_can('administrator') || (is_multisite() && !is_main_site())) {
        remove_menu_page('edit.php?post_type=testimonial');
    }
}
add_action('admin_menu', 'hide_testimonial_menu');


/*
	RENDER META BOX ON EDIT PAGE
*/
function volleyball_testimonial_add_meta_boxes() {
	add_meta_box(
		'testimonial_details',
		'Details',
		'testimonial_details',
		'testimonial',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'volleyball_testimonial_add_meta_boxes' );

// Content to display inside meta box
function testimonial_details( $post ) {
	include( 'views/testimonial_details.php' );
}


/*
	SAVE POST META
*/
function volleyball_testimonial_save_post_meta_data( $post_id ){
	// Check for varified nonce
	if ( ! isset( $_POST['vision_elite_testimonial_nonce'] ) ||
		! wp_verify_nonce( $_POST['vision_elite_testimonial_nonce'], 'vision_elite_testimonial_nonce' ) ){
		return;
	}else{
		if ( isset( $_REQUEST['testimonial_name'] ) ) {
			update_post_meta( $post_id, 'testimonial_name', sanitize_text_field(htmlentities($_REQUEST['testimonial_name'])));
		}
		if ( isset( $_REQUEST['testimonial_league'] ) ) {
			update_post_meta( $post_id, 'testimonial_league', sanitize_text_field(htmlentities($_REQUEST['testimonial_league'])));
		}
        if ( isset( $_REQUEST['testimonial_testimony'] ) ) {
            update_post_meta( $post_id, 'testimonial_testimony', wp_kses_post($_REQUEST['testimonial_testimony']));
        }
        if ( isset( $_REQUEST['testimonial_rating'] ) ) {
            update_post_meta( $post_id, 'testimonial_rating', sanitize_text_field(htmlentities($_REQUEST['testimonial_rating'])));
        }
		if ( isset( $_REQUEST['testimonial_image'] ) ) {
			update_post_meta( $post_id, 'testimonial_image', sanitize_text_field(htmlentities($_REQUEST['testimonial_image'])));
		}
	}
}
add_action( 'save_post', 'volleyball_testimonial_save_post_meta_data' );