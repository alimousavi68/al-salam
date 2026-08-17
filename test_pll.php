<?php
require_once('../../../wp-load.php');

echo "<h2>Polylang Classes</h2>";
$classes = get_declared_classes();
foreach ($classes as $class) {
    if (strpos($class, 'PLL') !== false || strpos(strtolower($class), 'polylang') !== false) {
        echo $class . "<br>";
    }
}

echo "<h2>Polylang Functions</h2>";
$funcs = get_defined_functions();
foreach ($funcs['user'] as $func) {
    if (strpos($func, 'pll') !== false || strpos(strtolower($func), 'polylang') !== false) {
        echo $func . "<br>";
    }
}
