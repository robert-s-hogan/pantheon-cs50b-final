<?php
/**
 * Molecule: Icon + Text
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/molecule-icon-text',
        [
            'title'      => __( 'Molecule: Icon & Text', 'understrap-child' ),
            'categories' => [ 'understrap-molecule', 'media' ],
            'content'    =>
                '<!-- wp:group {"className":"d-flex align-items-center"} -->' .
                '<div class="wp-block-group d-flex align-items-center">' .
                '  <img src="https://via.placeholder.com/48" class="me-3" />' .
                '  <!-- wp:paragraph -->' .
                '  <p>This is a bit of text beside an icon.</p>' .
                '  <!-- /wp:paragraph -->' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
