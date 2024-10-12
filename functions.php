<?php
    // cookies
    if ( !session_id() ) {
        session_start();
    }

    // theme support
    function homedecor_theme_support(){
        add_theme_support('custom-logo');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('woocommerce');
        if ( defined( 'ELEMENTOR_VERSION' ) ) {
            add_theme_support( 'elementor' );
            add_theme_support('elementor-default-kit');
        }       
    }
    add_action('after_setup_theme','homedecor_theme_support');



    // admin settings pages
    require_once get_template_directory() . '/admin/main-settings.php';    // Include the main settings page
    require_once get_template_directory() . '/admin/popup-settings.php';    // Include the promotional popup settings page
    require_once get_template_directory() . '/admin/advance-settings.php';    // Include the advance settings page


    // admin page promotional page image upload
    add_action('admin_enqueue_scripts', 'enqueue_media_uploader');
    function enqueue_media_uploader() {
        wp_enqueue_media();
    }



    // Set default content width for Elementor
    function yourtheme_elementor_content_width() {
        return '1200';
    }
    add_filter('elementor/container/width', 'yourtheme_elementor_content_width');


    // styles
    function homedecor_register_styles() {
        $version = wp_get_theme()->get('Version');
        
        // Enqueue Ionicons CSS
        wp_enqueue_style('ionicons', 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/ionicons.min.css', array(), null);

        // Enqueue your theme styles
        wp_enqueue_style('homedecor-style', get_template_directory_uri() . "/assets/css/theme.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-header', get_template_directory_uri() . "/assets/css/header.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-footer', get_template_directory_uri() . "/assets/css/footer.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-front-page', get_template_directory_uri() . "/assets/css/front-page.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-blogs', get_template_directory_uri() . "/assets/css/blogs.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-woocommerce', get_template_directory_uri() . "/assets/css/woocommerce.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-auth', get_template_directory_uri() . "/assets/css/auth.css", array(), $version, 'all');

        // elementor styles
        wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
            if ( did_action( 'elementor/loaded' ) ) {
                wp_enqueue_style( 'elementor-frontend' );
                wp_enqueue_style( 'elementor-pro-frontend' );
            }
    }
    add_action('wp_enqueue_scripts', 'homedecor_register_styles');


    // js
    function homedecor_register_scripts() {
        // Enqueue jQuery from WordPress core (loaded by default in WordPress)
        wp_enqueue_script('jquery');

        // Enqueue Ionicons JS modules
        wp_enqueue_script('homedecor-ionicon-module', 'https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js', array(), '7.1.0', true);
        wp_enqueue_script('homedecor-ionicon-nonmodule', 'https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js', array(), '7.1.0', true);

        // Enqueue your custom JavaScript files
        wp_enqueue_script('homedecor-js', get_template_directory_uri() . '/assets/js/function.js', array(), '1.0', true);
    }
    add_action('wp_enqueue_scripts', 'homedecor_register_scripts');


    // fetching menus
    function homedecor_register_menus(){
        register_nav_menus(
            array(
                'primary-menu' => __('Primary Menu', 'homedecor'),
                'footer_menu' => __('Footer Menu', 'homedecor'),
            )
        );
    }
    add_action( 'init', 'homedecor_register_menus' );

    // fetching woocommerce prodcut categories
    function get_woocommerce_product_categories() {
        $args = array(
            'taxonomy'   => 'product_cat',
            'orderby'    => 'name',
            'order'      => 'ASC',
            'hide_empty' => false,
        );
        $product_categories = get_terms($args);
        return $product_categories;
    }    


    function homedecor_customize_register($wp_customize) {
        // Add section for social links
        $wp_customize->add_section('homedecor_social_links_section', array(
            'title'    => __('Social Links', 'homedecor'),
            'priority' => 30,
        ));
    
        // Add settings for each social link
        $social_networks = array('facebook', 'twitter', 'youtube', 'linkedin');
        foreach ($social_networks as $network) {
            $wp_customize->add_setting("homedecor_{$network}_link", array(
                'default'   => '',
                'transport' => 'refresh',
            ));
            
            $wp_customize->add_control("homedecor_{$network}_link", array(
                'label'    => ucfirst($network) . ' Link',
                'section'  => 'homedecor_social_links_section',
                'settings' => "homedecor_{$network}_link",
                'type'     => 'url',
            ));
        }

          // Add section for contact emails
        $wp_customize->add_section('homedecor_contact_emails_section', array(
            'title'    => __('Contact Emails', 'homedecor'),
            'priority' => 35,
        ));

        // Add settings for each email address
        $email_fields = array(
            'sales_email'    => 'Sales Email',
            'inquiry_email'  => 'Inquiry Email',
        );
        
        foreach ($email_fields as $field => $label) {
            $wp_customize->add_setting("homedecor_{$field}", array(
                'default'   => '',
                'transport' => 'refresh',
            ));
            
            $wp_customize->add_control("homedecor_{$field}", array(
                'label'    => $label,
                'section'  => 'homedecor_contact_emails_section',
                'settings' => "homedecor_{$field}",
                'type'     => 'email',
            ));
        }
    }
    add_action('customize_register', 'homedecor_customize_register');
    


    


// Handle AJAX request to load category products
function load_category_products() {
    $category_id = intval($_POST['category_id']);

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;

            // Product details
            $product_id = $product->get_id();
            $product_name = $product->get_name();
            $product_link = get_permalink($product_id);
            $product_image = $product->get_image('thumbnail');
            $rating_count = $product->get_rating_count();
            $average_rating = $product->get_average_rating();

            // Get prices
            if ($product->is_type('variable')) {
                $regular_price_min = $product->get_variation_regular_price('min', true);
                $regular_price_max = $product->get_variation_regular_price('max', true);

                if ($regular_price_min === $regular_price_max) {
                    $regular_price_formatted = wc_price($regular_price_min);
                } else {
                    $regular_price_formatted = wc_price($regular_price_min) . ' - ' . wc_price($regular_price_max);
                }
                $sale_price_formatted = ''; // No sale price for variable products
            } else {
                $regular_price_formatted = wc_price($product->get_regular_price());
                $sale_price_formatted = $product->get_sale_price() ? wc_price($product->get_sale_price()) : '';
            }

            // Output HTML
            ?>
            <div class="carousel-item">
                <a href="<?php echo esc_url($product_link); ?>" class="product-link">
                    <div class="product-info">
                        <div class="image_container">
                            <?php echo $product_image; ?>
                        </div>
                        <div class="product-details">
                            <p class="product-category">
                                <?php
                                $product_categories = wp_get_post_terms($product->get_id(), 'product_cat');
                                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                    foreach ($product_categories as $category) {
                                        echo esc_html($category->name) . ' ';
                                    }
                                }
                                ?>
                            </p>
                            <h4 class="product-name"><?php echo esc_html($product_name); ?></h4>
                            <div class="product-meta">
                                <?php if ($average_rating > 0) : ?>
                                    <div class="rating">
                                        <?php echo wc_get_rating_html($average_rating, $rating_count); ?>
                                    </div>
                                <?php endif; ?>
                                <div class="prices">
                                    <?php if ($sale_price_formatted) : ?>
                                        <span class="regular-price"><?php echo ($regular_price_formatted); ?></span>
                                        <span class="sale-price"><?php echo ($sale_price_formatted); ?></span>
                                    <?php else : ?>
                                        <span class="regular-price-solo"><?php echo ($regular_price_formatted); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
    } else {
        echo '<p>No products found in this category.</p>';
    }

    wp_reset_postdata();
    wp_die();
}
add_action('wp_ajax_load_category_products', 'load_category_products');
add_action('wp_ajax_nopriv_load_category_products', 'load_category_products');



    // Register product filters sidebar in widgets
    function register_product_filters_sidebar() {
        register_sidebar(array(
            'name'          => __('Shop Sidebar', 'homedecor'),
            'id'            => 'product-filters-sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    }
    add_action('widgets_init', 'register_product_filters_sidebar');

    // custom loop for shop / category page
    function custom_loop_shop_per_page( $products_per_page ) {
        $products_per_page = 12; // Change this number to the desired amount of products per page
        return $products_per_page;
    }
    add_filter( 'loop_shop_per_page', 'custom_loop_shop_per_page', 20 );


    // register page logic
    function handle_user_registration() {
        if (isset($_POST['submit'])) {
            $email = sanitize_email($_POST['email']);
            $password = sanitize_text_field($_POST['password']);
            $confirm_password = sanitize_text_field($_POST['confirm_password']);
            $captcha_input = sanitize_text_field($_POST['captcha']);

            // Check CAPTCHA
            if ($captcha_input !== $_SESSION['custom_captcha']) {
                $error_message = "CAPTCHA verification failed. Please try again.";
            } elseif (email_exists($email)) {
                $error_message = "Email already exists. Please try another one.";
            } elseif ($password !== $confirm_password) {
                $error_message = "Passwords do not match.";
            } else {
                // Register user
                $username = sanitize_user(current(explode('@', $email)));
                $user_id = wp_create_user($username, $password, $email);

                if (is_wp_error($user_id)) {
                    $error_message = $user_id->get_error_message();
                } else {
                    wp_set_current_user($user_id);
                    wp_set_auth_cookie($user_id);
                    wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
                    exit;
                }
            }

            if ($error_message) {
                wp_redirect(add_query_arg('error_message', urlencode($error_message), wp_get_referer()));
                exit;
            }
        }
    }
    add_action('template_redirect', 'handle_user_registration');


    // register page capcha
    function generate_random_string($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';

        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }

        return $random_string;
    }


    // login page logic
    function handle_user_login() {
        if (isset($_POST['submit_login'])) {
            $username_or_email = sanitize_text_field($_POST['username_or_email']);
            $password = sanitize_text_field($_POST['password']);

            $user = get_user_by('email', $username_or_email);

            if (!$user) {
                $user = get_user_by('login', $username_or_email);
            }

            if ($user && wp_check_password($password, $user->data->user_pass, $user->ID)) {
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID);
                wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
                exit;
            } else {
                $error_message = "Invalid username or password.";
                wp_redirect(add_query_arg('error_message', urlencode($error_message), wp_get_referer()));
                exit;
            }
        }
    }
    add_action('template_redirect', 'handle_user_login');


    // newsletter custom table
    function create_newsletter_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'newsletter_subscribers';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            email varchar(100) NOT NULL,
            subscribed_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY email (email)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
    add_action('after_switch_theme', 'create_newsletter_table');

    // newsletter form submission handler
    function handle_newsletter_form_submission() {
        if (isset($_POST['newsletter_email'])) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'newsletter_subscribers';
            $email = sanitize_email($_POST['newsletter_email']);

            if (is_email($email)) {
                $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE email = %s", $email));

                if ($exists) {
                    $message = "You are already subscribed.";
                    $status = 'error';
                } else {
                    $wpdb->insert($table_name, array('email' => $email));
                    $message = "Thank you for subscribing!";
                    $status = 'success';
                }
            } else {
                $message = "Please enter a valid email address.";
                $status = 'error';
            }

            set_transient('newsletter_form_message', $message, 30);
            set_transient('newsletter_form_status', $status, 30);

            wp_redirect($_SERVER['HTTP_REFERER']);
            exit;
        }
    }
    add_action('admin_post_nopriv_newsletter_subscription', 'handle_newsletter_form_submission');
    add_action('admin_post_newsletter_subscription', 'handle_newsletter_form_submission');



