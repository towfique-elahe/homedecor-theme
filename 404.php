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

    <div class="section_divider"></div>

    <!-- page -->
    <section id="error404">
        <!-- main content -->
        <div class="container">
            <h1 class="heading">
                404 - Page Not Found
            </h1>
            <p class="para">
                We're sorry, but the page you are looking for cannot be found.
            </p>
            <p class="para">
                Please check the URL for errors or navigate to the <a
                    href="<?php echo esc_url(home_url('/')); ?>">homepage</a>.
            </p>
        </div>
    </section>

    <div class="section_divider"></div>

    <?php get_footer() ?>
</body>

</html>