<?php
/**
 * Atom: Section Title
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/atom-section-title',
        [
            'title'      => esc_html__( 'Atom: Section Title', 'understrap-child' ),
            'categories' => [ 'understrap-atom' ],
            'content'    => '
<!-- wp:heading {"level":2,"className":"section-title"} -->
<h2 class="section-title">Your Section Title</h2>
<!-- /wp:heading -->'
        ]
    );
} );
