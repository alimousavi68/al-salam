<?php
/**
 * Theme Customizer
 * Implements panels based on Blueprint.
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

function alsalam_customize_controls_enqueue() {
    wp_enqueue_style('alsalam-customizer-css', get_template_directory_uri() . '/includes/customizer/customizer-admin.css', array(), '1.0.0');
    wp_enqueue_script('alsalam-customizer-js', get_template_directory_uri() . '/includes/customizer/customizer-admin.js', array('jquery', 'customize-controls', 'jquery-ui-sortable'), '1.0.0', true);
}
add_action('customize_controls_enqueue_scripts', 'alsalam_customize_controls_enqueue');

function alsalam_customize_register($wp_customize) {
    // Load Custom Controls
    require_once get_template_directory() . '/includes/customizer/class-alsalam-customizer-controls.php';

    // ==========================================
    // PANELS
    // ==========================================
    $wp_customize->add_panel('panel_global', ['title' => __('1. Global Settings', 'alsalam'), 'priority' => 130]);
    $wp_customize->add_panel('panel_header', ['title' => __('2. Header & Navigation', 'alsalam'), 'priority' => 131]);
    $wp_customize->add_panel('panel_homepage', ['title' => __('3. Homepage Sections', 'alsalam'), 'priority' => 132]);
    $wp_customize->add_panel('panel_footer', ['title' => __('4. Footer Settings', 'alsalam'), 'priority' => 133]);
    $wp_customize->add_panel('panel_inner', ['title' => __('5. Inner Pages & Archive', 'alsalam'), 'priority' => 134]);

    // ==========================================
    // PANEL 1: GLOBAL SETTINGS
    // ==========================================
    // 1.1 Colors
    $wp_customize->add_section('sec_global_colors', ['title' => __('Brand Colors', 'alsalam'), 'panel' => 'panel_global']);
    
    $wp_customize->add_setting('_alsalam_color_primary', ['default' => '#239BA8', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_alsalam_color_primary', [
        'label' => __('Primary Color', 'alsalam'), 'section' => 'sec_global_colors'
    ]));

    $wp_customize->add_setting('_alsalam_color_primary_dark', ['default' => '#12A19A', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_alsalam_color_primary_dark', [
        'label' => __('Primary Dark (Hover)', 'alsalam'), 'section' => 'sec_global_colors'
    ]));

    $wp_customize->add_setting('_alsalam_color_bg_dark', ['default' => '#041424', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_alsalam_color_bg_dark', [
        'label' => __('Dark Background', 'alsalam'), 'section' => 'sec_global_colors'
    ]));

    $wp_customize->add_setting('_alsalam_color_bg_light', ['default' => '#F4F7FE', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, '_alsalam_color_bg_light', [
        'label' => __('Site Background', 'alsalam'), 'section' => 'sec_global_colors'
    ]));

    // 1.2 Typography
    $wp_customize->add_section('sec_global_typo', ['title' => __('Typography', 'alsalam'), 'panel' => 'panel_global']);
    
    $wp_customize->add_setting('_alsalam_font_heading_en', ['default' => 'Outfit', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_font_heading_en', [
        'label' => __('Heading Font (EN)', 'alsalam'), 'section' => 'sec_global_typo', 'type' => 'select',
        'choices' => ['Outfit' => 'Outfit', 'Inter' => 'Inter', 'Roboto' => 'Roboto']
    ]);

    $wp_customize->add_setting('_alsalam_font_heading_ar', ['default' => 'Cairo', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_font_heading_ar', [
        'label' => __('Heading Font (AR)', 'alsalam'), 'section' => 'sec_global_typo', 'type' => 'select',
        'choices' => ['Cairo' => 'Cairo', 'Tajawal' => 'Tajawal']
    ]);

    $wp_customize->add_setting('_alsalam_font_body_en', ['default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_font_body_en', [
        'label' => __('Body Font (EN)', 'alsalam'), 'section' => 'sec_global_typo', 'type' => 'select',
        'choices' => ['Inter' => 'Inter', 'Outfit' => 'Outfit', 'Roboto' => 'Roboto']
    ]);

    $wp_customize->add_setting('_alsalam_font_body_ar', ['default' => 'Tajawal', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_font_body_ar', [
        'label' => __('Body Font (AR)', 'alsalam'), 'section' => 'sec_global_typo', 'type' => 'select',
        'choices' => ['Tajawal' => 'Tajawal', 'Cairo' => 'Cairo']
    ]);

    // 1.3 Social Media
    $wp_customize->add_section('sec_global_social', ['title' => __('Social Media', 'alsalam'), 'panel' => 'panel_global']);
    $wp_customize->add_setting('_alsalam_social_links', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_social_links', [
        'label' => __('Social Links', 'alsalam'),
        'section' => 'sec_global_social',
        'fields' => [
            'icon' => ['type' => 'image', 'label' => __('Icon (SVG)', 'alsalam')],
            'url'  => ['type' => 'url', 'label' => __('Link URL', 'alsalam')]
        ]
    ]));

    // ==========================================
    // PANEL 2: HEADER SETTINGS
    // ==========================================
    $wp_customize->add_section('sec_header_logo', ['title' => __('Logo & Style', 'alsalam'), 'panel' => 'panel_header']);
    
    $wp_customize->add_setting('_alsalam_header_logo', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_header_logo', [
        'label' => __('Header Logo', 'alsalam'), 'section' => 'sec_header_logo'
    ]));

    $wp_customize->add_setting('_alsalam_header_logo_width', ['default' => 150, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Slider_Control($wp_customize, '_alsalam_header_logo_width', [
        'label' => __('Logo Width (px)', 'alsalam'), 'section' => 'sec_header_logo',
        'choices' => ['min' => 50, 'max' => 300, 'step' => 5]
    ]));

    $wp_customize->add_section('sec_header_action', ['title' => __('Action Elements', 'alsalam'), 'panel' => 'panel_header']);
    
    $wp_customize->add_setting('_alsalam_header_cta_text', ['default' => 'Request Inquiry', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_header_cta_text', ['label' => __('CTA Button Text', 'alsalam'), 'section' => 'sec_header_action', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_header_cta_link', ['default' => '/inquiry/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_header_cta_link', ['label' => __('CTA Button Link', 'alsalam'), 'section' => 'sec_header_action', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_header_lang_switcher', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_header_lang_switcher', [
        'label' => __('Enable Language Switcher', 'alsalam'), 'section' => 'sec_header_action'
    ]));

    // ==========================================
    // PANEL 3: HOMEPAGE SECTIONS
    // ==========================================
    // 3.1 Hero
    $wp_customize->add_section('sec_home_hero', ['title' => __('3.1 Hero Section', 'alsalam'), 'panel' => 'panel_homepage']);
    
    $wp_customize->add_setting('_alsalam_hero_bg_type', ['default' => 'image', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_hero_bg_type', [
        'label' => __('Background Type', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'select',
        'choices' => ['image' => 'Image', 'video' => 'Video']
    ]);

    $wp_customize->add_setting('_alsalam_hero_bg_video', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_hero_bg_video', ['label' => __('Video File URL (MP4)', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_hero_deco_tr', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_hero_deco_tr', ['label' => __('Deco Image (Top Right)', 'alsalam'), 'section' => 'sec_home_hero']));

    $wp_customize->add_setting('_alsalam_hero_deco_bl', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_hero_deco_bl', ['label' => __('Deco Image (Bottom Left)', 'alsalam'), 'section' => 'sec_home_hero']));

    $wp_customize->add_setting('_alsalam_hero_btn1_text', ['default' => 'About Us', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_hero_btn1_text', ['label' => __('Button 1 Text', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_hero_btn1_link', ['default' => '/about/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_hero_btn1_link', ['label' => __('Button 1 Link', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_hero_btn2_text', ['default' => 'Our Products', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_hero_btn2_text', ['label' => __('Button 2 Text', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_hero_btn2_link', ['default' => '/products/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_hero_btn2_link', ['label' => __('Button 2 Link', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_hero_video_modal_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_hero_video_modal_enable', ['label' => __('Enable Video Modal Pulse Button', 'alsalam'), 'section' => 'sec_home_hero']));
    
    $wp_customize->add_setting('_alsalam_hero_video_modal_url', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_hero_video_modal_url', ['label' => __('Modal Video URL', 'alsalam'), 'section' => 'sec_home_hero', 'type' => 'url']);

    // Hero Carousel
    $wp_customize->add_setting('_alsalam_hero_slides', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_hero_slides', [
        'label' => __('Content Slides', 'alsalam'), 'section' => 'sec_home_hero',
        'fields' => [
            'badge1' => ['type' => 'text', 'label' => __('Badge Part 1 (Dark)', 'alsalam')],
            'badge2' => ['type' => 'text', 'label' => __('Badge Part 2 (Light)', 'alsalam')],
            'title'  => ['type' => 'text', 'label' => __('Main Title (H2)', 'alsalam')],
            'sub'    => ['type' => 'text', 'label' => __('Subtitle (H3)', 'alsalam')],
            'desc'   => ['type' => 'textarea', 'label' => __('Description', 'alsalam')]
        ]
    ]));

    // 3.2 About
    $wp_customize->add_section('sec_home_about', ['title' => __('3.2 About Section', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_about_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_about_enable', ['label' => __('Enable About Section', 'alsalam'), 'section' => 'sec_home_about']));
    
    $wp_customize->add_setting('_alsalam_about_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_about_img', ['label' => __('Main Image', 'alsalam'), 'section' => 'sec_home_about']));
    
    $wp_customize->add_setting('_alsalam_about_deco', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_about_deco', ['label' => __('Deco Icon', 'alsalam'), 'section' => 'sec_home_about']));

    $wp_customize->add_setting('_alsalam_about_btn_text', ['default' => 'Learn More', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_about_btn_text', ['label' => __('Floating Button Text', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_about_btn_link', ['default' => '/about/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_about_btn_link', ['label' => __('Floating Button Link', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_about_badge', ['default' => 'Corporate Profile', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_about_badge', ['label' => __('Badge', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_about_title', ['default' => 'About AL-SALAM', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_about_title', ['label' => __('Title', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_about_desc1', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_about_desc1', ['label' => __('Paragraph 1', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'textarea']);

    $wp_customize->add_setting('_alsalam_about_features', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_about_features', [
        'label' => __('Features (Max 2)', 'alsalam'), 'section' => 'sec_home_about',
        'fields' => [
            'icon' => ['type' => 'image', 'label' => __('Icon', 'alsalam')],
            'title' => ['type' => 'text', 'label' => __('Title', 'alsalam')]
        ]
    ]));

    $wp_customize->add_setting('_alsalam_about_desc2', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_about_desc2', ['label' => __('Paragraph 2', 'alsalam'), 'section' => 'sec_home_about', 'type' => 'textarea']);

    // 3.3 Infrastructure
    $wp_customize->add_section('sec_home_infra', ['title' => __('3.3 Infrastructure', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_infra_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_infra_enable', ['label' => __('Enable Infrastructure', 'alsalam'), 'section' => 'sec_home_infra']));

    $wp_customize->add_setting('_alsalam_infra_title', ['default' => 'Advanced <span class="text-teal-500">Pharmaceutical</span> Infrastructure', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_infra_title', ['label' => __('Title (use <span> for primary color)', 'alsalam'), 'section' => 'sec_home_infra', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_infra_sub', ['default' => 'Built on Quality. Driven by Care', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_infra_sub', ['label' => __('Subtitle', 'alsalam'), 'section' => 'sec_home_infra', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_infra_mask', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_infra_mask', ['label' => __('Background Mask Image', 'alsalam'), 'section' => 'sec_home_infra']));

    $default_infra_items = json_encode([
        ['icon' => alsalam_img('Shield.svg'), 'title' => 'Sterile Production', 'desc' => 'Manufactured under strict GMP guidelines with high sterility standards to ensure product purity.'],
        ['icon' => alsalam_img('Search copy.svg'), 'title' => 'Quality Control', 'desc' => 'Rigorous testing and analytical inspection to ensure full compliance with global pharmacopeia standards.'],
        ['icon' => alsalam_img('Star.svg'), 'title' => 'Facility & Utilities', 'desc' => 'State-of-the-art cleanroom facilities powered by intelligent climate control (HVAC) systems.'],
        ['icon' => alsalam_img('Graph.svg'), 'title' => 'Storage & Packaging', 'desc' => 'Advanced packaging and validation protocols including thermal processing for maximum safety.']
    ]);
    
    $wp_customize->add_setting('_alsalam_infra_items', ['default' => $default_infra_items, 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_infra_items', [
        'label' => __('Infrastructure Items (Max 4)', 'alsalam'), 'section' => 'sec_home_infra',
        'fields' => [
            'icon'  => ['type' => 'image', 'label' => __('Icon', 'alsalam')],
            'title' => ['type' => 'text', 'label' => __('Title', 'alsalam')],
            'desc'  => ['type' => 'textarea', 'label' => __('Description', 'alsalam')]
        ]
    ]));

    // 3.4 Products Carousel
    $wp_customize->add_section('sec_home_products', ['title' => __('3.4 Products Carousel', 'alsalam'), 'panel' => 'panel_homepage']);
    
    $wp_customize->add_setting('_alsalam_products_title', ['default' => 'Reliable Sterile Solutions', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_products_title', ['label' => __('Section Title', 'alsalam'), 'section' => 'sec_home_products', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_products_sub', ['default' => 'European Standards, Iraqi Excellence', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_products_sub', ['label' => __('Subtitle', 'alsalam'), 'section' => 'sec_home_products', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_products_btn_text', ['default' => 'All Products', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_products_btn_text', ['label' => __('CTA Button Text', 'alsalam'), 'section' => 'sec_home_products', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_products_btn_link', ['default' => '/products/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_products_btn_link', ['label' => __('CTA Button Link', 'alsalam'), 'section' => 'sec_home_products', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_products_count', ['default' => 10, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Slider_Control($wp_customize, '_alsalam_products_count', [
        'label' => __('Max Products to Show', 'alsalam'), 'section' => 'sec_home_products',
        'choices' => ['min' => 3, 'max' => 20, 'step' => 1]
    ]));

    // 3.5 Gallery
    $wp_customize->add_section('sec_home_gallery', ['title' => __('3.5 Company Gallery', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_gallery_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_gallery_enable', ['label' => __('Enable Gallery', 'alsalam'), 'section' => 'sec_home_gallery']));
    
    $wp_customize->add_setting('_alsalam_gallery_badge', ['default' => 'AL-SALAM', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_gallery_badge', ['label' => __('Badge', 'alsalam'), 'section' => 'sec_home_gallery', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_gallery_title', ['default' => 'Company Gallery', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_gallery_title', ['label' => __('Title', 'alsalam'), 'section' => 'sec_home_gallery', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_gallery_btn_text', ['default' => 'View All', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_gallery_btn_text', ['label' => __('Button Text', 'alsalam'), 'section' => 'sec_home_gallery', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_gallery_btn_link', ['default' => '/gallery/', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_gallery_btn_link', ['label' => __('Button Link', 'alsalam'), 'section' => 'sec_home_gallery', 'type' => 'url']);

    // 3.6 Why Choose Us
    $wp_customize->add_section('sec_home_why', ['title' => __('3.6 Why Choose Us', 'alsalam'), 'panel' => 'panel_homepage']);
    
    $wp_customize->add_setting('_alsalam_why_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_why_img', ['label' => __('Main Image', 'alsalam'), 'section' => 'sec_home_why']));
    
    $wp_customize->add_setting('_alsalam_why_badge', ['default' => 'Flexible IV Bag Technology', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_why_badge', ['label' => __('Floating Badge Text', 'alsalam'), 'section' => 'sec_home_why', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_why_box_title', ['default' => 'Why Choose Us', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_why_box_title', ['label' => __('Box Title', 'alsalam'), 'section' => 'sec_home_why', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_why_box_sub', ['default' => 'A transversal vision...', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_why_box_sub', ['label' => __('Box Subtitle', 'alsalam'), 'section' => 'sec_home_why', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_why_icon', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_why_icon', ['label' => __('Floating 3D Icon', 'alsalam'), 'section' => 'sec_home_why']));

    $wp_customize->add_setting('_alsalam_why_title', ['default' => 'Safer, Smarter <span class="text-teal-500">Infusion Solutions</span>', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_why_title', ['label' => __('Main Title (Right)', 'alsalam'), 'section' => 'sec_home_why', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_why_desc', ['default' => '', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_why_desc', ['label' => __('Description', 'alsalam'), 'section' => 'sec_home_why', 'type' => 'textarea']);

    $wp_customize->add_setting('_alsalam_why_features', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_why_features', [
        'label' => __('Reasons/Features', 'alsalam'), 'section' => 'sec_home_why',
        'fields' => [
            'icon'  => ['type' => 'image', 'label' => __('Icon', 'alsalam')],
            'title' => ['type' => 'text', 'label' => __('Title', 'alsalam')],
            'desc'  => ['type' => 'textarea', 'label' => __('Text', 'alsalam')]
        ]
    ]));

    // 3.7 News & Events
    $wp_customize->add_section('sec_home_news', ['title' => __('3.7 News & Events', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_news_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_news_enable', ['label' => __('Enable News Section', 'alsalam'), 'section' => 'sec_home_news']));
    
    $wp_customize->add_setting('_alsalam_news_title', ['default' => 'News & Events', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_news_title', ['label' => __('Title', 'alsalam'), 'section' => 'sec_home_news', 'type' => 'text']);

    // Fetch categories for dropdown
    $cats = get_categories();
    $cat_choices = [];
    foreach ($cats as $cat) { $cat_choices[$cat->slug] = $cat->name; }

    $wp_customize->add_setting('_alsalam_news_tab1_cat', ['default' => 'latest', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_news_tab1_cat', ['label' => __('Tab 1 Category', 'alsalam'), 'section' => 'sec_home_news', 'type' => 'select', 'choices' => $cat_choices]);

    $wp_customize->add_setting('_alsalam_news_tab2_cat', ['default' => 'educational', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_news_tab2_cat', ['label' => __('Tab 2 Category', 'alsalam'), 'section' => 'sec_home_news', 'type' => 'select', 'choices' => $cat_choices]);

    $wp_customize->add_setting('_alsalam_news_btn_text', ['default' => 'Read More', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_news_btn_text', ['label' => __('Read More Text', 'alsalam'), 'section' => 'sec_home_news', 'type' => 'text']);

    // 3.8 Testimonials
    $wp_customize->add_section('sec_home_testimonials', ['title' => __('3.8 Testimonials', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_testi_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_testi_enable', ['label' => __('Enable Testimonials', 'alsalam'), 'section' => 'sec_home_testimonials']));
    
    $wp_customize->add_setting('_alsalam_testi_title', ['default' => 'What Our Partners Say', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_testi_title', ['label' => __('Title', 'alsalam'), 'section' => 'sec_home_testimonials', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_testi_icon', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_testi_icon', ['label' => __('Title Icon', 'alsalam'), 'section' => 'sec_home_testimonials']));

    $wp_customize->add_setting('_alsalam_testi_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_testi_image', ['label' => __('Background Image', 'alsalam'), 'section' => 'sec_home_testimonials']));

    $wp_customize->add_setting('_alsalam_testi_btn_text', ['default' => 'All Comments', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_testi_btn_text', ['label' => __('Floating Button Text', 'alsalam'), 'section' => 'sec_home_testimonials', 'type' => 'text']);

    $wp_customize->add_setting('_alsalam_testi_btn_link', ['default' => '/about/#testimonials', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('_alsalam_testi_btn_link', ['label' => __('Floating Button Link', 'alsalam'), 'section' => 'sec_home_testimonials', 'type' => 'url']);

    $wp_customize->add_setting('_alsalam_testi_reviews', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_testi_reviews', [
        'label' => __('Testimonials (Max 5)', 'alsalam'), 'section' => 'sec_home_testimonials', 'limit' => 5,
        'fields' => [
            'name'    => ['type' => 'text', 'label' => __('Name', 'alsalam')],
            'role'    => ['type' => 'text', 'label' => __('Role / Title', 'alsalam')],
            'rating'  => ['type' => 'text', 'label' => __('Rating (1 to 5)', 'alsalam')],
            'date'    => ['type' => 'text', 'label' => __('Date', 'alsalam')],
            'comment' => ['type' => 'textarea', 'label' => __('Comment', 'alsalam')],
            'avatar'  => ['type' => 'image', 'label' => __('Avatar Image', 'alsalam')]
        ]
    ]));

    // 3.9 Features Marquee
    $wp_customize->add_section('sec_home_marquee', ['title' => __('3.9 Features Marquee', 'alsalam'), 'panel' => 'panel_homepage']);
    $wp_customize->add_setting('_alsalam_marquee_enable', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_marquee_enable', ['label' => __('Enable Marquee', 'alsalam'), 'section' => 'sec_home_marquee']));
    
    $wp_customize->add_setting('_alsalam_marquee_items', ['default' => '[]', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control(new Alsalam_Repeater_Control($wp_customize, '_alsalam_marquee_items', [
        'label' => __('Marquee Items', 'alsalam'), 'section' => 'sec_home_marquee',
        'fields' => [
            'icon'  => ['type' => 'image', 'label' => __('Icon', 'alsalam')],
            'title' => ['type' => 'text', 'label' => __('Title', 'alsalam')]
        ]
    ]));

    // ==========================================
    // PANEL 4: FOOTER SETTINGS
    // ==========================================
    $wp_customize->add_section('sec_footer_brand', ['title' => __('Brand & Newsletter', 'alsalam'), 'panel' => 'panel_footer']);
    $wp_customize->add_setting('_alsalam_footer_title', ['default' => 'Excellence <br/> in Parenteral Manufacturing', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_footer_title', ['label' => __('Footer Title HTML', 'alsalam'), 'section' => 'sec_footer_brand', 'type' => 'textarea']);
    
    $wp_customize->add_setting('_alsalam_footer_newsletter', ['default' => 'Enter your email address', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_footer_newsletter', ['label' => __('Newsletter Placeholder', 'alsalam'), 'section' => 'sec_footer_brand', 'type' => 'text']);

    $wp_customize->add_section('sec_footer_bottom', ['title' => __('Bottom Bar & Policies', 'alsalam'), 'panel' => 'panel_footer']);
    $wp_customize->add_setting('_alsalam_footer_copyright', ['default' => 'Copyright © [year] AL-SALAM. All rights reserved.', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_footer_copyright', ['label' => __('Copyright Text', 'alsalam'), 'section' => 'sec_footer_bottom', 'type' => 'text']);

    // Polices & Columns links from menus
    $menus = wp_get_nav_menus();
    $menu_choices = ['' => '-- Select Menu --'];
    foreach ($menus as $menu) { $menu_choices[$menu->term_id] = $menu->name; }
    
    $wp_customize->add_setting('_alsalam_footer_quick_menu', ['default' => '', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('_alsalam_footer_quick_menu', ['label' => __('Quick Access Menu', 'alsalam'), 'section' => 'sec_footer_bottom', 'type' => 'select', 'choices' => $menu_choices]);

    $wp_customize->add_setting('_alsalam_footer_services_menu', ['default' => '', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('_alsalam_footer_services_menu', ['label' => __('Services Menu', 'alsalam'), 'section' => 'sec_footer_bottom', 'type' => 'select', 'choices' => $menu_choices]);

    $wp_customize->add_setting('_alsalam_footer_resources_menu', ['default' => '', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('_alsalam_footer_resources_menu', ['label' => __('Resources Menu', 'alsalam'), 'section' => 'sec_footer_bottom', 'type' => 'select', 'choices' => $menu_choices]);

    $wp_customize->add_setting('_alsalam_footer_policy_menu', ['default' => '', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('_alsalam_footer_policy_menu', ['label' => __('Policies Menu', 'alsalam'), 'section' => 'sec_footer_bottom', 'type' => 'select', 'choices' => $menu_choices]);

    $wp_customize->add_setting('_alsalam_footer_scroll_top', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_footer_scroll_top', ['label' => __('Enable Scroll to Top', 'alsalam'), 'section' => 'sec_footer_bottom']));

    $wp_customize->add_setting('_alsalam_footer_dev_credit', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_footer_dev_credit', ['label' => __('Enable Developer Credit', 'alsalam'), 'section' => 'sec_footer_bottom']));

    // ==========================================
    // PANEL 5: INNER PAGES & ARCHIVE
    // ==========================================
    $wp_customize->add_section('sec_inner_settings', ['title' => __('General Inner Page Settings', 'alsalam'), 'panel' => 'panel_inner']);
    
    $wp_customize->add_setting('_alsalam_inner_preloader', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_inner_preloader', ['label' => __('Enable Preloader', 'alsalam'), 'section' => 'sec_inner_settings']));

    $wp_customize->add_setting('_alsalam_inner_preloader_logo', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_inner_preloader_logo', ['label' => __('Preloader Logo', 'alsalam'), 'section' => 'sec_inner_settings']));

    $wp_customize->add_setting('_alsalam_inner_breadcrumb', ['default' => '1', 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new Alsalam_Toggle_Control($wp_customize, '_alsalam_inner_breadcrumb', ['label' => __('Enable Breadcrumb', 'alsalam'), 'section' => 'sec_inner_settings']));

    $wp_customize->add_setting('_alsalam_inner_header_bg', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_inner_header_bg', ['label' => __('Global Inner Header Background', 'alsalam'), 'section' => 'sec_inner_settings']));

    $wp_customize->add_section('sec_inner_404', ['title' => __('404 Error Page', 'alsalam'), 'panel' => 'panel_inner']);
    $wp_customize->add_setting('_alsalam_404_img', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, '_alsalam_404_img', ['label' => __('404 Vector Image', 'alsalam'), 'section' => 'sec_inner_404']));
    
    $wp_customize->add_setting('_alsalam_404_title', ['default' => 'Page Not Found', 'sanitize_callback' => 'wp_kses_post']);
    $wp_customize->add_control('_alsalam_404_title', ['label' => __('404 Title', 'alsalam'), 'section' => 'sec_inner_404', 'type' => 'text']);
    
    $wp_customize->add_setting('_alsalam_404_btn', ['default' => 'Back to Home', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('_alsalam_404_btn', ['label' => __('Back to Home Button Text', 'alsalam'), 'section' => 'sec_inner_404', 'type' => 'text']);
}
add_action('customize_register', 'alsalam_customize_register');
