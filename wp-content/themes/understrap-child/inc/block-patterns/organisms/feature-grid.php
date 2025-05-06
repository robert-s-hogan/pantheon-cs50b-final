<?php
/**
 * Organism: Feature Grid
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/organism-feature-grid',
        [
            'title'      => __( 'Organism: Feature Grid', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'columns' ],
            'content'    =>
                '<!-- wp:columns {"className":"feature-grid"} -->' .
                '<div class="wp-block-columns feature-grid">' .
                '  <!-- wp:column -->' .
                '  <div class="wp-block-column">' .
                '    <h4>Feature One</h4>' .
                '    <p>Short description of feature one.</p>' .
                '  </div>' .
                '  <!-- /wp:column -->' .
                '  <!-- wp:column -->' .
                '  <div class="wp-block-column">' .
                '    <h4>Feature Two</h4>' .
                '    <p>Short description of feature two.</p>' .
                '  </div>' .
                '  <!-- /wp:column -->' .
                '  <!-- wp:column -->' .
                '  <div class="wp-block-column">' .
                '    <h4>Feature Three</h4>' .
                '    <p>Short description of feature three.</p>' .
                '  </div>' .
                '  <!-- /wp:column -->' .
                '</div>' .
                '<!-- /wp:columns -->',
        ]
    );
} );
