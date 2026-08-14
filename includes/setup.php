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

        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'alsalam'),
            'footer'  => esc_html__('Footer Menu', 'alsalam'),
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
