<?php
/*
Template Name: Forgot Password
*/

if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
    exit;
}

$error_message = '';
$success_message = '';

if (isset($_POST['submit_forgot_password'])) {
    $user_email = sanitize_email($_POST['user_email']);

    if (!email_exists($user_email)) {
        $error_message = 'No account found with that email address.';
    } else {
        // Send reset password email
        $user = get_user_by('email', $user_email);
        $reset_key = get_password_reset_key($user);

        if (!is_wp_error($reset_key)) {
            $reset_link = network_site_url("wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($user->user_login), 'login');

            // Send email
            $message = "Someone requested a password reset for the following account: " . "\r\n\r\n";
            $message .= network_site_url() . "\r\n\r\n";
            $message .= "Username: " . $user->user_login . "\r\n\r\n";
            $message .= "If this was a mistake, just ignore this email and nothing will happen.\r\n\r\n";
            $message .= "To reset your password, visit the following address:\r\n\r\n";
            $message .= '<' . $reset_link . ">\r\n";

            wp_mail($user_email, 'Password Reset Request', $message);

            $success_message = 'Check your email for the password reset link.';
        } else {
            $error_message = 'Unable to send reset link. Please try again later.';
        }
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
    <?php
    // Load header
    get_header();
    ?>

    <section id="auth">
        <div class="container">
            <div class="row">
                <!-- svg image -->
                <div class="col hero-image">
                    <?php
                    // Define paths
                    $imgSrc = get_template_directory_uri() . '/assets/images/forgot-password.svg';
                    $defaultImg = get_template_directory_uri() . '/assets/images/default-banner.jpg';

                    // Check if the forgot-password.svg exists
                    $imagePath = file_exists(get_template_directory() . '/assets/images/forgot-password.svg') ? $imgSrc : $defaultImg;
                    ?>

                    <!-- HTML with PHP echo to dynamically set src attribute -->
                    <div class="image_container">
                        <img src="<?php echo esc_attr($imagePath); ?>" alt="Forgot Password Image">
                    </div>
                </div>

                <!-- main content -->
                <div class="col main">
                    <div class="card">
                        <h1 class="section_heading">Forgot Password</h1>
                        <?php if ($error_message): ?>
                            <div class="error_message"><?php echo esc_html($error_message); ?></div>
                        <?php endif; ?>
                        <?php if ($success_message): ?>
                            <div class="success_message"><?php echo esc_html($success_message); ?></div>
                        <?php endif; ?>
                        <form method="post" id="forgot-password-form" class="auth-form">
                            <div class="form-group">
                                <label for="user_email">Email Address</label>
                                <input type="email" id="user_email" name="user_email" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit_forgot_password" class="btn">Reset Password</button>
                            </div>
                            <div class="form-group">
                                <p class="redirect">Remembered your password? <a href="<?php echo home_url('/index.php/login'); ?>">Login</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="auth-cta">
        <img src="<?php echo get_template_directory_uri() . '/assets/images/background.jpeg'; ?>" alt="" class="cta-image">
        <div class="content">
            <h3 class="cta-heading">Reset Your Password</h3>
            <p class="cta-para">Enter your email address to receive a password reset link.</p>
        </div>
    </section>

    <?php get_footer(); ?>
</body>
</html>
