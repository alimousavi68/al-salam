<?php
require_once('../../../wp-load.php');

$file_content = file_get_contents(WP_PLUGIN_DIR . '/polylang/include/api.php');
if (strpos($file_content, 'pll_translate_string') !== false) {
    echo "pll_translate_string filter exists in api.php!\n";
}

// Let's grep the whole plugin for apply_filters.*string
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(WP_PLUGIN_DIR . '/polylang'));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'apply_filters(') !== false && strpos($content, 'string') !== false) {
            preg_match_all("/apply_filters\(\s*'([^']+)'/", $content, $matches);
            foreach ($matches[1] as $match) {
                if (strpos($match, 'string') !== false) {
                    echo "Found filter: $match in " . $file->getFilename() . "\n";
                }
            }
        }
    }
}
