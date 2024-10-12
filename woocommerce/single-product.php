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
        <?php
          // woocommerce breadcrumbs
          do_action('woocommerce_before_main_content');
        ?>
      </div>
    </section>

    <!-- woocommerce single product -->
    <section id="wooSingleProduct">
      <!-- main content -->
      <div class="container">
        <?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

          <?php
            while ( have_posts() ) :
              the_post();
              // Product gallery and summary
              ?>
              <div class="product">
                <div class="product-gallery">
                  <?php
                    do_action( 'woocommerce_before_single_product_summary' ); // Hook for product gallery
                  ?>
                </div>
                <div class="product-summary">
                  <?php
                    do_action( 'woocommerce_single_product_summary' ); // Hook for product summary
                  ?>
                </div>
              </div>
              <?php
            endwhile; // end of the loop.
          ?>

        <div class="product-secondary">
          <?php
            // Reviews and related products
            do_action( 'woocommerce_after_single_product_summary' );
            do_action( 'woocommerce_after_main_content' );
          ?>
        </div>

      </div>
    </section>

    <div class="section-divider"></div>

    <?php get_footer(); ?>
  </body>
</html>
