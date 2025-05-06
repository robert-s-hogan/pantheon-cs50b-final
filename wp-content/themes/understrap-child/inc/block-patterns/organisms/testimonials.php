<?php
/**
 * Organism: Testimonials
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/organism-testimonials',
        [
            'title'      => __( 'Organism: Testimonial', 'understrap-child' ),
            'categories' => [ 'understrap-organism', 'quotes' ],
            'content'    =>
                '<!-- wp:quote {"className":"testimonials"} -->' .
                '<blockquote class="wp-block-quote testimonials">' .
                '  <p>This product changed my life!</p>' .
                '  <cite>— Happy Customer</cite>' .
                '</blockquote>' .
                '<!-- /wp:quote -->',
        ]
    );
} );
