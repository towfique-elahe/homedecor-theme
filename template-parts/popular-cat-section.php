<section id="popularCats">
      <div class="container col">
          <div class="row head">
              <h3 class="section_heading">Popular Category</h3>
              <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="link">View Shop <ion-icon name="arrow-forward-outline"></ion-icon></a>
          </div>
          <hr class="line">
          <div class="carousel-container">
              <div class="carousel">
                  <?php
                      $selected_categories = get_option('homedecor_popular_categories', array());
                      $selected_categories = is_array($selected_categories) ? $selected_categories : array();
                      if (!empty($selected_categories)) {
                          foreach ($selected_categories as $category_id) {
                              $category = get_term($category_id, 'product_cat');
                              if ($category) {
                                  $category_link = get_term_link($category_id, 'product_cat');
                                  $thumbnail_id = get_term_meta($category_id, 'thumbnail_id', true);
                                  $image_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'thumbnail') : get_template_directory_uri() . '/assets/images/default-product.jpg';
                                  ?>
                                  <a class="carousel-item" href="<?php echo esc_html($category_link); ?>">
                                    <div class="image_container">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                    </div>
                                    <h4 class="cat_name"><?php echo esc_html($category->name); ?></h4>
                                  </a>
                                  <?php
                              }
                          }
                      } else {
                          echo '<p>No categories selected.</p>';
                      }
                  ?>
              </div>
          </div>
      </div>
    </section>