<section id="transform">
    <div class="container">
        <div class="row">
            <!-- Left Side: Title, Description, CTA Button -->
            <div class="col branding-content">
                <h3 class="branding-title section_heading">Transform Your Home with <?php bloginfo('name'); ?></h3>
                <p class="branding-description">Discover the latest trends in home decor and elevate your living space with our exclusive collection. Whether you're looking for modern, classic, or eclectic styles, we have something to suit every taste. Let's turn your house into a home you'll love.</p>
                <a href="<?php echo esc_url(home_url('/index.php/shop')); ?>" class="cta-button">Shop Now</a>
            </div>

            <!-- Right Side: Image -->
            <div class="col branding-image">
                <div class="image_container">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/branding.jpeg'; ?>" alt="Home Decor Branding Image">
                </div>
            </div>
        </div>
    </div>
</section>