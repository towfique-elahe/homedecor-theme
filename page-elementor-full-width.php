<?php
/* Template Name: Elementor Full Width */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <!-- header -->
    <?php get_header(); ?>

    <!-- main content -->
    <div id="content" class="elementor-full-width">
        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        ?>
    </div>

    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>
</html>
