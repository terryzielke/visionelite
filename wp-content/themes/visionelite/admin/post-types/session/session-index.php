<?php
/*
	Add additional meta fields to the standard WP Page post type
*/
if ( ! defined( 'WPINC' ) ) { die; }


/*
	POST TYPES
*/
function volleyball_session_post_type_int() {
	
	$session_labels = array(
		'name'                  => _x( 'Programs', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Program', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Programs', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Program', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Program', 'zielkeDesign' ),
		'new_item'              => __( 'New Program', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Program', 'zielkeDesign' ),
		'view_item'             => __( 'View Program', 'zielkeDesign' ),
		'all_items'             => __( 'All Programs', 'zielkeDesign' ),
		'search_items'          => __( 'Search Programs', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Programs:', 'zielkeDesign' ),
		'not_found'             => __( 'No Programs found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Programs found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Program Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Programs archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Program', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Program', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Programs list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Programs list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Programs list', 'zielkeDesign' ),
	);
	$session_args = array(
		'labels'             => $session_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'schedule',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-clipboard',
		'supports'           => array( 'title', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'session', $session_args );
	
}
add_action( 'init', 'volleyball_session_post_type_int' );


/* 
  RENDER META BOX ON EDIT PAGE
*/
function volleyball_session_add_meta_boxes() {
	add_meta_box(
		'program',
		'Program Info',
		'session_program',
		'session',
		'normal'
	);
	add_meta_box(
		'schedule',
		'Program Schedule',
		'session_schedule',
		'session',
		'normal'
	);
	add_meta_box(
		'note',
		'Note',
		'session_note',
		'session',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'volleyball_session_add_meta_boxes' );

function session_program( $post ) {
	include( 'views/session_program.php' );
}
function session_schedule( $post ) {
	include( 'views/session_schedule.php' );
}
function session_note( $post ) {
	include( 'views/session_note.php' );
}


/*
	SAVE POST META
*/
function volleyball_session_save_post_meta_data($post_id){
	// Check for varified nonce
	if ( ! isset( $_POST['volleyball_network_session_nonce'] ) ||
		! wp_verify_nonce( $_POST['volleyball_network_session_nonce'], 'volleyball_network_session_nonce' ) ){
		return;
	}else{
		// meta data
		if ( isset( $_REQUEST['session_program'] ) ) {
			update_post_meta( $post_id, 'session_program', sanitize_text_field(htmlentities($_REQUEST['session_program'])));
		}
		if ( isset( $_REQUEST['session_sport'] ) ) {
			update_post_meta( $post_id, 'session_sport', sanitize_text_field(htmlentities($_REQUEST['session_sport'])));
		}
		if ( isset( $_REQUEST['session_season'] ) ) {
			update_post_meta( $post_id, 'session_season', sanitize_text_field(htmlentities($_REQUEST['session_season'])));
		}
		if ( isset( $_REQUEST['session_venue'] ) ) {
			update_post_meta( $post_id, 'session_venue', sanitize_text_field(htmlentities($_REQUEST['session_venue'])));
		}
		if ( isset( $_REQUEST['session_registration'] ) ) {
			update_post_meta( $post_id, 'session_registration', sanitize_text_field(htmlentities($_REQUEST['session_registration'])));
		}
		if ( isset( $_REQUEST['session_remaining_spots'] ) ) {
			update_post_meta( $post_id, 'session_remaining_spots', sanitize_text_field(htmlentities($_REQUEST['session_remaining_spots'])));
		}
		if ( isset( $_REQUEST['session_price'] ) ) {
			update_post_meta( $post_id, 'session_price', sanitize_text_field(htmlentities($_REQUEST['session_price'])));
		}
		if ( isset( $_REQUEST['session_start_date'] ) ) {
			update_post_meta( $post_id, 'session_start_date', sanitize_text_field(htmlentities($_REQUEST['session_start_date'])));
		}
		if ( isset( $_REQUEST['session_end_date'] ) ) {
			update_post_meta( $post_id, 'session_end_date', sanitize_text_field(htmlentities($_REQUEST['session_end_date'])));
		}
		if ( isset( $_REQUEST['session_start_time'] ) ) {
			update_post_meta( $post_id, 'session_start_time', sanitize_text_field(htmlentities($_REQUEST['session_start_time'])));
		}
		if ( isset( $_REQUEST['session_end_time'] ) ) {
			update_post_meta( $post_id, 'session_end_time', sanitize_text_field(htmlentities($_REQUEST['session_end_time'])));
		}
		if ( isset( $_REQUEST['session_cancelations'] ) ) {
			update_post_meta( $post_id, 'session_cancelations', sanitize_text_field(htmlentities($_REQUEST['session_cancelations'])));
		}
		if ( isset( $_REQUEST['session_note'] ) ) {
			update_post_meta( $post_id, 'session_note', sanitize_text_field(htmlentities($_REQUEST['session_note'])));
		}
		// cant use sanitize_text_field for array
		update_post_meta( $post_id, 'session_days', $_REQUEST['session_days']);
		if ( isset( $_REQUEST['session_time'] ) ) {
			update_post_meta( $post_id, 'session_time', sanitize_text_field(htmlentities($_REQUEST['session_time'])));
		}
	}
}
add_action( 'save_post', 'volleyball_session_save_post_meta_data');


/*
	CUSTOM COLUMNS
*/
function volleyball_session_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Program' ),
		'venue' => __( 'Venue' ),
		'age' => __( 'Age' ),
		'gender' => __( 'Gender' ),
	);
	return $columns;
}
add_filter( 'manage_session_posts_columns', 'volleyball_session_columns' );
// Add the data to the custom columns
function volleyball_session_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'age' :
			$terms = get_the_terms( $post_id, 'age' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => 'session', 'age' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'age', 'display' ) )
					);
				}
				echo join( ', ', $out );
			} else {
				_e( 'No Age' );
			}
			break;
		case 'gender' :
			$terms = get_the_terms( $post_id, 'gender' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => 'session', 'gender' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'gender', 'display' ) )
					);
				}
				echo join( ', ', $out );
			} else {
				_e( 'CO-ED' );
			}
			break;
		case 'venue' :
			$venue = get_post_meta( $post_id, 'session_venue', true );
			if(is_multisite()) {
				// If multisite, switch to the main site to get the venue title
				switch_to_blog(1);
				$venue_title = get_the_title($venue);
				restore_current_blog();
				echo esc_html($venue_title);
			} else {
				// If not multisite, get the venue title from the current site
				$venue_title = get_the_title($venue);
				echo esc_html($venue_title);
			}
			break;
	}
}
add_action( 'manage_session_posts_custom_column' , 'volleyball_session_custom_columns', 10, 2 );
// Make the custom columns sortable
function volleyball_session_sortable_columns( $columns ) {
    $columns['age'] = 'age';
    $columns['gender'] = 'gender';
    $columns['venue'] = 'venue';
    return $columns;
}
add_filter( 'manage_edit-session_sortable_columns', 'volleyball_session_sortable_columns' );
