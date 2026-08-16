<?php
defined('ABSPATH') || exit;

/**
 * Register dynamic strings (Customizer & Metaboxes) for Polylang translation.
 * This dynamically reads the current values of Customizer settings so that if the 
 * user changes them, the new text automatically appears in Polylang String Translations!
 */
add_action('init', 'alsalam_register_polylang_strings');
function alsalam_register_polylang_strings() {
    if (!function_exists('pll_register_string')) return;

    $dynamic_strings = [
        // Header
        'Header CTA Text' => get_theme_mod('_alsalam_header_cta_text', 'Request Inquiry'),
        
        // Footer
        'Footer Title'    => get_theme_mod('_alsalam_footer_title', 'Excellence <br/> in Parenteral Manufacturing'),
        'Footer Newsletter' => get_theme_mod('_alsalam_footer_newsletter', 'Enter your email address'),
        'Footer Copyright' => get_theme_mod('_alsalam_footer_copyright', 'Copyright © [year] AL-SALAM. All rights reserved.'),
        'Footer Quick Access' => get_theme_mod('_alsalam_footer_quick_title', 'Quick Access'),
        'Footer Services'   => get_theme_mod('_alsalam_footer_services_title', 'Services'),
        'Footer Resources'  => get_theme_mod('_alsalam_footer_resources_title', 'Resources'),
        'Footer Dev Credit' => get_theme_mod('_alsalam_footer_dev_text', 'Designed & Developed by'),
        
        // Hero Section
        'Hero Button 1'   => get_theme_mod('_alsalam_hero_btn1_text', 'About Us'),
        'Hero Button 2'   => get_theme_mod('_alsalam_hero_btn2_text', 'Our Products'),
        
        // About Section
        'About Badge'     => get_theme_mod('_alsalam_about_badge', 'Corporate Profile'),
        'About Title'     => get_theme_mod('_alsalam_about_title', 'About AL-SALAM'),
        'About Button'    => get_theme_mod('_alsalam_about_btn_text', 'Learn More'),
        
        // Infrastructure Section
        'Infra Title'     => get_theme_mod('_alsalam_infra_title', 'Advanced <span class="text-teal-500">Pharmaceutical</span> Infrastructure'),
        'Infra Subtitle'  => get_theme_mod('_alsalam_infra_sub', 'Built on Quality. Driven by Care'),
        
        // Products Section
        'Products Title'  => get_theme_mod('_alsalam_products_title', 'Reliable Sterile Solutions'),
        'Products Sub'    => get_theme_mod('_alsalam_products_sub', 'European Standards, Iraqi Excellence'),
        'Products Btn'    => get_theme_mod('_alsalam_products_btn_text', 'All Products'),
        
        // Gallery Section
        'Gallery Badge'   => get_theme_mod('_alsalam_gallery_badge', 'AL-SALAM'),
        'Gallery Title'   => get_theme_mod('_alsalam_gallery_title', 'Company Gallery'),
        'Gallery Btn'     => get_theme_mod('_alsalam_gallery_btn_text', 'View All'),
        
        // Testimonials Section
        'Testimonials Sub' => get_theme_mod('_alsalam_testimonials_sub', 'Trusted by health institutions'),
        'Testimonials Title' => get_theme_mod('_alsalam_testimonials_title', 'What Our Partners Say'),
        
        // News Section
        'News Sub'        => get_theme_mod('_alsalam_news_sub', 'Stay updated'),
        'News Title'      => get_theme_mod('_alsalam_news_title', 'Latest News & Events'),
        'News Btn'        => get_theme_mod('_alsalam_news_btn_text', 'All Updates'),
        
        // Single Post/Product/Gallery Globals
        'Breadcrumb Home'    => get_theme_mod('_alsalam_breadcrumb_home', 'Home'),
        'Breadcrumb Gallery' => get_theme_mod('_alsalam_breadcrumb_gallery', 'Gallery'),
        'Breadcrumb Product' => get_theme_mod('_alsalam_breadcrumb_products', 'Products'),
        'Gallery Location'   => get_theme_mod('_alsalam_gallery_location_label', 'Location:'),
        'Gallery Photo'      => get_theme_mod('_alsalam_gallery_photo_label', 'Photographer:'),
        'Product EU Title'   => get_theme_mod('_alsalam_product_eu_title', 'European Standards Approved'),
        'Product EU Desc'    => get_theme_mod('_alsalam_product_eu_desc', 'Tested & validation-indexed for therapeutic hospital networks.'),
        'Product Tab 1'      => get_theme_mod('_alsalam_product_clinical_tab', 'Clinical Overview'),
        'Product Tab 2'      => get_theme_mod('_alsalam_product_formulation_tab', 'Product Formulation & Intent'),
        'Product Spec'       => get_theme_mod('_alsalam_product_spec_param', 'Specification Parameter'),
        'Product Metric'     => get_theme_mod('_alsalam_product_metric_details', 'Metric Details'),
        'Product Pkg'        => get_theme_mod('_alsalam_product_packaging_label', 'Packaging presentation'),
        'Product Vol'        => get_theme_mod('_alsalam_product_volume_label', 'Volume Availability'),
        'Product Grade'      => get_theme_mod('_alsalam_product_grade_label', 'Quality Grade'),
        'Product Shelf'      => get_theme_mod('_alsalam_product_shelf_label', 'Shelf life'),
        'Product Shelf Val'  => get_theme_mod('_alsalam_product_shelf_val', '36 Months from packaging date'),
        'Product Inquiry Btn'=> get_theme_mod('_alsalam_product_inquiry_btn', 'Request Commercial Inquiry'),
        'Product Related'    => get_theme_mod('_alsalam_product_related_title', 'Related <span class="text-teal-500">Parenteral</span> Formulations'),
    ];

    foreach ($dynamic_strings as $name => $string) {
        if (!empty($string)) {
            // Registering the current value means when the user changes it in Customizer, 
            // the new value becomes available in Polylang String Translations automatically!
            pll_register_string('alsalam_mod_' . sanitize_title($name), $string, 'AL-SALAM Settings');
        }
    }
}
