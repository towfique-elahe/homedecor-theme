<?php
/*
Template Name: My Account Page
*/

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/index.php/login'));
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
        case 'downloads':
            return __('Downloads', 'woocommerce');
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
    </section>

    <?php get_footer(); ?>
</body>
</html>
