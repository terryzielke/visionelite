<?php


// Add a Company Info page under the setttings menu
function add_company_info_page() {
    add_submenu_page(
        'options-general.php',
        'Company Info',
        'Company Info',
        'manage_options',
        'company-info',
        'company_info_page_callback'
    );
}
add_action('admin_menu', 'add_company_info_page');

// Callback function for the Company Info page
function company_info_page_callback() {
    // Check if the user has permission to manage options
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    include_once(get_template_directory() . '/admin/pages/site/views/company-info.php');
}

// Register settings for the Company Info page
function register_company_info_settings() {
    register_setting('company_info_options_group', 'company_info_options');
    add_settings_section(
        'company_info_section',
        'Company Information',
        'company_info_section_callback',
        'company-info'
    );
    add_settings_field(
        'company_email',
        'Contact Email',
        'company_email_callback',
        'company-info',
        'company_info_section'
    );
}
add_action('admin_init', 'register_company_info_settings');

function company_info_section_callback() {
    echo '<p>Update the company information that appears across the site.</p>';
}

function company_email_callback() {
    $options = get_option('company_info_options');
    $company_email = isset($options['company_email']) ? esc_attr($options['company_email']) : '';
    echo '<input type="email" name="company_info_options[company_email]" value="' . $company_email . '" class="regular-text" required />';
}