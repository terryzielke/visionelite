<?php


add_action( 'wpmu_new_blog', 'set_default_theme_for_new_site', 10, 6 );
function set_default_theme_for_new_site( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {
    switch_to_blog( $blog_id );
    // Set the default theme (use theme directory name, not display name)
    $default_theme = 'visionelite'; // Replace with your theme's directory name
    update_option( 'template', $default_theme );
    update_option( 'stylesheet', $default_theme );
    restore_current_blog();
}


add_action('network_site_new_form', 'add_custom_fields_to_new_site_form');
function add_custom_fields_to_new_site_form() {
    ?>
    <h3>Vision Elite Site Settings</h3>
	<p>These settings are critical for the operation of the site. Please fill them out carefully.</p>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="site_province">Province</label></th>
            <td>
				<select name="site_province" id="site_province" style="width:300px;">
                    <?php
                        $provinces = array(
                            'AB' => 'Alberta',
                            'BC' => 'British Columbia',
                            'MB' => 'Manitoba',
                            'NB' => 'New Brunswick',
                            'NL' => 'Newfoundland and Labrador',
                            'NS' => 'Nova Scotia',
                            'ON' => 'Ontario',
                            'PE' => 'Prince Edward Island',
                            'QC' => 'Quebec',
                            'SK' => 'Saskatchewan',
                            'NT' => 'Northwest Territories',
                            'NU' => 'Nunavut',
                            'YT' => 'Yukon'
                        );
                        foreach ($provinces as $code => $name) :
                            $selected = '';
                            echo sprintf('<option value="%s" %s>%s</option>', esc_attr($code), $selected, esc_html($name));
                        endforeach;
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="site_city">City</label></th>
            <td><input name="site_city" type="text" id="site_city" value="" style="width:300px;" class="regular-text"></td>
        </tr>
        <tr>
            <th scope="row"><label for="site_sport">Sport</label></th>
            <td>
				<select name="site_sport" id="site_sport" style="width:300px;">
					<?php
				        if ( is_multisite() ) {
				            switch_to_blog( 1 ); // Switch to the main site to get the sports.
				        }
                        // Get sports from sport post type
                        $sports = get_posts( array(
                            'post_type'      => 'activity',
                            'posts_per_page' => -1,
				            'orderby'        => 'menu_order',
				            'order'          => 'ASC',
                            'fields'         => 'ids', // Only get IDs to reduce memory usage
                        ) );
                        if ( ! empty( $sports ) && is_array( $sports ) ) {
                            $sports = array_combine( $sports, array_map( function( $id ) {
                                return get_the_title( $id );
                            }, $sports ) );
                        } else {
                            // Fallback to predefined sports if no posts found
                            $sports = array(
                                'volleyball' => 'Volleyball',
                            );
                        }
				        if ( is_multisite() ) {
				            restore_current_blog(); // Restore the current blog context.
				        }
                        // Loop through sports and create options
						foreach ($sports as $key => $value) :
							echo '<option value="'.strtolower($value).'" %s>'.$value.'</option>';
						endforeach;
					?>
				</select>
			</td>
        </tr>
    </table>
    <?php
}


add_action('wpmu_new_blog', 'save_custom_site_meta', 10, 6);
function save_custom_site_meta($blog_id, $user_id, $domain, $path, $site_id, $meta) {

    if (isset($_POST['site_province'])) {
        update_blog_option($blog_id, 'site_province', sanitize_text_field($_POST['site_province']));
    }
    if (isset($_POST['site_city'])) {
        update_blog_option($blog_id, 'site_city', sanitize_text_field($_POST['site_city']));
    }
    if (isset($_POST['site_sport'])) {
        update_blog_option($blog_id, 'site_sport', sanitize_text_field($_POST['site_sport']));
    }
}


// This class ensures settings are registered and displayed correctly only on individual subsite admin pages.
class Subsite_General_Settings {

    // Constructor.
    // Initializes the plugin by hooking into WordPress actions.
    public function __construct() {
        
        if ( is_multisite() && ! is_network_admin() ) {
            add_action( 'admin_init', array( $this, 'register_custom_general_settings' ) );
        }
    }
    
    public function register_custom_general_settings() {
        // Register settings so WordPress can save them.
        // We register them under the 'general' settings group to automatically place them
        // on the standard General Settings page (wp-admin/options-general.php).
        register_setting(
            'general',
            'site_province',
            array(
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '',
                'show_in_rest'      => false,
            )
        );
        register_setting(
            'general',
            'site_city',
            array(
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '',
                'show_in_rest'      => false,
            )
        );
        register_setting(
            'general',
            'site_sport',
            array(
                'type'              => 'string',
                'sanitize_callback' => array( $this, 'sanitize_site_sport_field' ),
                'default'           => '',
                'show_in_rest'      => false,
            )
        );

        // Add the custom fields to the General Settings page.
        // The 'general' slug refers to the main General Settings page.
        // We attach them to the 'default' section of that page.
        add_settings_field(
            'site_province',
            'Site Province',
            array( $this, 'display_site_province_field' ),
            'general',
            'default'
        );
        add_settings_field(
            'site_city',     
            'Site City',     
            array( $this, 'display_site_city_field' ),
            'general', 
            'default' 
        );
        add_settings_field(
            'site_sport',
            'Site Sport',
            array( $this, 'display_site_sport_field' ),
            'general',
            'default'
        );
    }

    public function display_site_province_field(){
        $province = get_option( 'site_province', '' );
        ?>
        <span class="input-wrapper">
            <select name="site_province" id="site_province" style="width:300px;" class="disabled">
                <option value="">— Select Province —</option>
                <?php
                $provinces = array(
                    'AB' => 'Alberta',
                    'BC' => 'British Columbia',
                    'MB' => 'Manitoba',
                    'NB' => 'New Brunswick',
                    'NL' => 'Newfoundland and Labrador',
                    'NS' => 'Nova Scotia',
                    'ON' => 'Ontario',
                    'PE' => 'Prince Edward Island',
                    'QC' => 'Quebec',
                    'SK' => 'Saskatchewan',
                    'NT' => 'Northwest Territories',
                    'NU' => 'Nunavut',
                    'YT' => 'Yukon'
                );
                foreach ( $provinces as $code => $name ) :
                    $selected = selected( $province, $code, false );
                    echo sprintf( '<option value="%s" %s>%s</option>', esc_attr( $code ), $selected, esc_html( $name ) );
                endforeach;
                ?>
            </select>
        </span>
        <?php
    }
    public function display_site_city_field() {
        $city = get_option( 'site_city', '' );
        ?>
        <span class="input-wrapper">
            <input type="text" id="site_city" name="site_city" value="<?=esc_attr( $city )?>" style="width:300px;" class="disabled" />
        </span>
        <?php
    }
    public function display_site_sport_field() {
        $sport = get_option( 'site_sport', '' );
        $sports = array();
        if ( is_multisite() ) {
            switch_to_blog( 1 ); // Switch to the main site to get the sports.
        }
        // get sports from sport post type
        $sports = get_posts( array(
            'post_type'      => 'activity',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'fields'         => 'ids', // Only get IDs to reduce memory usage
        ) );
        if ( ! empty( $sports ) && is_array( $sports ) ) {
            $sports = array_combine( $sports, array_map( function( $id ) {
                return get_the_title( $id );
            }, $sports ) );
        } else {
            // Fallback to predefined sports if no posts found
            $sports = array(
                '1' => 'Volleyball',
            );
        }
        if ( is_multisite() ) {
            restore_current_blog(); // Restore the current blog context.
        }

        ?>
        <span class="input-wrapper">
            <select name="site_sport" id="site_sport" style="width:300px;" class="disabled">
                <?php
                foreach ( $sports as $key => $value ) :
                    // selected() is a WordPress helper function to add the 'selected' attribute if values match.
                    $selected = selected( $sport, strtolower($value), false );
                    echo sprintf( '<option value="%s" %s>%s</option>', esc_attr( strtolower($value) ), $selected, esc_html( $value ) );
                endforeach;
                ?>
            </select>
        </span>
        <?php
    }

    /**
     * Custom sanitize callback for the 'Site Sport' field.
     * This ensures that only a value from our predefined list of sports is saved.
     *
     * @param string $input The raw input value submitted from the form.
     * @return string The sanitized and validated value, or an empty string if the input is invalid.
     */
	public function sanitize_site_sport_field( $input ) {
	    // Fetch the valid sports with sanitized keys
	    if ( is_multisite() ) {
	        switch_to_blog( 1 );
	    }
	
	    $sports_posts = get_posts( array(
	        'post_type'      => 'activity',
	        'posts_per_page' => -1,
	        'orderby'        => 'menu_order',
	        'order'          => 'ASC',
	    ) );
	
	    $valid_sports = array();
	    if ( ! empty( $sports_posts ) ) {
	        foreach ( $sports_posts as $post ) {
	            $valid_sports[] = sanitize_title( $post->post_title );
	        }
	    } else {
	        // Fallback
	        $valid_sports[] = 'volleyball';
	    }
	
	    if ( is_multisite() ) {
	        restore_current_blog();
	    }
	
	    // Check if the input is in the array of valid keys
	    if ( in_array( $input, $valid_sports ) ) {
	        return $input;
	    }
	
	    return '';
	}
}
// Instantiate the class
new Subsite_General_Settings();

