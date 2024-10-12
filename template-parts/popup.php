<?php
// Get popup settings from the WordPress options
$title = get_option('promo_popup_title', 'Default Title');
$message = get_option('promo_popup_message', 'Default Message');
$button_text = get_option('promo_popup_button_text', 'Default Button Text');
$button_link = get_option('promo_popup_button_link', '/default-link');
$image_url = get_option('promo_popup_image', '');
$delay = (int)get_option('promo_popup_delay', 3) * 1000; // Convert to milliseconds
$duration = (int)get_option('promo_popup_duration', 10) * 1000; // Convert to milliseconds
$showOncePerSession = (bool)get_option('promo_popup_once_per_session', 0);
?>

<div id="promoPopup" class="promo-popup" style="display: none;">
    <div class="promo-content">
        <span class="close-btn" onclick="closePopup();">&times;</span>
        <?php if ($image_url): ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="Promotion Image" class="promo-image">
        <?php endif; ?>
        <h3 class="promo-title"><?php echo esc_html($title); ?></h3>
        <p class="promo-message"><?php echo wp_kses_post($message); ?></p>
        <button class="promo-button" onclick="location.href='<?php echo esc_url($button_link); ?>';">
            <?php echo esc_html($button_text); ?>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var delay = <?php echo esc_js($delay); ?>;
        var duration = <?php echo esc_js($duration); ?>;
        var showOncePerSession = <?php echo $showOncePerSession ? 'true' : 'false'; ?>;

        function showPopup() {
            document.getElementById('promoPopup').style.display = 'flex';
            setTimeout(closePopup, duration);
            if (showOncePerSession) {
                sessionStorage.setItem('popupShown', 'true');
            }
        }

        function closePopup() {
            document.getElementById('promoPopup').style.display = 'none';
        }

        // Check if popup should be shown based on session storage
        if (!showOncePerSession || !sessionStorage.getItem('popupShown')) {
            setTimeout(showPopup, delay);
        }

        // Close the popup when clicking outside the content area
        window.onclick = function(event) {
            if (event.target === document.getElementById('promoPopup')) {
                closePopup();
            }
        };

        // Add event listener to close button (in case onclick is not working)
        var closeButton = document.querySelector('.close-btn');
        if (closeButton) {
            closeButton.addEventListener('click', closePopup);
        }
    });
</script>
