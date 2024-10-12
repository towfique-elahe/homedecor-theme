<div class="navbar">
    <div class="container">
        <!-- This anchor will be fixed and the link will be the WordPress home URL -->
        <a href="<?php echo home_url(); ?>" class="home-btn">Home</a>
        <nav class="nav">
            <?php foreach ( $categories as $category ) : ?>
                <?php if ( !$category->parent ) : // Only display top-level categories ?>
                    <?php
                    // Check if this category has child categories
                    $child_categories = get_terms( array(
                        'taxonomy' => 'product_cat',
                        'hide_empty' => false,
                        'parent' => $category->term_id,
                    ) );
                    $has_children = !empty( $child_categories );
                    
                    // Get category thumbnail ID
                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    // Get image URL
                    $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_template_directory_uri() . '/assets/images/default-category.jpg';
                    ?>
                    <div class="dropdown">
                        <a href="<?php echo get_term_link( $category ); ?>" class="dropbtn menu-link">
                            <?php echo $category->name; ?>
                            <?php if ( $has_children ) : ?>
                                <ion-icon name="chevron-down-outline"></ion-icon>
                            <?php endif; ?>
                        </a>
                        <?php if ( $has_children ) : ?>
                            <div class="dropdown-content submenu">
                                <h3 class="submenu-heading">
                                    <a href="<?php echo get_term_link( $category ); ?>">
                                        <?php echo $category->name; ?>
                                    </a>
                                </h3>
                                <div class="row">
                                    <div class="column column1 submenu-item">
                                        <?php foreach ( $child_categories as $child_category ) : ?>
                                            <?php
                                            // Check for grandchild categories
                                            $grandchild_categories = get_terms( array(
                                                'taxonomy' => 'product_cat',
                                                'hide_empty' => false,
                                                'parent' => $child_category->term_id,
                                            ) );
                                            $has_grandchildren = !empty( $grandchild_categories );
                                            ?>
                                            <a href="<?php echo get_term_link( $child_category ); ?>" class="dropbtn sub-submenu-link" data-target="dropright<?php echo $child_category->term_id; ?>">
                                                <?php echo $child_category->name; ?>
                                                <?php if ( $has_grandchildren ) : ?>
                                                    <ion-icon name="chevron-forward-outline"></ion-icon>
                                                <?php endif; ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php foreach ( $child_categories as $child_category ) : ?>
                                        <?php
                                        $grandchild_categories = get_terms( array(
                                            'taxonomy' => 'product_cat',
                                            'hide_empty' => false,
                                            'parent' => $child_category->term_id,
                                        ) );
                                        ?>
                                        <div class="column column2 submenu-item dropright" id="dropright<?php echo $child_category->term_id; ?>">
                                            <?php foreach ( $grandchild_categories as $grandchild_category ) : ?>
                                                <a href="<?php echo get_term_link( $grandchild_category ); ?>" class="sub-submenu-link">
                                                    <?php echo $grandchild_category->name; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="column column3 submenu-item">
                                        <div class="image_container">
                                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $category->name ); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    </div>
</div>
