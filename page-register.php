<?php
    /*
    Template Name: Register Page
    */

    session_start(); // Start session

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

        // Handle registration errors
        $error_message = '';

        if (isset($_GET['error_message'])) {
            $error_message = sanitize_text_field(wp_unslash($_GET['error_message']));
        }

        // Generate and store CAPTCHA in session
        $_SESSION['custom_captcha'] = generate_random_string(6); // Adjust length as needed
    ?>

    <section id="auth">
        <div class="container">
            <div class="row">
                <!-- svg image -->
                <div class="col hero-image">
                    <?php
                        // Define paths
                        $imgSrc = get_template_directory_uri() . '/assets/images/register.svg';
                        $defaultImg = get_template_directory_uri() . '/assets/images/default-banner.jpg';

                        // Check if the register.svg exists
                        $imagePath = file_exists(get_template_directory() . '/assets/images/register.svg') ? $imgSrc : $defaultImg;
                    ?>

                    <!-- HTML with PHP echo to dynamically set src attribute -->
                    <div class="image_container">
                        <img src="<?php echo esc_attr($imagePath); ?>" alt="Registration Image">
                    </div>
                </div>

                <!-- main content -->
                <div class="col main">
                    <div class="card">
                        <h1 class="section_heading">Register</h1>
                        <?php if ($error_message): ?>
                            <div class="error_message"><?php echo esc_html($error_message); ?></div>
                        <?php endif; ?>
                        <form method="post" id="registration-form" class="auth-form">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="password-field">
                                    <input type="password" id="password" name="password" required>
                                    <ion-icon name="eye-outline" class="eye-toggle" toggle-target="#password"></ion-icon>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm Password</label>
                                <div class="password-field">
                                    <input type="password" id="confirm_password" name="confirm_password" required>
                                    <ion-icon name="eye-outline" class="eye-toggle" toggle-target="#confirm_password"></ion-icon>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="captcha">CAPTCHA</label>
                                <input type="text" id="captcha" name="captcha" required>
                                <span class="captcha"><?php echo $_SESSION['custom_captcha']; ?></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn">Sign Up</button>
                            </div>
                            <div class="form-group">
                                <p class="redirect">Already have an account? <a href="<?php echo home_url('/index.php/login'); ?>">Login</a></p>
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
            <a href="<?php echo home_url('/index.php/register'); ?>" class="cta-button">Sign Up Now!</a>
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
