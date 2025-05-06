<?php
/**
 * Molecule: Button Group
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/molecule-button-group',
        [
            'title'      => __( 'Molecule: Button Group', 'understrap-child' ),
            'categories' => [ 'understrap-molecule', 'buttons' ],
            'content'    =>
                '<!-- wp:buttons {"className":"btn-group"} -->' .
                '<div class="wp-block-buttons btn-group" role="group">' .
                '  <!-- wp:button {"className":"btn btn-outline-primary"} -->' .
                '  <div class="wp-block-button"><a class="wp-block-button__link btn btn-outline-primary">One</a></div>' .
                '  <!-- /wp:button -->' .
                '  <!-- wp:button {"className":"btn btn-primary"} -->' .
                '  <div class="wp-block-button"><a class="wp-block-button__link btn btn-primary">Two</a></div>' .
                '  <!-- /wp:button -->' .
                '</div>' .
                '<!-- /wp:buttons -->',
        ]
    );
} );
