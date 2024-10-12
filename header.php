<header class="header">
    <!-- top bar -->
    <div class="topbar">
        <div class="container">
            <p class="greeting">
                Welcome to Home Decor Retail
            </p>
        </div>
    </div>

    <div class="sticky-header" id="stickyHeader">
            <!-- main bar -->
            <div class="mainbar">
                <div class="container row">
                    <div class="col">
                        <!-- logo -->
                        <?php
                            if(function_exists('the_custom_logo')){
                                $custom_logo_id = get_theme_mod('custom_logo');
                                $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            }
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo_container">
                            <?php if (has_custom_logo()) : ?>
                                <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="logo">
                            <?php else : ?>
                                <span class="site-title"><?php bloginfo('name'); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>

                    <div class="col search_grp">
                            <!-- <div class="cat_menu">
                                <button id="categoryButton">all <ion-icon name="chevron-down-outline"></ion-icon></button>
                                <ul class="dropdown_content" id="categoryList" style="display: none;">
                                    <?php
                                    $product_categories = get_woocommerce_product_categories();
                                    foreach ($product_categories as $category) {
                                        echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <hr> -->
                            <form role="search" method="get" class="search" action="<?php echo esc_url(home_url('/')); ?>">
                                <input type="search" class="search_box" placeholder="Search products" value="<?php echo get_search_query(); ?>" name="s" />
                                <input type="hidden" name="post_type" value="product" />
                                <button type="submit" class="search_btn">
                                    <ion-icon name="search-outline"></ion-icon>
                                </button>
                            </form>
                    </div>


                    <div class="col">
                        <div class="action_grp">
                            <div class="cart">
                                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="action_btn">
                                    <ion-icon name="cart-outline"></ion-icon>
                                    <span class="counter"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                                </a>
                            </div>

                            <div class="user">
                                <a href="<?php echo esc_url(home_url('/index.php/my-account')); ?>" class="action_btn">
                                    <ion-icon name="person-outline"></ion-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- navbar -->
<?php
// Fetch WooCommerce product categories
$categories = get_terms( array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false, // Change to true to hide empty categories
) );
?>
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
                                        <?php if ( !empty( $grandchild_categories ) ) : ?>
                                            <div class="column column2 submenu-item dropright" id="dropright<?php echo $child_category->term_id; ?>">
                                                <?php foreach ( $grandchild_categories as $grandchild_category ) : ?>
                                                    <a href="<?php echo get_term_link( $grandchild_category ); ?>" class="sub-submenu-link">
                                                        <?php echo $grandchild_category->name; ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
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





            <!-- mobile menu -->
            <div class="mobile_menu">
                    <!-- main bar -->
                        <!-- logo -->
                        <div class="logo">
                            <?php
                                if(function_exists('the_custom_logo')){
                                    $custom_logo_id = get_theme_mod('custom_logo');
                                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                                }
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo_container">
                                <?php if (has_custom_logo()) : ?>
                                    <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php bloginfo('name'); ?>" class="logo">
                                <?php else : ?>
                                    <span class="site-title"><?php bloginfo('name'); ?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                            
                        <!-- menu -->
                        <div class="menu_btn">
                            <a href="javascript:void(0);" class="menu-icon">
                                <ion-icon name="menu"></ion-icon>
                            </a>
                        </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <a href="javascript:void(0);" class="close-icon">
                    <ion-icon name="close"></ion-icon>
                </a>

                <!-- menu -->
                <nav class="nav">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="home_btn">
                            Home
                        </a>
                        <?php
                            wp_nav_menu(array(
                                'theme_location' => 'primary-menu',
                                'container' => false,
                                'menu_class' => 'menu',
                                'fallback_cb' => '__return_false'
                            ));
                        ?>
                </nav>

                <div class="action-buttons">
                    <a href="<?php echo wc_get_cart_url(); ?>" class="cart-icon">
                        <ion-icon name="cart"></ion-icon>
                    </a>
                    <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>" class="user-icon">
                        <ion-icon name="person"></ion-icon>
                    </a>
                </div>
            </div>
    </div>
</header>