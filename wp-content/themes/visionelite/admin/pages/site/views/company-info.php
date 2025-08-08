<?php
// update the company information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['company_info_options'])) {
    $options = array(
        'company_email' => sanitize_email($_POST['company_info_options']['company_email']),
    );
    update_option('company_info_options', $options);
    echo '<div class="updated"><p>Company information updated successfully.</p></div>';
}
?>
<form method="post" action="">
    <?php settings_fields('company_info_options_group'); ?>
    <?php do_settings_sections('company-info'); ?>
    <?php submit_button(); ?>
</form>