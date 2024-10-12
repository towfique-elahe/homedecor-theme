<section id="categoryTabs">
        <div class="container col">
            <div class="row head">
                <h3 class="section_heading">Browse by Category</h3>
                <div class="category-tabs">
                    <?php
                    $selected_categories = get_option('homedecor_product_categories', array());
                    $selected_categories = is_array($selected_categories) ? $selected_categories : array();

                    if (!empty($selected_categories)) {
                        foreach ($selected_categories as $category_id) {
                            $category = get_term($category_id, 'product_cat');
                            if ($category) {
                                ?>
                                <button class="category-tab" data-category-id="<?php echo esc_attr($category_id); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </button>
                                <?php
                            }
                        }
                    } else {
                        echo '<p>No categories selected.</p>';
                    }
                    ?>
                </div>
            </div>
            <hr class="line">
            <div class="carousel-container">
                <div class="carousel category-carousel">
                    <!-- Products will be dynamically loaded here -->
                </div>
            </div>
        </div>
</section>