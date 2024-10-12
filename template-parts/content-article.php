<article class="blog-article">

    <h1 class="blog-title">
        <?php the_title(); ?>
    </h1>

    <p class="blog-date">Published on <?php echo get_the_date('d M, Y'); ?></p>
    <?php homedecor_breadcrumbs(); ?>

    <?php
        $thumbnail_url = get_the_post_thumbnail_url();
        if ($thumbnail_url) {
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr(get_the_title()) . '" class="blog-banner">';
        } else {
            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/default-banner.jpg') . '" alt="Default Image" class="blog-banner">';
        }
    ?>

    <div class="blog-content">
        <?php the_content(); ?>
    </div>

</article>