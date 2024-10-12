<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Enqueue Styles -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- header -->
    <?php get_header(); ?>

    <section id="wooPageHead">
        <div class="container">
            <?php do_action('woocommerce_before_main_content'); // WooCommerce breadcrumbs ?>
        </div>
    </section>

    <!-- woocommerce single product -->
    <section id="wooSingleProduct">
        <!-- main content -->
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
                <div class="product">

                    <div class="product-gallery">
                        <?php do_action('woocommerce_before_single_product_summary'); // Product gallery ?>
                    </div>

                    <div class="col">
                        <div class="product-summary">
                            <?php do_action('woocommerce_single_product_summary'); // Product summary ?>
                        </div>

                        <!-- Linked Products Carousel -->
                        <?php
                        global $product;
                        $linked_products = $product->get_upsell_ids();

                        if (!empty($linked_products)) {
                            ?>
                            <nav class="carousel linked-products">
                                <?php
                                $args = array(
                                    'post_type' => 'product',
                                    'posts_per_page' => -1,
                                    'post__in' => $linked_products
                                );

                                $linked_query = new WP_Query($args);

                                if ($linked_query->have_posts()) {
                                    while ($linked_query->have_posts()) {
                                        $linked_query->the_post();
                                        $product_link = esc_url(get_permalink());
                                        $product_name = esc_html(get_the_title());
                                        $product_name_attr = esc_attr(get_the_title());
                                        $image_id = get_post_thumbnail_id();
                                        $image_url = $image_id ? esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')) : esc_url(get_template_directory_uri() . '/assets/images/default-banner.jpg');

                                        echo '<a class="carousel-item linked-product" href="' . $product_link . '">';
                                        echo '    <div class="image_container">';
                                        echo '        <img src="' . $image_url . '" alt="' . $product_name_attr . '">';
                                        echo '    </div>';
                                        echo '    <h4 class="product_name">' . $product_name . '</h4>';
                                        echo '</a>';
                                    }
                                    wp_reset_postdata();
                                }
                                ?>
                            </nav>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            <?php endwhile; ?>
            
            <div class="product-secondary">
                <?php
                    do_action('woocommerce_after_single_product_summary'); // Reviews and related products
                    do_action('woocommerce_after_main_content'); // Close main content hooks
                ?>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <?php get_footer(); ?>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Slick Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

	<script>
		// carousel
        $(".carousel").slick({
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 3000,
		  arrows: false,
        });
	</script>
</body>
</html>
