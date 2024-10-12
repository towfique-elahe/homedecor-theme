<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enqueue Styles -->
    <?php
		wp_head();
    ?>
</head>

<body>
    <!-- blog -->
    <section id="archiveBlog">
        <!-- header -->
        <?php get_header() ?>

        <div class="section-divider"></div>

        <!-- main content -->
        <div class="container">
            <h1 class="heading">
                <?php
                    if (is_home()) {
                        echo get_the_title(get_option('page_for_posts'));
                    } else {
                        echo get_the_title();
                    }
                ?>
            </h1>

            <div class="blogs">
                <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            
                            get_template_part('template-parts/content', 'archive');
                        }
                    } else {
                        echo "No news and events are available";
                    }
                ?>
            </div>

            <?php the_posts_pagination(); ?>
        </div>
    </section>

    <?php get_footer() ?>
</body>

</html>