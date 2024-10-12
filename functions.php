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
    }
    add_action('after_setup_theme','homedecor_theme_support');

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
        wp_enqueue_style('homedecor-woocommerce', get_template_directory_uri() . "/assets/css/woocommerce.css", array(), $version, 'all');
        wp_enqueue_style('homedecor-auth', get_template_directory_uri() . "/assets/css/auth.css", array(), $version, 'all');
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
    


    // Registering Home Decor Settings in WP Dashboard
    // Add Settings Menu
    function homedecor_add_admin_menu() {
        add_menu_page(
            'Home Decor Settings', // Page title
            'Home Decor',          // Menu title
            'manage_options',      // Capability
            'homedecor_settings',  // Menu slug
            'homedecor_settings_page', // Function to display the page content
            'dashicons-admin-generic', // Icon
            110                     // Position
        );
    }
    add_action('admin_menu', 'homedecor_add_admin_menu');

    // Register Settings
    function homedecor_register_settings() {
        register_setting('homedecor_settings_group', 'homedecor_popular_categories', 'sanitize_callback_function');
        register_setting('homedecor_settings_group', 'homedecor_featured_products', 'sanitize_callback_function');
        register_setting('homedecor_settings_group', 'homedecor_product_categories', 'sanitize_callback_function');
        register_setting('homedecor_settings_group', 'homedecor_testimonials', 'sanitize_testimonials');
        register_setting('homedecor_settings_group', 'homedecor_branding_images', 'sanitize_branding_images');
        register_setting('homedecor_settings_group', 'homedecor_slider_images', 'sanitize_slider_images');
    }
    add_action('admin_init', 'homedecor_register_settings');

    function sanitize_callback_function($input) {
        // Validate and sanitize the input
        return array_map('intval', (array)$input);
    }

    function sanitize_slider_images($input) {
        // Sanitize slider images
        if (is_array($input)) {
            foreach ($input as $key => $slide) {
                $input[$key]['image'] = esc_url_raw($slide['image']);
                $input[$key]['link'] = esc_url_raw($slide['link']);
            }
        }
        return $input;
    }

    function sanitize_branding_images($input) {
        $sanitized = array();
        foreach ($input as $key => $value) {
            $sanitized[$key]['url'] = esc_url_raw($value['url']);
            $sanitized[$key]['link'] = esc_url_raw($value['link']);
        }
        return $sanitized;
    }

    function sanitize_testimonials($input) {
        // Sanitize testimonials
        if (is_array($input)) {
            foreach ($input as $key => $testimonial) {
                $input[$key]['name'] = sanitize_text_field($testimonial['name']);
                $input[$key]['content'] = sanitize_textarea_field($testimonial['content']);
                $input[$key]['image'] = sanitize_text_field($testimonial['image']);
            }
        }
        return $input;
    }



    // Home Decor Settings Page Content in WP Dashboard
    // Settings Page Content
    function homedecor_settings_page() {
        ?>
        <div class="wrap">
            <h1>Home Decor Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields('homedecor_settings_group'); ?>
                <?php do_settings_sections('homedecor_settings_group'); ?>
                <table class="form-table">
                    <!-- hero slider -->
                    <tr valign="top">
                        <th scope="row">Slider Images</th>
                        <td>
                            <?php
                            $slider_images = get_option('homedecor_slider_images', array());
                            ?>
                            <div id="slider-images-fields">
                                <?php
                                foreach ($slider_images as $index => $slide) {
                                    ?>
                                    <div class="slider-image-field">
                                        <input type="text" name="homedecor_slider_images[<?php echo $index; ?>][image]" value="<?php echo esc_attr($slide['image']); ?>" placeholder="Image URL">
                                        <input type="text" name="homedecor_slider_images[<?php echo $index; ?>][link]" value="<?php echo esc_attr($slide['link']); ?>" placeholder="Link URL">
                                        <button type="button" class="remove-slider-image">Remove</button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <button type="button" id="add-slider-image">Add Slider Image</button>
                            <p class="description">Add images and links for the slider.</p>
                        </td>
                    </tr>

                    <!-- branding images -->
                    <tr valign="top">
                        <th scope="row">Branding Images</th>
                        <td>
                            <?php
                            $branding_images = get_option('homedecor_branding_images', array());
                            $branding_images = is_array($branding_images) ? $branding_images : array();
                            ?>
                            <div id="branding-images-fields">
                                <?php
                                for ($i = 0; $i < 2; $i++) {
                                    $url = isset($branding_images[$i]['url']) ? esc_url($branding_images[$i]['url']) : '';
                                    $link = isset($branding_images[$i]['link']) ? esc_url($branding_images[$i]['link']) : '';
                                    ?>
                                    <div class="branding-image-field">
                                        <input type="text" name="homedecor_branding_images[<?php echo $i; ?>][url]" value="<?php echo $url; ?>" placeholder="Image URL" class="regular-text">
                                        <input type="text" name="homedecor_branding_images[<?php echo $i; ?>][link]" value="<?php echo $link; ?>" placeholder="Link URL" class="regular-text">
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <p class="description">Add branding images and their respective links.</p>
                        </td>
                    </tr>

                    <!-- popular categories -->
                    <tr valign="top">
                        <th scope="row">Select Popular Categories</th>
                        <td>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                            ));

                            $selected_categories = get_option('homedecor_popular_categories', array());
                            $selected_categories = is_array($selected_categories) ? $selected_categories : array();

                            if(empty($categories)) {
                                echo 'No categories found.';
                            } else {
                                foreach ($categories as $category) {
                                    ?>
                                    <input type="checkbox" name="homedecor_popular_categories[]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $selected_categories)); ?>>
                                    <?php echo esc_html($category->name); ?><br>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>

                    <!-- featured products -->
                    <tr valign="top">
                        <th scope="row">Select Featured Products</th>
                        <td>
                            <?php
                            $selected_products = get_option('homedecor_featured_products', array());
                            $selected_products = is_array($selected_products) ? $selected_products : array();

                            // WooCommerce product query
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => -1,
                                'orderby' => 'title',
                                'order' => 'ASC'
                            );
                            $products = get_posts($args);
                            ?>
                            <select multiple="multiple" name="homedecor_featured_products[]" style="width: 100%; height: 200px;">
                                <?php
                                foreach ($products as $product) {
                                    $selected = in_array($product->ID, $selected_products) ? 'selected="selected"' : '';
                                    echo '<option value="' . esc_attr($product->ID) . '" ' . $selected . '>' . esc_html($product->post_title) . '</option>';
                                }
                                ?>
                            </select>
                            <p class="description">Press and hold CTRL then select the products.</p>
                        </td>
                    </tr>

                    <!-- browse by category -->
                    <tr valign="top">
                        <th scope="row">Select Categories for Browse by Category</th>
                        <td>
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => false,
                            ));

                            $selected_categories = get_option('homedecor_product_categories', array());
                            $selected_categories = is_array($selected_categories) ? $selected_categories : array();

                            if (empty($categories)) {
                                echo 'No categories found.';
                            } else {
                                foreach ($categories as $category) {
                                    ?>
                                    <input type="checkbox" name="homedecor_product_categories[]" value="<?php echo esc_attr($category->term_id); ?>" <?php checked(in_array($category->term_id, $selected_categories)); ?>>
                                    <?php echo esc_html($category->name); ?><br>
                                    <?php
                                }
                            }
                            ?>
                            <p class="description">Select the categories to show as tab in browse by category.</p>
                        </td>
                    </tr>

                    <!-- testimonials -->
                    <tr valign="top">
                        <th scope="row">Testimonials</th>
                        <td>
                            <?php
                            $testimonials = get_option('homedecor_testimonials', array());
                            $testimonials = is_array($testimonials) ? $testimonials : array();
                            ?>
                            <div id="testimonial-fields">
                                <?php
                                foreach ($testimonials as $index => $testimonial) {
                                    ?>
                                    <div class="testimonial-field">
                                        <input type="text" name="homedecor_testimonials[<?php echo $index; ?>][name]" value="<?php echo esc_attr($testimonial['name']); ?>" placeholder="Name">
                                        <textarea name="homedecor_testimonials[<?php echo $index; ?>][content]" placeholder="Testimonial"><?php echo esc_textarea($testimonial['content']); ?></textarea>
                                        <input type="text" name="homedecor_testimonials[<?php echo $index; ?>][image]" value="<?php echo esc_attr($testimonial['image']); ?>" placeholder="Image URL">
                                        <button type="button" class="remove-testimonial">Remove</button>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <button type="button" id="add-testimonial">Add Testimonial</button>
                            <p class="description">Add customer testimonials to display on the home page.</p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>

        <!-- Slider Images Functionality -->
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const addSliderImageButton = document.getElementById('add-slider-image');
                const sliderImagesFields = document.getElementById('slider-images-fields');

                addSliderImageButton.addEventListener('click', function() {
                    const index = sliderImagesFields.children.length;
                    const fieldHTML = `
                        <div class="slider-image-field">
                            <input type="text" name="homedecor_slider_images[${index}][image]" placeholder="Image URL">
                            <input type="text" name="homedecor_slider_images[${index}][link]" placeholder="Link URL">
                            <button type="button" class="remove-slider-image">Remove</button>
                        </div>`;
                    sliderImagesFields.insertAdjacentHTML('beforeend', fieldHTML);
                });

                sliderImagesFields.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-slider-image')) {
                        event.target.parentElement.remove();
                    }
                });
            });
        </script>

        <!-- testimonial functionality -->
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                const addTestimonialButton = document.getElementById('add-testimonial');
                const testimonialFields = document.getElementById('testimonial-fields');

                addTestimonialButton.addEventListener('click', function() {
                    const index = testimonialFields.children.length;
                    const fieldHTML = `
                        <div class="testimonial-field">
                            <input type="text" name="homedecor_testimonials[${index}][name]" placeholder="Name">
                            <textarea name="homedecor_testimonials[${index}][content]" placeholder="Testimonial"></textarea>
                            <input type="text" name="homedecor_testimonials[${index}][image]" placeholder="Image URL">
                            <button type="button" class="remove-testimonial">Remove</button>
                        </div>`;
                    testimonialFields.insertAdjacentHTML('beforeend', fieldHTML);
                });

                testimonialFields.addEventListener('click', function(event) {
                    if (event.target.classList.contains('remove-testimonial')) {
                        event.target.parentElement.remove();
                    }
                });
            });
        </script>
        <?php
    }


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
                $regular_price = $product->get_regular_price();
                $sale_price = $product->get_sale_price();
                $rating_count = $product->get_rating_count();
                $average_rating = $product->get_average_rating();
                $discount_percent = 0;

                // Calculate discount percent if on sale
                if ($sale_price && $regular_price && $regular_price > 0) {
                    $discount_percent = (($regular_price - $sale_price) / $regular_price) * 100;
                }

                // Format prices using WooCommerce price functions
                $regular_price_formatted = wc_price($product->get_regular_price());
                $sale_price_formatted = wc_price($product->get_sale_price());

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
                                        <?php if ($sale_price) : ?>
                                            <span class="regular-price"><?php echo ($regular_price_formatted); ?></span>
                                            <span class="sale-price"><?php echo ($sale_price_formatted); ?></span>
                                            <span class="discount-percent"><?php echo sprintf('-%.0f%%', $discount_percent); ?></span>
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
            'name'          => __('Product Filters', 'your-theme-textdomain'),
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



?>