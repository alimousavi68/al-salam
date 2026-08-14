<?php
require_once dirname(dirname(dirname(__DIR__))) . '/wp-load.php';
require_once __DIR__ . '/includes/seeder.php';

alsalam_seed_customizer_options();
echo "Done seeding customizer options\n";
