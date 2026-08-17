<?php
/**
 * Helper functions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

// Polyfills for Polylang functions to prevent fatal errors when Polylang is inactive
if (!function_exists('pll__')) {
    function pll__($string) {
        return __($string, 'alsalam');
    }
}
if (!function_exists('pll_e')) {
    function pll_e($string) {
        echo esc_html(__($string, 'alsalam'));
    }
}
/**
 * Get image URI from assets
 */
function alsalam_img($filename) {
    return ALSALAM_URI . '/assets/images/' . $filename;
}

/**
 * Convert Western Arabic numerals (0-9) to Eastern Arabic-Indic numerals (٠-٩)
 * when the current language is Arabic. Otherwise return the value unchanged.
 *
 * Usage: echo alsalam_number(42);      // outputs ٤٢ in Arabic context
 *        echo alsalam_number('500ml'); // outputs ٥٠٠ml in Arabic context
 *
 * @param  string|int $value The number or string containing numbers.
 * @return string
 */
if (!function_exists('alsalam_number')) {
    function alsalam_number($value) {
        $is_ar = false;
        if (function_exists('pll_current_language')) {
            $is_ar = (pll_current_language() === 'ar');
        } elseif (is_rtl()) {
            $is_ar = true;
        }

        if (!$is_ar) {
            return (string) $value;
        }

        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $arabic  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        return str_replace($western, $arabic, (string) $value);
    }
}

/**
 * Format and localize a date string — uses Arabic numerals in AR context.
 *
 * @param  string $format  PHP date format string (default 'Y/m/d').
 * @param  int    $post_id Optional post ID; defaults to current post in loop.
 * @return string
 */
if (!function_exists('alsalam_date')) {
    function alsalam_date($format = 'Y/m/d', $post_id = null) {
        if ($post_id) {
            $date = get_the_date($format, $post_id);
        } else {
            $date = get_the_date($format);
        }
        return alsalam_number($date);
    }
}

/**
 * Get language-aware page URL for internal links
 */
if (!function_exists('alsalam_page_url')) {
    function alsalam_page_url($slug) {
        $clean_slug = trim($slug, '/');
        
        // 1. Try get_page_by_path
        $page = get_page_by_path($clean_slug); 
        
        // 2. Fallback: Search by page template (e.g. page-inquiry.php -> inquiry)
        if (!$page) {
            $pages = get_pages([
                'meta_key'   => '_wp_page_template',
                'meta_value' => 'page-' . $clean_slug . '.php',
            ]);
            if (!empty($pages)) {
                $page = $pages[0];
            }
        }
        
        // 3. If Polylang is active, translate post ID to active language
        if ($page && function_exists('pll_get_post')) {
            $current_lang = function_exists('pll_current_language') ? pll_current_language() : '';
            $trans_id = pll_get_post($page->ID, $current_lang);
            if ($trans_id) {
                return get_permalink($trans_id);
            }
        }

        if ($page) {
            return get_permalink($page->ID);
        }

        if (function_exists('pll_home_url')) {
            return rtrim(pll_home_url(), '/') . '/' . $clean_slug . '/';
        }
        return home_url('/' . $clean_slug . '/');
    }
}

/**
 * Get language-aware CTA URL for the header button
 */
if (!function_exists('alsalam_get_cta_url')) {
    function alsalam_get_cta_url() {
        $cta_link = get_theme_mod('_alsalam_header_cta_link');
        
        // If empty, default '#', or contains 'inquiry', use language-aware page URL
        if (empty($cta_link) || $cta_link === '#' || strpos($cta_link, 'inquiry') !== false || $cta_link === '/inquiry/' || $cta_link === '/inquiry') {
            return alsalam_page_url('inquiry');
        }
        
        // If Polylang is active and it's a URL, translate it
        if (function_exists('pll_translate_url')) {
            $translated = pll_translate_url($cta_link);
            if (!empty($translated)) {
                return $translated;
            }
        }
        
        return $cta_link;
    }
}



