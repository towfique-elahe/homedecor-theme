<div class="blog">
    <div class="row">

        <div class="col">
            <div class="image_container">
                <?php if (has_post_thumbnail()) : ?>
                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="blog-img">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-banner.jpg" alt="Default Image" class="blog-img">
                <?php endif; ?>
            </div>
        </div>

        <div class="col blog-content">
            <h3 class="blog-title">
                <?php the_title() ?>
            </h3>
            <p class="blog-date">
                <?php
                    $post_date = get_the_date('d M, Y');
                    echo $post_date;
                ?>
            </p>
            <div class="blog-summary">
                <?php the_excerpt(); ?>
            </div>
            <a href="<?php the_permalink() ?>" class="blog-link">View Post</a>
        </div>

    </div>
</div>