#!/usr/bin/env php
<?php
/**
 * print-block-patterns.php
 *
 * Usage: from your theme root run
 *   php print-block-patterns.php
 *
 * It will look through your `inc/` folder for:
 *   • `block-patterns.php`
 *   • `block-types.php`
 *   • any `.json` files under `inc/block-types/hero-section/`
 *
 * and echo each one with a /*** Name of file ***/ 

 $script_dir = realpath(__DIR__);
 $theme_root = realpath( $script_dir . '/..' );
 $inc_dir    = $theme_root . '/inc';
$files = [];

// explicitly include these two
$files[] = $inc_dir . '/block-patterns.php';
$files[] = $inc_dir . '/block-types.php';

// include any JSON under inc/block-types/hero-section
$hero_dir = $inc_dir . '/block-types/hero-section';
if (is_dir($hero_dir)) {
    foreach (scandir($hero_dir) as $fn) {
        if (substr($fn, -5) === '.json') {
            $files[] = "$hero_dir/$fn";
        }
    }
}

foreach ($files as $path) {
    if (! file_exists($path)) {
        continue;
    }
    // print a header
    echo "/***\n";
    echo "Name of file: " . str_replace($theme_root . '/', '', $path) . "\n";
    echo "***/\n\n";
    // dump contents
    echo file_get_contents($path) . "\n\n";
}
