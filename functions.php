<?php
/**
 * Theme functions and definitions
 *
 * @package alsalam
 */

defined('ABSPATH') || exit;

// Define theme constants
define('ALSALAM_VERSION', '1.0.0');
define('ALSALAM_DIR', get_template_directory());
define('ALSALAM_URI', get_template_directory_uri());

// Include core theme modules
$alsalam_includes = array(
    'includes/setup.php',
    'includes/enqueue.php',
    'includes/helpers.php',
    'includes/navigation-walker.php',
    'includes/security.php',
    'includes/sidebars.php',
    'includes/customizer.php',
    'includes/seeder.php',
    'includes/page-metaboxes.php',
    'includes/polylang-strings.php',
    'includes/inbox-system.php',
);

foreach ($alsalam_includes as $file) {
    require_once ALSALAM_DIR . '/' . $file;
}
