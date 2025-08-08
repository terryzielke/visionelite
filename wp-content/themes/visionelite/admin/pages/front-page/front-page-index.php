<?php
add_action('add_meta_boxes', 'front_page_template_conditional_metabox');
function front_page_template_conditional_metabox() {
    global $post;

    // Ensure $post is available
    if (!isset($post)) return;

    // Get the current page template
    $template_file = get_page_template_slug($post->ID);

    // Target a specific template file
    if ($template_file == 'php/templates/pages/front-page-template.php') {
        add_meta_box(
            'banner_section',               // ID
            'Banner Section',               // Title
            'banner_section_callback',      // Callback
            'page',                         // Screen
            'normal',                       // Context
            'default'                       // Priority
        );
        add_meta_box(
            'cta_btn_section',
            'Call To Action Buttons',
            'cta_btn_section_callback',
            'page',
            'normal',
            'default'
        );
        add_meta_box(
            'registration_options_section',
            'Registration Options',
            'registration_options_section',
            'page',
            'normal',
            'default'
        );
    }
}

function banner_section_callback($post) {
	include( 'views/banner_section.php' );
}

function cta_btn_section_callback($post) {
	include( 'views/cta_btn_section.php' );
}

function registration_options_section($post) {
	include( 'views/registration_options_section.php' );
}


/*
	SAVE POST META
*/
add_action( 'save_post', 'front_page_save_post_meta_data' );
function front_page_save_post_meta_data( $post_id ){
	// Check for varified nonce
	if ( ! isset( $_POST['vision_elite_front_page_nonce'] ) ||
		! wp_verify_nonce( $_POST['vision_elite_front_page_nonce'], 'vision_elite_front_page_nonce' ) ){
		return;
	}else{
        // banner section
        if ( isset( $_REQUEST['banner_image'] ) ) {
            update_post_meta( $post_id, 'banner_image', sanitize_text_field(htmlentities($_REQUEST['banner_image'])));
        }
		if ( isset( $_REQUEST['banner_white_h1'] ) ) {
			update_post_meta( $post_id, 'banner_white_h1', sanitize_text_field(htmlentities($_REQUEST['banner_white_h1'])));
		}
		if ( isset( $_REQUEST['banner_orange_h1'] ) ) {
			update_post_meta( $post_id, 'banner_orange_h1', sanitize_text_field(htmlentities($_REQUEST['banner_orange_h1'])));
		}
        if ( isset( $_REQUEST['banner_description'] ) ) {
            update_post_meta( $post_id, 'banner_description', wp_kses_post($_REQUEST['banner_description']));
        }
        if ( isset( $_REQUEST['banner_btn_text'] ) ) {
            update_post_meta( $post_id, 'banner_btn_text', sanitize_text_field(htmlentities($_REQUEST['banner_btn_text'])));
        }
        if ( isset( $_REQUEST['banner_btn_link'] ) ) {
            update_post_meta( $post_id, 'banner_btn_link', sanitize_text_field(htmlentities($_REQUEST['banner_btn_link'])));
        }
		if ( isset( $_REQUEST['banner_caption_text'] ) ) {
			update_post_meta( $post_id, 'banner_caption_text', wp_kses_post($_REQUEST['banner_caption_text']));
		}
        // cta buttons section
		if ( isset( $_REQUEST['cta_h2'] ) ) {
			update_post_meta( $post_id, 'cta_h2', sanitize_text_field(htmlentities($_REQUEST['cta_h2'])));
		}
		if ( isset( $_REQUEST['cta_h3'] ) ) {
			update_post_meta( $post_id, 'cta_h3', sanitize_text_field(htmlentities($_REQUEST['cta_h3'])));
		}
		if ( isset( $_REQUEST['cta_buttons_csv'] ) ) {
			update_post_meta( $post_id, 'cta_buttons_csv', wp_kses_post($_REQUEST['cta_buttons_csv']));
		}
        // registration options section
        if ( isset( $_REQUEST['registration_banner_image'] ) ) {
            update_post_meta( $post_id, 'registration_banner_image', sanitize_text_field(htmlentities($_REQUEST['registration_banner_image'])));
        }
        if ( isset( $_REQUEST['registration_banner_h2'] ) ) {
            update_post_meta( $post_id, 'registration_banner_h2', sanitize_text_field(htmlentities($_REQUEST['registration_banner_h2'])));
        }
        if ( isset( $_REQUEST['registration_banner_h3'] ) ) {
            update_post_meta( $post_id, 'registration_banner_h3', sanitize_text_field(htmlentities($_REQUEST['registration_banner_h3'])));
        }
        if ( isset( $_REQUEST['registration_banner_btn_text'] ) ) {
            update_post_meta( $post_id, 'registration_banner_btn_text', sanitize_text_field(htmlentities($_REQUEST['registration_banner_btn_text'])));
        }
        if ( isset( $_REQUEST['registration_banner_btn_link'] ) ) {
            update_post_meta( $post_id, 'registration_banner_btn_link', sanitize_text_field(htmlentities($_REQUEST['registration_banner_btn_link'])));
        }
        if ( isset( $_REQUEST['registration_cta_csv'] ) ) {
            update_post_meta( $post_id, 'registration_cta_csv', sanitize_text_field(htmlentities($_REQUEST['registration_cta_csv'])));
        }
	}
}
?>