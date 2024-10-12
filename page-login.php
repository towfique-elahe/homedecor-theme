<?php
/*
Template Name: Login Page
*/

if (is_user_logged_in()) {
    wp_redirect(get_permalink(get_option('woocommerce_myaccount_page_id')));
    exit;
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

        // Handle login errors
        $error_message = '';

        if (isset($_GET['error_message'])) {
            $error_message = sanitize_text_field(wp_unslash($_GET['error_message']));
        }
    ?>

    <section id="auth">
        <div class="container">
            <div class="row">
                <!-- svg image -->
                <div class="col hero-image">
                    <?php
                        // Define paths
                        $imgSrc = get_template_directory_uri() . '/assets/images/login.svg';
                        $defaultImg = get_template_directory_uri() . '/assets/images/default-banner.jpg';

                        // Check if the login.svg exists
                        $imagePath = file_exists(get_template_directory() . '/assets/images/login.svg') ? $imgSrc : $defaultImg;
                    ?>

                    <!-- HTML with PHP echo to dynamically set src attribute -->
                    <div class="image_container">
                        <img src="<?php echo esc_attr($imagePath); ?>" alt="Login Image">
                    </div>
                </div>

                <!-- main content -->
                <div class="col main">
                    <div class="card">
                        <h1 class="section_heading">Login</h1>
                        <?php if ($error_message): ?>
                            <div class="error_message"><?php echo esc_html($error_message); ?></div>
                        <?php endif; ?>
                        <form method="post" id="login-form" class="auth-form">
                            <div class="form-group">
                                <label for="username_or_email">Username or Email</label>
                                <input type="text" id="username_or_email" name="username_or_email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-field">
                                    <input type="password" id="password" name="password" required>
                                    <ion-icon name="eye-outline" class="eye-toggle" toggle-target="#password"></ion-icon>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit_login" class="btn">Login</button>
                            </div>
                            <div class="form-group">
                                <p class="redirect">Don't have an account? <a href="<?php echo home_url('/register'); ?>">Register</a></p>
                                <p class="redirect">Forgot your password? <a href="<?php echo home_url('/reset-password'); ?>">Reset it here</a></p>
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
            <h3 class="cta-heading">Welcome to Our Website</h3>
            <p class="cta-para">Join us today to enjoy exclusive benefits and more.</p>
            <a href="<?php echo home_url('/register'); ?>" class="cta-button">Sign Up Now!</a>
        </div>
    </section>

    <?php get_footer(); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eyeToggles = document.querySelectorAll('.eye-toggle');

            eyeToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('toggle-target');
                    const target = document.querySelector(targetId);
                    this.classList.toggle('active');

                    if (target.type === 'password') {
                        target.type = 'text';
                    } else {
                        target.type = 'password';
                    }
                });
            });
        });
    </script>
</body>
</html>
