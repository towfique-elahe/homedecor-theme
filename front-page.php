<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Enqueue Styles -->
    <?php wp_head(); ?>
    <!-- Slick Carousel CSS -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
    />
  </head>

  <body>
    <?php get_header()?>

    <!-- hero section -->
    <?php get_template_part('template-parts/front-page/hero-section'); ?>

    <!-- feature section -->
    <?php get_template_part('template-parts/front-page/feature-section'); ?>

    <div class="section_divider"></div>

    
    <!-- popular categories section -->
    <?php get_template_part('template-parts/front-page/popular-cat-section'); ?>

    <div class="section_divider"></div>


    <!-- call to action section -->
    <?php get_template_part('template-parts/front-page/call-to-action'); ?>

    <div class="section_divider"></div>
    

    <!-- featured products section -->
    <?php get_template_part('template-parts/front-page/featured-products-section'); ?>
    
    <div class="section_divider"></div>


    <!-- best seller section -->
    <?php get_template_part('template-parts/front-page/best-seller-section'); ?>

    <div class="section_divider"></div>


    <!-- new products section -->
    <?php get_template_part('template-parts/front-page/new-products-section'); ?>

    <div class="section_divider"></div>


    <!-- products with category tabs section -->
    <?php get_template_part('template-parts/front-page/category-tab-section'); ?>

    <div class="section_divider"></div>

    
    <!-- transform home section -->
    <?php get_template_part('template-parts/front-page/transform-home-section'); ?>

    <div class="section_divider"></div>


    <!-- customer testimonials section -->
    <?php get_template_part('template-parts/front-page/testimonials-section'); ?>

    <div class="section_divider"></div>


    <!-- recent blogs section -->
    <?php get_template_part('template-parts/front-page/blogs-section'); ?>

    <div class="section_divider"></div>

    <?php get_footer() ?>

    
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- hero slider script -->
    <script>
      jQuery(document).ready(function ($) {
        $(".slider").slick({
          autoplay: true,
          autoplaySpeed: 5000,
          arrows: true,
          dots: true,
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 768,
              settings: {
                arrows: false,
              },
            },
            {
              breakpoint: 480,
              settings: {
                arrows: false,
                dots: false,
              },
            },
          ],
        });
      });
    </script>

    <!-- Slick Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
      // testimonial section
      $(document).ready(function () {
        $(".testimonials-carousel").slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 3000,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              },
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
              },
            },
          ],
        });

        // blog post section
        $(".blog-posts-carousel").slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 3000,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              },
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
              },
            },
          ],
        });

        // universal carousel
        $(".carousel").slick({
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 3000,
          prevArrow: '<button type="button" class="slick-prev">❮</button>',
          nextArrow: '<button type="button" class="slick-next">❯</button>',
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                arrows: false,
              },
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
              },
            },
          ],
        });
      });
    </script>

    <!-- browse by category section script -->
    <script>
      // category click events and updateing the carousel
      jQuery(document).ready(function ($) {
        function loadCategoryProducts(categoryId) {
          $.ajax({
            url: "/wp-admin/admin-ajax.php",
            type: "POST",
            data: {
              action: "load_category_products",
              category_id: categoryId,
            },
            success: function (response) {
              $(".category-carousel").slick("unslick"); // Destroy the existing carousel
              $(".category-carousel").html(response); // Update the carousel content
              $(".category-carousel").slick({
                // Reinitialize the carousel
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                prevArrow:
                  '<button type="button" class="slick-prev">❮</button>',
                nextArrow:
                  '<button type="button" class="slick-next">❯</button>',
                responsive: [
                  {
                    breakpoint: 1024,
                    settings: {
                      slidesToShow: 3,
                      slidesToScroll: 1,
                    },
                  },
                  {
                    breakpoint: 768,
                    settings: {
                      slidesToShow: 2,
                      slidesToScroll: 1,
                      arrows: false,
                    },
                  },
                  {
                    breakpoint: 480,
                    settings: {
                      slidesToShow: 1,
                      slidesToScroll: 1,
                      arrows: false,
                    },
                  },
                ],
              });
            },
          });
        }

        // Handle category tab click
        $(".category-tab").on("click", function () {
          var categoryId = $(this).data("category-id");

          // Remove active class from all tabs and add to the clicked tab
          $(".category-tab").removeClass("active");
          $(this).addClass("active");

          loadCategoryProducts(categoryId);
        });

        // Load products for the first category on page load and add active class
        var firstCategoryId = $(".category-tab:first").data("category-id");
        if (firstCategoryId) {
          $(".category-tab:first").addClass("active");
          loadCategoryProducts(firstCategoryId);
        }
      });
    </script>
  </body>
</html>
