<section id="recentBlogs">
        <div class="container col">
            <div class="row head">
                <h3 class="section_heading">Recent Blog Post</h3>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="link">View All Posts <ion-icon name="arrow-forward-outline"></ion-icon></a>
            </div>
            <hr class="line">
            <div class="carousel-container">
                <div class="carousel blog-posts-carousel">
                    <?php
                    // Query to fetch the latest 10 blog posts
                    $recent_posts_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 10, // Number of posts to display
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );

                    $recent_posts_query = new WP_Query($recent_posts_args);

                    if ($recent_posts_query->have_posts()) {
                        while ($recent_posts_query->have_posts()) {
                            $recent_posts_query->the_post();

                            // Post details
                            $post_id = get_the_ID();
                            $post_title = get_the_title();
                            $post_link = get_permalink();
                            $post_excerpt = get_the_excerpt();
                            $post_date = get_the_date();
                            $default_image = get_template_directory_uri() . '/assets/images/default-product.jpg';
                            $post_image = has_post_thumbnail() ? get_the_post_thumbnail($post_id, 'thumbnail') : '<img src="' . esc_url($default_image) . '" alt="' . esc_attr($post_title) . '">';

                            // Output HTML
                            ?>
                            <div class="carousel-item">
                                <a href="<?php echo esc_url($post_link); ?>" class="post-link">
                                    <div class="post-info">
                                        <div class="image_container">
                                            <?php echo $post_image; ?>
                                        </div>
                                        <div class="post-details">
                                            <p class="post-date"><?php echo esc_html($post_date); ?></p>
                                            <h4 class="post-title"><?php echo esc_html($post_title); ?></h4>
                                            <p class="post-excerpt"><?php echo esc_html(wp_trim_words($post_excerpt, 20, '...')); ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        wp_reset_postdata(); // Reset post data after custom query
                    } else {
                        echo '<p>No blog posts found.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>