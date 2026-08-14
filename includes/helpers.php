<?php
/**
 * Helper functions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

/**
 * Get translation safely
 */
if (!function_exists('alsalam_str')) {
    function alsalam_str($key) {
        if (function_exists('pll__')) {
            return pll__($key);
        }
        return $key;
    }
}

/**
 * Get image URI from assets
 */
function alsalam_img($filename) {
    return ALSALAM_URI . '/assets/images/' . $filename;
}
