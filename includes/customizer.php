<?php
/**
 * Theme Customizer
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

function alsalam_customize_register($wp_customize) {
    $wp_customize->add_panel('alsalam_theme_options', array(
        'title'       => __('Theme Options', 'alsalam'),
        'description' => __('Global theme settings', 'alsalam'),
        'priority'    => 130,
    ));
}
add_action('customize_register', 'alsalam_customize_register');
