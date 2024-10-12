<section id="customerTestimonials">
        <div class="container col">
            <div class="row head">
                <h3 class="section_heading">Customer Testimonial</h3>
            </div>
            <hr class="line">
            <div class="carousel-container">
                <div class="carousel testimonials-carousel">
                    <?php
                    $testimonials = get_option('homedecor_testimonials', array());
                    if (!empty($testimonials)) {
                        foreach ($testimonials as $testimonial) {
                            $image_url = !empty($testimonial['image']) ? esc_url($testimonial['image']) : get_template_directory_uri() . '/assets/images/default-product.jpg';
                            ?>
                            <div class="carousel-item testimonial">
                                <div class="testimonial-content">
                                    <div class="image_container">
                                        <img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($testimonial['name']); ?>" class="testimonial-image">
                                    </div>
                                    <p class="testimonial-text"><?php echo esc_html($testimonial['content']); ?></p>
                                    <p class="testimonial-name">- <?php echo esc_html($testimonial['name']); ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No testimonials available.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>