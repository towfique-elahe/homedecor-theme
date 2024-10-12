<?php
// Register a custom settings page for the promotional popup
add_action('admin_menu', 'register_promo_popup_settings_page');

function register_promo_popup_settings_page() {
    add_submenu_page(
        'homedecor_settings',
        'Promotional Popup Settings',
        'Promotional Popup',
        'manage_options',
        'homedecor-promotional-popup-settings',
        'promo_popup_settings_page'
    );
}

// Render the settings page content
function promo_popup_settings_page() {
    ?>
    <div class="wrap">
        <h1>Promotional Popup Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('promo_popup_settings_group');
            do_settings_sections('promo-popup-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register settings, sections, and fields
add_action('admin_init', 'register_promo_popup_settings');

function register_promo_popup_settings() {
    register_setting('promo_popup_settings_group', 'promo_popup_title');
    register_setting('promo_popup_settings_group', 'promo_popup_message');
    register_setting('promo_popup_settings_group', 'promo_popup_button_text');
    register_setting('promo_popup_settings_group', 'promo_popup_button_link');
    register_setting('promo_popup_settings_group', 'promo_popup_image');
    register_setting('promo_popup_settings_group', 'promo_popup_delay');
    register_setting('promo_popup_settings_group', 'promo_popup_duration');
    register_setting('promo_popup_settings_group', 'promo_popup_once_per_session');

    add_settings_section('promo_popup_main_section', '', null, 'promo-popup-settings');

    add_settings_field('promo_popup_title', 'Popup Title', 'promo_popup_title_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_message', 'Popup Message', 'promo_popup_message_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_button_text', 'Button Text', 'promo_popup_button_text_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_button_link', 'Button Link', 'promo_popup_button_link_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_image', 'Popup Image', 'promo_popup_image_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_delay', 'Popup Delay (seconds)', 'promo_popup_delay_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_duration', 'Popup Duration (seconds)', 'promo_popup_duration_callback', 'promo-popup-settings', 'promo_popup_main_section');
    add_settings_field('promo_popup_once_per_session', 'Show Once Per Session', 'promo_popup_once_per_session_callback', 'promo-popup-settings', 'promo_popup_main_section');
}

// Callback functions for each setting field
function promo_popup_title_callback() {
    $value = get_option('promo_popup_title', 'Summer Sale: 20% Off Home Decor!');
    echo '<input type="text" name="promo_popup_title" value="' . esc_attr($value) . '" style="width: 100%;">';
}

function promo_popup_message_callback() {
    $value = get_option('promo_popup_message', 'Transform your home with our stunning decor pieces. Use code <strong>SUMMER20</strong> at checkout. Offer ends soon!');
    echo '<textarea name="promo_popup_message" rows="5" style="width: 100%;">' . esc_textarea($value) . '</textarea>';
}

function promo_popup_button_text_callback() {
    $value = get_option('promo_popup_button_text', 'Shop Now');
    echo '<input type="text" name="promo_popup_button_text" value="' . esc_attr($value) . '" style="width: 100%;">';
}

function promo_popup_button_link_callback() {
    $value = get_option('promo_popup_button_link', '/shop');
    echo '<input type="url" name="promo_popup_button_link" value="' . esc_attr($value) . '" style="width: 100%;">';
}

function promo_popup_image_callback() {
    $image_url = get_option('promo_popup_image', '');
    ?>
    <input type="text" id="promo_popup_image" name="promo_popup_image" value="<?php echo esc_attr($image_url); ?>" style="width: 80%;" />
    <input type="button" id="promo_popup_image_button" class="button" value="Upload Image" />
    <script>
        jQuery(document).ready(function($){
            $('#promo_popup_image_button').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    multiple: false
                }).open()
                .on('select', function() {
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#promo_popup_image').val(image_url);
                });
            });
        });
    </script>
    <?php
}

function promo_popup_delay_callback() {
    $value = get_option('promo_popup_delay', 3); // Default delay 3 seconds
    echo '<input type="number" name="promo_popup_delay" value="' . esc_attr($value) . '" style="width: 100%;" min="0">';
}

function promo_popup_duration_callback() {
    $value = get_option('promo_popup_duration', 10); // Default duration 10 seconds
    echo '<input type="number" name="promo_popup_duration" value="' . esc_attr($value) . '" style="width: 100%;" min="0">';
}

function promo_popup_once_per_session_callback() {
    $value = get_option('promo_popup_once_per_session', 0); // Default is unchecked (false)
    echo '<input type="checkbox" name="promo_popup_once_per_session" value="1"' . checked(1, $value, false) . '> Show popup only once per session';
}
