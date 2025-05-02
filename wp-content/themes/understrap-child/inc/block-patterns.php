<?php
/**
 * Register custom block‑pattern categories.
 *
 * @package understrap-child
 */

add_action( 'init', function() {
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
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
    }
}, 9 );
