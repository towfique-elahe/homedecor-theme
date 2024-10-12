<?php
// Registering Advanced Settings Page in WP Dashboard
function homedecor_add_advanced_settings_menu() {
    add_submenu_page(
        'homedecor_settings',       // Parent slug
        'Advance Options',        // Page title
        'Advance Options',        // Menu title
        'manage_options',           // Capability
        'homedecor-advanced-options', // Menu slug
        'homedecor_advanced_settings_page' // Function to display the page content
    );
}
add_action('admin_menu', 'homedecor_add_advanced_settings_menu');

// Register Settings for Advanced Settings Page
function homedecor_register_advanced_settings() {
    register_setting('homedecor_advanced_settings_group', 'homedecor_watermark');
    register_setting('homedecor_advanced_settings_group', 'homedecor_webp_conversion');
    register_setting('homedecor_advanced_settings_group', 'disable_attribute_urls'); // Add this line for the attribute option
}
add_action('admin_init', 'homedecor_register_advanced_settings');

// Display the Advanced Settings Page
function homedecor_advanced_settings_page() {
    ?>
    <div class="wrap">
        <h1>Advanced Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('homedecor_advanced_settings_group'); ?>
            <?php do_settings_sections('homedecor_advanced_settings'); ?>
            <table class="form-table">
                <!-- Watermarking -->
                <tr valign="top">
                    <th scope="row">Enable Watermarking</th>
                    <td>
                        <?php $watermark_enabled = get_option('homedecor_watermark', ''); ?>
                        <input type="checkbox" name="homedecor_watermark" value="1" <?php checked(1, $watermark_enabled, true); ?>>
                        <label for="homedecor_watermark">Add watermark to uploaded images</label>
                    </td>
                </tr>

                <!-- WebP Conversion -->
                <tr valign="top">
                    <th scope="row">Enable WebP Conversion</th>
                    <td>
                        <?php $webp_conversion = get_option('homedecor_webp_conversion', ''); ?>
                        <input type="checkbox" name="homedecor_webp_conversion" value="1" <?php checked(1, $webp_conversion, true); ?>>
                        <label for="homedecor_webp_conversion">Convert uploaded images to WebP format</label>
                    </td>
                </tr>

                <!-- Disable Attribute URLs -->
                <tr valign="top">
                    <th scope="row">Disable Attribute Term URLs</th>
                    <td>
                        <?php $disable_attribute_urls = get_option('disable_attribute_urls', ''); ?>
                        <input type="checkbox" name="disable_attribute_urls" value="1" <?php checked(1, $disable_attribute_urls, true); ?>>
                        <label for="disable_attribute_urls">Disable URLs for attribute terms</label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
