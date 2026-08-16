<?php
/**
 * Helper functions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

// Polyfills for Polylang functions to prevent fatal errors
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
if (!function_exists('pll_register_string')) {
    function pll_register_string($name, $string, $group = 'AL-SALAM', $multiline = false) {
        // No-op fallback
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

