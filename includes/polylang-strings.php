<?php
defined('ABSPATH') || exit;

add_action('init', 'alsalam_register_polylang_strings');
function alsalam_register_polylang_strings() {
    if (!function_exists('pll_register_string')) return;

    $translations_path = ALSALAM_DIR . '/../alsalam_original_theme/data/translations.php';
    if (!file_exists($translations_path)) return;

    // Read the file and strip the __() function to avoid fatal error
    $content = file_get_contents($translations_path);
    $content = preg_replace('/function __\(\$key\).*?\}/s', '', $content);
    
    // Evaluate the array
    $content = str_replace('<?php', '', $content);
    eval($content);
    
    if (isset($translations) && isset($translations['en'])) {
        foreach ($translations['en'] as $key => $value) {
            pll_register_string($key, $value, 'AL-SALAM Theme');
        }
    }
}
