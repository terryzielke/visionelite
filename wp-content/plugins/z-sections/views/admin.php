<div class="z-template-page-builder-settings-wrapper zielke">
<h1>Sections Page Builder Settings</h1>

<form method="post" action="options.php">
<?php
// select settings group
settings_fields( 'z_sections_settings' );
do_settings_sections( 'z_sections_settings' );

// get current settings
$z_sections_css = esc_attr( get_option('z_sections_css'));
$z_sections_js = esc_attr( get_option('z_sections_js'));
$z_sections_wysiwyg =  get_option('z_sections_wysiwyg');
?>
	
<div class="break clear"></div>

<div>
    <h3>Disable Plugin CSS and JS</h3>
    <!-- checkbox for enabling plugin CSS -->
    <label for="z_sections_css">
        <input type="checkbox" id="z_sections_css" name="z_sections_css" value="1" <?php checked( $z_sections_css, '1' ); ?> />
        Disable Plugin CSS
    </label>
    <!-- checkbox for enabling plugin JS -->
    <label for="z_sections_js">
        <input type="checkbox" id="z_sections_js" name="z_sections_js" value="1" <?php checked( $z_sections_js, '1' ); ?> />
        Disable Plugin JS
    </label>
</div>

<div>
    <h3>Sections Documentation</h3>
    <h4>Bootstrap Gutter Spacing Classes</h4>
    <p>Use the following classes to control the gutter spacing between columns:</p>
    <ul>
        <li><code>gx-0</code> - No gutter</li>
        <li><code>gx-1</code> - 0.25rem gutter</li>
        <li><code>gx-2</code> - 0.5rem gutter</li>
        <li><code>gx-3</code> - 1rem gutter</li>
        <li><code>gx-4</code> - 1.5rem gutter</li>
        <li><code>gx-5</code> - 3rem gutter</li>
    </ul>
    <p>These classes can be added to the section element to control the spacing between columns.</p>

    <h4>Full Viewer Width</h4>
    <p>To make a section full viewer width, add the class <code>full-viewer-width</code> to the section element. This will allow the section to extend the full width of the viewport, ignoring the default container padding.</p>
</div>

<div>
    <h3>Custom Documentation</h3>
    <p>Place any documentation concerning custom id or class ussage here.</p>
    <?php
    // WYSIWYG editor for custom documentation
    $editor_settings = array(
        'textarea_name' => 'z_sections_wysiwyg',
        'media_buttons' => false,
        'teeny' => true,
        'quicktags' => false,
        'wpautop' => true,
        'textarea_rows' => 20,
    );
    wp_editor( $z_sections_wysiwyg, 'z_sections_wysiwyg', $editor_settings );
    ?>
</div>

	
<div class="break clear"></div>

<?php submit_button('Save','primary','z_sections_save_button'); ?>

</form>
</div>
<style>
    h3{
        margin-top: 40px;
    }
    h4{
        margin-top: 20px;
    }
</style>