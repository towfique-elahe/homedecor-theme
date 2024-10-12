<!-- footer branding section -->
 <section id="footerBranding">
  <div class="container">
    <div class="row">
      <div class="col">
        <!-- site name -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="title">
          <?php bloginfo('name'); ?>.
        </a>
        <p class="sub-title">
          Elevate Your Home's Aesthetic
        </p>
      </div>
      <div class="col">
        <p class="description">
          Discover the perfect blend of style and comfort with our curated collection of home decor items. From modern minimalism to classic elegance, we offer designs that cater to every taste. Transform your living spaces into a sanctuary of beauty and sophistication.
        </p>
        <a href="<?php echo esc_url(home_url('/shop')); ?>" class="button">
          Explore Our Collection <ion-icon name="arrow-forward-outline"></ion-icon>
        </a>
      </div>
    </div>
  </div>
 </section>



<!-- footer -->
<footer id="footer">
  <div class="container">
    <!-- call to action -->
    <div class="row">

    </div>

    <!-- main -->
    <div class="row">
      <!-- get in touch column -->
      <div class="col">
        <h4 class="heading">get in touch</h4>
        <ul class="list">
          <li>
            <span>For Sales:</span>
            <a
              href="mailto:<?php echo esc_attr(get_theme_mod('homedecor_sales_email')); ?>"
            >
              <?php echo esc_html(get_theme_mod('homedecor_sales_email')); ?>
            </a>
          </li>
          <li>
            <span>For Inquiry:</span>
            <a
              href="mailto:<?php echo esc_attr(get_theme_mod('homedecor_inquiry_email')); ?>"
            >
              <?php echo esc_html(get_theme_mod('homedecor_inquiry_email')); ?>
            </a>
          </li>
        </ul>
        <div class="social">
          <?php 
                    $social_networks = array(
                        'facebook' =>
          'logo-facebook', 'twitter' => 'logo-twitter', 'youtube' =>
          'logo-youtube', 'linkedin' => 'logo-linkedin', ); foreach
          ($social_networks as $network => $icon) { $url =
          get_theme_mod("homedecor_{$network}_link"); if ($url) { echo '<a
            href="' . esc_url($url) . '"
            class="link"
            target="_blank"
            rel="noopener noreferrer"
            >'; echo '<ion-icon name="' . $icon . '"></ion-icon>'; echo '</a
          >'; } } ?>
        </div>
      </div>

      <!-- useful links column -->
      <div class="col">
        <h4 class="heading">useful links</h4>
        <?php
                wp_nav_menu( array(
                    'theme_location' =>
        'footer_menu', 'container' => false, 'menu_class' => 'list',
        'fallback_cb' => false, 'depth' => 1, ) ); ?>
      </div>

      <!-- newsletter column -->
      <div class="col">
          <h4 class="heading">Newsletter</h4>
          <div id="newsletter_form">
              <form action="<?php echo esc_url(admin_url('admin-post.php#newsletter_form')); ?>" method="post" class="newsletter" id="newsletter_form">
                  <input type="hidden" name="action" value="newsletter_subscription">
                  <div class="email">
                      <ion-icon name="mail-outline"></ion-icon>
                      <input type="email" name="newsletter_email" id="newsletter_email" placeholder="Your email address" required />
                  </div>
                  <button type="submit" class="btn">Subscribe</button>
              </form>
          </div>
          <p class="para">
              Subscribe to our Newsletter to receive early discounts offers, latest news, sales and promo information.
          </p>
          <?php if ($message = get_transient('newsletter_form_message')): ?>
              <div class="newsletter-message <?php echo esc_attr(get_transient('newsletter_form_status')); ?>">
                  <?php echo esc_html($message); ?>
              </div>
              <?php delete_transient('newsletter_form_message'); ?>
              <?php delete_transient('newsletter_form_status'); ?>
          <?php endif; ?>
      </div>

    </div>

    <hr />

    <p class="copyright">
      &copy; 2023 - 
      <?php echo date('Y'); ?>
      <a href="<?php echo esc_url(home_url('/')); ?>">
        <span class="site-title"><?php bloginfo('name'); ?></span>
      </a>
      all rights reserved | Powered by
      <a href="https://siscotek.com/">SISCOTEK</a>
    </p>
  </div>
</footer>

<?php
  // Include the popup template part from the template-parts directory
  get_template_part('template-parts/popup');
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const starRating = document.querySelector('.woocommerce-product-rating .star-rating span');
    const ratingValue = 4.5; // Example rating value

    if (starRating) {
        const percentage = (ratingValue / 5) * 100; // Calculate percentage
        starRating.style.width = percentage + '%'; // Apply width dynamically
    }
});
</script>

<script>
// Select all submenu links with a data-target attribute
const submenuLinks = document.querySelectorAll('.sub-submenu-link[data-target]');

// Add event listeners to each submenu link
submenuLinks.forEach(link => {
  link.addEventListener('mouseenter', (event) => {
    // Hide all dropright menus
    document.querySelectorAll('.dropright').forEach(dropright => {
      dropright.style.display = 'none';
    });

    // Get the target dropright menu and display it
    const targetId = event.target.getAttribute('data-target');
    const targetMenu = document.getElementById(targetId);
    if (targetMenu) {
      targetMenu.style.display = 'block';
    }
  });
});

// Display the first dropright menu by default
const droprights = document.querySelectorAll('.dropright');
droprights.forEach((dropright, index) => {
  console.log(`Dropright ${index}:`, dropright);
  // Optionally, you can add some condition to check which element to display
  if (index === 0) {
    dropright.style.display = 'block';
  }
});
</script>


<!-- Enqueue Scripts -->
<?php
    wp_footer();
?>
