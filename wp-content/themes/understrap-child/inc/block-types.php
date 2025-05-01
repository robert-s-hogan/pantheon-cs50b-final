<?php
// inc/block-types.php
add_action( 'init', function() {
    register_block_type( __DIR__ . '/block-types/hero-section/block.json' );
  } );

function understrap_child_render_hero_section( $attrs, $content, $block ) { // Added $content, $block as good practice
    // Ensure attributes are an array (should be, but safety first)
    $attrs = (array) $attrs;

    // Extract attributes into variables available in the current scope
    // This will create $background, $title, $buttonText variables from the keys in $attrs
    extract( $attrs );

    // Now include the template directly.
    // Variables like $background, $title, etc. are now defined in this scope
    ob_start(); // Start output buffering to capture the template output
    require get_stylesheet_directory() . '/template-parts/organisms/hero.php'; // Include the template file
    return ob_get_clean(); // Get the buffered output and return it
}