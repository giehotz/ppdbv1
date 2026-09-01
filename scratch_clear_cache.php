<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootWeb($paths);

$cache = \Config\Services::cache();
$cache->delete('home_landing_data');
$cache->delete('app_settings');
$cache->delete('web_settings');
echo "Cache cleared successfully." . PHP_EOL;
unlink(__FILE__);