// Add Watermark to Uploaded Images
function add_watermark_to_image($file) {
    // Check if watermarking is enabled
    $watermark_enabled = get_option('homedecor_watermark', false);
    if (!$watermark_enabled) {
        return $file;
    }

    // Check if the uploaded file is an image
    $image_types = array('image/jpeg', 'image/png');
    if (!in_array($file['type'], $image_types)) {
        return $file;
    }

    // Load the image
    $image_path = $file['file'];
    $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

    // Get the site logo URL
    $custom_logo_id = get_theme_mod('custom_logo');
    if (!$custom_logo_id) {
        return $file; // No logo set, exit function
    }
    $logo_url = wp_get_attachment_image_src($custom_logo_id, 'full')[0];
    if (!$logo_url) {
        return $file; // Could not get logo URL, exit function
    }

    // Load the watermark image from the logo URL
    $watermark = imagecreatefromstring(file_get_contents($logo_url));
    if (!$watermark) {
        return $file; // Failed to load watermark image
    }

    // Create image from file
    switch ($image_ext) {
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($image_path);
            break;
        case 'png':
            $image = imagecreatefrompng($image_path);
            break;
        default:
            return $file;
    }
    if (!$image) {
        return $file; // Failed to create image from file
    }

    // Get dimensions of the main image and watermark
    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    // Resize the watermark to a width of 100px, maintaining aspect ratio
    $new_watermark_width = 100;
    $new_watermark_height = ($new_watermark_width / $watermark_width) * $watermark_height;
    $resized_watermark = imagecreatetruecolor($new_watermark_width, $new_watermark_height);

    // Handle transparency for PNG
    if ($image_ext == 'png') {
        imagealphablending($resized_watermark, false);
        imagesavealpha($resized_watermark, true);
        $transparent = imagecolorallocatealpha($resized_watermark, 0, 0, 0, 127);
        imagefill($resized_watermark, 0, 0, $transparent);
    }

    imagecopyresampled($resized_watermark, $watermark, 0, 0, 0, 0, $new_watermark_width, $new_watermark_height, $watermark_width, $watermark_height);
    imagedestroy($watermark); // Free the memory of the old watermark
    $watermark = $resized_watermark;
    $watermark_width = $new_watermark_width;
    $watermark_height = $new_watermark_height;

    // Calculate position for the watermark (bottom right corner)
    $dest_x = $image_width - $watermark_width - 10; // 10px padding from the edge
    $dest_y = $image_height - $watermark_height - 10; // 10px padding from the edge

    // Merge the watermark with the main image
    imagecopy($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

    // Save the watermarked image
    switch ($image_ext) {
        case 'jpeg':
        case 'jpg':
            imagejpeg($image, $image_path);
            break;
        case 'png':
            imagealphablending($image, false);
            imagesavealpha($image, true);
            imagepng($image, $image_path);
            break;
    }

    // Free up memory
    imagedestroy($image);
    imagedestroy($watermark);

    return $file;
}
add_filter('wp_handle_upload', 'add_watermark_to_image', 10, 1);







	// Convert Uploaded Images to WebP
	function convert_image_to_webp($file) {
		// Check if WebP conversion is enabled
		$webp_conversion_enabled = get_option('homedecor_webp_conversion', false);
		if (!$webp_conversion_enabled) {
			return $file;
		}

		// Check if the uploaded file is an image
		$image_types = array('image/jpeg', 'image/png');
		if (!in_array($file['type'], $image_types)) {
			return $file;
		}

		// Load the image
		$image_path = $file['file'];
		$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
		$image_name = pathinfo($image_path, PATHINFO_FILENAME);
		$upload_dir = wp_upload_dir();
		$webp_path = $upload_dir['path'] . '/' . $image_name . '.webp';

		// Create image from file
		switch ($image_ext) {
			case 'jpeg':
			case 'jpg':
				$image = imagecreatefromjpeg($image_path);
				break;
			case 'png':
				$image = imagecreatefrompng($image_path);
				break;
			default:
				return $file;
		}

		// Convert to WebP
		imagewebp($image, $webp_path);
		imagedestroy($image);

		// Add WebP file to Media Library
		$wp_filetype = wp_check_filetype($webp_path);
		$attachment = array(
			'guid'           => $upload_dir['url'] . '/' . basename($webp_path),
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name($image_name),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		$attach_id = wp_insert_attachment($attachment, $webp_path);
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $webp_path);
		wp_update_attachment_metadata($attach_id, $attach_data);

		return $file;
	}
	add_filter('wp_handle_upload', 'convert_image_to_webp');


?>