<?php
/*
	Add additional meta fields to the standard WP Page post type
*/
if ( ! defined( 'WPINC' ) ) { die; }


/*
	POST TYPES
*/
function volleyball_event_post_type_int() {
	
	$event_labels = array(
		'name'                  => _x( 'Events', 'Post type general name', 'zielkeDesign' ),
		'singular_name'         => _x( 'Event', 'Post type singular name', 'zielkeDesign' ),
		'menu_name'             => _x( 'Events', 'Admin Menu text', 'zielkeDesign' ),
		'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'zielkeDesign' ),
		'add_new'               => __( 'Add New', 'zielkeDesign' ),
		'add_new_item'          => __( 'Add Event', 'zielkeDesign' ),
		'new_item'              => __( 'New Event', 'zielkeDesign' ),
		'edit_item'             => __( 'Edit Event', 'zielkeDesign' ),
		'view_item'             => __( 'View Event', 'zielkeDesign' ),
		'all_items'             => __( 'All Events', 'zielkeDesign' ),
		'search_items'          => __( 'Search Events', 'zielkeDesign' ),
		'parent_item_colon'     => __( 'Parent Events:', 'zielkeDesign' ),
		'not_found'             => __( 'No Events found.', 'zielkeDesign' ),
		'not_found_in_trash'    => __( 'No Events found in Trash.', 'zielkeDesign' ),
		'featured_image'        => _x( 'Event Thumbnail', 'zielkeDesign' ),
		'set_featured_image'    => _x( 'Set thumbnail', 'zielkeDesign' ),
		'remove_featured_image' => _x( 'Remove thumbnail', 'zielkeDesign' ),
		'use_featured_image'    => _x( 'Use as thumbnail', 'zielkeDesign' ),
		'archives'              => _x( 'Events archives', 'zielkeDesign' ),
		'insert_into_item'      => _x( 'Insert into Event', 'zielkeDesign' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this Event', 'zielkeDesign' ),
		'filter_items_list'     => _x( 'Filter Events list', 'zielkeDesign' ),
		'items_list_navigation' => _x( 'Events list navigation', 'zielkeDesign' ),
		'items_list'            => _x( 'Events list', 'zielkeDesign' ),
	);
	$event_args = array(
		'labels'             => $event_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'page',
		'has_archive'        => false,
		'rewrite' => array(
			'slug' => 'event',
			'with_front' => false
		),
		'hierarchical'       => true,
		'menu_position'      => 10,
		'menu_icon'          => 'dashicons-buddicons-activity',
		'supports'           => array( 'title', 'page-attributes' ),
        'show_in_rest'       => true,
	);
	register_post_type( 'event', $event_args );
	
}
add_action( 'init', 'volleyball_event_post_type_int' );


/*
  RENDER META BOX ON EDIT PAGE
*/
function volleyball_event_add_meta_boxes() {
	add_meta_box(
		'event_banner',
		'Event Banner',
		'event_banner',
		'event',
		'normal'
	);
	add_meta_box(
		'event_details',
		'Event Details',
		'event_details',
		'event',
		'normal'
	);
	add_meta_box(
		'schedule',
		'Event Schedule',
		'event_schedule',
		'event',
		'normal'
	);
}
add_action( 'add_meta_boxes', 'volleyball_event_add_meta_boxes' );

function event_banner( $post ) {
	include( 'views/event_banner.php' );
}
function event_details( $post ) {
	include( 'views/event_details.php' );
}
function event_schedule( $post ) {
	include( 'views/event_schedule.php' );
}


/*
	ADD TEMPLATE PAGE FOR SINGLE EVENT
	template file exists in themes/visionelite/admin/post-types/event/templates/single-event.php
*/
function volleyball_event_template_include( $template ) {
	if ( is_singular( 'event' ) ) {
		// Check if the template file exists
		$custom_template = locate_template( 'admin/post-types/event/templates/single-event.php' );
		if ( $custom_template ) {
			return $custom_template;
		} else {
			// Fallback to default template
			return plugin_dir_path( __FILE__ ) . 'templates/single-event.php';
		}
	}
	return $template;
}
add_filter( 'template_include', 'volleyball_event_template_include' );


/*
	SAVE POST META
*/
function volleyball_event_save_post_meta_data( $post_id, $post, $update){
    // Avoid infinite loop and autosaves
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
	// Check for varified nonce
	if ( ! isset( $_POST['volleyball_network_event_nonce'] ) ||
		! wp_verify_nonce( $_POST['volleyball_network_event_nonce'], 'volleyball_network_event_nonce' ) ){
		return;
	}else{
		// banner
		if ( isset( $_REQUEST['banner_image'] ) ) {
			update_post_meta( $post_id, 'banner_image', sanitize_text_field(htmlentities($_REQUEST['banner_image'])));
		}
        if ( isset( $_REQUEST['banner_description'] ) ) {
            update_post_meta( $post_id, 'banner_description', sanitize_text_field(htmlentities($_REQUEST['banner_description'])));
        }
		if ( isset( $_REQUEST['banner_btn_text'] ) ) {
			update_post_meta( $post_id, 'banner_btn_text', sanitize_text_field(htmlentities($_REQUEST['banner_btn_text'])));
		}
		if ( isset( $_REQUEST['banner_btn_link'] ) ) {
			update_post_meta( $post_id, 'banner_btn_link', sanitize_text_field(htmlentities($_REQUEST['banner_btn_link'])));
		}
		// details
		if ( isset( $_REQUEST['event_venue'] ) ) {
			update_post_meta( $post_id, 'event_venue', sanitize_text_field(htmlentities($_REQUEST['event_venue'])));
		}
		if ( isset( $_REQUEST['event_registration'] ) ) {
			update_post_meta( $post_id, 'event_registration', sanitize_text_field(htmlentities($_REQUEST['event_registration'])));
		}
		if ( isset( $_REQUEST['event_price'] ) ) {
			update_post_meta( $post_id, 'event_price', sanitize_text_field(htmlentities($_REQUEST['event_price'])));
		}
        if ( isset( $_REQUEST['event_description'] ) ) {
            update_post_meta( $post_id, 'event_description', wp_kses_post($_REQUEST['event_description']));
        }
		if ( isset( $_REQUEST['event_start_date'] ) ) {
			update_post_meta( $post_id, 'event_start_date', sanitize_text_field(htmlentities($_REQUEST['event_start_date'])));
		}
		if ( isset( $_REQUEST['event_end_date'] ) ) {
			update_post_meta( $post_id, 'event_end_date', sanitize_text_field(htmlentities($_REQUEST['event_end_date'])));
		}
		if ( isset( $_REQUEST['event_start_time'] ) ) {
			update_post_meta( $post_id, 'event_start_time', sanitize_text_field(htmlentities($_REQUEST['event_start_time'])));
		}
		if ( isset( $_REQUEST['event_end_time'] ) ) {
			update_post_meta( $post_id, 'event_end_time', sanitize_text_field(htmlentities($_REQUEST['event_end_time'])));
		}
		if ( isset( $_REQUEST['event_cancelations'] ) ) {
			update_post_meta( $post_id, 'event_cancelations', sanitize_text_field(htmlentities($_REQUEST['event_cancelations'])));
		}
		if ( isset( $_REQUEST['event_note'] ) ) {
			update_post_meta( $post_id, 'event_note', sanitize_text_field(htmlentities($_REQUEST['event_note'])));
		}
		// cant use sanitize_text_field for array
		update_post_meta( $post_id, 'event_days', $_REQUEST['event_days']);
		if ( isset( $_REQUEST['event_time'] ) ) {
			update_post_meta( $post_id, 'event_time', sanitize_text_field(htmlentities($_REQUEST['event_time'])));
		}
		// set new venue data
		/*
		if ( isset($_REQUEST['new_venue_name']) && isset($_REQUEST['new_venue_address']) ) {
			$venue_data = [
				'name'        => sanitize_text_field($_REQUEST['new_venue_name']),
				'address'     => sanitize_text_field($_REQUEST['new_venue_address']),
				'city'        => sanitize_text_field($_REQUEST['new_venue_city'] ?? ''),
				'province'    => sanitize_text_field($_REQUEST['new_venue_province'] ?? ''),
				'postal_code' => sanitize_text_field($_REQUEST['new_venue_postal_code'] ?? ''),
			];
			visionelite_add_inline_venue($venue_data, $post_id);
		}
		*/
	}
}
add_action( 'save_post', 'volleyball_event_save_post_meta_data', 10, 3 );


/*
	ADD INLINE VENUE
*/
function visionelite_add_inline_venue($venue, $event_post_id) {
	if ( ! current_user_can( 'edit_posts' ) ) {
		return;
	}

	if ( empty($venue['name']) || empty($venue['address']) ) {
		return;
	}

	$post_data = [
		'post_title'   => $venue['name'],
		'post_type'    => 'venue',
		'post_status'  => 'publish',
		'post_content' => '',
	];

	if ( is_multisite() ) {
		switch_to_blog(1);
	}

	$venue_id = wp_insert_post($post_data);

	if ( ! is_wp_error($venue_id) ) {
		update_post_meta($venue_id, 'venue_address', $venue['address']);
		update_post_meta($venue_id, 'venue_city', ucwords($venue['city']));
		update_post_meta($venue_id, 'venue_province', $venue['province']);
		update_post_meta($venue_id, 'venue_postal_code', $venue['postal_code']);

		update_post_meta($event_post_id, 'event_venue', $venue_id);
	}

	if ( is_multisite() ) {
		restore_current_blog();
	}
}


/*
	CUSTOM COLUMNS
*/
function volleyball_event_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Event' ),
		'venue' => __( 'Venue' ),
		'date' => __( 'date' ),
	);
	return $columns;
}
add_filter( 'manage_event_posts_columns', 'volleyball_event_columns' );
// Add the data to the custom columns
function volleyball_event_custom_columns( $column, $post_id ) {
	switch ( $column ) {
		case 'date' :
			$startdate = get_post_meta( $post_id, 'session_start_date', true );
			$enddate = get_post_meta( $post_id, 'session_end_date', true );
			// Format the start date -> end date for display
			if ( $startdate && $enddate ) {
				$start_date = date_i18n( get_option( 'date_format' ), strtotime( $startdate ) );
				$end_date = date_i18n( get_option( 'date_format' ), strtotime( $enddate ) );
				echo esc_html( $start_date . ' - ' . $end_date );
			} elseif ( $startdate ) {
				$start_date = date_i18n( get_option( 'date_format' ), strtotime( $startdate ) );
				echo esc_html( $start_date );
			} elseif ( $enddate ) {
				$end_date = date_i18n( get_option( 'date_format' ), strtotime( $enddate ) );
				echo esc_html( $end_date );
			} else {	
				echo esc_html__( 'No date set', 'zielkeDesign' );
			}
			break;
		case 'venue' :
			$venue = get_post_meta( $post_id, 'event_venue', true );
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
add_action( 'manage_event_posts_custom_column' , 'volleyball_event_custom_columns', 10, 2 );
// Make the custom columns sortable
function volleyball_event_sortable_columns( $columns ) {
    $columns['age'] = 'age';
    $columns['gender'] = 'gender';
    $columns['venue'] = 'venue';
    return $columns;
}
add_filter( 'manage_edit-event_sortable_columns', 'volleyball_event_sortable_columns' );
