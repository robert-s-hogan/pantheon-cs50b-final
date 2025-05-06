<?php
/**
 * Atom: Subheading
 */
defined( 'ABSPATH' ) || exit;

register_block_pattern(
    'understrap-atom/subheading',
    [
        'title'      => __( 'Atom: Subheading (H3)', 'understrap-child' ),
        'categories' => [ 'understrap-atom' ],
        'content'    =>
            '<!-- wp:heading {"level":3,"className":"subheading"} -->' .
            '<h3 class="subheading">' .
                esc_html__( 'Subheading Title', 'understrap-child' ) .
            '</h3>' .
            '<!-- /wp:heading -->',
    ]
);
