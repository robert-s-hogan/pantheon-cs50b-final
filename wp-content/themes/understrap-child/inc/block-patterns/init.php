<?php
/**
 * Theme Name: UnderStrap‑Child
 * Purpose: Auto‑load all block patterns by atomic folder.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    // 1) Register categories
    if ( function_exists( 'register_block_pattern_category' ) ) {
        $cats = [
            'understrap-atom'     => __( 'Atoms',     'understrap-child' ),
            'understrap-molecule' => __( 'Molecules', 'understrap-child' ),
            'understrap-organism' => __( 'Organisms', 'understrap-child' ),
            'understrap-template' => __( 'Templates', 'understrap-child' ),
            'understrap-general'  => __( 'UnderStrap Patterns', 'understrap-child' ),
        ];
        foreach ( $cats as $slug => $label ) {
            register_block_pattern_category( $slug, [ 'label' => $label ] );
        }
    }

    // 2) Auto‑require every pattern file
    $base = get_stylesheet_directory() . '/inc/block-patterns/';
    $types = [ 'atoms', 'molecules', 'organisms', 'templates' ];
    foreach ( $types as $type ) {
        foreach ( glob( "{$base}{$type}/*.php" ) as $file ) {
            require_once $file;
        }
    }
} );
