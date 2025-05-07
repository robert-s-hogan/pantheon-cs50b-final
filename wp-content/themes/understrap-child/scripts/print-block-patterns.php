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
 *   • wp-config.php (WordPress configuration, includes debug settings)
 *   • header.php (Theme header template)
 *   • functions.php (How the theme loads block code and other functions)
 *   • ALL .php files in the inc/ directory (including subdirectories)
 *   • ALL .json files in inc/block-types/ (specific block definitions)
 *   • Specific template-parts/ files (e.g., organisms used by blocks)
 *   • ALL .php files in template-parts/atoms/
 *   • ALL .scss files in src/sass/ (including subdirectories)
 *
 * It helps provide a comprehensive picture of your theme's structure,
 * block pattern setup, dynamic rendering, and core styles.
 */

// --- Print the script's own code first ---
$self_path = __FILE__;
echo "/***\n";
echo "Name of file: " . basename($self_path) . "\n";
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

// --- Determine WordPress root ---
// Assuming WordPress root is the parent of the theme root
$wordpress_root = realpath($theme_root . '/..');

// Define common directories/files based on paths
$inc_dir            = $theme_root . '/inc';
$template_parts_dir = $theme_root . '/template-parts';
$atom_dir           = $template_parts_dir . '/atoms';
$organism_dir       = $template_parts_dir . '/organisms';
$src_dir            = $theme_root . '/src';
$sass_dir           = $src_dir . '/sass';
$functions_file     = $theme_root . '/functions.php';
$header_file        = $theme_root . '/header.php'; // Add header.php
$wp_config_file     = $wordpress_root . '/wp-config.php'; // Path to wp-config.php

$files = [];

// --- Helper function to recursively add files with a specific extension ---
/**
 * Recursively scans a directory for files with a specific extension and adds them to an array.
 *
 * @param string $dir The directory to scan.
 * @param string $extension The file extension (e.g., '.php', '.scss').
 * @param array $files_array The array to add file paths to (passed by reference).
 */
function add_files_from_dir_recursive($dir, $extension, &$files_array) {
    if (!is_dir($dir)) {
        return; // Directory doesn't exist
    }

    $items = scandir($dir);
    if ($items === false) {
        // Could add an error message here if needed, but less critical for this script
        return;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue; // Skip parent and current directory entries
        }

        $path = $dir . '/' . $item;

        if (is_dir($path)) {
            // Recurse into subdirectories
            add_files_from_dir_recursive($path, $extension, $files_array);
        } elseif (is_file($path)) {
            // Check if it's a file and ends with the specified extension
            if (substr($item, -strlen($extension)) === $extension) {
                $files_array[] = $path;
            }
        }
    }
}


// --- Add core WordPress/Theme files ---
if (file_exists($wp_config_file)) {
    $files[] = $wp_config_file;
}
if (file_exists($header_file)) { // Add header.php
    $files[] = $header_file;
}
if (file_exists($functions_file)) {
    $files[] = $functions_file;
}


// --- 1) Theme Helper Files (inc/ directory) ---
// Add ALL .php files within the inc/ directory, recursively.
add_files_from_dir_recursive($inc_dir, '.php', $files);


// --- 2) Specific Block Type Files (JSON configuration) ---
// Find block.json (or other .json) files for specific block types.
// This is done separately as it targets a different extension.
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
// This scans non-recursively by default, match the original behavior.
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


// --- 4) Stylesheet Files (src/sass/ directory) ---
// Add ALL .scss files within the src/sass/ directory, recursively.
add_files_from_dir_recursive($sass_dir, '.scss', $files);


// --- Final Processing and Printing ---

// Remove duplicates and ensure order (optional, but makes output predictable)
// Note: $self_path was printed separately at the start. We don't need it in this sorted list.
$files = array_unique($files);
// Remove the script's own path if it somehow got in the list
$files = array_diff($files, [$self_path]);

// Define a custom sort function to prioritize certain files
usort($files, function($a, $b) use ($wordpress_root, $theme_root, $inc_dir, $template_parts_dir, $src_dir) {
    $order = [
        $wordpress_root . '/wp-config.php',
        $theme_root . '/header.php',
        $theme_root . '/functions.php',
        $inc_dir, // Prioritize inc/ files generally
        $template_parts_dir, // Then template-parts/
        $src_dir . '/sass', // Then src/sass/
    ];

    $a_prefix = '';
    $b_prefix = '';

    foreach ($order as $priority_path) {
        if (strpos($a, $priority_path) === 0) {
            $a_prefix = $priority_path;
        }
        if (strpos($b, $priority_path) === 0) {
            $b_prefix = $priority_path;
        }
    }

    // If prefixes are different, sort by prefix order
    if ($a_prefix !== $b_prefix) {
        $a_order = array_search($a_prefix, $order);
        $b_order = array_search($b_prefix, $order);
        // If one doesn't match a priority path, treat it as lower priority
        if ($a_order === false) return 1;
        if ($b_order === false) return -1;
        return $a_order - $b_order;
    }

    // If prefixes are the same or neither match a priority path, sort alphabetically
    return strcmp($a, $b);
});


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
    // Make path relative to theme root for cleaner output (or WP root for wp-config)
    // Use $wordpress_root for wp-config.php to show its location clearly
    if ($path === $wp_config_file) {
         echo "Name of file: " . str_replace($wordpress_root . '/', '', $path) . "\n";
    } else {
         echo "Name of file: " . str_replace($theme_root . '/', '', $path) . "\n";
    }
    echo "***/\n\n";

    // dump contents
    echo file_get_contents($path) . "\n\n";
}

?>