<?php
/*
Template Name: My Account Page
*/

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

// Function to get the title of the current endpoint
function get_current_endpoint_title() {
    $endpoint = WC()->query->get_current_endpoint();

    if (!$endpoint) {
        return get_the_title(get_option('woocommerce_myaccount_page_id'));
    }

    switch ($endpoint) {
        case 'orders':
            return __('Orders', 'woocommerce');
        case 'view-order':
            return __('Order details', 'woocommerce');
        case 'edit-address':
            return __('Addresses', 'woocommerce');
        case 'payment-methods':
            return __('Payment Methods', 'woocommerce');
        case 'edit-account':
            return __('Account Details', 'woocommerce');
        case 'customer-logout':
            return __('Logout', 'woocommerce');
        default:
            return get_the_title(get_option('woocommerce_myaccount_page_id'));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Enqueue Styles -->
    <?php wp_head(); ?>
</head>

<body>
    <?php get_header(); ?>

    <section id="auth">
        <div class="container my-account">
            <div class="row">
                <!-- svg image -->
                <div class="col hero-image">
                    <?php
                        // Define paths
                        $imgSrc = get_template_directory_uri() . '/assets/images/account.svg';
                        $defaultImg = get_template_directory_uri() . '/assets/images/default-banner.jpg';

                        // Check if the login.svg exists
                        $imagePath = file_exists(get_template_directory() . '/assets/images/account.svg') ? $imgSrc : $defaultImg;
                    ?>

                    <!-- HTML with PHP echo to dynamically set src attribute -->
                    <div class="image_container">
                        <img src="<?php echo esc_attr($imagePath); ?>" alt="Account Image">
                    </div>
                </div>

                <!-- main content -->
                <div class="col">
                    <h1 class="section_heading">
                        <?php 
                            echo esc_html(get_current_endpoint_title());
                        ?>
                    </h1>
                    <?php
                        // Display WooCommerce My Account content
                        do_action('woocommerce_account_navigation');
                        do_action('woocommerce_account_content');
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="section_divider"></div>

    <!-- call to action -->
    <section class="auth-cta">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/background.jpeg'; ?>" alt="" class="cta-image">
        <div class="content">
            <h3 class="cta-heading">Welcome to Our Website</h3>
            <p class="cta-para">Join us today to enjoy exclusive benefits and more.</p>
            <a href="<?php echo home_url('/shop'); ?>" class="cta-button">Shop Now!</a>
        </div>
    </section>

    <?php get_footer(); ?>
</body>
</html>
