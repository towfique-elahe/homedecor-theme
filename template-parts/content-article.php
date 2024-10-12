<h1 class="blog-title">
    <?php the_title(); ?>
</h1>
<article class="blog-content">
    <p class="blog-date">Published <?php echo get_the_date('d M, Y'); ?></p>

    <?php
        $thumbnail_url = get_the_post_thumbnail_url();
        if ($thumbnail_url) {
            echo '<img src="' . esc_url($thumbnail_url) . '" alt="" class="blog-banner">';
        }
        
        the_content();
    ?>
</article>