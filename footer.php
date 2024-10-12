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
        <h4 class="heading">newsletter</h4>
        <div id="newsletter_form">
          <form
            action="#"
            method="post"
            class="newsletter"
            id="newsletter_form"
          >
            <div class="email">
              <ion-icon name="mail-outline"></ion-icon>
              <input
                type="email"
                name="newsletter_email"
                id="newsletter_email"
                placeholder="Your email address"
                required
              />
            </div>
            <button type="submit" class="btn">Subscribe</button>
          </form>
        </div>
        <p class="para">
          Subscribe to our Newsletter to receive early discounts offers, latest
          news, sales and promo informations.
        </p>
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

<!-- Enqueue Scripts -->
<?php
    wp_footer();
?>
