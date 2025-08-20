<?php

// SETUP
add_action('after_setup_theme', function(){
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	]);
	register_nav_menus([
        'primary' => 'Primary',
        'footer' => 'Footer',
    ]);
});


// ENQUEUE STYLES & SCRIPTS
add_action('wp_enqueue_scripts', function(){
	// CSS
	wp_dequeue_style('wp-block-library');
    $css_file = get_template_directory() . '/css/theme.min.css';
    $version = file_exists($css_file) ? filemtime($css_file) : '1.0.0'; // fallback version
    wp_enqueue_style('theme.min', get_stylesheet_directory_uri() . '/css/theme.min.css', array(), $version);
	// JS 
	wp_enqueue_script('navigation', get_template_directory_uri().'/js/navigation.js', ['jquery'], '', true);
	wp_enqueue_script('scripts', get_template_directory_uri().'/js/scripts.js', ['jquery'], '', true);
	wp_enqueue_script('filters', get_template_directory_uri().'/js/filters.js', ['jquery'], '', true);
    // INCLUDES
	wp_enqueue_script('visible', get_template_directory_uri().'/inc/visible/jquery.visible.min.js', ['jquery'], '', true);
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/inc/slick/slick.css');
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/inc/slick/slick.min.js', array(), '', true );
});


// ADMIN STYLES & SCRIPTS
add_action('admin_enqueue_scripts', function(){
    // worpdpress media
    wp_enqueue_media();
	// css
	wp_enqueue_style( 'wp-color-picker' ); 
    wp_enqueue_style( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css' );
	wp_enqueue_style( 'admin_styles', get_template_directory_uri() . '/css/admin.css' );
	// js
    wp_enqueue_script('jquery');
 	wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script('admin-scripts', get_template_directory_uri().'/js/admin.js', ['jquery'], '', true);
    // ajax
    wp_enqueue_script('admin-inline-add-venue-ajax', get_template_directory_uri() . '/js/ajax/admin-inline-add-venue-ajax.js', ['jquery'], '', true);
    wp_localize_script('admin-inline-add-venue-ajax', 'admin_inline_add_venue_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('admin_inline_add_venue_ajax_nonce'),
    ]);
});

// PHP AJAX FILES
require_once('js/ajax/admin-inline-add-venue-ajax.php');


// PHP FUNCTIONS
require get_template_directory() . '/php/functions/location-functions.php';


// CUSTOM LOGIN PAGE
add_action( 'login_enqueue_scripts', function(){
	wp_enqueue_style( 'login_page_styles', get_template_directory_uri() . '/css/login.css' );
});


// INCLUDE ADMIN PAGES, POST TYPES, AND TAXONOMIES
require get_template_directory() . '/admin/pages/site/site-index.php';
require get_template_directory() . '/admin/pages/front-page/front-page-index.php';
require get_template_directory() . '/admin/post-types/sport/sport-index.php';
require get_template_directory() . '/admin/post-types/program/program-index.php';
require get_template_directory() . '/admin/post-types/session/session-index.php';
require get_template_directory() . '/admin/post-types/venue/venue-index.php';
require get_template_directory() . '/admin/post-types/event/event-index.php';
require get_template_directory() . '/admin/post-types/coach/coach-index.php';
require get_template_directory() . '/admin/post-types/testimonial/testimonial-index.php';
require get_template_directory() . '/admin/post-types/affiliation-request/affiliation-index.php';
require get_template_directory() . '/admin/taxonomies/taxonomies.php';


// POST TEMPLATES
add_filter( 'single_template', function($postType){
	global $post;
	
    if($post->post_type == 'program-type'){
        $postType = dirname( __FILE__ ) . '/admin/post-types/program-type/templates/single-program-type.php';
    }
	if($post->post_type == 'program'){
  		$postType = dirname( __FILE__ ) . '/admin/post-types/program/templates/single-program.php';
	}
    if($post->post_type == 'venue'){
  		$postType = dirname( __FILE__ ) . '/admin/post-types/venue/templates/single-venue.php';
    }
	return $postType;
});


