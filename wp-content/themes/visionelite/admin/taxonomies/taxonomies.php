<?php
function register_visionelite_taxonomies() {
    // Ages Taxonomy
    register_taxonomy('age', 'session', array(
        'label' => __('Age'),
        'rewrite' => array('slug' => 'age'),
        'hierarchical' => false,
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
		'show_in_rest' => true,
        'rest_base' => 'age',
    ));

    // Grade Taxonomy
    register_taxonomy('grade', 'session', array(
        'label' => __('Grade'),
        'rewrite' => array('slug' => 'grade'),
        'hierarchical' => false,
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'show_in_rest' => true,
        'rest_base' => 'grade',
    ));

    // Gender Taxonomy
    register_taxonomy('gender', 'session', array(
        'label' => __('Gender'),
        'rewrite' => array('slug' => 'gender'),
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
		'show_in_rest' => true,
        'rest_base' => 'gender',
    ));
}
add_action('init', 'register_visionelite_taxonomies');
?>