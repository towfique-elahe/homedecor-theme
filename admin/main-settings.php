<?php
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