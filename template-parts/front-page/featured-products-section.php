<section id="featuredProducts">
    <div class="container col">
        <div class="row head">
            <h3 class="section_heading">Featured Products</h3>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="link">View Shop <ion-icon name="arrow-forward-outline"></ion-icon></a>
        </div>
        <hr class="line">
        <div class="carousel-container">
            <div class="carousel featured-products-carousel">
                <?php
                // Get featured product IDs
                $featured_product_ids = wc_get_featured_product_ids();

                if (!empty($featured_product_ids)) {
                    $featured_products_args = array(
                        'post_type' => 'product',
                        'post__in' => $featured_product_ids,
                        'posts_per_page' => 10, // Adjust as needed
                        'orderby' => 'post__in', // Maintain the order of the selected products
                    );

                    $featured_products_query = new WP_Query($featured_products_args);

                    if ($featured_products_query->have_posts()) {
                        while ($featured_products_query->have_posts()) {
                            $featured_products_query->the_post();
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

                                $regular_price_formatted = wc_price($regular_price_min) . ' - ' . wc_price($regular_price_max);
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
                        wp_reset_postdata(); // Reset post data after custom query
                    } else {
                        echo '<p>No featured products found.</p>';
                    }
                } else {
                    echo '<p>No featured products selected.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</section>
