<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enqueue Styles -->
    <?php
		wp_head();
    ?>
    <style>
        #error404 .row {
            align-items: center;
        }
        #error404 .para {
            font-size: 1.2rem;
            font-weight: 500;
        }
        #error404 .nav {
            display: flex;
            gap: 1rem;
            list-style: none;
        }
        #error404 .nav a {
            font-weight: 600;
            padding: 0.5rem 1rem;
            background-color: var(--clr3);
            color: var(--clr2);
            border-radius: .3rem;
            transition: 0.2s ease
        }
        #error404 .nav a:hover,
        #error404 .nav a:active,
        #error404 .nav a:focus {
            background-color: var(--clr2);
            color: var(--clr3);
        }
        @media only screen and (max-width:768px) {
            #error404 .row {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- header -->
    <?php get_header() ?>

    <div class="section_divider"></div>

    <!-- page -->
    <section id="error404">
        <!-- main content -->
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="section_heading">
                        404 - Page Not Found
                    </h1>
                    <p class="para">
                        We're sorry, but the page you are looking for cannot be found.
                    </p>
                    <p class="para">
                        Please check the URL for errors or navigate to -
                    </p>
                    <ul class="nav">
                        <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_shop_page_id'))); ?>">Shop</a></li>
                        <li><a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">Blog</a></li>
                        <li><a href="<?php echo esc_url(wc_get_account_endpoint_url('my-account')); ?>">Account</a></li>
                    </ul>
                </div>
                <div class="col">
                    <?php
                        // Define paths
                        $imgSrc = get_template_directory_uri() . '/assets/images/404.svg';
                        $defaultImg = get_template_directory_uri() . '/assets/images/default-banner.jpg';

                        // Check if the login.svg exists
                        $imagePath = file_exists(get_template_directory() . '/assets/images/404.svg') ? $imgSrc : $defaultImg;
                    ?>
                    <div class="image_container">
                        <img src="<?php echo esc_attr($imagePath); ?>" alt="404 Image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section_divider"></div>

    <?php get_footer() ?>
</body>

</html>