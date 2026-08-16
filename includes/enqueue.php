<?php
/**
 * Enqueue scripts and styles
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

function alsalam_scripts() {
    // Google Fonts
    wp_enqueue_style('alsalam-fonts', 'https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&family=Tajawal:wght@300;400;500;700;800&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap', array(), null);

    // Swiper CSS (Local)
    wp_enqueue_style('alsalam-swiper-css', ALSALAM_URI . '/assets/css/swiper-bundle.min.css', array(), '11.0.0');

    // Tailwind CSS (Local Build)
    wp_enqueue_style('alsalam-tailwind', ALSALAM_URI . '/assets/css/tailwind.css', array(), filemtime(ALSALAM_DIR . '/assets/css/tailwind.css'));
    
    // Main Style
    wp_enqueue_style('alsalam-style', get_stylesheet_uri(), array('alsalam-tailwind'), ALSALAM_VERSION);

    // Custom CSS
    if (file_exists(ALSALAM_DIR . '/assets/css/custom.css')) {
        wp_enqueue_style('alsalam-custom', ALSALAM_URI . '/assets/css/custom.css', array('alsalam-tailwind'), filemtime(ALSALAM_DIR . '/assets/css/custom.css'));
    }

    // Scripts (Local)
    wp_enqueue_script('alsalam-gsap', ALSALAM_URI . '/assets/js/gsap.min.js', array(), '3.12.2', true);
    wp_enqueue_script('alsalam-scrolltrigger', ALSALAM_URI . '/assets/js/ScrollTrigger.min.js', array('alsalam-gsap'), '3.12.2', true);
    wp_enqueue_script('alsalam-swiper-js', ALSALAM_URI . '/assets/js/swiper-bundle.min.js', array(), '11.0.0', true);

    // Core JavaScript
    if (file_exists(ALSALAM_DIR . '/assets/js/main.js')) {
        wp_enqueue_script('alsalam-main', ALSALAM_URI . '/assets/js/main.js', array(), filemtime(ALSALAM_DIR . '/assets/js/main.js'), true);
    }
    // Main App JS
    if (file_exists(ALSALAM_DIR . '/assets/js/app.js')) {
        wp_enqueue_script('alsalam-app', ALSALAM_URI . '/assets/js/app.js', array('jquery', 'alsalam-swiper-js', 'alsalam-gsap'), filemtime(ALSALAM_DIR . '/assets/js/app.js'), true);
        wp_localize_script('alsalam-app', 'alsalam_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('alsalam_nonce')
        ));
    }

    // Animations JS
    if (file_exists(ALSALAM_DIR . '/assets/js/animations.js')) {
        wp_enqueue_script('alsalam-animations', ALSALAM_URI . '/assets/js/animations.js', array('alsalam-gsap', 'alsalam-scrolltrigger'), filemtime(ALSALAM_DIR . '/assets/js/animations.js'), true);
    }
}
add_action('wp_enqueue_scripts', 'alsalam_scripts');
