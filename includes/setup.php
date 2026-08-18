<?php
/**
 * Theme setup and configuration
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

if (!function_exists('alsalam_setup')) :
    function alsalam_setup() {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
        add_theme_support('custom-logo', array(
            'height'      => 100,
            'width'       => 400,
            'flex-height' => true,
            'flex-width'  => true,
        ));

        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'alsalam'),
            'footer'  => esc_html__('Footer Policy Menu', 'alsalam'),
            'footer_quick_access' => esc_html__('Footer Quick Access', 'alsalam'),
            'footer_services' => esc_html__('Footer Services', 'alsalam'),
            'footer_resources' => esc_html__('Footer Resources', 'alsalam')
        ));

        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        add_theme_support('widgets-block-editor', false);
    }
endif;
add_action('after_setup_theme', 'alsalam_setup');

/**
 * Force front-page.php template for Polylang front page translations
 */
function alsalam_front_page_template_redirect($template) {
    if (is_front_page()) {
        $front_page_template = get_template_directory() . '/front-page.php';
        if (file_exists($front_page_template)) {
            return $front_page_template;
        }
    }
    if (is_page()) {
        $front_id = get_option('page_on_front');
        $current_id = get_queried_object_id();

        if ($front_id && $current_id) {
            if ($front_id == $current_id) {
                return get_template_directory() . '/front-page.php';
            }
            if (function_exists('pll_get_post_translations')) {
                $translations = pll_get_post_translations($front_id);
                if (is_array($translations) && in_array($current_id, $translations)) {
                    return get_template_directory() . '/front-page.php';
                }
            }
        }
    }
    return $template;
}
add_filter('template_include', 'alsalam_front_page_template_redirect', 99);
