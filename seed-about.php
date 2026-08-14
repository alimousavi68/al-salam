<?php
/**
 * Standalone script to seed About pages
 * Run with: wp eval-file seed-about.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Get the original translations array
$translations_path = __DIR__ . '/../alsalam_original_theme/data/translations.php';
$content = file_get_contents($translations_path);
$content = preg_replace('/function __\(\$key\).*?\}/s', '', $content);
$content = str_replace('<?php', '', $content);
eval($content);

if (!isset($translations) || !isset($translations['en']) || !isset($translations['ar'])) {
    die("Error: Translations array not found.\n");
}

function alsalam_seed_about_page($lang, $title, $translations_array) {
    // Check if page already exists
    $existing = get_page_by_title($title, OBJECT, 'page');
    if ($existing) {
        $post_id = $existing->ID;
        echo "Page '$title' already exists (ID: $post_id). Updating meta...\n";
    } else {
        $post_id = wp_insert_post([
            'post_title' => $title,
            'post_type' => 'page',
            'post_status' => 'publish',
            'page_template' => 'page-about.php'
        ]);
        echo "Created page '$title' (ID: $post_id).\n";
    }

    // Set template again just in case
    update_post_meta($post_id, '_wp_page_template', 'page-about.php');

    // 2. Map original translations to meta keys
    $meta_map = [
        'about_meta_title' => '_alsalam_meta_title',
        'about_page_subtitle' => '_alsalam_hero_subtitle',
        'about_corp_profile_badge' => '_alsalam_about_corp_profile_badge',
        'about_corp_profile_title' => '_alsalam_about_corp_profile_title',
        'about_corp_profile_desc1' => '_alsalam_about_corp_profile_desc1',
        'about_corp_profile_desc2' => '_alsalam_about_corp_profile_desc2',
        'about_standards_title' => '_alsalam_about_standards_title',
        'about_standards_desc' => '_alsalam_about_standards_desc',
        'about_aseptic_title' => '_alsalam_about_aseptic_title',
        'about_aseptic_desc' => '_alsalam_about_aseptic_desc',
        'about_purpose_title' => '_alsalam_about_purpose_title',
        'about_vision_title' => '_alsalam_about_vision_title',
        'about_vision_desc' => '_alsalam_about_vision_desc',
        'about_vision_badge' => '_alsalam_about_vision_badge',
        'about_mission_title' => '_alsalam_about_mission_title',
        'about_mission_desc' => '_alsalam_about_mission_desc',
        'about_mission_badge' => '_alsalam_about_mission_badge',
        'about_values_title' => '_alsalam_about_values_title',
        'about_values_val1' => '_alsalam_about_values_val1',
        'about_values_val2' => '_alsalam_about_values_val2',
        'about_values_val3' => '_alsalam_about_values_val3',
        'about_values_badge' => '_alsalam_about_values_badge',
        'about_cap_badge' => '_alsalam_about_cap_badge',
        'about_cap_title' => '_alsalam_about_cap_title',
        'about_cap_desc' => '_alsalam_about_cap_desc',
        'about_metric1_val' => '_alsalam_about_metric1_val',
        'about_metric1_title' => '_alsalam_about_metric1_title',
        'about_metric1_desc' => '_alsalam_about_metric1_desc',
        'about_metric2_val' => '_alsalam_about_metric2_val',
        'about_metric2_title' => '_alsalam_about_metric2_title',
        'about_metric2_desc' => '_alsalam_about_metric2_desc',
        'about_metric3_val' => '_alsalam_about_metric3_val',
        'about_metric3_title' => '_alsalam_about_metric3_title',
        'about_metric3_desc' => '_alsalam_about_metric3_desc',
        'about_metric4_val' => '_alsalam_about_metric4_val',
        'about_metric4_title' => '_alsalam_about_metric4_title',
        'about_metric4_desc' => '_alsalam_about_metric4_desc',
        'about_cta_title' => '_alsalam_about_cta_title',
        'about_cta_desc' => '_alsalam_about_cta_desc',
        'submit_inquiry_btn' => '_alsalam_submit_inquiry_btn',
    ];

    foreach ($meta_map as $orig_key => $meta_key) {
        if (isset($translations_array[$orig_key])) {
            update_post_meta($post_id, $meta_key, $translations_array[$orig_key]);
        }
    }
    
    // Default setting
    update_post_meta($post_id, '_alsalam_show_hero', '1');

    // Set Polylang language
    if (function_exists('pll_set_post_language')) {
        pll_set_post_language($post_id, $lang);
    }

    return $post_id;
}

$en_id = alsalam_seed_about_page('en', 'About', $translations['en']);
$ar_id = alsalam_seed_about_page('ar', 'من نحن', $translations['ar']);

// Link translations
if (function_exists('pll_save_post_translations')) {
    pll_save_post_translations([
        'en' => $en_id,
        'ar' => $ar_id
    ]);
    echo "Linked translations successfully.\n";
}

echo "Done seeding pages.\n";
