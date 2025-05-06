<?php
/**
 * Molecule: Info Card
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/molecule-info-card',
        [
            'title'      => __( 'Molecule: Info Card', 'understrap-child' ),
            'categories' => [ 'understrap-molecule', 'cards' ],
            'content'    =>
                '<!-- wp:group {"className":"info-card"} -->' .
                '<div class="wp-block-group info-card">' .
                '  <!-- wp:image /-->' .
                '  <!-- wp:heading {"level":3} -->' .
                '  <h3>Card Title</h3>' .
                '  <!-- /wp:heading -->' .
                '  <!-- wp:paragraph -->' .
                '  <p>Short description or summary.</p>' .
                '  <!-- /wp:paragraph -->' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
