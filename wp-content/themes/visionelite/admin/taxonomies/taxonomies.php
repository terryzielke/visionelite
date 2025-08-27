<?php
// add term order support
function add_term_order_support() {
    global $wpdb;
    $wpdb->terms = $wpdb->prefix . 'terms';
}
add_action( 'init', 'add_term_order_support' );


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

    // Skill Level Taxonomy
    register_taxonomy('skill_level', 'session', array(
        'label' => __('Skill Level'),
        'rewrite' => array('slug' => 'skill_level'),
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
		'show_in_rest' => true,
        'rest_base' => 'skill_level',
    ));

    // Seeason Taxonomy
    register_taxonomy('season', 'session', array(
        'label' => __('Season'),
        'rewrite' => array('slug' => 'season'),
        'hierarchical' => true,
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
		'show_in_rest' => true,
        'rest_base' => 'season',
    ));
}
add_action('init', 'register_visionelite_taxonomies');


// Add custom field to skill_level taxonomy
function skill_level_add_order_field( $term ) {
    $order = get_term_meta( $term->term_id, 'order', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="term-order">Order</label></th>
        <td>
            <input type="number" name="term_order" id="term-order" value="<?php echo esc_attr( $order ); ?>" />
        </td>
    </tr>
    <?php
}
add_action( 'skill_level_edit_form_fields', 'skill_level_add_order_field' );

// Save custom field
function skill_level_save_order_field( $term_id ) {
    if ( isset( $_POST['term_order'] ) ) {
        update_term_meta( $term_id, 'order', intval( $_POST['term_order'] ) );
    }
}
add_action( 'edited_skill_level', 'skill_level_save_order_field' );

// add order field to season taxonomy
function season_add_order_field( $term ) {
    $order = get_term_meta( $term->term_id, 'order', true );
    ?>
    <tr class="form-field">
        <th scope="row"><label for="term-order">Order</label></th>
        <td>
            <input type="number" name="term_order" id="term-order" value="<?php echo esc_attr( $order ); ?>" />
        </td>
    </tr>
    <?php
}
add_action( 'season_edit_form_fields', 'season_add_order_field' );
// Save custom field
function season_save_order_field( $term_id ) {
    if ( isset( $_POST['term_order'] ) ) {
        update_term_meta( $term_id, 'order', intval( $_POST['term_order'] ) );
    }
}
add_action( 'edited_season', 'season_save_order_field' );

/**
 * Convert "season" taxonomy checkboxes to radio buttons in the post editor
 */
add_action('admin_footer', function () {
    global $pagenow;

    if (!in_array($pagenow, ['post.php', 'post-new.php'])) {
        return;
    }
    ?>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.querySelector("#taxonomy-season");
        if (!container) return;

        const checkboxes = container.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(input => {
            input.type = "radio";

            // Ensure the name ends with [] so WP core still treats it as an array
            if (!input.name.endsWith("[]")) {
                input.name = input.name + "[]";
            }
        });
    });
    </script>
    <?php
});

?>