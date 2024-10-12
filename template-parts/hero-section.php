<section id="hero">
  <div class="container">
          <div class="slider">
            <?php
            $slider_images = get_option('homedecor_slider_images', array());

            $default_image = get_template_directory_uri() . '/assets/images/default-banner.jpg';
            $default_link = 'javascript:void(0)';

            foreach ($slider_images as $slide) {
                $image_url = isset($slide['image']) && !empty($slide['image']) ? esc_url($slide['image']) : $default_image;
                $link_url = isset($slide['link']) && !empty($slide['link']) ? esc_url($slide['link']) : $default_link;
                ?>
                    <a href="<?php echo $link_url; ?>" class="image_container">
                        <img src="<?php echo $image_url; ?>" alt="">
                    </a>
                <?php
            }
            ?>
          </div>
          
          <div class="branding">
            <?php
            $branding_images = get_option('homedecor_branding_images', array());
            $default_image_url = get_template_directory_uri() . '/assets/images/default-banner.jpg';

            for ($i = 0; $i < 2; $i++) {
                $image_url = $default_image_url;
                $link_url = 'javascript:void(0)';
                
                if (isset($branding_images[$i])) {
                    if (!empty($branding_images[$i]['url'])) {
                        $image_url = esc_url($branding_images[$i]['url']);
                    }
                    if (!empty($branding_images[$i]['link'])) {
                        $link_url = esc_url($branding_images[$i]['link']);
                    }
                }
                ?>
                <a href="<?php echo $link_url; ?>" class="image_container">
                    <img src="<?php echo $image_url; ?>" alt="Branding Image">
                </a>
                <?php
            }
            ?>
          </div>
  </div>
</section>
