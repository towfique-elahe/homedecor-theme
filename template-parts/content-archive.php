<div class="blog">
    <img src="<?php the_post_thumbnail_url('thumbnail') ?>" alt="" class="blog-img">
    <p class="blog-date">
        <?php
            $post_date = get_the_date('d M');
            echo $post_date;
        ?>
    </p>
    <div class="blog-content">
        <h3 class="blog-title">
            <?php the_title() ?>
        </h3>
        <p class="blog-summary">
            <?php the_excerpt() ?>
        </p>
        <a href="<?php the_permalink() ?>" class="blog-link">see more ...</a>
    </div>
</div>