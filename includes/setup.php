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
