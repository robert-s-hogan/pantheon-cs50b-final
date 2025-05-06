<?php
/**
 * Atom: Section Title
 */
defined( 'ABSPATH' ) || exit;

register_block_pattern(
    'understrap-atom/section-title',
    [
        'title'      => __( 'Atom: Section Title', 'understrap-child' ),
        'categories' => [ 'understrap-atom' ],
        'content'    =>
            '<!-- wp:heading {"level":2,"className":"section-title"} -->'
          . '<h2 class="section-title">'
          .   esc_html__( 'Section Title', 'understrap-child' )
          . '</h2>'
          . '<!-- /wp:heading -->',
    ]
);
