<?php
require_once('../../../wp-load.php');

if (!class_exists('PLL_Admin_Strings')) {
    echo json_encode(['error' => 'Polylang Admin Strings class not found']);
    exit;
}

$strings = PLL_Admin_Strings::get_strings();
$export = [];

foreach ($strings as $string) {
    // Only export actual text, ignoring obvious hex codes or simple numbers
    $text = $string['string'];
    if (preg_match('/^#[a-fA-F0-9]{3,6}$/', $text)) {
        continue; // skip colors
    }
    if (is_numeric($text)) {
        continue; // skip numbers
    }
    
    $export[] = $text;
}

header('Content-Type: application/json');
echo json_encode($export, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