// PAGE TEMPLATES
add_filter('theme_page_templates', function($templates) {
    $templates['php/templates/pages/front-page-template.php'] = 'Front Page';
    $templates['php/templates/pages/login-template.php'] = 'Login';
    $templates['php/templates/pages/contact-template.php'] = 'Contact';
    $templates['php/templates/pages/program-search-template.php'] = 'Program Search';
    $templates['php/templates/pages/affiliation-request-template.php'] = 'Affiliation Request';
    return $templates;
});
add_filter('template_include', function($template) {
    global $wp;
    // Only for multisite subsites (not main site) on the front page   
    if (
        is_multisite() &&
        get_current_blog_id() !== 1 &&
        is_front_page() &&
        is_home() // this indicates it's using the blog feed
    ) {
        $custom_template = get_template_directory() . '/php/templates/pages/subsite-template.php';

        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    // Add template override for subsite program pages
    if (is_multisite() && is_404()) {
        $requested_path = $wp->request; // e.g. "program/summer-camp"

        if (preg_match('#^program/([^/]+)$#', $requested_path, $matches)) {
            $post_name = sanitize_title($matches[1]);

            // Check if main site has this program
            switch_to_blog(1);
            $program_post = get_page_by_path($post_name, OBJECT, 'program');
            restore_current_blog();

            if ($program_post) {
                // Pass post name to template
                set_query_var('program_slug', $post_name);
                return get_template_directory() . '/php/templates/posts/subsite-program-template.php';
            }
        }
    }
    if (is_page()) {
        $page_template = get_page_template_slug();
        if ($page_template && locate_template($page_template)) {
            return locate_template($page_template);
        }
    }

    return $template;
});


// Remove the default editor any page that is not using the default template
add_action('edit_form_after_title', function($post) {
    $template = get_page_template_slug($post->ID);
    if ($template && $template === 'php/templates/pages/front-page-template.php') { // Check if a custom template is set
        remove_post_type_support('page', 'editor');
    }
});


// If the page is not using the default template, remove the .et_pb_toggle_builder_wrapper element from the page editor
add_action('edit_form_after_title', function($post) {
    if ($post->post_type !== 'page') {
        return;
    }
    $template = get_page_template_slug($post->ID);
    if ($template && $template !== 'default') { // Check if a custom template is set
        echo '<style>html body .et_pb_toggle_builder_wrapper { display: none !important; }</style>';
    }
});


// COMPONENT TEMPLATES
require get_template_directory() . '/php/templates/components/program-filters.php';
require get_template_directory() . '/php/templates/components/program-list.php';


// INCLUDE SHORTCODES
require get_template_directory() . '/php/shortcodes/city-contact-info-list.php';
require get_template_directory() . '/php/shortcodes/showcase-registration-form.php';
require get_template_directory() . '/php/shortcodes/become_a_sponsor_impact.php';


// OVERRIDE THE EMAIL FROM VALUE
function mail_name( $email ){
	return 'Vision Elite';
}
add_filter( 'wp_mail_from_name', 'mail_name' );


// ALLOW SVGS
add_filter('upload_mimes', function($mimes){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
});


// REMOVE ADMIN BAR
if ( ! current_user_can( 'administrator' ) ) {
    show_admin_bar( false );
}
else{
    show_admin_bar( true );
}


// REDIRECT FROM LOGOUT SCREEN TO HOME
add_action('wp_logout',function(){
  wp_safe_redirect( home_url() );
  exit;
});


// IF MULTISITE GET ARRAY OF SITE_CITY OPTIONS FROM ALL SITES ELSE GET CITIES FROM VENUE POST TYPE
function get_all_cities() {
    $cities = [];
    //if (is_multisite()) {
    /*
        $sites = get_sites();
        foreach ($sites as $site) {
            switch_to_blog($site->blog_id);
            $city = get_option('site_city');
            if ($city && !in_array($city, $cities)) {
                $cities[] = $city;
            }
            restore_current_blog();
        }
    */
    //} else {
        $args = [
            'post_type' => 'venue',
            'posts_per_page' => -1,
            'fields' => 'ids', // Only get post IDs for performance
        ];
        $venues = get_posts($args);
        foreach ($venues as $venue_id) {
            $city = get_post_meta($venue_id, 'venue_city', true);
            if ($city && !in_array($city, $cities)) {
                $cities[] = $city;
            }
        }
        // Sort cities alphabetically
        sort($cities);
        // Remove duplicates
        $cities = array_unique($cities);
        // Remove empty values
        $cities = array_filter($cities, function($city) {
            return !empty($city);
        });
    //}
    return $cities;
}


// Adds an additional function to retrieve formated page content without the H1.
function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


// REMOVE ADMIN MENUS
add_action('admin_menu', function(){
	remove_menu_page('edit-comments.php');
    if (!current_user_can('administrator')) {
        remove_menu_page('edit.php');
        remove_menu_page('edit.php?post_type=page');
        remove_menu_page('tools.php');
        remove_menu_page('upload.php');
    }
});
add_action('wp_before_admin_bar_render', function(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
});


// Add a body class in the admin area depending on super admin status
add_filter( 'admin_body_class', function( $classes ) {
    if ( is_super_admin() ) {
        $classes .= ' super-admin-dashboard';
    } else {
        $classes .= ' non-super-admin-dashboard';
    }
    return $classes;
} );


// CHECK FOR BLOG PAGES
function is_blog () {
    return ( is_archive() || is_author() || is_category() || is_home() || is_single() || is_tag()) && 'post' == get_post_type();
}


// MODIFY SEARCH QUERY
function modify_search_query($query) {
    if ($query->is_search() && $query->is_main_query()) {
        $query->set('post_type', array('post', 'page', 'program')); // Add custom post types if needed
    }
}
add_action('pre_get_posts', 'modify_search_query');


// FORCE CLASSIC EDITOR
function force_classic_editor() {
    add_filter('use_block_editor_for_post', '__return_false', 10);
    remove_action('admin_enqueue_scripts', 'wp_enqueue_editor_block_directory_assets');
}
add_action('after_setup_theme', 'force_classic_editor');


// REMOVE DIVI PROJECT POST TYPE
function remove_divi_project_post_type() {
    unregister_post_type('et_pb_layout');
}
add_action('init', 'remove_divi_project_post_type');


// GET CLEAN DIVI EXCERPT
function get_cleaned_divi_content($post_id, $word_limit = 40) {
    $post = get_post($post_id);
    if (!$post) return '';

    // Render content with shortcodes
    $content = apply_filters('the_content', $post->post_content);

    // Strip all tags
    $content = wp_strip_all_tags($content);

    // Trim to word limit
    $words = preg_split('/\s+/', $content);
    if (count($words) > $word_limit) {
        $words = array_slice($words, 0, $word_limit);
        $content = implode(' ', $words) . '...';
    }

    return $content;
}