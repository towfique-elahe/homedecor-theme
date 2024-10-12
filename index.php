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
    <!-- header -->
    <?php get_header() ?>

    <!-- blog -->
    <section id="archiveBlog">
        <!-- page heading -->
        <div class="head">
            <div class="container">
                <h1 class="heading">
                    <?php
                        echo get_the_title(get_option('page_for_posts'));
                    ?>
                </h1>
                <?php homedecor_breadcrumbs(); ?>
            </div>
        </div>
        
        <div class="container">
            <!-- main content -->
            <div class="main">
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

            <!-- sidebar -->
            <?php if (is_active_sidebar('blog-archive-sidebar')) : ?>
                <aside id="secondary" class="widget-area sidebar-blog-archive">
                    <?php dynamic_sidebar('blog-archive-sidebar'); ?>
                </aside>
            <?php endif; ?>

        </div>
    </section>

    <?php get_footer() ?>
</body>

</html>