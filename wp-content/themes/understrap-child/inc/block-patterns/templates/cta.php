<?php
/**
 * Template: Call to Action
 */
defined( 'ABSPATH' ) || exit;

add_action( 'init', function() {
    register_block_pattern(
        'understrap/template-cta',
        [
            'title'      => __( 'Template: Call to Action', 'understrap-child' ),
            'categories' => [ 'understrap-template', 'buttons' ],
            'content'    =>
                '<!-- wp:group {"align":"full","className":"cta-section"} -->' .
                '<div class="wp-block-group alignfull cta-section">' .
                    '<!-- wp:heading {"level":2} -->' .
                    '<h2>' . esc_html__( 'Ready to Take the Next Step?', 'understrap-child' ) . '</h2>' .
                    '<!-- /wp:heading -->' .
                    '<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->' .
                    '<div class="wp-block-buttons">' .
                        '<!-- wp:button {"className":"btn btn-light"} -->' .
                        '<div class="wp-block-button"><a class="wp-block-button__link btn btn-light">' . esc_html__( 'Get Started', 'understrap-child' ) . '</a></div>' .
                        '<!-- /wp:button -->' .
                    '</div>' .
                    '<!-- /wp:buttons -->' .
                '</div>' .
                '<!-- /wp:group -->',
        ]
    );
} );
