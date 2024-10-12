<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Enqueue Styles -->
    <?php
		wp_head();
    ?>
  </head>

  <body>
    <!-- header -->
    <?php get_header() ?>

	<section id="wooPageHead">
		<div class="container">
			<?php
				// woocommerce breadcrumbs
				do_action( 'woocommerce_before_main_content' );
				// woocommerce header
				do_action( 'woocommerce_shop_loop_header' );
			?>
              <nav class="carousel woocommerce-subcategories">
				<?php
					// get current category
					$term = get_queried_object();
					// get subcategories of the current category.
					$args = array(
						'parent' => $term->term_id,
						'taxonomy' => 'product_cat',
						'hide_empty' => false,
					);
					$subcategories = get_terms($args);
					// display the subcategories
					if ( ! empty($subcategories) && ! is_wp_error($subcategories) ) {
						foreach ($subcategories as $subcategory) {
							$subcategory_link = esc_url(get_term_link($subcategory));
							$thumbnail_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true); // corrected get_term_meta usage
							$image_url = $thumbnail_id ? esc_url(wp_get_attachment_image_url($thumbnail_id, 'thumbnail')) : esc_url(get_template_directory_uri() . '/assets/images/default-banner.jpg');
							$subcategory_name = esc_html($subcategory->name);
							$subcategory_name_attr = esc_attr($subcategory->name);
							echo '<a class="carousel-item woocommerce-subcategory" href="' . $subcategory_link . '">';
							echo '    <div class="image_container">';
							echo '        <img src="' . $image_url . '" alt="' . $subcategory_name_attr . '">';
							echo '    </div>';
							echo '    <h4 class="cat_name">' . $subcategory_name . '</h4>';
							echo '</a>';
						}
					}
				?>
              </nav>	
		</div>
	</section>

    <!-- woocommerce shop page -->
    <section id="wooShop">
		<div class="container">
			<!-- Sidebar for filters -->
				<?php if (is_active_sidebar('product-filters-sidebar')) : ?>
					<aside id="secondary" class="widget-area sidebar-filter">
						<?php dynamic_sidebar('product-filters-sidebar'); ?>
					</aside>
				<?php endif; ?>

			<!-- main content -->
			<div class="main">
				<?php
					if ( woocommerce_product_loop() ) {

						do_action( 'woocommerce_before_shop_loop' );

						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						do_action( 'woocommerce_after_shop_loop' );

					} else {

						do_action( 'woocommerce_no_products_found' );
					}

					do_action( 'woocommerce_after_main_content' );
				?>
			</div>
		</div>
    </section>

    <div class="section-divider"></div>

    <?php get_footer() ?>

	<!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Slick Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

	<script>
		// carousel
        $(".carousel").slick({
          infinite: true,
          slidesToShow: 6,
          slidesToScroll: 2,
          autoplay: true,
          autoplaySpeed: 3000,
		  arrows: false,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 6,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: false,
              },
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              },
            },
          ],
        });
	</script>
  </body>
</html>
