<?php
/*
	Add additional meta fields to the standard WP Page post type
*/
if ( ! defined( 'WPINC' ) ) { die; }


/*
	POST TYPES
*/
function volleyball_coach_post_type_int() {
	
	$coach_labels = array(
		'name'                  => _x( 'Coachs', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Coach', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Coachs', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Coach', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Coach', 'zielkeDesign' ),
		'new_item'              => __( 'New Coach', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Coach', 'zielkeDesign' ),
		'view_item'             => __( 'View Coach', 'zielkeDesign' ),
		'all_items'             => __( 'All Coachs', 'zielkeDesign' ),
		'search_items'          => __( 'Search Coachs', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Coachs:', 'zielkeDesign' ),
		'not_found'             => __( 'No Coachs found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Coachs found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Coach Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Coachs archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Coach', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Coach', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Coachs list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Coachs list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Coachs list', 'zielkeDesign' ),
	);
	$coach_args = array(
		'labels'             => $coach_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'coach',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-businessman',
		'supports'           => array( 'title', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'coach', $coach_args );
	
}
add_action( 'init', 'volleyball_coach_post_type_int' );


/* 
  RENDER META BOX ON EDIT PAGE
*/
function volleyball_coach_add_meta_boxes() {
	add_meta_box(
		'coach_info',
		'Coach Info',
		'coach_info',
		'coach',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'volleyball_coach_add_meta_boxes' );

function coach_info( $post ) {
	include( 'views/coach_info.php' );
}


/*
	ADD TEMPLATE PAGE FOR SINGLE COACH
*/
function volleyball_coach_template_include( $template ) {
	if ( is_singular( 'coach' ) ) {
		// Check if the template file exists
		$custom_template = locate_template( 'admin/post-types/coach/templates/single-coach.php' );
		if ( $custom_template ) {
			return $custom_template;
		} else {
			// Fallback to default template
			return plugin_dir_path( __FILE__ ) . 'templates/single-coach.php';
		}
	}
	return $template;
}
add_filter( 'template_include', 'volleyball_coach_template_include' );


/*
	SAVE POST META
*/
function volleyball_coach_save_post_meta_data($post_id){
	// Check for varified nonce
	if ( ! isset( $_POST['volleyball_network_coach_nonce'] ) ||
		! wp_verify_nonce( $_POST['volleyball_network_coach_nonce'], 'volleyball_network_coach_nonce' ) ){
		return;
	}else{
		// meta data
		if ( isset( $_REQUEST['coach_image'] ) ) {
			update_post_meta( $post_id, 'coach_image', sanitize_text_field(htmlentities($_REQUEST['coach_image'])));
		}
		if ( isset( $_REQUEST['coach_firstname'] ) ) {
			update_post_meta( $post_id, 'coach_firstname', sanitize_text_field(htmlentities($_REQUEST['coach_firstname'])));
		}
		if ( isset( $_REQUEST['coach_lastname'] ) ) {
			update_post_meta( $post_id, 'coach_lastname', sanitize_text_field(htmlentities($_REQUEST['coach_lastname'])));
		}
		if ( isset( $_REQUEST['coach_position'] ) ) {
			update_post_meta( $post_id, 'coach_position', sanitize_text_field(htmlentities($_REQUEST['coach_position'])));
		}
		if ( isset( $_REQUEST['coach_bio'] ) ) {
			update_post_meta( $post_id, 'coach_bio', wp_kses_post($_REQUEST['coach_bio']));
		}
		if ( isset( $_REQUEST['coach_phone'] ) ) {
			update_post_meta( $post_id, 'coach_phone', sanitize_text_field(htmlentities($_REQUEST['coach_phone'])));
		}
		if ( isset( $_REQUEST['coach_email'] ) ) {
			update_post_meta( $post_id, 'coach_email', sanitize_text_field(htmlentities($_REQUEST['coach_email'])));
		}
	}
}
add_action( 'save_post', 'volleyball_coach_save_post_meta_data');