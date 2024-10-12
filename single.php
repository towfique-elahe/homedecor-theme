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
    <section id="blog">
        <!-- header -->
        <?php get_header() ?>

        <div class="section-divider"></div>

        <!-- main content -->
        <div class="container">
            <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        
                        get_template_part('template-parts/content', 'article');
                    }
                }
            ?>
        </div>
    </section>

    <?php get_footer() ?>
</body>

</html>