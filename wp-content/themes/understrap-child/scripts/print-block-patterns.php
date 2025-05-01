#!/usr/bin/env php
<?php
/**
 * print-block-patterns.php
 *
 * Usage:
 *   From theme root: php scripts/print-block-patterns.php
 *   (The script also attempts to work if run directly from the theme root)
 *
 * This script will print its own code first, followed by:
 *   • functions.php (How the theme loads block code)
 *   • inc/atomic.php (Your render helper)
 *   • inc/block-patterns.php (Pattern/Category registration)
 *   • inc/block-types.php (Block type registration)
 *   • inc/block-types/hero-section/block.json (Hero block definition)
 *   • template-parts/organisms/hero.php (Hero template)
 *   • ALL files in template-parts/atoms/ (Atomic components)
 *
 * It helps provide a complete picture of your block pattern and dynamic rendering setup.
 */

// --- Print the script's own code first ---
$self_path = __FILE__;
echo "/***\n";
echo "Name of file: " . basename($self_path) . "\n"; // Just print the script name for simplicity here
echo "Printing script's own code...\n";
echo "***/\n\n";
echo file_get_contents($self_path) . "\n\n";
// --- End printing script's own code ---


// Define script directory (where this file is located)
$script_dir = realpath(__DIR__);

// --- Determine the theme root dynamically ---
$base_dir_name = basename($script_dir);

if ($base_dir_name === 'scripts') {
    // If the directory is named 'scripts', assume theme root is its parent
    $theme_root = realpath($script_dir . '/..');
} else {
    // Otherwise, assume the script is run directly from the theme root
    $theme_root = $script_dir;
}

// Define common directories based on the determined theme root
$inc_dir            = $theme_root . '/inc';
$template_parts_dir = $theme_root . '/template-parts';
$atom_dir           = $template_parts_dir . '/atoms';
$organism_dir       = $template_parts_dir . '/organisms';
$functions_file     = $theme_root . '/functions.php'; // Define the path to functions.php

$files = [];

// --- Add functions.php ---
if (file_exists($functions_file)) {
    $files[] = $functions_file;
}

// --- 1) Core Pattern/Block Registration Files ---
// These files define the patterns, categories, and register the block types.
$core_inc_files = [
    $inc_dir . '/atomic.php',
    $inc_dir . '/block-patterns.php',
    $inc_dir . '/block-types.php',
];
foreach ($core_inc_files as $path) {
    if (file_exists($path)) {
        $files[] = $path;
    }
}

// --- 2) Specific Block Type Files (JSON configuration) ---
// Find block.json files for specific block types you are debugging.
$block_type_dirs = [
    $inc_dir . '/block-types/hero-section',
    // Add other block type directories here if needed
];

foreach ($block_type_dirs as $dir) {
    if (is_dir($dir)) {
        $scanned_dir = scandir($dir);
        if ($scanned_dir !== false) {
            foreach ($scanned_dir as $fn) {
                 if ($fn === '.' || $fn === '..') {
                     continue;
                 }
                // Only include .json files
                if (substr($fn, -5) === '.json') {
                    $files[] = "$dir/$fn";
                }
            }
        }
    }
}

// --- 3) Template Part Files Rendered by Dynamic Blocks ---
// These files contain the HTML structure for the blocks/components.

// Organism files relevant to the blocks being debugged
$organism_files = [
    $organism_dir . '/hero.php', // Used by the understrap-child/hero-section block
    // Add other specific organism files used by your blocks/patterns
];
foreach ($organism_files as $path) {
     if (file_exists($path)) {
        $files[] = $path;
    }
}

// ALL Atom files (as they are foundational components) - based on your screenshot
if (is_dir($atom_dir)) {
     $scanned_atoms = scandir($atom_dir);
     if ($scanned_atoms !== false) {
         foreach ($scanned_atoms as $fn) {
             // Skip '.' and '..' and only include .php files
             if ($fn === '.' || $fn === '..' || substr($fn, -4) !== '.php') {
                 continue;
             }
             $files[] = "$atom_dir/$fn";
         }
     }
}

// --- 4) Helper Files (inc/atomic.php is already in core_inc_files) ---
// Add any other necessary helper files if they aren't in the above categories


// Remove duplicates and ensure order (optional, but makes output predictable)
// Note: $self_path was printed separately at the start. We don't need it in this sorted list.
$files = array_unique($files);
// Remove the script's own path if it somehow got in the list
$files = array_diff($files, [$self_path]);
sort($files); // Sort alphabetically by path


// --- Print the contents of the other files ---
foreach ($files as $path) {
    // Double check file exists before printing - important!
    if (! file_exists($path)) {
         // This shouldn't happen often now, but provides a safeguard
         echo "/***\n";
         echo "ERROR: File not found (Skipping) - " . str_replace($theme_root . '/', '', $path) . "\n";
         echo "***/\n\n";
        continue; // Skip to the next file
    }

    // print a header for the file
    echo "/***\n";
    // Make path relative to theme root for cleaner output
    echo "Name of file: " . str_replace($theme_root . '/', '', $path) . "\n";
    echo "***/\n\n";

    // dump contents
    echo file_get_contents($path) . "\n\n";
}

?>