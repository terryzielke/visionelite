<?php
/*
	Add additional meta fields to the standard WP Page post type
*/
if ( ! defined( 'WPINC' ) ) { die; }


/*
	POST TYPES
*/
function vision_elite_affiliation_post_type_int() {
	
	$affiliation_labels = array(
		'name'                  => _x( 'Affiliations', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Affiliation', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Affiliations', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Affiliation', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Affiliation', 'zielkeDesign' ),
		'new_item'              => __( 'New Affiliation', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Affiliation', 'zielkeDesign' ),
		'view_item'             => __( 'View Affiliation', 'zielkeDesign' ),
		'all_items'             => __( 'All Affiliations', 'zielkeDesign' ),
		'search_items'          => __( 'Search Affiliations', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Affiliations:', 'zielkeDesign' ),
		'not_found'             => __( 'No Affiliations found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Affiliations found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Affiliation Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Affiliations archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Affiliation', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Affiliation', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Affiliations list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Affiliations list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Affiliations list', 'zielkeDesign' ),
	);
	$affiliation_args = array(
		'labels'             => $affiliation_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'affiliation',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-businessman',
		'supports'           => array( 'title', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'affiliation', $affiliation_args );
	
}
add_action( 'init', 'vision_elite_affiliation_post_type_int' );


/**
 * Hide menu from non-admins
 */
function hide_affiliation_menu() {
    if (!current_user_can('administrator') || (is_multisite() && !is_main_site())) {
        remove_menu_page('edit.php?post_type=affiliation');
    }
}
add_action('admin_menu', 'hide_affiliation_menu');


/* 
  RENDER META BOX ON EDIT PAGE
*/
function vision_elite_affiliation_add_meta_boxes() {
	add_meta_box(
		'affiliation_info',
		'affiliation Info',
		'affiliation_info',
		'affiliation',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'vision_elite_affiliation_add_meta_boxes' );

function affiliation_info( $post ) {
	include( 'views/affiliation_info.php' );
}


/*
	SAVE POST META
*/
function vision_elite_affiliation_save_post_meta_data($post_id){
	// Check for varified nonce
	if ( ! isset( $_POST['vision_elite_affiliation_nonce'] ) ||
		! wp_verify_nonce( $_POST['vision_elite_affiliation_nonce'], 'vision_elite_affiliation_nonce' ) ){
		return;
	}else{
		// meta data
		if ( isset( $_REQUEST['affiliation_image'] ) ) {
			update_post_meta( $post_id, 'affiliation_image', sanitize_text_field(htmlentities($_REQUEST['affiliation_image'])));
		}
		if ( isset( $_REQUEST['affiliation_firstname'] ) ) {
			update_post_meta( $post_id, 'affiliation_firstname', sanitize_text_field(htmlentities($_REQUEST['affiliation_firstname'])));
		}
		if ( isset( $_REQUEST['affiliation_lastname'] ) ) {
			update_post_meta( $post_id, 'affiliation_lastname', sanitize_text_field(htmlentities($_REQUEST['affiliation_lastname'])));
		}
		if ( isset( $_REQUEST['affiliation_position'] ) ) {
			update_post_meta( $post_id, 'affiliation_position', sanitize_text_field(htmlentities($_REQUEST['affiliation_position'])));
		}
		if ( isset( $_REQUEST['affiliation_bio'] ) ) {
			update_post_meta( $post_id, 'affiliation_bio', wp_kses_post($_REQUEST['affiliation_bio']));
		}
		if ( isset( $_REQUEST['affiliation_phone'] ) ) {
			update_post_meta( $post_id, 'affiliation_phone', sanitize_text_field(htmlentities($_REQUEST['affiliation_phone'])));
		}
		if ( isset( $_REQUEST['affiliation_email'] ) ) {
			update_post_meta( $post_id, 'affiliation_email', sanitize_text_field(htmlentities($_REQUEST['affiliation_email'])));
		}
		if ( isset( $_REQUEST['prefered_contact_method'] ) ) {
			update_post_meta( $post_id, 'prefered_contact_method', sanitize_text_field(htmlentities($_REQUEST['prefered_contact_method'])));
		}
		if ( isset( $_REQUEST['prefered_contact_time'] ) ) {
			update_post_meta( $post_id, 'prefered_contact_time', sanitize_text_field(htmlentities($_REQUEST['prefered_contact_time'])));
		}
		if ( isset( $_REQUEST['affiliation_province'] ) ) {
			update_post_meta( $post_id, 'affiliation_province', sanitize_text_field(htmlentities($_REQUEST['affiliation_province'])));
		}
		if ( isset( $_REQUEST['affiliation_city'] ) ) {
			update_post_meta( $post_id, 'affiliation_city', sanitize_text_field(htmlentities($_REQUEST['affiliation_city'])));
		}
		if ( isset( $_REQUEST['affiliation_sport'] ) ) {
			update_post_meta( $post_id, 'affiliation_sport', sanitize_text_field(htmlentities($_REQUEST['affiliation_sport'])));
		}
	}
}
add_action( 'save_post', 'vision_elite_affiliation_save_post_meta_data');


// Add custom columns to the affiliation post type for Province and City
function vision_elite_affiliation_custom_columns( $columns ) {
	$columns = array(
		'cb' => $columns['cb'],
		'title' => __( 'Name' ),
		'city' => __( 'City' ),
		'province' => __( 'Province' ),
		'date' => $columns['date'],
	);
	return $columns;
}
add_filter( 'manage_affiliation_posts_columns', 'vision_elite_affiliation_custom_columns' );

// Populate custom columns with data
function vision_elite_affiliation_custom_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'city':
			$city = get_post_meta( $post_id, 'affiliation_city', true );
			echo esc_html( $city );
			break;
		case 'province':
			$province = get_post_meta( $post_id, 'affiliation_province', true );
			echo esc_html( $province );
			break;
	}
}
add_action( 'manage_affiliation_posts_custom_column', 'vision_elite_affiliation_custom_column_data', 10, 2 );