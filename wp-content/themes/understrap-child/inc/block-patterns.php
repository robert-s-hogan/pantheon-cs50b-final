<?php
/**
 * Register custom block‑pattern categories (and debug pattern files).
 *
 * @package understrap-child
 */

// 1) DEBUG: List out any PHP files in patterns/ at the very start of init.
add_action( 'init', function() {
    $pattern_dir = get_stylesheet_directory() . '/patterns';
    $found = glob( $pattern_dir . '/*.php' );

    if ( false === $found ) {
        error_log( 'DEBUG: glob() failed on ' . $pattern_dir );
    } elseif ( empty( $found ) ) {
        error_log( 'DEBUG: No pattern files found in ' . $pattern_dir );
    } else {
        error_log( 'DEBUG: patterns found: ' . implode( ', ', $found ) );
    }
}, 1 );

// 2) Register your pattern categories before WP loads patterns (priority 9).
add_action( 'init', function() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        error_log( 'DEBUG: register_block_pattern_category() not available.' );
        return;
    }

    $cats = [
        'hero'      => __( 'Hero Sections',      'understrap-child' ),
        'events'    => __( 'Events Sections',    'understrap-child' ),
        'about'     => __( 'About Sections',     'understrap-child' ),
        'volunteer' => __( 'Volunteer Sections', 'understrap-child' ),
        'contact'   => __( 'Contact Sections',   'understrap-child' ),
        'general'   => __( 'General Sections',   'understrap-child' ),
    ];

    foreach ( $cats as $slug => $label ) {
        register_block_pattern_category( $slug, [ 'label' => $label ] );
        error_log( "DEBUG: registered category '{$slug}'" );
    }
}, 9 );
