<?php
defined('ABSPATH') || exit;

add_action('init', 'alsalam_register_polylang_strings');
function alsalam_register_polylang_strings() {
    if (!function_exists('pll_register_string')) return;

    $translations_path = ALSALAM_DIR . '/includes/translations-data.php';
    if (!file_exists($translations_path)) return;

    $translations = require $translations_path;
    
    if (isset($translations) && isset($translations['en'])) {
        foreach ($translations['en'] as $key => $value) {
            pll_register_string($key, $value, 'AL-SALAM Theme');
        }
    }
}
